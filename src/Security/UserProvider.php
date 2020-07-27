<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 *
 */
class UserProvider implements UserProviderInterface
{
    /**
     * @var UserRepository
     */
    private $_userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->_userRepository = $userRepository;
    }


    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername(string $username)
    {
        $user = $this->_userRepository->findOneByEmail($username);

        if (!$user) {
            throw new UsernameNotFoundException("Error Processing Request");
        }
    }

    /**
     * Refreshes the user.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException  if the user is not supported
     * @throws UsernameNotFoundException if the user is not found
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @return bool
     */
    public function supportsClass(string $class)
    {
        return User::class === $class;
    }
}
