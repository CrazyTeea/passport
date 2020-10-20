<?php


namespace app\controllers\api;


use app\models\Founders;
use app\models\Objects;
use app\models\Organizations;
use app\models\OrgArea;
use app\models\OrgDocs;
use app\models\OrgInfo;
use app\models\OrgLiving;
use app\models\OrgLivingStudents;
use app\models\Regions;
use app\models\UsersInfo;
use Yii;
use yii\rest\Controller;

class OrganizationsController extends Controller
{
    public function actionGetOrg($id)
    {
        $org = Organizations::findOne($id);
        if (!$org) return ['organization' => [], 'info' => [], 'area' => [], 'living' => [], 'region' => [], 'founder' => [], 'livingStudents' => []];
        $info = OrgInfo::findAll(['id_org' => $id]);
        $region = Regions::findOne($org->id_region);
        $founder = Founders::findOne($org->id_founder);
        $area = OrgArea::findOne(['id_org' => $id]);
        $living = OrgLiving::findOne(['id_org' => $id]);
        $inv = Yii::$app->request->get('living_st_inv');
        $livingStudents = OrgLivingStudents::findAll(['id_org' => $id, 'invalid' => $inv]);

        return ['organization' => $org, 'info' => $info, 'area' => $area, 'living' => $living, 'region' => $region, 'founder' => $founder, 'livingStudents' => $livingStudents];
    }


    public function actionAll(){
        $name = Yii::$app->request->get('name');
        return Organizations::find()->where(['system_status'=>1])->andWhere(['like','name',$name])->all();
    }

    public function actionObjCount($id)
    {
        return Objects::find()->where(['id_org' => $id, 'system_status' => 1])->count();
    }

    public function actionUsersInfo($id)
    {
        return UsersInfo::find()->where(['id_org' => $id])->asArray()->all();
    }

    public function actionGetDocTypes($id_org)
    {
        return OrgDocs::find()->joinWith(['descriptor', 'file'])->where(['id_org' => $id_org])->asArray()->all();
    }

}