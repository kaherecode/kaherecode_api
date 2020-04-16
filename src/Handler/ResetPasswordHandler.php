<?php

namespace App\Handler;

use App\Entity\ResetPassword;
use App\Repository\UserRepository;
use App\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 *
 */
class ResetPasswordHandler implements MessageHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;

    /**
     * @var UserRepository
     */
    private $_userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $_passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->_entityManager = $entityManager;
        $this->_userRepository = $userRepository;
        $this->_passwordEncoder = $passwordEncoder;
    }

    public function __invoke(ResetPassword $resetPassword)
    {
        if ($resetPassword->getConfirmationToken() === ''
            || $resetPassword->getPlainPassword() === ''
        ) {
            throw new \Exception("Values can not be empty.");
        }

        $user = $this
            ->_userRepository
            ->findOneBy(
                ['confirmationToken' => $resetPassword->getConfirmationToken()]
            );

        if (null === $user) {
            throw new NotFoundException("No password reset has been requested.");
        }

        $user->setPassword(
            $this
                ->_passwordEncoder
                ->encodePassword($user, $resetPassword->getPlainPassword())
        );
        $user->setConfirmationToken(null);
        $user->setPasswordRequestedAt(null);

        $this->_entityManager->flush();
    }
}
