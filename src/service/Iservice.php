<?php

namespace App\Service;

interface Iservice {
    
    public function getModels(): array;

    public function getModel($id): array;

}