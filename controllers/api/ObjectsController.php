<?php


namespace app\controllers\api;


use app\models\Objects;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

class ObjectsController extends Controller
{

    public function actionByOrg($id_org)
    {

        $realEstateObjects = Objects::getRealEstateObjects($id_org);
        $objects = Objects::find()
            ->where(['objects.id_org' => $id_org, 'system_status' => 1])
            ->joinWith(['area', 'money', 'tariff'])->asArray()->all();

        $realEstateObjects = array_map(function ($item) {
            return [
                'id_realEstate' => $item['id'],
                'name' => $item['object_name'],
                'kad_number' => $item['cadastral_number'],
                'address' => $item['objectEgrnAddress'],
                'id_region' => $item['egrn_id_region'],
                'doc_number' => $item['registration_right_number'],
                'reg_zap' => $item['registration_right_date'],
                'osn_isp' => $item['id_right_type']
            ];
        }, $realEstateObjects);

        foreach ($objects as $obj) {
            $key = array_search(['id_realEstate' => $obj['id_realEstate']], $realEstateObjects);
            unset($realEstateObjects[$key]);
        }

        return ArrayHelper::merge($objects, $realEstateObjects);
    }

    public function actionByOrgCount($id_org)
    {

        $realEstateObjects = Objects::getRealEstateObjects($id_org);
        $objects = Objects::find()->where(['objects.id_org' => $id_org, 'system_status' => 1])->count();

        return $objects + count($realEstateObjects);
    }
}