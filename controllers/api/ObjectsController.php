<?php

namespace app\controllers\api;

use app\models\ObjDocs;
use app\models\ObjDocTypes;
use app\models\Objects;
use Yii;
use yii\rest\Controller;

class ObjectsController extends Controller
{
    public function actionByOrg($id_org): array
    {
        $objects = Objects::find()
            ->joinWith(['area', 'money', 'tariff'])
            ->where(['objects.id_org' => $id_org, 'objects.system_status' => 1])
            ->asArray()->all();
        foreach ($objects as $i => $object) {
            /**
             * Вычитаются ключи с названиями 'area', 'const_count_pol', 'count_pol', 'created_at', 'id', 'id_org',
             * 'id_realEstate', 'money', 'ob_fin_stroy', 'system_status', 'tariff', 'updated_at'
             **/
            //$n = 12;
            $full_count_pol = 112;
            if (is_null($object['reconstruct']) || $object['reconstruct'] != 1) {
                /**
                 * К вычитаемым ключам добавляются ключи с названиями 'date_end_reconstruct', 'date_start_reconstruct',
                 * 'rec_money_bud_sub', 'rec_money_faip', 'rec_money_vneb'
                 **/
                //$n += 5;
                $full_count_pol -= 5;
            }
            if (is_null($object['ustav_dey']) || $object['ustav_dey'] != 0) {
                /**
                 * К вычитаемым ключам добавляются ключи с названиями 'nevos_reason', 'reason', 'uslovie'
                 **/
                //$n += 3;
                $full_count_pol -= 3;
            }
            //$full_count_pol = count($object) - $n;
            /**
             * Вычитаются ключи с названиями 'cnt_mest_obsh_na_odn', 'cnt_mest_pl_na_odn', 'id', 'id_object'
             **/
            //if ($object['area'] != null) $full_count_pol += (count($object['area']) - 4);
            /**
             * Вычитаются ключи с названиями 'id', 'id_object'
             **/
            //if ($object['money'] != null) $full_count_pol += (count($object['money']) - 2);
            /**
             * Вычитаются ключи с названиями 'id', 'id_object'
             **/
            //if ($object['tariff'] != null) $full_count_pol += (count($object['tariff']) - 2);

            $objects[$i]['full_count_pol'] = $full_count_pol;
        }

        return $objects;
    }

    public function actionByOrgCount($id_org): int
    {
        return Objects::find()->where(['objects.id_org' => $id_org, 'system_status' => 1])->count();
    }

    public function actionGetDocTypes($id_obj): array
    {
        $arr = ObjDocs::find()->joinWith(['descriptor', 'file'])
            ->where(['id_obj' => $id_obj])->asArray()->all();
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
                }, ObjDocTypes::find()->all());
            }
        }
        return $arr;
    }

    public function actionByOrgOne($id_org, $id_object)
    {
        return Objects::find()
            ->where(['objects.id' => $id_object, 'objects.id_org' => $id_org, 'system_status' => 1])
            ->joinWith(['area', 'money', 'tariff'])
            ->asArray()->one();
    }

    public function actionCntRealEstate($id_org): int
    {
        return 0;
    }
}