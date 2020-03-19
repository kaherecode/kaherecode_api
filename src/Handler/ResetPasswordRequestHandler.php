<?php

namespace App\Handler;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\ResetPasswordRequest;
use App\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 *
 */
class ResetPasswordRequestHandler implements MessageHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;

    /**
     * @var UserRepository
     */
    private $_userRepository;


    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ) {
        $this->_entityManager = $entityManager;
        $this->_userRepository = $userRepository;
    }

    public function __invoke(ResetPasswordRequest $resetPassword)
    {
        /**
         * @var User
         */
        $user = $this->_userRepository->findOneBy(
            ['email' => $resetPassword->getEmail()]
        );

        if (null === $user) {
            throw new NotFoundException(
                sprintf(
                    'User with email address "%s" does not exists.',
                    $resetPassword->getEmail()
                )
            );
        }

        $user->setPasswordRequestedAt(new \DateTime());
        $user->setConfirmationToken(sha1(uniqid()));

        $this->_entityManager->flush();

        // TODO: Send confirmation mail to the user
    }
}
