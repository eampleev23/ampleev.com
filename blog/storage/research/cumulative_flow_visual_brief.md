# Visual Brief: Практика применения Cumulative Flow в контексте Scrum и SAFe (parallax hero, замена legacy-изображения)

Статус: regenerated and reviewed by Codex on 2026-06-12 after metaphor correction. Файл: `blog/public/assets/img/articles/cumulative_flow_scrum_safe_main.png`, 1920x1080 (16:9), фотореализм + графический оверлей. Layout — parallax: заголовок почти по центру (чуть ниже и левее), поэтому центр и центр-лево не должны содержать мелкий текст или ключевые детали.

## Исправление направления

Предыдущая версия с indoor rowing tank была отклонена: она передавала идею синхронного потока, но теряла исходную метафору Cumulative Flow как слоёв пород/земли. Новая версия возвращает именно эту метафору: диаграммные области читаются как геологические пласты на срезе земли, а горы на фоне поддерживают связь с legacy-изображением `article-6_my.jpg`.

## Связь с оригиналом (article-6_my.jpg)

Оригинал: пейзаж с озером и горами, поверх — полупрозрачные диагональные цветные области, отсылающие к слоям Cumulative Flow Diagram. Сохраняем приём «природный пейзаж + диаграммные пласты», но усиливаем метафору: в кадре должен быть видимый срез земли/склона с натуральными геологическими слоями, а CFD-области должны ложиться как полупрозрачные пласты пород.

## Пространство

Широкий горный пейзаж: дальняя горная гряда, озеро или долина на фоне, небо с мягкими облаками, тёплый естественный свет. На переднем плане или справа — открытый срез склона/обрыва с читаемыми горизонтально-волнистыми слоями почвы и пород. Не офис, не спортивный зал, не абстрактная диаграмма.

## Люди

Людей в кадре нет. Для этой статьи hero должен работать как метафора накопления слоёв и состояния потока, а не как сцена командного взаимодействия.

## Оверлей: полосы CFD как геологические пласты

Поверх среза земли — четыре полупрозрачные плавные области, наложенные как слои пород/земли. Они могут слегка продолжаться по пейзажу в духе legacy-изображения, но должны прежде всего читаться как strata, а не как абстрактные широкие плашки. Цвета спокойные: зелёный, бирюзовый, синий, приглушённый фиолетово-серый. Прозрачность около 20-30%, мягкие границы, тонкие светлые разделители как границы пластов.

## Текст (легенда стадий)

Компактная легенда в верхнем правом углу, ровно четыре подписи с цветовыми маркерами:
- `Бэклог`
- `В работе`
- `Ревью`
- `Готово`

Кириллица должна быть идеально читаемой. Больше никакого текста в кадре.

## Зона заголовка

Центр и центр-лево: небо, горы, озеро/долина и мягкий пейзаж без мелкого текста. Полупрозрачные слои допустимы, если они не забивают title-safe zone плотным цветом.

## Negative constraints

Без гребцов, indoor rowing tank, спортивного комплекса, офиса, людей, sci-fi, неона, логотипов, fake UI, искажённого текста, стоковой постановки, плотной заливки в центре. Не превращать картинку в чистую инфографику: база должна оставаться фотореалистичным природным пейзажем.

## Alt

- RU: «Горный пейзаж со срезом земли, где области Cumulative Flow выглядят как полупрозрачные геологические пласты»
- EN: "A mountain landscape with an exposed earth cross-section, where Cumulative Flow areas appear as translucent geological strata"

## Результат проверки

Финальный PNG собран из Codex-generated photorealistic mountain/earth-strata base image и локального графического overlay. Видимый текст в изображении: `Бэклог`, `В работе`, `Ревью`, `Готово`. В кадре есть горы на фоне, озеро/долина, видимый срез земли с натуральными слоями, а цветные CFD-области наложены как полупрозрачные пласты пород. Логотипов и лишнего текста нет.

## Промпт для генерации базы (Codex)

```text
Use case: photorealistic-natural
Asset type: 16:9 parallax hero base image for an article about Cumulative Flow in Scrum and SAFe; local graphic overlay will be added afterward.
Primary request: restore the original metaphor: Cumulative Flow areas should feel like geological strata, layers of rock and soil in the earth, with mountains in the background.
Scene/backdrop: wide photorealistic mountain landscape at golden-hour daylight, distant mountain range and soft clouds, a calm lake or broad valley in the far background, natural atmosphere, not a city and not an office. In the foreground and lower-right/lower-middle, show an exposed cutaway slope or cliff face with clearly visible natural sedimentary rock layers, like strata in the earth. The strata should be broad, smooth, layered, and readable as geological bands, leaving room for a later semi-transparent CFD color overlay.
Composition/framing: 16:9 editorial hero, panoramic view. Keep the center and center-left calm and open for a parallax title overlay, with sky, distant mountains, or soft atmospheric space there. Stronger geological stratification belongs in the lower third and right side. Upper-right corner should remain clean enough for a small legend overlay. No people.
Lighting/mood: natural cinematic daylight, warm but not orange-heavy, realistic landscape photography, textured but calm.
Color palette: natural mountain colors, muted earth tones, rock beige/gray/ochre, soft sky blues, restrained greens. The base image itself should not contain bright artificial diagram colors; those will be added later.
Text: no text anywhere in the image.
Constraints: photorealistic landscape; distant mountains visible; exposed geological strata visible as layered earth; central title-safe zone open; no labels, no logos, no watermarks, no people, no buildings, no UI.
Avoid: indoor sports facility, rowing, office, sci-fi, neon, abstract gradients, fake charts, text, signage, crowded details in the center, dark unreadable foreground.
```
