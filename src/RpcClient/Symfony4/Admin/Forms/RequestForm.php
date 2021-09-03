<?php

namespace ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Forms;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\BuildFormInterface;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\UserEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\UserServiceInterface;

class RequestForm implements ValidateEntityByMetadataInterface, BuildFormInterface
{

    private $authBy = null;
    private $method = null;
    private $body = '{}';
    private $meta = '{}';
    private $description = null;

    private $_userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->_userService = $userService;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
//        $metadata->addPropertyConstraint('authBy', new Assert\NotBlank());
        $metadata->addPropertyConstraint('method', new Assert\NotBlank());
    }

    public function buildForm(FormBuilderInterface $formBuilder)
    {
        $formBuilder->add('authBy', ChoiceType::class, [
            'label' => 'authBy',
            'choices' => array_flip($this->getUserOptions()),
        ]);
        $formBuilder->add('method', TextType::class, [
            'label' => 'method'
        ]);
        $formBuilder->add('body', TextareaType::class, [
            'label' => 'body'
        ]);
        $formBuilder->add('meta', TextareaType::class, [
            'label' => 'meta'
        ]);
        $formBuilder->add('description', TextareaType::class, [
            'label' => 'description'
        ]);
    }

    public function getAuthBy()
    {
        return $this->authBy;
    }

    public function setAuthBy($authBy): void
    {
        $this->authBy = $authBy;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method): void
    {
        $this->method = $method;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body): void
    {
        $this->body = $body;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function setMeta($meta): void
    {
        $this->meta = $meta;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getUserOptions(): array
    {
        /** @var UserEntity[] $collection */
        $collection = $this->_userService->all();
        $options = [
            null => 'guest'
        ];
        foreach ($collection as $entity) {
            $options[$entity->getId()] = $entity->getLogin() ?? $entity->getDescription();
        }
        return $options;
    }
}
