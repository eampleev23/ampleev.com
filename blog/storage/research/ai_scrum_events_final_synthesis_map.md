# Research brief: итоговая synthesis article серии AI + Scrum events

Вопрос серии: Как AI меняет классические встречи кросс-функциональной команды разработки?

Финальный обзорный вопрос: какой общий вывод следует из уже опубликованных статей серии про Backlog Refinement, Sprint Planning, Daily Scrum, Sprint Review и Sprint Retrospective?

Статус: synthesis map до написания полного RU-черновика. Требует подтверждения тезиса пользователем.

Дата подготовки: 2026-06-08.

## Опубликованные статьи серии

1. Backlog Refinement и AI: что реально меняется
   - Вопрос: Как AI меняет встречи по уточнению беклога в Scrum?
   - RU URL: https://ampleev.com/article_backlog_refinement_i_ai_chto_realno_menyaetsya
   - EN URL: https://ampleev.com/en/article_backlog_refinement_and_ai_what_really_changes
   - Published: 2026-03-26 12:54
   - Local draft: blog/storage/drafts/backlog_refinement_i_ai_chto_realno_menyaetsya.html
   - Research brief: not found in blog/storage/research; use published draft and cited sources.

2. AI-assisted Sprint Planning: как ускорить подготовку, не потеряв ответственность
   - Вопрос: Как AI меняет классическое планирование спринта в Scrum?
   - RU URL: https://ampleev.com/article_ai_assisted_sprint_planning_kak_uskorit_podgotovku_ne_poteryav_otvetstvennost
   - EN URL: https://ampleev.com/en/article_ai_assisted_sprint_planning_how_to_speed_up_preparation_without_losing_accountability
   - Published: 2026-05-15 13:42
   - Local draft: blog/storage/drafts/ai_assisted_sprint_planning_kak_uskorit_podgotovku_ne_poteryav_otvetstvennost.html
   - Research brief: not found in blog/storage/research; use published draft and cited sources.

3. Daily Scrum и AI: почему стендап не должен стать статус-ботом
   - Вопрос: Как AI меняет классический Daily Scrum в Scrum?
   - RU URL: https://ampleev.com/article_daily_scrum_i_ai_pochemu_stendap_ne_dolzhen_stat_status_botom
   - EN URL: https://ampleev.com/en/article_daily_scrum_and_ai_why_the_standup_should_not_become_a_status_bot
   - Published: 2026-06-02 15:31
   - Local draft: blog/storage/drafts/daily_scrum_i_ai_pochemu_stendap_ne_dolzhen_stat_status_botom.html
   - Research brief: blog/storage/research/daily_scrum_i_ai_pochemu_stendap_ne_dolzhen_stat_status_botom.md

4. Sprint Review и AI: почему демо не заменяет разговор о ценности
   - Вопрос: Как AI меняет классический Sprint Review в Scrum?
   - RU URL: https://ampleev.com/article_sprint_review_i_ai_pochemu_demo_ne_zamenyaet_razgovor_o_tsennosti
   - EN URL: https://ampleev.com/en/article_sprint_review_and_ai_why_a_demo_does_not_replace_the_conversation_about_value
   - Published: 2026-06-02 17:43
   - Local draft: blog/storage/drafts/sprint_review_i_ai_pochemu_demo_ne_zamenyaet_razgovor_o_tsennosti.html
   - Research brief: blog/storage/research/sprint_review_i_ai_pochemu_demo_ne_zamenyaet_razgovor_o_tsennosti.md

5. Sprint Retrospective и AI: почему улучшения нельзя делегировать модели
   - Вопрос: Как AI меняет классическую Sprint Retrospective в Scrum?
   - RU URL: https://ampleev.com/article_sprint_retrospective_i_ai_pochemu_uluchsheniya_nelzya_delegirovat_modeli
   - EN URL: https://ampleev.com/en/article_sprint_retrospective_and_ai_why_improvements_cannot_be_delegated_to_a_model
   - Published: 2026-06-02 20:53
   - Local draft: blog/storage/drafts/sprint_retrospective_i_ai_pochemu_uluchsheniya_nelzya_delegirovat_modeli.html
   - Research brief: blog/storage/research/sprint_retrospective_i_ai_pochemu_uluchsheniya_nelzya_delegirovat_modeli.md

