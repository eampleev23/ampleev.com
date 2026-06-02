# Research brief: Sprint Retrospective и AI

Вопрос статьи: как AI меняет классическую Sprint Retrospective в Scrum?

Рабочий тезис: AI может удешевить подготовку к Sprint Retrospective, собрать сигналы из рабочих систем, напомнить о повторяющихся проблемах и помочь сформулировать проверяемые action items. Но он не должен подменять саму ретроспективу: честный разговор о взаимодействиях, процессе, инструментах, Definition of Done и качестве требует психологической безопасности, человеческого суждения и ответственности команды за изменения. Главный риск - превратить ретро в красивый список AI-рекомендаций, который никто не проживает и не доводит до действия.

## Проверенные факты

- Scrum Guide 2020 определяет Sprint Retrospective как событие для планирования способов повысить качество и эффективность. Scrum Team инспектирует последний Sprint относительно людей, взаимодействий, процессов, инструментов и Definition of Done; обсуждает, что прошло хорошо, какие проблемы возникли и как они были или не были решены; определяет наиболее полезные изменения, а самые значимые улучшения должны быть адресованы как можно скорее и могут попадать в Sprint Backlog следующего спринта. Источник: https://scrumguides.org/scrum-guide.html
- Scrum Guide 2020 связывает события Scrum с прозрачностью, инспекцией и адаптацией; inspection without adaptation is considered pointless. Это важно для ретроспективы: AI-анализ без реального изменения процесса не выполняет смысл события. Источник: https://scrumguides.org/scrum-guide.html
- Scrum.org в практических материалах повторяет ту же рамку: Sprint Retrospective - это место, где Scrum Team инспектирует и адаптирует рабочие практики, включая взаимодействие, impediments, Definition of Done и будущие improvements. Источник: https://www.scrum.org/resources/introduction-sprint-retrospective
- Scrum Guide Expanded v2026.1 / Scrum Guide Expansion Pack - companion/adaptation source на базе Scrum Guide 2020, а не новая каноническая версия Scrum Guide. Он прямо указывает версию v2026.1, дату обновления 2026-01-18 и статус adaptation of the original 2020 Scrum Guide. Источник: https://scrumexpansion.org/scrum-guide-expanded/
- Scrum Guide Expanded полезен как практический companion-ориентир: в Sprint Retrospective команда договаривается, как улучшаться; bad assumptions are explored; reflection is more effective in a psychologically safe environment; наиболее impactful improvements должны адресоваться как можно скорее, а Scrum depends on meaningful, continuous improvement follow-through. Источник: https://scrumexpansion.org/scrum-guide-expanded/
- В разделе Artificial Intelligence Scrum Guide Expanded описывает AI как supervised decision-making partner: AI может улучшать transparency, inspection и adaptation, но не заменяет human accountability, не должен override empirical process control и требует human in the loop. Источник: https://scrumexpansion.org/scrum-guide-expanded/
- Empirical Software Engineering case study Lehtinen, Itkonen & Lassenius (2017) анализировал 37 team-level retrospectives почти за 3 года. Важные выводы для статьи: ретроспективы часто обсуждают темы, близкие и controllable командой; обсуждения могут страдать participant bias и без hard evidence не всегда отражают reality; некоторые темы повторяются долго, потому что они естественно возвращаются или потому что команда не может решить их на своём уровне. Источник: https://link.springer.com/article/10.1007/s10664-016-9464-2
- Edmondson (1999) вводит team psychological safety как shared belief, что команда безопасна для interpersonal risk taking; исследование 51 work teams связывает psychological safety с learning behavior. Это классический источник для осторожного тезиса: ретроспектива требует условий, где люди могут говорить о проблемах без страха наказания. Источник: https://journals.sagepub.com/doi/10.2307/2666999
- NIST Generative AI Profile (July 2024) выделяет риски generative AI: confabulation, data privacy, human-AI configuration, overreliance, information integrity и bias/homogenization. Для Sprint Retrospective это релевантно, потому что AI может суммаризировать чаты, PR, инциденты и оценки настроения команды, а затем уверенно создавать выводы о людях, процессах и причинах проблем. Источник: https://nvlpubs.nist.gov/nistpubs/ai/NIST.AI.600-1.pdf
- OWASP Top 10 for LLM Applications 2025 включает sensitive information disclosure, excessive agency, misinformation и другие риски LLM-приложений. Это важно для ретроспектив, где AI получает доступ к внутренним сообщениям, issue tracker, review comments, incident notes и потенциально чувствительным оценкам людей. Источник: https://genai.owasp.org/llm-top-10/
- DORA State of AI-assisted Software Development 2025 описывает AI как amplifier existing strengths and weaknesses, а наибольшая отдача зависит не только от инструментов, а от underlying organizational system. Это поддерживает осторожную формулировку: AI усиливает зрелость ретроспективы или её слабости, но сам по себе не создаёт continuous improvement. Источник: https://dora.dev/dora-report-2025/
- EDPB Opinion 28/2024 относится к обработке персональных данных в контексте AI models; полезен как ориентир по legal basis и responsible AI, когда ретроспективные данные включают персональные сообщения, оценки и поведение сотрудников. Источник: https://www.edpb.europa.eu/our-work-tools/our-documents/opinion-board-art-64/opinion-282024-certain-data-protection-aspects_en
- ICO guidance / impact assessment on workplace monitoring reminds that monitoring workers interacts with data protection and requires attention to rights, transparency and proportionality. Для статьи это не юридическая инструкция, а практический сигнал: AI-retro не должен превращаться в скрытый мониторинг производительности. Источник: https://ico.org.uk/about-the-ico/research-reports-impact-and-evaluation/impact-and-evaluation/impact-assessment/monitoring-at-work-guidance-impact-assessment-october-2023/

