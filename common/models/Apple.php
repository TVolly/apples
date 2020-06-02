<?php

namespace commmon\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "apples".
 *
 * @property int $id
 * @property string $color
 * @property int $eaten_up
 * @property int|null $fall_at
 * @property int $created_at
 */
class Apple extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apples';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => null,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color'], 'required'],
            [['eaten_up', 'fall_at'], 'integer'],
            [['color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'eaten_up' => 'Eaten Up',
            'fall_at' => 'Fall At',
            'created_at' => 'Created At',
        ];
    }
}
