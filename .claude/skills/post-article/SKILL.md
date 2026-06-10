---
name: post-article
description: Use in the Ampleev.com Laravel blog repo to plan, research, write, review, translate, create or select visual assets for, preview, and prepare publication of evidence-based RU/EN article drafts or article series in the author's style.
---

# Post Article

## Purpose

Use the existing Ampleev.com article workflow and editorial standard. Articles are evidence-based answers to a question, written first in Russian in the author's style, reviewed against real sources, then translated into high-quality English. Articles are HTML drafts in `blog/storage/drafts`, not Markdown posts and not a separate CMS. The Laravel app lives in `blog`.

Prefer the project commands and existing controllers over direct database edits:

- `blog/app/Console/Commands/MakeArticle.php`
- `blog/app/Console/Commands/MakeArticleEn.php`
- `blog/app/Console/Commands/PublishArticle.php`
- `blog/app/Console/Commands/SyncDrafts.php`
- `blog/app/Http/Controllers/DraftController.php`
- `ARTICLE_PUBLISHING_WORKFLOW.md`
- `publish-article-helper.sh`
- `blog/storage/article_series.md`
- `blog/storage/glossaries/ai_terms_ru.md`
- `blog/public/assets/img/articles`

Use these two production articles as the style and citation-format baseline:

- `https://ampleev.com/article_backlog_refinement_i_ai_chto_realno_menyaetsya`
- `https://ampleev.com/article_ai_assisted_sprint_planning_kak_uskorit_podgotovku_ne_poteryav_otvetstvennost`

## Editorial Intake

When the user asks to write an article or a series, start from the question the article(s) must answer.

Ask whether the user wants:

- one article answering the question;
- a new series answering a broader question through several decomposed questions;
- an article added to an existing series.

If the user chooses or may need a series, decompose the broad question together with the user. Planned series entries should be stored only as questions during planning; titles, slugs, and English titles are created through the author/reviewer process after research and drafting.

## Series Registry And Discovery

Start series lookup from `blog/storage/article_series.md`. This file is a fast local cache for article-series planning and should prevent slow broad production discovery on every run.

Production-published articles remain the source of truth. Browse production article pages and use sitemap/blog pages only when:

- the registry is missing;
- the registry looks stale or contradicts the user's request;
- the user asks for a fresh check;
- the agent is preparing a production publication update.

When production validation is needed, detect series from lead paragraphs, intro/outro text, cross-links, publication dates, and planned-question wording.

When presenting a series to the user, show:

- series question;
- published articles with title, production URL, and production publication date;
- draft articles with draft path and research path when known;
- planned article questions explicitly mentioned or implied by the published articles.

For the current AI/Scrum example, the discovered series question is: `Как AI меняет классические встречи кросс-функциональной команды разработки?`. Published examples include `Backlog Refinement и AI: что реально меняется` and `AI-assisted Sprint Planning: как ускорить подготовку, не потеряв ответственность`; planned questions include Daily Scrum, Sprint Review, Retrospective, and a final overview question.

Keep planned entries as questions only. Titles, slugs, English titles, images, and final source lists emerge during the author/reviewer workflow.

After each user-approved production publication, update `blog/storage/article_series.md`: move the article to published, add production URLs, add publication date, keep remaining planned questions current, and note any draft/research paths that still matter.

Do not invent hidden series metadata. If the registry or production text is ambiguous, tell the user what was inferred and ask for confirmation.

## Series Final Overview Articles

When a planned series entry is a final overview, итоговая обзорная статья, synthesis article, or asks the whole series question after several articles have already been published, treat it as a synthesis of the series, not as another standalone article.

Before drafting, build a synthesis map in the research brief:

- series question and final overview question;
- every published article in the series from `blog/storage/article_series.md`, with title, question, production URL, publication date, and matching research brief path when available;
- 3-5 key conclusions from each published article, each traced to that article's research brief, production article, or a cited primary source;
- recurring cross-series patterns: what AI changes across meetings, what it does not change, recurring benefits, recurring risks, recurring human-accountability boundaries, and meeting-specific differences;
- source status for each cross-series claim: reused from prior article, supported by a new cross-cutting source, or marked as interpretation;
- source gaps, contradictions, or claims that need new research before they can be used.

