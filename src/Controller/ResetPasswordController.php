<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Handler\ResetPasswordHandler;

/**
 *
 */
class ResetPasswordController
{
    /**
     * @var ResetPasswordHandler
     */
    private $_resetPasswordHandler;

    public function __construct(ResetPasswordHandler $resetPasswordHandler)
    {
        $this->_resetPasswordHandler = $resetPasswordHandler;
    }

    public function __invoke(ResetPassword $data)
    {
        $this->_resetPasswordHandler->__invoke($data);
        $data->setPlainPassword(null);

        return $data;
    }
}
