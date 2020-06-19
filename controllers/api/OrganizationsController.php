<?php


namespace app\controllers\api;


use app\models\Organizations;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

class OrganizationsController extends Controller
{
    public function actionGetOrg($id){
        return Organizations::find()->where(['organizations.id'=>$id])->with(['region','founder'])->asArray()->one();
    }

}