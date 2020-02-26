@extends('layouts.app')

@section('title', "5 простых хаков окружения разработчика для повышения производительности. 2 часть.")
@section('description', 'Простые, но эффективные способы улучшить вашу жизнь как разработчика. 2 часть')
@section('page_url', route('blog.show_article', '5_prostih_hakov_okruzhenia_razrabotchika_dlia_povishenia_proizvoditelnosti_chast_2'))
@section('main_image_path', env('APP_URL').'/assets/img/5haks2_main.jpg')

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
                    <h1>5 простых хаков окружения разработчика для повышения производительности. 2 часть.</h1>
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
                    <p>Данная статья является продолжением <a
                                href="https://ampleev.com/article_5_prostih_hakov_okruzhenia_razrabotchika_dlia_povishenia_proizvoditelnosti_chast_1">первой
                            части</a>.</p>
                    <div class="popover-image">
                        <figure>
                            <img src="/assets/img/5haks2_main.jpg" alt="Image" class="rounded border shadow-lg">
                            <figcaption>
                                <noindex>
                                    Photo by <a rel="nofollow"
                                                href="https://unsplash.com/@marvelous?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Marvin
                                        Meyer</a> on <a rel="nofollow"
                                                        href="https://unsplash.com/s/photos/workspace?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>
                                </noindex>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <article>
                        <br/>
                        <br/>
                        <h2>3. Установите алиасы в Shell</h2>
                        <p class="lead">
                            Чем меньше вы печатаете руками при вводе команд в консоли, тем более вы продуктивны.
                            Откройте <code>~/.bash_aliases</code> в вашем любимом текстовом редакторе и вперёд - вводить
                            алиасы.
                            Убедитесь, что в вашем дистрибутиве алиасы храняться именно в <code>~/.bash_aliases</code>.
                            Имя файла
                            может отличаться в различных дистрибутивах.
                        </p>

                        <p class="lead">
                            Если вы впервые узнали об этой функции, я поясню: она позволит вам записывать в псевдоним
                            какой угодно bash-скрипт и выполнять, соответственно, любое количество команд из любого
                            контекста.
                        </p>

                        <p class="lead">
                            При каждом входе на удаленный сервер, вы утомительно вводите адрес директории и после этого
                            только вводите команду? Сделайте алиас.
                        </p>

                        <p class="lead">
                            Просто утомительно и часто вводите путь к какому-либо файлу? Даже, не запуская команду?
                            Всё-равно: ваш выход - это алиас.
                        </p>

                        <p class="lead">
                            Никак не можете запомнить синтаксис этой утомительной команды? Я думаю, вы уже поняли.
                        </p>

                        <p class="lead">
                            Записать алиас очень просто: <br/>
                            <code>alias mydir='cd /some/long/directory/path'</code>
                        </p>
                        <hr>

                        <h2>4. Организуйте ваши директории с кодом</h2>

                        <p class="lead">
                            Это звучит просто и, уверяю вас, так оно и есть. Вы должны выделить немного дополнительного
                            времени (скорее всего не больше нескольких минут) на организацию структуры каталогов для
                            вашего кода. Делать это систематически (можно этот процесс сравнить с уборкой вашего стола).
                        </p>

                        <p class="lead">
                            Лично мне нравится хранить любые клонированные репозитории в отдельном каталоге с именем
                            <code>co</code> или <code>checkout</code>. Это помогает быстро ориентироваться между кодом,
                            который я пишу локально и склонированным.
                        </p>

                        <p class="lead">
                            Для любого другого кода, мне нравится организовывать каталоги по используемым языкам.
                            Например:
                        </p>
                        <code>'code ---> go ---> [my_cool_project] ---> [source_files]'</code>
                        <hr>

                        <h2>5. Используйте команду ripgrep</h2>
                        <p class="lead">
                            Не можете вспомнить в каком файле была эта функция? Забыли где вы объявили эту переменную?
                            <a rel="nofollow" href="https://github.com/BurntSushi/ripgrep">Ripgrep</a> в помощь!
                        </p>

                        <p class="lead">
                            Возможно, вы использовали <a rel="nofollow" href="https://git-scm.com/docs/git-grep">git-grep</a>
                            для поиска в репозитории раньше. Ripgrep
                            тоже самое, но с одним очень важным исключением, облегчающим жизнь: она восхищает!
                        </p>

                        <p class="lead">
                            Благодаря своей быстроте, ripgrep просмотрит миллионы строк кода во много раз
                            быстрее, чем git-grep.
                        </p>

                        <p class="lead">
                            В следующий раз, когда захотите найти какой-либо набор символов в проекте и не будете знать
                            с чего начать, попробуйте <a rel="nofollow" href="https://github.com/BurntSushi/ripgrep">ripgrep</a>.
                            Это очень просто:
                        </p>
                        <code>rg 'search term'</code>

                        <br/>
                        <br/>
                        <br/>
                        <p class="lead">
                            <em>
                                Надеюсь, эти хаки были вам полезны, на этом у меня всё.
                            </em>
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