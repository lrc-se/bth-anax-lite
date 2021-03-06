<?php

namespace LRC\Webshop;

/**
 * Webshop product class.
 */
class Product
{
    const ORDER_BY = ['name', 'price', 'stock', 'available'];
    
    public $id;
    public $name;
    public $description;
    public $image;
    public $price;
    public $stock;
    public $available;
    public $categoryIds;
    
    
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->available = true;
        $this->categoryIds = [];
    }
    
    /**
     * Returns the product's image URL, or the URL to a default image if no image found.
     *
     * @return  string  Image URL.
     */
    public function getImage()
    {
        return ($this->image ?: 'img/webshop/default.png');
    }
    
    /**
     * Checks whether the product is part of a category.
     *
     * @param   int     $id     The ID (PK) of the category to check.
     * @return  bool            True if the product is part of the category, false otherwise.
     */
    public function hasCategory($id)
    {
        return in_array($id, $this->categoryIds);
    }
}
