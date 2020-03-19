<?php

namespace App\Controller;

use App\Entity\ResetPasswordRequest;
use App\Handler\ResetPasswordRequestHandler;

/**
 *
 */
class ResetPasswordRequestController
{
    protected $_resetPasswordRequestHandler;

    public function __construct(ResetPasswordRequestHandler $resetPasswordRequestHandler)
    {
        $this->_resetPasswordRequestHandler = $resetPasswordRequestHandler;
    }

    public function __invoke(ResetPasswordRequest $data)
    {
        $this->_resetPasswordRequestHandler->__invoke($data);

        return $data;
    }
}
