<?php

namespace App\Entity;

use App\Controller\ResetPasswordController;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *     messenger=true,
 *     collectionOperations={
 *         "post"={
 *             "status"=202,
 *             "path"="/users/reset-password",
 *             "controller"=ResetPasswordController::class
 *         }
 *     },
 *     itemOperations={},
 *     output=false
 * )
 */
class ResetPassword
{
    /**
     * @var string
     */
    private $confirmationToken;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param string $confirmationToken
     *
     * @return self
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
