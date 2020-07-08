<?php


namespace app\controllers\api;


use app\models\Founders;
use app\models\Organizations;
use app\models\OrgArea;
use app\models\OrgInfo;
use app\models\OrgLiving;
use app\models\OrgLivingStudents;
use app\models\Regions;
use app\models\UsersInfo;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

class OrganizationsController extends Controller
{
    public function actionGetOrg($id){
        $org = Organizations::find()->where(['organizations.id'=>$id])->one();
        $info = OrgInfo::findAll(['id_org'=>$id]);
        $region=Regions::findOne($org->id_region);
        $founder=Founders::findOne($org->id_founder);
        $area = OrgArea::findOne(['id_org'=>$id]);
        $living = OrgLiving::findOne(['id_org'=>$id]);
        $inv = Yii::$app->request->get('living_st_inv');
        $livingStudents = OrgLivingStudents::findAll(['id_org'=>$id,'invalid'=>$inv]);

        return ['organization'=>$org,'info'=>$info,'area'=>$area,'living'=>$living,'region'=>$region,'founder'=>$founder,'livingStudents'=>$livingStudents ?? []];
    }

    public function actionUsersInfo($id){
        return UsersInfo::find()->where(['id_org'=>$id])->asArray()->all();
    }

}