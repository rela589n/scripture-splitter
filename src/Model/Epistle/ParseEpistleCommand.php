<?php

namespace App\Model\Epistle;

use App\Model\Epistle\Chapter\ChapterObsidianFormatter;
use App\Model\Epistle\Chapter\ChapterRange;
use App\Service\VerseFileWriter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Webmozart\Assert\Assert;

#[AsCommand(
    name: 'app:epistle:parse',
    description: 'Parse epistle',
)]
class ParseEpistleCommand extends Command
{
    public function __construct(
        private readonly EpistleParser $parser,
        private readonly ChapterObsidianFormatter $formatter,
        private readonly VerseFileWriter $writer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('epistleName', InputArgument::REQUIRED, 'Epistle name, example: "Івана"')
            ->addOption('workDir', null, InputOption::VALUE_REQUIRED, 'Working directory')
            ->addOption('range', null, InputOption::VALUE_REQUIRED, 'Chapters range');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string $epistleName */
        $epistleName = $input->getArgument('epistleName');
        Assert::notEmpty($epistleName);

        /** @var string $workDirName */
        $workDirName = $input->getOption('workDir');
        Assert::notEmpty($workDirName);

        /** @var array $chapterRangeArray */
        $chapterRangeArray = explode('-', $input->getOption('range'));
        $chapterRange = new ChapterRange((int)$chapterRangeArray[0], (int)$chapterRangeArray[1]);

        $epistle = $this->parser->parse($epistleName, $workDirName, $chapterRange);

        foreach ($epistle->getChapters() as $chapter) {
            $outputDirName = sprintf('%s%d/', $workDirName, $chapter->getNumber());

            $verseDescriptors = $this->formatter->format($chapter);

            $this->writer->write($outputDirName, $verseDescriptors);
        }

        $io->success('Files have been successfully written');

        return Command::SUCCESS;
    }
}
