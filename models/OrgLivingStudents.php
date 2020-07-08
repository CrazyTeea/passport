<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "org_living_students".
 *
 * @property int $id
 * @property int|null $id_org
 * @property int|null $id_living
 * @property string|null $type
 * @property string|null $name
 * @property int|null $spo
 * @property int|null $bak
 * @property int|null $spec
 * @property int|null $mag
 * @property int|null $asp
 * @property int|null $ord
 * @property int|null $in
 * @property int|null $budjet_type
 * @property int|null $invalid
 *
 * @property OrgLiving $living
 * @property Organizations $org
 */
class OrgLivingStudents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'org_living_students';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_org', 'id_living', 'spo', 'bak', 'spec', 'mag', 'asp', 'ord', 'in', 'budjet_type', 'invalid'], 'integer'],
            [['type', 'name'], 'string'],
            [['id_living'], 'exist', 'skipOnError' => true, 'targetClass' => OrgLiving::className(), 'targetAttribute' => ['id_living' => 'id']],
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
            'id_living' => 'Id Living',
            'type' => 'Type',
            'name' => 'Name',
            'spo' => 'Spo',
            'bak' => 'Bak',
            'spec' => 'Spec',
            'mag' => 'Mag',
            'asp' => 'Asp',
            'ord' => 'Ord',
            'in' => 'In',
            'budjet_type' => 'Budjet Type',
            'invalid' => 'Invalid',
        ];
    }

    /**
     * Gets query for [[Living]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLiving()
    {
        return $this->hasOne(OrgLiving::className(), ['id' => 'id_living']);
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
