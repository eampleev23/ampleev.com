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
                                <a href="{{$article->tweetHrefGenerate()}}"
                                   class="mx-1 btn btn-sm btn-round btn-primary">
                                    <img class="icon" src="assets/img/icons/social/twitter.svg"
                                         alt="twitter social icon" data-inject-svg/>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{route('blog.show_article', $article->id)}}&display=popup"
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
