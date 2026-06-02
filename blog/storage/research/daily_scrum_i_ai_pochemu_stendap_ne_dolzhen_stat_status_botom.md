# Research brief: Daily Scrum и AI

Вопрос статьи: как AI меняет Daily Scrum?

Рабочий тезис: AI может снизить стоимость статусной коммуникации перед Daily Scrum и собрать полезные сигналы из рабочих систем, но не должен заменять живую инспекцию прогресса к Sprint Goal, адаптацию Sprint Backlog и командную координацию. Главный риск - превратить Daily Scrum из короткой командной планирующей сессии в AI-generated status reporting.

Дата подготовки: 2026-06-02.

## Факты, которые можно использовать

- Scrum Guide 2020 определяет Daily Scrum как 15-минутное событие для Developers. Его цель - inspect progress toward the Sprint Goal и adapt the Sprint Backlog as necessary, adjusting upcoming planned work. Developers могут выбирать структуру и техники, пока Daily Scrum фокусируется на Sprint Goal и produces an actionable plan for the next day of work. Источник: https://scrumguides.org/scrum-guide.html
- Scrum Guide Expanded v2026.1 / Scrum Guide Expansion Pack - это companion/expansion source, а не новая каноническая версия Scrum Guide. Он прямо указывает, что это adaptation of the original 2020 Scrum Guide, и полезен как практическое пояснение, а не как источник новых обязательных правил. Для Daily Scrum он подчёркивает collaborative update of the actionable plan, риски / impediments, quick decision-making и flow-рамку "monitor idle work, not idle people". Источник: https://scrumexpansion.org/scrum-guide-expanded/
- В разделе про Artificial Intelligence Scrum Guide Expanded формулирует AI как supervised decision-making partner: AI может улучшать transparency, inspection и adaptation, но не заменяет human accountability и не должен override empirical process control. Это релевантно тезису статьи: AI помогает собирать сигналы перед Daily Scrum, но не проводит Daily Scrum и не принимает ответственность за адаптацию плана. Источник: https://scrumexpansion.org/scrum-guide-expanded/
- Daily Scrum не является статусной встречей для менеджера, Product Owner или Scrum Master. Scrum.org отдельно разбирает этот миф и описывает Daily Scrum как collaborative planning session by Developers. Источники: https://www.scrum.org/resources/what-is-a-daily-scrum и https://www.scrum.org/resources/blog/scrum-myths-daily-scrum-not-status-meeting
- Если Daily Scrum превращается в status meeting, фокус смещается с Sprint Goal и адаптации плана на индивидуальную отчётность. Это ухудшает self-management и может снижать готовность Developers открыто приносить проблемы. Источник: Scrum.org, "Scrum Myths: Daily Scrum Is Not a Status Meeting".
- В AI-сценариях с суммаризацией рабочих источников возникают типовые generative AI риски: confabulation, overreliance, privacy, information integrity, human-AI configuration и необходимость governance. Источники: NIST AI RMF 1.0 https://www.nist.gov/publications/artificial-intelligence-risk-management-framework-ai-rmf-10 и NIST Generative AI Profile https://nvlpubs.nist.gov/nistpubs/ai/NIST.AI.600-1.pdf
- OWASP Top 10 for LLM Applications 2025 выделяет sensitive information disclosure, misinformation, excessive agency, system prompt leakage и другие риски LLM-приложений. Для Daily Scrum это важно, потому что AI summary может получать доступ к Jira, Git, Slack/Teams, incident data, support tickets и внутренним обсуждениям. Источник: https://owasp.org/www-project-top-10-for-large-language-model-applications/assets/PDF/OWASP-Top-10-for-LLMs-v2025.pdf
- DORA 2025 описывает AI-assisted software development не как самостоятельную гарантию улучшения delivery, а как усилитель организационных практик. Это поддерживает осторожную формулировку статьи: AI помогает только при наличии зрелой командной дисциплины, проверки и governance. Источник: https://dora.dev/dora-report-2025/
- В контексте персональных данных и employee monitoring полезны источники EDPB/ICO: обработка персональных данных в AI-моделях требует оценки правового основания, минимизации, прозрачности и контроля; monitoring at work требует необходимости, пропорциональности и понятного уведомления работников. Источники: https://www.edpb.europa.eu/our-work-tools/our-documents/opinion-board-art-64/opinion-282024-certain-data-protection-aspects_en и https://ico.org.uk/media/for-organisations/documents/4026921/monitoring-at-work-impact-assessment-202310.pdf

