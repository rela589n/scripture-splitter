<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Verse;
use App\Model\VerseDescriptor;
use Twig\Environment;
use Twig\Error\Error;

final readonly class ObsidianFormatter
{
    public function __construct(
        private Environment $twig,
    ) {
    }

    /**
     * @param string $chapterReference
     * @param list<Verse> $verses
     *
     * @throws Error
     *
     * @return list<VerseDescriptor>
     */
    public function format(string $chapterReference, array $verses): array
    {
        $descriptors = [];

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

        return $descriptors;
    }
}
