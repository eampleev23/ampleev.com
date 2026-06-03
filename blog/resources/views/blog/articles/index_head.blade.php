@if(!isset($blog_section))
    @php
        $currentLocale = $site_locale ?? 'ru';
        $headline = $copy['title'] ?? ($currentLocale === 'en' ? 'Blog' : 'Блог');
        $description = $copy['description'] ?? '';
        $eyebrow = $currentLocale === 'en' ? 'Editorial field notes' : 'Редакционный журнал';
        $note = $currentLocale === 'en'
            ? 'Product delivery, Agile practice, and AI without ritual theatre.'
            : 'Delivery, Agile-практика и AI без ритуального театра.';
        $strips = $currentLocale === 'en'
            ? ['AI in team rituals', 'Delivery craft', 'Evidence over fashion']
            : ['AI в командных встречах', 'Delivery-практика', 'Доказательность вместо моды'];
    @endphp

    <section class="blog-index-head blog-index-head--editorial has-divider" aria-labelledby="blog-index-title">
        <div class="container">
            <div class="blog-index-head__grid">
                <div>
                    <div class="blog-index-head__eyebrow">{{ $eyebrow }}</div>
                    <h1 id="blog-index-title">{{ $headline }}</h1>
                    @if($description)
                        <p>{{ $description }}</p>
                    @endif
                </div>
                <aside class="blog-index-head__note" aria-label="{{ $currentLocale === 'en' ? 'Blog positioning' : 'Позиционирование блога' }}">
                    <span>{{ $note }}</span>
                    <div class="blog-index-head__strips" aria-hidden="true">
                        @foreach($strips as $strip)
                            <i>{{ $strip }}</i>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endif