## Выводы по статьям

### Backlog Refinement

- AI ускоряет не договоренность команды, а подготовку материала к ней: сбор контекста, черновик user story, acceptance criteria, риски, открытые вопросы и первичную декомпозицию. Опора: draft + Scrum Guide 2020, LLM-assisted requirements engineering sources.
- Главный риск: ложная ясность. Хорошо оформленный backlog item может выглядеть понятным, хотя продуктовые и технические пробелы остались. Опора: draft + NIST Generative AI Profile, factuality / summarization sources, automation bias.
- Высвобождаемое время не является чистой экономией. Появляется новая работа: подготовка данных, запросы, проверка источников, документирование решений, governance. Опора: draft + NIST GenAI Profile.
- AI-подготовка требует Definition of Ready / проверки фактов, гипотез, источников, доменных терминов, рисков и владельцев проверки. Опора: draft, практическая интерпретация.
- Human accountability: команда решает, готова ли задача к обсуждению и работе; AI-черновик остается сырьем. Опора: draft + Scrum Guide 2020.

### Sprint Planning

- AI снижает стоимость подготовки вариантов Sprint Goal, объема работ, зависимостей, декомпозиции, рисков и тестовых сценариев. Опора: draft + Scrum Guide 2020, NIST AI RMF / GenAI Profile, SE / effort estimation sources.
- Главная ловушка: ложная реалистичность плана. План может выглядеть связным и полным, но не быть проверенным на capacity, DoD, зависимости и реальные ограничения команды. Опора: draft + planning fallacy, automation bias, Agile effort estimation sources.
- AI может помогать выявлять неопределенность, но не должен становиться источником псевдоточной оценки. Опора: draft + Agile estimation reviews, GPT2SP replication report.
- Sprint Backlog становится настоящим только после явного принятия Разработчиками как своего плана. Опора: draft + Scrum Guide 2020.
- Human accountability: AI может ускорить проверку, но не выбрать Sprint Goal, объем и командное обязательство за людей. Опора: draft.

### Daily Scrum

- AI может уменьшить стоимость статусной коммуникации и заранее собрать сигналы из Jira/Git/CI/support/chats, но Daily Scrum остается инспекцией прогресса к Sprint Goal и адаптацией Sprint Backlog. Опора: research brief + draft + Scrum Guide 2020.
- Хороший AI-вход группируется вокруг Sprint Goal, blockers, risks, dependencies, decisions и follow-ups, а не вокруг персональной активности. Опора: research brief + Scrum Guide Expanded as companion.
- Главный риск: AI-generated status reporting. Стендап становится аккуратным отчетом, но команда теряет живую координацию и shared awareness. Опора: research brief + Scrum.org Daily Scrum is not a status meeting + NIST/OWASP risks.
- AI-summary не должен использоваться как proxy для performance management. Опора: research brief + EDPB / ICO workplace monitoring guidance.
- Human accountability: команда сама решает, что меняется в плане; AI только готовит вход и подсвечивает кандидаты-сигналы. Опора: draft.

### Sprint Review

- AI может удешевить подготовку Sprint Review: release notes, результат спринта, метрики, обратную связь, открытые продуктовые вопросы и кандидаты на изменения Product Backlog. Опора: research brief + draft + Scrum Guide 2020.
- Sprint Review ценен не демо, а совместной инспекцией результата, обратной связью стейкхолдеров и адаптацией Product Backlog. Опора: research brief + Scrum Guide 2020 + Scrum.org Sprint Review sources.
- Главный риск: AI-polished demo / demo theater. Красивое резюме может имитировать согласие и стереть противоречивую обратную связь. Опора: research brief + NIST GenAI Profile / OWASP misinformation.
- AI-generated insights о пользователях нужно считать гипотезами до проверки первоисточников. Опора: research brief + NIST confabulation / information integrity.
- Human accountability: Product Owner, Scrum Team и stakeholders принимают продуктовые решения; AI не адаптирует Product Backlog вместо них. Опора: draft + Scrum Guide / Scrum Guide Expanded companion.

