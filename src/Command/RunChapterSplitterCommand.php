<?php

namespace App\Command;

use App\Service\ChapterSplitter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Webmozart\Assert\Assert;

#[AsCommand(
    name: 'splitter:run',
    description: 'Run chapter splitter',
)]
final class RunChapterSplitterCommand extends Command
{
    public function __construct(
        private readonly ChapterSplitter $splitter,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('chapterRef', InputArgument::REQUIRED, 'Chapter reference, example: "Івана 11"')
            ->addOption('inputFile', null, InputOption::VALUE_OPTIONAL, 'Input file name', 'input.txt')
            ->addOption('outputDir', null, InputOption::VALUE_OPTIONAL, 'Output file directory name', 'output/')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string $chapterReference */
        $chapterReference = $input->getArgument('chapterRef');
        Assert::notEmpty($chapterReference);

        /** @var string $inputFileName */
        $inputFileName = $input->getOption('inputFile');
        Assert::notEmpty($inputFileName);

        /** @var string $outputDirName */
        $outputDirName = $input->getOption('outputDir');
        Assert::notEmpty($outputDirName);

        $this->splitter->run($inputFileName, $chapterReference, $outputDirName);

        $io->success('Files have been successfully written');

        return Command::SUCCESS;
    }
}
