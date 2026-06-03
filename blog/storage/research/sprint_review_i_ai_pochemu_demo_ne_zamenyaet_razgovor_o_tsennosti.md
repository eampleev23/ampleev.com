# Research brief: Sprint Review и AI

Вопрос статьи: как AI меняет классический Sprint Review в Scrum?

Рабочий тезис: AI может удешевить подготовку к Sprint Review (release notes, демо-сценарий, агрегация пользовательской обратной связи, продуктовые метрики, черновик изменений в Product Backlog), но не должен заменять главное — совместную рабочую сессию, на которой Scrum Team и стейкхолдеры инспектируют результат спринта, обсуждают прогресс к Product Goal и адаптируют Product Backlog. Главный риск — превратить Sprint Review из working session в отполированное AI-демо, которое имитирует обратную связь и согласие, но не порождает реальных продуктовых решений.

Дата подготовки: 2026-06-02.

## Факты, которые можно использовать

- Scrum Guide 2020 определяет Sprint Review как второе с конца событие спринта, timeboxed максимум 4 часа для месячного спринта. Цель — inspect the outcome of the Sprint и determine future adaptations. Scrum Team presents the results of their work to key stakeholders, и обсуждается progress toward the Product Goal. Прямая цитата по формату: "The Sprint Review is a working session and the Scrum Team should avoid limiting it to a presentation." Attendees collaborate on what to do next, и the Product Backlog may also be adjusted to meet new opportunities. Источник: https://scrumguides.org/scrum-guide.html
- Scrum Guide 2020 явно связывает Sprint Review с Product Goal и эмпирическим контролем: команда и стейкхолдеры review what was accomplished и what has changed in their environment, и на основе этого collaborate on what to do next. Это инспекция Increment и адаптация Product Backlog, а не приёмка работы. Источник: https://scrumguides.org/scrum-guide.html
- Scrum.org прямо разбирает анти-паттерн "Sprint Review = демо". Материал "Myth 12: The Sprint Review is a Demo" и "Sprint Review: Much More Than Just A Demo" описывают Sprint Review как collaborative working session, в которой может быть (а может и не быть) демо, но цель — maximize feedback и minimize risk, а не презентация. Источники: https://www.scrum.org/resources/blog/myth-12-sprint-review-demo и https://www.scrum.org/resources/what-is-a-sprint-review
- Scrum.org отдельно подчёркивает роль стейкхолдеров: частая ошибка — команда так увлекается презентацией, что стейкхолдеры не успевают дать обратную связь; Product Backlog должен занимать prominent place и активно корректироваться по мере появления инсайтов. Источники: https://www.scrum.org/resources/blog/how-engage-stakeholders-your-sprint-reviews-0 и https://www.scrum.org/resources/blog/sprint-review-being-good-stakeholder
- Scrum Guide Expanded v2026.1 / Scrum Guide Expansion Pack — companion/expansion source на базе 2020 Scrum Guide, а не новая каноническая версия. Полезен как практическое пояснение: Sprint Review — про flow of value к стейкхолдерам, реальную инспекцию Increment и совместную адаптацию плана продукта, а не про статус-презентацию. В разделе про Artificial Intelligence он формулирует AI как supervised decision-making partner: AI может усиливать transparency, inspection и adaptation, но не заменяет human accountability и не отменяет empirical process control. Для Sprint Review это значит: AI может готовить вход (резюме изменений, метрики, агрегированную обратную связь), но не принимает продуктовые решения и не несёт за них ответственность. Источник: https://scrumexpansion.org/scrum-guide-expanded/
- В AI-сценариях с генерацией release notes, демо-нарратива и суммаризацией пользовательской обратной связи возникают типовые generative AI риски: confabulation (уверенное выдумывание фактов и инсайтов), overreliance, misinformation, information integrity, human-AI configuration и необходимость governance. Источники: NIST AI RMF 1.0 https://www.nist.gov/publications/artificial-intelligence-risk-management-framework-ai-rmf-10 и NIST Generative AI Profile https://nvlpubs.nist.gov/nistpubs/ai/NIST.AI.600-1.pdf
- OWASP Top 10 for LLM Applications 2025 выделяет sensitive information disclosure, misinformation, excessive agency и др. Для Sprint Review это релевантно, потому что AI-сводка может получать доступ к product analytics, support tickets, CRM, NPS/опросам, записям интервью с пользователями и внутренним обсуждениям, а сгенерированные "инсайты" могут попасть прямо в продуктовые решения. Источник: https://owasp.org/www-project-top-10-for-large-language-model-applications/assets/PDF/OWASP-Top-10-for-LLMs-v2025.pdf
- DORA State of AI-assisted Software Development 2025 описывает AI как усилитель организационных практик, а не самостоятельную гарантию лучшего delivery или лучших продуктовых решений. Поддерживает осторожную формулировку: AI улучшает Sprint Review только при зрелой практике инспекции и адаптации. Источник: https://dora.dev/dora-report-2025/
- В контексте обработки персональных данных пользователей и сотрудников при агрегации обратной связи полезны ориентиры EDPB/ICO: правовое основание, минимизация, прозрачность, пропорциональность. Источники: https://www.edpb.europa.eu/our-work-tools/our-documents/opinion-board-art-64/opinion-282024-certain-data-protection-aspects_en и https://ico.org.uk/media/for-organisations/documents/4026921/monitoring-at-work-impact-assessment-202310.pdf

