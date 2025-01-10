<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Диаграммы сгорания(Burn Down Charts) в контексте SAFe')
@section('description', 'В этой статье я постараюсь рассказать о своем опыте применения диаграмм сгорания (Burn Down Charts). ')
@section('page_url', 'blog-article')

@section('custom_css')
    @parent
@endsection

@section('sidebar')
    @parent
    {{--    <p>This is appended to the master sidebar.</p>--}}
@endsection

@section('content')

    <div class="navbar-container ">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand fade-page" href="{{route('blog.home')}}">
                    <span>Амплеев Евгений | Блог</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <img class="icon navbar-toggler-open" src="assets/img/icons/interface/menu.svg"
                         alt="menu interface icon" data-inject-svg/>
                    <img class="icon navbar-toggler-close" src="assets/img/icons/interface/cross.svg"
                         alt="cross interface icon" data-inject-svg/>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    <div class="py-2 py-lg-0">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown-grid"
                                   aria-expanded="false" aria-haspopup="true">Обо мне</a>
                                <div class="dropdown-menu row">
                                    <div class="col-auto" data-dropdown-content>
                                        <div class="dropdown-grid-menu"><a href="home-course.html"
                                                                           class="dropdown-item fade-page">Course</a><a
                                                href="home-coworking.html"
                                                class="dropdown-item fade-page">Coworking<span
                                                    class="badge badge-primary ml-2">New</span></a><a
                                                href="home-cryptocurrency.html" class="dropdown-item fade-page">Cryptocurrency</a>
                                            <a
                                                href="home-desktop-app.html" class="dropdown-item fade-page">Desktop
                                                App</a><a href="home-event.html"
                                                          class="dropdown-item fade-page">Event</a><a
                                                href="home-mobile-app.html" class="dropdown-item fade-page">Mobile
                                                App</a><a href="home-portfolio.html" class="dropdown-item fade-page">Portfolio</a>
                                            <a
                                                href="home-saas.html" class="dropdown-item fade-page">SaaS</a><a
                                                href="home-saas-trend.html" class="dropdown-item fade-page">SaaS -
                                                Trend</a><a href="home-software-library.html"
                                                            class="dropdown-item fade-page">Software Library</a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <a href="#" class="btn btn-primary ml-lg-3">Авторизоваться</a>

                </div>
            </div>
        </nav>
    </div>

    <div class="article-progress" data-sticky="below-nav">
        <progress class="reading-position" value="0"></progress>
        <div class="article-progress-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <div class="text-small text-muted mr-1">Читаете:</div>
                                <div class="text-small">Диаграммы сгорания в контексте SAFe</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="text-small text-muted">Поделиться:</span>
                                <div class="d-flex ml-1">
                                    <a href="https://twitter.com/intent/tweet?text=Диаграммы%20сгорания%20в%20контексте%20SAFe%20-%20https://www.ampleev.com/blog-article&hashtags=#agile#SAFe#burndowncharts"
                                       class="mx-1 btn btn-sm btn-round btn-primary">
                                        <img class="icon" src="assets/img/icons/social/twitter.svg"
                                             alt="twitter social icon" data-inject-svg/>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.ampleev.com/blog-article&display=popup"
                                       class="mx-1 btn btn-sm btn-round btn-primary">
                                        <img class="icon" src="assets/img/icons/social/facebook.svg"
                                             alt="facebook social icon" data-inject-svg/>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="pb-0 pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Блог</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">Agile</a>
                                </li>
                            </ol>
                        </nav>
                        <span class="badge bg-primary-alt text-primary">
                <img class="icon bg-primary" src="assets/img/icons/interface/heart.svg" alt="heart interface icon"
                     data-inject-svg/>21</span>
                    </div>
                    <h1>Диаграммы сгорания в контексте SAFe</h1>
                    <div class="d-flex align-items-center">
                        <a href="#">
                            <img src="assets/img/avatars/female-3_my.jpg" alt="Avatar" class="avatar mr-2">
                        </a>
                        <div>
                            <div>Автор статьи: <a href="#">Амплеев Евгений</a>
                            </div>
                            <div class="text-small text-muted">30 Октября</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="p-0" data-reading-position>
        <div class="container">
            <div class="row justify-content-center position-relative">
                <p class="lead"> После публикации среди друзей <a
                        href="https://ampleev.com/article_praktika_primenenia_burn_down_charts_v_kontekste_safe_i_scrum">первой
                        статьи о Burn Down Chart</a>, в комментариях первый вопрос, который был задан: "Было бы
                    интересно узнать подробнее про ваш опыт с SAFe". Поэтому, в этой статье я постараюсь раскрыть
                    специфику работы в SAFe относительно Scrum на нашей практике. Я точно не претендую на истину в
                    первой инстанции и буду рад любым исправлениям и уточнениям со стороны коллег. </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <article class="article"><p class="lead"> После публикации среди друзей <a
                                href="https://ampleev.com/article_praktika_primenenia_burn_down_charts_v_kontekste_safe_i_scrum">первой
                                статьи о Burn Down Chart</a>, в комментариях первый вопрос, который был задан: "Было бы
                            интересно узнать подробнее про ваш опыт с SAFe". Поэтому, в этой статье я постараюсь
                            раскрыть специфику работы в SAFe относительно Scrum на нашей практике. Я точно не претендую
                            на истину в первой инстанции и буду рад любым исправлениям и уточнениям со стороны коллег.
                        </p>
                        <p class="lead">Сначала перечислю тезисно самое основное, что отличает работу в SAFe от SCRUM,
                            на мой взгляд.</p>
                        <ul>
                            <li>Increment в Scrum и Program Increment в SAFe</li>
                            <li>ART - Agile Release Train</li>
                            <li>Количество взаимодействующих команд</li>
                            <li>PIPE</li>
                            <li>SOS</li>
                            <li>PO - не собственник бизнеса</li>
                            <li>RTE</li>
                            <li>Пятый спринт для обучения</li>
                            <li>System Demo</li>
                        </ul>
                        <p><b>Increment в Scrum и Program Increment в SAFe.</b> На самом деле разные термины, но в них
                            легко запутаться т.к. никто не использует у нас термин Program Increment, все говорят просто
                            Increment - а это уже другой термин, который используется в SCRUM. Но в целом они достаточно
                            похожи с точки зрения смысла, на мой взгляд. Increment в SCRUM - это по сути текущий продукт
                            + запланированные истории на спринт в выполненном состоянии (прошедшие DOD команды). Program
                            Increment - это временной интервал в течение которого поезд (Agile Release Train) доставляет
                            инкрементальную ценность в продакшн. По длительности у нас это 4 спринта по 2 недели на
                            разработку и один спринт на обучение. </p>
                        <p><b>Agile Release Train</b> - это команда команд, работающих над одним потоком создания
                            ценности. Мы это называем просто поездом, но по фреймворку правильно это называть
                            "Solution". В нашем случае, это правило не полностью соблюдается и команды часто работают
                            над разными продуктами с технической точки зрения, т.к. большинство бизнес-фич реализуется
                            комплексно и затрагивают несколько продуктов. Это с технической стороны. Но, уверен, что
                            кто-то считает все it-системы одним продуктом компании и, возможно, так даже правильнее.</p>
                        <p><b>Количество взаимодействующих команд</b> у нас в SAFe существенно больше, в сумме
                            рекомендуется до 125 человек в одном поезде. У нас 3 поезда и не в каждом это правило
                            соблюдается, есть поезда с количеством более 125 человек. SCRUM не описывает как
                            взаимодействовать с другими командами, на сколько мне известно, в отличие от SAFe, где есть
                            очень четкие рекомендации по этому поводу. Самый яркий, на мой взгляд, артефакт для этого -
                            это Program Board.
                        </p>
                        <div class="popover-image">
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 23%; left: 3%;"
                                 data-toggle="tooltip" data-placement="bottom" title=""
                                 data-original-title="Команда 1"></div>
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 43%; left: 3%;"
                                 data-toggle="tooltip" data-placement="bottom" title=""
                                 data-original-title="Команда 2"></div>
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 63%; left: 3%;"
                                 data-toggle="tooltip" data-placement="bottom" title=""
                                 data-original-title="Команда 3"></div>
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 43%; left: 57%;"
                                 data-toggle="tooltip" data-placement="bottom" title=""
                                 data-original-title="Команда 2 должна в третьей итерации избавить от зависимости команду 3, чтобы команда 3 в 4 итерации реализовала свою фичу"></div>
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 49%; left: 71%;"
                                 data-toggle="tooltip" data-placement="bottom" title=""
                                 data-original-title="Фича, которую должна реализовать команда 3 в 4 итерации и которую реализовать не сможет без снятия зависимости в 3 итерации командой 2"
                                 alt="Image"></div>
                            <img src="/assets/img/program_board.jpg"
                                 alt="Image" class="rounded border shadow-lg"></div>
                        <br> На нем отображаются взаимосвязи между командами поезда и, обсуждая его, проходят
                        еженедельные мероприятия Scrum Of Scrums (SOS) у нас. <p></p>
                        <p>Примерно каждые 2,5 месяца (каждые 5 спринтов) происходит событие <b>PIPE - Programm
                                Increment Planning Event</b>. Это когда все распределенные команды собираются в одном
                            зале на 2 дня и планируют свои работы на следующие 2,5 месяца. В процессе этого мероприятия
                            появляются такие артефакты, как Program board, например, на котором отображаются все
                            зависимости команд между собой для каждого из поездов, выше я уже показал как он выглядит.
                            Задачей Скрам Мастера каждой команды на этом мероприятии является фасилитация выявлений
                            максимального количества зависимостей, затем по-возможности, их удаление (посредством
                            передачи компетенций устно, например, от команды команде или посредством забора зависимости
                            от одной команды в другую, чтобы команда могла автономно реализовать свою фичу ни от кого не
                            зависив). На практике это у нас так и происходит. Сначала декомпозируются фичи на User
                            Story, User Story раскидываются по 4 спринтам. Фичи размещаются на Program Board и
                            выставляются зависимости от других команд какие есть. В течение мероприятия это обсуждается,
                            корректируется.</p>
                        <p><b>SOS - Scrum Of Scrum.</b> Это мероприятие проходит раз в неделю для каждого поезда
                            отдельно. Скрам Мастера всех команд поезда собираются в онлайне, транслируется Program Board
                            поезда и обсуждаются статусы всех зависимостей и фичей команд конкретного поезда. По сути
                            это мероприятие необходимо для центролизованной синхронизации команд внутри поезда. Что-то
                            вроде стендапа, но раз в неделю и не для команды, а для Скрам Мастеров.</p>
                        <p><b>PO (Product Owner)</b> - не собственник бизнеса. Есть Product Manager - он работает с
                            Bussiness Owner'ами соответствующих направлений бизнеса и по сути раздает фичи Product
                            Owner'ам. Product Owner работает уже непосредственно в команде - бъет фичи на User Stories
                            (в нашем случае совместно с командой) и не всегда бъет, но мы постоянно прогрессируем в этом
                            направлении.</p>
                        <p><b>RTE (Release Train Engineer</b> - машинист поезда. Скрам Мастер Скрам Мастеров. Проводит
                            мероприятия SOS своего поезда. Взаимодействует с Product Manager'ом на уровне фич.
                            Фасилитирует PIPE.</p>
                        <p><b>Пятый спринт для обучения</b> - да, в отличие от Scrum, здесь выделен команде целый спринт
                            в конце инремента на обучение. Мы, как правило, на практике используем его в первую очередь
                            для посещения тренингов внутренних в том числе и по SAFe, но не только. Частные курсы и
                            митапы стараемся планировать на это время по возможности. Также у нас есть разработчики,
                            которые расширяют свой стек в течение 5 спринта, чтобы была возможность закрыть чью-либо
                            компетенцию в команде (подстраховать при необходимости).</p>
                        <p><b>System Demo.</b> В результате PIPE у каждой команды есть список целей на инкремент и
                            каждая из этих целей оценена Buisseness Owner'ом поезда по 10-бальной шкале. Это называется
                            Business Value. Цели эти делятся на основные и расширенные. Основные цели - это цели, в
                            которых команда не видит никаких рисков в достижении. Расширенные - это цели с рисками
                            достижения. Все цели обязательные и объем работ планируется под все цели. На System Demo
                            Business Owner принимает результаты работы за инкремент. Допустим, у команды было 3 основных
                            цели с оценками 10, 6, 8 и 2 расширенные с оценками 10, 3. Представим, что Business Owner
                            поставил соответственно оценки следующие: 8, 6, 4, 2, 0. Теперь можно посчитать процент
                            достижения целей: за 100% берется изначальная сумма балов за основные цели, в нашем случае
                            это 10+6+8=24. Достигнутые баллы считаются с учетом расширенных целей(т.е. 20 из 24 команда
                            достигла), т.е. в результате процент достижения целей у команды будет (20*100)/24 = 83,3%.
                            Нормальным результатом считается достижение от 80% до 100%. </p>
                        <p>Во всем остальном мы работаем по SCRUM. Ну или почти во всем :) Что касается нашего опыта:
                            могу сказать, что, с моей точки зрения, эволюция очевидна. За год работы команды сильно
                            выросли, стали самоорганизующимися, какие-то команды, правда, развалились, но и в этом
                            просматривается определенная эволюция. Расти тоже еще есть куда. </p>
                        <h3>Комментарии коллег из facebook</h3>
                        <blockquote class="bg-primary-alt">
                            <div class="h-75 mb-2">«Женя, привет! Круто, что пишешь, молодец! Чуть поправлю про
                                поезда - собираются они не вокруг продукта, а вокруг потока создания ценности. А в
                                рознице у нас с точки зрения SAFe не поезд, а Solution. Просто для удобства коммуникации
                                и упрощения понимания, мы продолжаем называть это поездом)»
                            </div>
                            <span class="text-small text-muted">– <a
                                    href="https://www.facebook.com/eampleev/posts/10218067831221054?comment_id=10218068282352332¬if_id=1581240428581368¬if_t=feedback_reaction_generic">Константин Воронин</a> (представитель проектного офиса Ингосстраха)</span>
                        </blockquote>
                        <blockquote class="bg-primary-alt">
                            <div class="h-75 mb-2">«Ну и может кто-нибудь заметит, что с точки зрения SAFe оценка
                                целей проходит на I&amp;A; (куда SD входит как часть, но напрямую с оценкой не связан) а
                                сами
                                SD должны проходить каждый спринт (после демо команд). Но мы пока от этого далеки,
                                поэтому осознанно называем все как написано у тебя в статье)»
                            </div>
                            <span class="text-small text-muted">– <a
                                    href="https://www.facebook.com/eampleev/posts/10218067831221054?comment_id=10218068282352332¬if_id=1581240428581368¬if_t=feedback_reaction_generic">Константин Воронин</a> (представитель проектного офиса Ингосстраха)</span>
                        </blockquote>
                        <blockquote class="bg-primary-alt">
                            <div class="h-75 mb-2">«Женя, продолжай, пожалуйста, очень полезно!»</div>
                            <span class="text-small text-muted">– <a
                                    href="https://www.facebook.com/eampleev/posts/10218067831221054?comment_id=10218068603520361¬if_id=1581245287473730¬if_t=feedback_reaction_generic">Алексей Ионов</a> (Сертифицированный тренер по SAFe)</span>
                        </blockquote>
                    </article>
                </div>
            </div>
        </div>
    </section>
    <section class="has-divider">
        <div class="container pt-3">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <hr>
                    <div class="d-flex align-items-center">
                        <span class="text-small mr-1">Share this article:</span>
                        <div class="d-flex mx-2">
                            <a href="#" class="btn btn-round btn-primary mx-1">
                                <img class="icon icon-sm" src="assets/img/icons/social/twitter.svg"
                                     alt="twitter social icon" data-inject-svg/>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.ampleev.com/blog-article&display=popup"
                               class="btn btn-round btn-primary mx-1">
                                <img class="icon icon-sm" src="assets/img/icons/social/facebook.svg"
                                     alt="facebook social icon" data-inject-svg/>
                            </a>
                            <a href="#" class="btn btn-round btn-primary mx-1">
                                <img class="icon icon-sm" src="assets/img/icons/social/linkedin.svg"
                                     alt="linkedin social icon" data-inject-svg/>
                            </a>
                        </div>
                    </div>
                    <hr>
                    <h5 class="my-4">4 Comments</h5>
                    <ol class="comments">
                        <li class="comment">
                            <div class="d-flex align-items-center text-small">
                                <img src="assets/img/avatars/female-4.jpg" alt="Angela Zhao"
                                     class="avatar avatar-sm mr-2">
                                <div class="text-dark mr-1">Angela Zhao</div>
                                <div class="text-muted">56 minutes ago</div>
                            </div>
                            <div class="my-2">
                                Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
                                aute
                                irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                pariatur.
                            </div>
                            <div>
                                <a href="#" class="text-small">Reply</a>
                            </div>
                            <ol class="comments">
                                <li class="comment">
                                    <div class="d-flex align-items-center text-small">
                                        <img src="assets/img/avatars/male-5.jpg" alt="Lenny Sims"
                                             class="avatar avatar-sm mr-2">
                                        <div class="text-dark mr-1">Lenny Sims</div>
                                        <div class="text-muted">just now</div>
                                    </div>
                                    <div class="my-2">
                                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                        fugiat nulla pariatur.
                                    </div>
                                    <div>
                                        <a href="#" class="text-small">Reply</a>
                                    </div>
                                </li>
                            </ol>
                        </li>
                        <li class="comment">
                            <div class="d-flex align-items-center text-small">
                                <img src="assets/img/avatars/female-1.jpg" alt="Sarah Priestly"
                                     class="avatar avatar-sm mr-2">
                                <div class="text-dark mr-1">Sarah Priestly</div>
                                <div class="text-muted">2 hours ago</div>
                            </div>
                            <div class="my-2">
                                Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit
                                laboriosam,
                                nisi ut aliquid ex ea commodi consequatur?
                            </div>
                            <div>
                                <a href="#" class="text-small">Reply</a>
                            </div>
                        </li>
                        <li class="comment">
                            <div class="d-flex align-items-center text-small">
                                <img src="assets/img/avatars/male-1.jpg" alt="Benjamin Cameron"
                                     class="avatar avatar-sm mr-2">
                                <div class="text-dark mr-1">Benjamin Cameron</div>
                                <div class="text-muted">3 hours ago</div>
                            </div>
                            <div class="my-2">
                                Sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam
                                quaerat
                                voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem
                            </div>
                            <div>
                                <a href="#" class="text-small">Reply</a>
                            </div>
                        </li>
                    </ol>
                    <hr>
                    <h5 class="my-4">Post a comment</h5>
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Name" name="comment-name">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email Address"
                                           name="comment-email">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="comment-text" rows="7"
                                      placeholder="Comment"></textarea>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="comment-form-opt-in">
                                <label class="custom-control-label text-small" for="comment-form-opt-in">Notify me when
                                    someone replies</label>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="divider">
            <img class="bg-primary-alt" src="assets/img/dividers/divider-1.svg" alt="divider graphic" data-inject-svg/>
        </div>
    </section>
    <section class="bg-primary-alt">
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <h3 class="h2">Related Stories</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="100">
                    <a href="#" class="card card-body justify-content-between bg-primary text-light">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="text-small d-flex">
                                <div class="mr-2">
                                    Links
                                </div>
                                <span class="opacity-70">19th December</span>
                            </div>
                            <span class="badge bg-primary-alt text-primary">
                  <img class="icon icon-sm bg-primary" src="assets/img/icons/interface/heart.svg"
                       alt="heart interface icon" data-inject-svg/>27
                </span>
                        </div>
                        <div>
                            <h2>A time-tracking app that isn’t a pain.</h2>
                            <span class="text-small opacity-70">http://www.website.io/link</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="200">
                    <div class="card">
                        <a href="#">
                            <img src="assets/img/article-1.jpg" alt="Image" class="card-img-top">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="text-small d-flex">
                                    <div class="mr-2">
                                        <a href="#">Business</a>
                                    </div>
                                    <span class="text-muted">29th November</span>
                                </div>
                                <span class="badge bg-primary-alt text-primary">
                    <img class="icon icon-sm bg-primary" src="assets/img/icons/interface/heart.svg"
                         alt="heart interface icon" data-inject-svg/>12
                  </span>
                            </div>
                            <a href="#">
                                <h4>How to build collateral</h4>
                            </a>
                            <p class="flex-grow-1">
                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                laudantium.
                            </p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="assets/img/avatars/female-3.jpg" alt="Image" class="avatar avatar-sm">
                                <div class="ml-1">
                                    <span class="text-small text-muted">By</span>
                                    <span class="text-small">Abby Sims</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="300">
                    <div class="card">
                        <a href="#">
                            <img src="assets/img/article-2.jpg" alt="Image" class="card-img-top">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="text-small d-flex">
                                    <div class="mr-2">
                                        <a href="#">Design</a>
                                    </div>
                                    <span class="text-muted">27th November</span>
                                </div>
                                <span class="badge bg-primary-alt text-primary">
                    <img class="icon icon-sm bg-primary" src="assets/img/icons/interface/heart.svg"
                         alt="heart interface icon" data-inject-svg/>23
                  </span>
                            </div>
                            <a href="#">
                                <h4>Forging your path</h4>
                            </a>
                            <p class="flex-grow-1">
                                Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                laudantium.
                            </p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="assets/img/avatars/male-4.jpg" alt="Image" class="avatar avatar-sm">
                                <div class="ml-1">
                                    <span class="text-small text-muted">By</span>
                                    <span class="text-small">Cedric</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="pb-4 bg-primary-3 text-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <a href="index.html">
                        <img src="assets/img/logo-white.svg" alt="Leap" class="icon icon-md mb-3">
                    </a>
                    <p class="pr-xl-3">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore
                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                    </p>
                </div>
                <div class="col-6 col-lg col-xl-2">
                    <h5>Navigate</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Demos</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Pages</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Portfolio</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Elements</a>
                        </li>
                    </ul>
                </div>
                <div class="col-6 col-lg">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex">
                            <img class="icon" src="assets/img/icons/theme/map/marker-1.svg" alt="marker-1 icon"
                                 data-inject-svg/>
                            <div class="ml-3">
                  <span>348 Greenpoint Avenue
                    <br/>Brooklyn, NY</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex">
                            <img class="icon" src="assets/img/icons/theme/communication/call-1.svg" alt="call-1 icon"
                                 data-inject-svg/>
                            <div class="ml-3">
                                <span>+61 3928 3324</span>
                                <span class="d-block text-muted text-small">Mon - Fri 9am - 5pm</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex">
                            <img class="icon" src="assets/img/icons/theme/communication/mail.svg" alt="mail icon"
                                 data-inject-svg/>
                            <div class="ml-3">
                                <a href="#">hello@company.io</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-6 col-lg-3">
                    <h5>Contact</h5>
                    <ul class="list-unstyled list-articles">
                        <li class="row row-tight">
                            <a href="#" class="col-3">
                                <img src="assets/img/article-1.jpg" alt="Image" class="rounded">
                            </a>
                            <div class="col">
                                <a href="#">
                                    <h6 class="mb-1">How to build collateral</h6>
                                </a>
                                <div class="d-flex text-small">
                                    <a href="#">Business</a>
                                    <span class="text-muted ml-1">29th November</span>
                                </div>
                            </div>
                        </li>
                        <li class="row row-tight">
                            <a href="#" class="col-3">
                                <img src="assets/img/article-2.jpg" alt="Image" class="rounded">
                            </a>
                            <div class="col">
                                <a href="#">
                                    <h6 class="mb-1">Forging your path</h6>
                                </a>
                                <div class="d-flex text-small">
                                    <a href="#">Design</a>
                                    <span class="text-muted ml-1">27th November</span>
                                </div>
                            </div>
                        </li>
                        <li class="row row-tight">
                            <a href="#" class="col-3">
                                <img src="assets/img/article-3.jpg" alt="Image" class="rounded">
                            </a>
                            <div class="col">
                                <a href="#">
                                    <h6 class="mb-1">Securing your Series A</h6>
                                </a>
                                <div class="d-flex text-small">
                                    <a href="#">Business</a>
                                    <span class="text-muted ml-1">23rd November</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row justify-content-center mb-2">
                <div class="col-auto">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <img class="icon undefined" src="assets/img/icons/social/instagram.svg"
                                     alt="instagram social icon" data-inject-svg/>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <img class="icon undefined" src="assets/img/icons/social/twitter.svg"
                                     alt="twitter social icon" data-inject-svg/>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <img class="icon undefined" src="assets/img/icons/social/youtube.svg"
                                     alt="youtube social icon" data-inject-svg/>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <img class="icon undefined" src="assets/img/icons/social/medium.svg"
                                     alt="medium social icon" data-inject-svg/>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <img class="icon undefined" src="assets/img/icons/social/facebook.svg"
                                     alt="facebook social icon" data-inject-svg/>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col col-md-auto text-center">
                    <small class="text-muted">&copy;2019 All Rights Reserved. Your Brand® is a registered trademark of
                        Your
                        Company
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <a href="#" class="btn back-to-top btn-primary btn-round" data-smooth-scroll data-aos="fade-up"
       data-aos-offset="2000"
       data-aos-mirror="true" data-aos-once="false">
        <img class="icon" src="assets/img/icons/theme/navigation/arrow-up.svg" alt="arrow-up icon" data-inject-svg/>
    </a>
@endsection

@section('pageScript')
    @parent
@endsection
