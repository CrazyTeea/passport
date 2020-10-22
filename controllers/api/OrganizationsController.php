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

    public function actionFounders()
    {
        return Founders::find()->all();
    }

    public function actionRegions()
    {
        return Regions::find()->all();
    }

    private function filter($get)
    {
        dd($get);
    }

    public function actionOrgFilter()
    {
        $filter = Yii::$app->request->get();
        $cnt = Organizations::find()->select(['id', 'id_founder', 'id_region'])
            ->andFilterWhere([
                'id_founder' => $filter['id_founder'] ?? null,
                'id' => $filter['id'] ?? null,
                'id_region' => $filter['id_region'] ?? null,
            ])->count();
        $arr = Organizations::find()
            ->andFilterWhere([
                'organizations.id_founder' => $filter['id_founder'] ?? null,
                'organizations.id' => $filter['id'] ?? null,
                'organizations.id_region' => $filter['id_region'] ?? null,
            ])
            ->offset(($filter['offset'] - 1) * $filter['limit'])
            ->limit($filter['limit'])
            ->groupBy(['organizations.id'])
            ->all();

        return array_merge(array_map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'foiv' => $item->founder->founder,
                'region' => $item->region->region,
                'obj_cnt' => Objects::find()->select(['id_org'])->where(['id_org' => $item->id])->count(),
            ];
        }, $arr), ['cnt' => $cnt]);

    }


    public function actionAll()
    {
        $name = Yii::$app->request->get('name');
        return Organizations::find()->where(['system_status' => 1])->andWhere(['like', 'name', $name])->all();
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