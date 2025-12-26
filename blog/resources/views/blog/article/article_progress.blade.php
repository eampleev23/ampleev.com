<div class="article-progress" data-sticky="below-nav">
    <progress class="reading-position" value="0"></progress>
    <div class="article-progress-wrapper">
        <div class="container">
            <div class="row">
                <div class="col py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <div class="text-small text-muted mr-1">Читаете:</div>
                            <div class="text-small">{!!$article->html_title!!}</div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="text-small text-muted">Поделиться:</span>
                            <div class="d-flex ml-1">
                                @if(empty($is_ru) || !$is_ru)
                                    <a href="{{$article->tweetHrefGenerate()}}"
                                       class="mx-1 btn btn-sm btn-round btn-primary"
                                       data-share-network="x"
                                       target="_blank" rel="noopener nofollow">
                                        <img class="icon" src="/assets/img/x-social.svg"
                                             alt="x social icon" data-inject-svg/>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show_article', $article->text_url)) }}&display=popup"
                                       class="mx-1 btn btn-sm btn-round btn-primary"
                                       data-share-network="facebook"
                                       target="_blank" rel="noopener nofollow">
                                        <img class="icon" src="/assets/img/icons/social/facebook.svg"
                                             alt="facebook social icon" data-inject-svg/>
                                    </a>
                                @endif
                                <a href="{{$article->telegramHrefGenerate()}}"
                                   class="mx-1 btn btn-sm btn-round btn-primary"
                                   data-share-network="telegram"
                                   target="_blank" rel="noopener nofollow">
                                    <img class="icon" src="/assets/img/icons/social/telegram-plane-svgrepo-com.svg"
                                         alt="telegram social icon" data-inject-svg/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
