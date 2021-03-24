<?php

namespace App\Data;

use App\Entity\Language;
use App\Entity\Continent;

class SearchData {
    /**
     * @var Continent[]
     */
    public $continents = [];

    /**
     * @var Language[]
     */
    public $languages = [];

    /**
     * @var string
     */
    public $recherche = '';
}