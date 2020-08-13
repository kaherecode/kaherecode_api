<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 *
 */
class SecurityController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $_serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->_serializer = $serializer;
    }

    /**
     * @Route(
     *     path="/api/me",
     *     methods={"GET"},
     *     defaults={
     *          "_api_resource_class"=User::class
     *     }
     * )
     */
    public function getLoggedInUser()
    {
        $response = new JsonResponse();
        $user = $this->getUser();

        if ($user instanceof User) {
            $response->setJson($this->_serializer->serialize($user, 'json'));
            $response->setStatusCode(JsonResponse::HTTP_OK);
        }

        return $response;
    }
}