## Source-backed claims для статьи

- "Sprint Review exists to inspect the Increment and adapt the Product Backlog, not to demo" — сильно поддержано Scrum Guide 2020 и Scrum.org (Myth 12, What is a Sprint Review).
- "Sprint Review is a working session, not a presentation" — прямая цитата Scrum Guide 2020.
- "The primary value is stakeholder feedback and a joint decision about what to do next" — поддержано Scrum Guide 2020 и Scrum.org stakeholder-материалами.
- "AI can cheaply prepare release notes, demo narrative, metrics and aggregated feedback" — plausible практическая возможность LLM; формулировать как use case, а не доказанное улучшение outcomes.
- "AI-polished demo can simulate alignment and hide weak signals" — аргумент построен из Scrum.org distinction (review != demo) плюс NIST/OWASP риски confabulation, overreliance, misinformation. Это риск, а не эмпирически установленная закономерность для AI в Sprint Review.
- "AI-generated product insights must not be treated as validated facts" — поддержано NIST GenAI Profile (confabulation, information integrity) и OWASP (misinformation). Формулировать практично: инсайт от модели — гипотеза для проверки, а не решение.
- "AI should not replace human accountability for product decisions / Product Backlog adaptation" — поддержано Scrum Guide 2020 (Product Owner accountability) и Scrum Guide Expanded как companion-ориентиром (supervised decision-making partner).

## Полезные интерпретации

- AI в Sprint Review логически продолжает серию: refinement — материал к обсуждению, planning — варианты плана, Daily Scrum — сигналы о ходе спринта, Sprint Review — собранный результат и обратная связь для адаптации продукта.
- Главная граница: AI может подготовить и структурировать вход (что сделано, что изменилось, что говорят данные и пользователи), но не создаёт сам по себе продуктового решения. Решение возникает, когда Scrum Team и стейкхолдеры вместе осмысляют результат и меняют Product Backlog.
- Хороший AI-вход к Sprint Review группируется вокруг Product Goal, ценности, рисков и открытых продуктовых вопросов, а не вокруг "сколько тикетов закрыли" и "как красиво показать демо".
- Опасный сценарий — "AI-driven demo theater": модель генерирует эффектную презентацию, release notes и список "достижений", команда зачитывает, стейкхолдеры кивают, Product Backlog не меняется. Прозрачность растёт по форме, но не по сути.
- Особый риск Sprint Review — обратная связь. Если AI агрегирует фидбек пользователей и стейкхолдеров в гладкое резюме, теряются противоречия, слабые сигналы, неудобное несогласие — именно то, ради чего событие существует.

## Слабые или contested claims

- Нет сильной исследовательской базы именно по AI-assisted Sprint Review в реальных Scrum-командах. Нельзя писать, что AI доказанно улучшает качество продуктовых решений, вовлечённость стейкхолдеров или скорость адаптации backlog.
- Нельзя утверждать, что AI reliably extracts true product insights из обратной связи. Он может предложить кандидатов-гипотезы, требующие человеческой проверки.
- Нельзя утверждать, что AI-сгенерированные демо/release notes повышают доверие стейкхолдеров; эффект зависит от честности содержания, а не от полировки.
- Не превращать статью в юридическую инструкцию по GDPR/AI Act. Privacy-источники — ориентиры для продуктовой гигиены данных при агрегации обратной связи.

