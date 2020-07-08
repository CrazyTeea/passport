<?php

namespace app\models;

/**
 * This is the model class for table "org_living".
 *
 * @property int $id
 * @property int $id_org
 * @property int|null $cnt_stud
 * @property int|null $cnt_stud_obuch
 * @property int|null $cnt_stug_step
 * @property int|null $prozh_is_person
 * @property int|null $rab_p
 * @property int|null $rab_s
 * @property int|null $nauch_p
 * @property int|null $nauch_s
 * @property int|null $prof_p
 * @property int|null $prof_s
 * @property int|null $in_p
 * @property int|null $in_s
 * @property int|null $inie_pr
 *
 * @property Organizations $org
 * @property OrgLivingStudents[] $orgLivingStudents
 */
class OrgLiving extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'org_living';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_org'], 'required'],
            [['id_org', 'cnt_stud', 'cnt_stud_obuch', 'cnt_stug_step', 'prozh_is_person', 'rab_p', 'rab_s', 'nauch_p', 'nauch_s', 'prof_p', 'prof_s', 'in_p','in_s', 'inie_pr'], 'integer'],
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
            'cnt_stud' => 'Cnt Stud',
            'cnt_stud_obuch' => 'Cnt Stud Obuch',
            'cnt_stug_step' => 'Cnt Stug Step',
            'prozh_is_person' => 'Prozh Is Person',
            'rab_p' => 'Rab P',
            'rab_s' => 'Rab S',
            'nauch_p' => 'Nauch P',
            'nauch_s' => 'Nauch S',
            'prof_p' => 'Prof P',
            'prof_s' => 'Prof S',
            'in_p' => 'In P',
            'inie_pr' => 'Inie Pr',
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

    /**
     * Gets query for [[OrgLivingStudents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrgLivingStudents()
    {
        return $this->hasMany(OrgLivingStudents::className(), ['id_living' => 'id']);
    }
}
