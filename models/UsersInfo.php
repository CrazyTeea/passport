<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_info".
 *
 * @property int $id
 * @property int|null $id_org
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $name
 * @property string|null $position
 * @property string|null $phone
 * @property string|null $email
 *
 * @property Organizations $org
 */
class UsersInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_org'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'position', 'phone', 'email'], 'string'],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Name',
            'position' => 'Position',
            'phone' => 'Phone',
            'email' => 'Email',
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
