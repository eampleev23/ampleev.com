const SCENE_WIDTH = 100;
const SCENE_HEIGHT = 100;

function createTrees(config) {
    const spacing = config.treesCount > 1 ? 20 / (config.treesCount - 1) : 0;

    return Array.from({ length: config.treesCount }, (_, index) => ({
        id: `tree-${index + 1}`,
        x: 16 + spacing * index,
        y: 24 + (index % 2) * 9,
        applesReady: config.initialApplesPerTree,
        hoursUntilNextHarvest: config.growthCycleDays * 24,
    }));
}

function createConsumers(config) {
    return Array.from({ length: config.consumersCount }, (_, index) => ({
        id: `consumer-${index + 1}`,
        name: `Потребитель ${index + 1}`,
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
        failedAttempts: 0,
        tripLabel: '',
    }));
}

export function createInitialState(config) {
    return {
        clock: {
            totalHours: 0,
            day: 1,
            hour: 0,
        },
        runtime: {
            running: false,
            speed: 1,
            tickDurationMs: 600,
            lastTickAt: null,
        },
        scene: {
            width: SCENE_WIDTH,
            height: SCENE_HEIGHT,
        },
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
            harvestingHoursLeft: 0,
        },
        market: {
            x: 50,
            y: 55,
            apples: 0,
            soldToday: 0,
            failedDemandToday: 0,
        },
        trees: createTrees(config),
        consumers: createConsumers(config),
        eventLog: [
            {
                id: `boot-${Date.now()}`,
                timeLabel: 'День 1, 00:00',
                text: 'Симуляция подготовлена. Можно запускать.',
                type: 'system',
            },
        ],
        metrics: {
            labels: [],
            marketApples: [],
            applesOnTrees: [],
            farmerCapital: [],
            avgConsumerMoney: [],
            avgReserveDays: [],
            aliveConsumers: [],
        },
    };
}
