<?php


namespace app\controllers\app;

use yii\web\Controller;

class ManualController extends AppController
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
