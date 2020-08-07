<div class="mb-4">
    <h5>Последнее в блоге</h5>
    <ul class="list-unstyled list-articles">
        @for($i=0; $i < count($top_articles); $i++)
            <li class="row row-tight">
                <a href="{{route('blog.show_article',$top_articles[$i]->text_url)}}"
                   class="col-3">
                    <img src="{{$top_articles[$i]->main_image_path}}" alt="Image" class="rounded">
                </a>
                <div class="col">
                    <a href="{{route('blog.show_article',$top_articles[$i]->text_url)}}">
                        <h6 class="mb-1">{{$top_articles[$i]->title}}</h6>
                    </a>
                    <div class="d-flex text-small">
                        <a href="#">{{$top_articles[$i]->blog_section->title}}</a>
                        <span class="text-muted ml-1">{{$top_articles[$i]->get_nice_time_created()}}</span>
                    </div>
                </div>
            </li>
        @endfor
    </ul>
</div>