<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%org_area}}`.
 */
class m200706_111201_create_org_area_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%org_area}}', [
            'id' => $this->primaryKey(),
            'id_org'=>$this->integer(),
            'area_prig_prozh'=>$this->decimal(22,2),
            'area_zhil_prig_prozh'=>$this->decimal(22,2),
            'area_zan_obuch'=>$this->decimal(22,2),
            'area_in_kat_nan'=>$this->decimal(22,2),
            'svobod'=>$this->decimal(22,2),
            'ne_isp'=>$this->decimal(22,2),
            'ne_zhil_plosh_v_prig_dlya_prozh'=>$this->decimal(22,2),
            'area_obsh_ne_prig_dlya_prozh'=>$this->decimal(22,2),

            'area_zhil_t_k_r'=>$this->decimal(22,2),
            'area_zhil_n_a_s'=>$this->decimal(22,2),
            'area_zhil_n_p'=>$this->decimal(22,2),

            'area_ne_zhil_t_k_r'=>$this->decimal(22,2),
            'area_ne_zhil_n_a_s'=>$this->decimal(22,2),
            'area_ne_zhil_n_p'=>$this->decimal(22,2),

            'area_obsh_t_k_r'=>$this->decimal(22,2),
            'area_obsh_zhil_n_a_s'=>$this->decimal(22,2),
            'area_obsh_zhil_n_p'=>$this->decimal(22,2),

            'area_kv_metr_zhil'=>$this->decimal(22,2),
            'area_kv_metr_obsh'=>$this->decimal(22,2),

            'area_obj_ne_isp_v_ust_dey'=>$this->decimal(22,2),
            
            'area_cnt_mest'=>$this->integer(),
            'area_cnt_mest_prig_prozh'=>$this->integer(),
            'area_cnt_mest_zan_obuch'=>$this->integer(),

            'm2_spo'=>$this->decimal(22,2),
            'm2_bak'=>$this->decimal(22,2),
            'm2_spec'=>$this->decimal(22,2),
            'm2_mag'=>$this->decimal(22,2),
            'm2_asp'=>$this->decimal(22,2),
            'm2_ord'=>$this->decimal(22,2),
            'm2_in'=>$this->decimal(22,2),

            '6m2_spo'=>$this->decimal(22,2),
            '6m2_bak'=>$this->decimal(22,2),
            '6m2_spec'=>$this->decimal(22,2),
            '6m2_mag'=>$this->decimal(22,2),
            '6m2_asp'=>$this->decimal(22,2),
            '6m2_ord'=>$this->decimal(22,2),
            '6m2_in'=>$this->decimal(22,2),

            'area_cnt_mest_zan_in_obuch'=>$this->integer(),
            'area_cnt_svob_mest'=>$this->integer(),
            'area_cnt_ne_mest'=>$this->integer(),
            'area_cnt_mest_ne_prig_k_prozh'=>$this->integer(),

            'area_cnt_mest_invalid'=>$this->integer(),


        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%org_area}}');
    }
}
