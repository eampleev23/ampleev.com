function cloneState(state) {
    return {
        ...state,
        clock: { ...state.clock },
        runtime: { ...state.runtime },
        scene: { ...state.scene },
        farmer: { ...state.farmer },
        market: { ...state.market },
        trees: state.trees.map((tree) => ({ ...tree })),
        consumers: state.consumers.map((consumer) => ({ ...consumer })),
        eventLog: [...state.eventLog],
        metrics: {
            labels: [...state.metrics.labels],
            marketApples: [...state.metrics.marketApples],
            farmerCapital: [...state.metrics.farmerCapital],
            avgConsumerMoney: [...state.metrics.avgConsumerMoney],
            avgReserveDays: [...state.metrics.avgReserveDays],
            aliveConsumers: [...state.metrics.aliveConsumers],
        },
    };
}

function formatHour(hour) {
    return String(hour).padStart(2, '0');
}

function timeLabel(clock) {
    return `День ${clock.day}, ${formatHour(clock.hour)}:00`;
}

function addEvent(state, text, type = 'info') {
    state.eventLog.unshift({
        id: `${Date.now()}-${Math.random().toString(36).slice(2, 8)}`,
        timeLabel: timeLabel(state.clock),
        text,
        type,
    });

    if (state.eventLog.length > 80) {
        state.eventLog = state.eventLog.slice(0, 80);
    }
}

function applePricePerUnit(config) {
    return Number(((config.applePricePerKg * config.appleWeightGrams) / 1000).toFixed(2));
}

function treeTarget(tree) {
    return { x: tree.x, y: tree.y + 8 };
}

function moveEntity(entity, destination, speed = 8) {
    const dx = destination.x - entity.x;
    const dy = destination.y - entity.y;
    const distance = Math.sqrt(dx * dx + dy * dy);

    entity.targetX = destination.x;
    entity.targetY = destination.y;

    if (distance <= speed) {
        entity.x = destination.x;
        entity.y = destination.y;
        return true;
    }

    entity.x += (dx / distance) * speed;
    entity.y += (dy / distance) * speed;
    return false;
}

function collectMetrics(state) {
    const aliveConsumers = state.consumers.filter((consumer) => consumer.alive);
    const applesOnTrees = state.trees.reduce((sum, tree) => sum + tree.applesReady, 0);
    const avgMoney = aliveConsumers.length
        ? aliveConsumers.reduce((sum, consumer) => sum + consumer.money, 0) / aliveConsumers.length
        : 0;
    const avgReserve = aliveConsumers.length
        ? aliveConsumers.reduce((sum, consumer) => sum + consumer.reserveDaysLeft, 0) / aliveConsumers.length
        : 0;

    state.metrics.labels.push(`D${state.clock.day} H${formatHour(state.clock.hour)}`);
    state.metrics.marketApples.push(state.market.apples);
    state.metrics.farmerCapital.push(Math.round(state.farmer.capital));
    state.metrics.avgConsumerMoney.push(Math.round(avgMoney));
    state.metrics.avgReserveDays.push(Number(avgReserve.toFixed(2)));
    state.metrics.aliveConsumers.push(aliveConsumers.length);
    state.metrics.applesOnTrees = state.metrics.applesOnTrees || [];
    state.metrics.applesOnTrees.push(applesOnTrees);

    const maxPoints = 120;
    Object.keys(state.metrics).forEach((key) => {
        if (state.metrics[key].length > maxPoints) {
            state.metrics[key] = state.metrics[key].slice(-maxPoints);
        }
    });
}

function resetDailyCounters(state) {
    state.market.soldToday = 0;
    state.market.failedDemandToday = 0;
    state.consumers.forEach((consumer) => {
        consumer.caloriesToday = 0;
        consumer.purchasesToday = 0;
        consumer.failedAttempts = 0;
    });
}

function settlePreviousDay(state, config) {
    state.consumers.forEach((consumer) => {
        if (!consumer.alive) {
            return;
        }

        const ratio = Math.min(1, consumer.caloriesToday / config.dailyCaloriesNeed);
        if (ratio >= 1) {
            consumer.reserveDaysLeft = Math.min(
                config.starvationDaysLimit,
                consumer.reserveDaysLeft + 0.15
            );
            return;
        }

        consumer.reserveDaysLeft -= (1 - ratio);
        if (consumer.reserveDaysLeft <= 0) {
            consumer.alive = false;
            consumer.state = 'dead';
            consumer.targetX = consumer.x;
            consumer.targetY = consumer.y;
            addEvent(state, `${consumer.name} умер от голода.`, 'danger');
        }
    });
}

