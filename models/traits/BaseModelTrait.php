<?php


namespace app\models\traits;

trait BaseModelTrait
{
    public static function getActive(bool $getAll = false)
    {
        $query = self::find()->where(
            [self::tableName() . '.system_status' => 1]
        );
        if ($getAll) {
            return $query->all();
        }
        return $query;
    }
}
