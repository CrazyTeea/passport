<?php


namespace app\jobs;

use app\models\Objects;
use app\models\Organizations;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class statisticJob extends BaseObject implements JobInterface
{
    public $mail;
    public $where;

    /**
     * @inheritDoc
     */
    public function execute($queue)
    {
        ini_set('max_execution_time', 0);

        $where = $this->where;

        $orgs = Organizations::find()
            ->where(['system_status'=>1]);

        if (isset($get['kont']) and $get['kont'] == 1) {
            $orgs = $orgs->joinWith('usersInfo', true, 'join');
        }
        if (isset($get['zap']) and $get['zap'] == 1) {
            $where = array_merge($where, ['active' => 1]);
        }
        if (isset($get['docs']) and $get['docs'] == 1) {
            $orgs = $orgs->joinWith('orgDocs');
            $having = ['>', 'count(org_docs.id)', 0];
        }

        $orgs = $orgs->andFilterWhere($where)->having($having ?? [])->groupBy('organizations.id');
        $orgs_id = (clone $orgs)->select(['organizations.id'])->column();

        $orgs = $orgs->all();

        $r_objs = Objects::getRealEstateObjects($orgs_id);

        ini_set('memory_limit', '-1');

        $html = Yii::$app->view->renderFile(
            '@app/views/app/export/_stat.php',
            compact('orgs', 'r_objs')
        );

        $reader = new Html();

        $html = $reader->loadFromString($html);

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'width'=>108
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $html
            ->getActiveSheet()
            ->getStyle('A1:K1')
            ->applyFromArray($styleArray)
            ->getAlignment()
            ->setWrapText(true);

        $html
            ->getActiveSheet()
            ->getColumnDimension('B')
            ->setWidth(50);
        $html
            ->getActiveSheet()
            ->getColumnDimension('C')
            ->setWidth(18.1);
        $html
            ->getActiveSheet()
            ->getColumnDimension('D')
            ->setWidth(24);
        $html
            ->getActiveSheet()
            ->getColumnDimension('E')
            ->setWidth(50);
        $html
            ->getActiveSheet()
            ->getColumnDimension('F')
            ->setWidth(17);
        $html
            ->getActiveSheet()
            ->getColumnDimension('G')
            ->setWidth(17);
        $html
            ->getActiveSheet()
            ->getColumnDimension('H')
            ->setWidth(17);
        $html
            ->getActiveSheet()
            ->getColumnDimension('I')
            ->setWidth(17);
        $html
            ->getActiveSheet()
            ->getColumnDimension('J')
            ->setWidth(17);
        $html
            ->getActiveSheet()
            ->getColumnDimension('K')
            ->setWidth(17);


        $writer = IOFactory::createWriter($html, 'Xlsx');

        $path = Yii::getAlias('@webroot') . '/uploads/Статистика ПЖФ.xlsx';

        $writer->save($path);

        Yii::$app->queue->push(new fileMail(
            [
                'file'=>$path,
                'subject'=>'Статистика ПЖФ',
                'mail'=>$this->mail,
                'message'=>'Статистика ПЖФ'
            ]
        ));
    }
}
