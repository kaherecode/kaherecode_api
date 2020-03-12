<?php

namespace App\DataPersister;

use App\Entity\Tutorial;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

/**
 *
 */
class TutorialDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_slugger;

    public function __construct(
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ) {
        $this->_entityManager = $entityManager;
        $this->_slugger = $slugger;
    }


    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Tutorial;
    }

    /**
     * @param Tutorial $data
     */
    public function persist($data, array $context = [])
    {
        $data->setSlug(
            $this
                ->_slugger
                ->slug(strtolower($data->getTitle())). '-' .uniqid()
        );

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}
