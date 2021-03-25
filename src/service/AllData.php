<?php

namespace App\Service;

use App\Service\IAllData;
use App\Service\Iservice;

class AllData implements IAllData {
    
    private Iservice $service;

    public function __construct(Iservice $service)
    {
        $this->service = $service;
    }

    public function getService() {
        return $this->service;
    }

    public function setService(Iservice $service) {
        $this->service = $service;
    }

    public function getAllData(): array {
        return $this->service->getModels();
    }
}