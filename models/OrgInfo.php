<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "org_info".
 *
 * @property int $id
 * @property int|null $id_org
 * @property int|null $stud_cnt
 * @property int|null $stud_cnt_rus
 * @property int|null $stud_cnt_inos
 * @property int|null $stud_type
 * @property int|null $s_f_b_spo
 * @property int|null $s_f_b_bak
 * @property int|null $s_f_b_spec
 * @property int|null $s_f_b_mag
 * @property int|null $s_f_b_asp
 * @property int|null $s_f_b_ord
 * @property int|null $s_f_b_in
 * @property int|null $s_b_s_spo
 * @property int|null $s_b_s_bak
 * @property int|null $s_b_s_spec
 * @property int|null $s_b_s_mag
 * @property int|null $s_b_s_asp
 * @property int|null $s_b_s_ord
 * @property int|null $s_b_s_in
 * @property int|null $s_m_b_spo
 * @property int|null $s_m_b_bak
 * @property int|null $s_m_b_spec
 * @property int|null $s_m_b_mag
 * @property int|null $s_m_b_asp
 * @property int|null $s_m_b_ord
 * @property int|null $s_m_b_in
 * @property int|null $s_p_u_spo
 * @property int|null $s_p_u_bak
 * @property int|null $s_p_u_spec
 * @property int|null $s_p_u_mag
 * @property int|null $s_p_u_asp
 * @property int|null $s_p_u_ord
 * @property int|null $s_p_u_in
 *
 * @property Organizations $org
 */
class OrgInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'org_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_org', 'stud_type', 's_f_b_spo', 's_f_b_bak', 's_f_b_spec', 's_f_b_mag', 's_f_b_asp', 's_f_b_ord', 's_f_b_in', 's_b_s_spo', 's_b_s_bak', 's_b_s_spec', 's_b_s_mag', 's_b_s_asp', 's_b_s_ord', 's_b_s_in', 's_m_b_spo', 's_m_b_bak', 's_m_b_spec', 's_m_b_mag', 's_m_b_asp', 's_m_b_ord', 's_m_b_in', 's_p_u_spo', 's_p_u_bak', 's_p_u_spec', 's_p_u_mag', 's_p_u_asp', 's_p_u_ord', 's_p_u_in'], 'integer'],
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
            'stud_cnt' => 'Stud Cnt',
            'stud_cnt_rus' => 'Stud Cnt Rus',
            'stud_cnt_inos' => 'Stud Cnt Inos',
            'stud_type' => 'Stud Type',
            's_f_b_spo' => 'S F B Spo',
            's_f_b_bak' => 'S F B Bak',
            's_f_b_spec' => 'S F B Spec',
            's_f_b_mag' => 'S F B Mag',
            's_f_b_asp' => 'S F B Asp',
            's_f_b_ord' => 'S F B Ord',
            's_f_b_in' => 'S F B In',
            's_b_s_spo' => 'S B S Spo',
            's_b_s_bak' => 'S B S Bak',
            's_b_s_spec' => 'S B S Spec',
            's_b_s_mag' => 'S B S Mag',
            's_b_s_asp' => 'S B S Asp',
            's_b_s_ord' => 'S B S Ord',
            's_b_s_in' => 'S B S In',
            's_m_b_spo' => 'S M B Spo',
            's_m_b_bak' => 'S M B Bak',
            's_m_b_spec' => 'S M B Spec',
            's_m_b_mag' => 'S M B Mag',
            's_m_b_asp' => 'S M B Asp',
            's_m_b_ord' => 'S M B Ord',
            's_m_b_in' => 'S M B In',
            's_p_u_spo' => 'S P U Spo',
            's_p_u_bak' => 'S P U Bak',
            's_p_u_spec' => 'S P U Spec',
            's_p_u_mag' => 'S P U Mag',
            's_p_u_asp' => 'S P U Asp',
            's_p_u_ord' => 'S P U Ord',
            's_p_u_in' => 'S P U In',
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
}
