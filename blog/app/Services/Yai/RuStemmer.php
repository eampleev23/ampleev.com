<?php

namespace App\Services\Yai;

/**
 * Стеммер Портера для русского языка (алгоритм Snowball).
 * Без стемминга BM25 по русскому корпусу почти не работает:
 * «планирование/планирования/планированию» должны сводиться к одной основе.
 */
class RuStemmer
{
    private const VOWELS = 'аеиоуыэюя';

    private const PERFECTIVE_GROUND = '/((ив|ивши|ившись|ыв|ывши|ывшись)|((?<=[ая])(в|вши|вшись)))$/u';
    private const REFLEXIVE = '/(с[яь])$/u';
    private const ADJECTIVE = '/(ее|ие|ые|ое|ими|ыми|ей|ий|ый|ой|ем|им|ым|ом|его|ого|ему|ому|их|ых|ую|юю|ая|яя|ою|ею)$/u';
    private const PARTICIPLE = '/((ивш|ывш|ующ)|((?<=[ая])(ем|нн|вш|ющ|щ)))$/u';
    private const VERB = '/((ила|ыла|ена|ейте|уйте|ите|или|ыли|ей|уй|ил|ыл|им|ым|ен|ило|ыло|ено|ят|ует|уют|ит|ыт|ены|ить|ыть|ишь|ую|ю)|((?<=[ая])(ла|на|ете|йте|ли|й|л|ем|н|ло|но|ет|ют|ны|ть|ешь|нно)))$/u';
    private const NOUN = '/(а|ев|ов|ие|ье|е|иями|ями|ами|еи|ии|и|ией|ей|ой|ий|й|иям|ям|ием|ем|ам|ом|о|у|ах|иях|ях|ы|ь|ию|ью|ю|ия|ья|я)$/u';
    private const DERIVATIONAL = '/[^аеиоуыэюя][аеиоуыэюя].*ость?$/u';
    private const DER_SUFFIX = '/ость?$/u';
    private const SUPERLATIVE = '/(ейше|ейш)$/u';

    public function stem(string $word): string
    {
        $word = str_replace('ё', 'е', mb_strtolower($word));

        if (!preg_match('/^(.*?[' . self::VOWELS . '])(.*)$/u', $word, $m)) {
            return $word; // нет гласных — стеммить нечего
        }

        $prefix = $m[1];
        $rv = $m[2];

        // Шаг 1
        $temp = preg_replace(self::PERFECTIVE_GROUND, '', $rv, 1, $count);
        if ($count > 0) {
            $rv = $temp;
        } else {
            $rv = preg_replace(self::REFLEXIVE, '', $rv, 1);

            $temp = preg_replace(self::ADJECTIVE, '', $rv, 1, $count);
            if ($count > 0) {
                $rv = preg_replace(self::PARTICIPLE, '', $temp, 1);
            } else {
                $temp = preg_replace(self::VERB, '', $rv, 1, $count);
                if ($count > 0) {
                    $rv = $temp;
                } else {
                    $rv = preg_replace(self::NOUN, '', $rv, 1);
                }
            }
        }

        // Шаг 2: убрать конечное «и»
        $rv = preg_replace('/и$/u', '', $rv, 1);

        // Шаг 3: словообразовательный суффикс «ость/ост»
        if (preg_match(self::DERIVATIONAL, $rv)) {
            $rv = preg_replace(self::DER_SUFFIX, '', $rv, 1);
        }

        // Шаг 4: «ь», превосходная степень, «нн» → «н»
        $temp = preg_replace('/ь$/u', '', $rv, 1, $count);
        if ($count > 0) {
            $rv = $temp;
        } else {
            $rv = preg_replace(self::SUPERLATIVE, '', $rv, 1);
            $rv = preg_replace('/нн$/u', 'н', $rv, 1);
        }

        return $prefix . $rv;
    }
}
