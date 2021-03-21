<?php

namespace App\service;

use App\Entity\Language;
use App\service\CountrieService;

class LanguageService {
    //Remplir le tableau languages[] qui continent les objets de type Language
    /**
     * @return Language[]
     */
    public function getLanguagesData(): array {
        require('C:\Users\adnan\Desktop\SymfonyTest1\src\config\serviceSoap.php');

        $languages = [];

        $languagesRaw = $soapClient->ListOfLanguagesByName()
        ->ListOfLanguagesByNameResult
        ->tLanguage;

        foreach($languagesRaw as $l) {
            $language = new Language();
            $language->setsISOCode($l->sISOCode);
            $language->setsName($l->sName);
            array_push($languages, $language);
        }

        return $languages;
    }

    /**
     * @return Language[]
     */
    public function getLanguagesDataWithCountries(): array {
        $languages = [];
        $countrieService = new CountrieService();
        $countries = $countrieService->getCountryData();

        $AllLanguages = array_map(function($x) {
            return($x->getLanguages());
        }, $countries);

        for($i=0; $i<count($countries); $i++) {
            if(in_array($countries[$i]->getContinent(), $continents))
                continue;
            array_push($continents, $countries[$i]->getContinent());
        }

        return $continents;
    }
}