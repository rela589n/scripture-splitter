<?php

declare(strict_types=1);

namespace App\Model;

final readonly class VerseDescriptor
{
    public function __construct(
        private string $chapterReference,
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
        return sprintf('%s %d.md', $this->chapterReference, $this->verse->getNumber());
    }
}
