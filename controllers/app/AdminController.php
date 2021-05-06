<?php


namespace app\controllers\app;


class AdminController extends AppController
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
