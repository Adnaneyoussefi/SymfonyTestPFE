<?php

namespace App\service;

use App\Entity\Countrie;
use App\service\ContinentService;

class CountrieService {
    //Remplir le tableau countries[] qui continent les objets de type Countrie
    /**
     * @return Countrie[]
     */
    public function getCountryData(): array {
        require('C:\Users\adnan\Desktop\SymfonyTest1\src\config\serviceSoap.php');
        $countries = [];
        $continentService = new ContinentService();
        $continents = $continentService->getContinentsData();

        $countriesRaw = $soapClient->FullCountryInfoAllCountries()
        ->FullCountryInfoAllCountriesResult
        ->tCountryInfo;

        foreach($countriesRaw as $value) {
            $countrie = new Countrie();
            $countrie->setsISOCode($value->sISOCode);
            $countrie->setsName($value->sName);
            $countrie->setsCapitalCity($value->sCapitalCity);
            $countrie->setsPhoneCode($value->sPhoneCode);
            $countrie->setsCountryFlag($value->sCountryFlag);
            if(isset($value->Languages->tLanguage) && is_array($value->Languages->tLanguage))
                $countrie->setLanguages($value->Languages->tLanguage);
            else if(isset($value->Languages->tLanguage))  
                $countrie->setLanguages([$value->Languages->tLanguage]);

            foreach($continents as $c) {
                if($c->getsCode() == $value->sContinentCode) {
                    $c->addCountries($countrie);
                    $countrie->setContinent($c);
                }
            }
            array_push($countries, $countrie);
        }

        return $countries;
    }
}