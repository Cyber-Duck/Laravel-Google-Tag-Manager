<?php

namespace CyberDuck\LaravelGoogleTagManager\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use CyberDuck\LaravelGoogleTagManager\Product\IsShoppable;
use CyberDuck\LaravelGoogleTagManager\Product\ShoppableTrait;

class Product extends Model implements IsShoppable
{
    use ShoppableTrait;

    public function getShoppableId() {
        return $this->shoppableid;
    }

    public function getShoppableName() {
        return $this->name;
    }
}