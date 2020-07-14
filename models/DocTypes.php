<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_types".
 *
 * @property int $id
 * @property string|null $desc
 * @property string|null $label
 */
class DocTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doc_types';
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
}
