<section class="bg-primary-alt">
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h3 class="h2">Возможно, вам будет интересно</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            @for($i=0; $i < count($random_articles); $i++)
                <div class="col-md-6 col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="200">
                    <div class="card">
                        <a href="{{route('blog.show_article',$random_articles[$i]->text_url)}}">
                            <img src="{{$random_articles[$i]->main_image_path}}" alt="Image" class="card-img-top">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="text-small d-flex">
                                    <div class="mr-2">
                                        <a href="{{route('blog.show_blog_section', str_replace('/', '_SLASH_', $random_articles[$i]->blog_section->title))}}">
                                            {{$random_articles[$i]->blog_section->short_title_for_display}}
                                        </a>
                                    </div>
                                    <span class="text-muted">{{$random_articles[$i]->get_nice_day_created()}}</span>
                                </div>
                                <span class="badge bg-primary-alt text-primary">
                                <img class="icon icon-sm bg-primary mr-1"
                                     src="/assets/img/icons/theme/general/visible.svg"
                                     alt="visible icon"
                                     style="transform: scale(1.3);"
                                     data-inject-svg/>{{$random_articles[$i]->views_count}}
                              </span>
                            </div>
                            <a href="{{route('blog.show_article',$random_articles[$i]->text_url)}}">
                                <h4>{!!$random_articles[$i]->html_title!!}</h4>
                            </a>
                            <p class="flex-grow-1">
                                {{$random_articles[$i]->seo_description}}
                            </p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="{{env('APP_URL').$random_articles[$i]->user->avatar_path}}" alt="Image"
                                     class="avatar avatar-sm">
                                <div class="ml-1">
                                    <span class="text-small">{{$random_articles[$i]->user->name}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
