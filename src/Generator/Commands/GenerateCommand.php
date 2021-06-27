<?php

namespace ZnSandbox\Sandbox\Generator\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnCore\Base\Helpers\ClassHelper;
use ZnLib\Console\Symfony4\Question\ChoiceQuestion;
use ZnSandbox\Sandbox\Bundle\Domain\Entities\BundleEntity;
use ZnSandbox\Sandbox\Bundle\Domain\Entities\DomainEntity;
use ZnSandbox\Sandbox\Bundle\Domain\Interfaces\Services\BundleServiceInterface;
use ZnSandbox\Sandbox\Generator\Domain\Services\GeneratorService;

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

        $domainEntity = $this->selectDomain($input, $output);
        $selectedEntities = $this->selectEntity($input, $output, $domainEntity);

        $selectedTables = [];
        foreach ($selectedEntities as $entityName) {
            $selectedTables[] = $domainEntity->getName() . '_' . $entityName;
        }
        $structure = $this->generatorService->getStructure($selectedTables);

        dd($structure);

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

    private function selectEntity(InputInterface $input, OutputInterface $output, DomainEntity $domainEntity): array
    {
        $tableList = $this->generatorService->allTables();
        $entityNames = [];
        foreach ($tableList as $tableName) {
            $segments = explode('_', $tableName);
            $bundleName = $segments[0];
            if($domainEntity->getName() == $bundleName) {
                array_shift($segments);
                $entityNames[] = implode('_', $segments);
            }
        }

        $question = new ChoiceQuestion(
            'Select entity',
            $entityNames,
            'a'
        );
        $question->setMultiselect(true);
        $selectedEntities = $this->getHelper('question')->ask($input, $output, $question);
        return $selectedEntities;
//        dd($entityNames);
    }

    private function selectDomain(InputInterface $input, OutputInterface $output): DomainEntity
    {
        /** @var BundleEntity[] $bundleCollection */
        $bundleCollection = $this->bundleService->all();
        $domainCollection = [];
        $domainCollectionNamespaces = [];
        foreach ($bundleCollection as $bundleEntity) {
            if ($bundleEntity->getDomain()) {
//                $domainNamespace = ClassHelper::getNamespace($bundleEntity->getDomain()->getClassName());
                $domainNamespace = $bundleEntity->getNamespace();
                $domainName = $bundleEntity->getDomain()->getName();
                $title = "$domainName ($domainNamespace)";
                $domainCollection[] = $title;
                $domainCollectionNamespaces[$title] = $bundleEntity->getDomain();
            }
            // dd($domainNamespace);
        }

        $output->writeln('');
        $question = new ChoiceQuestion(
            'Select domain',
            $domainCollection
        );
        $selectedDomain = $this->getHelper('question')->ask($input, $output, $question);
        return $domainCollectionNamespaces[$selectedDomain];
    }
}
