<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "obj_files".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property ObjDocs[] $objDocs
 */
class ObjFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obj_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[ObjDocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjDocs()
    {
        return $this->hasMany(ObjDocs::className(), ['id_obj_file' => 'id']);
    }


    public function deleteFile($id_obj, $desc)
    {
        $path = Yii::getAlias('@webroot') . "/uploads/objs/$id_obj/$desc/$this->name";
        if (file_exists($path)) {
            unlink($path);
        }
        $this->delete();
    }

    public function upload(UploadedFile $file, int $id_obj, string $desc): int
    {
        $this->name = $file->name;
        $this->save();

        $path = Yii::getAlias('@webroot') . "/uploads/objs/$id_obj/$desc";
        if (!file_exists($path)) {
            FileHelper::createDirectory($path);
        }
        $path .= "/$this->name";
        $file->saveAs($path);

        $file = null;

        return $this->id;
    }

}
