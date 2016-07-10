<?php
namespace CyberDuck\LaravelGoogleTagManager\Product;

/**
 * @package cyber-duck/laravel-google-tag-manager
 * @license MIT License https://github.com/cyber-duck/laravel-google-tag-manager/blob/master/LICENSE
 * @author  Simone Todaro <simo.todaro@gmail.com>
 **/
trait ShoppableTrait
{
    public function getShoppableData() {
        return [
            'id' => {$this->getShoppableId()},
            'name' => {$this->getShoppableName()},
            'price' => {$this->getShoppablePrice()},
            'brand' => {$this->getShoppableBrand()},
            'category' => {$this->getShoppableCategory()},
            'variant' => {$this->getShoppableVariant()},
        ];
    }
    public function getShoppablePromoData() {
        return [
            'id' => {$this->getShoppableId()},
            'name' => {$this->getShoppableName()},
        ];
    }
    public function getShoppableBrand()
    {
        return '';
    }

    public function getShoppableCategory()
    {
        return '';
    }

    public function getShoppableVariant()
    {
        return '';
    }
}