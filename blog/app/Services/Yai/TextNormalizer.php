<?php

namespace App\Services\Yai;

/**
 * Приводит текст к поисковым токенам: lowercase, ё→е, разбивка по не-буквам,
 * стоп-слова, стемминг (русский — Портер, английский — лёгкое усечение суффиксов).
 * Одна и та же нормализация применяется при индексации и к запросу пользователя.
 */
class TextNormalizer
{
    private const RU_STOPWORDS = [
        'и', 'в', 'во', 'на', 'не', 'что', 'как', 'это', 'с', 'со', 'по', 'для', 'к', 'ко', 'о', 'об', 'из',
        'у', 'за', 'от', 'до', 'но', 'а', 'же', 'ли', 'бы', 'то', 'так', 'или', 'при', 'чтобы', 'если',
        'когда', 'где', 'чем', 'был', 'была', 'были', 'было', 'есть', 'быть', 'его', 'ее', 'её', 'их', 'мы',
        'вы', 'они', 'он', 'она', 'оно', 'я', 'ты', 'мне', 'вам', 'нам', 'нас', 'вас', 'них', 'нем', 'нём',
        'этот', 'эта', 'эти', 'этой', 'этом', 'тот', 'та', 'те', 'том', 'свой', 'своей', 'наш', 'ваш',
        'весь', 'все', 'всё', 'всех', 'уже', 'еще', 'ещё', 'только', 'можно', 'нужно', 'очень', 'просто',
        'может', 'даже', 'ни', 'да', 'нет', 'тут', 'там', 'потому', 'поэтому', 'между', 'через', 'после',
        'без', 'под', 'над', 'про', 'также', 'тоже',
    ];

    private const EN_STOPWORDS = [
        'the', 'a', 'an', 'and', 'or', 'of', 'to', 'in', 'on', 'for', 'with', 'is', 'are', 'was', 'were',
        'be', 'been', 'being', 'it', 'its', 'this', 'that', 'these', 'those', 'as', 'at', 'by', 'from',
        'not', 'but', 'what', 'how', 'why', 'when', 'where', 'who', 'which', 'do', 'does', 'did', 'done',
        'can', 'could', 'should', 'would', 'will', 'shall', 'may', 'might', 'must', 'has', 'have', 'had',
        'i', 'you', 'we', 'they', 'he', 'she', 'their', 'our', 'your', 'my', 'me', 'us', 'them', 'his',
        'her', 'if', 'so', 'than', 'then', 'there', 'here', 'about', 'into', 'out', 'up', 'down', 'more',
        'most', 'some', 'any', 'no', 'nor', 'only', 'just', 'very', 'too', 'also', 'all', 'both', 'each',
    ];

    private RuStemmer $ruStemmer;

    /** @var array<string, true> */
    private array $stopwords;

    public function __construct()
    {
        $this->ruStemmer = new RuStemmer();
        $this->stopwords = array_fill_keys(array_merge(self::RU_STOPWORDS, self::EN_STOPWORDS), true);
    }

    /**
     * @return string[] стемы токенов текста (с повторами — частоты нужны для BM25)
     */
    public function tokenize(string $text): array
    {
        $text = str_replace('ё', 'е', mb_strtolower($text));
        $rawTokens = preg_split('/[^a-zа-я0-9]+/u', $text, -1, PREG_SPLIT_NO_EMPTY);

        $tokens = [];
        foreach ($rawTokens as $token) {
            if (mb_strlen($token) < 2 || isset($this->stopwords[$token])) {
                continue;
            }
            $tokens[] = $this->stemToken($token);
        }

        return $tokens;
    }

    private function stemToken(string $token): string
    {
        if (preg_match('/[а-я]/u', $token)) {
            return $this->ruStemmer->stem($token);
        }

        return $this->stemEnglish($token);
    }

    /**
     * Лёгкий английский стеммер: усечение частотных суффиксов с защитой длины.
     * Полный Портер здесь избыточен — корпус небольшой, а ошибки усечения
     * компенсируются BM25-ранжированием.
     */
    private function stemEnglish(string $word): string
    {
        $len = strlen($word);

        foreach (['ational' => 'ate', 'ization' => 'ize', 'fulness' => 'ful', 'iveness' => 'ive'] as $from => $to) {
            if ($len > strlen($from) + 2 && str_ends_with($word, $from)) {
                return substr($word, 0, -strlen($from)) . $to;
            }
        }

        foreach (['ements', 'ement', 'ingly', 'edly', 'tions', 'tion', 'sion', 'ities', 'ity', 'ing', 'ies', 'ied', 'ed', 'es', 'ly', 's'] as $suffix) {
            if ($len > strlen($suffix) + 2 && str_ends_with($word, $suffix)) {
                $stemmed = substr($word, 0, -strlen($suffix));
                // 'ies'/'ied' → 'y': stories → story
                if ($suffix === 'ies' || $suffix === 'ied') {
                    $stemmed .= 'y';
                }
                return $stemmed;
            }
        }

        return $word;
    }

    public function isCyrillic(string $text): bool
    {
        return (bool) preg_match('/[а-яё]/ui', $text);
    }
}
