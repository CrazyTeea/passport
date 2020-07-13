<?php


namespace app\controllers\api;


use app\models\Objects;
use yii\rest\Controller;

class ObjectsController extends Controller
{
    public function actionByOrg($id_org){
        return Objects::find()
            ->where(['objects.id_org'=>$id_org,'system_status'=>1])
            ->joinWith(['area','money','tariff'])->asArray()->all();
    }
}