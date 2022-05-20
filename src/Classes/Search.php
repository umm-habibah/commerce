<?php

namespace App\Classes;

use App\Entity\Category;

/**
 * @package App\Classes
 * Représentation d'une recherche par un objet
 */
class Search
{
    /**
     * Recherche par le nom
     *
     * @var string
     */
    public $q = '';

    /**
     * Recherche par la ou les catégories
     *
     * @var Category[]
     */
    public $categories = [];
}
