<?php

declare(strict_types=1);

namespace App\Model\File;

use App\Model\Chapter;
use App\Service\FileDescriptor;

final readonly class ChapterDescriptor implements FileDescriptor
{
    public function __construct(
        private Chapter $chapter,
        private string $content,
    ) {
    }

    public function getFileName(): string
    {
        return sprintf(
            '%s %d-%d.md',
            $this->chapter->getReference(),
            $this->chapter->getFirstVerseNumber(),
            $this->chapter->getLastVerseNumber(),
        );
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
