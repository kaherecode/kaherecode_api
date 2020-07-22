<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Exception\UserException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 *
 */
final class UserManager implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->_entityManager = $entityManager;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                'checkUserDontExists', EventPriorities::PRE_VALIDATE
            ],
        ];
    }

    public function checkUserDontExists(
        ViewEvent $event
    ): void {
        $user = $event->getControllerResult();

        if (!$user instanceof User || $event->getRequest()->isMethodSafe(false)) {
            return;
        }

        $data = $this->_entityManager
            ->getRepository(User::class)->findOneByEmail($user->getEmail());

        if ($data) {
            throw new UserException("This email address is already used.");
        }

        $data = $this->_entityManager
            ->getRepository(User::class)->findOneByUsername($user->getUsername());

        if ($data) {
            throw new UserException("This username is already used.");
        }
    }
}
