<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Apple;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\services\AppleFactory;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use common\exceptions\FruitException;

class ApplesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create-many', 'fall', 'eat'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create-many' => ['post'],
                    'fall' => ['post'],
                    'eat' => ['post'],
                ],
            ],
        ];
    }

    public function actionCreateMany()
    {
        $count = \random_int(1, 5);
        (new AppleFactory())->createMany($count);

        Yii::$app->session->setFlash('success', 'Добавлено яблок: ' . $count);

        return $this->goHome();
    }

    public function actionFall($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findOrFail($id);

        try {
            $model->fallToGround();

            return [
                'id' => $model->id,
                'content' => $this->renderPartial('/site/_apple_view', [
                    'model' => $model,
                ]),
            ];
        } catch (FruitException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function actionEat($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findOrFail($id);

        try {
            $model->eat(Yii::$app->request->post('eat'));

            return [
                'id' => $model->id,
                'action' => $model->eaten_up >= Apple::EATEN_MAX_VALUE ? 'delete' : 'safe',
                'content' => $this->renderPartial('/site/_apple_view', [
                    'model' => $model,
                ]),
            ];
        } catch (FruitException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    private function findOrFail($id)
    {
        $model = Apple::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('Apple not found');
        }

        return $model;
    }
}