## Поддержанные утверждения

- "Retrospective exists for quality and effectiveness, not for a pleasant summary" - сильно поддержано Scrum Guide 2020 и Scrum.org.
- "AI can help prepare inputs for inspection, but cannot create adaptation by itself" - поддержано Scrum Guide pillars и Scrum Guide Expanded AI framing as supervised partner with human accountability.
- "AI summaries may reduce participant bias by bringing hard evidence, but may also introduce model bias, homogenization and confabulation" - поддержано Lehtinen et al. on participant bias and NIST on GAI risks.
- "Retrospective requires psychological safety; people may stop speaking honestly if AI-retro data feels like performance monitoring" - supported by Edmondson, Scrum Guide Expanded psychological-safety note, ICO/EDPB privacy-monitoring concerns.
- "AI-generated action items should be treated as hypotheses / candidate improvements" - supported by Scrum empiricism, NIST risks and the lack of direct empirical evidence for AI-retrospectives.
- "The most useful AI-retro output is not a list of complaints but a small set of testable improvements with owner, evidence and next-sprint check" - practical interpretation grounded in Scrum Guide's most helpful changes and Lehtinen's corrective-action / recurrence analysis.

## Полезные интерпретации для статьи

- AI в ретро продолжает логику предыдущих частей серии: в refinement он готовил материал, в planning - варианты плана, в Daily Scrum - сигналы о ходе спринта, в Sprint Review - результат и обратную связь, в Sprint Retrospective - сигналы о процессе и кандидатные улучшения.
- Граница ретроспективы: AI может собрать факты до встречи, но не может заменить признание проблемы, конфликт, договорённость, изменение working agreements или принятие ответственности.
- Хороший AI-input для Retrospective должен группировать сигналы вокруг process, interactions, tools, Definition of Done, quality, flow и recurring patterns, а не вокруг персональной эффективности людей.
- Для B2B LMS кейса полезно показать: AI видит повторяющиеся задержки review, уточнения eligibility, поздние QA-данные, расхождения в Definition of Done и зависание PR. Но команда должна сама решить, что менять: DoD, working agreements, PR-size policy, test-data ownership, review cadence.
- Самая опасная версия AI-assisted Retrospective - автоматически сгенерированный "что улучшить" без живого обсуждения. Внешне зрелость, по сути - ещё один отчёт.

