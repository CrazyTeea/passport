<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "obj_docs".
 *
 * @property int $id
 * @property int|null $id_obj_desc
 * @property int|null $id_obj
 * @property int|null $id_obj_file
 *
 * @property Objects $obj
 * @property ObjDocTypes $objDesc
 * @property ObjFiles $objFile
 */
class ObjDocs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obj_docs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_obj_desc', 'id_obj', 'id_obj_file'], 'integer'],
            [['id_obj'], 'exist', 'skipOnError' => true,
                'targetClass' => Objects::class, 'targetAttribute' => ['id_obj' => 'id']],
            [['id_obj_desc'], 'exist', 'skipOnError' => true,
                'targetClass' => ObjDocTypes::class, 'targetAttribute' => ['id_obj_desc' => 'id']],
            [['id_obj_file'], 'exist', 'skipOnError' => true,
                'targetClass' => ObjFiles::class, 'targetAttribute' => ['id_obj_file' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_obj_desc' => 'Id Obj Desc',
            'id_obj' => 'Id Obj',
            'id_obj_file' => 'Id Obj File',
        ];
    }

    /**
     * Gets query for [[Obj]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObj()
    {
        return $this->hasOne(Objects::class, ['id' => 'id_obj']);
    }

    /**
     * Gets query for [[ObjDesc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDescriptor()
    {
        return $this->hasOne(ObjDocTypes::class, ['id' => 'id_obj_desc']);
    }

    /**
     * Gets query for [[ObjFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(ObjFiles::class, ['id' => 'id_obj_file']);
    }
}