## Source-backed claims для статьи

- "Daily Scrum exists for inspection and adaptation, not reporting" - сильно поддержано Scrum Guide 2020 и Scrum.org.
- "AI-assisted Daily Scrum should look at stuck work and risks, not idle people" - поддержано Scrum Guide Expanded как companion-ориентиром через flow-рамку "monitor idle work, not idle people"; в статье нужно явно отделять этот ориентир от канонических правил Scrum Guide 2020.
- "AI can be useful before Daily Scrum as a preparation layer" - это практическая интерпретация, поддержанная общими возможностями LLM summarization и DORA/NIST рамками, но не прямым исследованием именно Daily Scrum.
- "AI summary can increase the risk of status-reporting behavior" - аргумент построен из Scrum.org distinction between Daily Scrum and status meeting плюс NIST/OWASP risks around overreliance, misinformation and governance. Это не эмпирически доказанная закономерность именно для AI standup bots, поэтому формулировать как риск, а не как установленный факт.
- "AI output should not be used for individual performance evaluation without explicit governance" - поддержано privacy/worker monitoring логикой ICO/EDPB и общими AI governance источниками. В статье лучше говорить практично: не смешивать delivery signals и performance management.
- "AI can surface blockers, stale PRs, unstable tests and mismatches between tracker status and reality" - это plausible практическая возможность при доступе к соответствующим источникам. Формулировать как use case, а не доказанное универсальное улучшение.

## Полезные интерпретации

- AI в Daily Scrum логически продолжает первые две статьи серии: в Backlog Refinement он готовит материал к обсуждению, в Sprint Planning - варианты плана, в Daily Scrum - сигналы о ходе спринта.
- Главная граница: AI может подготовить вход для разговора, но не создаёт shared awareness сам по себе. Shared awareness возникает, когда команда одинаково понимает важные риски, зависимости, решения и следующий план.
- Хороший AI summary перед Daily должен группировать сигналы вокруг Sprint Goal, risks, blockers, dependencies и decisions, а не вокруг персональной активности каждого участника.
- Scrum Guide Expanded усиливает практический язык статьи: AI-summary лучше направлять на flow of value, застрявшую работу, impediments и actionable plan, а не на idle people и индивидуальную занятость.
- Если команда использует AI summary как "кто чем был занят", инструмент усиливает уже плохой формат Daily Scrum.
- Если команда использует AI summary как вход для вопроса "что меняется в плане на ближайшие сутки?", инструмент может сделать Daily Scrum более коротким и предметным.

## Слабые или contested claims

- Нет сильной исследовательской базы именно по AI-assisted Daily Scrum в реальных Scrum-командах. Поэтому нельзя писать, что AI доказанно сокращает Daily Scrum, улучшает скорость delivery или повышает качество координации.
- Нельзя утверждать, что AI reliably detects blockers from chat/logs. Он может подсветить кандидаты, но блокеры требуют человеческой проверки.
- Нельзя утверждать, что asynchronous AI summaries могут заменить live Daily Scrum во всех распределённых командах. Асинхронность полезна для фактов, но при риске для Sprint Goal обычно требуется координация.
- Не стоит превращать статью в юридическую инструкцию по GDPR/AI Act/worker monitoring. Можно использовать privacy/governance источники как ориентиры для продуктовой и командной гигиены данных.

## Source gaps

- Мало прямых peer-reviewed исследований 2024-2026 о daily standup bots, AI-generated standup summaries и влиянии таких инструментов на Scrum outcomes.
- Мало независимых сравнений "Daily Scrum with AI summary" vs "Daily Scrum without AI summary" с измеримыми outcomes: coordination quality, Sprint Goal achievement, blocker resolution time, trust.
- Vendor materials о standup bots часто полезны как примеры функциональности, но слишком слабы для центральных утверждений статьи и не должны быть опорой.

