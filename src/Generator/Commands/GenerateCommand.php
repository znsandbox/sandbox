<?php

namespace ZnSandbox\Sandbox\Generator\Commands;

use Illuminate\Support\Collection;
use Symfony\Component\Console\Command\Command;
use ZnLib\Console\Symfony4\Question\ChoiceQuestion;
use ZnSandbox\Sandbox\Generator\Domain\Services\GeneratorService;
use ZnTool\Package\Domain\Entities\PackageEntity;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{

    protected static $defaultName = 'generator:generate';

    private $generatorService;

    public function __construct(string $name = null, GeneratorService $generatorService)
    {
        parent::__construct($name);
        $this->generatorService = $generatorService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<fg=white># Generator</>');

        $tableList = $this->generatorService->allTables();

        if (empty($tableList)) {
            $output->writeln('');
            $output->writeln('<fg=magenta>No tables in database!</>');
            $output->writeln('');
            return 0;
        }

        $output->writeln('');
        $question = new ChoiceQuestion(
            'Select tables for export',
            $tableList,
            'a'
        );
        $question->setMultiselect(true);
        $selectedTables = $this->getHelper('question')->ask($input, $output, $question);
        //dd($selectedTables);

        $structure = $this->generatorService->getStructure($selectedTables);

        dd($structure);
        return 0;
    }
}
