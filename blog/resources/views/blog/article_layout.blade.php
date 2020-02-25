@extends('layouts.app')

@section('title', "5 простых хаков окружения разработчика для повышения производительности. 1 часть.")
@section('description', 'Простые, но эффективные способы улучшить вашу жизнь как разработчика. 1 часть')
@section('page_url', route('blog.show_article', '5_prostih_hakov_okruzhenia_razrabotchika_dlia_povishenia_proizvoditelnosti_chast_1'))
@section('main_image_path', env('APP_URL').'/assets/img/5haks_main.jpg')

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
                                <div class="text-small">5 простых хаков окружения разработчика для повышения
                                    производительности
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
                                    Development
                                </li>
                            </ol>
                        </nav>
                        <span class="badge bg-primary-alt text-primary">
                <img class="icon bg-primary" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"
                     alt="heart interface icon"
                     data-inject-svg/>{{$article->views_count}}</span>
                    </div>
                    <h1>5 простых хаков окружения разработчика для повышения производительности</h1>
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
                    <p>Простые, но эффективные способы улучшить вашу жизнь как разработчика.</p>
                    <div class="popover-image"><img src="/assets/img/5haks_main.jpg" alt="Image"
                                                    class="rounded border shadow-lg"></div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <article>
                        <br/>
                        <br/>

                        <p class="lead">
                            Ниже приведены 5 лайфхаков, которые я использую в своей ежедневной работе разработчиком и
                            нахожу очень полезеыми для своей эффективности и результативности. Некоторые из них - это
                            всего-лишь советы по организованности, другие же являются конкретными инструментами для
                            повышения общей эффективности вашей работы. Наслаждайтесь!
                        </p>

                        <br/>
                        <h2>1. Статус ветки GIT в терминале</h2>

                        <p class="lead">
                            Во-первых, есть очень простое улучшение, которое на столько популярное, что недавно оно было
                            включено в iTerm2 (такой новый терминал для macOS с кучей приблуд всяких полезных) в
                            качестве
                            основной фичи.
                        </p>

                        <p class="lead">
                            При работе в GIT-репозитории полезно иметь перед глазами описание ветки, в которой вы
                            работаете и ее статус. До недавнего времени это можно было сделать с помощью простого
                            редактирования профиля Bash (в результате эта информация отображалась в консоли по умолчанию
                            перед вводом команды там же, где и '$').
                        </p>

                        <p class="lead">
                            Возможно, способ с настройкой профиля Bash и сейчас проканает, но я расскажу о способе,
                            который предоставляет iTerm2. Следуйте этим простым шагам чтобы реализовать это в своем
                            терминале:</p>
                        <ul>
                            <li>Запустите iTerm2 и выберете Preferences > Profiles</li>
                            <li>Перейдите в таб "Sessions" и в самом низу окна отметьте чекбокс "Status bar enabled"
                            </li>

                            <br/>
                            <figure>
                                <img role="presentation"
                                     src="/assets/img/5haks_1.png" alt="Разблокируйте Status bar - изображение"
                                     class="rounded border shadow-lg">
                                <figcaption>
                                    Разблокируйте Status bar
                                </figcaption>
                            </figure>

                            <li>Сконфигурируйте Status Bar, выбрав и перетащив компонент ветки с названием "master"
                            </li>

                            <br/>
                            <figure>
                                <img role="presentation"
                                     src="/assets/img/5haks_2.png" alt="Разблокируйте Status bar - изображение"
                                     class="rounded border shadow-lg">
                                <figcaption>
                                    Выберите и перетащите компонент ветки с названием "master" в окно "Active
                                    components"
                                </figcaption>
                            </figure>

                        </ul>

                        <p class="lead">
                            Конечно, вам решать, где и когда использовать данную фичу. Лично я сейчас использую ее во
                            всех клиентах консоли, которые использую, т.к., не видя ветки, я уже начинаю ощущать
                            физический дискомфорт.
                        </p>

                        <br/>
                        <h2>2. Используйте Tmux</h2>

                        <p class="lead">
                            Если вы не знакомы с Tmux, то я рекомендую поставить его и потестить. На первый взгляд он
                            может показаться обычным диспетчером окон / сессий, но в действительности это невероятно
                            сложный (в хорошем смысле) функциональный инструмент.
                        </p>

                        <p class="lead">
                            Tmax позволяет управлять несколькими окнами с помощью горячих клавиш. Одно из самых удобных
                            преимуществ - это возможность останавливать сессии и возвращаться к любой из них позже.
                        </p>

                        <p class="lead">
                            Это может быть особенно полезно если у вас удаленная машина. Вы можете начать сеанс,
                            запустить долго выполняющийся скрипт, затем поставить его на паузк и выпить кофе.
                        </p>

                        <p class="lead">
                            Пока вы ходите за кофе, ваша сессия будет ждать вас ровно в том месте и состоянии, в котором
                            вы ее оставили.
                        </p>

                        <p class="lead">
                            Еще одно удивительное преимущество заключается в том, что Tmux автоматически и корректно
                            приостановит ваш сеанс, если вы потеряете соединение ssh с вашей удаленной машиной.
                        </p>

                        <p class="lead">
                            Если вы подключаетесь к удаленному компьютеру, откройте новый сеанс Tmux, а затем откройте
                            ваш файл в Vim. В этом сеансе он будет защищен от адского файла *.swp, если вы отключитесь.
                            Это преимущество сложно переоценить.
                        </p>

                        <p class="lead">
                            Tmux спас мою задницу больше раз, чем я могу сосчитать. Честно.
                        </p>

                        <em>Продолжение планируется во второй части статьи.</em>


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