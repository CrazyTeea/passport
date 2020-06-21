<?php

namespace app\controllers\app;

use yii\web\Controller;

class PassportController extends Controller
{
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionOrgInfo(){
        return $this->render('orgInfo');
    }
    public function actionAreaInfo(){
        return $this->render('areaInfo');
    }
}