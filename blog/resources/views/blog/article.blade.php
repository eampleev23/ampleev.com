<!-- Stored in resources/views/child.blade.php -->
@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->seo_description)
@section('page_url', route('blog.show_article', $article->id))

@section('custom_css')
    @parent
@endsection

@section('sidebar')
    @parent
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" media="all"/>
    {{--    <p>This is appended to the master sidebar.</p>--}}
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
                                <div class="text-small">{{$article->title}}</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="text-small text-muted">Поделиться:</span>
                                <div class="d-flex ml-1">
                                    <a href="https://twitter.com/intent/tweet?text=Диаграммы%20сгорания%20в%20контексте%20SAFe%20-%20https://www.ampleev.com/blog-article"
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
                                    <a href="#">{{$article->blog_section->title}}</a>
                                </li>
                            </ol>
                        </nav>
                        <span class="badge bg-primary-alt text-primary">
                <img class="icon bg-primary" src="assets/img/icons/interface/heart.svg" alt="heart interface icon"
                     data-inject-svg/>{{$article->likes_count}}</span>
                    </div>
                    <h1>{{$article->title}}</h1>
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
    {!! $article->content !!}

    <section class="has-divider">
        <div class="container pt-3">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <hr>
                    <div class="d-flex align-items-center">
                        {{--                        <span class="text-small mr-1">Поделиться этой статьей:</span>--}}
                        <div class="d-flex mx-2">
{{--                            <div--}}
{{--                                    class="fb-like"--}}
{{--                                    data-share="true"--}}
{{--                                    data-width="450"--}}
{{--                                    data-show-faces="true">--}}
{{--                            </div>--}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.ampleev.com/blog-article&display=popup"
                               class="btn btn-round btn-primary mx-1">
                                <img class="icon icon-sm" src="assets/img/icons/social/facebook.svg"
                                     alt="facebook social icon" data-inject-svg/>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text=Диаграммы%20сгорания%20в%20контексте%20SAFe%20-%20https://www.ampleev.com/blog-article"
                               class="btn btn-round btn-primary mx-1">
                                <img class="icon icon-sm" src="assets/img/icons/social/twitter.svg"
                                     alt="twitter social icon" data-inject-svg/>
                            </a>

                        </div>
                    </div>
                    <hr>
                    <h5 class="my-4">Всего комментариев: {{$article->get_comments_counter()}}</h5>
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
                                    <ol class="comments">
                                        <li class="comment">
                                            <div class="d-flex align-items-center text-small">
                                                <img src="assets/img/avatars/male-5.jpg" alt="Lenny Sims"
                                                     class="avatar avatar-sm mr-2">
                                                <div class="text-dark mr-1">Lenny Sims</div>
                                                <div class="text-muted">just now</div>
                                            </div>
                                            <div class="my-2">
                                                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                                                dolore eu
                                                fugiat nulla pariatur.
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
                                                        Duis aute irure dolor in reprehenderit in voluptate velit esse
                                                        cillum dolore eu
                                                        fugiat nulla pariatur.
                                                    </div>
                                                    <div>
                                                        <a href="#" class="text-small">Reply</a>
                                                    </div>
                                                    <ol class="comments">
                                                        <li class="comment">
                                                            <div class="d-flex align-items-center text-small">
                                                                <img src="assets/img/avatars/male-5.jpg"
                                                                     alt="Lenny Sims"
                                                                     class="avatar avatar-sm mr-2">
                                                                <div class="text-dark mr-1">Lenny Sims</div>
                                                                <div class="text-muted">just now</div>
                                                            </div>
                                                            <div class="my-2">
                                                                Duis aute irure dolor in reprehenderit in voluptate
                                                                velit esse cillum dolore eu
                                                                fugiat nulla pariatur.
                                                            </div>
                                                            <div>
                                                                <a href="#" class="text-small">Reply</a>
                                                            </div>
                                                        </li>
                                                    </ol>
                                                </li>
                                            </ol>
                                        </li>
                                    </ol>
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
                            <a href="https://twitter.com/intent/tweet?text=Диаграммы%20сгорания%20в%20контексте%20SAFe%20-%20https://www.ampleev.com/blog-article"
                               class="nav-link">
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
                            <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.ampleev.com/blog-article&display=popup"
                               class="nav-link">
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