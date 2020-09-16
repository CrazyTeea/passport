<?php

namespace app\models;

use Yii;

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
 *
 * @property Organizations $org
 * @property Regions $region
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
            [['id_org', 'id_region', 'reconstruct', 'ustav_dey', 'system_status'], 'integer'],
            [['name', 'address', 'kad_number', 'osn_isp', 'flat_plan', 'flat_type', 'prib_type'], 'string'],
            [['smet', 'money_faip', 'money_bud_sub', 'money_vneb'], 'number'],
            [['stroy_date_start', 'stroy_date_end', 'exp_date', 'ob_fin_stroy'], 'safe'],
            [['reg_zap', 'doc_number'], 'string', 'max' => 255],
            [['id_org'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['id_org' => 'id']],
            [['id_region'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::className(), 'targetAttribute' => ['id_region' => 'id']],
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
        return $this->hasOne(Organizations::className(), ['id' => 'id_org']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Regions::className(), ['id' => 'id_region']);
    }
    public function getArea()
    {
        return $this->hasOne(ObjectsArea::className(), ['id_object' => 'id']);
    }
    public function getMoney()
    {
        return $this->hasOne(ObjectsMoney::className(), ['id_object' => 'id']);
    }
    public function getTariff()
    {
        return $this->hasOne(ObjectsTariff::className(), ['id_object' => 'id']);
    }
}
