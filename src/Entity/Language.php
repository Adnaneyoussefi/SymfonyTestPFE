<?php

namespace App\Entity;

use App\Entity\Country;

class Language
{
    private $sISOCode;

    private $sName;

    private $countries = [];

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
