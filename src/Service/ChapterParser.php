<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Epistle\Chapter\Chapter;
use App\Model\Epistle\Epistle;

final readonly class ChapterParser
{
    public function __construct(
        private VerseFileReader $reader,
        private ChapterVersesParser $versesParser,
    ) {
    }

    public function parse(Epistle $epistle, int $number, string $chapterReference, string $inputFileName): Chapter
    {
        $chapter = Chapter::parse($epistle, $number, $chapterReference);

        $inputText = $this->reader->read($inputFileName);

        $this->versesParser->parse($chapter, $inputText);

        return $chapter;
    }
}
