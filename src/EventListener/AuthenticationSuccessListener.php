<?php

namespace App\EventListener;

use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

/**
 *
 */
class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(
        AuthenticationSuccessEvent $event
    ) {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['id'] = $user->getId();

        $event->setData($data);
    }
}
