<?php

namespace App\Service\DataBaseManagement;

class DataBaseManagementFactory
{   
    public function __construct(
        DoctrineService $doctrineService
        // $otherService
    ) {
        $this->doctrineService = $doctrineService;
        // $this->otherService = $otherService; 
    }

    public function initialize(string $orm = null): DataBaseManagementInterface
    {
        switch ($orm) {
            case 'doctrine':
                return $this->doctrineService;

            // case 'other':
            //     return $this->otherService;
            
            default:
                return $this->doctrineService;
        }
    }
}