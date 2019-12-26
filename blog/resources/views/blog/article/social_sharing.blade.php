<div class="d-flex align-items-center">
    {{--                        <span class="text-small mr-1">Поделиться этой статьей:</span>--}}
    <div class="d-flex mx-2">
        {{--                            <div--}}
        {{--                                    class="fb-like"--}}
        {{--                                    data-share="true"--}}
        {{--                                    data-width="450"--}}
        {{--                                    data-show-faces="true">--}}
        {{--                            </div>--}}
        <a href="https://www.facebook.com/sharer/sharer.php?u={{route('blog.show_article', $article->text_url)}}&display=popup"
           class="btn btn-round btn-primary mx-1">
            <img class="icon icon-sm" src="assets/img/icons/social/facebook.svg"
                 alt="facebook social icon" data-inject-svg/>
        </a>
        <a href="{{$article->tweetHrefGenerate()}}"
           class="btn btn-round btn-primary mx-1">
            <img class="icon icon-sm" src="assets/img/icons/social/twitter.svg"
                 alt="twitter social icon" data-inject-svg/>
        </a>

    </div>
</div>
