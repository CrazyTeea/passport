<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Objects;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    public function actionIndex()
    {
        Objects::updateAll([
            'date_start_reconstruct' => null,
            'date_end_reconstruct' => null,
            'rec_money_faip' => null,
            'rec_money_bud_sub' => null,
            'rec_money_vneb' => null
        ], ['reconstruct' => 0]);
        Objects::updateAll([
            'date_start_reconstruct' => null,
            'date_end_reconstruct' => null,
            'rec_money_faip' => null,
            'rec_money_bud_sub' => null,
            'rec_money_vneb' => null
        ], ['is', 'reconstruct', null]);
    }
}
