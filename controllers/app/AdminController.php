<?php


namespace app\controllers\app;


use yii\web\Controller;

class AdminController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionData()
    {
        return $this->render('data');
    }
}