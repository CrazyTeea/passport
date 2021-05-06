<?php

namespace app\models;

use app\models\traits\BaseModelTrait;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\httpclient\Client;
use yii\httpclient\Exception;

/**
 * This is the model class for table "objects".
 *
 * @property string|null $address
 * @property int $const_count_pol
 * @property int $count_pol
 * @property int|null $date_end_reconstruct
 * @property int|null $date_start_reconstruct
 * @property string|null $doc_number
 * @property string|null $exp_date
 * @property string|null $flat_plan
 * @property string|null $flat_type
 * @property int $id
 * @property int $id_org
 * @property int $id_realEstate
 * @property int $id_region
 * @property string|null $kad_number
 * @property int|null $max_per
 * @property int|null $mech_por
 * @property int|null $min_per
 * @property float|null $money_bud_sub
 * @property float|null $money_faip
 * @property float|null $money_vneb
 * @property string|null $name
 * @property string|null $ob_fin_stroy
 * @property string|null $osn_isp
 * @property int|null $pandus
 * @property int|null $pokr
 * @property string|null $prib_type
 * @property int|null $reconstruct
 * @property int|null $rec_money_bud_sub
 * @property int|null $rec_money_faip
 * @property int|null $rec_money_vneb
 * @property string|null $reg_zap
 * @property int|null $sanusel
 * @property int|null $signal
 * @property float|null $smet
 * @property string|null $stroy_date_end
 * @property string|null $stroy_date_start
 * @property int|null $system_status
 * @property int|null $ustav_dey
 * @property int|null $vives
 * @property int|null $wifi
 * @property int|null $year_cen
 *
 * @property ObjectsArea $area
 * @property ObjectsMoney $money
 * @property Organizations $org
 * @property Regions $region
 * @property ObjectsTariff $tariff
 */
class Objects extends ActiveRecord
{
    use BaseModelTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'objects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [[
                'address', 'flat_plan', 'flat_type', 'kad_number', 'name', 'osn_isp', 'prib_type', 'wifi'
            ], 'safe'],
            [[
                'const_count_pol', 'count_pol', 'id_org', 'id_region', 'max_per', 'mech_por', 'min_per', 'pandus',
                'pokr', 'reconstruct', 'sanusel', 'signal', 'system_status', 'ustav_dey', 'vives', 'year_cen'
            ], 'integer'],
            [[
                'date_end_reconstruct', 'date_start_reconstruct', 'exp_date', 'ob_fin_stroy', 'stroy_date_end',
                'stroy_date_start','reg_zap',
            ], 'safe'],
            [['doc_number',],'string','max'=>100],
            [['nevos_reason', 'reason', 'uslovie'], 'string'],
            [['id_org'], 'required'],
            [['id_org'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::class, 'targetAttribute' => ['id_org' => 'id']],
            [['id_region'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::class, 'targetAttribute' => ['id_region' => 'id']],
            [[
                'money_bud_sub', 'money_faip', 'money_vneb', 'rec_money_bud_sub', 'rec_money_faip', 'rec_money_vneb',
                'smet'
            ], 'number']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
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

    public function getOrg(): ActiveQuery
    {
        return $this->hasOne(Organizations::class, ['id' => 'id_org']);
    }

    public function getRegion(): ActiveQuery
    {
        return $this->hasOne(Regions::class, ['id' => 'id_region']);
    }

    public function getArea(): ActiveQuery
    {
        return $this->hasOne(ObjectsArea::class, ['id_object' => 'id']);
    }

    public function getMoney(): ActiveQuery
    {
        return $this->hasOne(ObjectsMoney::class, ['id_object' => 'id']);
    }

    public function getTariff(): ActiveQuery
    {
        return $this->hasOne(ObjectsTariff::class, ['id_object' => 'id']);
    }

    public function getDocs(): ActiveQuery
    {
        return $this->hasMany(ObjFiles::class, ['id_obj' => 'id']);
    }

    public function countingNumberFields(): bool
    {
        $this->count_pol = 0;
        $array_obj = [
            'const_count_pol', 'count_pol', 'created_at', 'id', 'id_org', 'id_realEstate', 'ob_fin_stroy',
            'system_status', 'updated_at'
        ];
        if ($this->reconstruct != 1) {
            $array_obj = array_merge($array_obj, ['date_end_reconstruct', 'date_start_reconstruct']);
        }
        foreach ($this as $key => $val) {
            if (!in_array($key, $array_obj)) {
                if (!is_null($val)) {
                    $this->count_pol++;
                }
            }
        }
        if ($area = $this->area) {
            foreach ($area as $key => $val) {
                if (!in_array($key, ['cnt_mest_obsh_na_odn', 'cnt_mest_pl_na_odn', 'id', 'id_object'])) {
                    if (!is_null($val)) {
                        $this->count_pol++;
                    }
                }
            }
        }
        if ($money = $this->money) {
            foreach ($money as $key => $val) {
                if (!in_array($key, ['id', 'id_object'])) {
                    if (!is_null($val)) {
                        $this->count_pol++;
                    }
                }
            }
        }
        if ($tariff = $this->tariff) {
            foreach ($tariff as $key => $val) {
                if (!in_array($key, ['id', 'id_object'])) {
                    if (!is_null($val)) {
                        $this->count_pol++;
                    }
                }
            }
        }
        return $this->save();
    }

    /**
     * @param int | array $id_org
     * @param int | null $idEgrnAssignment
     * @return array
     * @throws InvalidConfigException
     * @throws Exception
     */
    public static function getRealEstateObjects($id_org, $idEgrnAssignment = 1): array
    {
        return [];
        $id_org = is_array($id_org) ? 'id_orgs:[' . implode(',', $id_org) . ']' : 'id_org:' . $id_org;

        $client = new Client();

        $where = $idEgrnAssignment ? "{$id_org},id_egrn_assignment:{$idEgrnAssignment}" : $id_org;

        $response = $client->createRequest()
            ->setUrl('https://xn--b1adcgjb2abq4al4j.xn--80apneeq.xn--p1ai/api/graph?access-token=23498jfskduespq0')
            ->setMethod('POST')
            ->setData(['query' => "{
            realEstates({$where}){              
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

    public static function getRealEstateObjects2($id_org, $idEgrnAssignment = 1): array
    {
        $id_org = is_array($id_org) ? 'id_orgs:[' . implode(',', $id_org) . ']' : 'id_org:' . $id_org;

        $client = new Client();

        $where = $idEgrnAssignment ? "{$id_org},id_egrn_assignment:{$idEgrnAssignment}" : $id_org;

        $response = $client->createRequest()
            ->setUrl('https://xn--b1adcgjb2abq4al4j.xn--80apneeq.xn--p1ai/api/graph?access-token=23498jfskduespq0')
            ->setMethod('POST')
            ->setData(['query' => "{
            realEstates({$where}){              
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

    /**
     * @param int $id_object
     * @return array
     * @throws Exception
     * @throws InvalidConfigException
     */
    public static function getRealEstateObject(int $id_object): array
    {
        return [];
        $client = new Client();
        $response = $client->createRequest()
            ->setUrl('https://xn--b1adcgjb2abq4al4j.xn--80apneeq.xn--p1ai/api/graph?access-token=23498jfskduespq0')
            ->setMethod('POST')
            ->setData(['query' => "{
            realEstate(id:{$id_object}){              
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

        return $response->getData()['data']['realEstate'];
    }
}
