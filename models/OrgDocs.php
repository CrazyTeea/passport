<?php

namespace app\models;

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
            [['id_desc', 'id_org', 'id_file'], 'integer'],
            [['id_desc', 'id_org', 'id_file'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'id_desc' => 'Id Desc',
            'id_org' => 'Id Org',
        ];
    }

    public function getDescriptor(): \yii\db\ActiveQuery
    {
        return $this->hasOne(DocTypes::class, ['id' => 'id_desc']);
    }

    public function getFile(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Files::class, ['id' => 'id_file']);
    }
}
