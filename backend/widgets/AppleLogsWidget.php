<?php

namespace backend\widgets;

use Yii;
use common\models\Log;

class AppleLogsWidget extends \yii\base\Widget
{
    public function run()
    {
        $models = Log::find()
            ->orderBy('id DESC')
            ->limit(30)
            ->all();

        return $this->render('apple-logs', [
            'models' => $models,
        ]);
    }
}