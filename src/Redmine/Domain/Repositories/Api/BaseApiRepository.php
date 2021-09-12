<?php

namespace ZnSandbox\Sandbox\Redmine\Domain\Repositories\Api;

use Redmine\Api\AbstractApi;
use Redmine\Client;
use ZnCore\Base\Exceptions\NotSupportedException;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Domain\Entities\Query\Where;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Libs\Query;
use ZnLib\Db\Traits\MapperTrait;
use ZnSandbox\Sandbox\Redmine\Domain\Interfaces\Repositories\IssueApiRepositoryInterface;

abstract class BaseApiRepository implements IssueApiRepositoryInterface
{

    use MapperTrait;

    private $client;
    private $cache = [];

    public function __construct(Client $client)
    {
        $this->client = $client;
        // https://www.redmine.org/projects/redmine/wiki/Rest_Issues
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    abstract public function getEndpoint(): AbstractApi;

    public function create(EntityIdInterface $entity)
    {
        $array = $this->getEndpoint()->create($params);
    }

    public function update(EntityIdInterface $entity)
    {
        $array = $this->getEndpoint()->update($entity->getId(), $params);
    }

    public function deleteById($id)
    {
        $array = $this->getEndpoint()->remove($id);
    }

    public function deleteByCondition(array $condition)
    {
        throw new NotSupportedException('deleteByCondition');
    }

    public function hashQuery(Query $query)
    {
        return hash('sha256', serialize($query));
    }

    public function setCache(Query $query, array $array)
    {
        $hash = $this->hashQuery($query);
        $this->cache[$hash] = $array;
    }

    public function getCache(Query $query): ?array
    {
        $hash = $this->hashQuery($query);
        return ArrayHelper::getValue($this->cache, $hash);
    }

    public function all(Query $query = null)
    {
        $array = $this->getCache($query);
        if(!$array) {
            $params = $this->forgeNativeParams($query);
            $array = $this->getEndpoint()->all($params);
        }
        $this->setCache($query, $array);
        return $this->mapperDecodeCollection($array['issues']);
    }

    public function count(Query $query = null): int
    {
        $array = $this->getCache($query);
        if(!$array) {
            $params = $this->forgeNativeParams($query);
            $array = $this->getEndpoint()->all($params);
        }
        $this->setCache($query, $array);
        return $array['total_count'];
    }

    public function oneById($id, Query $query = null): EntityIdInterface
    {
        $params = $this->forgeNativeParams($query);
        $array = $this->getEndpoint()->show($id, $params);
        return $this->mapperDecodeEntity($array['issue']);
    }

    protected function forgeNativeParams(Query $query = null): array
    {
        $query = Query::forge($query);
        $params = [
            //'project_id' => 'e-daryn',
            //'sort' => 'id',
//            'query_id' => 66,
            //'tracker_id' => 1,
            //'limit' => 2,
            //'priority_id' => '5',
            //'status_id' => 'open',
            //'due_date' => null

            //'sort' => 'created_on:desc,updated_on:desc',

            /*'project_id' => 'id5-cli-portal',
            'status_id' => 'closed',
            'sort' => 'created_on:desc,status:desc'*/
        ];
//        dd($query->getWhere());
        /** @var Where[] $whereList */
        $whereList = $query->getWhere();
        if($whereList) {
            foreach ($whereList as $where) {
                $params[$where->column] = $where->value;
            }
        }

        $orderList = $query->getParam(Query::ORDER);
        $sortList = [];
        if ($orderList) {
            foreach ($orderList as $column => $direct) {
                $directNative = $direct == SORT_ASC ? 'asc' : 'desc';
                $sortList[] = $column . ':' . $directNative;
            }
        }


        if ($sortList) {
            $params['sort'] = implode(',', $sortList);
        }

        $limit = $query->getParam(Query::LIMIT);
        if ($limit) {
            $params['limit'] = $limit;
        }
        $page = $query->getParam(Query::PAGE);
        if ($page) {
            $params['offset'] = $limit * ($page - 1);
        }

        $with = $query->getParam(Query::WITH);
        if ($with) {

            $params['include'] = implode(',', $with);
        }

        return $params;
    }
}
