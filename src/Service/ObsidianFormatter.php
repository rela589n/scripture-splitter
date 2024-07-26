<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\File\PassageDescriptor;
use App\Model\File\VerseDescriptor;
use App\Model\Passage;
use Twig\Environment;
use Twig\Error\Error;

final readonly class ObsidianFormatter
{
    public function __construct(
        private Environment $twig,
    ) {
    }

    /**
     * @throws Error
     *
     * @return list<VerseDescriptor>
     */
    public function format(string $chapterReference, Passage $passage): array
    {
        $descriptors = [];

        $verses = $passage->getVerses();

        foreach ($verses as $index => $verse) {
            $previousVerse = $verses[$index - 1] ?? null;
            $nextVerse = $verses[$index + 1] ?? null;

            $content = $this->twig->render('verse.md.twig', [
                'chapterReference' => $chapterReference,
                'previousVerse' => $previousVerse,
                'verse' => $verse,
                'nextVerse' => $nextVerse,
            ]);

            $descriptors[] = new VerseDescriptor($chapterReference, $verse, $content);
        }

        $passageContent = $this->twig->render('passage.md.twig', [
            'chapterReference' => $chapterReference,
            'passage' => $passage,
        ]);

        $descriptors[] = new PassageDescriptor($chapterReference, $passage, $passageContent);

        return $descriptors;
    }
}
