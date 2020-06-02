<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\exceptions\FruitException;

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
    public const LIFE_HOURS = 5;

    public const STATE_HANGING = 'hanging';
    public const STATE_FALL = 'fall';
    public const STATE_ROTTEN = 'rotten';

    private const EATEN_MAX_VALUE = 100;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apples';
    }

    public function __construct(string $color, array $config = [])
    {
        parent::__construct($config);
        
        $this->color = $color;
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

    public function getState()
    {
        if ($this->fall_at === null) {
            return self::STATE_HANGING;
        } elseif ($this->fall_at > time() - self::LIFE_HOURS * 3600) {
            return self::STATE_FALL;
        }

        return self::STATE_ROTTEN;
    }

    public function getSize()
    {
        return round(1 - ($this->eaten_up/self::EATEN_MAX_VALUE), 2);
    }

    public function fallToGround()
    {
        if ($this->fall_at !== null) {
            throw new FruitException('Already fallen');
        }

        $this->fall_at = time();
        $this->update(false);
    }

    public function eat(int $percent)
    {
        if ($this->state !== self::STATE_FALL) {
            throw new FruitException('Can`t eat');
        } elseif ($percent < 0 || ($this->eaten_up + $percent) > self::EATEN_MAX_VALUE) {
            throw new FruitException('Bad value');
        }

        $this->eaten_up += $percent;
        $this->update(false);
    }
}