function maybeAdvanceTrees(state, config) {
    state.trees.forEach((tree) => {
        if (tree.applesReady > 0) {
            return;
        }

        tree.hoursUntilNextHarvest -= config.stepHours;
        if (tree.hoursUntilNextHarvest <= 0) {
            tree.applesReady = config.applesPerTreePerCycle;
            tree.hoursUntilNextHarvest = config.growthCycleDays * 24;
            addEvent(state, `На дереве созрел урожай: ${tree.applesReady} яблок.`, 'success');
        }
    });
}

function maybePayIncome(state, config) {
    if (state.clock.hour !== config.dayIncomeHour) {
        return;
    }

    state.consumers.forEach((consumer) => {
        if (!consumer.alive) {
            return;
        }

        consumer.money += config.consumerDailyIncome;
        addEvent(state, `${consumer.name} получил доход: ${config.consumerDailyIncome} ₽.`, 'income');
    });
}

function updateFarmer(state) {
    const farmer = state.farmer;
    const ripeTree = state.trees.find((tree) => tree.applesReady > 0);

    if (farmer.state === 'idle_market') {
        if (ripeTree) {
            farmer.state = 'go_to_tree';
            farmer.targetTreeId = ripeTree.id;
        }
        return;
    }

    if (farmer.state === 'go_to_tree') {
        const tree = state.trees.find((item) => item.id === farmer.targetTreeId);
        if (!tree || tree.applesReady <= 0) {
            farmer.state = 'idle_market';
            farmer.targetTreeId = null;
            return;
        }

        const arrived = moveEntity(farmer, treeTarget(tree));
        if (arrived) {
            farmer.state = 'harvesting';
            farmer.harvestingHoursLeft = 2;
            addEvent(state, `Фермер начал сбор яблок у ${tree.id}.`, 'harvest');
        }
        return;
    }

    if (farmer.state === 'harvesting') {
        const tree = state.trees.find((item) => item.id === farmer.targetTreeId);
        farmer.harvestingHoursLeft -= 1;

        if (farmer.harvestingHoursLeft <= 0 && tree) {
            farmer.carriedApples += tree.applesReady;
            addEvent(state, `Фермер собрал ${tree.applesReady} яблок и несёт их на рынок.`, 'harvest');
            tree.applesReady = 0;
            farmer.state = 'go_to_market';
        }
        return;
    }

    if (farmer.state === 'go_to_market') {
        const arrived = moveEntity(farmer, { x: state.market.x, y: state.market.y });
        if (arrived) {
            state.market.apples += farmer.carriedApples;
            addEvent(state, `Фермер доставил на рынок ${farmer.carriedApples} яблок.`, 'market');
            farmer.carriedApples = 0;
            farmer.targetTreeId = null;
            farmer.state = 'idle_market';
        }
    }
}

function updateConsumers(state, config) {
    const pricePerApple = applePricePerUnit(config);

    state.consumers.forEach((consumer) => {
        if (!consumer.alive) {
            return;
        }

        if (consumer.state === 'idle_home') {
            const hungry = consumer.caloriesToday < config.dailyCaloriesNeed;
            const canAfford = consumer.money >= pricePerApple;
            if (hungry && canAfford) {
                consumer.state = 'go_to_market';
            }
            return;
        }

        if (consumer.state === 'go_to_market') {
            const arrived = moveEntity(consumer, { x: state.market.x + 6, y: state.market.y + 10 });
            if (arrived) {
                consumer.state = 'buying';
            }
            return;
        }

        if (consumer.state === 'buying') {
            const hungry = consumer.caloriesToday < config.dailyCaloriesNeed;
            if (!hungry) {
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
                addEvent(state, `${consumer.name} купил яблоко за ${pricePerApple.toFixed(2)} ₽.`, 'purchase');
                consumer.state = 'return_home';
            } else {
                state.market.failedDemandToday += 1;
                consumer.failedAttempts += 1;
                addEvent(state, `${consumer.name} не смог купить яблоко: на рынке пусто или не хватает денег.`, 'warning');
                consumer.state = 'return_home';
            }
            return;
        }

        if (consumer.state === 'return_home') {
            const arrived = moveEntity(consumer, { x: consumer.homeX, y: consumer.homeY });
            if (arrived) {
                consumer.state = 'idle_home';
            }
        }
    });
}

function advanceClock(state, config) {
    const wasMidnight = state.clock.hour === 0 && state.clock.totalHours > 0;
    if (wasMidnight) {
        settlePreviousDay(state, config);
        resetDailyCounters(state);
    }

    state.clock.totalHours += config.stepHours;
    state.clock.day = Math.floor(state.clock.totalHours / 24) + 1;
    state.clock.hour = state.clock.totalHours % 24;
}

export function tickSimulation(previousState, config) {
    const state = cloneState(previousState);

    advanceClock(state, config);
    maybeAdvanceTrees(state, config);
    maybePayIncome(state, config);
    updateFarmer(state);
    updateConsumers(state, config);
    collectMetrics(state);

    return state;
}

export function getApplePricePerUnit(config) {
    return applePricePerUnit(config);
}
