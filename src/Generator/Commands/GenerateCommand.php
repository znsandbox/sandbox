<?php

namespace ZnSandbox\Sandbox\Generator\Commands;

use Illuminate\Support\Collection;
use Symfony\Component\Console\Command\Command;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Helpers\InstanceHelper;
use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\App\Libs\ConfigManager;
use ZnCore\Domain\Interfaces\DomainInterface;
use ZnLib\Console\Symfony4\Question\ChoiceQuestion;
use ZnSandbox\Sandbox\Bundle\Domain\Entities\BundleEntity;
use ZnSandbox\Sandbox\Bundle\Domain\Interfaces\Services\BundleServiceInterface;
use ZnSandbox\Sandbox\Generator\Domain\Services\GeneratorService;
use ZnTool\Package\Domain\Entities\PackageEntity;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{

    protected static $defaultName = 'generator:generate';

    private $generatorService;
    private $bundleService;

    public function __construct(
        string $name = null,
        GeneratorService $generatorService,
        BundleServiceInterface $bundleService
    )
    {
        parent::__construct($name);
        $this->generatorService = $generatorService;
        $this->bundleService = $bundleService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<fg=white># Generator</>');

        $domainNamespace = $this->selectDomain($input, $output);
        dd($domainNamespace);

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
        $structure = $this->generatorService->getStructure($selectedTables);

        dd($structure);
        return 0;
    }

    private function selectDomain(InputInterface $input, OutputInterface $output): string {
        /** @var BundleEntity[] $bundleCollection */
        $bundleCollection = $this->bundleService->all();
        $domainCollection = [];
        $domainCollectionNamespaces = [];
        foreach ($bundleCollection as $bundleEntity) {
            if($bundleEntity->getDomain()) {
                $domainNamespace = ClassHelper::getNamespace($bundleEntity->getDomain()->getClassName());
                $domainName = $bundleEntity->getDomain()->getName();
                $title = "$domainName ($domainNamespace)";
                $domainCollection[] = $title;
                $domainCollectionNamespaces[$title] = $domainNamespace;
            }
            // dd($domainNamespace);
        }

        $output->writeln('');
        $question = new ChoiceQuestion(
            'Select domain',
            $domainCollection
        );
        $selectedDomain = $this->getHelper('question')->ask($input, $output, $question);
        $domainNamespace = $domainCollectionNamespaces[$selectedDomain];

        return $domainNamespace;
    }
}