For final overview research, reuse the published articles and their research briefs as internal evidence. Do not rerun every article's research from scratch unless a source is missing, stale, contradicted, or needed for a new cross-cutting claim. Add fresh authoritative sources only for the broad synthesis question, updated AI context, Scrum-wide claims, or claims not already supported by the series.

The article itself must:

- answer the series question directly with a general conclusion;
- link to every previous article in the series when using its conclusions;
- avoid becoming a simple recap; synthesize patterns across events and explain the practical consequence for a cross-functional Scrum team;
- clearly separate "AI can change the preparation/signal/analysis layer" from "AI cannot take over Scrum accountability, inspection, adaptation, or the team's conversation";
- include a compact comparison table or structured summary when it helps show the pattern across Backlog Refinement, Sprint Planning, Daily Scrum, Sprint Review, and Sprint Retrospective;
- end with a concrete conclusion about how a team should adopt AI across Scrum events.

For final overview review, the Reviewer must check traceability: every broad conclusion must be grounded in a previous article's conclusion, that article's research brief, or a new authoritative source. Reject unsupported aggregation, accidental contradictions between articles, missing internal links to prior series articles, and any claim that overstates what the earlier research established.

## Research Standard

Before treating a draft as ready, prepare a research brief for the exact question being answered. Save it in the repo under `blog/storage/research/<text_url>.md` once the working `text_url` is known; use a temporary descriptive filename if research starts before the title is settled, then rename when the draft slug is stable.

Use the maximum practical number of official, authoritative, and directly or indirectly relevant sources:

- for AI topics, prefer sources from the last 24 months unless a classic source is needed for context;
- for Agile/Scrum topics, use the most current official source, such as the current Scrum Guide for Scrum questions, and include older material only when it explains history or a changed rule;
- for Scrum+AI topics, always consider the current Scrum Guide Expansion Pack / Scrum Guide Expanded as an optional companion source based on the 2020 Scrum Guide, while clearly distinguishing it from the canonical Scrum Guide rules;
- prefer official guides, standards, peer-reviewed papers, systematic reviews, recognized professional bodies, and primary documentation;
- use vendor or blog sources only when they are clearly relevant and identify them as less authoritative than standards or research.

The research brief must separate facts, source-backed claims, useful interpretations, weak/contested claims, and source gaps. Do not let the article make claims the research brief cannot support.

Match the citation style of the baseline articles: use inline HTML links inside the argument where the source matters, and end with an `<h4>Источники и ориентиры</h4>` section containing a `<ul>` of linked sources with short notes explaining why each source matters.

## Author And Reviewer

Use a soft two-role workflow. If subagents are available, run Author and Reviewer as separate workers. If not, explicitly perform both roles in sequence.

Reviewer responsibilities:

- build and maintain the research brief;
- verify factual claims and citation quality;
- reject unsupported or hallucinated claims;
- check that English terms are translated consistently with `blog/storage/glossaries/ai_terms_ru.md`;
- identify recurring new English terms, append glossary entries, and list them for user review;
- review selected or generated visuals for factual fit, style fit, readable text, correct dimensions, and immersion in the real process described by the article;
- critique Russian style against the two baseline articles;
- critique English translation quality.

Author responsibilities:

- write the Russian article in the author's practical first-person style;
- answer the chosen question directly and argumentatively;
- use concrete Agile/product/engineering/AI-in-work examples;
- keep the lead paragraph useful as standalone context;
- structure the article with short `<h4>` sections, occasional `blockquote.bg-primary-alt`, tables only when they clarify comparison, and a concrete conclusion;
- apply Reviewer corrections.

Run at least two Reviewer -> Author rounds for the Russian version. Continue until there are no critical findings, but stop and ask the user if more than four rounds are needed.

Critical findings are:

- factual error;
- unsupported source or weak source for an important claim;
- weak argumentation;
- mismatch with the author's style;
- inconsistent terminology;
- poor English translation.

After the Russian article passes review, create the English translation immediately. It must be idiomatic English, not literal sentence-by-sentence translation. Run the same Reviewer -> Author loop for the English version: at least two rounds, maximum four without asking the user.

## Visual Assets

