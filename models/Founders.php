<?php

namespace app\models;

/**
 * This is the model class for table "founders".
 *
 * @property int $id
 * @property string|null $founder
 * @property int $system_status
 *
 * @property Organizations[] $organizations
 */
class Founders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'founders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['system_status'],'integer'],
            [['founder'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'founder' => 'Founder',
        ];
    }

    /**
     * Gets query for [[Organizations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations()
    {
        return $this->hasMany(Organizations::className(), ['id_founder' => 'id']);
    }
}
