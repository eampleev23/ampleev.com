(function () {
    var root = document.querySelector('[data-economy-sim-root]');
    if (!root) return;

    var defaultConfig = {
        consumersCount: 1,
        treesCount: 3,
        initialApplesPerTree: 24,
        applesPerTreePerCycle: 40,
        growthCycleDays: 7,
        consumerStartMoney: 5000,
        consumerDailyIncome: 1200,
        farmerStartCapital: 15000,
        applePricePerKg: 180,
        appleWeightGrams: 180,
        kcalPerApple: 95,
        dailyCaloriesNeed: 2000,
        starvationDaysLimit: 35,
        dayIncomeHour: 8,
        stepHours: 1
    };

    var speedOptions = [1, 5, 20, 100];

    function createTrees(config) {
        var spacing = config.treesCount > 1 ? 20 / (config.treesCount - 1) : 0;
        return Array.from({ length: config.treesCount }, function (_, index) {
            return {
                id: 'tree-' + (index + 1),
                x: 16 + spacing * index,
                y: 24 + (index % 2) * 9,
                applesReady: config.initialApplesPerTree,
                hoursUntilNextHarvest: config.growthCycleDays * 24
            };
        });
    }

    function createConsumers(config) {
        return Array.from({ length: config.consumersCount }, function (_, index) {
            return {
                id: 'consumer-' + (index + 1),
                name: 'Потребитель ' + (index + 1),
                x: 83,
                y: 22 + index * 18,
                homeX: 83,
                homeY: 22 + index * 18,
                state: 'idle_home',
                targetX: 83,
                targetY: 22 + index * 18,
                money: config.consumerStartMoney,
                caloriesToday: 0,
                reserveDaysLeft: config.starvationDaysLimit,
                alive: true,
                purchasesToday: 0,
                failedAttempts: 0
            };
        });
    }

    function createInitialState(config) {
        return {
            clock: { totalHours: 0, day: 1, hour: 0 },
            runtime: { running: false, speed: 1, tickDurationMs: 600 },
            farmer: {
                id: 'farmer-1',
                name: 'Фермер',
                x: 50,
                y: 55,
                targetX: 50,
                targetY: 55,
                state: 'idle_market',
                capital: config.farmerStartCapital,
                carriedApples: 0,
                targetTreeId: null,
                harvestingHoursLeft: 0
            },
            market: {
                x: 50,
                y: 55,
                apples: 0,
                soldToday: 0,
                failedDemandToday: 0
            },
            trees: createTrees(config),
            consumers: createConsumers(config),
            eventLog: [{
                id: 'boot-' + Date.now(),
                timeLabel: 'День 1, 00:00',
                text: 'Симуляция подготовлена. Можно запускать.',
                type: 'system'
            }],
            metrics: {
                labels: [],
                applesOnTrees: [],
                marketApples: [],
                farmerCapital: [],
                avgConsumerMoney: [],
                avgReserveDays: [],
                aliveConsumers: []
            }
        };
    }

    function cloneState(state) {
        return {
            clock: Object.assign({}, state.clock),
            runtime: Object.assign({}, state.runtime),
            farmer: Object.assign({}, state.farmer),
            market: Object.assign({}, state.market),
            trees: state.trees.map(function (tree) { return Object.assign({}, tree); }),
            consumers: state.consumers.map(function (consumer) { return Object.assign({}, consumer); }),
            eventLog: state.eventLog.slice(),
            metrics: {
                labels: state.metrics.labels.slice(),
                applesOnTrees: (state.metrics.applesOnTrees || []).slice(),
                marketApples: state.metrics.marketApples.slice(),
                farmerCapital: state.metrics.farmerCapital.slice(),
                avgConsumerMoney: state.metrics.avgConsumerMoney.slice(),
                avgReserveDays: state.metrics.avgReserveDays.slice(),
                aliveConsumers: state.metrics.aliveConsumers.slice()
            }
        };
    }

    function formatHour(hour) {
        return String(hour).padStart(2, '0');
    }

    function getTimeLabel(clock) {
        return 'День ' + clock.day + ', ' + formatHour(clock.hour) + ':00';
    }

    function addEvent(state, text, type) {
        state.eventLog.unshift({
            id: Date.now() + '-' + Math.random().toString(36).slice(2, 8),
            timeLabel: getTimeLabel(state.clock),
            text: text,
            type: type || 'info'
        });

        if (state.eventLog.length > 80) {
            state.eventLog = state.eventLog.slice(0, 80);
        }
    }

    function getApplePricePerUnit(config) {
        return Number(((config.applePricePerKg * config.appleWeightGrams) / 1000).toFixed(2));
    }

    function moveEntity(entity, destination, speed) {
        var dx = destination.x - entity.x;
        var dy = destination.y - entity.y;
        var distance = Math.sqrt(dx * dx + dy * dy);
        var velocity = speed || 8;

        entity.targetX = destination.x;
        entity.targetY = destination.y;

        if (distance <= velocity) {
            entity.x = destination.x;
            entity.y = destination.y;
            return true;
        }

        entity.x += (dx / distance) * velocity;
        entity.y += (dy / distance) * velocity;
        return false;
    }

    function treeTarget(tree) {
        return { x: tree.x, y: tree.y + 8 };
    }

    function collectMetrics(state) {
        var aliveConsumers = state.consumers.filter(function (consumer) { return consumer.alive; });
        var avgMoney = aliveConsumers.length
            ? aliveConsumers.reduce(function (sum, consumer) { return sum + consumer.money; }, 0) / aliveConsumers.length
            : 0;
        var avgReserve = aliveConsumers.length
            ? aliveConsumers.reduce(function (sum, consumer) { return sum + consumer.reserveDaysLeft; }, 0) / aliveConsumers.length
            : 0;
        var applesOnTrees = state.trees.reduce(function (sum, tree) { return sum + tree.applesReady; }, 0);

        state.metrics.labels.push('D' + state.clock.day + ' H' + formatHour(state.clock.hour));
        state.metrics.applesOnTrees.push(applesOnTrees);
        state.metrics.marketApples.push(state.market.apples);
        state.metrics.farmerCapital.push(Math.round(state.farmer.capital));
        state.metrics.avgConsumerMoney.push(Math.round(avgMoney));
        state.metrics.avgReserveDays.push(Number(avgReserve.toFixed(2)));
        state.metrics.aliveConsumers.push(aliveConsumers.length);

        var maxPoints = 120;
        Object.keys(state.metrics).forEach(function (key) {
            if (state.metrics[key].length > maxPoints) {
                state.metrics[key] = state.metrics[key].slice(-maxPoints);
            }
        });
    }

    function resetDailyCounters(state) {
        state.market.soldToday = 0;
        state.market.failedDemandToday = 0;
        state.consumers.forEach(function (consumer) {
            consumer.caloriesToday = 0;
            consumer.purchasesToday = 0;
            consumer.failedAttempts = 0;
        });
    }

    function settlePreviousDay(state, config) {
        state.consumers.forEach(function (consumer) {
            if (!consumer.alive) return;

            var ratio = Math.min(1, consumer.caloriesToday / config.dailyCaloriesNeed);
            if (ratio >= 1) {
                consumer.reserveDaysLeft = Math.min(config.starvationDaysLimit, consumer.reserveDaysLeft + 0.15);
                return;
            }

            consumer.reserveDaysLeft -= (1 - ratio);
            if (consumer.reserveDaysLeft <= 0) {
                consumer.alive = false;
                consumer.state = 'dead';
                consumer.targetX = consumer.x;
                consumer.targetY = consumer.y;
                addEvent(state, consumer.name + ' умер от голода.', 'danger');
            }
        });
    }

    function maybeAdvanceTrees(state, config) {
        state.trees.forEach(function (tree) {
            if (tree.applesReady > 0) return;
            tree.hoursUntilNextHarvest -= config.stepHours;
            if (tree.hoursUntilNextHarvest <= 0) {
                tree.applesReady = config.applesPerTreePerCycle;
                tree.hoursUntilNextHarvest = config.growthCycleDays * 24;
                addEvent(state, 'На дереве созрел урожай: ' + tree.applesReady + ' яблок.', 'success');
            }
        });
    }

    function maybePayIncome(state, config) {
        if (state.clock.hour !== config.dayIncomeHour) return;
        state.consumers.forEach(function (consumer) {
            if (!consumer.alive) return;
            consumer.money += config.consumerDailyIncome;
            addEvent(state, consumer.name + ' получил доход: ' + config.consumerDailyIncome + ' ₽.', 'income');
        });
    }

    function updateFarmer(state) {
        var farmer = state.farmer;
        var ripeTree = state.trees.find(function (tree) { return tree.applesReady > 0; });

        if (farmer.state === 'idle_market') {
            if (ripeTree) {
                farmer.state = 'go_to_tree';
                farmer.targetTreeId = ripeTree.id;
            }
            return;
        }

        if (farmer.state === 'go_to_tree') {
            var tree = state.trees.find(function (item) { return item.id === farmer.targetTreeId; });
            if (!tree || tree.applesReady <= 0) {
                farmer.state = 'idle_market';
                farmer.targetTreeId = null;
                return;
            }

            var arrivedAtTree = moveEntity(farmer, treeTarget(tree));
            if (arrivedAtTree) {
                farmer.state = 'harvesting';
                farmer.harvestingHoursLeft = 2;
                addEvent(state, 'Фермер начал сбор яблок у ' + tree.id + '.', 'harvest');
            }
            return;
        }

        if (farmer.state === 'harvesting') {
            var harvestTree = state.trees.find(function (item) { return item.id === farmer.targetTreeId; });
            farmer.harvestingHoursLeft -= 1;
            if (farmer.harvestingHoursLeft <= 0 && harvestTree) {
                farmer.carriedApples += harvestTree.applesReady;
                addEvent(state, 'Фермер собрал ' + harvestTree.applesReady + ' яблок и несёт их на рынок.', 'harvest');
                harvestTree.applesReady = 0;
                farmer.state = 'go_to_market';
            }
            return;
        }

        if (farmer.state === 'go_to_market') {
            var arrivedAtMarket = moveEntity(farmer, { x: state.market.x, y: state.market.y });
            if (arrivedAtMarket) {
                state.market.apples += farmer.carriedApples;
                addEvent(state, 'Фермер доставил на рынок ' + farmer.carriedApples + ' яблок.', 'market');
                farmer.carriedApples = 0;
                farmer.targetTreeId = null;
                farmer.state = 'idle_market';
            }
        }
    }

    function updateConsumers(state, config) {
        var pricePerApple = getApplePricePerUnit(config);

        state.consumers.forEach(function (consumer) {
            if (!consumer.alive) return;

            if (consumer.state === 'idle_home') {
                var hungry = consumer.caloriesToday < config.dailyCaloriesNeed;
                var canAfford = consumer.money >= pricePerApple;
                if (hungry && canAfford) {
                    consumer.state = 'go_to_market';
                }
                return;
            }

            if (consumer.state === 'go_to_market') {
                var arrivedAtMarket = moveEntity(consumer, { x: state.market.x + 6, y: state.market.y + 10 });
                if (arrivedAtMarket) {
                    consumer.state = 'buying';
                }
                return;
            }

            if (consumer.state === 'buying') {
                var stillHungry = consumer.caloriesToday < config.dailyCaloriesNeed;
                if (!stillHungry) {
                    consumer.state = 'return_home';
                    return;
                }

                if (state.market.apples > 0 && consumer.money >= pricePerApple) {
                    state.market.apples -= 1;
                    state.market.soldToday += 1;
                    state.farmer.capital += pricePerApple;
                    consumer.money -= pricePerApple;
                    consumer.caloriesToday += config.kcalPerApple;
                    consumer.purchasesToday += 1;
                    addEvent(state, consumer.name + ' купил яблоко за ' + pricePerApple.toFixed(2) + ' ₽.', 'purchase');
                    consumer.state = 'return_home';
                } else {
                    state.market.failedDemandToday += 1;
                    consumer.failedAttempts += 1;
                    addEvent(state, consumer.name + ' не смог купить яблоко: на рынке пусто или не хватает денег.', 'warning');
                    consumer.state = 'return_home';
                }
                return;
            }

            if (consumer.state === 'return_home') {
                var arrivedHome = moveEntity(consumer, { x: consumer.homeX, y: consumer.homeY });
                if (arrivedHome) {
                    consumer.state = 'idle_home';
                }
            }
        });
    }

    function advanceClock(state, config) {
        var wasMidnight = state.clock.hour === 0 && state.clock.totalHours > 0;
        if (wasMidnight) {
            settlePreviousDay(state, config);
            resetDailyCounters(state);
        }

        state.clock.totalHours += config.stepHours;
        state.clock.day = Math.floor(state.clock.totalHours / 24) + 1;
        state.clock.hour = state.clock.totalHours % 24;
    }

    function tickSimulation(previousState, config) {
        var state = cloneState(previousState);
        advanceClock(state, config);
        maybeAdvanceTrees(state, config);
        maybePayIncome(state, config);
        updateFarmer(state);
        updateConsumers(state, config);
        collectMetrics(state);
        return state;
    }

    function createApp(rootEl) {
        var state = {
            config: Object.assign({}, defaultConfig),
            pendingConfig: Object.assign({}, defaultConfig),
            sim: createInitialState(defaultConfig),
            timerId: null
        };

        function tickDurationForSpeed(speed) {
            var base = 650;
            return Math.max(45, Math.floor(base / speed));
        }

        function updateRuntimeSpeed(speed) {
            state.sim.runtime.speed = speed;
            state.sim.runtime.tickDurationMs = tickDurationForSpeed(speed);
        }

        function startLoop() {
            stopLoop();
            state.sim.runtime.running = true;
            state.timerId = window.setInterval(step, state.sim.runtime.tickDurationMs);
        }

        function stopLoop() {
            if (state.timerId) {
                window.clearInterval(state.timerId);
                state.timerId = null;
            }
            state.sim.runtime.running = false;
        }

        function restartLoopIfNeeded() {
            if (!state.sim.runtime.running) return;
            startLoop();
        }

        function resetSimulation() {
            stopLoop();
            state.config = Object.assign({}, state.pendingConfig);
            state.sim = createInitialState(state.config);
            updateRuntimeSpeed(1);
            render();
        }

        function step() {
            state.sim = tickSimulation(state.sim, state.config);
            render();
        }

        function setSpeed(speed) {
            updateRuntimeSpeed(speed);
            restartLoopIfNeeded();
            render();
        }

        function syncDerivedPreview() {
            var pricePreview = rootEl.querySelector('[data-price-preview]');
            if (pricePreview) {
                pricePreview.textContent = getApplePricePerUnit(state.pendingConfig).toFixed(2) + ' ₽ за яблоко';
            }
            var appleNeedPreview = rootEl.querySelector('[data-apple-need-preview]');
            if (appleNeedPreview) {
                appleNeedPreview.textContent = Math.ceil(state.pendingConfig.dailyCaloriesNeed / state.pendingConfig.kcalPerApple) + ' яблок/день';
            }
        }

        function escapeAttr(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        }

        function sparkline(values, color, label) {
            if (!values.length) return '';
            var width = 220;
            var height = 70;
            var min = Math.min.apply(null, values);
            var max = Math.max.apply(null, values);
            var range = max - min || 1;
            var points = values.map(function (value, index) {
                var x = (index / Math.max(values.length - 1, 1)) * width;
                var y = height - ((value - min) / range) * (height - 8) - 4;
                return x + ',' + y;
            }).join(' ');

            return '<svg viewBox="0 0 ' + width + ' ' + height + '" class="economy-chart" role="img" aria-label="' + escapeAttr(label) + '" focusable="false"><polyline fill="none" stroke="' + color + '" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" points="' + points + '"></polyline></svg>';
        }

        function renderTrees() {
            return state.sim.trees.map(function (tree) {
                var apples = Math.min(tree.applesReady, 8);
                var appleDots = Array.from({ length: apples }, function (_, index) {
                    var angle = (Math.PI * 2 * index) / Math.max(apples, 1);
                    var x = 50 + Math.cos(angle) * 18;
                    var y = 30 + Math.sin(angle) * 14;
                    return '<span class="economy-apple-dot" style="left:' + x + '%;top:' + y + '%"></span>';
                }).join('');

                return '<div class="economy-tree" style="left:' + tree.x + '%;top:' + tree.y + '%;"><div class="economy-tree-crown">' + appleDots + '</div><div class="economy-tree-trunk"></div><div class="economy-tree-label"><strong>' + tree.applesReady + ' ябл.</strong><span>до урожая: ' + Math.ceil(tree.hoursUntilNextHarvest / 24) + ' дн.</span></div></div>';
            }).join('');
        }

        function consumerStateLabel(consumer) {
            var labels = {
                idle_home: 'Дома',
                go_to_market: 'Идёт на рынок',
                buying: 'Покупает',
                return_home: 'Возвращается домой',
                dead: 'Мёртв'
            };

            if (!consumer.alive) {
                return labels.dead;
            }

            return labels[consumer.state] || consumer.state;
        }

        function renderConsumers() {
            return state.sim.consumers.map(function (consumer) {
                var reservePct = Math.max(0, Math.min(100, (consumer.reserveDaysLeft / state.config.starvationDaysLimit) * 100));
                return '<div class="economy-agent economy-agent-consumer ' + (consumer.alive ? '' : 'is-dead') + '" style="left:' + consumer.x + '%;top:' + consumer.y + '%;"><div class="economy-agent-body">' + (consumer.alive ? '🙂' : '✖') + '</div><div class="economy-agent-card"><strong>' + consumer.name + '</strong><span>' + consumerStateLabel(consumer) + '</span><span>' + consumer.money.toFixed(0) + ' ₽</span><span>' + consumer.caloriesToday + '/' + state.config.dailyCaloriesNeed + ' ккал</span><span>Ресурс: ' + consumer.reserveDaysLeft.toFixed(1) + ' дн.</span><div class="economy-bar"><i style="width:' + reservePct + '%"></i></div></div></div>';
            }).join('');
        }

        function farmerStateLabel(value) {
            var labels = {
                idle_market: 'На рынке',
                go_to_tree: 'Идёт к дереву',
                harvesting: 'Собирает урожай',
                go_to_market: 'Несёт на рынок'
            };
            return labels[value] || value;
        }

        function renderFarmer() {
            return '<div class="economy-agent economy-agent-farmer" style="left:' + state.sim.farmer.x + '%;top:' + state.sim.farmer.y + '%;"><div class="economy-agent-body">🧑‍🌾</div><div class="economy-agent-card"><strong>Фермер</strong><span>' + state.sim.farmer.capital.toFixed(0) + ' ₽</span><span>Несёт: ' + state.sim.farmer.carriedApples + ' ябл.</span><span>' + farmerStateLabel(state.sim.farmer.state) + '</span></div></div>';
        }

        function renderMetrics() {
            var aliveConsumers = state.sim.consumers.filter(function (consumer) { return consumer.alive; });
            var alive = aliveConsumers.length;
            var avgMoney = alive ? aliveConsumers.reduce(function (sum, consumer) { return sum + consumer.money; }, 0) / alive : 0;
            var avgReserve = alive ? aliveConsumers.reduce(function (sum, consumer) { return sum + consumer.reserveDaysLeft; }, 0) / alive : 0;
            var applesOnTrees = state.sim.trees.reduce(function (sum, tree) { return sum + tree.applesReady; }, 0);

            return '<div class="economy-side-grid">' +
                '<div class="economy-kpi"><span>Живые / умершие</span><strong>' + alive + ' / ' + (state.sim.consumers.length - alive) + '</strong></div>' +
                '<div class="economy-kpi"><span>Яблок на деревьях</span><strong>' + applesOnTrees + '</strong></div>' +
                '<div class="economy-kpi"><span>Яблок на рынке</span><strong>' + state.sim.market.apples + '</strong></div>' +
                '<div class="economy-kpi"><span>Капитал фермера</span><strong>' + state.sim.farmer.capital.toFixed(0) + ' ₽</strong></div>' +
                '<div class="economy-kpi"><span>Средние деньги потребителей</span><strong>' + avgMoney.toFixed(0) + ' ₽</strong></div>' +
                '<div class="economy-kpi"><span>Средний запас выживания</span><strong>' + avgReserve.toFixed(1) + ' дн.</strong></div>' +
                '<div class="economy-kpi"><span>Цена яблока</span><strong>' + getApplePricePerUnit(state.config).toFixed(2) + ' ₽</strong></div>' +
                '</div>' +
                '<div class="economy-chart-card"><h6>Яблоки на деревьях</h6>' + sparkline(state.sim.metrics.applesOnTrees || [], '#22c55e', 'Динамика количества яблок на деревьях') + '</div>' +
                '<div class="economy-chart-card"><h6>Яблоки на рынке</h6>' + sparkline(state.sim.metrics.marketApples, '#3f5bd8', 'Динамика количества яблок на рынке') + '</div>' +
                '<div class="economy-chart-card"><h6>Капитал фермера</h6>' + sparkline(state.sim.metrics.farmerCapital, '#11a36a', 'Динамика капитала фермера') + '</div>' +
                '<div class="economy-chart-card"><h6>Запас выживания потребителей</h6>' + sparkline(state.sim.metrics.avgReserveDays, '#f59e0b', 'Динамика среднего запаса выживания потребителей') + '</div>';
        }

        function renderConfigInput(label, key, min, max, step) {
            var actualStep = step || 1;
            return '<label class="economy-config-field"><span>' + label + '</span><input type="number" min="' + min + '" max="' + max + '" step="' + actualStep + '" value="' + state.pendingConfig[key] + '" inputmode="decimal" data-config-key="' + key + '"></label>';
        }

        function render() {
            var pricePerApple = getApplePricePerUnit(state.config);
            var activeConfigKey = document.activeElement && document.activeElement.getAttribute('data-config-key');
            var activeSelectionStart = null;
            var activeSelectionEnd = null;

            if (activeConfigKey && document.activeElement.setSelectionRange) {
                try {
                    activeSelectionStart = document.activeElement.selectionStart;
                    activeSelectionEnd = document.activeElement.selectionEnd;
                } catch (error) {
                    activeSelectionStart = null;
                    activeSelectionEnd = null;
                }
            }

            rootEl.innerHTML =
                '<div class="economy-sim-layout">' +
                    '<aside class="economy-panel economy-left-panel">' +
                        '<div class="economy-panel-card">' +
                            '<h4>Управление</h4>' +
                            '<div class="economy-control-row">' +
                                '<button class="btn btn-primary btn-sm" data-action="start" aria-pressed="' + (state.sim.runtime.running ? 'true' : 'false') + '">Старт</button>' +
                                '<button class="btn btn-outline-primary btn-sm" data-action="pause" aria-pressed="' + (!state.sim.runtime.running ? 'true' : 'false') + '">Пауза</button>' +
                                '<button class="btn btn-outline-primary btn-sm" data-action="step">Шаг</button>' +
                                '<button class="btn btn-outline-secondary btn-sm" data-action="reset">Сброс</button>' +
                            '</div>' +
                            '<div class="economy-speed-row">' +
                                speedOptions.map(function (speed) {
                                    return '<button class="btn btn-sm ' + (state.sim.runtime.speed === speed ? 'btn-primary' : 'btn-outline-primary') + '" data-speed="' + speed + '" aria-pressed="' + (state.sim.runtime.speed === speed ? 'true' : 'false') + '">' + speed + 'x</button>';
                                }).join('') +
                            '</div>' +
                            '<div class="economy-runtime-state" aria-live="polite">' +
                                '<span class="badge ' + (state.sim.runtime.running ? 'badge-success' : 'badge-secondary') + '">' + (state.sim.runtime.running ? 'Симуляция идёт' : 'Пауза') + '</span>' +
                                '<span>День ' + state.sim.clock.day + ', ' + formatHour(state.sim.clock.hour) + ':00</span>' +
                            '</div>' +
                        '</div>' +
                        '<form class="economy-panel-card" data-config-form>' +
                            '<h4>Параметры</h4>' +
                            renderConfigInput('Потребители', 'consumersCount', 1, 3) +
                            renderConfigInput('Деревья', 'treesCount', 1, 8) +
                            renderConfigInput('Яблок на дереве в начале', 'initialApplesPerTree', 0, 200) +
                            renderConfigInput('Яблок на дерево за цикл', 'applesPerTreePerCycle', 1, 200) +
                            renderConfigInput('Цикл созревания (дни)', 'growthCycleDays', 1, 30) +
                            renderConfigInput('Стартовые деньги потребителя, ₽', 'consumerStartMoney', 0, 100000) +
                            renderConfigInput('Доход потребителя в день, ₽', 'consumerDailyIncome', 0, 100000) +
                            renderConfigInput('Стартовый капитал фермера, ₽', 'farmerStartCapital', 0, 1000000) +
                            renderConfigInput('Цена яблок, ₽/кг', 'applePricePerKg', 1, 10000) +
                            renderConfigInput('Вес яблока, г', 'appleWeightGrams', 50, 500) +
                            renderConfigInput('Ккал в яблоке', 'kcalPerApple', 20, 300) +
                            renderConfigInput('Суточная потребность, ккал', 'dailyCaloriesNeed', 500, 5000) +
                            renderConfigInput('Предел голодания, дней', 'starvationDaysLimit', 1, 90) +
                            '<div class="economy-config-note"><div><strong>Текущая цена:</strong> <span data-price-preview>' + getApplePricePerUnit(state.pendingConfig).toFixed(2) + ' ₽ за яблоко</span></div><div><strong>Норма:</strong> <span data-apple-need-preview>' + Math.ceil(state.pendingConfig.dailyCaloriesNeed / state.pendingConfig.kcalPerApple) + ' яблок/день</span></div></div>' +
                            '<button type="submit" class="btn btn-primary btn-block mt-3">Применить и перезапустить</button>' +
                        '</form>' +
                    '</aside>' +
                    '<div class="economy-center-panel" role="region" aria-label="Сцена симуляции экономики">' +
                        '<div class="economy-scene-card">' +
                            '<div class="economy-scene" role="img" aria-label="Сад, рынок, дома потребителей и перемещение агентов">' +
                                '<div class="economy-zone economy-zone-orchard"><div class="economy-zone-label">Сад</div></div>' +
                                '<div class="economy-zone economy-zone-market"><div class="economy-zone-label">Рынок</div><div class="economy-market-stock">' + '🍎'.repeat(Math.min(state.sim.market.apples, 20)) + '<strong>' + state.sim.market.apples + '</strong></div></div>' +
                                '<div class="economy-zone economy-zone-homes"><div class="economy-zone-label">Дома потребителей</div></div>' +
                                renderTrees() +
                                renderFarmer() +
                                renderConsumers() +
                            '</div>' +
                        '</div>' +
                        '<div class="economy-log-card">' +
                            '<div class="d-flex justify-content-between align-items-center mb-2"><h5 class="mb-0">Лог событий</h5><span class="text-small text-muted">Продажа: ' + state.sim.market.soldToday + ' ябл./день · Нехватка: ' + state.sim.market.failedDemandToday + ' · Цена: ' + pricePerApple.toFixed(2) + ' ₽</span></div>' +
                            '<div class="economy-log-list" role="log" aria-live="polite" aria-relevant="additions text">' +
                                state.sim.eventLog.map(function (entry) {
                                    return '<div class="economy-log-item is-' + entry.type + '"><span class="economy-log-time">' + entry.timeLabel + '</span><span>' + entry.text + '</span></div>';
                                }).join('') +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<aside class="economy-panel economy-right-panel"><div class="economy-panel-card"><h4>Состояние системы</h4>' + renderMetrics() + '</div></aside>' +
                '</div>';

            syncDerivedPreview();
            if (activeConfigKey) {
                var nextActive = rootEl.querySelector('[data-config-key="' + activeConfigKey + '"]');
                if (nextActive) {
                    nextActive.focus({ preventScroll: true });
                    if (activeSelectionStart !== null && nextActive.setSelectionRange) {
                        try {
                            nextActive.setSelectionRange(activeSelectionStart, activeSelectionEnd);
                        } catch (error) {
                            // Number inputs may reject selection restoration in some browsers.
                        }
                    }
                }
            }
        }

        function bindEvents() {
            rootEl.addEventListener('click', function (event) {
                var button = event.target.closest('[data-action],[data-speed]');
                if (!button) return;

                var action = button.getAttribute('data-action');
                if (action === 'start') startLoop();
                if (action === 'pause') stopLoop();
                if (action === 'step') step();
                if (action === 'reset') resetSimulation();

                var speed = button.getAttribute('data-speed');
                if (speed) setSpeed(Number(speed));

                render();
            });

            rootEl.addEventListener('input', function (event) {
                var input = event.target.closest('[data-config-key]');
                if (!input) return;
                var key = input.getAttribute('data-config-key');
                var value = Number(input.value);
                state.pendingConfig[key] = Number.isFinite(value) ? value : input.value;
                syncDerivedPreview();
            });

            rootEl.addEventListener('submit', function (event) {
                if (!event.target.matches('[data-config-form]')) return;
                event.preventDefault();
                resetSimulation();
                startLoop();
            });
        }

        return {
            init: function () {
                updateRuntimeSpeed(1);
                bindEvents();
                render();
            }
        };
    }

    createApp(root).init();
})();
