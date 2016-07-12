<?php
namespace CyberDuck\LaravelGoogleTagManager\Product;

/**
 * @package cyber-duck/laravel-google-tag-manager
 * @license MIT License https://github.com/cyber-duck/laravel-google-tag-manager/blob/master/LICENSE
 * @author  Simone Todaro <simo.todaro@gmail.com>
 **/
trait ShoppableTrait
{
    public function getShoppableData()
    {
        $data = [
            'id' => $this->getShoppableId(),
            'name' => $this->getShoppableName()
        ];
        if (!empty($this->getShoppablePrice())) {
            $data['price'] = $this->getShoppablePrice();
        }
        if (!empty($this->getShoppableBrand())) {
            $data['brand'] = $this->getShoppableBrand();
        }
        if (!empty($this->getShoppableCategory())) {
            $data['category'] = $this->getShoppableCategory();
        }
        if (!empty($this->getShoppableVariant())) {
            $data['variant'] = $this->getShoppableVariant();
        }
        return $data;
    }
    public function getShoppablePromoData()
    {
        return [
            'id' => $this->getShoppableId(),
            'name' => $this->getShoppableName(),
        ];
    }

    public function getShoppablePrice()
    {
        return null;
    }

    public function getShoppableBrand()
    {
        return null;
    }

    public function getShoppableCategory()
    {
        return null;
    }

    public function getShoppableVariant()
    {
        return null;
    }
}