Treat images as part of the article argument, not decoration. For every article, prepare a short visual brief after the article question and thesis are clear:

- what real process the image should immerse the reader in;
- what people, roles, age range, tools, room/context, emotions, and tension should be visible, including why this casting fits the article topic and how the central people differ from recent article images;
- whether the image is main image, hero image, or inline explanatory figure;
- the composition role of the image: close portrait, medium conversation, wide room, over-the-shoulder, detail shot, partial artifact, or another specific camera setup;
- the lighting role of the image: warm side light, daylight, soft backlight, screen glow, darker editorial hero, or another specific light setup;
- the article-specific interior seed: one coherent but newly chosen interior style, material palette, color family, and lighting grammar for all images in this article;
- whether a board/screen/artifact is central, partial, only an edge, off-frame, or absent;
- what meaningful board/screen text should appear in the image, if any, and exactly what that text must say.

Prefer visuals that feel like a real work process: living people, realistic facial expressions, believable workplace details, collaboration, uncertainty, discussion, artifacts on screens or boards, and concrete domain context. The strongest baseline is the `Backlog Refinement и AI` hero-background direction: one pleasant, emotionally alive participant in a textured environment, with the board or work artifact possibly outside the frame. The image does not need to literally show the whole meeting to carry the article. The `AI-assisted Sprint Planning` visual direction is acceptable too: credible office design and clean readable board text, but prefer more texture, warmth, and composition variety when generating new images.

Choose people by the article's actual domain, not as generic office models. The visual brief must state the intended age range and role logic. For Scrum/software-development team articles, default to plausible product/development-team participants in their 20s or early 30s, with contemporary IT-team styling and natural emotion; avoid making the whole team look like middle-aged executives, consultants, or a staged corporate boardroom unless the article is specifically about that audience. If the topic concerns leadership, legacy enterprise change, hiring, education, health care, or another domain, adjust the age range and appearance to that context and explain it in the brief.

For articles with more than one image, require deliberate visual variety. Do not create two images with nearly the same wide-room composition, the same team-around-a-central-board setup, the same camera height, and the same lighting. A coherent article image set should mix at least two of these dimensions:

- different scale: single-person close hero, two-person exchange, small cluster, wide room, hands/artifact detail;
- different artifact visibility: board absent, board edge only, screen partial, artifact central;
- different camera angle: side profile, over-the-shoulder, shallow-depth portrait, table-level view, wide environmental view;
- different light: darker editorial hero with texture, warm office side light, daylight, screen glow, or soft backlight.

Within one article, keep the images in the same interior world. They should feel like different moments or camera setups from one coherent workplace/session, not unrelated stock shots. Before generating, define an article-specific interior seed and reuse it across all images in that article: room style, materials, color family, background motifs, and lighting grammar. Vary people, emotion, scale, angle, and artifact visibility; do not vary the interior identity so much that the article looks assembled from different locations.

Across articles, do the opposite: choose a fresh interior seed each time. Do not let the previous article's interior become the default for the next article. If the last article used olive acoustic panels, terracotta plaster, walnut slats, and warm wood, the next article should deliberately use another well-designed interior direction. The new direction should still be in the spirit of the references: immersive, textured, modern, realistic, and human, but visually different.

Good interior seed examples include:

- high-tech textured office: matte graphite or champagne metal panels, warm microcement, ribbed glass used only as texture, slim linear lights, integrated acoustic surfaces, plants, and soft human light;
- industrial loft: brick, black steel, oak table, fabric panels, warm practical lamps;
- calm Nordic product room: pale wood, felt acoustic walls, muted green plants, soft daylight;
- biophilic studio: wood, moss/plant texture, clay wall, warm indirect light;
- editorial dark lounge: deep plaster, fabric panels, shelves, side light, no visible window.

Use these as variety patterns, not as fixed presets. Avoid defaulting to the same green/terracotta/walnut setup across articles.

The main/hero image may be indirect rather than literal: one person thinking, smiling, reacting, holding a notebook or tablet, looking toward an off-frame board, or sitting against a strong textured wall can be better than another full-team board shot. Inline images may be more literal when they need to show the artifact, screen, or board text. Across a series, avoid repeating the same hero grammar from article to article.

