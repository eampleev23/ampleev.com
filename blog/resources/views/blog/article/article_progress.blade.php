@php
    use App\Support\SiteLocale;

    $shareArticleRoute = SiteLocale::routeNameForLocale('blog.show_article', $site_locale ?? 'ru');
    $shareArticleUrl = route($shareArticleRoute, $article->text_url);
    $progressSeries = $article->seriesCard();
    $progressAccentStyle = ($progressSeries && !empty($progressSeries['accent_var']))
        ? '--article-accent: var(' . $progressSeries['accent_var'] . ');'
        : '';
@endphp

<div class="article-progress" data-sticky="below-nav" @if($progressAccentStyle) style="{{ $progressAccentStyle }}" @endif>
    <progress class="reading-position" value="0"></progress>
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
                                       target="_blank" rel="noopener nofollow">
                                        <img class="icon" src="/assets/img/x-social.svg"
                                             alt="x social icon" data-inject-svg/>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareArticleUrl) }}&display=popup"
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
