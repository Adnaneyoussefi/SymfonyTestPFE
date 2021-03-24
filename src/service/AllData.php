<?php

namespace App\service;

use App\service\IAllData;
use App\service\Iservice;

class AllData implements IAllData {
    
    private Iservice $service;

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