Before generating images, scan recent/baseline article images in `blog/public/assets/img/articles` and the current draft references. Do not reuse the same apparent person, hairstyle, clothing style, emotion, pose, age impression, background texture, background color palette, window/glass placement, or lighting grammar across different articles in the same series. Blog articles should feel useful to many different development teams, so the visual cast should change from article to article: different genders, ages, hairstyles, body language, emotional states, and work styles.

Use reference images as direction, not as a template to copy. If a reference works because it has a pleasant person and a textured background, keep the principle but vary the execution: a different person, different emotion, different texture, different colors, different light, and different framing. Do not copy a reference's exact wall, window, pose, or central subject. If the reference has no visible window and only implies window light, do not add a visible window unless the visual brief explicitly asks for one.

For new generated images, use a textured, well-designed environment by default: warm office lighting, wood/brick/acoustic panels/glass/plants/fabric textures, visible depth, and a non-sterile background. If the topic is not office/team work, translate this rule into the relevant domain: still use a real textured environment with human presence and credible emotion, not a flat or generic backdrop.

For hero/main images, prefer full-background texture when it strengthens the title overlay: textured plaster, painted concrete, wood, brick, acoustic panels, fabric walls, shelves, or plants can fill the frame. Visible windows or glass walls are optional, not default; avoid them when they make the image look like a copy of a previous hero or break the immersive textured background.

Avoid abstract AI imagery, decorative gradients, empty futuristic scenes, generic stock-photo posing, dark/blurred atmosphere, fake dashboards, uncanny hands/faces, surreal whiteboards, unreadable or distorted boards/screens, or visuals that do not reveal the actual subject of the article.

Select an existing image only when it already matches the article's process, style, and resolution. Otherwise generate a new bitmap image with the available image-generation capability. Do not ask the user for paid third-party/API image-generation keys, create `.imggen.env`, or call OpenAI/Gemini/Midjourney/etc. paid APIs unless the user explicitly approves that paid route for this article.

When running in Claude Code and no built-in/free image-generation tool is available, use the Codex handoff workflow instead of paid API generation:

1. Write a complete visual brief and final generation prompt for each required image.
2. Include target filename, desired dimensions, crop instructions, article language, exact visible board/screen text, negative constraints, alt text, and caption.
3. Ask the user to hand the prompts to Codex for generation with the built-in `imagegen` capability.
4. Mark images as `pending Codex generation` and do not claim the article is visually complete.
5. After the user or Codex places the generated images in `blog/public/assets/img/articles`, re-open and inspect the actual bitmap before final approval.

Suggested handoff prompt for Codex:

```text
Use $post-article.

Generate the pending article images from this visual brief. Use built-in Codex image generation only; do not use paid external API keys. Save finished images under blog/public/assets/img/articles, inspect the actual bitmap, list all visible text, and reject/regenerate anything with distorted text, surreal boards/screens, weak texture, or non-immersive stock-photo styling.
```

If image generation, image search, and Codex handoff are all unavailable, write the exact image prompt/brief into the work summary, mark the image as pending, and do not claim the article is visually complete. Place finished article images in `blog/public/assets/img/articles` and reference them as `/assets/img/articles/<file>`.

Resolution and format:

- Prefer 16:9 images around `1920x1080` for hero and inline process images.
- Existing acceptable examples include `1920x1080`, `1672x941`, and `1774x887`; avoid going below roughly `1600px` width for new main/hero images.
- Use a 3:2-ish image such as `1536x1024` only when it intentionally matches the article card/main-image treatment.
- Keep main, hero, and inline images visually coherent within one article and within a series.

Text in images:

