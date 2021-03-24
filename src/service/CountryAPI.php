<?php

namespace App\service;

use App\Entity\Country;
use App\Entity\Language;
use App\Entity\Continent;
use App\service\Iservice;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class CountryAPI implements Iservice {

    private $api_country;

    public function __construct1($api_country)
    {
        $this->api_country = $api_country;
    }

    public function getModels(): array {
        $soapClient = new \SoapClient($this->getParameter('app.api_country'));
        return ["country" => $this->getCountryData($soapClient), 
                "continent" => $this->getContinentWithCountryData($soapClient), 
                "language" => $this->getLanguageWithCountryData($soapClient)];
    }
    
    /**
     * @return Continent[]
     */
    public function getContinentsData($soapClient): array {
        
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
     * @return Language[]
     */
    public function getLanguagesData($soapClient): array {

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
     * @return Country[]
     */
    public function getCountryData($soapClient) {
        $countries = [];
        
        $continents = $this->getContinentsData($soapClient);
        $languages = $this->getLanguagesData($soapClient);

        $countriesRaw = $soapClient->FullCountryInfoAllCountries()
        ->FullCountryInfoAllCountriesResult
        ->tCountryInfo;

        foreach($countriesRaw as $value) {
            $country = new Country();
            $country->setsISOCode($value->sISOCode)
                ->setsName($value->sName)
                ->setsCapitalCity($value->sCapitalCity)
                ->setsPhoneCode($value->sPhoneCode)
                ->setsCountryFlag($value->sCountryFlag);
            
            foreach($continents as $c) {
                if($c->getsCode() == $value->sContinentCode) {
                    $c->addCountries($country);
                    $country->setContinent($c);
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
                        $country->addLanguages($la);
                        $la->addCountries($country);
                    }
                }
            }
            array_push($countries, $country);
        }
        return $countries;
    }

    /**
     * @return Continent[]
     */
    public function getContinentWithCountryData($soapClient): array {
        $continents = [];

        $countries = $this->getCountryData($soapClient);

        for($i=0; $i<count($countries); $i++) {
            if(in_array($countries[$i]->getContinent(), $continents))
                continue;
            array_push($continents, $countries[$i]->getContinent());
        }

        return $continents;
    }

    /**
     * @return Language[]
     */
    public function getLanguageWithCountryData($soapClient): array {
        $languages = [];
        $countries = $this->getCountryData($soapClient);

        $AllLanguages = array_map(function($l) {
            return $l->getLanguages();
        }, $countries);

        for($i=0; $i<count($AllLanguages); $i++) {
            for($j=0; $j<count($AllLanguages[$i]); $j++) {
                if(in_array($AllLanguages[$i][$j], $languages))
                    continue;
                array_push($languages, $AllLanguages[$i][$j]);
            }
        }

        return $languages;
    }

    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if (method_exists($this, $function = '__construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }
}