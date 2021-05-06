<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "organizations".
 *
 * @property int $active
 * @property int $count_pol
 * @property string $created_at
 * @property boolean $data_complete
 * @property string|null $full_name
 * @property string|null $last_updated_at
 * @property int $id
 * @property int|null $id_founder
 * @property int|null $id_region
 * @property string|null $name
 * @property string|null $short_name
 * @property string|null $covid_var1
 * @property string|null $covid_var2
 * @property string|null $covid_var3
 * @property string|null $covid_var4
 * @property string|null $covid_var5
 * @property int|null $system_status
 * @property string $updated_at
 *
 * @property Founders $founder
 * @property OrgInfo[] $info
 * @property Regions $region
 *
 *
 */
class Organizations extends ActiveRecord
{
    public $reg;
    public $foun;


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'organizations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['active', 'id_founder', 'id_region', 'system_status'], 'integer'],
            [['created_at', 'data_complete', 'updated_at'], 'safe'],
            [['full_name', 'name', 'short_name', 'covid_var2'], 'string'],
            [['covid_var3', 'covid_var4', 'covid_var5',], 'number'],
            [['covid_var1', 'last_updated_at'], 'safe'],
            [['id_founder'], 'exist', 'skipOnError' => true, 'targetClass' => Founders::className(), 'targetAttribute' => ['id_founder' => 'id']],
            [['id_region'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::className(), 'targetAttribute' => ['id_region' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
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

    public static function Active($id)
    {
        if (\Yii::$app->user->can('user')) {
            $org = Organizations::findOne($id);
            if (!$org->active) {
                $org->active = true;
                $org->save(false);
            }
        }
    }

    /**
     * Gets query for [[Founder]].
     *
     * @return ActiveQuery
     */
    public function getFounder(): ActiveQuery
    {
        return $this->hasOne(Founders::className(), ['id' => 'id_founder']);
    }

    public function getObjs(): ActiveQuery
    {
        return $this->hasMany(Objects::class, ['id_org' => 'id'])->andOnCondition([Objects::tableName() . '.system_status' => 1]);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return ActiveQuery
     */
    public function getRegion(): ActiveQuery
    {
        return $this->hasOne(Regions::className(), ['id' => 'id_region']);
    }

    public function getUsersInfo(): ActiveQuery
    {
        return $this->hasMany(UsersInfo::class, ['id_org' => 'id']);
    }

    public function getInfo(): ActiveQuery
    {
        return $this->hasMany(OrgInfo::class, ['id_org' => 'id']);
    }

    public function getArea(): ActiveQuery
    {
        return $this->hasOne(OrgArea::class, ['id_org' => 'id']);
    }

    public function getLiving(): ActiveQuery
    {
        return $this->hasOne(OrgLiving::class, ['id_org' => 'id']);
    }

    public function getLivingStudents(): ActiveQuery
    {
        return $this->hasMany(OrgLivingStudents::class, ['id_org' => 'id']);
    }

    public function getOrgDocs(): ActiveQuery
    {
        return $this->hasMany(OrgDocs::class, ['id_org' => 'id']);
    }

    public static function UpdateTime($id_org)
    {
        if (!(Yii::$app->user->can('admin') || Yii::$app->user->can('root'))) {
            Organizations::updateAll(['last_updated_at' => date('Y-m-d H:i:s')], ['id' => $id_org]);
        }
    }

    public function countingNumberFields(): bool
    {
        $this->count_pol = 0;
        if (!is_null($this->covid_var1)) {
            $this->count_pol++;
        }
        if (!is_null($this->covid_var4)) {
            $this->count_pol++;
        }
        if (!is_null($this->covid_var5)) {
            $this->count_pol++;
        }

        if ($info = OrgInfo::findAll(['id_org' => $this->id])) {
            foreach ($info as $item) {
                foreach ($item as $key => $val) {
                    if (!in_array($key, ['created_at', 'id', 'id_org', 'stud_type', 'updated_at'])) {
                        if (!is_null($val)) {
                            $this->count_pol++;
                        }
                    }
                }
            }
        }
        if ($area = OrgArea::findOne(['id_org' => $this->id])) {
            foreach ($area as $key => $val) {
                if (!in_array($key, ['id', 'id_org'])) {
                    if (!is_null($val)) {
                        $this->count_pol++;
                    }
                }
            }
        }
        if ($living = OrgLiving::findOne(['id_org' => $this->id])) {
            foreach ($living as $key => $val) {
                if (!in_array($key, ['cnt_stud', 'cnt_stud_obuch', 'id', 'id_org', 'prozh_is_person'])) {
                    if (!is_null($val)) {
                        $this->count_pol++;
                    }
                }
            }
        }
        if ($livingStudents = OrgLivingStudents::findAll(['id_org' => $this->id])) {
            foreach ($livingStudents as $item) {
                foreach ($item as $key => $val) {
                    if (!in_array($key, ['budjet_type', 'id', 'id_org', 'invalid', 'id_living', 'name', 'type'])) {
                        if (!is_null($val)) {
                            $this->count_pol++;
                        }
                    }
                }
            }
        }
        return $this->save();
    }
}
