<?php
/**
 * @var \common\models\Apple $model
 */

 use yii\helpers\Html;
 use yii\helpers\Url;
?>

<div class="row">
    <div class="col-md-3">
        <?= Html::tag('div', '', [
            'class' => 'apple-row__circle',
            'style' => [
                'background-color' => $model->color,
            ],
        ]); ?>
    </div>

    <div class="col-md-5">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td><?= $model->id; ?></td>
                </tr>
                <tr>
                    <th>Цвет</th>
                    <td><?= $model->color; ?></td>
                </tr>
                <tr>
                    <th>Размер</th>
                    <td><?= $model->size; ?></td>
                </tr>
                <tr>
                    <th>Состояние</th>
                    <td><?= $model->state; ?></td>
                </tr>
                <tr>
                    <th>Дата создания</th>
                    <td><?= Yii::$app->formatter->asDatetime($model->created_at); ?></td>
                </tr>
                <tr>
                    <th>Дата падения</th>
                    <td><?= Yii::$app->formatter->asDatetime($model->fall_at); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-md-4">
        <div class="alert alert-danger"></div>

        <div style="margin-bottom: 15px">
            <?= Html::button('Упасть', [
                'class' => 'btn btn-info h-fall',
                'data-url' => Url::to(['/apples/fall', 'id' => $model->id])
            ]); ?>
        </div>

        <form class="form-inline h-eat" action="<?= Url::to(['/apples/eat', 'id' => $model->id]); ?>">
            <div class="form-group">
                <input type="number" step="5" value="30" class="form-control"/>

                <button class="btn btn-primary" type="submit">Съесть</button>
            </div>
        </form>
    </div>
</div>