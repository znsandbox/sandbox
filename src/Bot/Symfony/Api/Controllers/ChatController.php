<?php

namespace PhpLab\Sandbox\Bot\Symfony\Api\Controllers;

use PhpLab\Core\Domain\Exceptions\UnprocessibleEntityException;
use PhpLab\Rest\Base\BaseCrudApiController;
use PhpLab\Rest\Libs\Serializer\JsonRestSerializer;
use PhpBundle\Messenger\Domain\Interfaces\ChatServiceInterface;
use PhpLab\Core\Enums\Http\HttpHeaderEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use PhpBundle\Messenger\Domain\Libs\WordClassificator;
use Phpml\Classification\KNearestNeighbors;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChatController
{

    /*public function __construct(ChatServiceInterface $chatService)
    {
        $this->service = $chatService;
    }*/

    public function send(Request $request): JsonResponse
    {
        $response = new JsonResponse;
        $body = $request->request->all();

        $userMessage = $body['content'];


        $wordClassificator = new WordClassificator;
        $wantLen = 40;
        $wordClassificator->setWordLength($wantLen);
        $classifier = new KNearestNeighbors;
        $wordClassificator->setClassifier($classifier);
        $wordDictonary = $this->getWords();

        $wordArray = array_keys($wordDictonary);

        //$response->setData($wordArray);
        $wordClassificator->train($wordArray);

        $predict = $wordClassificator->predict($userMessage);
        $response->setData($predict);

        //$this->dialog($wordClassificator, $input, $output);


        try {
            //$entity = $this->service->create($body);
            //$response->setStatusCode(Response::HTTP_CREATED);
            //$response->headers->set(HttpHeaderEnum::X_ENTITY_ID, $entity->getId());
            //$response->setData($words);
        } catch (UnprocessibleEntityException $e) {
            $errorCollection = $e->getErrorCollection();
            $serializer = new JsonRestSerializer($response);
            $serializer->serialize($errorCollection);
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //$location = $this->generateUrl('app_crud_view', ['id', 3], UrlGeneratorInterface::ABSOLUTE_URL);
        //$response->headers->set('Location', $location);
        return $response;
    }

    private function getWords()
    {
        $content = file_get_contents('C:\Users\Admin\Desktop\answer_databse\answer_databse\answer_databse.txt');
        $content = str_replace("\r\n", PHP_EOL, $content);
        $lineArray = \PhpLab\Core\Helpers\StringHelper::textToLines($content);
        $rrrrr = [];

        foreach ($lineArray as &$line) {
            $line111 = explode('\\', $line);
            if(isset($line111[1])) {
                $request = \PhpLab\Sandbox\Bot\Domain\Helpers\MlHelper::prepareWord($line111[0]);
                $rrrrr[$request][] = $line111[1];
            }
        }
        return array_slice($rrrrr, 0, 200);
        dd(array_slice($rrrrr, 0, 200));

        $rrr = \PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper::getColumn($lineArray, 'request');
        foreach ($rrr as &$line) {
            $line = \PhpLab\Sandbox\Bot\Domain\Helpers\MlHelper::prepareWord($line);
        }
        $rrr = array_unique($rrr);

        dd(array_slice($rrr, 0, 200));

        return array_slice($lineArray, 0, 20);
    }

}
