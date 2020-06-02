<?php

namespace common\tests\unit\models;

use Yii;
use common\models\Apple;
use common\exceptions\FruitException;


class AppleModelTest extends \Codeception\Test\Unit
{
    private const COLOR_GREEN = 'green';

    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    public function testAppleConstructor()
    {
        $model = new Apple(self::COLOR_GREEN);

        expect('apple should be valid color', $model->color)->equals(self::COLOR_GREEN);
    }

    public function testAppleStateChangeByFallAt()
    {
        $model = new Apple(self::COLOR_GREEN);
        expect('apple state should be hanging', $model->state)->equals(Apple::STATE_HANGING);

        $model->fall_at = time();
        expect('apple state should be fall', $model->state)->equals(Apple::STATE_FALL);

        $model->fall_at = time() - Apple::LIFE_HOURS * 3600 - 1;
        expect('apple state should be fall', $model->state)->equals(Apple::STATE_ROTTEN);
    }

    public function testAppleSizeChangeByEatenUp()
    {
        $model = new Apple(self::COLOR_GREEN);
        expect('apple size should be 1', $model->size)->equals(1);

        $model->eaten_up = 25;
        expect('apple state should be 0.7', $model->size)->equals(0.75);
    }

    public function testAppleFallToGround()
    {
        $model = new Apple(self::COLOR_GREEN);
        expect('apple fall_at is null', $model->fall_at)->null();

        $model->fallToGround();
        expect('apple fall_at not null', $model->fall_at)->notNull();

        $this->tester->expectException(function () use ($model) {
            $model->fallToGround();
        }, FruitException::class);
    }

    public function testAppleEating()
    {
        $model = new Apple(self::COLOR_GREEN);
        // целое яблоко
        expect('apple eaten_up is 0', $model->eaten_up)->equals(0);

        // нельзя съесть пока висит на дереве
        $this->tester->expectException(function () use ($model) {
            $model->eat(10);
        }, FruitException::class);

        $model->fallToGround();

        $model->eat(30);
        expect('apple eaten_up is 30', $model->eaten_up)->equals(30);

        // нельзя съесть отрицательное значение
        $this->tester->expectException(function () use ($model) {
            $model->eat(-5);
        }, FruitException::class);

        $model->eat(40);
        expect('apple eaten_up is 70', $model->eaten_up)->equals(70);

        // не осталось такого куска
        $this->tester->expectException(function () use ($model) {
            $model->eat(40);
        }, FruitException::class);
    }
}
