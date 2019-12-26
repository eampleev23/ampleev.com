<div class="col-md-8 col-lg-9">


    @for($i=0; $i < count($articles); $i++)
        <div class="pr-lg-4">
            <div class="card card-article-wide flex-md-row no-gutters">
                <a href="{{route('blog.show_article',$articles[$i]->id)}}" class="col-md-4">
                    {{--                    <img src="{{$articles[$i]->main_image_path}}" alt="Image" class="card-img-top">--}}
                    <img src="{{$articles[$i]->main_image_path}}" alt="Image" class="card-img-top">
                </a>
                <div class="card-body d-flex flex-column col-auto p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="text-small d-flex">
                            <div class="mr-2">
                                <a href="#">SAFe</a>
                            </div>
                            <span class="text-muted">{{$articles[$i]->get_nice_time_created()}}</span>
                        </div>
                        <span class="badge bg-primary-alt text-primary">
                      <img class="icon icon-sm bg-primary" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"
                           alt="heart interface icon" data-inject-svg/>{{$articles[$i]->views_count}}
                    </span>
                    </div>
                    <a href="{{route('blog.show_article',1)}}" class="flex-grow-1">
                        <h3>{{$articles[$i]->title}}</h3>
                    </a>
                    <div class="d-flex align-items-center mt-3">
                        <img src="assets/img/avatars/female-3_my.jpg" alt="Image" class="avatar avatar-sm">
                        <div class="ml-1">
                            <span class="text-small">Амплеев Евгений</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endfor


</div>