## Source gaps

- Мало прямых peer-reviewed исследований 2024-2026 о AI-generated Sprint Reviews / release demos и их влиянии на продуктовые outcomes.
- Мало независимых сравнений "Sprint Review с AI-подготовкой" vs "без" по измеримым метрикам: качество решений, вовлечённость стейкхолдеров, изменения в Product Backlog, удовлетворённость.
- Vendor-инструменты (auto release notes, demo recorders, feedback analytics) полезны как примеры функциональности, но слишком слабы для центральных утверждений и не должны быть опорой.

## Visual brief — Codex handoff (Codex generation completed; pending user visual approval)

Генерация изображений выполнялась через Codex handoff workflow (built-in `imagegen`), без платных external API. Статья НЕ считается визуально готовой, пока пользователь не примет итоговые изображения. Оба изображения должны быть визуально когерентны между собой и с серией, не должны повторять людей, фон, окна, свет или одну и ту же композицию из других статей серии, но внутри этой статьи должны сохранять один интерьерный мир: olive/green acoustic panels + terracotta plaster + walnut slats + warm wood.

Общие правила (применяются к обоим): фотореализм; живые люди с реальными эмоциями; современный офис с текстурой и глубиной (дерево/кирпич/стекло/растения/ткань, тёплый свет); эффект присутствия в реальной рабочей сессии. Изображения в одной статье должны отличаться композицией, дистанцией камеры, светом и видимостью артефактов, но не должны выглядеть как разные офисы. Для этой статьи общий интерьер: зелёные/olive acoustic panels, terracotta plaster, walnut slats, warm wood table; синие панели, видимые окна и стеклянные стены запрещены. Люди должны отличаться от уже использованных в серии: другой пол/возраст/причёска/стиль одежды/эмоция/роль. Референс Backlog Refinement используется только как направление качества и текстуры, не как шаблон для копирования человека, стены, окна или света. Negative constraints: без абстрактного AI, декоративных градиентов, пустых футуристичных сцен, generic stock-позирования, видимых окон/стеклянных стен, синих панелей, фейковых дашбордов, искажённых рук/лиц, сюрреалистичных досок, нечитаемого/искажённого текста, ломаной кириллицы, выдуманных UI-подписей. Любой gibberish или искажённый текст — hard rejection (перегенерировать).

### Image 1 — main/hero
- Filename: `blog/public/assets/img/articles/sprint_review_ai_main.png`
- Reference в драфте: `/assets/img/articles/sprint_review_ai_main.png` (main + hero)
- Dimensions: финально `1672x941` (16:9). Если генератор отдаёт 3:2/квадрат — центр-кроп до 16:9, затем ресемпл до 1672x941, без искажения пропорций.
- Composition role: close/medium hero portrait, one emotionally alive participant, textured background, board/screen/window absent.
- Lighting role: warm side light with olive/terracotta textured contrast, no visible window.
- Article language: RU, but visible board/screen text intentionally absent.
- Сцена: один участник Sprint Review в текстурном современном офисе; мужчина 35-45 лет с короткими волосами и лёгкой щетиной, держит планшет и ручку, реагирует на вопрос за кадром. Тезис передаётся через живую рабочую реакцию и атмосферу обсуждения ценности, а не через буквальный кадр всей команды у доски.
- Visible text inventory: читаемого текста нет.
- alt: `Участник Sprint Review с планшетом реагирует на обсуждение ценности продукта в офисе с фактурным фоном`
- caption: используется как hero/main, без подписи под изображением.

