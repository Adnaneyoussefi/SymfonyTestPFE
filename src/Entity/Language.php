<?php

namespace App\Entity;

class Language
{
    private $sISOCode;

    private $sName;

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
}
