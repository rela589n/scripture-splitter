<?php

declare(strict_types=1);

namespace App\Service;

final readonly class ChapterSplitter
{
    public function __construct(
        private VerseFileReader $reader,
        private ChapterParser $parser,
        private ChapterObsidianFormatter $formatter,
        private VerseFileWriter $writer,
    ) {
    }

    public function run(string $inputFileName, string $chapterReference, string $outputDirName): void
    {
        $inputText = $this->reader->read($inputFileName);

        $chapter = $this->parser->parse($chapterReference, $inputText);

        $verseDescriptors = $this->formatter->format($chapter);

        $this->writer->write($outputDirName, $verseDescriptors);
    }
}
