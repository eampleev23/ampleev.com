<?php

namespace App\Services\Yai;

/**
 * Режет плоский текст документа на чанки для индексации.
 * Границы — только по абзацам (середина предложения не рвётся),
 * целевой размер ~2400 символов (~600-800 токенов), перехлёст — последний
 * абзац предыдущего чанка, чтобы ответ на стыке абзацев не терял контекст.
 */
class Chunker
{
    private const TARGET_CHARS = 2400;
    private const MAX_CHARS = 3400;
    private const OVERLAP_MAX_CHARS = 500;

    /**
     * @return string[] тексты чанков
     */
    public function split(string $text): array
    {
        $paragraphs = preg_split('/\n{2,}/u', trim($text), -1, PREG_SPLIT_NO_EMPTY);
        $paragraphs = array_values(array_filter(array_map('trim', $paragraphs), fn ($p) => $p !== ''));

        if ($paragraphs === []) {
            return [];
        }

        $chunks = [];
        $current = '';
        $lastParagraph = '';

        foreach ($paragraphs as $paragraph) {
            // Абзац-гигант делим по предложениям, чтобы не выйти за MAX_CHARS
            if (mb_strlen($paragraph) > self::MAX_CHARS) {
                $paragraph = $this->softWrapLongParagraph($paragraph);
            }

            if ($current !== '' && mb_strlen($current) + mb_strlen($paragraph) > self::TARGET_CHARS) {
                $chunks[] = $current;
                $overlap = mb_strlen($lastParagraph) <= self::OVERLAP_MAX_CHARS ? $lastParagraph : '';
                $current = $overlap === '' ? '' : $overlap . "\n\n";
            }

            $current .= ($current === '' ? '' : "\n\n") . $paragraph;
            $lastParagraph = $paragraph;
        }

        if (trim($current) !== '') {
            $chunks[] = $current;
        }

        return $chunks;
    }

    private function softWrapLongParagraph(string $paragraph): string
    {
        $sentences = preg_split('/(?<=[.!?…])\s+/u', $paragraph, -1, PREG_SPLIT_NO_EMPTY);
        $parts = [];
        $buffer = '';

        foreach ($sentences as $sentence) {
            if ($buffer !== '' && mb_strlen($buffer) + mb_strlen($sentence) > self::TARGET_CHARS) {
                $parts[] = $buffer;
                $buffer = '';
            }
            $buffer .= ($buffer === '' ? '' : ' ') . $sentence;
        }
        if ($buffer !== '') {
            $parts[] = $buffer;
        }

        return implode("\n\n", $parts);
    }
}
