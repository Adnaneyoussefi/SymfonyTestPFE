<?php

namespace App\Entity;

use App\Entity\Language;
use App\Entity\Continent;

class Countrie
{
    private $sISOCode;

    private $sName;

    private $sCapitalCity;

    private $sPhoneCode;

    private $sCountryFlag;

    private $languages = [];

    private $continent;

    public function getsISOCode(): ?string
    {
        return $this->sISOCode;
    }

    public function setsISOCode(string $sISOCode): self
    {
        $this->sISOCode = $sISOCode;

        return $this;
    }

    public function getsName(): ?string
    {
        return $this->sName;
    }

    public function setsName(string $sName): self
    {
        $this->sName = $sName;

        return $this;
    }

    public function getsCapitalCity(): ?string
    {
        return $this->sCapitalCity;
    }

    public function setsCapitalCity(string $sCapitalCity): self
    {
        $this->sCapitalCity = $sCapitalCity;

        return $this;
    }

    public function getsPhoneCode(): ?string
    {
        return $this->sPhoneCode;
    }

    public function setsPhoneCode(string $sPhoneCode): self
    {
        $this->sPhoneCode = $sPhoneCode;

        return $this;
    }

    public function getsCountryFlag(): ?string
    {
        return $this->sCountryFlag;
    }

    public function setsCountryFlag(string $sCountryFlag): self
    {
        $this->sCountryFlag = $sCountryFlag;

        return $this;
    }

    public function getContinent() : Continent
    {
        return $this->continent;
    }

    public function setContinent(?Continent $continent): self
    {
        $this->continent = $continent;

        return $this;
    }

    /**
     * @return Language[]
     */
    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function setLanguages(array $languages): self
    {
        $this->languages = $languages;

        return $this;
    }
}