<?php


namespace app\controllers\api;


use app\models\Objects;
use yii\rest\Controller;

class ObjectsController extends Controller
{
    public function actionByOrg($id_org){
        return Objects::findAll(['id_org'=>$id_org,'system_status'=>1]);
    }
}