<?php
/* 
 * @var \yii\web\View $this
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Apples';

?>

<div class="text-right">
    <?= Html::a(
        'Создать яблоки',
        Url::to(['apples/create-many']), 
        [
            'class' => 'btn btn-success',
            'data-method' => 'POST',
        ]
    ); ?>
</div>
