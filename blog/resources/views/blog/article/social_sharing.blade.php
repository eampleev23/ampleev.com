@php
    use App\Support\SiteLocale;

    $shareArticleRoute = SiteLocale::routeNameForLocale('blog.show_article', $site_locale ?? 'ru');
    $shareArticleUrl = route($shareArticleRoute, $article->text_url);
    $shareCopy = ($site_locale ?? 'ru') === 'en'
        ? ['x' => 'Share on X', 'facebook' => 'Share on Facebook', 'telegram' => 'Share on Telegram']
        : ['x' => 'Поделиться в X', 'facebook' => 'Поделиться в Facebook', 'telegram' => 'Поделиться в Telegram'];
@endphp

<div class="d-flex align-items-center">
    <span class="text-small mr-1">{{ $locale_labels['share_article'] ?? 'Поделиться этой статьей:' }}</span>
    <div class="d-flex mx-2">
        @if(empty($is_ru) || !$is_ru)
            <a href="{{$article->tweetHrefGenerate()}}"
               class="btn btn-round btn-primary mx-1"
               data-share-network="x"
               target="_blank" rel="noopener noreferrer nofollow"
               aria-label="{{ $shareCopy['x'] }}">
                <img class="icon icon-sm" src="/assets/img/x-social.svg"
                     alt="" aria-hidden="true" data-inject-svg/>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareArticleUrl) }}&display=popup"
               class="btn btn-round btn-primary mx-1"
               data-share-network="facebook"
               target="_blank" rel="noopener noreferrer nofollow"
               aria-label="{{ $shareCopy['facebook'] }}">
                <img class="icon icon-sm" src="/assets/img/icons/social/facebook.svg"
                     alt="" aria-hidden="true" data-inject-svg/>
            </a>
        @endif
        <a href="{{$article->telegramHrefGenerate()}}"
           class="btn btn-round btn-primary mx-1"
           data-share-network="telegram"
           target="_blank" rel="noopener noreferrer nofollow"
           aria-label="{{ $shareCopy['telegram'] }}">
            <img class="icon icon-sm" src="/assets/img/icons/social/telegram-plane-svgrepo-com.svg"
                 alt="" aria-hidden="true" data-inject-svg/>
        </a>
    </div>
</div>
