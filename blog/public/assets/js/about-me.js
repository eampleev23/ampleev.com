(function () {
    'use strict';

    var page = document.querySelector('[data-about-profile]');
    if (!page) return;

    function initPageShell() {
        document.querySelectorAll('img[data-inject-svg]').forEach(function (image) {
            image.removeAttribute('data-inject-svg');
        });

        var toggler = document.querySelector('.navbar-toggler');
        var collapse = document.querySelector('.navbar-collapse');
        var navbar = toggler ? toggler.closest('.navbar') : null;

        if (toggler && collapse) {
            toggler.addEventListener('click', function () {
                var expanded = toggler.getAttribute('aria-expanded') === 'true';
                toggler.setAttribute('aria-expanded', expanded ? 'false' : 'true');
                collapse.classList.toggle('show', !expanded);
                if (navbar) navbar.classList.toggle('navbar-toggled-show', !expanded);
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth < 992) return;
                toggler.setAttribute('aria-expanded', 'false');
                collapse.classList.remove('show');
                if (navbar) navbar.classList.remove('navbar-toggled-show');
            });
        }

        var backToTop = document.querySelector('.back-to-top');
        if (backToTop) {
            backToTop.addEventListener('click', function (event) {
                event.preventDefault();
                var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
            });
        }
    }

    function initAiUsage() {
        var block = page.querySelector('[data-ai-usage-block]');
        if (!block) return;

        var endpoint = block.getAttribute('data-ai-usage-latest-url');
        var interval = Math.max(60000, parseInt(block.getAttribute('data-ai-usage-poll-interval'), 10) || 60000);
        var locale = block.getAttribute('data-ai-usage-locale') || 'ru-RU';
        var timezone = block.getAttribute('data-ai-usage-timezone') || 'Europe/Moscow';
        var updatedLabel = block.getAttribute('data-ai-usage-updated-label') || 'Обновлено';
        var formatter = new Intl.NumberFormat(locale);
        var timer = null;
        var isFetching = false;
        var lastRequestAt = Date.now();

        function renderCounter(field, value) {
            var element = block.querySelector('[data-ai-token-field="' + field + '"]');
            var number = parseInt(value, 10);
            if (!element || !Number.isFinite(number)) return;

            element.textContent = formatter.format(number);
            element.setAttribute('data-ai-token-count', String(number));
        }

        function renderTimestamp(value) {
            var element = block.querySelector('[data-ai-usage-updated]');
            var date = new Date(value);
            if (!element || Number.isNaN(date.getTime())) return;

            var options = locale === 'en-US'
                ? { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit', timeZone: timezone }
                : { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', timeZone: timezone };
            var formatted = new Intl.DateTimeFormat(locale, options).format(date).replace(',', '');

            element.textContent = updatedLabel + ': ' + formatted;
            element.setAttribute('datetime', value);
            element.setAttribute('data-ai-usage-updated-current', value);
            element.hidden = false;
        }

        function scheduleNextPoll() {
            window.clearTimeout(timer);
            if (document.hidden || !endpoint) return;

            var elapsed = Date.now() - lastRequestAt;
            timer = window.setTimeout(refreshSnapshot, Math.max(0, interval - elapsed));
        }

        function refreshSnapshot() {
            if (!endpoint || document.hidden || isFetching) {
                scheduleNextPoll();
                return;
            }

            var elapsed = Date.now() - lastRequestAt;
            if (elapsed < interval) {
                scheduleNextPoll();
                return;
            }

            isFetching = true;
            lastRequestAt = Date.now();

            fetch(endpoint, {
                headers: { 'Accept': 'application/json' },
                cache: 'no-store',
                credentials: 'same-origin'
            })
                .then(function (response) {
                    if (!response.ok) throw new Error('Snapshot request failed');
                    return response.json();
                })
                .then(function (data) {
                    var snapshot = data && data.snapshot;
                    if (!snapshot) return;

                    renderCounter('total_tokens', snapshot.total_tokens);
                    renderCounter('codex_tokens', snapshot.codex_tokens);
                    renderCounter('claude_tokens', snapshot.claude_tokens);
                    renderTimestamp(snapshot.captured_at);
                })
                .catch(function () {
                    // The server-rendered snapshot remains visible on transient API errors.
                })
                .finally(function () {
                    isFetching = false;
                    scheduleNextPoll();
                });
        }

        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                window.clearTimeout(timer);
                return;
            }

            scheduleNextPoll();
        });

        if (document.readyState === 'complete') {
            scheduleNextPoll();
        } else {
            window.addEventListener('load', scheduleNextPoll, { once: true });
        }
    }

    function initAnalytics() {
        if (page.getAttribute('data-about-analytics-enabled') !== 'true') return;

        var endpoint = page.getAttribute('data-about-analytics-url');
        var csrf = document.querySelector('meta[name="csrf-token"]');

        function externalEvent(eventName, params) {
            if (typeof window.gtag === 'function') {
                window.gtag('event', eventName, params);
            }

            if (typeof window.ym === 'function' && window.METRIKA_COUNTER_ID) {
                window.ym(window.METRIKA_COUNTER_ID, 'reachGoal', eventName, params);
            }
        }

        function firstPartyEvent(eventName, params) {
            if (!endpoint || !csrf) return;

            var canonical = document.querySelector('link[rel="canonical"]');
            var payload = Object.assign({
                event_name: eventName,
                page_url: window.location.href,
                page_title: document.title || '',
                canonical_url: canonical ? canonical.href : '',
                locale: document.documentElement ? document.documentElement.lang : '',
                referrer: document.referrer || ''
            }, params);

            fetch(endpoint, {
                method: 'POST',
                credentials: 'same-origin',
                keepalive: true,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf.getAttribute('content') || ''
                },
                body: JSON.stringify(payload)
            }).catch(function () {});
        }

        function track(eventName, params, sendFirstParty) {
            externalEvent(eventName, params);
            if (sendFirstParty !== false) firstPartyEvent(eventName, params);
        }

        page.addEventListener('click', function (event) {
            var link = event.target.closest('[data-about-event]');
            if (!link || !page.contains(link)) return;

            var eventName = link.getAttribute('data-about-event');
            var params = {};
            var placement = link.getAttribute('data-placement');
            var project = link.getAttribute('data-project');
            if (placement) params.placement = placement;
            if (project) params.project = project;

            track(eventName, params, link.getAttribute('data-about-first-party') !== 'false');
        });

        var sentDepths = {};
        var scrollQueued = false;

        function measureScrollDepth() {
            scrollQueued = false;
            var root = document.documentElement;
            var height = Math.max(root.scrollHeight, document.body ? document.body.scrollHeight : 0);
            if (!height) return;

            var depth = ((window.scrollY + window.innerHeight) / height) * 100;
            [50, 90].forEach(function (threshold) {
                if (depth < threshold || sentDepths[threshold]) return;
                sentDepths[threshold] = true;
                track('about_scroll_depth', { depth: threshold }, true);
            });
        }

        function onScroll() {
            if (scrollQueued) return;
            scrollQueued = true;
            window.requestAnimationFrame(measureScrollDepth);
        }

        window.addEventListener('scroll', onScroll, { passive: true });
        measureScrollDepth();
    }

    initPageShell();
    initAiUsage();
    initAnalytics();
})();
