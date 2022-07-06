<?php

namespace ZnCore\Base\Validation\Helpers;

use Symfony\Component\PropertyAccess\Exception\UninitializedPropertyException;
use Symfony\Component\Validator\ConstraintViolationList;
use ZnCore\Base\Develop\Helpers\DeprecateHelper;
use ZnCore\Base\Validation\Entities\ValidationErrorEntity;
use ZnCore\Domain\Collection\Interfaces\Enumerable;
use ZnCore\Domain\Collection\Libs\Collection;
use ZnCore\Domain\Entity\Factories\PropertyAccess;

DeprecateHelper::softThrow('ValidateEntityInterface');

/**
 * Class ArrayValidationHelper
 * @package ZnCore\Domain\Helpers
 * @see DynamicEntityValidationHelper
 */
class ArrayValidationHelper
{

    /**
     * @return array | Enumerable | ValidationErrorEntity[]
     */
    public static function validate($data): Enumerable
    {
        $rules = $data->validationRules();
        return self::validateByRulesArray($data, $rules);
    }

    private static function validateByRulesArray(object $entity, array $rules)
    {
        $violations = [];
        $validator = SymfonyValidationHelper::createValidator();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($rules as $name => $rule) {
            try {
                $value = $propertyAccessor->getValue($entity, $name);
            } catch (UninitializedPropertyException $e) {
                $value = null;
            }
            $vol = $validator->validate($value, $rules[$name]);
            if ($vol->count()) {
                $violations[$name] = $vol;
            }
        }
        return self::prepareUnprocessible($violations);
    }

    /**
     * @param array | ConstraintViolationList[] $violations
     * @return  array | Enumerable | ValidationErrorEntity[]
     */
    private static function prepareUnprocessible(array $violations): Enumerable
    {
        $collection = new Collection();
        foreach ($violations as $name => $violationList) {
            foreach ($violationList as $violation) {
                //$name = $violation->propertyPath();
                $violation->getCode();
                $entity = new ValidationErrorEntity;
                $entity->setField($name);
                $message = $violation->getMessage();
                $entity->setMessage($message);
                $entity->setViolation($violation);
                $collection->add($entity);
            }
        }
        return $collection;
    }
}
