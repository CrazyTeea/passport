<?php


namespace app\controllers\api;


use app\models\Organizations;
use yii\rest\Controller;

class OrganizationsController extends Controller
{
    public function actionGetOrg($id){
        $org = Organizations::find()->where(['organizations.id'=>$id])->joinWith(['region'])->asArray()->one();
        return array_merge($org,['region'=>$org['region']['region']]);
    }
}