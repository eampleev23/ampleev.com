<?php

namespace App\Helpers;

class Transliterator
{
    /**
     * Транслитерация русского текста в латиницу для URL
     * 
     * @param string $text
     * @return string
     */
    public static function transliterate($text)
    {
        $translitMap = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
            'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'Ts', 'Ч' => 'Ch',
            'Ш' => 'Sh', 'Щ' => 'Sch', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        ];

        $text = mb_strtolower($text, 'UTF-8');
        $text = strtr($text, $translitMap);
        
        // Заменяем пробелы и специальные символы на подчеркивания
        $text = preg_replace('/[^a-z0-9_]+/u', '_', $text);
        
        // Убираем множественные подчеркивания
        $text = preg_replace('/_+/', '_', $text);
        
        // Убираем подчеркивания в начале и конце
        $text = trim($text, '_');
        
        return $text;
    }

    /**
     * Генерирует text_url из title
     * 
     * @param string $title
     * @return string
     */
    public static function generateTextUrl($title)
    {
        return self::transliterate($title);
    }
}





