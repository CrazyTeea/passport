<?php


namespace app\controllers\app;


use yii\web\Controller;

class DocumentsController extends AppController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}