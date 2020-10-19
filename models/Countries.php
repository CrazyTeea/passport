<?php

namespace app\models;

/**
 * This is the model class for table "countries".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $en
 * @property string|null $ru
 * @property string|null $flag
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['en', 'ru', 'flag'], 'string'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'en' => 'En',
            'ru' => 'Ru',
            'flag' => 'Flag',
        ];
    }
}