### Sprint Retrospective

- AI может принести hard evidence в ретро: повторяющиеся impediments, ожидание review, невыполненные action items, расхождения с Definition of Done, recurring patterns. Опора: research brief + draft + Lehtinen et al.
- Retrospective существует для повышения качества и эффективности, а не для красивого summary. Инспекция без адаптации не выполняет смысл события. Опора: research brief + Scrum Guide 2020 / Scrum.org.
- Главный риск: AI-generated improvement list без психологической безопасности, признания проблемы, owner и follow-through. Опора: research brief + Edmondson psychological safety + Scrum Guide Expanded companion.
- AI должен анализировать work and system, not people; иначе ретро превращается в employee monitoring и разрушает честность разговора. Опора: research brief + ICO / EDPB + NIST / OWASP.
- Human accountability: команда сама выбирает небольшие улучшения, берет owner, проверяет эффект в следующем спринте и меняет поведение. Опора: draft.

## Сквозные паттерны

### Что AI меняет

- Удешевляет подготовительный слой: поиск, суммаризация, структурирование, предварительная декомпозиция, списки рисков, вопросы, протоколы.
- Делает вход во встречу богаче: больше фактов, сигналов, вариантов и противоречий можно принести до начала разговора.
- Смещает ценность встречи: меньше ручного восстановления контекста, больше проверки смысла, ограничений, рисков и решений.
- Повышает потребность в traceability: факты, гипотезы и интерпретации модели надо разделять.
- Делает governance частью командной практики: какие данные можно использовать, кто проверяет output, где human override, что нельзя использовать для performance management.

Source status: supported by all five articles; broad formulation also should be backed by Scrum Guide 2020, NIST AI RMF 1.0 / GenAI Profile, OWASP Top 10 for LLM Applications 2025 and DORA 2025 in final article.

### Что AI не меняет

- Не меняет назначение Scrum events: inspection, adaptation, transparency, Product/Sprint Goal focus, team learning and accountability.
- Не создает командное согласие, shared awareness, psychological safety, stakeholder feedback или commitment сам по себе.
- Не несет accountability за Product Backlog, Sprint Goal, Sprint Backlog, adaptation plan, Product decisions, working agreements или improvements.
- Не превращает черновик в истину: AI output остается материалом для проверки.

Source status: supported by Scrum Guide 2020 in all articles; Scrum Guide Expanded only as companion source.

### Повторяющиеся выгоды

- Быстрее собрать контекст и вывести команду на более предметный разговор.
- Раньше увидеть зависимости, риски, пропуски, stale work, feedback signals и recurring patterns.
- Лучше фиксировать решения, open questions, assumptions, owners and follow-ups.
- Освободить внимание людей от рутинного пересказа фактов для решений, компромиссов и проверки.

Source status: supported by all five articles as practical interpretation; not enough direct empirical evidence to claim universal outcome improvement.

### Повторяющиеся риски

- Ложная ясность: красивый backlog item выглядит понятным.
- Ложная реалистичность: красивый Sprint Plan выглядит выполнимым.
- AI-generated status reporting: Daily Scrum становится отчетом.
- AI-polished demo: Sprint Review становится presentation theater.
- AI-generated improvements: Retrospective становится списком рекомендаций без изменения поведения.
- Overreliance, confabulation, misinformation, information integrity, data privacy, excessive agency, hidden monitoring.

Source status: strongly supported as risks by prior articles + NIST / OWASP / Scrum.org; do not phrase as proven inevitability.

### Где остается человеческая ответственность

- PO / stakeholders: value, Product Goal, Product Backlog adaptation, product trade-offs.
- Developers: Sprint Backlog as their plan, technical feasibility, DoD, testability, adaptation of work.
- Scrum Master: protect events from degraded formats, keep focus on inspection/adaptation, enable psychological safety and follow-through.
- QA / UX / Engineering roles: validate failure modes, user experience, architecture, data, evidence and human consequences.
- Whole Scrum Team: decide what is true, what is risky, what to change, and how to check the effect.

