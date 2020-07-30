<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string|null $name
 */
class Files extends \yii\db\ActiveRecord
{
    public function deleteFile($id_org,$desc){
        $path = Yii::getAlias('@webroot')."/uploads/orgs/$id_org/$desc/$this->name";
        if (file_exists($path))
            unlink($path);
        $this->delete();
    }
    public function upload(UploadedFile $file,Int $id_org,String $desc) : Int {
        $this->name = $file->name;
        $this->save();

        $path = Yii::getAlias('@webroot')."/uploads/orgs/$id_org/$desc";
        if (!file_exists($path))
            FileHelper::createDirectory($path);
        $path.="/$this->name";
        $file->saveAs($path);

        $file = null;

        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
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
}
