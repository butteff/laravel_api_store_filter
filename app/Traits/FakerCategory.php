<?php

namespace App\Traits;

trait FakerCategory
{
    const CATEGORIES = ['televisions', 'mobilePhones', 'laptops', 'cameras', 'mensClothing', 'womensClothing', 'jewelry', 'watches'];
    
    public $faker2 = null;

    function initFaker()
    {
        if (!$this->faker2) {
            $this->faker2 = \Faker\Factory::create();
            $this->faker2->addProvider(new \FakerEcommerce\Ecommerce($this->faker2));
        }
    }
}