<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "org_area".
 *
 * @property int $id
 * @property int|null $id_org
 * @property float|null $area_prig_prozh
 * @property float|null $area_zhil_prig_prozh
 * @property float|null $area_zan_obuch
 * @property float|null $area_in_kat_nan
 * @property float|null $svobod
 * @property float|null $ne_isp
 * @property float|null $ne_zhil_plosh_v_prig_dlya_prozh
 * @property float|null $area_obsh_ne_prig_dlya_prozh
 * @property float|null $area_zhil_t_k_r
 * @property float|null $area_zhil_n_a_s
 * @property float|null $area_zhil_n_p
 * @property float|null $area_ne_zhil_t_k_r
 * @property float|null $area_ne_zhil_n_a_s
 * @property float|null $area_ne_zhil_n_p
 * @property float|null $area_obsh_t_k_r
 * @property float|null $area_obsh_zhil_n_a_s
 * @property float|null $area_obsh_zhil_n_p
 * @property float|null $area_kv_metr_zhil
 * @property float|null $area_kv_metr_obsh
 * @property float|null $area_obj_ne_isp_v_ust_dey
 * @property int|null $area_cnt_mest
 * @property int|null $area_cnt_mest_prig_prozh
 * @property int|null $area_cnt_mest_zan_obuch
 * @property float|null $m2_spo
 * @property float|null $m2_bak
 * @property float|null $m2_spec
 * @property float|null $m2_mag
 * @property float|null $m2_asp
 * @property float|null $m2_ord
 * @property float|null $m2_in
 * @property float|null $c6m2_spo
 * @property float|null $c6m2_bak
 * @property float|null $c6m2_spec
 * @property float|null $c6m2_mag
 * @property float|null $c6m2_asp
 * @property float|null $c6m2_ord
 * @property float|null $c6m2_in
 * @property int|null $area_cnt_mest_zan_in_obuch
 * @property int|null $area_cnt_svob_mest
 * @property int|null $area_cnt_ne_mest
 * @property int|null $area_cnt_mest_ne_prig_k_prozh
 * @property int|null $area_cnt_mest_invalid
 * @property int|null $area_cnt_nuzhd_zhil
 * @property int|null $area_cnt_prozh_u_drugih
 * @property int|null $area_cnt_mest_vozm_k_vvodu_v_esk
 * @property int|null $area_cnt_mest_vozm_mest_is_neisp
 * @property int|null $area_cnt_mest_vozm_mest_is_neprig
 *
 * @property Organizations $org
 */
