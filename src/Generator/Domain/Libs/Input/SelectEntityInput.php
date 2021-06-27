<?php

namespace ZnSandbox\Sandbox\Generator\Domain\Libs\Input;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnLib\Console\Symfony4\Question\ChoiceQuestion;
use ZnSandbox\Sandbox\Bundle\Domain\Entities\DomainEntity;
use ZnSandbox\Sandbox\Generator\Domain\Helpers\TableMapperHelper;

class SelectEntityInput extends BaseInput
{

    private $domainEntity;

    /*public function __construct(
        InputInterface $input,
        OutputInterface $output,
        Command $command,
        DomainEntity $domainEntity
    )
    {
        $this->input = $input;
        $this->output = $output;
        $this->command = $command;
        $this->domainEntity = $domainEntity;
    }*/

    public function getDomainEntity(): DomainEntity
    {
        return $this->domainEntity;
    }

    public function setDomainEntity(DomainEntity $domainEntity): void
    {
        $this->domainEntity = $domainEntity;
    }

    public function run(array $tableList): array
    {
        $entityNames = [];
        foreach ($tableList as $tableName) {
            $bundleName = TableMapperHelper::extractDomainNameFromTable($tableName);
            if ($this->domainEntity->getName() == $bundleName) {
                $entityNames[] = TableMapperHelper::extractEntityNameFromTable($tableName);
            }
        }

        $question = new ChoiceQuestion(
            'Select entity',
            $entityNames,
            'a'
        );
        $question->setMultiselect(true);
        $selectedEntities = $this->getCommand()->getHelper('question')->ask($this->getInput(), $this->getOutput(), $question);
        return $selectedEntities;
//        dd($entityNames);
    }
}
