@php
    use App\Support\SiteLocale;

    $shareArticleRoute = SiteLocale::routeNameForLocale('blog.show_article', $site_locale ?? 'ru');
    $shareArticleUrl = route($shareArticleRoute, $article->text_url);
@endphp

<div class="d-flex align-items-center">
    <span class="text-small mr-1">{{ $locale_labels['share_article'] ?? 'Поделиться этой статьей:' }}</span>
    <div class="d-flex mx-2">
        @if(empty($is_ru) || !$is_ru)
            <a href="{{$article->tweetHrefGenerate()}}"
               class="btn btn-round btn-primary mx-1"
               data-share-network="x"
               target="_blank" rel="noopener nofollow">
                <img class="icon icon-sm" src="/assets/img/x-social.svg"
                     alt="x social icon" data-inject-svg/>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareArticleUrl) }}&display=popup"
               class="btn btn-round btn-primary mx-1"
               data-share-network="facebook"
               target="_blank" rel="noopener nofollow">
                <img class="icon icon-sm" src="/assets/img/icons/social/facebook.svg"
                     alt="facebook social icon" data-inject-svg/>
            </a>
        @endif
        <a href="{{$article->telegramHrefGenerate()}}"
           class="btn btn-round btn-primary mx-1"
           data-share-network="telegram"
           target="_blank" rel="noopener nofollow">
            <img class="icon icon-sm" src="/assets/img/icons/social/telegram-plane-svgrepo-com.svg"
                 alt="telegram social icon" data-inject-svg/>
        </a>
    </div>
</div>