class OrgArea extends \yii\db\ActiveRecord
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
            [['id_org', 'area_cnt_mest', 'area_cnt_mest_prig_prozh', 'area_cnt_mest_zan_obuch', 'area_cnt_mest_zan_in_obuch',
                'area_cnt_svob_mest', 'area_cnt_ne_mest', 'area_cnt_mest_ne_prig_k_prozh', 'area_cnt_mest_invalid',
                'area_cnt_nuzhd_zhil', 'area_cnt_prozh_u_drugih', 'area_cnt_mest_vozm_k_vvodu_v_esk',
                'area_cnt_mest_vozm_mest_is_neisp', 'area_cnt_mest_vozm_mest_is_neprig'], 'integer'],
            [['area_prig_prozh', 'area_zhil_prig_prozh', 'area_zan_obuch', 'area_in_kat_nan', 'svobod',
                'ne_isp', 'ne_zhil_plosh_v_prig_dlya_prozh', 'area_obsh_ne_prig_dlya_prozh', 'area_zhil_t_k_r',
                'area_zhil_n_a_s', 'area_zhil_n_p', 'area_ne_zhil_t_k_r', 'area_ne_zhil_n_a_s', 'area_ne_zhil_n_p',
                'area_obsh_t_k_r', 'area_obsh_zhil_n_a_s', 'area_obsh_zhil_n_p', 'area_kv_metr_zhil', 'area_kv_metr_obsh',
                'area_obj_ne_isp_v_ust_dey', 'm2_spo', 'm2_bak', 'm2_spec', 'm2_mag', 'm2_asp', 'm2_ord', 'm2_in', 'c6m2_spo',
                'c6m2_bak', 'c6m2_spec', 'c6m2_mag', 'c6m2_asp', 'c6m2_ord', 'c6m2_in'], 'number'],
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
            'area_prig_prozh' => 'Area Prig Prozh',
            'area_zhil_prig_prozh' => 'Area Zhil Prig Prozh',
            'area_zan_obuch' => 'Area Zan Obuch',
            'area_in_kat_nan' => 'Area In Kat Nan',
            'svobod' => 'Svobod',
            'ne_isp' => 'Ne Isp',
            'ne_zhil_plosh_v_prig_dlya_prozh' => 'Ne Zhil Plosh V Prig Dlya Prozh',
            'area_obsh_ne_prig_dlya_prozh' => 'Area Obsh Ne Prig Dlya Prozh',
            'area_zhil_t_k_r' => 'Area Zhil T K R',
            'area_zhil_n_a_s' => 'Area Zhil N A S',
            'area_zhil_n_p' => 'Area Zhil N P',
            'area_ne_zhil_t_k_r' => 'Area Ne Zhil T K R',
            'area_ne_zhil_n_a_s' => 'Area Ne Zhil N A S',
            'area_ne_zhil_n_p' => 'Area Ne Zhil N P',
            'area_obsh_t_k_r' => 'Area Obsh T K R',
            'area_obsh_zhil_n_a_s' => 'Area Obsh Zhil N A S',
            'area_obsh_zhil_n_p' => 'Area Obsh Zhil N P',
            'area_kv_metr_zhil' => 'Area Kv Metr Zhil',
            'area_kv_metr_obsh' => 'Area Kv Metr Obsh',
            'area_obj_ne_isp_v_ust_dey' => 'Area Obj Ne Isp V Ust Dey',
            'area_cnt_mest' => 'Area Cnt Mest',
            'area_cnt_mest_prig_prozh' => 'Area Cnt Mest Prig Prozh',
            'area_cnt_mest_zan_obuch' => 'Area Cnt Mest Zan Obuch',
            'm2_spo' => 'M2 Spo',
            'm2_bak' => 'M2 Bak',
            'm2_spec' => 'M2 Spec',
            'm2_mag' => 'M2 Mag',
            'm2_asp' => 'M2 Asp',
            'm2_ord' => 'M2 Ord',
            'm2_in' => 'M2 In',
            '6m2_spo' => '6m2 Spo',
            '6m2_bak' => '6m2 Bak',
            '6m2_spec' => '6m2 Spec',
            '6m2_mag' => '6m2 Mag',
            '6m2_asp' => '6m2 Asp',
            '6m2_ord' => '6m2 Ord',
            '6m2_in' => '6m2 In',
            'area_cnt_mest_zan_in_obuch' => 'Area Cnt Mest Zan In Obuch',
            'area_cnt_svob_mest' => 'Area Cnt Svob Mest',
            'area_cnt_ne_mest' => 'Area Cnt Ne Mest',
            'area_cnt_mest_ne_prig_k_prozh' => 'Area Cnt Mest Ne Prig K Prozh',
            'area_cnt_mest_invalid' => 'Area Cnt Mest Invalid',
            'area_cnt_nuzhd_zhil' => 'Area Cnt Nuzhd Zhil',
            'area_cnt_prozh_u_drugih' => 'Area Cnt Prozh U Drugih',
            'area_cnt_mest_vozm_k_vvodu_v_esk' => 'Area Cnt Mest Vozm K Vvodu V Esk',
            'area_cnt_mest_vozm_mest_is_neisp' => 'Area Cnt Mest Vozm Mest Is Neisp',
            'area_cnt_mest_vozm_mest_is_neprig' => 'Area Cnt Mest Vozm Mest Is Neprig',
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