## Слабые / contested claims

- Нет сильной эмпирической базы именно по AI-assisted Sprint Retrospectives в реальных Scrum-командах. Нельзя утверждать, что AI доказанно улучшает качество ретроспектив, психологическую безопасность, скорость delivery или follow-through action items.
- Нельзя писать, что AI reliably detects root causes from Slack/Jira/Git. Он может подсветить кандидаты и противоречия, но root cause требует человеческой проверки.
- Нельзя обещать, что sentiment analysis корректно измеряет настроение команды. Для ретро это особенно рискованно: настроение - не метрика эффективности и не замена разговору.
- Не стоит делать юридическую инструкцию по GDPR/AI Act/worker monitoring. Privacy/governance источники использовать как ориентиры по прозрачности, минимизации данных и границам использования.

## Source gaps

- Мало независимых исследований 2024-2026 именно по AI-generated retrospective summaries, AI retrospective assistants и влиянию таких инструментов на action-item follow-through.
- Мало сравнений "ретро с AI-input" vs "ретро без AI-input" по outcomes вроде quality improvement, team learning, trust, psychological safety и reduction of recurring problems.
- Практические vendor claims по AI-retro tools использовать осторожно или не использовать как доказательства.

## Visual brief

- Article-specific interior seed: industrial product-team studio, deliberately different from the previous Sprint Review interior and from the earlier Nordic Retrospective regeneration. Matte charcoal microcement walls, black steel shelving, warm oak table, muted teal fabric acoustic panels, small plants, analog notebooks, slim warm practical lamps, soft side light from off-frame. Avoid the previous olive/terracotta/walnut lounge grammar and avoid making the team look like a corporate boardroom.
- Casting logic: Scrum/software-development team article, so people should read as plausible product/development-team participants in their 20s or early 30s with contemporary IT-team styling, not middle-aged executives or consultants. The hero centers a young rotating retro facilitator / backend developer; the inline figure shows a small diverse product/dev team.
- Main/hero image: indirect Retrospective scene. One emotionally alive participant listens to a difficult but constructive team conversation. No central board, no readable text. The image should communicate psychological safety, seriousness and human judgment, not automation. It must differ from recent series images: not a gray-haired white man with tablet, not the curly-haired woman/bald man two-person Sprint Review scene, not a wide team-around-board Daily Scrum shot, not the earlier East Asian woman in the olive/terracotta Retrospective draft, and not the middle-aged Black woman in the Nordic regeneration.
- Inline figure: same interior identity, table-level/over-the-shoulder scene where the team is looking at a small retrospective action board. The board should show that AI/helpful evidence has been translated into a few next-sprint action items, not a generic "mood summary".
- Regenerated assets saved:
  - `blog/public/assets/img/articles/sprint_retrospective_ai_main.png` - 1672x941. Hero/main image. Visible text: none. Approved: industrial product-team studio with charcoal microcement, black shelving, oak table, muted teal panels and warm practical light; young Latina / mixed-heritage product-development participant listens to an off-frame teammate; board/screen absent.
  - `blog/public/assets/img/articles/sprint_retrospective_ai_actions.png` - 1672x941. Inline figure. Visible text reviewed: `Sprint Retrospective`, `Facts`, `Patterns`, `Actions`, `Owner`, `Next Sprint`, `Reduce wait time`, `Clarify DoD`, `Smaller PRs`. No extra readable labels found. Approved: same industrial product-team studio interior family, plausible young product/dev team, action-board meaning is aligned with article.

## Draft constraints

- Working title: `Sprint Retrospective и AI: почему улучшения нельзя делегировать модели`
- Text URL: `sprint_retrospective_i_ai_pochemu_uluchsheniya_nelzya_delegirovat_modeli`
- Article section: `AI`
- Layout: `parallax`
- Main image mode: `static`
- Series feedback questions: true
- Terms for glossary: Sprint Retrospective, action items, psychological safety, root cause analysis, sentiment analysis, team dynamics, follow-through, working agreements, action owner, continuous improvement.
