<?php

namespace ZnSandbox\Sandbox\Tests\rest\Article;

use ZnLib\Components\Http\Enums\HttpMethodEnum;
use ZnLib\Components\Http\Enums\HttpStatusCodeEnum;
use ZnTool\Test\Base\BaseRestApiTest;
use ZnTool\Test\Helpers\RestHelper;
use ZnLib\Rest\Helpers\RestResponseHelper;

class PostControllerTest extends BaseRestApiTest
{

    protected $lastId;
    protected $basePath = 'api/v1';

    public function testAll()
    {
        $expectedBody = [
            [
                "id" => 5,
                "title" => 'post 5',
                'category_id' => 2,
                'category' => null,
            ],
            [
                "id" => 6,
                "title" => 'post 6',
                'category_id' => 3,
                'category' => null,
            ],
            [
                "id" => 7,
                "title" => 'post 7',
                'category_id' => 1,
                'category' => null,
            ],
            [
                "id" => 8,
                "title" => 'post 8',
                'category_id' => 2,
                'category' => null,
            ]
        ];

        $response = $this->getRestClient()->sendGet('article-post', [
            'per-page' => '4',
            'page' => '2',
        ]);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::OK)
            ->assertPagination(null, 2, 4)
            ->assertBody($expectedBody);
    }

    public function testAllWithRelations()
    {
        $expectedBody = [
            [
                "id" => 5,
                'category' => [
                    'id' => 2,
                ],
                'tags' => [
                    [
                        'id' => 2,
                    ],
                    [
                        'id' => 3,
                    ],
                ],
            ],
            [
                "id" => 6,
                'category' => [
                    'id' => 3,
                ],
                'tags' => [
                    [
                        'id' => 4,
                    ],
                    [
                        'id' => 5,
                    ],
                ],
            ],
            [
                "id" => 7,
                'category' => [
                    'id' => 1,
                ],
                'tags' => [
                    [
                        'id' => 6,
                    ],
                    [
                        'id' => 7,
                    ],
                ],
            ],
            [
                "id" => 8,
                'category' => [
                    'id' => 2,
                ],
                'tags' => [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
            ]
        ];
        $response = $this->getRestClient()->sendGet('article-post', [
            'per-page' => '4',
            'page' => '2',
            'expand' => 'category,tags',
        ]);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::OK)
            ->assertPagination(null, 2, 4)
            ->assertBody($expectedBody);
    }

    public function testAllSortByCategory()
    {
        $response = $this->getRestClient()->sendGet('article-post', [
            'per-page' => '4',
            'page' => '2',
            'sort' => 'category_id,id',
        ]);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::OK)
            ->assertPagination(null, 2, 4)
            ->assertOrder('category_id', SORT_ASC);
    }

    public function testAllSortByCategoryDesc()
    {
        $response = $this->getRestClient()->sendGet('article-post', [
            'per-page' => '4',
            'page' => '2',
            'sort' => '-category_id,id',
        ]);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::OK)
            ->assertPagination(null, 2, 4)
            ->assertOrder('category_id', SORT_DESC);
    }

    public function testAllOnlyFields()
    {
        $expectedBody = [
            [
                "id" => 1,
                "title" => null,
                'category_id' => null,
            ],
            [
                "id" => 2,
                "title" => null,
                'category_id' => null,
            ],
        ];
        $response = $this->getRestClient()->sendGet('article-post', [
            'per-page' => '2',
            'fields' => 'id',
            'sort' => 'id',
        ]);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::OK)
            //->assertPagination(null, 2, 4)
            ->assertBody($expectedBody);
    }

    public function testAllById()
    {
        $expectedBody = [
            [
                "id" => 3,
            ],
        ];
        $response = $this->getRestClient()->sendGet('article-post', [
            'per-page' => '4',
            'page' => '2',
            'id' => '3',
        ]);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::OK)
            ->assertPagination(1, 1, 4)
            ->assertBody($expectedBody);
    }

    public function testView()
    {
        $expectedBody = [
            'id' => 3,
            'title' => 'post 3',
            'category_id' => 3,
        ];
        $response = $this->getRestClient()->sendGet('article-post/3');
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::OK)
            ->assertBody($expectedBody);
    }

    public function testViewWithRelations()
    {
        $expectedBody = [
            'id' => 3,
            'category' => [
                'id' => 3,
                'title' => 'category 3',
            ],
            'tags' => [
                [
                    'id' => 5,
                ],
                [
                    'id' => 6,
                ],
            ],
        ];
        $response = $this->getRestClient()->sendGet('article-post/3', [
            'expand' => 'category,tags',
        ]);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::OK)
            ->assertBody($expectedBody);
    }

    public function testViewNotFound()
    {
        $response = $this->getRestClient()->sendGet('article-post/3333');
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::NOT_FOUND);
    }

    public function testBadCreate()
    {
        $response = $this->getRestClient()->sendPost('article-post', [
            'title' => 'te',
            'category_id' => 3,
        ]);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::UNPROCESSABLE_ENTITY)
            ->assertUnprocessableEntity(['title']);
    }

    public function testBadUpdate()
    {
        $data = [
            'title' => 'te',
            'category_id' => 3,
        ];

        $response = $this->getRestClient()->sendPut('article-post/100', $data);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::UNPROCESSABLE_ENTITY)
            ->assertUnprocessableEntity(['title']);
    }

    public function testCreate()
    {
        $data = [
            'title' => 'test123',
            'category_id' => 3,
        ];

        $response = $this->getRestClient()->sendPost('article-post', $data);
        $this->getRestAssert($response)
            ->assertCreated();

        $lastId = RestResponseHelper::getLastInsertId($response);


        $response = $this->getRestClient()->sendGet('article-post/' . $lastId);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::OK)
            ->assertBody([
                'id' => $lastId,
                'title' => 'test123',
                'category_id' => 3,
            ]);

        $data = [
            'title' => 'qwerty'
        ];

        $response = $this->getRestClient()->sendPut('article-post/' . $lastId, $data);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::NO_CONTENT);

        $response = $this->getRestClient()->sendGet('article-post/' . $lastId);
        $this->getRestAssert($response)
            ->assertBody([
                'id' => $lastId,
                'title' => 'qwerty',
                'category_id' => 3,
            ]);

        $response = $this->getRestClient()->sendDelete('article-post/' . $lastId);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::NO_CONTENT);

        $response = $this->getRestClient()->sendGet('article-post/' . $lastId);
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::NOT_FOUND);
    }

    public function testMethodAllowed()
    {
        $response = $this->getRestClient()->sendPost('article-post/1');
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::METHOD_NOT_ALLOWED);

        $response = $this->getRestClient()->sendPut('article-post');
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::METHOD_NOT_ALLOWED);

        $response = $this->getRestClient()->sendDelete('article-post');
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::METHOD_NOT_ALLOWED);
    }

    public function testOptions()
    {
        $response = $this->getRestClient()->sendOptions('article-post/1');
        $expectedMethods = [
            HttpMethodEnum::GET,
            HttpMethodEnum::POST,
            HttpMethodEnum::PUT,
            HttpMethodEnum::DELETE,
            HttpMethodEnum::OPTIONS,
        ];
        $this->getRestAssert($response)
            ->assertCors('*', null, $expectedMethods);
    }

    public function testNotRoute()
    {
        $response = $this->getRestClient()->sendDelete('article-post-possst/1');
        $this->getRestAssert($response)
            ->assertStatusCode(HttpStatusCodeEnum::NOT_FOUND);
    }

}
