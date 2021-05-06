<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "org_living_students".
 *
 * @property int           $id
 * @property int|null      $id_org
 * @property int|null      $id_living
 * @property string|null   $type
 * @property string|null   $name
 * @property int|null      $spo
 * @property int|null      $bak
 * @property int|null      $spec
 * @property int|null      $mag
 * @property int|null      $asp
 * @property int|null      $ord
 * @property int|null      $in
 * @property int|null      $budjet_type
 * @property int|null      $invalid
 *
 * @property OrgLiving     $living
 * @property Organizations $org
 */
class OrgLivingStudents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'org_living_students';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id_org', 'id_living', 'spo', 'bak',
                'spec', 'mag', 'asp', 'ord', 'in', 'budjet_type', 'invalid'], 'integer'],
            [['type', 'name'], 'string'],
            [['id_living'], 'exist', 'skipOnError' => true, 'targetClass' => OrgLiving::className(), 'targetAttribute' => ['id_living' => 'id']],
            [['id_org'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['id_org' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
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
    public function getLiving(): \yii\db\ActiveQuery
    {
        return $this->hasOne(OrgLiving::className(), ['id' => 'id_living']);
    }

    public function getCountry(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Countries::class, ['code'=>'name']);
    }


    public static function getIndexes($id_org = null): array
    {
        $studs = OrgLivingStudents::find();
        if ($id_org) {
            $studs = $studs->andWhere(['id_org' => $id_org]);
        }
        $studs = $studs->select(['id_org', 'budjet_type', "group_concat(name separator ',') names"]);
        $studs = $studs->groupBy("id_org,budjet_type");
        return ArrayHelper::index($studs->asArray()->all(), 'budjet_type', function ($el) {
            return $el['id_org'];
        });
    }

    /**
     * @param null $id_org
     * @param int  $invalid
     *
     * @return bool|int|mixed|string|null
     */

    public static function cntStudents($id_org = null, $invalid = 0)
    {
        $studs = OrgLivingStudents::find();
        if ($id_org) {
            $studs = $studs->andWhere(['id_org' => $id_org]);
        }


        //  $studs = $studs->groupBy('invalid,budjet_type,type,id_org');

        //dd($arr);
        return $studs->asArray()->all();
    }

    /**
     * Gets query for [[Org]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrg(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Organizations::className(), ['id' => 'id_org']);
    }
}
