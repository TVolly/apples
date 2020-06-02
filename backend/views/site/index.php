<?php
/* 
 * @var \yii\web\View $this
 * @var \common\models\Apple[] $apples
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Apples';

?>

<div class="text-right">
    <?= Html::a(
        'Добавить яблоки',
        Url::to(['apples/create-many']), 
        [
            'class' => 'btn btn-success',
            'data-method' => 'POST',
        ]
    ); ?>
</div>

<div class="row">

<div class="col-md-3">
    <?= \backend\widgets\AppleLogsWidget::widget(); ?>
</div>

<div class="col-md-9">
    <?php foreach ($apples as $apple): ?>
        <div class="apple-row" id="apple-<?= $apple->id; ?>">
            <?= $this->render('_apple_view', ['model' => $apple]); ?>
        </div>
    <?php endforeach; ?>
</div>

</div>