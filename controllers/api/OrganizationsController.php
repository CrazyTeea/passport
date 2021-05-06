<?php

namespace app\controllers\api;

use app\models\DocTypes;
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
    public function actionGetOrg($id): array
    {
        $org = Organizations::findOne($id);
        $full_count_pol = 77;
        if (!$org) {
            return [
                'organization' => [], 'info' => [], 'area' => [], 'living' => [], 'region' => [], 'founder' => [],
                'livingStudents' => [], 'count_pol' => 0, 'full_count_pol' => $full_count_pol
            ];
        }

        $count_pol = $org->count_pol;

        $info = OrgInfo::findAll(['id_org' => $id]);

        $region = Regions::findOne($org->id_region);
        $founder = Founders::findOne($org->id_founder);
        $area = OrgArea::findOne(['id_org' => $id]);

        $living = OrgLiving::findOne(['id_org' => $id]);

        $inv = Yii::$app->request->get('living_st_inv');
        if ($livingStudents = OrgLivingStudents::findAll(
            !is_null($inv)
                ? ['id_org' => $id, 'invalid' => $inv]
                : ['id_org' => $id]
        )) {
            foreach ($livingStudents as $item) {
                /**
                 * Вычитаются ключи с названиями 'budjet_type', 'id', 'id_org', 'invalid', 'id_living', 'name', 'type'
                 **/
                foreach ($item as $key => $val) {
                    if (!in_array($key, ['budjet_type', 'id', 'id_org', 'invalid', 'id_living', 'name', 'type'])) {
                        $full_count_pol++;
                    }
                }
                //$full_count_pol += (count($item) - 7);
            }
        } else {
            $full_count_pol += 252;
        }

        $docs = OrgDocs::findAll(['id_org' => $id]);

        return ['organization' => $org, 'docs' => $docs,
            'info' => $info, 'area' => $area, 'living' => $living,
            'region' => $region, 'founder' => $founder, 'livingStudents' => $livingStudents,
            'count_pol' => $count_pol, 'full_count_pol' => $full_count_pol];
    }

    public function actionFounders(): array
    {
        $name = Yii::$app->request->get('name');
        return Founders::find()->where(['system_status' => 1])->andWhere(['like', 'founder', $name])->all();
    }

    public function actionRegions(): array
    {
        return Regions::find()->all();
    }


    public function actionOrgFilter(): array
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
                if ($b['id_org'] == $item->id) {
                    $a++;
                }
                $a += 0;
                return $a;
            }, 0);
            $my_obj_cnt = count($item->objs ?? []);

            return [
                'id' => $item->id,
                'name' => $item->name,
                'foiv' => $item->founder->founder,
                'region' => $item->region->region,
                'r_obj_cnt' => ((int)$r_obj_cnt) ? $r_obj_cnt : $my_obj_cnt,
                //'my_obj_cnt' => $my_obj_cnt,
                'docs' => OrgDocs::find()->where(['id_org' => $item->id])->andWhere('id_file is not null')->count('id')
            ];
        }, $arr);

        return array_merge($arr2, ['cnt' => $cnt]);
    }

    public function actionAll($name = null): array
    {

        return Organizations::find()->where(['system_status' => 1])
            ->andWhere(['or',
                ['like', 'name', $name],
                ['like', 'full_name', $name],
                ['like', 'short_name', $name]
            ])
            ->limit(10)
            ->orderBy('name ASC')
            ->all();
    }

    public function actionObjCount($id)
    {
        return Objects::find()
            ->where(['id_org' => $id, 'system_status' => 1])
            ->count();
    }

    public function actionUsersInfo($id): array
    {
        return UsersInfo::find()->where(['id_org' => $id])->asArray()->all();
    }

    public function actionGetDocTypes($id_org): array
    {
        $arr = OrgDocs::find()->joinWith(['descriptor', 'file'])
            ->where(['id_org' => $id_org])->asArray()->all();
        if (Yii::$app->user->can('user')) {
            if (count($arr) < 2) {
                $arr = array_map(function ($item) use ($arr) {
                    $i = null;
                    foreach ($arr as $ke => $it) {
                        if (isset($it['descriptor']['desc']) and $it['descriptor']['desc'] == $item->desc) {
                            $i = $ke;
                        }
                    }
                    return $arr[$i] ?? [
                            'descriptor' => $item,
                            'file' => null
                        ];
                }, DocTypes::find()->all());
            }
        }
        return $arr;
    }
}
