<?php

namespace backend\services;

use yii\base\Model;
use Colors\RandomColor;
use common\models\Apple;

class AppleFactory
{
    public function createMany($count)
    {
        return array_map(function ($color) {
            $model = new Apple($color);
            $model->save();
            
            return $model;
        }, $this->appleColors($count));
    }

    private function appleColors($count)
    {
        return RandomColor::many($count, [
            'hue' => ['red', 'yellow', 'orange', 'green'],
        ]);
    }
}