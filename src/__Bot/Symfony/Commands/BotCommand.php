<?php

namespace ZnSandbox\Sandbox\Bot\Symfony\Commands;

use ZnBundle\Messenger\Domain\Libs\WordClassificator;
use Phpml\Classification\KNearestNeighbors;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BotCommand extends Command
{

    protected static $defaultName = 'bot:bot';
    private $domainService;
    private $wordArray = [
        'привет',
        'как дела',
        'да',
        'нет',
        'хорошо',
        'плохо',
    ];

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        dd($output);
        $output->writeln('<fg=white># Привет, я Бот!</>');

        $wordClassificator = new WordClassificator;
        $wantLen = 20;
        $wordClassificator->setWordLength($wantLen);
        $classifier = new KNearestNeighbors;
        $wordClassificator->setClassifier($classifier);
        $wordClassificator->train($this->wordArray);

        $this->dialog($wordClassificator, $input, $output);

        //$this->test($wordClassificator);
    }

    private function dialog(WordClassificator $wordClassificator, InputInterface $input, OutputInterface $output)
    {
        /*$question = new Question('> ', '');
        $userAnwer = $this->getHelper('question')->ask($input, $output, $question);*/
        $userAnwer = 'как дел';
        $predict = $wordClassificator->predict($userAnwer);
        $output->writeln($predict);
    }

    private function train(WordClassificator $wordClassificator, KNearestNeighbors $classifier): KNearestNeighbors
    {
        $arr = $wordClassificator->generateTrain($this->wordArray, 2);
        list($samples, $labels) = $wordClassificator->prepareSamplesForTraining($arr);
        $classifier->train($samples, $labels);
        return $classifier;
    }

    private function test(WordClassificator $wordClassificator)
    {
        $tests = [
            [
                'sample' => 'как дела',
                'expected' => 'как дела',
            ],
            [
                'sample' => 'как дел',
                'expected' => 'как дела',
            ],
            [
                'sample' => 'как дила',
                'expected' => 'как дела',
            ],
            [
                'sample' => 'каг дила',
                'expected' => 'как дела',
            ],
            [
                'sample' => 'каг дилы',
                'expected' => 'как дела',
            ],

            [
                'sample' => 'привет',
                'expected' => 'привет',
            ],
            [
                'sample' => 'превет',
                'expected' => 'привет',
            ],
            [
                'sample' => 'превед',
                'expected' => 'привет',
            ],
            [
                'sample' => 'привед',
                'expected' => 'привет',
            ],
            /*[
                'sample' => 'првет',
                'expected' => 'привет',
            ],*/

            [
                'sample' => 'да',
                'expected' => 'да',
            ],
            [
                'sample' => 'дп',
                'expected' => 'да',
            ],

            [
                'sample' => 'нет',
                'expected' => 'нет',
            ],
            [
                'sample' => 'нпт',
                'expected' => 'нет',
            ],
            [
                'sample' => 'нее',
                'expected' => 'нет',
            ],

        ];

        $testResults = [];
        foreach ($tests as $test) {
            $predict = $wordClassificator->predict($test['sample']);
            $isOk = $predict == $test['expected'];
            $testResults[] = $isOk;
            if ( ! $isOk) {
                dump("{$test['sample']} - {$test['expected']} - {$predict}");
            }
        }
        dd($testResults);
    }

}