- Meaningful readable text on boards/screens is preferred for any article image when it is appropriate to the question being answered and helps reveal the process, decision, tension, metric, artifact, or comparison in the article. A board/screen with no readable text is acceptable only if text would not add meaning or if the visual brief explicitly says the surface should stay text-free.
- If text is present, it must be legible, language-correct, and exactly reviewed against the article language. No gibberish, misspellings, broken Cyrillic, fake UI labels, or unverified claims in the image.
- Prefer short, article-relevant labels on boards/screens over dense paragraphs. For Scrum+AI articles, good examples are compact labels such as `Sprint Goal`, `AI signals`, `Blockers`, `Follow-ups`, `Risks`, `Decisions`, or their Russian equivalents when the image is for the Russian article.
- First try to generate or select an image where the required short text is already rendered correctly, as in the `AI-assisted Sprint Planning` baseline image. If repeated attempts fail, either choose a text-free composition where text is not needed, or use a clean board/screen plus post-processing as a fallback. Then inspect the final bitmap before using it.
- Treat any unreadable or surreal board/screen text as a hard rejection. Regenerate, select another image, or remove/replace the text-bearing image before the article is considered ready.
- Do not report "no readable text" as a success criterion when the image includes a central board/screen. Either add correct readable text or explain why the image intentionally has no text.
- Inventory all actually visible text in every selected/generated image, including extra labels the model added beyond the prompt. Record it in the visual brief or work summary, then either approve it as meaningful and harmless or regenerate/replace the image.
- Existing draft images are not grandfathered in. Re-review them against the same criteria; replace them if they fail.

For each image, add useful `alt` text and, for inline figures, a caption that explains the article point. The Reviewer must inspect the generated/selected image before the draft is considered ready.

## Glossary Updates

Use `blog/storage/glossaries/ai_terms_ru.md` while writing Russian articles. When new recurring English terms appear, append concise entries to this glossary in the existing numbered format and list the added entries in the work summary so the user can correct them if needed.

## Workflow

For a new Russian article after the editorial/research process is ready:

1. Work from `blog`.
2. Create the draft with `./php-docker artisan make:article "Заголовок статьи"`. Default the article layout to `parallax` (full-screen hero image header, as in the published AI/Scrum series articles): pass `--template=parallax` or set `article-layout` to `parallax` in the draft meta. Use `classic`/`basic-ru` or `image-header` only when the user asks or the content clearly needs another layout.
3. Edit `storage/drafts/<text_url>.html`.
4. Preview locally at `http://localhost:8000/drafts/<text_url>`. Preview syncs the draft into the local DB as `confirmed=0`.
5. Wait for the user to inspect the preview and explicitly approve publication before running local or production publish.
6. Ensure the draft HTML and any new images under `blog/public/assets/img` are included in git changes.
7. After deploy, a new article still needs production `php artisan publish <text_url>` because deploy `drafts:sync` updates only already published articles. Production `publish` can create the new RU article directly from the deployed draft file if the DB row does not exist yet.

For an existing published Russian article:

1. Edit the existing `blog/storage/drafts/<text_url>.html`, or create a draft from the existing article via `./php-docker artisan make:article "Current title"` if no draft exists.
2. Preserve the existing `text_url` for legacy URLs by keeping the filename stable.
3. Preview locally and, when useful, run `./php-docker artisan drafts:sync --only=<text_url> --dry-run`.
4. A normal deploy can sync changes to already published articles through `drafts:sync`.

For an English version after the Russian version has passed review:

1. Ensure the base Russian article exists.
2. Create the EN draft with `./php-docker artisan make:article-en <ru_text_url>`.
3. Edit `blog/storage/drafts/en/<ru_text_url>.html`.
4. Preview at `http://localhost:8000/en/drafts/<ru_text_url>`.
5. Wait for explicit user approval before publishing with `./php-docker artisan publish <ru_text_url> --lang=en`.
6. Remember that the EN public `text_url` is generated from the English `article-title`; the draft filename remains the Russian article `text_url`.

If Docker is not running, start it from `blog` with `docker compose up -d`. If Docker Desktop itself is down, ask the user before opening it.

## Production Publication Runbook

Use this only after explicit user approval to publish. Do not publish from this runbook while the user is still reviewing drafts.

Happy path:

1. Run local validation and local publish/checks from `blog`:
   - `./php-docker artisan publish <ru_text_url>`
   - `./php-docker artisan publish <ru_text_url> --lang=en`
   - `./php-docker artisan drafts:sync --only=<ru_text_url> --dry-run`
