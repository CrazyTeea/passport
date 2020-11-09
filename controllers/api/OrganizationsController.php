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
        $name = Yii::$app->request->get('name');
        return Founders::find()->where(['system_status' => 1])->andWhere(['like', 'founder', $name])->all();
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

        $filter_arr = [
            'organizations.system_status' => 1,
            'organizations.id_founder' => $filter['id_founder'] ?? null,
            'organizations.id' => $filter['id'] ?? null,
            'organizations.id_region' => $filter['id_region'] ?? null,
        ];
        $cnt = Organizations::find()->select(['organizations.id', 'organizations.id_founder', 'organizations.id_region']);
        $arr = Organizations::find();
        if (isset($filter['docs']) and $filter['docs'] == 1) {
            $cnt = $cnt->joinWith('orgDocs');
            $arr = $arr->joinWith('orgDocs');
            $having = ['>', 'count(org_docs.id)', 0];
        }
        if (isset($filter['kont']) and $filter['kont'] == 1) {
            $cnt = $cnt->joinWith('usersInfo', true, 'join');
            $arr = $arr->joinWith('usersInfo', true, 'join');
        }

        if (isset($filter['zap']) and $filter['zap'] == 1) {
            $filter_arr = array_merge($filter_arr, ['active' => 1]);
        }


        $cnt = $cnt->andFilterWhere($filter_arr)
            ->groupBy(['organizations.id'])
            ->having($having ?? [])->count();

        $arr = $arr->andFilterWhere($filter_arr)
            ->offset(($filter['offset'] - 1) * $filter['limit'])
            ->limit($filter['limit'])
            ->having($having ?? [])
            ->groupBy(['organizations.id']);

        $r_objs = Objects::getRealEstateObjects((clone $arr)->select('organizations.id')->column());

        $arr = $arr->all();


        $arr2 = array_map(function ($item) use ($r_objs) {
            $r_obj_cnt = array_reduce($r_objs, function ($a, $b) use ($item) {
                if ($b['id_org'] == $item->id)
                    $a++;
                $a += 0;
                return $a;
            }, 0);;
            $my_obj_cnt = Objects::find()->select(['id_org'])->where(['id_org' => $item->id])->count();
            if ($r_obj_cnt or $my_obj_cnt)
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'foiv' => $item->founder->founder,
                    'region' => $item->region->region,
                    'r_obj_cnt' => $r_obj_cnt,
                    'my_obj_cnt' => $my_obj_cnt,
                    'docs' => OrgDocs::find()->where(['id_org' => $item->id])->count('id')
                ];
            return null;
        }, $arr);


        $arr2 = array_filter($arr2, function ($item) {
            if (is_null($item)) {
                return false;
            }
            return true;
        });

        return array_merge($arr2, ['cnt' => $cnt > 255 ? 255 : $cnt]);

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