## Visual brief

- Main/hero image: команда у физической Daily Scrum доски обсуждает ближайшие сутки и риск по Sprint Goal, а не позирует перед абстрактным AI. Должны быть видны люди, рабочий процесс, доска/тикеты/сигналы, напряжение вокруг координации. Центральная доска должна нести смысловой текст, потому что она показывает рамку разговора. Required/readable text reviewed: `Daily Scrum`, `Sprint Goal`, `AI Signals`, `Blockers`, `Follow-ups`, `Risks`, `Deliver checkout flow improvements with high reliability`, `Review PR`, `Dedupe check`, `Timezone risk`, `QA data`.
- Inline figure: команда смотрит на AI-сигналы перед Daily Scrum: зависимости, блокеры, PR/review bottlenecks, риск по Sprint Goal. Изображение должно поддерживать тезис "AI собирает сигналы, команда адаптирует план". Центральный экран должен иметь читаемые короткие labels. Required/readable text reviewed: `Daily Scrum`, `Sprint Goal`, `Deliver a stable checkout flow with higher reliability`, `72%`, `AI Signals`, `Blockers`, `Risks`, `Decisions`, `Follow-ups`, `Review PR`, `PR #4821`, `Timezone risk`, `API updates`, `Dedupe check`, `Data mismatch`, `QA data`, `Incomplete test data`, `History log`, `Keep 30 days`, `Address comments`, `Prepare dataset`, `HIGH`, `MEDIUM`, `DONE`, `TODAY`, `TOMORROW`.
- Предыдущие draft-изображения отвергнуты: сюрреалистичные / нечитаемые доски и экраны не проходят visual standard и не должны публиковаться.
- Промежуточные изображения без readable text на центральной доске/экране тоже больше не считаются достаточными по новому правилу. Они были реалистичными по людям и среде, но слабее раскрывали процесс.
- Изображения заменены 2026-06-02 второй visual pass:
  - `blog/public/assets/img/articles/daily_scrum_ai_main.png` - 1672x941, реалистичная команда у физической доски, reviewed readable board labels listed above; подходит как main/hero image.
  - `blog/public/assets/img/articles/daily_scrum_ai_signals.png` - 1672x941, команда обсуждает экран с AI-сигналами, reviewed readable screen labels listed above; подходит как inline figure.
- Постобработка не использовалась: сначала были сгенерированы изображения с корректным читаемым текстом сразу, и эта попытка прошла reviewer inspection.
- Final visual prompts:
  - Hero: warm realistic editorial photo of a cross-functional software team standing around a physical Daily Scrum board in a textured modern office, natural expressions, readable exact board labels `Daily Scrum`, `Sprint Goal`, `AI Signals`, `Blockers`, `Follow-ups`, `Risks`, sticky notes `Review PR`, `Dedupe check`, `Timezone risk`, `QA data`, no gibberish, no surreal UI, 16:9.
  - Inline: warm realistic editorial photo of a team reviewing an AI-assisted signal board on a large monitor before Daily Scrum, readable exact screen labels `Daily Scrum`, `Sprint Goal`, `AI Signals`, `Blockers`, `Risks`, `Decisions`, `Follow-ups`, cards `Review PR`, `Timezone risk`, `Dedupe check`, `QA data`, `History log`, no fake unreadable UI, 16:9.

## Reviewer notes

- В статье нужны inline-ссылки, а не только финальный список источников.
- Нужно отделить Scrum Guide 2020 как канонический источник от Scrum Guide Expanded v2026.1 как companion-ориентира.
- `article-blog-section` уже должен быть `AI`, чтобы статья не расходилась с первыми двумя частями серии.
- Источники DORA 2025 и OWASP 2025 должны использоваться вместо более старого DORA 2023.
- Термины для проверки по glossary: Daily Scrum, Developers, Sprint Goal, Sprint Backlog, status report/status bot, shared awareness, blockers, pull requests, review bottlenecks, AI-generated status reporting, governance, data hygiene.
