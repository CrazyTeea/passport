<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "org_docs".
 *
 * @property int $id
 * @property int|null $id_desc
 * @property int|null $id_org
 * @property int|null $id_file
 */
class OrgDocs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'org_docs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_desc', 'id_org','id_file'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_desc' => 'Id Desc',
            'id_org' => 'Id Org',
        ];
    }

    public function getDescriptor(){
        return $this->hasOne(DocTypes::className(),['id'=>'id_desc']);
    }
    public function getFile(){
        return $this->hasOne(Files::className(),['id'=>'id_file']);
    }
}
