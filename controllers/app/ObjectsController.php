<?php


namespace app\controllers\app;


use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class ObjectsController extends Controller
{
    public function actionObject($id = null){
        if ($post = Yii::$app->request->post()){
            return Json::encode($post);
        }
        return $this->render('object');
    }
}