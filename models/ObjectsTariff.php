<?php

namespace app\models;

/**
 * This is the model class for table "objects_tariff".
 *
 * @property int $id
 * @property int $id_object
 * @property float|null $u_t_b
 * @property float|null $k_u_b
 * @property float|null $p_p_b
 * @property float|null $d_u_b
 * @property float|null $u_t_p
 * @property float|null $k_u_p
 * @property float|null $p_p_p
 * @property float|null $d_u_p
 * @property float|null $u_t_nr
 * @property float|null $k_u_nr
 * @property float|null $p_p_nr
 * @property float|null $d_u_nr
 * @property float|null $u_t_do
 * @property float|null $k_u_do
 * @property float|null $p_p_do
 * @property float|null $d_u_do
 * @property float|null $u_t_in
 * @property float|null $k_u_in
 * @property float|null $p_p_in
 * @property float|null $d_u_in
 *
 * @property Objects $object
 */
class ObjectsTariff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objects_tariff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_object'], 'required'],
            [['id_object'], 'integer'],
            [['u_t_b', 'k_u_b', 'p_p_b', 'd_u_b', 'u_t_p', 'k_u_p', 'p_p_p', 'd_u_p', 'u_t_nr',
                'k_u_nr', 'p_p_nr', 'd_u_nr', 'u_t_do', 'k_u_do', 'p_p_do', 'd_u_do', 'u_t_in',
                'k_u_in', 'p_p_in', 'd_u_in'], 'number'],
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
            'u_t_b' => 'U T B',
            'k_u_b' => 'K U B',
            'p_p_b' => 'P P B',
            'd_u_b' => 'D U B',
            'u_t_p' => 'U T P',
            'k_u_p' => 'K U P',
            'p_p_p' => 'P P P',
            'd_u_p' => 'D U P',
            'u_t_nr' => 'U T Nr',
            'k_u_nr' => 'K U Nr',
            'p_p_nr' => 'P P Nr',
            'd_u_nr' => 'D U Nr',
            'u_t_do' => 'U T Do',
            'k_u_do' => 'K U Do',
            'p_p_do' => 'P P Do',
            'd_u_do' => 'D U Do',
            'u_t_in' => 'U T In',
            'k_u_in' => 'K U In',
            'p_p_in' => 'P P In',
            'd_u_in' => 'D U In',
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
