<?php
/**
 * @var \yii\web\View $this
 * @var \common\models\Log[] $models
 */
?>


<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">История яблок</h3>
    </div>
    <div class="panel-body">
        <?php foreach ($models as $model): ?>
            <?= $model->text; ?>
            <div class="text-right">
                <small>
                    <?= Yii::$app->formatter->asDatetime($model->created_at); ?>
                </small>
            </div>

            <hr>
        <?php endforeach; ?>
    </div>
</div>