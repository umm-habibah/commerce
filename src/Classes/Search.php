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

    /**
     * Recherche par prix min
     *
     * @var null|integer
     */
    public $min;

    /**
     * Recherche par prix max
     *
     * @var null|integer
     */
    public $max;
}
