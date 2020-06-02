<?php

namespace common\behaviors;

use Yii;
use common\models\Log;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use common\events\FruitEatenEvent;
use common\events\FruitFallOnGroundEvent;

class FruitLoggerBehavior extends Behavior
{
    public $type = 'Fruit';

    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_INSERT => 'onFruitCreated',
            FruitFallOnGroundEvent::EVENT_NAME => 'onFruitFallOnGround',
            FruitEatenEvent::EVENT_NAME => 'onFruitEaten',
        ];
    }

    public function onFruitCreated($event)
    {
        $this->addLog($event->sender->id, 'Добавлен');
    }

    public function onFruitFallOnGround($event)
    {
        $this->addLog($event->sender->id, 'Упал на землю');
    }

    public function onFruitEaten(FruitEatenEvent $event)
    {
        $this->addLog($event->sender->id, 'Было съедено ' . $event->percent . '%');
    }

    private function addLog($senderId, $message)
    {
        (new Log([
            'text' => Yii::t('app', '{type} #{id}. {message}', [
                'type' => $this->type,
                'id' => $senderId,
                'message' => $message,
            ]),
        ]))->save();
    }
}
