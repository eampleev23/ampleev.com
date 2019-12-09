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
                <a class="navbar-brand fade-page" href="{{route('blog.index')}}">
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
                                    <a href="https://twitter.com/intent/tweet?text=Диаграммы%20сгорания%20в%20контексте%20SAFe%20-%20https://www.ampleev.com/blog-article&hashtags=#agile#SAFe#burndowncharts" class="mx-1 btn btn-sm btn-round btn-primary">
                                        <img class="icon" src="assets/img/icons/social/twitter.svg"
                                             alt="twitter social icon" data-inject-svg/>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.ampleev.com/blog-article&display=popup" class="mx-1 btn btn-sm btn-round btn-primary">
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
                    <article class="article">
                        <p class="lead">
                            В этой статье я планирую рассказать как на своей практики мы применяем диаграмму сгорания
                            (Burn Down Chart) в процессе работы по методологии SAFe
                        </p>
                        <p>
                            Немного расскажу мы - это кто. У нас команда, состоящая из 9 человек (Product Owner - 1 шт.,
                            Scrum Master - 1 шт., Dev-team - 7 человек (из которых 3 разработчика, 2 аналитика и 2
                            тестировщика).
                            Роли внутри dev-team я указал как основную специализацию, но это не значит что тестировщик
                            не может
                            подстраховать аналитика и наоборот плюс разработчики тоже с разным стеком и также могут
                            подстраховать друг друга.
                        </p>
                        <p>
                            В своей работе мы используем фреймворк <a href="https://www.scaledagileframework.com">SAFe
                                или Scaled Agile Framework</a>. Я постараюсь описать очень кратко и для тех, кто
                            более-менее
                            представляет что-то об Agile такого описания должно быть достаточно.
                        </p>
                        <h4>SAFe или Scaled Agile Framework</h4>
                        <p>
                            По сути - это работа по методологии Scrum или Kanban в крупной корпорации
                            (не в такой, где одна команда фигачит стартап сутки напролет), где могут совместно работать
                            много скрам-команд (у нас их 17).
                        </p>

                        <h4>Диаграммы сгорания (Burn Down Charts)</h4>
                        <p>
                            Как ни сранно, внутри спринта при использовании "Диаграмм Сгорания" (Burn Down Charts),
                            разницы особой нет SAFe у вас или стартап из одной команды.
                        </p>

                        <p>По сути мы просто визуализируем общий объем работ на спринт, понимаем тенденцию и,
                            таким образом, понимаем на сколько качественно мы спланировали спринт. Этот инструмент не
                            единственный,
                            но он существенно облегчает работу в долгой перспективе.</p>

                        <p>Конечно, всем интересно, как на практике данная диаграмма помогает в решении командных
                            проблем.
                            Я лишь постараюсь перечислить несколько кейсов, уверен, что у многих бывали и другие, буду
                            рад дополнениям в комментариях.</p>

                        <h4>Контекст</h4>

                        <p>Также хочу заранее договориться о том, что мы все кейсы рассматриваем при условии, что
                            команда ежедневно перед стендапом обращает внимание на эту диаграмму. Способы могут быть
                            разные (у нас, например, Scrum Master публикует ежедневно перед стендапом актуальную версию
                            в командном чате с упоминанием всей команды.</p>

                        <h4>Своевременное понимание всей команды, что появилась незапланированная работа</h4>

                        <p>Например, давйте представим, что в командном чате вы каждый день выкладываете текущий тип
                            диаграммы. У нас происходило такое, что один из членов команды заводил историю, сам ее
                            оценивал и закидывал на доску. Как ни странно такое бывает и у достаточно развитых команд с
                            точки зрения Agile. Почему-то этот разработчик не учитывал тот факт, что оценка должна быть
                            командной и вся команда должна принимать такое решение на одном из мероприятий (если внутри
                            не договорились иначе.</p>

                        <p>В итоге, при следующем апдейте(максимум через 8 рабочих часов, вся команда видит, что
                            добавилась работа, и на стендапе может обсудить этот инцидент и как с ним поступить</p>

                        <p>Спасает это прежде всего от невнятных комментариев на ретроспективе о том почему мы завалили
                            спринт. Помимо этого, повышает степень командной, а не персональной ответственности.</p>

                        <h4>Индексация опыта и инструмент улучшения качества планирования</h4>

                        <p>Когда команда постоянно наблюдает за данной диаграммой, постепенно набиратется опыт и мы уже
                            заранее знаем какие проблемы в команде как на нее влияют. Например, мы можем понять, что
                            если плохо декомпозировать задачи, то сжигание происходт в лучшем случае в последний
                            момент и очень часто в результате такого "сжигания" заводятся новые истории в беклог,
                            которые на самом деле просто позволяют думать, что мы завершили спринт успешно. Скрам
                            Мастер, конечно, должен пресекать подобное.</p>

                        <h4>Помогает понять перед стендапом и на ретроспективе на сколько мы отклоняемся от идеального
                            сгорания и своевременно задуматься о каких-либо действиях</h4>

                        <p>Когда команда постоянно наблюдает за данной диаграммой, постепенно набиратется опыт и мы уже
                            заранее знаем какие проблемы в команде как на нее влияют. Например, мы можем понять, что
                            если плохо декомпозировать задачи, то сжигание происходт в лучшем случае в последний
                            момент и очень часто в результате такого "сжигания" заводятся новые истории в беклог,
                            которые на самом деле просто позволяют думать, что мы завершили спринт успешно. Скрам
                            Мастер, конечно, должен пресекать подобное.</p>

                        <h4>Пример не очень хорошей диаграмы</h4>

                        <p>Когда команда постоянно наблюдает за данной диаграммой, постепенно набиратется опыт и мы уже
                            заранее знаем какие проблемы в команде как на нее влияют. Например, мы можем понять, что
                            если плохо декомпозировать задачи, то сжигание происходт в лучшем случае в последний
                            момент и очень часто в результате такого "сжигания" заводятся новые истории в беклог,
                            которые на самом деле просто позволяют думать, что мы завершили спринт успешно. Скрам
                            Мастер, конечно, должен пресекать подобное.</p>


                        <figure>
                            <img src="assets/img/article-9.jpg" alt="Image" class="rounded">
                            <figcaption>A caption to describe the image</figcaption>
                        </figure>
                        <p>
                            Aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate
                            velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas
                            nulla
                            pariatur?
                        </p>
                        <blockquote class="bg-primary-alt">
                            <div class="h3 mb-2">“We couldn’t have done it without the hard-working team from Leap.”
                            </div>
                            <span class="text-small text-muted">– Harvey Dent (via Tareq I.)</span>
                            <a href="#" class="btn btn-primary btn-sm">
                                <img class="icon" src="assets/img/icons/social/twitter.svg" alt="twitter social icon"
                                     data-inject-svg/>
                                <span>Tweet</span>
                            </a>
                        </blockquote>
                        <p>
                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                            laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi
                            architecto
                            beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas
                            sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione
                            voluptatem sequi nesciunt.
                        </p>
                        <h5>A minor heading to summarise</h5>
                        <p>Sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat
                            voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit
                            laboriosam, nisi ut aliquid ex ea commodi consequatur?</p>
                        <ul>
                            <li>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam
                            </li>
                            <li>Corporis suscipit laboriosam</li>
                            <li>Aspernatur aut odit aut fugit eos qui ratione</li>
                            <li>Et quasi</li>
                        </ul>
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
                            <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.ampleev.com/blog-article&display=popup" class="btn btn-round btn-primary mx-1">
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
