<?php


namespace app\controllers\app;


use app\models\Organizations;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use Yii;

class ExportController extends AppController
{
    public function actionExportStat()
    {
        $get = Yii::$app->request->get();

        $where = [];

        if (isset($get['id']) and $get['id'])
            $where['organizations.id'] = array_map(function ($item) {
                return $item * 1;
            }, explode(',', $get['id']));
        if (isset($get['id_founder']) and $get['id_founder'])
            $where['id_founder'] = explode(',', $get['id_founder']);
        if (isset($get['id_region']) and $get['id_region'])
            $where['id_region'] = explode(',', $get['id_region']);

        $orgs = Organizations::find()->andFilterWhere($where)->all();

        $html = $this->renderPartial('_stat', compact('orgs'));
        return $html;

        $reader = new Html();
        $html = $reader->loadFromString($html);

        $writer = IOFactory::createWriter($html, 'Xlsx');
        $writer->save('write.xlsx');

    }
}