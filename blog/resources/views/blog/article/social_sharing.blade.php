<div class="d-flex align-items-center">
    <span class="text-small mr-1">Поделиться этой статьей:</span>
    <div class="d-flex mx-2">
        <a href="{{$article->tweetHrefGenerate()}}"
           class="btn btn-round btn-primary mx-1">
            <img class="icon icon-sm" src="/assets/img/x-social.svg"
                 alt="x social icon" data-inject-svg/>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{route('blog.show_article', $article->text_url)}}&display=popup"
           class="btn btn-round btn-primary mx-1">
            <img class="icon icon-sm" src="/assets/img/icons/social/facebook.svg"
                 alt="facebook social icon" data-inject-svg/>
        </a>
        <a href="{{$article->telegramHrefGenerate()}}"
           class="btn btn-round btn-primary mx-1">
            <img class="icon icon-sm" src="/assets/img/icons/social/telegram-plane-svgrepo-com.svg"
                 alt="telegram social icon" data-inject-svg/>
        </a>
    </div>
</div>
