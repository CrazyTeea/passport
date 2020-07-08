<?php


namespace app\controllers\api;


use app\models\Organizations;
use app\models\UsersInfo;
use yii\rest\Controller;

class OrganizationsController extends Controller
{
    public function actionGetOrg($id){
        return Organizations::find()->where(['organizations.id'=>$id])->with(['region','founder','info',
            'area','living','livingStudents'])->asArray()->one();
    }

    public function actionUsersInfo($id){
        return UsersInfo::find()->where(['id_org'=>$id])->asArray()->all();
    }

}