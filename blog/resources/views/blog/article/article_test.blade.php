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
                <div class="col-lg-10 col-xl-8">
                    <img src="assets/img/article-5_my.jpg" alt="Image" class="rounded">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <article class="article"><p class="lead"> В этой статье я планирую рассказать как на своей практике
                            мы
                            применяем
                            Burn Down Chart в процессе работы по фреймворку <a
                                href="https://www.scaledagileframework.com/">SAFe</a>
                        </p>

                        <p>Начну, пожалуй, с самого интересного. А именно с того, что использование этой диаграммы в
                            SAFe не
                            должно иметь никакой специфики относительно использования этой диаграммы в SCRUM. Или
                            должно?</p>

                        <p>SAFe у нас отличается наличием такой роли, как <a
                                href="https://www.scaledagileframework.com/release-train-engineer-and-solution-train-engineer/">RTE</a>,
                            в отличие от SCRUM, где ее нет. Burn Down Chart -
                            это инструмент отслеживания объема работ в спринте и он необходим прежде всего для
                            SCRUM-команды, а не
                            для кого-либо извне, не так ли?</p>

                        <p>Таким образом, все же перейду к тому как мы используем Burn Down Chart, не смотря ни на что,
                            и,
                            находясь по-прежнему внутри фреймворка SAFe.</p>

                        <p>Я нахожусь в роли <a
                                href="https://www.scaledagileframework.com/scrum-master/">Scrum
                                Master</a> и
                            стараюсь
                            высвечивать эту диаграмму ежедневно
                            для всей <a
                                href="https://www.scaledagileframework.com/dev-team/">Dev
                                Team</a>. Средство,
                            которое я использую - это командный чат, упоминание всей команды
                            через "@", скриншот текущего состояния диаграммы. Упоминание всей команды - это достаточно
                            тонкий инструмент и важно использовать его как можно реже(ведь, мы, Скрам Мастера, должны
                            помогать команде
                            работать в комфорте и с минимально возможной расфокусировкой, не так ли?)</p>

                        <p>В итоге команда ежедневно видит текущее состояние спринта и способна отследить следующие
                            события</p>
                        <ul>
                            <li>Появление незапланированной работы</li>
                            <li>Долгое зависание задач в незавершенном статусе</li>
                            <li>Чрезмерное закладывание рисков</li>
                            <li>Понимание - в правильном ли темпе идет работа</li>
                        </ul>

                        <p>Далее я постараюсь раскрыть каждое из этих событий и привести примеры из своей практики.</p>

                        <h4>Появление незапланированной работы</h4>

                        <br/>

                        <div class="popover-image">

                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 22%; left: 17%;"
                                 data-toggle="tooltip" data-placement="bottom" title="Запланированное увеличение объема работ. В первый день спринта у нас проходит такое мероприятие, как Scrum Planning. Соответственно,
                             если это увеличение произошло в течение этого мероприятия, значит здесь всё нормально.">

                            </div>

                            <div class="popover-hotspot bg-primary-2" style="top: 8%; left: 81%;" data-toggle="tooltip"
                                 title="Незапланированное увеличение объема работ. Здесь же мы видим странность: объем запланированной работы увеличился во второй вторник двухнедельного спринта.
                              Это повод обратить на это внимание команды на стендапе.">

                            </div>
                            <img src="/assets/img/saas-1_my.jpg" alt="Image"
                                 class="rounded border shadow-lg">
                        </div>


                        <br/>
                        <br/>

                        <p class="lead">На данной диаграмме очень хорошо видно, как появляется новая работа (во второй
                            вторник
                            двухнедельного спринта).</p>
                        <p>
                            Случай из практики: "Разработчик, как член
                            scrum-команды, разделяющей принципы agile, классно взаимодействует с Product-ом напрямую.
                            Product говорит ему, что вот это надо запилить быстренько, ты же сам понимаешь, тут быстро и
                            риски минимальные.
                        </p>
                        <p>
                            Разработчик классный, он знает все про agile и про важность доставки бизнес-ценности, идет
                            закидывает на доску
                            историю из беклога, оценена она командой в 6 sp.
                        </p>
                        <p>
                            Остальная часть команды (кроме разработчика и Product-а) замечает это на утреннем апдейте
                            диаграммы. На стендапе команда принимает решение как быть с этой ситуацией. Вероятнее всего,
                            история выкидывается из спринта, Product-у и Разработчику команда дает понять, что так
                            делать
                            нельзя, продакт может поставить данную историю в следующий спринт при необходимости.
                        </p>
                        <p>
                            Конечно, в идеале команда должна заметить появление новой работы на стендапе и без
                            диаграммы. Но
                            диграмма является хорошим индикатором, который сводит риски незаметить такое важное для всей
                            команды изменение к минимуму.
                        </p>
                        <p>
                            <small>Здесь важно понимать, что сценарий мог пойти по-разному в зависимости от уровня
                                команды. В крутых командах Product Owner врядли так сделал бы, а если и сделал бы, то
                                аргументировал
                                не тем, что &#171;это можно быстренько запилить&#187;, а тем, что &#171;я оцениваю в 55%
                                вероятность того, что
                                если
                                это запилить сейчас, то может увеличить нашу прибыль на 20% в следующем месяце&#187; или
                                еще
                                какой-либо измеримой метрикой.
                            </small>
                        </p>

                        <h4>Долгое зависание задач в незавершенном статусе</h4>
                        <br/>
                        <div class="popover-image">

                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 14%; left: 27%;"
                                 data-toggle="tooltip" data-placement="bottom"
                                 title="Когда количество работы не уменьшилось за один день - это может быть вполне нормально.">

                            </div>

                            <div class="popover-hotspot bg-primary-2" style="top: 14%; left: 74%;" data-toggle="tooltip"
                                 data-placement="bottom" title="Но когда ситуация не меняется в течение 40-50% времени спринта,
                              это уже повод для расследования проблемы">

                            </div>
                            <img src="/assets/img/saas-1_my_1.jpg" alt="Image"
                                 class="rounded border shadow-lg">
                        </div>

                        <br/>
                        <br/>

                        <p class="lead">Здесь мы видим, что очень долго работа не завершается даже частично. Это может
                            сигнализировать о
                            разных проблемах, перечислю некоторые из них</p>
                        <ul>

                            <li><h5>Плохая декомпозиция задач</h5>
                                <p>
                                    <em>Очень часто начинающие команды говорят о невозможности декомпозиции. У них все
                                        сгорает в
                                        последний день, работа не распараллеливается и т.д. Конечно, с этим необходимо
                                        работать
                                        Скрам Мастеру и объяснять ценность декомпозиции команде.
                                    </em>
                                </p>
                            </li>

                            <li><h5>Не оптимально сформулированный DOD</h5>
                                <p>
                                    <em>DOD (Definition of Done) - описание критериев готовности User Story в спринте.
                                        Иногда их
                                        вообще нет или они описаны очень абстрактно. Это вполне может быть проблемой,
                                        котороую,
                                        естественно, должен помочь решить Скрам Мастер
                                    </em>
                                </p>
                            </li>
                        </ul>
                        <br/>
                        <h4>Чрезмерное закладывание рисков</h4>
                        <br/>
                        <div class="popover-image">

                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 28%; left: 20%;"
                                 data-toggle="tooltip" data-placement="bottom"
                                 title="До этого момента мы видим практически идеальную работу команды.">

                            </div>

                            <div class="popover-hotspot bg-primary-2" style="top: 74%; left: 56%;" data-toggle="tooltip"
                                 data-placement="bottom"
                                 title="Здесь же, очевидно, мы понимаем, что команда плохо спланировала свой ресурс на спринт. Почему это плохо, опишу ниже.">

                            </div>
                            <img src="/assets/img/saas-1_my_2.jpg" alt="Image"
                                 class="rounded border shadow-lg">
                        </div>
                        <br/>
                        <br/>

                        <p class="lead">В этом случае мы видим ситуацию когда команда перезаложила риски.</p>
                        <p> Возможно, какая-то история была
                            переоценена. Возможно, это более системная проблема и необходимо увеличивать объем работы
                            при
                            планировании спринта. В
                            любом случае, данная ситуация не корректна. Ведь бизнес планировал что будут реализованы
                            именно
                            задачи спринта и именно к концу спринта. В зависимости от того как были спланированы
                            зависимости,
                            здесь вероятнее всего придется проводить встречи для корректировки ожиданий. </p>

                        <p>На моей практике такое было когда находилось решение более быстрое, чем обсуждалось при
                            оценке.
                            Обсуждали всей командой какую историю сможем закрыть до конца спринта и на ретроспективе
                            договорились, что будем стараться смотреть код при груминге. Выяснилось, что достаточно было
                            просто заглянуть в код чтобы понять, что решение сильно проще.</p>
                        <h4>Понимание - в правильном ли темпе идет работа</h4>
                        <br/>
                        <div class="popover-image">

                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 24%; left: 4%;"
                                 data-toggle="tooltip" data-placement="bottom"
                                 title="В этой части я показал неудачный вариант отображения Burn Down Chart в одном из трекеров (строится автоматически).">

                            </div>

                            <div class="popover-hotspot bg-primary-2" style="top: 90%; left: 4%;" data-toggle="tooltip"
                                 data-placement="bottom"
                                 title="В этой части показана диаграмма, которую строю я своими руками (ну почти).">

                            </div>

                            <div class="popover-hotspot bg-primary-2" style="top: 3%; left: 48%;" data-toggle="tooltip"
                                 data-placement="bottom"
                                 title="Здесь почти незаметно появление незапланированной работы.">

                            </div>

                            <div class="popover-hotspot bg-primary-2" style="top: 41%; left: 48%;" data-toggle="tooltip"
                                 data-placement="bottom"
                                 title="Здесь появление незапланированной работы более наглядно.">

                            </div>


                            <div class="popover-hotspot bg-primary-2" style="top: 8%; left: 77%;" data-toggle="tooltip"
                                 data-placement="bottom"
                                 title="Здесь есть ощущение, что осталось еще 3 дня работы (хотя по факту их 2), т.е. эта диаграмма предлагает поработать в выходные.">

                            </div>

                            <div class="popover-hotspot bg-primary-2" style="top: 53%; left: 77%;" data-toggle="tooltip"
                                 data-placement="bottom"
                                 title="Здесь мы точно видим, что осталось только 2 дня работы и рапределяем свои силы исходя из корректных данных">

                            </div>
                            <img src="/assets/img/saas-1_my_4.jpg" alt="Image"
                                 class="rounded border shadow-lg">
                        </div>
                        <br/>
                        <br/>

                        <p class="lead">Здесь я хотел бы обратить внимание на графически неудачные способы отображения
                            Burn
                            Down Chart</p>

                        <p>В верхней части изображения приведен пример не самого удачной графической реализации по двум
                            причинам, которые я изложу ниже.</p>

                        <ul>

                            <li><h5>Не заметно попадание новых SP в спринт</h5>
                                <p>
                                    <em>Здесь, на верхней диаграмме, практически не заметно, что добавилась
                                        незапланированная работа. На нижней это более наглядно.
                                    </em>
                                </p>
                            </li>

                            <li><h5>Не корретно отображается относительный остаток работ</h5>
                                <p>
                                    <em>Согласно верхней диаграмме осталось работать еще 3 дня. По факту их 2, в
                                        выходной,
                                        возможно, кто-то планирует отдохнуть.
                                    </em>
                                </p>
                            </li>
                        </ul>

                        <p>
                            Конечно, кому-то такие мелочи покажутся не значительными. Но надо понимать, что каждый
                            член
                            команды всего лишь краем глаза вpглянет на эту диаграмму и она должна донести максимум
                            полезной
                            информации.

                        </p>


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
