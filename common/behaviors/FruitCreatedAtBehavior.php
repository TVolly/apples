<?php

namespace common\behaviors;

use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;

class FruitCreatedAtBehavior extends AttributeBehavior
{
    public $createdAtAttribute = 'created_at';
    public $lifeHours = 5;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->attributes = [
            BaseActiveRecord::EVENT_BEFORE_INSERT => $this->createdAtAttribute,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            return time() - \random_int(0, 2 * $this->lifeHours * 3600);
        }

        return parent::getValue($event);
    }
}
