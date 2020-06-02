<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m200602_105914_add_admin_user
 */
class m200602_105914_add_admin_user extends Migration
{
    private const USERNAME = 'admin';
    private const EMAIL = 'admin@no.mail';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new User([
            'email' => self::EMAIL,
            'username' => self::USERNAME,
            'status' => User::STATUS_ACTIVE,
        ]);
        $user->setPassword('secret');
        $user->generateAuthKey();
        $user->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        User::deleteAll([
            'username' => self::USERNAME,
        ]);
    }
}
