<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "objects_area".
 *
 * @property int $id
 * @property int $id_object
 * @property float|null $zan_obuch
 * @property float|null $zan_inie
 * @property float|null $svobod
 * @property float|null $neisp
 * @property float|null $punkt_pit
 * @property float|null $pom_dlya_uch
 * @property float|null $pom_dlya_med
 * @property float|null $pom_dlya_sport
 * @property float|null $pom_dlya_soc
 * @property float|null $pom_dlya_kult
 * @property float|null $in_nezh_plosh
 * @property float|null $zhil_tkr
 * @property float|null $zhil_nas
 * @property float|null $zhil_np
 * @property float|null $nzhil_tkr
 * @property float|null $nzhil_nas
 * @property float|null $nzhil_np
 * @property float|null $aren
 * @property float|null $pbp
 * @property int|null $cnt_mest_zan_obuch
 * @property int|null $cnt_mest_zan_in_obuch
 * @property int|null $cnt_svobod_mest
 * @property int|null $cnt_neisp_mest
 * @property int|null $cnt_nepr_isp_mest
 * @property int|null $cnt_mest_inv
 * @property int|null $cnt_mest_vozm_neisp_mest
 * @property int|null $cnt_mest_vozm_neprig_mest
 *
 * @property Objects $object
 */
class ObjectsArea extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objects_area';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_object'], 'required'],
            [['id_object', 'cnt_mest_zan_obuch', 'cnt_mest_zan_in_obuch', 'cnt_svobod_mest', 'cnt_neisp_mest', 'cnt_nepr_isp_mest', 'cnt_mest_inv', 'cnt_mest_vozm_neisp_mest', 'cnt_mest_vozm_neprig_mest'], 'integer'],
            [['zan_obuch', 'zan_inie', 'svobod', 'neisp', 'punkt_pit', 'pom_dlya_uch', 'pom_dlya_med', 'pom_dlya_sport', 'pom_dlya_soc', 'in_nezh_plosh', 'zhil_tkr', 'zhil_nas', 'zhil_np', 'nzhil_tkr', 'nzhil_nas', 'nzhil_np', 'aren', 'pbp'], 'number'],
            [['id_object'], 'exist', 'skipOnError' => true, 'targetClass' => Objects::className(), 'targetAttribute' => ['id_object' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_object' => 'Id Object',
            'zan_obuch' => 'Zan Obuch',
            'zan_inie' => 'Zan Inie',
            'svobod' => 'Svobod',
            'neisp' => 'Neisp',
            'punkt_pit' => 'Punkt Pit',
            'pom_dlya_uch' => 'Pom Dlya Uch',
            'pom_dlya_med' => 'Pom Dlya Med',
            'pom_dlya_sport' => 'Pom Dlya Sport',
            'pom_dlya_soc' => 'Pom Dlya Soc',
            'in_nezh_plosh' => 'In Nezh Plosh',
            'zhil_tkr' => 'Zhil Tkr',
            'zhil_nas' => 'Zhil Nas',
            'zhil_np' => 'Zhil Np',
            'nzhil_tkr' => 'Nzhil Tkr',
            'nzhil_nas' => 'Nzhil Nas',
            'nzhil_np' => 'Nzhil Np',
            'aren' => 'Aren',
            'pbp' => 'Pbp',
            'cnt_mest_zan_obuch' => 'Cnt Mest Zan Obuch',
            'cnt_mest_zan_in_obuch' => 'Cnt Mest Zan In Obuch',
            'cnt_svobod_mest' => 'Cnt Svobod Mest',
            'cnt_neisp_mest' => 'Cnt Neisp Mest',
            'cnt_nepr_isp_mest' => 'Cnt Nepr Isp Mest',
            'cnt_mest_inv' => 'Cnt Mest Inv',
            'cnt_mest_vozm_neisp_mest' => 'Cnt Mest Vozm Neisp Mest',
            'cnt_mest_vozm_neprig_mest' => 'Cnt Mest Vozm Neprig Mest',
        ];
    }

    /**
     * Gets query for [[Object]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(Objects::className(), ['id' => 'id_object']);
    }
}
