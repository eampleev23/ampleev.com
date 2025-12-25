<?php

namespace App\Console\Commands;

use App\BlogSection;
use Illuminate\Console\Command;

class SetBlogSectionShortTitle extends Command
{
    protected $signature = 'blog:section-short-title
                            {identifier : ID (число) или точное название раздела}
                            {short_title : Короткое название}
                            {--clear : Очистить значение (установить NULL)}';

    protected $description = 'Задает короткое название (short_title) для категории/раздела блога';

    public function handle(): int
    {
        $identifier = (string) $this->argument('identifier');

        $section = null;
        if (ctype_digit($identifier)) {
            $section = BlogSection::find((int) $identifier);
        }

        if (!$section) {
            $section = BlogSection::where('title', $identifier)->first();
        }

        if (!$section) {
            $this->error('Раздел не найден. Укажи ID или точное title из БД.');
            return 1;
        }

        if ($this->option('clear')) {
            $section->short_title = null;
            $section->save();
            $this->info("OK: short_title очищен для '{$section->title}' (id={$section->id})");
            return 0;
        }

        $short = trim((string) $this->argument('short_title'));
        if ($short === '') {
            $this->error('short_title не должен быть пустым (или используй --clear).');
            return 1;
        }

        if (mb_strlen($short) > 50) {
            $this->error('short_title слишком длинный (макс 50 символов).');
            return 1;
        }

        $section->short_title = $short;
        $section->save();

        $this->info("OK: '{$section->title}' → short_title='{$section->short_title}' (id={$section->id})");
        return 0;
    }
}


