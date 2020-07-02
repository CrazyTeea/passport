<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organizations".
 *
 * @property int $id
 * @property string|null $full_name
 * @property string|null $name
 * @property string|null $short_name
 * @property int|null $id_region
 * @property int|null $id_founder
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $system_status
 *
 * @property Founders $founder
 * @property Regions $region
 */
class Organizations extends \yii\db\ActiveRecord
{
    public $reg;
    public $foun;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organizations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'name', 'short_name'], 'string'],
            [['id_region', 'id_founder', 'system_status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_founder'], 'exist', 'skipOnError' => true, 'targetClass' => Founders::className(), 'targetAttribute' => ['id_founder' => 'id']],
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
            'full_name' => 'Full Name',
            'name' => 'Name',
            'short_name' => 'Short Name',
            'id_region' => 'Id Region',
            'id_founder' => 'Id Founder',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'system_status' => 'System Status',
        ];
    }

    /**
     * Gets query for [[Founder]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFounder()
    {
        return $this->hasOne(Founders::className(), ['id' => 'id_founder']);
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

    public function getUsersInfo(){
        return $this->hasMany(UsersInfo::class,['id_org'=>'id']);
    }
}