2. Commit and push only files for this article and its publication metadata: RU/EN draft HTML, article images, research brief, glossary additions, `blog/storage/article_series.md`, and approved homepage route changes. If unrelated dirty files exist, leave them untouched. If code fixes are needed, ask for explicit approval and preferably commit them separately.
3. Push the approved commit and wait for deploy to finish.
4. Verify the server is on the expected commit before production publish:
   - `ssh simplecloud 'cd /var/www/ampleev.com/blog && git rev-parse HEAD'`
   - If a different SSH alias/host is used, keep the same command shape with that host.
5. Never open production `/drafts/<text_url>` or `/en/drafts/<text_url>` as a validation step. Draft preview is local-only and production can correctly return 404.
6. Run production RU publish first:
   - `ssh simplecloud 'cd /var/www/ampleev.com/blog && php artisan publish <ru_text_url>'`
7. Run production EN publish only after RU publish succeeds:
   - `ssh simplecloud 'cd /var/www/ampleev.com/blog && php artisan publish <ru_text_url> --lang=en'`
8. Run production DB sanity checks for the published article and EN translation.
9. Run public HTTP checks for RU/EN article pages, feedback language/routes, and homepage redirects.
10. Update `blog/storage/article_series.md` with final production publication data if needed, then commit and push that registry update as a follow-up.

Production DB sanity checks must verify at least:

- RU article exists by `articles.text_url`;
- `confirmed=1`;
- `created_at` is set and matches the intended publication time/date closely enough;
- `show_feedback_questions=1` for series articles;
- `main_image_mode=static` unless the user explicitly requested zoom;
- expected `article_layout`;
- EN translation exists with `locale=en` and the expected EN `text_url`.

Public checks:

- RU public article URL renders RU feedback questions and the feedback form posts to `/article-feedback`.
- EN public article URL renders EN feedback questions and the feedback form posts to `/en/article-feedback`.
- Check `blog/routes/web.php` for the intended homepage redirects.
- Check `/en/` directly, the RU article URL directly, and the EN article URL directly.
- Do not treat a non-RU redirect from `/` as a failure by itself; geo, headers, cookies, or locale preference can legitimately send `/` to `/en/...`.

## Draft Contract

Every draft is a full HTML file with meta tags in `<head>` and two body containers.

Required or expected meta tags:

- `article-title`
- `article-seo-description`
- `article-blog-section` for Russian articles
- `article-user-id` for Russian articles
- `article-main-image-path`
- `article-hero-image-path` when using a hero layout; default to main image when unsure
- `article-main-image-mode` with `static` or `zoom`; prefer `static` for new drafts unless the user wants the main image clickable
- `article-layout` with `classic`, `image-header`, or `parallax`; default to `parallax` for new articles unless the user asks for another layout
- `article-html-title`

Required body blocks:

- `<div class="first-paragraph">` with the lead paragraph HTML
- `<div class="content">` with the main article HTML

For `publish <text_url>`, Russian articles require non-empty `title`, `seo_description`, `blog_section`, `user_id`, `main_image_path`, `html_title`, `first_paragraph`, and `content`. English publication requires non-empty `title`, `seo_description`, `main_image_path`, `html_title`, `first_paragraph`, and `content`.

Write article content as clean HTML, not Markdown. Use `/assets/img/...` paths for local images and place new images in `blog/public/assets/img`. Images inside article content zoom only when explicitly wrapped in a link with `data-fancybox`; `article-main-image-mode` controls only the main image.

## Series Feedback And Homepage

Every article shows the interestingness question: `Вам была интересна данная статья?`. Articles that are part of a series must also show the continuation question: `Вы ожидаете продолжения серии?`.

For a final overview article that closes a series, ask the user whether to keep the continuation question, replace it with another series-completion question if the app supports that, or hide the series-continuation feedback. Do not silently show `Вы ожидаете продолжения серии?` on a closing article if it conflicts with the article's ending.

Use the existing `show_feedback_questions` flag: set it to true for series articles and false for standalone articles unless the user asks otherwise. This should be part of the normal article workflow, not a separate question to the user. Verify the rendered article shows the expected feedback questions.

After the user approves publication, make the newly published article the homepage article each time by updating the existing root redirects in `blog/routes/web.php` for RU and EN as appropriate. Do not change homepage redirects before the user approves the final RU/EN drafts.

## Writing Style

For Russian posts, match only these two baseline articles unless the user provides another reference:

