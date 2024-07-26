<?php

declare(strict_types=1);

namespace App\Model\File;

use App\Model\Verse;
use App\Service\FileDescriptor;

final readonly class VerseDescriptor implements FileDescriptor
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
