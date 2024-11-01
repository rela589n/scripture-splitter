<?php

declare(strict_types=1);

namespace App\Model\Epistle\Chapter\View;

use App\Model\Epistle\Chapter\Chapter;
use App\Service\FileView;

final readonly class ChapterView implements FileView
{
    public function __construct(
        private Chapter $chapter,
        private string $content,
    ) {
    }

    public function getFileName(): string
    {
        return sprintf(
            '%s %s.md',
            $this->chapter->getReference(),
            $this->chapter->getTranslationName(),
        );
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