Source status: supported by role sections across published articles and Scrum Guide 2020 accountabilities.

### Meeting-specific differences

- Backlog Refinement: AI prepares understanding of future work; risk is false clarity.
- Sprint Planning: AI prepares plan options; risk is false realism and pseudo-precision.
- Daily Scrum: AI prepares sprint signals; risk is status bot / surveillance.
- Sprint Review: AI prepares outcome + feedback; risk is polished demo and fake alignment.
- Sprint Retrospective: AI prepares process evidence + follow-through support; risk is delegated improvement / monitoring people.

Source status: direct synthesis from article conclusions.

## Source gaps before full draft

- Need a current authoritative cross-cutting Scrum source for the whole series conclusion. Use Scrum Guide 2020 as canonical; use Scrum Guide Expanded v2026.1 only as companion and explicitly state that.
- Need a cross-cutting AI governance source for broad claims about overreliance, confabulation, privacy, human oversight and accountability. Use NIST AI RMF 1.0 and NIST Generative AI Profile; OWASP 2025 for LLM application risks.
- Need current broad software-delivery / AI adoption source. Use DORA 2025 for cautious framing: AI amplifies existing organizational practices rather than guaranteeing delivery improvement.
- Need avoid claiming direct empirical proof that AI improves Scrum events. Existing briefs explicitly say direct evidence for AI-assisted Daily / Review / Retrospective is limited.
- For Backlog Refinement and Sprint Planning, no separate research brief was found. Final article can use published drafts and cited sources, but reviewer should either accept this as internal evidence or reconstruct short source notes from their source lists.

## Proposed thesis

AI does not replace Scrum events. It changes the cost structure around them: preparation, summarization, signal detection and documentation become cheaper, but the scarce and valuable part becomes more human, not less human. Across Scrum events, AI should be treated as a supervised preparation and inspection layer. The team still owns meaning, trade-offs, accountability, adaptation and follow-through.

RU article thesis draft:

AI меняет классические встречи Scrum не тем, что забирает их у команды, а тем, что переносит часть ручной подготовки в AI-слой. Команда быстрее приходит к фактам, вариантам, рискам и сигналам. Но именно поэтому сильнее возрастает цена человеческой части: проверить смысл, принять компромисс, договориться об ответственности, адаптировать backlog или план и довести изменение до действия. Если AI используется зрело, Scrum events становятся меньше похожи на ритуальный пересказ статусов и больше похожи на короткие сессии инспекции и адаптации. Если незрело, AI просто ускоряет старые анти-паттерны: ложную ясность, ложную реалистичность, статусную отчетность, демо-театр и ретро без реального улучшения.

## Feedback question recommendation

Current series-question behavior: series articles show both "Вам была интересна данная статья?" and "Вы ожидаете продолжения серии?".

For final overview article, "Вы ожидаете продолжения серии?" conflicts with closing the series. Recommended editorial choice: replace with a completion-oriented question if the app supports custom feedback text, for example "Был ли полезен итоговый обзор серии?" or "Помогла ли серия понять, где AI действительно полезен в Scrum events?". If the app only supports the existing boolean series-continuation flag, hide the continuation question on the final overview and keep only the interestingness question.

Technical status checked 2026-06-08:
- `ArticleFeedbackAnswer::questions()` has only two hardcoded questions: interesting and continuation.
- `feedback_questions.blade.php` uses `show_feedback_questions=false` to keep only the interestingness question.
- There is no custom per-article completion question without a code/model change.
- Draft decision after user approved direction: set `article-show-feedback-questions=false` for the final overview, so the article keeps only "Вам была интересна данная статья?" and does not ask "Вы ожидаете продолжения серии?".

## Visual brief

Status: generated, saved and reviewed.

