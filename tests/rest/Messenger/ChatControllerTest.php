<?php

namespace PhpLab\Sandbox\Tests\rest\Messenger;

use PhpLab\Core\Enums\Http\HttpStatusCodeEnum;
use PhpLab\Test\Base\BaseRestApiTest;

class ChatControllerTest extends BaseRestApiTest
{

    protected $basePath = 'api/v1';

    public function testAll()
    {
        $response = $this->getRestClient()->sendGet('messenger-chat', [
            'per-page' => '4',
            'page' => '2',
        ]);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::UNAUTHORIZED);

        /*$expectedBody = [
            [
                "id" => 5,
                "title" => 'chat 5',
                'type' => 'public',
            ],
            [
                "id" => 6,
                "title" => 'chat 6',
                'type' => 'public',
            ],
            [
                "id" => 7,
                "title" => 'chat 7',
                'type' => 'public',
            ],
            [
                "id" => 8,
                "title" => 'chat 8',
                'type' => 'public',
            ],
        ];
        $this->assertBody($response, $expectedBody);
        $this->assertPagination($response, null, 2, 4);*/
    }

}
