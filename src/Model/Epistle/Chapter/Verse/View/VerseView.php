<?php

declare(strict_types=1);

namespace App\Model\Epistle\Chapter\Verse\View;

use App\Model\Epistle\Chapter\Verse\Verse;
use App\Service\FileView;

final readonly class VerseView implements FileView
{
    public function __construct(
        private Verse $verse,
        private string $content,
    ) {
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getFileName(): string
    {
        return sprintf(
            '%s %d %s.md',
            $this->verse->getChapter()->getReference(),
            $this->verse->getNumber(),
            $this->verse->getTranslationName(),
        );
    }
}
