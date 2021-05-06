<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "org_info".
 *
 * @property int $id
 * @property int $id_org
 * @property int|null $stud_cnt
 * @property int|null $stud_cnt_inos
 * @property int|null $stud_cnt_rus
 * @property int|null $stud_type
 * @property int|null $s_b_s_asp
 * @property int|null $s_b_s_bak
 * @property int|null $s_b_s_in
 * @property int|null $s_b_s_mag
 * @property int|null $s_b_s_ord
 * @property int|null $s_b_s_spec
 * @property int|null $s_b_s_spo
 * @property int|null $s_f_b_asp
 * @property int|null $s_f_b_bak
 * @property int|null $s_f_b_in
 * @property int|null $s_f_b_mag
 * @property int|null $s_f_b_ord
 * @property int|null $s_f_b_spec
 * @property int|null $s_f_b_spo
 * @property int|null $s_m_b_asp
 * @property int|null $s_m_b_bak
 * @property int|null $s_m_b_in
 * @property int|null $s_m_b_mag
 * @property int|null $s_m_b_ord
 * @property int|null $s_m_b_spec
 * @property int|null $s_m_b_spo
 * @property int|null $s_p_u_asp
 * @property int|null $s_p_u_bak
 * @property int|null $s_p_u_in
 * @property int|null $s_p_u_mag
 * @property int|null $s_p_u_ord
 * @property int|null $s_p_u_spec
 * @property int|null $s_p_u_spo
 *
 * @property Organizations $org
 */
class OrgInfo extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'org_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [[
                'id_org', 'stud_type', 's_b_s_asp', 's_b_s_bak', 's_b_s_in', 's_b_s_mag', 's_b_s_ord', 's_b_s_spec',
                's_b_s_spo', 's_f_b_asp', 's_f_b_bak', 's_f_b_in', 's_f_b_mag', 's_f_b_ord', 's_f_b_spec', 's_f_b_spo',
                's_m_b_asp', 's_m_b_bak', 's_m_b_in', 's_m_b_mag', 's_m_b_ord', 's_m_b_spec', 's_m_b_spo', 's_p_u_asp',
                's_p_u_bak', 's_p_u_in', 's_p_u_mag', 's_p_u_ord', 's_p_u_spec', 's_p_u_spo'
            ], 'integer'],


            [['id_org'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['id_org' => 'id']],
        ];
    }

    /**
     * Gets query for [[Org]].
     *
     * @return ActiveQuery
     */
    public function getOrg(): ActiveQuery
    {
        return $this->hasOne(Organizations::className(), ['id' => 'id_org']);
    }
}