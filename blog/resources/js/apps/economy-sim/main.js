import '../../bootstrap';
import { defaultConfig, speedOptions } from './defaultConfig';
import { createInitialState } from './createInitialState';
import { tickSimulation, getApplePricePerUnit } from './tickSimulation';

const root = document.querySelector('[data-economy-sim-root]');

if (!root) {
    // no-op on pages without the simulator
} else {
    const app = createEconomySimApp(root);
    app.init();
}

function createEconomySimApp(rootEl) {
    const state = {
        config: { ...defaultConfig },
        pendingConfig: { ...defaultConfig },
        sim: createInitialState(defaultConfig),
        timerId: null,
    };

    function tickDurationForSpeed(speed) {
        const base = 650;
        return Math.max(45, Math.floor(base / speed));
    }

    function updateRuntimeSpeed(speed) {
        state.sim.runtime.speed = speed;
        state.sim.runtime.tickDurationMs = tickDurationForSpeed(speed);
    }

    function startLoop() {
        stopLoop();
        state.sim.runtime.running = true;
        state.timerId = window.setInterval(() => {
            step();
        }, state.sim.runtime.tickDurationMs);
    }

    function stopLoop() {
        if (state.timerId) {
            window.clearInterval(state.timerId);
            state.timerId = null;
        }
        state.sim.runtime.running = false;
    }

    function restartLoopIfNeeded() {
        if (!state.sim.runtime.running) {
            return;
        }
        startLoop();
    }

    function resetSimulation() {
        stopLoop();
        state.config = { ...state.pendingConfig };
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

    function bindEvents() {
        rootEl.addEventListener('click', (event) => {
            const button = event.target.closest('[data-action]');
            if (!button) return;

            const action = button.getAttribute('data-action');
            if (action === 'start') startLoop();
            if (action === 'pause') stopLoop();
            if (action === 'step') step();
            if (action === 'reset') resetSimulation();

            const speed = button.getAttribute('data-speed');
            if (speed) {
                setSpeed(Number(speed));
            }

            render();
        });

        rootEl.addEventListener('input', (event) => {
            const input = event.target.closest('[data-config-key]');
            if (!input) return;

            const key = input.getAttribute('data-config-key');
            const value = Number(input.value);
            state.pendingConfig[key] = Number.isFinite(value) ? value : input.value;
            syncDerivedPreview();
            updateConfigSummary();
        });

        rootEl.addEventListener('change', (event) => {
            const input = event.target.closest('[data-config-key]');
            if (!input) return;
            input.value = String(state.pendingConfig[input.getAttribute('data-config-key')]);
            updateConfigSummary();
        });

        rootEl.addEventListener('submit', (event) => {
            if (!event.target.matches('[data-config-form]')) return;
            event.preventDefault();
            resetSimulation();
            startLoop();
        });
    }

    function syncDerivedPreview() {
        const summary = rootEl.querySelector('[data-price-preview]');
        if (summary) {
            summary.textContent = `${getApplePricePerUnit(state.pendingConfig).toFixed(2)} ₽ за яблоко`;
        }

        const appleNeed = rootEl.querySelector('[data-apple-need-preview]');
        if (appleNeed) {
            appleNeed.textContent = `${Math.ceil(state.pendingConfig.dailyCaloriesNeed / state.pendingConfig.kcalPerApple)} яблок/день`;
        }
    }

    function updateConfigSummary() {
        syncDerivedPreview();
    }

    function sparkline(values, color) {
        if (!values.length) return '';
        const width = 220;
        const height = 70;
        const min = Math.min(...values);
        const max = Math.max(...values);
        const range = max - min || 1;
        const points = values
            .map((value, index) => {
                const x = (index / Math.max(values.length - 1, 1)) * width;
                const y = height - ((value - min) / range) * (height - 8) - 4;
                return `${x},${y}`;
            })
            .join(' ');

        return `
            <svg viewBox="0 0 ${width} ${height}" class="economy-sim-chart">
                <polyline fill="none" stroke="${color}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" points="${points}"></polyline>
            </svg>
        `;
    }

    function renderTrees() {
        return state.sim.trees.map((tree) => {
            const apples = Math.min(tree.applesReady, 8);
            const appleDots = Array.from({ length: apples }, (_, index) => {
                const angle = (Math.PI * 2 * index) / Math.max(apples, 1);
                const x = 50 + Math.cos(angle) * 18;
                const y = 30 + Math.sin(angle) * 14;
                return `<span class="economy-apple-dot" style="left:${x}%;top:${y}%"></span>`;
            }).join('');

            return `
                <div class="economy-tree" style="left:${tree.x}%;top:${tree.y}%;">
                    <div class="economy-tree-crown">${appleDots}</div>
                    <div class="economy-tree-trunk"></div>
                    <div class="economy-tree-label">
                        <strong>${tree.applesReady} ябл.</strong>
                        <span>до урожая: ${Math.ceil(tree.hoursUntilNextHarvest / 24)} дн.</span>
                    </div>
                </div>
            `;
        }).join('');
    }

    function consumerStateLabel(consumer) {
        if (!consumer.alive) return 'Умер';

        const labels = {
            idle_home: 'Дома',
            go_to_market: 'Идёт на рынок',
            buying: 'Покупает',
            return_home: 'Возвращается домой',
        };

        return labels[consumer.state] || consumer.state;
    }

    function renderConsumers() {
        return state.sim.consumers.map((consumer) => {
            const reservePct = Math.max(0, Math.min(100, (consumer.reserveDaysLeft / state.config.starvationDaysLimit) * 100));
            return `
                <div class="economy-agent economy-agent-consumer ${consumer.alive ? '' : 'is-dead'}"
                     style="left:${consumer.x}%;top:${consumer.y}%;">
                    <div class="economy-agent-body">${consumer.alive ? '🙂' : '✖'}</div>
                    <div class="economy-agent-card">
                        <strong>${consumer.name}</strong>
                        <span>${consumerStateLabel(consumer)}</span>
                        <span>${consumer.money.toFixed(0)} ₽</span>
                        <span>${consumer.caloriesToday}/${state.config.dailyCaloriesNeed} ккал</span>
                        <span>Ресурс: ${consumer.reserveDaysLeft.toFixed(1)} дн.</span>
                        <div class="economy-bar"><i style="width:${reservePct}%"></i></div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function renderFarmer() {
        return `
            <div class="economy-agent economy-agent-farmer"
                 style="left:${state.sim.farmer.x}%;top:${state.sim.farmer.y}%;">
                <div class="economy-agent-body">🧑‍🌾</div>
                <div class="economy-agent-card">
                    <strong>Фермер</strong>
                    <span>${state.sim.farmer.capital.toFixed(0)} ₽</span>
                    <span>Несёт: ${state.sim.farmer.carriedApples} ябл.</span>
                    <span>${farmerStateLabel(state.sim.farmer.state)}</span>
                </div>
            </div>
        `;
    }

    function farmerStateLabel(value) {
        const labels = {
            idle_market: 'На рынке',
            go_to_tree: 'Идёт к дереву',
            harvesting: 'Собирает урожай',
            go_to_market: 'Несёт на рынок',
        };
        return labels[value] || value;
    }

    function renderMetrics() {
        const alive = state.sim.consumers.filter((consumer) => consumer.alive).length;
        const applesOnTrees = state.sim.trees.reduce((sum, tree) => sum + tree.applesReady, 0);
        const avgMoney = alive
            ? state.sim.consumers.filter((consumer) => consumer.alive).reduce((sum, consumer) => sum + consumer.money, 0) / alive
            : 0;
        const avgReserve = alive
            ? state.sim.consumers.filter((consumer) => consumer.alive).reduce((sum, consumer) => sum + consumer.reserveDaysLeft, 0) / alive
            : 0;

        return `
            <div class="economy-side-grid">
                <div class="economy-kpi"><span>Живые / умершие</span><strong>${alive} / ${state.sim.consumers.length - alive}</strong></div>
                <div class="economy-kpi"><span>Яблок на деревьях</span><strong>${applesOnTrees}</strong></div>
                <div class="economy-kpi"><span>Яблок на рынке</span><strong>${state.sim.market.apples}</strong></div>
                <div class="economy-kpi"><span>Капитал фермера</span><strong>${state.sim.farmer.capital.toFixed(0)} ₽</strong></div>
                <div class="economy-kpi"><span>Средние деньги потребителей</span><strong>${avgMoney.toFixed(0)} ₽</strong></div>
                <div class="economy-kpi"><span>Средний запас выживания</span><strong>${avgReserve.toFixed(1)} дн.</strong></div>
                <div class="economy-kpi"><span>Цена яблока</span><strong>${getApplePricePerUnit(state.config).toFixed(2)} ₽</strong></div>
            </div>
            <div class="economy-chart-card">
                <h6>Яблоки на деревьях</h6>
                ${sparkline(state.sim.metrics.applesOnTrees || [], '#22c55e')}
            </div>
            <div class="economy-chart-card">
                <h6>Яблоки на рынке</h6>
                ${sparkline(state.sim.metrics.marketApples, '#3f5bd8')}
            </div>
            <div class="economy-chart-card">
                <h6>Капитал фермера</h6>
                ${sparkline(state.sim.metrics.farmerCapital, '#11a36a')}
            </div>
            <div class="economy-chart-card">
                <h6>Запас выживания потребителей</h6>
                ${sparkline(state.sim.metrics.avgReserveDays, '#f59e0b')}
            </div>
        `;
    }

    function renderConfigInput(label, key, min, max, step = 1) {
        return `
            <label class="economy-config-field">
                <span>${label}</span>
                <input type="number" min="${min}" max="${max}" step="${step}" value="${state.pendingConfig[key]}" data-config-key="${key}">
            </label>
        `;
    }

    function render() {
        const pricePerApple = getApplePricePerUnit(state.config);

        rootEl.innerHTML = `
            <div class="economy-sim-layout">
                <aside class="economy-panel economy-left-panel">
                    <div class="economy-panel-card">
                        <h4>Управление</h4>
                        <div class="economy-control-row">
                            <button class="btn btn-primary btn-sm" data-action="start">Старт</button>
                            <button class="btn btn-outline-primary btn-sm" data-action="pause">Пауза</button>
                            <button class="btn btn-outline-primary btn-sm" data-action="step">Шаг</button>
                            <button class="btn btn-outline-secondary btn-sm" data-action="reset">Сброс</button>
                        </div>
                        <div class="economy-speed-row">
                            ${speedOptions.map((speed) => `
                                <button class="btn btn-sm ${state.sim.runtime.speed === speed ? 'btn-primary' : 'btn-outline-primary'}" data-speed="${speed}">
                                    ${speed}x
                                </button>
                            `).join('')}
                        </div>
                        <div class="economy-runtime-state">
                            <span class="badge ${state.sim.runtime.running ? 'badge-success' : 'badge-secondary'}">
                                ${state.sim.runtime.running ? 'Симуляция идёт' : 'Пауза'}
                            </span>
                            <span>День ${state.sim.clock.day}, ${String(state.sim.clock.hour).padStart(2, '0')}:00</span>
                        </div>
                    </div>

                    <form class="economy-panel-card" data-config-form>
                        <h4>Параметры</h4>
                        ${renderConfigInput('Потребители', 'consumersCount', 1, 3)}
                        ${renderConfigInput('Деревья', 'treesCount', 1, 8)}
                        ${renderConfigInput('Яблок на дереве в начале', 'initialApplesPerTree', 0, 200)}
                        ${renderConfigInput('Яблок на дерево за цикл', 'applesPerTreePerCycle', 1, 200)}
                        ${renderConfigInput('Цикл созревания (дни)', 'growthCycleDays', 1, 30)}
                        ${renderConfigInput('Стартовые деньги потребителя, ₽', 'consumerStartMoney', 0, 100000)}
                        ${renderConfigInput('Доход потребителя в день, ₽', 'consumerDailyIncome', 0, 100000)}
                        ${renderConfigInput('Стартовый капитал фермера, ₽', 'farmerStartCapital', 0, 1000000)}
                        ${renderConfigInput('Цена яблок, ₽/кг', 'applePricePerKg', 1, 10000)}
                        ${renderConfigInput('Вес яблока, г', 'appleWeightGrams', 50, 500)}
                        ${renderConfigInput('Ккал в яблоке', 'kcalPerApple', 20, 300)}
                        ${renderConfigInput('Суточная потребность, ккал', 'dailyCaloriesNeed', 500, 5000)}
                        ${renderConfigInput('Предел голодания, дней', 'starvationDaysLimit', 1, 90)}
                        <div class="economy-config-note">
                            <div><strong>Текущая цена:</strong> <span data-price-preview>${getApplePricePerUnit(state.pendingConfig).toFixed(2)} ₽ за яблоко</span></div>
                            <div><strong>Норма:</strong> <span data-apple-need-preview>${Math.ceil(state.pendingConfig.dailyCaloriesNeed / state.pendingConfig.kcalPerApple)} яблок/день</span></div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-3">Применить и перезапустить</button>
                    </form>
                </aside>

                <main class="economy-center-panel">
                    <div class="economy-scene-card">
                        <div class="economy-scene">
                            <div class="economy-zone economy-zone-orchard">
                                <div class="economy-zone-label">Сад</div>
                            </div>
                            <div class="economy-zone economy-zone-market">
                                <div class="economy-zone-label">Рынок</div>
                                <div class="economy-market-stock">
                                    ${'🍎'.repeat(Math.min(state.sim.market.apples, 20))}
                                    <strong>${state.sim.market.apples}</strong>
                                </div>
                            </div>
                            <div class="economy-zone economy-zone-homes">
                                <div class="economy-zone-label">Дома потребителей</div>
                            </div>
                            ${renderTrees()}
                            ${renderFarmer()}
                            ${renderConsumers()}
                        </div>
                    </div>

                    <div class="economy-log-card">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">Лог событий</h5>
                            <span class="text-small text-muted">Продажа: ${state.sim.market.soldToday} ябл./день · Нехватка: ${state.sim.market.failedDemandToday} · Цена: ${pricePerApple.toFixed(2)} ₽</span>
                        </div>
                        <div class="economy-log-list">
                            ${state.sim.eventLog.map((entry) => `
                                <div class="economy-log-item is-${entry.type}">
                                    <span class="economy-log-time">${entry.timeLabel}</span>
                                    <span>${entry.text}</span>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </main>

                <aside class="economy-panel economy-right-panel">
                    <div class="economy-panel-card">
                        <h4>Состояние системы</h4>
                        ${renderMetrics()}
                    </div>
                </aside>
            </div>
        `;

        syncDerivedPreview();
    }

    return {
        init() {
            updateRuntimeSpeed(1);
            bindEvents();
            render();
        },
    };
}
