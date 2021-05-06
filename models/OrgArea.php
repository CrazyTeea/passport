<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "org_area".
 *
 * @property int $id
 * @property int|null $id_org
 * @property int|null $m2_spo
 * @property int|null $m2_bak
 * @property int|null $m2_spec
 * @property int|null $m2_mag
 * @property int|null $m2_asp
 * @property int|null $m2_ord
 * @property int|null $m2_in
 * @property int|null $m2_vis
 * @property int|null $c6m2_spo
 * @property int|null $c6m2_bak
 * @property int|null $c6m2_spec
 * @property int|null $c6m2_mag
 * @property int|null $c6m2_asp
 * @property int|null $c6m2_ord
 * @property int|null $c6m2_in
 * @property int|null $c6m2_vis
 * @property int|null $area_cnt_nuzhd_zhil
 * @property int|null $area_cnt_prozh_u_drugih
 *
 * @property Organizations $org
 */
class OrgArea extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'org_area';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_org'], 'integer'],
            [['m2_spo',  'm2_in',  'c6m2_in',
                'area_cnt_nuzhd_zhil', 'area_cnt_prozh_u_drugih', 'c6m2_vis', 'm2_vis'], 'number'],
            [['id_org'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['id_org' => 'id']],
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
            'm2_spo' => 'M2 Spo',
            'm2_in' => 'M2 In',
            'c6m2_spo' => 'C6m2 Spo',
            'c6m2_in' => 'C6m2 In',
            'area_cnt_nuzhd_zhil' => 'Area Cnt Nuzhd Zhil',
            'area_cnt_prozh_u_drugih' => 'Area Cnt Prozh U Drugih',
        ];
    }

    /**
     * Gets query for [[Org]].
     *
     * @return ActiveQuery
     */
    public function getOrg()
    {
        return $this->hasOne(Organizations::className(), ['id' => 'id_org']);
    }
}
