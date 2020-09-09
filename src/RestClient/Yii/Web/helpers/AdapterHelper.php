<?php

namespace ZnSandbox\Sandbox\RestClient\Yii\Web\helpers;

use ZnCore\Domain\Helpers\EntityHelper;
use ZnSandbox\Sandbox\RestClient\Domain\Entities\BookmarkEntity;
use yii2bundle\rest\domain\entities\RequestEntity;
use ZnSandbox\Sandbox\RestClient\Yii\Web\models\RequestForm;
use GuzzleHttp\Psr7\Response;

class AdapterHelper
{

    public static function bookmarkEntityToForm(BookmarkEntity $bookmarkEntity): RequestForm
    {
        /** @var RequestForm $model */
        $model = \Yii::createObject(RequestForm::class);
        $model->endpoint = $bookmarkEntity->getUri();
        $model->method = $bookmarkEntity->getMethod();
        $model->authorization = $bookmarkEntity->getAuthorization();
        $model->description = $bookmarkEntity->getDescription();

        if ($bookmarkEntity->getQuery()) {
            foreach ($bookmarkEntity->getQuery() as $key => $value) {
                $model->queryKeys[] = $key;
                $model->queryValues[] = $value;
                $model->queryActives[] = true;
            }
        }

        if ($bookmarkEntity->getBody()) {
            foreach ($bookmarkEntity->getBody() as $key => $value) {
                $model->bodyKeys[] = $key;
                $model->bodyValues[] = $value;
                $model->bodyActives[] = true;
            }
        }

        if ($bookmarkEntity->getHeader()) {
            foreach ($bookmarkEntity->getHeader() as $key => $value) {
                $model->headerKeys[] = $key;
                $model->headerValues[] = $value;
                $model->headerActives[] = true;
            }
        }
        return $model;
    }

    public static function formToBookmarkEntityData(RequestForm $model): BookmarkEntity
    {
        $data = [
            'method' => $model->method,
            'uri' => $model->endpoint,
            'query' => [],
            'body' => [],
            'header' => [],
            'authorization' => $model->authorization,
            'description' => $model->description,
        ];

        foreach ($model->queryKeys as $i => $key) {
            $data['query'][$key] = $model->queryValues[$i];
        }

        foreach ($model->bodyKeys as $i => $key) {
            $data['body'][$key] = $model->bodyValues[$i];
        }

        foreach ($model->headerKeys as $i => $key) {
            $data['header'][$key] = $model->headerValues[$i];
        }
        $bookmarkEntity = new BookmarkEntity;
        EntityHelper::setAttributes($bookmarkEntity, $data);
        return $bookmarkEntity;
    }

    public static function collapseFields(RequestForm $model, string $attributeName) {
        $data = [];
        $keys = $model->{$attributeName.'Keys'};
        $values = $model->{$attributeName.'Values'};
        $actives = $model->{$attributeName.'Actives'};
        foreach ($keys as $i => $key) {
            if(!empty($actives[$i])) {
                $data[$key] = $values[$i];
            }
        }
        return $data;
    }

    private static function buildQuery($data)
    {
        $couples = [];
        foreach ($data as $key => $value) {
            $couples[] = self::encodeQueryKey($key) . '=' . urlencode($value);
        }
        $query = join('&', $couples);
        $query = trim($query);
        return $query;
    }

    private static function encodeQueryKey($key)
    {
        $encodedKey = urlencode($key);
        return str_replace(['%5B', '%5D'], ['[', ']'], $encodedKey);
    }
}