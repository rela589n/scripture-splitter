<?php

declare(strict_types=1);

namespace App\Model\File;

use App\Model\Passage;
use App\Service\FileDescriptor;

final readonly class PassageDescriptor implements FileDescriptor
{
    public function __construct(
        private string $chapterReference,
        private Passage $passage,
        private string $content,
    ) {
    }

    public function getFileName(): string
    {
        return sprintf(
            '%s %d-%d.md',
            $this->chapterReference,
            $this->passage->getStartVerseNumber(),
            $this->passage->getEndVerseNumber(),
        );
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
