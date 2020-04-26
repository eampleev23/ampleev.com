@extends('layouts.app')

@section('title', "Чему учит нас осьминог относительно дизайна организации по Agile?")
@section('description', '')
@section('page_url', route('blog.show_article', 'chemu_uchit_nas_osminog_otnositelno_dizaina_organizacii_po_agile'))
@section('main_image_path', env('APP_URL').'/assets/img/octopus_main.jpg')

@section('custom_css')
    @parent
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="assets/css/custiom_article.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- here we are-->
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')
    @include('layouts.navbar_white')

    <div class="article-progress" data-sticky="below-nav">
        <progress class="reading-position" value="0"></progress>
        <div class="article-progress-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <div class="text-small text-muted mr-1">Читаете:</div>
                                <div class="text-small">Чему учит нас осьминог относительно дизайна организации по
                                    Agile?
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="text-small text-muted">Поделиться:</span>
                                <div class="d-flex ml-1">
                                    <a href="{{$article->tweetHrefGenerate()}}"
                                       class="mx-1 btn btn-sm btn-round btn-primary">
                                        <img class="icon" src="assets/img/icons/social/twitter.svg"
                                             alt="twitter social icon" data-inject-svg/>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{route('blog.show_article', $article->text_url)}}&display=popup"
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
                                    <a href="{{route('blog.home')}}">Блог</a>
                                </li>
                                <li class="breadcrumb-item">
                                    Agile
                                </li>
                            </ol>
                        </nav>
                        <span class="badge bg-primary-alt text-primary">
                <img class="icon bg-primary" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"
                     alt="heart interface icon"
                     data-inject-svg/>{{$article->views_count}}</span>
                    </div>
                    <h1>Чему учит нас осьминог относительно дизайна организации по Agile?</h1>
                    <div class="d-flex align-items-center">
                        <a href="#">
                            <img src="{{env('APP_URL').$article->user->avatar_path}}" alt="Avatar" class="avatar mr-2">
                        </a>
                        <div>
                            <div>Автор статьи: <a href="#">{{$article->user->name}}</a>
                            </div>
                            <div class="text-small text-muted">{{$article->get_nice_time_created()}}</div>
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
                    <div class="popover-image">
                        <figure>
                            <img src="/assets/img/octopus_main_1.jpg" alt="Image" class="rounded border shadow-lg">
                            <figcaption>
                                <noindex>
                                    Photo by <a rel="nofollow"
                                                href="https://unsplash.com/@serenarepice?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Serena
                                        Repice Lentini</a> on <a rel="nofollow"
                                                                 href="https://unsplash.com/">Unsplash</a>
                                </noindex>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <article class="article"><p class="lead"> В этой статье я планирую рассказать как на своей практике
                            мы применяем Cumulative Flow Chart в Scrum в процессе работы по фреймворку <a
                                    href="https://www.scaledagileframework.com">SAFe</a></p>
                        <p>Начну, пожалуй, со ссылки на <a rel="nofollow"
                                    href="https://blog.kaiten.ru/накопительная-диаграмма-потока/">такую статью</a> -
                            здесь, на мой взгляд, хорошо описано ее назначение в стандартном виде, рекомендую изучить
                            перед прочтением моей статьи. Ниже же я опишу как мы ее адаптировали для
                            Scrum-процесса(изначально она используется в Kanban) и какие проблемы она помогает нам
                            решать при работе по спринтам.</p>
                        <p>Ранее, в <a
                                    href="https://ampleev.com/article_praktika_primenenia_burn_down_charts_v_kontekste_safe_i_scrum">статье
                                о Burn Down Charts</a> я уже говорил о том, что там мы видим появление новой работы и
                            сгорание старой. Проблема Burn Down Chart в том, что, в отличие от Cumulative Flow Chart, на
                            ней мы не видим движение Пользовательских Историй по статусам. Когда же мы начинаем
                            наблюдать движения по статусам в Cumulative Flow Chart, мы начинаем видеть ежедневные
                            изменения (Burn Down Chart может не изменяться несколько дней и в некоторых контекстах это
                            может быть вполне нормально) и можем заметить более тонкие проблемы.</p>
                        <p>Вот как это может выглядеть в динамике(на изображении диаграмма построенная на реальных
                            данных).</p>
                        <div class="popover-image"><img src="assets/img/cdf_example_1.jpg" alt="Image"
                                                        class="rounded border shadow-lg"></div>
                        <br/> <br/>
                        <div class="popover-image">
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 62%; left: 66%;"
                                 data-toggle="tooltip" data-placement="bottom" title=""
                                 data-original-title="Первые 7 дней спринта в тестировании находится очень малый объем работ."></div>
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 27%; left: 66%;"
                                 data-toggle="tooltip" data-placement="bottom" title=""
                                 data-original-title="Из черновика в работу истории уходят достаточно равномерно - это хорошо."></div>
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 57%; left: 83%;"
                                 data-toggle="tooltip" data-placement="bottom" title=""
                                 data-original-title="Меньше половины объема работ спринта выполнено, а остался всего один день."></div>
                            <img src="assets/img/cfd_example_2.jpg" alt="Image" class="rounded border shadow-lg"></div>
                        <br/> <br/>
                        <p>В данном примере мы видим следующее</p>
                        <ul>
                            <li>Первые 7 дней спринта в тестировании находится очень малый объем работ и он не
                                меняется
                            </li>
                            <li>Из DOR (здесь это черновик) в работу Пользовательские Истории уходят достаточно
                                равномерно - это хорошо.
                            </li>
                            <li>Также как и на Burn Down, мы видим, что согласно тенденции Пользовательские Истории не
                                будут выполнены к концу спринта
                            </li>
                        </ul>
                        <p>Эти 3 наблюдения в совокупности приводят к следующему выводу. Здесь явно еще на ранних этапах
                            (где-то во второй-третий день спринта) нужно было Скрам Мастеру обратить внимание на слой
                            "Тестирование", который слишком мал и не меняется достаточно долго(убедиться в чем причина).
                            Можно предположить, что объем работы готовой для тестирования невозможно протестировать по
                            каким-либо обстоятельствам, но тогда это означает, что тестировщики простаивают, а
                            значит,как минимум стоит повнимательнее их послушать на ближайшем стендапе.</p>
                        <p>Если говорить о практике применения, то я, к примеру, публикую ежедневно в чате команды все
                            метрики перед стендапом с упоминанием всей команды. </p>
                        <p>В целом, не стоит забывать, что все же метрики нужно правильно интерпретировать. Уметь видеть
                            действительно системные проблемы если они есть и не воспринимать за проблемы то, что в вашем
                            контексте может быть даже положительным признаком</p></article>
                </div>
            </div>
        </div>
    </section>

    <section class="has-divider">
        <div class="container pt-3">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">

                    <hr>
                    @include('blog.article.social_sharing')
                    @include('blog.article.answer_form')
                    <hr id="add_comment">
                    @include('blog.article.add_comment')

                </div>
            </div>
        </div>
        <div class="divider">
            <img class="bg-primary-alt" src="assets/img/dividers/divider-1.svg" alt="divider graphic" data-inject-svg/>
        </div>
    </section>

    @include('blog.article.related_stories')
    @include('blog.articles.emailing_list_footer')

@endsection

@section('pageScript')
    @parent
@endsection