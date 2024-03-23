<?php

namespace Src\Helpers;

class File
{
    public const FILE_NAME = 'out.csv';

    private string $content = '';

    public function putLine(string $line): void
    {
        $this->content .= str_replace('.', ',', $line) . "\n";
    }

    public function save(): void
    {
        if (file_exists(self::FILE_NAME)) {
            unlink(self::FILE_NAME);
        }

        file_put_contents(self::FILE_NAME, $this->content);
    }
}
