<?php

namespace App\Service\DataBaseManagement;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;

class DoctrineService implements DataBaseManagementInterface
{
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->em   = $entityManager;
    }

    public function save(Entity|User $entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function remove(Entity|User $entity): void
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}