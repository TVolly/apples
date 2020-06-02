<?php 

namespace common\events;

class FruitEatenEvent extends \yii\base\Event
{
    public const EVENT_NAME = 'fruitEaten';

    public $percent;
}