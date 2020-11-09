<?php

namespace app\models;

use yii\httpclient\Client;

/**
 * This is the model class for table "objects".
 *
 * @property int $id
 * @property int $id_org
 * @property string|null $name
 * @property string|null $address
 * @property int $id_region
 * @property string|null $kad_number
 * @property string|null $osn_isp
 * @property string|null $reg_zap
 * @property string|null $doc_number
 * @property string|null $flat_plan
 * @property string|null $flat_type
 * @property string|null $prib_type
 * @property float|null $smet
 * @property string|null $stroy_date_start
 * @property string|null $stroy_date_end
 * @property string|null $exp_date
 * @property string|null $ob_fin_stroy
 * @property float|null $money_faip
 * @property float|null $money_bud_sub
 * @property float|null $money_vneb
 * @property int|null $reconstruct
 * @property int|null $ustav_dey
 * @property int|null $system_status
 * @property int|null $rec_money_faip
 * @property int|null $rec_money_bud_sub
 * @property int|null $rec_money_vneb
 * @property int|null $date_start_reconstruct
 * @property int|null $date_end_reconstruct
 * @property int|null $pandus
 * @property int|null $mech_por
 * @property int|null $sanusel
 * @property int|null $signal
 * @property int|null $pokr
 * @property int|null $vives
 * @property int|null $min_per
 * @property int|null $max_per
 *
 * @property Organizations $org
 * @property Regions $region
 * @property ObjectsArea $area
 * @property ObjectsMoney $money
 * @property ObjectsTariff $tariff
 */
class Objects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_org', 'id_region'], 'required'],
            [['id_org', 'id_region', 'reconstruct', 'ustav_dey', 'pandus', 'mech_por', 'sanusel',
                'signal', 'pokr', 'vives', 'min_per', 'max_per', 'system_status'], 'integer'],
            [['name', 'address', 'kad_number', 'osn_isp', 'flat_plan', 'flat_type', 'prib_type'], 'safe'],
            [['smet', 'money_faip', 'money_bud_sub', 'money_vneb', 'rec_money_faip', 'rec_money_bud_sub', 'rec_money_vneb'], 'number'],
            [['stroy_date_start', 'stroy_date_end', 'exp_date', 'ob_fin_stroy', 'date_start_reconstruct', 'date_end_reconstruct'], 'safe'],
            [['reg_zap', 'doc_number', 'reason', 'uslovie', 'nevos_reason'], 'string', 'max' => 255],
            [['id_org'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::class, 'targetAttribute' => ['id_org' => 'id']],
            [['id_region'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::class, 'targetAttribute' => ['id_region' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_org' => 'Id Org',
            'name' => 'Name',
            'address' => 'Address',
            'id_region' => 'Id Region',
            'kad_number' => 'Kad Number',
            'osn_isp' => 'Osn Isp',
            'reg_zap' => 'Reg Zap',
            'doc_number' => 'Doc Number',
            'flat_plan' => 'Flat Plan',
            'flat_type' => 'Flat Type',
            'prib_type' => 'Prib Type',
            'smet' => 'Smet',
            'stroy_date_start' => 'Stroy Date Start',
            'stroy_date_end' => 'Stroy Date End',
            'exp_date' => 'Exp Date',
            'ob_fin_stroy' => 'Ob Fin Stroy',
            'money_faip' => 'Money Faip',
            'money_bud_sub' => 'Money Bud Sub',
            'money_vneb' => 'Money Vneb',
            'reconstruct' => 'Reconstruct',
            'ustav_dey' => 'Ustav Dey',
            'system_status' => 'System Status',
        ];
    }


    /**
     * Gets query for [[Org]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrg()
    {
        return $this->hasOne(Organizations::class, ['id' => 'id_org']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Regions::class, ['id' => 'id_region']);
    }

    public function getArea()
    {
        return $this->hasOne(ObjectsArea::class, ['id_object' => 'id']);
    }

    public function getMoney()
    {
        return $this->hasOne(ObjectsMoney::class, ['id_object' => 'id']);
    }

    public function getTariff()
    {
        return $this->hasOne(ObjectsTariff::class, ['id_object' => 'id']);
    }

    /**
     * @param int | array $id_org
     * @param int $idEgrnAssignment
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public static function getRealEstateObjects($id_org, int $idEgrnAssignment = 1): array
    {
        $id_org = is_array($id_org) ? 'id_orgs:['.implode(',',$id_org).']' : 'id_org:'.$id_org;

        $client = new Client();
        $response = $client->createRequest()
            ->setUrl('https://xn--b1adcgjb2abq4al4j.xn--80apneeq.xn--p1ai/api/graph?access-token=23498jfskduespq0')
            ->setMethod('POST')
            ->setData(['query' => "{
            realEstates({$id_org},id_egrn_assignment:{$idEgrnAssignment}){              
                cadastral_number
                egrn_id_region
                id
                id_org
                object_name
                objectEgrnAddress   
                registration_right_number     
                registration_right_date
                id_right_type
            }
        }"])->send();


        return $response->getData()['data']['realEstates'];
    }
}
