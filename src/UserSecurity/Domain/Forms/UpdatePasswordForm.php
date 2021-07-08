<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Forms;

use ZnSandbox\Sandbox\UserSecurity\Domain\Helpers\PasswordValidatorHelper;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;

class UpdatePasswordForm implements ValidateEntityByMetadataInterface
{

    private $currentPassword;
    private $newPassword;
    private $newPasswordConfirm;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('currentPassword', new Assert\NotBlank);

        $metadata->addPropertyConstraint('newPassword', PasswordValidatorHelper::createConstraint());

        /*$metadata->addPropertyConstraint('newPassword', new Assert\NotBlank);
        $metadata->addPropertyConstraint('newPassword', new Assert\Length(['min' => 6, 'max' => 18]));
        $metadata->addPropertyConstraint('newPassword', new Assert\Regex([
            'pattern' => '/' . RegexpPatternEnum::PASSWORD_REQUIRED . '/',
            'message' => I18Next::t('user', 'password.the_password_is_too_light'),
        ]));*/

        $metadata->addPropertyConstraint('newPasswordConfirm', new Assert\NotBlank);
        $metadata->addPropertyConstraint('newPasswordConfirm', new Assert\EqualTo([
            'propertyPath' => 'newPassword',
            'message' => I18Next::t('user_security', 'change-password.message.does_not_match_the_new_password'),
        ]));

        $metadata->addPropertyConstraint('newPassword', new Assert\NotEqualTo([
            'propertyPath' => 'currentPassword',
            'message' => I18Next::t('user_security', 'change-password.message.does_match_the_new_password'),
        ]));
    }

    public function getCurrentPassword(): string
    {
        return $this->currentPassword;
    }

    public function setCurrentPassword(string $currentPassword): void
    {
        $this->currentPassword = $currentPassword;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): void
    {
        $this->newPassword = $newPassword;
    }

    public function getNewPasswordConfirm(): string
    {
        return $this->newPasswordConfirm;
    }

    public function setNewPasswordConfirm(string $newPasswordConfirm): void
    {
        $this->newPasswordConfirm = $newPasswordConfirm;
    }
}