Main/hero image direction:
- Filename: `blog/public/assets/img/articles/ai_scrum_events_final_overview_main.png`
- Target: 16:9, around 1920x1080 or at least 1600px wide.
- Article role: main + hero image.
- Scene: realistic editorial image for the final synthesis article about AI and Scrum events. One emotionally alive product/development team participant in their early 30s, contemporary casual IT styling, sits at a warm table with notebook and laptop, looking toward an off-frame team board while considering a difficult trade-off.
- Interior seed: pale birch acoustic wall panels, matte champagne metal details, soft off-frame daylight, translucent polycarbonate dividers as texture, a few plants, warm practical lights. Must be distinct from earlier series images: no olive/terracotta/walnut lounge, no charcoal/teal industrial studio, no wide team-around-board Daily composition, no gray-haired Sprint Review portrait.
- Artifact/text: board/screen may be edge-only or blurred; no readable text required. If text appears, it must be inventoried and rejected unless correct and meaningful.
- Negative constraints: no abstract AI imagery, robots, glowing brains, futuristic dashboards, generic stock posing, decorative gradients, visible large glass-wall office, distorted hands/faces, gibberish, fake UI.
- Alt text: `Участник команды разработки осмысляет AI-сигналы перед обсуждением Scrum events`.

Generation prompt used:

```text
Create a realistic editorial 16:9 hero image for a Russian article about how AI changes Scrum events for a cross-functional software development team. Scene: a modern product-team workspace during a quiet synthesis discussion after a sprint, not a staged corporate boardroom. One emotionally alive participant in their early 30s, plausible product/development team member, contemporary casual IT styling, sits at a warm table with a notebook and laptop, looking toward an off-frame team board as if considering a difficult trade-off. Background: fresh interior seed distinct from prior images: pale birch acoustic wall panels, matte champagne metal details, soft off-frame daylight, translucent polycarbonate dividers used only as texture, a few plants, warm practical lights, no visible large window, no olive/terracotta/walnut lounge, no charcoal/teal industrial studio, no blue corporate panels. Board or screen only partially visible at the edge or blurred, no readable text. Mood: thoughtful, human, practical, real teamwork, not futuristic. No abstract AI imagery, no robots, no glowing brains, no generic stock posing, no fake dashboards, no unreadable text, no distorted hands or faces, no surreal boards, no decorative gradients. Target filename concept: ai_scrum_events_final_overview_main.png. Alt text concept: Участник команды разработки осмысляет AI-сигналы перед обсуждением Scrum events.
```

Generated asset:
- Source generated image: `/Users/eampleev/.codex/generated_images/019ea7cc-e090-7000-8e3e-0af710d1c96c/ig_0438b61b52596eaa016a26e9407bb48191b4d71892f84e6403.png`
- Article asset: `blog/public/assets/img/articles/ai_scrum_events_final_overview_main.png`
- Dimensions: 1672x941, PNG, RGB, 16:9-ish.

Post-generation review:
- Visible text inventory: no readable text. Board / sticky notes are blurred or edge-only; no gibberish found.
- People and setting: one plausible product/development-team participant in early 30s, casual IT styling, thoughtful expression.
- Interior identity: pale ribbed glass / birch-acoustic texture, champagne/warm panels, plants and warm lights; distinct from Sprint Review olive/terracotta/walnut and Retrospective charcoal/teal industrial interior.
- Hard rejections checked: no abstract AI, no robot/futuristic dashboard, no distorted hands/faces, no surreal board, no fake UI.
- Status: approved for draft visual use.

Face replacement update 2026-06-08:
- User provided face reference: `/Users/eampleev/Downloads/IMG_4509.HEIC`; converted temporary PNG for inspection: `/private/tmp/IMG_4509_face_source.png`.
- A first local PIL composite candidate was rejected as too collage-like: `blog/public/assets/img/articles/ai_scrum_events_final_overview_main_face_candidate.png`.
- Built-in imagegen produced a more natural face replacement: `/Users/eampleev/.codex/generated_images/019ea7cc-e090-7000-8e3e-0af710d1c96c/ig_0438b61b52596eaa016a26ef3c8af081918dd43a7b2b615c4f.png`.
- Accepted candidate copied to `blog/public/assets/img/articles/ai_scrum_events_final_overview_main_face_candidate_gen.png`.
- Original generated hero backed up to `blog/public/assets/img/articles/ai_scrum_events_final_overview_main_original.png`.
- Main article image path `blog/public/assets/img/articles/ai_scrum_events_final_overview_main.png` now contains the face-replaced version, so RU/EN drafts continue to reference the same image path.
- Post-replacement review: 1672x941 PNG, realistic integration, base composition preserved, no readable text/gibberish, no obvious face/hands distortions on visual inspection.

