<?php

namespace ZnSandbox\Sandbox\Wsdl\Domain\Services;

use ZnSandbox\Sandbox\Wsdl\Domain\Entities\TransportEntity;
use ZnSandbox\Sandbox\Wsdl\Domain\Enums\StatusEnum;
use ZnSandbox\Sandbox\Wsdl\Domain\Interfaces\Repositories\ClientRepositoryInterface;
use ZnSandbox\Sandbox\Wsdl\Domain\Interfaces\Repositories\TransportRepositoryInterface;
use ZnSandbox\Sandbox\Wsdl\Domain\Interfaces\Services\TransportServiceInterface;
use ZnCore\Domain\Service\Base\BaseCrudService;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;

/**
 * @method TransportRepositoryInterface getRepository()
 */
class TransportService extends BaseCrudService implements TransportServiceInterface
{

    private $sendMessageRepository;

    public function __construct(
        EntityManagerInterface $em,
        ClientRepositoryInterface $sendMessageRepository
    )
    {
        $this->setEntityManager($em);
        $this->sendMessageRepository = $sendMessageRepository;
    }

    public function getEntityClass(): string
    {
        return TransportEntity::class;
    }

    public function sendAll(): void
    {
        $collection = $this
            ->getEntityManager()
            ->getRepository(TransportEntity::class)
            ->allByNewStatus();

        /** @var TransportEntity $transportEntity */
        foreach ($collection as $transportEntity) {
            $this->send($transportEntity);
        }
    }

    public function send(TransportEntity $transportEntity): void
    {
        $this->sendMessageRepository->send($transportEntity);
        $transportEntity->setStatusId(StatusEnum::COMPLETE);
        $this->getEntityManager()->persist($transportEntity);
    }
}