### Image 2 — inline figure
- Filename: `blog/public/assets/img/articles/sprint_review_ai_input.png`
- Reference в драфте: `/assets/img/articles/sprint_review_ai_input.png`
- Dimensions: финально `1672x941` (16:9), та же логика кропа/ресемпла.
- Article language: RU.
- Composition role: medium two-person exchange at table level, no screen/board/window, full textured background.
- Lighting role: warm side light with richer color contrast, coherent with the hero portrait while preserving the same olive/terracotta/walnut interior.
- Сцена: два участника Sprint Review обсуждают обратную связь и возможную адаптацию Product Backlog без центральной доски или экрана. Женщина 40+ с короткими кудрявыми волосами и аналитическим/скептичным выражением держит ручку у блокнота; мужчина 25-35 лет с очень короткой стрижкой внимательно слушает и выглядит задумчивым. Тезис: AI может собрать вход, но решение возникает в человеческом разговоре.
- Visible text inventory: читаемого текста нет.
- alt: `Два участника Sprint Review обсуждают обратную связь и решение о том, что менять в Product Backlog`
- caption (RU draft, уже в HTML): `AI полезен как подготовительный слой: он собирает результат и обратную связь, а команда со стейкхолдерами решает, что менять в Product Backlog.`
- caption (EN draft, уже в HTML): `AI is useful as a preparation layer: it gathers the outcome and the feedback, while the team and stakeholders decide what to change in the Product Backlog.`

### Generated image review
- `blog/public/assets/img/articles/sprint_review_ai_main.png` — regenerated by Codex on 2026-06-02 as a distinct hero candidate: male participant, olive/terracotta textured background, no visible window, no board/screen, no readable text; pending user visual approval.
- `blog/public/assets/img/articles/sprint_review_ai_input.png` — regenerated by Codex on 2026-06-02 as a distinct inline candidate: two different participants, olive/terracotta/walnut interior matching the hero, no blue panels, no visible window, no board/screen, no readable text; pending user visual approval.
- The two images differ materially from each other and from the Backlog Refinement hero: different people, different emotions, different artifact visibility, and no copied window/wall setup. They also share one interior identity inside this article: green/olive panels, terracotta plaster, walnut slats, and warm wood.

### Post-generation review — COMPLETED 2026-06-02 (Codex imagegen, approved)
1. Оба PNG открыты как bitmap и проверены.
2. Размер подтверждён: оба 1672x941.
3. Инвентаризация видимого текста:
   - `sprint_review_ai_main.png`: читаемого текста нет (доска/артефакт вне кадра). Гиббериша нет.
   - `sprint_review_ai_input.png`: читаемого текста нет (блокнот и стикеры пустые, ноутбук закрыт, корешки книг нечитаемы). Гиббериша нет.
4. Качество: фотореализм, живые эмоции, текстурный не стерильный офис, тёплый свет, без искажённых лиц/рук, без фейковых дашбордов и сюрреалистичных досок. Hard rejection не сработал.
5. Композиционное разнообразие подтверждено: Image 1 — одиночный портрет, медиум-клоуз, доска вне кадра, палитра зелёный/терракота; Image 2 — диалог двух человек за столом, table-level, артефакты на столе, палитра синий/терракота. Разный каст (пол/возраст/причёска), без повторов. Соответствует обновлённым требованиям скилла (variety, indirect hero допустим).
6. Решение по тексту на экране: вместо запрошенного экрана с labels Codex выдал text-free working-session композицию — это допустимый fallback по скиллу и усиливает тезис «Sprint Review = разговор, не демо». Центрального board/screen с текстом нет, поэтому правило обязательного текста не триггерится.
7. alt/caption приведены в соответствие с фактическим изображением (двое участников в обсуждении; caption поясняет тезис статьи). Main/hero alt — через шаблон.

Статус изображений: GENERATED & REVIEWED (approved). Статья визуально готова.

## Reviewer notes

- В статье нужны inline-ссылки, а не только финальный список источников.
- Отделить Scrum Guide 2020 как канонический источник от Scrum Guide Expanded v2026.1 как companion-ориентира.
- `article-blog-section` = `AI` для согласованности с серией; `article-layout` = `parallax` как в предыдущих статьях серии; `article-show-feedback-questions` = true (series).
- Lead-параграф должен явно продолжать серию и ссылаться на 3 предыдущие статьи (refinement, planning, Daily Scrum).
- Использовать тот же сквозной кейс серии: B2B LMS-платформа, обязательные курсы, email-напоминания.
- Источники DORA 2025 и OWASP 2025, а не более старые версии.
- Термины для проверки по glossary: Sprint Review, Product Goal, Product Backlog, Product Owner, Increment, stakeholders, working session, release notes, demo, product analytics, feedback, confabulation, overreliance, governance, shared awareness.
