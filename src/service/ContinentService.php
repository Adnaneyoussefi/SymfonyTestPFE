<?php

namespace App\service;

use App\Entity\Countrie;
use App\Entity\Continent;
use App\service\CountrieService;

class ContinentService {
    //Remplir le tableau continents[] qui continent les objets de type Continent
    /**
     * @return Continent[]
     */
    public function getContinentsData(): array {
        require('C:\Users\adnan\Desktop\SymfonyTest1\src\config\serviceSoap.php');

        $continents = [];

        $continentsRaw = $soapClient->ListOfContinentsByName()
        ->ListOfContinentsByNameResult
        ->tContinent;

        foreach($continentsRaw as $c) {
            $continent = new Continent();
            $continent->setsCode($c->sCode);
            $continent->setsName($c->sName);
            array_push($continents, $continent);
        }

        return $continents;
    }

    /**
     * @return Continent[]
     */
    public function getContinentsDataWithCountries(): array {
        $continents = [];
        $countrieService = new CountrieService();
        $countries = $countrieService->getCountryData();

        for($i=0; $i<count($countries); $i++) {
            if(in_array($countries[$i]->getContinent(), $continents))
                continue;
            array_push($continents, $countries[$i]->getContinent());
        }

        return $continents;
    }
}