<?php


namespace app\controllers\app;


use yii\web\Controller;

class DocumentsController extends Controller
{
    public function actionIndex(){
        return $this->render('index');
    }
}