Head/laptop refinement update 2026-06-08:
- User requested the head to be about 10% smaller and the laptop to be the latest MacBook Pro.
- Current face-replaced version backed up to `blog/public/assets/img/articles/ai_scrum_events_final_overview_main_face_large_backup.png`.
- Built-in imagegen produced updated asset: `/Users/eampleev/.codex/generated_images/019ea7cc-e090-7000-8e3e-0af710d1c96c/ig_0438b61b52596eaa016a26fbcb362c81919ef4b0a51ad36a63.png`.
- Updated version copied to `blog/public/assets/img/articles/ai_scrum_events_final_overview_main.png` and resized to 1672x941.
- Visual check: head is smaller and better proportioned, laptop reads as dark modern MacBook Pro with Apple mark, body pose / interior / board composition preserved, no readable text/gibberish, no obvious face/hands/laptop distortion on visual inspection.

## RU reviewer / author rounds

### Round 1 reviewer

Critical:
- Main image file is missing. Draft references `/assets/img/articles/ai_scrum_events_final_overview_main.png`, but the file does not exist. Visual status must remain pending.

Non-critical:
- Text links to every prior article in the lead, synthesis body and sources list.
- Broad cross-series claims are traceable to the synthesis map and prior articles.
- The article explicitly avoids claiming that AI is proven to improve Scrum events.
- Feedback behavior is technically checked and set to hide the continuation question.
- New glossary entries needed for recurring terms: Scrum Events, supervised decision-making partner, empirical process control, traceability, human override.

### Round 1 author changes

- Added glossary entries 183-187.
- Added technical feedback decision to this brief.
- Added visual brief and marked hero image as pending local generation / placement.

### Round 2 reviewer

Critical:
- Preview initially returned HTTP 500 because `article-seo-description` exceeded the database column limit.

Non-critical:
- Image generation produced a suitable 1672x941 PNG after local file discovery.
- Draft preview should verify `article-show-feedback-questions=false` behavior: only interestingness question should render.
- Need ensure no publication, commit, push or homepage change was performed.

### Round 2 author changes

- Shortened `article-seo-description` to fit the local DB limit.
- Copied generated image into `blog/public/assets/img/articles/ai_scrum_events_final_overview_main.png`.
- Preview check: `http://localhost:8000/drafts/ai_i_scrum_events_chto_realno_menyaetsya_vo_vstrechah_komandy_razrabotki` returned HTTP 200.
- Rendered feedback check: only `Вам была интересна данная статья?` appears; `Вы ожидаете продолжения серии?` does not appear.
- No publication, commit, push or homepage redirect update performed.

## EN reviewer / author rounds

### EN round 1 reviewer

Critical: none.

Non-critical:
- EN draft is idiomatic rather than sentence-by-sentence literal translation.
- EN draft links to every previous EN article in the series in the lead, synthesis body and sources list.
- English source list uses `Sources and reference points`.
- Broad claims retain the same caveats as RU: no claim that AI is proven to improve Scrum Events.

### EN round 1 author changes

- Created EN draft at `blog/storage/drafts/en/ai_i_scrum_events_chto_realno_menyaetsya_vo_vstrechah_komandy_razrabotki.html`.
- Used English title: `AI and Scrum Events: What Really Changes in Development Team Meetings`.
- Reused the approved generated hero image.

### EN round 2 reviewer

Critical: none.

Checks:
- EN preview returned HTTP 200 at `http://localhost:8000/en/drafts/ai_i_scrum_events_chto_realno_menyaetsya_vo_vstrechah_komandy_razrabotki`.
- Rendered feedback check: only `Was this article interesting to you?` appears; `Are you looking forward to the next part of the series?` does not appear.
- EN article image renders from `/assets/img/articles/ai_scrum_events_final_overview_main.png`.

### EN round 2 author changes

- No text changes needed after preview checks.
- No publication, commit, push or homepage redirect update performed.
