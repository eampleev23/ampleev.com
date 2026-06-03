@php
    use App\Support\SiteLocale;

    $shareArticleRoute = SiteLocale::routeNameForLocale('blog.show_article', $site_locale ?? 'ru');
    $shareArticleUrl = route($shareArticleRoute, $article->text_url);
    $shareCopy = ($site_locale ?? 'ru') === 'en'
        ? ['x' => 'Share on X', 'facebook' => 'Share on Facebook', 'telegram' => 'Share on Telegram', 'progress' => 'Article reading progress']
        : ['x' => 'Поделиться в X', 'facebook' => 'Поделиться в Facebook', 'telegram' => 'Поделиться в Telegram', 'progress' => 'Прогресс чтения статьи'];
@endphp

<div class="article-progress" data-sticky="below-nav">
    <progress class="reading-position" value="0" max="100" aria-label="{{ $shareCopy['progress'] }}"></progress>
    <div class="article-progress-wrapper">
        <div class="container">
            <div class="row">
                <div class="col py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <div class="text-small text-muted mr-1">{{ $locale_labels['reading_now'] ?? 'Читаете:' }}</div>
                            <div class="text-small">{!!$article->html_title!!}</div>
                        </div>
                        <div class="d-flex align-items-center article-progress-share">
                            <span class="text-small text-muted article-progress-share-label">{{ $locale_labels['share'] ?? 'Поделиться:' }}</span>
                            <div class="d-flex ml-1">
                                @if(empty($is_ru) || !$is_ru)
                                    <a href="{{$article->tweetHrefGenerate()}}"
                                       class="mx-1 btn btn-sm btn-round btn-primary"
                                       data-share-network="x"
                                       target="_blank" rel="noopener noreferrer nofollow"
                                       aria-label="{{ $shareCopy['x'] }}">
                                        <img class="icon" src="/assets/img/x-social.svg"
                                             alt="" aria-hidden="true" data-inject-svg/>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareArticleUrl) }}&display=popup"
                                       class="mx-1 btn btn-sm btn-round btn-primary"
                                       data-share-network="facebook"
                                       target="_blank" rel="noopener noreferrer nofollow"
                                       aria-label="{{ $shareCopy['facebook'] }}">
                                        <img class="icon" src="/assets/img/icons/social/facebook.svg"
                                             alt="" aria-hidden="true" data-inject-svg/>
                                    </a>
                                @endif
                                <a href="{{$article->telegramHrefGenerate()}}"
                                   class="mx-1 btn btn-sm btn-round btn-primary"
                                   data-share-network="telegram"
                                   target="_blank" rel="noopener noreferrer nofollow"
                                   aria-label="{{ $shareCopy['telegram'] }}">
                                    <img class="icon" src="/assets/img/icons/social/telegram-plane-svgrepo-com.svg"
                                         alt="" aria-hidden="true" data-inject-svg/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
