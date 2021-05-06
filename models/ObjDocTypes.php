<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "obj_doc_types".
 *
 * @property int $id
 * @property string|null $desc
 * @property string|null $label
 *
 * @property ObjDocs[] $objDocs
 */
class ObjDocTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obj_doc_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label'], 'string'],
            [['desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desc' => 'Desc',
            'label' => 'Label',
        ];
    }

    /**
     * Gets query for [[ObjDocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjDocs()
    {
        return $this->hasMany(ObjDocs::class, ['id_obj_desc' => 'id']);
    }

}