- `Backlog Refinement и AI: что реально меняется`
- `AI-assisted Sprint Planning: как ускорить подготовку, не потеряв ответственность`

Style characteristics:

- answer a clear question with an argued thesis;
- combine research-backed claims with practical first-person judgement;
- use concrete product/team examples rather than generic advice;
- compare "без AI" and "с AI" when useful;
- name risks, hidden costs, and human review explicitly;
- avoid hype, filler, and unsourced generalizations;
- keep terms consistent with the glossary;
- keep the lead paragraph useful on its own because it is displayed separately.

For English translations, preserve the Russian article's intent and examples, but write idiomatic English rather than literal sentence-by-sentence translation.

## Safety Checks

Before saying the article workflow is done:

- Verify the draft path and preview URL.
- Check all required meta tags and body blocks.
- Check image paths exist when images are added or changed.
- Verify article images match the visual brief, use the expected style, have acceptable dimensions, and are saved under `blog/public/assets/img/articles`.
- In Claude Code, verify that paid external image APIs were not used or requested unless the user explicitly approved that route; otherwise verify pending images have a Codex handoff prompt and are not described as complete.
- Verify new images use a textured, well-designed, non-sterile environment unless the article domain clearly requires a different real-world setting.
- Verify the visual brief defines article-appropriate casting: age range, roles, clothing/style, and emotion must fit the topic. For Scrum/software-development team articles, reject images where the people mostly read as middle-aged corporate executives instead of plausible IT/product-team participants in their 20s or early 30s, unless the article explicitly calls for that audience.
- Verify the visual brief defines an article-specific interior seed before generation.
- Verify all images inside one article share the same interior identity and broad material/color family. Reject image sets where images look like different offices or unrelated stock shots.
- Verify the article's interior seed is materially different from recent/baseline articles in the same series. Reject repeating the previous article's room palette/materials, such as reusing olive/terracotta/walnut just because it worked before.
- Verify new images do not repeat the apparent same person, hairstyle, clothing style, emotion, pose, background texture, background color palette, visible window/glass placement, or lighting grammar from recent/baseline images in the same series.
- Verify references were used directionally, not copied: a good reference should inspire quality, texture, and emotional credibility, while the new image varies person, emotion, texture, color, light, and framing.
- Verify multiple images in one article are not near-duplicates: they must differ materially in composition, camera distance/angle, artifact visibility, and/or lighting. Reject a set where every image is the same "team standing around a central board/screen" composition.
- Verify hero/main images are allowed to be indirect and composition-led. A strong hero can show one emotionally alive participant against a textured background with the board/screen off-frame or absent, when that creates a better article image than a literal full-meeting scene.
- Verify any visible text inside images is correct, legible, and free of generated nonsense.
- Verify central boards/screens have meaningful readable text when text would improve the article point; absence of text on a central board/screen requires an explicit rationale.
- Verify all actually visible image text, including model-added extras, was inventoried and accepted or the image was regenerated/replaced.
- Verify image `alt` text and captions are meaningful and language-appropriate.
- Verify the research brief exists and supports the article's factual claims.
- For a final overview article, verify the research brief contains a synthesis map of all published series articles, key conclusions, source status, recurring patterns, and source gaps.
- For a final overview article, verify every broad cross-series conclusion is traceable to prior series articles/research briefs or a new authoritative source, and verify the article links to every previous series article used in the synthesis.
- Verify the article has inline source links and the final `Источники и ориентиры` source list.
- Verify at least two Russian review rounds and at least two English review rounds were completed, or clearly state why this was impossible.
- Verify new glossary entries are listed for the user.
- Verify `blog/storage/article_series.md` was read for series lookup and updated after any approved production publication.
- Verify `show_feedback_questions` matches standalone vs series status.
- Verify homepage redirect changes are prepared only after user approval.
- After approved production publication, verify server HEAD, run RU publish before EN publish, run DB sanity checks, and run public RU/EN feedback-language checks.
- Avoid changing a published article's URL unless the user explicitly asks.
- Do not run local publish, production publish, delete drafts, delete comments, push to git, or update homepage redirects unless the user explicitly asked for that action or approved it.
- Mention when drafts are ready for user review and when publication is still pending.
