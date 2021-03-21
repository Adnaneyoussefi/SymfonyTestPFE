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
        $languageService = new LanguageService();
        $continents = $continentService->getContinentsData();
        $languages = $languageService->getLanguagesData();

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
            
            foreach($continents as $c) {
                if($c->getsCode() == $value->sContinentCode) {
                    $c->addCountries($countrie);
                    $countrie->setContinent($c);
                }
            }

            $t = [];
            if(isset($value->Languages->tLanguage) && is_array($value->Languages->tLanguage))
                $t = $value->Languages->tLanguage;
            else if(isset($value->Languages->tLanguage))  
                $t = [$value->Languages->tLanguage];

            foreach($t as $l) {
                foreach($languages as $la) {
                    if($l->sISOCode == $la->getsISOCode()) {
                        $countrie->addLanguages($la);
                        $la->addCountries($countrie);
                    }
                }
            }
            array_push($countries, $countrie);
        }
        return $countries;
    }
}