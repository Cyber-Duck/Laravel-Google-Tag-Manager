<?php
namespace CyberDuck\LaravelGoogleTagManager\Product;

/**
 * @package cyber-duck/laravel-google-tag-manager
 * @license MIT License https://github.com/cyber-duck/laravel-google-tag-manager/blob/master/LICENSE
 * @author  Simone Todaro <simo.todaro@gmail.com>
 **/
interface IsShoppable
{
    public function getShoppableData();
    public function getShoppablePromoData();
    public function getShoppableId();
    public function getShoppableName();
    public function getShoppablePrice();
    public function getShoppableBrand();
    public function getShoppableCategory();
    public function getShoppableVariant();
}