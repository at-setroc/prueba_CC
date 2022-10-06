<?php

namespace App\Service\DataBaseManagement;

use App\Entity\User;
use Doctrine\ORM\Mapping\Entity;

interface DataBaseManagementInterface
{
    public function save(Entity|User $entity): void;

    public function remove(Entity|User $entity): void;
}