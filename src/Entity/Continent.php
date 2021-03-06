<?php

namespace App\Entity;

use App\Entity\Country;

class Continent
{
    private $sCode;

    private $sName;

    private $countries = [];

    public function getsCode(): ?string
    {
        return $this->sCode;
    }

    public function setsCode(string $sCode): self
    {
        $this->sCode = $sCode;

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

    /**
     * @return Countrie[]
     */
    public function getCountries(): array
    {
        return $this->countries;
    }

    public function setCountries(array $countries): self
    {
        $this->countries = $countries;

        return $this;
    }

    public function addCountries(Country $countrie): self
    {
        $this->countries[] = $countrie;
        //array_push($this->countries, $countrie);

        return $this;
    }
}