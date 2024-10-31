<?php

declare(strict_types=1);

namespace App\Model\Epistle\Chapter;

use App\Model\Epistle\Chapter\Verse\ChapterVersesParser;
use App\Model\Epistle\Epistle;
use App\Service\VerseFileReader;

final readonly class ChapterParser
{
    public function __construct(
        private VerseFileReader $reader,
        private ChapterVersesParser $versesParser,
    ) {
    }

    public function parse(Epistle $epistle, int $number, string $inputFileName): Chapter
    {
        $chapter = Chapter::parse($epistle, $number);

        $inputText = $this->reader->read($inputFileName);

        $this->versesParser->parse($chapter, $inputText);

        return $chapter;
    }
}
