<?php


namespace app\jobs;

use app\helpers\MyReader;
use app\models\Countries;
use app\models\Objects;
use app\models\Organizations;
use app\models\OrgInfo;
use app\models\OrgLiving;
use app\models\OrgLivingStudents;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;

class ExportJob extends \yii\base\BaseObject implements \yii\queue\JobInterface
{
    public $where;
    public $pages;
    public $mail;
    public $id_org;
    public $fileName;

    private function generatorOrg(array $orgs)
    {
        foreach ($orgs as $org) {
            yield $org;
        }
    }

    private function cntArea(array $objs): array
    {
        $objs = $this->generatorOrg($objs);

        $arr = [
            'zil' => [
                'area_zan_obuch' => 0,
                'area_in_kat_nan' => 0,
                'svobod' => 0,
                'ne_isp' => 0,
                'tkr' => 0,
                'nas' => 0,
                'np' => 0,
                'odp' => 0,
                'zpo' => 0,
                'cnt_mest_pl_na_odn' => 0,
                'cnt_mest_obsh_na_odn' => 0,
                //'ne_isp'=>0,
            ],
            'nezil' => [
                'obsh' => 0,
                'tkr' => 0,
                'nas' => 0,
                'np' => 0,
                'nz' => 0
            ]
        ];

        foreach ($objs as $item) {
            if (!($item->area and $item->ustav_dey)) {
                continue;
            }
            if ($item->area and !$item->ustav_dey) {
                $arr['nezil']['nz'] += (
                    $item->area->zan_obuch +
                    $item->area->zan_inie +
                    $item->area->svobod +
                    $item->area->neisp +
                    $item->area->zhil_tkr +
                    $item->area->nzhil_tkr +
                    $item->area->zhil_nas +
                    $item->area->nzhil_nas +
                    $item->area->zhil_np +
                    $item->area->nzhil_np
                    + (
                        $item->area->punkt_pit + $item->area->pom_dlya_uch + $item->area->pom_dlya_med +
                        $item->area->pom_dlya_sport + $item->area->pom_dlya_soc + $item->area->pom_dlya_kult +
                        $item->area->in_nezh_plosh
                    )
                );
            }

            $arr['zil']['area_zan_obuch'] += $item->area->zan_obuch;
            $arr['zil']['area_in_kat_nan'] += $item->area->zan_inie;
            $arr['zil']['svobod'] += $item->area->svobod;
            $arr['zil']['ne_isp'] += $item->area->neisp;
            $arr['zil']['tkr'] += $item->area->zhil_tkr;
            $arr['zil']['nas'] += $item->area->zhil_nas;
            $arr['zil']['np'] += $item->area->zhil_np;

            $arr['zil']['odp'] += $item->area->zhil_nas;
            $arr['zil']['zpo'] += $item->area->zhil_np;

            $arr['nezil']['tkr'] += $item->area->nzhil_tkr;
            $arr['nezil']['nas'] += $item->area->nzhil_nas;
            $arr['nezil']['np'] += $item->area->nzhil_np;


            $temp =
                $item->area->cnt_mest_zan_obuch +
                $item->area->cnt_mest_zan_in_obuch +
                $item->area->cnt_svobod_mest;
            $temp = $temp > 0 ? $temp : 1;

            $n = $item->area->punkt_pit + $item->area->pom_dlya_uch + $item->area->pom_dlya_med +
                $item->area->pom_dlya_sport + $item->area->pom_dlya_soc + $item->area->pom_dlya_kult +
                $item->area->in_nezh_plosh;

            $arr['zil']['cnt_mest_pl_na_odn'] += (
                (
                    $item->area->zan_obuch +
                    $item->area->zan_inie +
                    $item->area->svobod
                ) / $temp
            );
            $arr['zil']['cnt_mest_obsh_na_odn'] += (
                (
                    $item->area->zan_obuch +
                    $item->area->zan_inie +
                    $item->area->svobod + $n
                ) / $temp
            );

            $arr['nezil']['obsh'] += (
                $item->area->punkt_pit +
                $item->area->pom_dlya_uch +
                $item->area->pom_dlya_med +
                $item->area->pom_dlya_sport +
                $item->area->pom_dlya_soc +
                $item->area->pom_dlya_kult +
                $item->area->in_nezh_plosh
            );
        }
        return $arr;
    }

    private function exportAll($rows, $orgs, $pages, $where): Spreadsheet
    {
        $arr = [];
        foreach ($this->generatorOrg($rows) as $row) {
            $arr[$row['id_org']][$row['invalid']][$row['budjet_type']][$row['type']][] = [
                'in' => $row['in'] ?? 0,
                'ord' => $row['ord'] ?? 0,
                'asp' => $row['asp'] ?? 0,
                'mag' => $row['mag'] ?? 0,
                'spec' => $row['spec'] ?? 0,
                'bak' => $row['bak'] ?? 0,
                'spo' => $row['spo'] ?? 0,
                'name' => Countries::findOne(['code' => $row['name']])->ru ?? ''
            ];
        }


        $indexes = OrgLivingStudents::getIndexes($where['organizations.id'] ?? []);

        if (isset($where['organizations.id'])) {
            $w = ['id_org' => $where['organizations.id']];
        }

        $contingers = OrgLivingStudents::find()->where(['is not', 'name', null])
            ->andWhere($w ?? [])->with(['org', 'country'])->all();

        $sum_attrs = [
            'spo',
            'bak',
            'spec',
            'mag',
            'asp',
            'ord',
            'in'
        ];

        $filter = new MyReader();
        $reader = IOFactory::createReader('Xlsx');

        $reader->setReadFilter($filter);

        $spreadsheet = $reader->load(Yii::getAlias('@webroot') . '/templates/template.xlsx');

        foreach ($this->generatorOrg($orgs) as $org_index => $org) {
            $cell_pos = $org_index + 2;


            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue("A{$cell_pos}", $org->id);
            $sheet->setCellValue("B{$cell_pos}", $org->full_name);
            $sheet->setCellValue("C{$cell_pos}", $org->short_name);
            $sheet->setCellValue("D{$cell_pos}", $org->founder->founder);
            $sheet->setCellValue("E{$cell_pos}", $org->region ? $org->region->region : '');
            $sheet->setCellValue(
                "F{$cell_pos}",
                $org->last_updated_at != '0000-00-00 00:00:00' ? $org->last_updated_at : 'Не приступали'
            );

            if (isset($org->info[0])) {
                $sheet->setCellValue("G{$cell_pos}", $v1 = $org->info[0]->s_f_b_spo);
                $sheet->setCellValue("H{$cell_pos}", $v2 = $org->info[0]->s_f_b_bak);
                $sheet->setCellValue("I{$cell_pos}", $v3 = $org->info[0]->s_f_b_spec);
                $sheet->setCellValue("J{$cell_pos}", $v4 = $org->info[0]->s_f_b_mag);
                $sheet->setCellValue("K{$cell_pos}", $v5 = $org->info[0]->s_f_b_asp);
                $sheet->setCellValue("L{$cell_pos}", $v6 = $org->info[0]->s_f_b_ord);
                $sheet->setCellValue("M{$cell_pos}", $v7 = $org->info[0]->s_f_b_in);
                $sheet->setCellValue("N{$cell_pos}", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);


                $sheet->setCellValue("O{$cell_pos}", $v1 = $org->info[0]->s_b_s_spo);
                $sheet->setCellValue("P{$cell_pos}", $v2 = $org->info[0]->s_b_s_bak);
                $sheet->setCellValue("Q{$cell_pos}", $v3 = $org->info[0]->s_b_s_spec);
                $sheet->setCellValue("R{$cell_pos}", $v4 = $org->info[0]->s_b_s_mag);
                $sheet->setCellValue("S{$cell_pos}", $v5 = $org->info[0]->s_b_s_asp);
                $sheet->setCellValue("T{$cell_pos}", $v6 = $org->info[0]->s_b_s_ord);
                $sheet->setCellValue("U{$cell_pos}", $v7 = $org->info[0]->s_b_s_in);
                $sheet->setCellValue("V{$cell_pos}", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);


                $sheet->setCellValue("W{$cell_pos}", $v1 = $org->info[0]->s_m_b_spo);
                $sheet->setCellValue("X{$cell_pos}", $v2 = $org->info[0]->s_m_b_bak);
                $sheet->setCellValue("Y{$cell_pos}", $v3 = $org->info[0]->s_m_b_spec);
                $sheet->setCellValue("Z{$cell_pos}", $v4 = $org->info[0]->s_m_b_mag);
                $sheet->setCellValue("AA{$cell_pos}", $v5 = $org->info[0]->s_m_b_asp);
                $sheet->setCellValue("AB{$cell_pos}", $v6 = $org->info[0]->s_m_b_ord);
                $sheet->setCellValue("AC{$cell_pos}", $v7 = $org->info[0]->s_m_b_in);
                $sheet->setCellValue("AD{$cell_pos}", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);


                $sheet->setCellValue("AE{$cell_pos}", $v1 = $org->info[0]->s_p_u_spo);
                $sheet->setCellValue("AF{$cell_pos}", $v2 = $org->info[0]->s_p_u_bak);
                $sheet->setCellValue("AG{$cell_pos}", $v3 = $org->info[0]->s_p_u_spec);
                $sheet->setCellValue("AH{$cell_pos}", $v4 = $org->info[0]->s_p_u_mag);
                $sheet->setCellValue("AI{$cell_pos}", $v5 = $org->info[0]->s_p_u_asp);
                $sheet->setCellValue("AJ{$cell_pos}", $v6 = $org->info[0]->s_p_u_ord);
                $sheet->setCellValue("AK{$cell_pos}", $v7 = $org->info[0]->s_p_u_in);
                $sheet->setCellValue("AL{$cell_pos}", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);
                $sheet->setCellValue(
                    "AM{$cell_pos}",
                    $v1 = $org->info[0]->s_f_b_spo +
                        $org->info[0]->s_b_s_spo +
                        $org->info[0]->s_m_b_spo +
                        $org->info[0]->s_p_u_spo
                );
                $sheet->setCellValue(
                    "AN{$cell_pos}",
                    $v2 = $org->info[0]->s_f_b_bak +
                        $org->info[0]->s_b_s_bak +
                        $org->info[0]->s_m_b_bak +
                        $org->info[0]->s_p_u_bak
                );
                $sheet->setCellValue(
                    "AO{$cell_pos}",
                    $v3 = $org->info[0]->s_f_b_spec +
                        $org->info[0]->s_b_s_spec +
                        $org->info[0]->s_m_b_spec +
                        $org->info[0]->s_p_u_spec
                );
                $sheet->setCellValue(
                    "AP{$cell_pos}",
                    $v4 = $org->info[0]->s_f_b_mag +
                        $org->info[0]->s_b_s_mag +
                        $org->info[0]->s_m_b_mag +
                        $org->info[0]->s_p_u_mag
                );
                $sheet->setCellValue(
                    "AQ{$cell_pos}",
                    $v5 = $org->info[0]->s_f_b_asp +
                        $org->info[0]->s_b_s_asp +
                        $org->info[0]->s_m_b_asp +
                        $org->info[0]->s_p_u_asp
                );
                $sheet->setCellValue(
                    "AR{$cell_pos}",
                    $v6 = $org->info[0]->s_f_b_ord +
                        $org->info[0]->s_b_s_ord +
                        $org->info[0]->s_m_b_ord +
                        $org->info[0]->s_p_u_ord
                );
                $sheet->setCellValue(
                    "AS{$cell_pos}",
                    $v7 = $org->info[0]->s_f_b_in +
                        $org->info[0]->s_b_s_in +
                        $org->info[0]->s_m_b_in +
                        $org->info[0]->s_p_u_in
                );
                $sheet->setCellValue(
                    "AT{$cell_pos}",
                    $v1 = $v1 + $v2 + $v3 + $v4 + $v5 + $v6 + $v7
                );
            }
            if (isset($org->info[1])) {
                $sheet->setCellValue("AU{$cell_pos}", $v1 = $org->info[1]->s_f_b_spo);
                $sheet->setCellValue("AV{$cell_pos}", $v2 = $org->info[1]->s_f_b_bak);
                $sheet->setCellValue("AW{$cell_pos}", $v3 = $org->info[1]->s_f_b_spec);
                $sheet->setCellValue("AX{$cell_pos}", $v4 = $org->info[1]->s_f_b_mag);
                $sheet->setCellValue("AY{$cell_pos}", $v5 = $org->info[1]->s_f_b_asp);
                $sheet->setCellValue("AZ{$cell_pos}", $v6 = $org->info[1]->s_f_b_ord);
                $sheet->setCellValue("BA{$cell_pos}", $v7 = $org->info[1]->s_f_b_in);
                $sheet->setCellValue("BB{$cell_pos}", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);

                $sheet->setCellValue("BC{$cell_pos}", $v1 = $org->info[1]->s_b_s_spo);
                $sheet->setCellValue("BD{$cell_pos}", $v2 = $org->info[1]->s_b_s_bak);
                $sheet->setCellValue("BE{$cell_pos}", $v3 = $org->info[1]->s_b_s_spec);
                $sheet->setCellValue("BF{$cell_pos}", $v4 = $org->info[1]->s_b_s_mag);
                $sheet->setCellValue("BG{$cell_pos}", $v5 = $org->info[1]->s_b_s_asp);
                $sheet->setCellValue("BH{$cell_pos}", $v6 = $org->info[1]->s_b_s_ord);
                $sheet->setCellValue("BI{$cell_pos}", $v7 = $org->info[1]->s_b_s_in);
                $sheet->setCellValue("BJ{$cell_pos}", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);


                $sheet->setCellValue("BK{$cell_pos}", $v1 = $org->info[1]->s_m_b_spo);
                $sheet->setCellValue("BL{$cell_pos}", $v2 = $org->info[1]->s_m_b_bak);
                $sheet->setCellValue("BM{$cell_pos}", $v3 = $org->info[1]->s_m_b_spec);
                $sheet->setCellValue("BN{$cell_pos}", $v4 = $org->info[1]->s_m_b_mag);
                $sheet->setCellValue("BO{$cell_pos}", $v5 = $org->info[1]->s_m_b_asp);
                $sheet->setCellValue("BP{$cell_pos}", $v6 = $org->info[1]->s_m_b_ord);
                $sheet->setCellValue("BQ{$cell_pos}", $v7 = $org->info[1]->s_m_b_in);
                $sheet->setCellValue("BR{$cell_pos}", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);


                $sheet->setCellValue("BS{$cell_pos}", $v1 = $org->info[1]->s_p_u_spo);
                $sheet->setCellValue("BT{$cell_pos}", $v2 = $org->info[1]->s_p_u_bak);
                $sheet->setCellValue("BU{$cell_pos}", $v3 = $org->info[1]->s_p_u_spec);
                $sheet->setCellValue("BV{$cell_pos}", $v4 = $org->info[1]->s_p_u_mag);
                $sheet->setCellValue("BW{$cell_pos}", $v5 = $org->info[1]->s_p_u_asp);
                $sheet->setCellValue("BX{$cell_pos}", $v6 = $org->info[1]->s_p_u_ord);
                $sheet->setCellValue("BY{$cell_pos}", $v7 = $org->info[1]->s_p_u_in);
                $sheet->setCellValue("BZ{$cell_pos}", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);


                $sheet->setCellValue(
                    "CA{$cell_pos}",
                    $org->info[1]->s_f_b_spo +
                    $org->info[1]->s_b_s_spo +
                    $org->info[1]->s_m_b_spo +
                    $org->info[1]->s_p_u_spo
                );
                $sheet->setCellValue(
                    "CB{$cell_pos}",
                    $org->info[1]->s_f_b_bak +
                    $org->info[1]->s_b_s_bak +
                    $org->info[1]->s_m_b_bak +
                    $org->info[1]->s_p_u_bak
                );
                $sheet->setCellValue(
                    "CC{$cell_pos}",
                    $org->info[1]->s_f_b_spec +
                    $org->info[1]->s_b_s_spec +
                    $org->info[1]->s_m_b_spec +
                    $org->info[1]->s_p_u_spec
                );
                $sheet->setCellValue(
                    "CD{$cell_pos}",
                    $org->info[1]->s_f_b_mag +
                    $org->info[1]->s_b_s_mag +
                    $org->info[1]->s_m_b_mag +
                    $org->info[1]->s_p_u_mag
                );
                $sheet->setCellValue(
                    "CE{$cell_pos}",
                    $org->info[1]->s_f_b_asp +
                    $org->info[1]->s_b_s_asp +
                    $org->info[1]->s_m_b_asp +
                    $org->info[1]->s_p_u_asp
                );
                $sheet->setCellValue(
                    "CF{$cell_pos}",
                    $org->info[1]->s_f_b_ord +
                    $org->info[1]->s_b_s_ord +
                    $org->info[1]->s_m_b_ord +
                    $org->info[1]->s_p_u_ord
                );
                $sheet->setCellValue(
                    "CG{$cell_pos}",
                    $org->info[1]->s_f_b_in +
                    $org->info[1]->s_b_s_in +
                    $org->info[1]->s_m_b_in +
                    $org->info[1]->s_p_u_in
                );
                $sheet->setCellValue(
                    "CH{$cell_pos}",
                    $v2 = $org->info[1]->s_f_b_spo +
                        $org->info[1]->s_b_s_spo +
                        $org->info[1]->s_m_b_spo +
                        $org->info[1]->s_p_u_spo +
                        $org->info[1]->s_f_b_bak +
                        $org->info[1]->s_b_s_bak +
                        $org->info[1]->s_m_b_bak +
                        $org->info[1]->s_p_u_bak +
                        $org->info[1]->s_f_b_spec +
                        $org->info[1]->s_b_s_spec +
                        $org->info[1]->s_m_b_spec +
                        $org->info[1]->s_p_u_spec +
                        $org->info[1]->s_f_b_mag +
                        $org->info[1]->s_b_s_mag +
                        $org->info[1]->s_m_b_mag +
                        $org->info[1]->s_p_u_mag +
                        $org->info[1]->s_f_b_asp +
                        $org->info[1]->s_b_s_asp +
                        $org->info[1]->s_m_b_asp +
                        $org->info[1]->s_p_u_asp +
                        $org->info[1]->s_f_b_ord +
                        $org->info[1]->s_b_s_ord +
                        $org->info[1]->s_m_b_ord +
                        $org->info[1]->s_p_u_ord +
                        $org->info[1]->s_f_b_in +
                        $org->info[1]->s_b_s_in +
                        $org->info[1]->s_m_b_in +
                        $org->info[1]->s_p_u_in
                );
                $sheet->setCellValue("CI{$cell_pos}", $v1 + $v2);
            }

            $cnt = $this->cntArea($org->objs);

            $sheet->setCellValue("CI{$cell_pos}", $cnt['zil']['area_zan_obuch']);
            $sheet->setCellValue("CJ{$cell_pos}", $cnt['zil']['area_in_kat_nan']);
            $sheet->setCellValue("CK{$cell_pos}", $cnt['zil']['svobod']);
            $sheet->setCellValue("CL{$cell_pos}", $cnt['zil']['ne_isp']);
            $sheet->setCellValue(
                "CM{$cell_pos}",
                $cnt['zil']['area_zan_obuch'] +
                $cnt['zil']['area_in_kat_nan'] +
                $cnt['zil']['svobod'] +
                $cnt['zil']['ne_isp']
            );
            $sheet->setCellValue("CN{$cell_pos}", $cnt['nezil']['obsh']);
            $sheet->setCellValue(
                "CO{$cell_pos}",
                $cnt['nezil']['obsh'] +
                $cnt['zil']['area_zan_obuch'] +
                $cnt['zil']['area_in_kat_nan'] +
                $cnt['zil']['svobod'] +
                $cnt['zil']['ne_isp']
            );
            $sheet->setCellValue("CP{$cell_pos}", $cnt['zil']['tkr']);
            $sheet->setCellValue("CQ{$cell_pos}", $cnt['zil']['nas']);
            $sheet->setCellValue("CR{$cell_pos}", $cnt['zil']['np']);

            $sheet->setCellValue("CS{$cell_pos}", $cnt['nezil']['tkr']);
            $sheet->setCellValue("CT{$cell_pos}", $cnt['nezil']['nas']);
            $sheet->setCellValue("CU{$cell_pos}", $cnt['nezil']['np']);

            $sheet->setCellValue("CV{$cell_pos}", $cnt['zil']['tkr'] + $cnt['nezil']['tkr']);
            $sheet->setCellValue("CW{$cell_pos}", $cnt['zil']['nas'] + $cnt['nezil']['nas']);
            $sheet->setCellValue("CX{$cell_pos}", $cnt['zil']['np'] + $cnt['nezil']['np']);
            $sheet->setCellValue(
                "CY{$cell_pos}",
                $cnt['zil']['nas'] +
                $cnt['nezil']['nas'] +
                $cnt['zil']['np'] +
                $cnt['nezil']['np']
            );


            $sheet->setCellValue("CZ{$cell_pos}", $cnt['zil']['cnt_mest_pl_na_odn']);
            $sheet->setCellValue("DA{$cell_pos}", $cnt['zil']['cnt_mest_obsh_na_odn']);
            $sheet->setCellValue("DB{$cell_pos}", $cnt['nezil']['nz']);

            $sheet->setCellValue("DC{$cell_pos}", $v1 = $org->area->m2_spo ?? 0);
            $sheet->setCellValue("DD{$cell_pos}", $v2 = $org->area->m2_vis ?? 0);
            $sheet->setCellValue("DE{$cell_pos}", $v7 = $org->area->m2_in ?? 0);
            $sheet->setCellValue("DF{$cell_pos}", $v7 + $v1 + $v2);


            $sheet->setCellValue("DG{$cell_pos}", $v1 = $org->area->c6m2_spo ?? 0);
            $sheet->setCellValue("DH{$cell_pos}", $v2 = $org->area->c6m2_vis ?? 0);
            $sheet->setCellValue("DI{$cell_pos}", $v7 = $org->area->c6m2_in ?? 0);
            $sheet->setCellValue("DJ{$cell_pos}", $v7 + $v1 + $v2);

            $sheet->setCellValue("DK{$cell_pos}", $v1 = ($org->area->c6m2_spo ?? 0) + ($org->area->m2_spo ?? 0));
            $sheet->setCellValue("DL{$cell_pos}", $v2 = ($org->area->c6m2_vis ?? 0) + ($org->area->m2_vis ?? 0));
            $sheet->setCellValue("DM{$cell_pos}", $v7 = ($org->area->c6m2_in ?? 0) + ($org->area->m2_in ?? 0));
            $sheet->setCellValue("DN{$cell_pos}", $v7 + $v1 + $v2);
            $sheet->setCellValue("DO{$cell_pos}", $v1 = array_reduce($org->objs, function ($a, $b) {
                return $a + ($b->ustav_dey ? $b->area->cnt_mest_zan_in_obuch ?? 0 : 0);
            }, 0));
            $sheet->setCellValue("DP{$cell_pos}", $v2 = array_reduce($org->objs, function ($a, $b) {
                return $a + ($b->ustav_dey ? $b->area->cnt_svobod_mest ?? 0 : 0);
            }, 0));
            $sheet->setCellValue("DQ{$cell_pos}", $v3 = array_reduce($org->objs, function ($a, $b) {
                return $a + ($b->ustav_dey ? $b->area->cnt_neisp_mest ?? 0 : 0);
            }, 0));
            $sheet->setCellValue("DR{$cell_pos}", $v11 = $v1 + $v2 + $v3);
            $sheet->setCellValue("DS{$cell_pos}", $v12 = $v11 + $v1 + $v2 + $v3);
            $sheet->setCellValue("DT{$cell_pos}", $v11 + $v12);
            $sheet->setCellValue("DU{$cell_pos}", array_reduce($org->objs, function ($a, $b) {
                return $a + ($b->ustav_dey ? $b->area->cnt_mest_inv ?? 0 : 0);
            }, 0));
            $sheet->setCellValue("DV{$cell_pos}", $org->area->area_cnt_nuzhd_zhil ?? 0);
            $sheet->setCellValue("DW{$cell_pos}", $org->area->area_cnt_prozh_u_drugih ?? 0);
            $sheet->setCellValue("DX{$cell_pos}", $v1 = array_reduce($org->objs, function ($a, $b) {
                return $a + ($b->ustav_dey ? $b->area->cnt_mest_vozm_neisp_mest ?? 0 : 0);
            }, 0));
            $sheet->setCellValue("DY{$cell_pos}", $v2 = array_reduce($org->objs, function ($a, $b) {
                return $a + ($b->ustav_dey ? $b->area->cnt_mest_vozm_neprig_mest ?? 0 : 0);
            }, 0));
            $sheet->setCellValue("DZ{$cell_pos}", $v1 + $v2);
            $sheet->setCellValue("EA{$cell_pos}", $org->covid_var1 ? 'Да' : 'Нет');
            $sheet->setCellValue("EB{$cell_pos}", $org->covid_var2 ?? '-');
            $sheet->setCellValue("EC{$cell_pos}", $org->covid_var3 ?? 0);
            $sheet->setCellValue("ED{$cell_pos}", $org->covid_var4 ?? 0);
            $sheet->setCellValue("EE{$cell_pos}", $org->covid_var5 ?? 0);

            $spreadsheet->setActiveSheetIndex(1);
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue("A{$cell_pos}", $org->id);
            $sheet->setCellValue("B{$cell_pos}", $org->full_name);
            $sheet->setCellValue("C{$cell_pos}", $org->short_name);
            $sheet->setCellValue("D{$cell_pos}", $org->founder->founder);
            $sheet->setCellValue("E{$cell_pos}", $org->region ? $org->region->region : '');
            $sheet->setCellValue("F{$cell_pos}", $org->updated_at);


            $n = 0;
            $budjet_type = 0;


            $sums = [
                'rf_och' => 0,
                'in_och' => 0,
                'rf_zaoch' => 0,
                'in_zaoch' => 0,
                'rf_ochzaoch' => 0,
                'in_ochzaoch' => 0,
            ];

            $g = 0;

            for ($i = 9; ; $i += 7) {
                if ($budjet_type > 3) {
                    $budjet_type = 0;
                }

                $items = ArrayHelper::getValue($arr, "{$org->id}.0.{$budjet_type}.rf_och", []);
                $sheet->setCellValue(
                    Coordinate::stringFromColumnIndex($i) . "{$cell_pos}",
                    $v1 = ArrayHelper::getValue($items, "0.{$sum_attrs[$n]}", 0)
                );
                $items = ArrayHelper::getValue($arr, "{$org->id}.0.{$budjet_type}.in_och", []);


                $attr = $sum_attrs[$n];


                $sheet->setCellValue(
                    Coordinate::stringFromColumnIndex($i + 1) . "{$cell_pos}",
                    $v2 = array_reduce($items, function ($a, $b) use ($attr) {
                        return $a + $b[$attr];
                    }, 0)
                );
                $items = ArrayHelper::getValue($arr, "{$org->id}.0.{$budjet_type}.rf_zaoch", []);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 2) . "{$cell_pos}", $v3 = ArrayHelper::getValue($items, "0.{$sum_attrs[$n]}", 0));

                $items = ArrayHelper::getValue($arr, "{$org->id}.0.{$budjet_type}.in_zaoch", []);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 3) . "{$cell_pos}", $v4 = array_reduce($items, function ($a, $b) use ($attr) {
                    return $a + $b[$attr];
                }, 0));

                $items = ArrayHelper::getValue($arr, "{$org->id}.0.{$budjet_type}.rf_ochzaoch", []);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 4) . "{$cell_pos}", $v5 = ArrayHelper::getValue($items, "0.{$sum_attrs[$n]}", 0));

                $items = ArrayHelper::getValue($arr, "{$org->id}.0.{$budjet_type}.in_ochzaoch", []);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 5) . "{$cell_pos}", $v6 = array_reduce($items, function ($a, $b) use ($attr) {
                    return $a + $b[$attr];
                }, 0));

                $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 6) . "{$cell_pos}", $v1 + $v2 + $v3 + $v4 + $v5 + $v6);

                $sums['rf_och'] += $v1;
                $sums['in_och'] += $v2;
                $sums['rf_zaoch'] += $v3;
                $sums['in_zaoch'] += $v4;
                $sums['rf_ochzaoch'] += $v5;
                $sums['in_ochzaoch'] += $v6;


                $n++;
                if ($n > 6) {
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 7) . "{$cell_pos}", ArrayHelper::getValue($indexes, "{$org->id}.{$budjet_type}.names", ''));
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 8) . "{$cell_pos}", $sums['rf_och']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 9) . "{$cell_pos}", $sums['in_och']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 10) . "{$cell_pos}", $sums['rf_zaoch']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 11) . "{$cell_pos}", $sums['in_zaoch']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 12) . "{$cell_pos}", $sums['rf_ochzaoch']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 13) . "{$cell_pos}", $sums['in_ochzaoch']);

                    $val = array_reduce($sums, function ($a, $b) {
                        return $a + $b;
                    }, 0);

                    $g += $val;

                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 14) . "{$cell_pos}", $val);

                    if (Coordinate::stringFromColumnIndex($i + 7) == 'HU') {
                        break;
                    }

                    $sums = [
                        'rf_och' => 0,
                        'in_och' => 0,
                        'rf_zaoch' => 0,
                        'in_zaoch' => 0,
                        'rf_ochzaoch' => 0,
                        'in_ochzaoch' => 0,
                    ];
                    $i += 8;
                    $budjet_type++;
                    $n = 0;
                }
            }


            $spreadsheet->setActiveSheetIndex(1);
            $sheet = $spreadsheet->getActiveSheet();
            $sums = [
                'rf_och' => 0,
                'in_och' => 0,
                'rf_zaoch' => 0,
                'in_zaoch' => 0,
                'rf_ochzaoch' => 0,
                'in_ochzaoch' => 0,
            ];
            $n = 0;
            $budjet_type = 0;

            for ($i = 237; ; $i += 7) {
                if ($budjet_type > 3) {
                    $budjet_type = 0;
                }


                $sheet->setCellValue(Coordinate::stringFromColumnIndex($i) . "{$cell_pos}", $v1 = ArrayHelper::getValue($arr, "{$org->id}.1.{$budjet_type}.rf_och.{$sum_attrs[$n]}", 0));
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 1) . "{$cell_pos}", $v2 = ArrayHelper::getValue($arr, "{$org->id}.1.{$budjet_type}.in_och.{$sum_attrs[$n]}", 0));
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 2) . "{$cell_pos}", $v3 = ArrayHelper::getValue($arr, "{$org->id}.1.{$budjet_type}.rf_zaoch.{$sum_attrs[$n]}", 0));
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 3) . "{$cell_pos}", $v4 = ArrayHelper::getValue($arr, "{$org->id}.1.{$budjet_type}.in_zaoch.{$sum_attrs[$n]}", 0));
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 4) . "{$cell_pos}", $v5 = ArrayHelper::getValue($arr, "{$org->id}.1.{$budjet_type}.rf_ochzaoch.{$sum_attrs[$n]}", 0));
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 5) . "{$cell_pos}", $v6 = ArrayHelper::getValue($arr, "{$org->id}.1.{$budjet_type}.in_ochzaoch.{$sum_attrs[$n]}", 0));
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 6) . "{$cell_pos}", $v1 + $v2 + $v3 + $v4 + $v5 + $v6);


                $sums['rf_och'] += $v1;
                $sums['in_och'] += $v2;
                $sums['rf_zaoch'] += $v3;
                $sums['in_zaoch'] += $v4;
                $sums['rf_ochzaoch'] += $v5;
                $sums['in_ochzaoch'] += $v6;

                $n++;
                if ($n > 6) {
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 7) . "{$cell_pos}", $sums['rf_och']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 8) . "{$cell_pos}", $sums['in_och']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 9) . "{$cell_pos}", $sums['rf_zaoch']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 10) . "{$cell_pos}", $sums['in_zaoch']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 11) . "{$cell_pos}", $sums['rf_ochzaoch']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 12) . "{$cell_pos}", $sums['in_ochzaoch']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 13) . "{$cell_pos}", array_reduce($sums, function ($a, $b) {
                        return $a + $b;
                    }, 0));

                    $sums = [
                        'rf_och' => 0,
                        'in_och' => 0,
                        'rf_zaoch' => 0,
                        'in_zaoch' => 0,
                        'rf_ochzaoch' => 0,
                        'in_ochzaoch' => 0,
                    ];


                    if (Coordinate::stringFromColumnIndex($i + 13) == 'QR') {
                        break;
                    }

                    $i += 7;
                    $budjet_type++;
                    $n = 0;
                }
            }
            $sheet->setCellValue("QS{$cell_pos}", $org->living->cnt_stug_step ?? 0);
            $sheet->setCellValue("QT{$cell_pos}", $v1 = $org->living->rab_p ?? 0);
            $sheet->setCellValue("QU{$cell_pos}", $v2 = $org->living->rab_s ?? 0);
            $sheet->setCellValue("QV{$cell_pos}", $v3 = $org->living->nauch_p ?? 0);
            $sheet->setCellValue("QW{$cell_pos}", $v4 = $org->living->nauch_s ?? 0);
            $sheet->setCellValue("QX{$cell_pos}", $v5 = $org->living->prof_p ?? 0);
            $sheet->setCellValue("QY{$cell_pos}", $v6 = $org->living->prof_s ?? 0);
            $sheet->setCellValue("QZ{$cell_pos}", $v7 = $org->living->in_p ?? 0);
            $sheet->setCellValue("RA{$cell_pos}", $v8 = $org->living->in_s ?? 0);
            $sheet->setCellValue("RB{$cell_pos}", $v11 = $v1 + $v3 + $v5 + $v7);
            $sheet->setCellValue("RC{$cell_pos}", $v12 = $v2 + $v4 + $v6 + $v8);
            $sheet->setCellValue("RD{$cell_pos}", $v11 + $v12);
            $sheet->setCellValue("RE{$cell_pos}", $f = $org->living->inie_pr ?? 0);
            $sheet->setCellValue("H{$cell_pos}", $g);
            $sheet->setCellValue("G{$cell_pos}", $g + $v11 + $v12 + $f);

        }

        $objs = Objects::find()->where(['system_status' => 1])
            ->andWhere(
                isset($where['organizations.id']) ?
                    ['id_org' => $where['organizations.id']] : []
            )->all();


        foreach ($objs as $obj_index => $obj) {
            if (in_array('5', $pages)) {
                $spreadsheet->setActiveSheetIndex(3);
                $sheet = $spreadsheet->getActiveSheet();
                $osn_isp = [
                    1 => 'Право оперативного управления',
                    3 => 'Договор аренды',
                    4 => 'Договор о безвоздмездом пользовании',
                    5 => 'Собственность',
                    9 => 'Иное'
                ];
                $flat_plan = [
                    'kor' => 'Коридорная',
                    'bloch' => 'Блочная',
                    'kvar' => 'Квартирная',
                    'gost' => 'Гостиничная'
                ];
                $flat_type = [
                    'odn' => 'Одноместный',
                    'dvuh' => 'Двухместный',
                    'treh' => 'Трёхместный и более',
                    'smesh' => 'Смешанный'
                ];
                $prib_type = [
                    'ind' => 'Индивидуальные (на комнату)',
                    'obsh' => 'Общедомовые',
                    'ots' => 'Отсутствуют',
                ];
                $rek = [
                    null => 'Не выбрано',
                    1 => 'Проводился/Запланирован',
                    0 => 'Не проводится'
                ];


                $obj_cel_pos = 2 + $obj_index;
                $sheet->setCellValue("A{$obj_cel_pos}", $obj->org->id);
                $sheet->setCellValue("B{$obj_cel_pos}", $obj->id);
                $sheet->setCellValue("C{$obj_cel_pos}", $obj->org->full_name);
                $sheet->setCellValue("D{$obj_cel_pos}", $obj->org->founder->founder);
                $sheet->setCellValue("E{$obj_cel_pos}", $obj->region ? $obj->region->region : '');
                $sheet->setCellValue("F{$obj_cel_pos}", $obj->updated_at);
                $sheet->setCellValue("G{$obj_cel_pos}", $obj->name);
                $sheet->setCellValue("H{$obj_cel_pos}", $obj->address);
                $sheet->setCellValue("I{$obj_cel_pos}", $obj->region ? $obj->region->region : '');
                $sheet->setCellValue("J{$obj_cel_pos}", $obj->kad_number);
                $sheet->setCellValue("k{$obj_cel_pos}", $obj->osn_isp ? $osn_isp[$obj->osn_isp] : 'Не выбрано');
                $sheet->setCellValue("L{$obj_cel_pos}", $obj->reg_zap);
                $sheet->setCellValue("M{$obj_cel_pos}", $obj->doc_number);
                $sheet->setCellValue("N{$obj_cel_pos}", $obj->flat_plan ? $flat_plan[$obj->flat_plan] : 'Не выбрано');
                $sheet->setCellValue("O{$obj_cel_pos}", $obj->flat_type ? $flat_type[$obj->flat_type] : 'Не выбрано');
                $sheet->setCellValue("P{$obj_cel_pos}", $obj->prib_type ? $prib_type[$obj->prib_type] : 'Не выбрано');
                $sheet->setCellValue("Q{$obj_cel_pos}", $obj->smet);
                $sheet->setCellValue("R{$obj_cel_pos}", $obj->year_cen);
                $sheet->setCellValue("S{$obj_cel_pos}", $obj->stroy_date_start ?? '-');
                $sheet->setCellValue("T{$obj_cel_pos}", $obj->stroy_date_end ?? '-');
                $sheet->setCellValue("U{$obj_cel_pos}", $obj->exp_date ?? '-');
                $sheet->setCellValue("V{$obj_cel_pos}", $v1 = $obj->money_faip);
                $sheet->setCellValue("W{$obj_cel_pos}", $v2 = $obj->money_bud_sub);
                $sheet->setCellValue("X{$obj_cel_pos}", $v3 = $obj->money_vneb);
                $sheet->setCellValue("Y{$obj_cel_pos}", $v1 + $v2 + $v3);
                $sheet->setCellValue("Z{$obj_cel_pos}", $rek[$obj->reconstruct]);
                $sheet->setCellValue("AA{$obj_cel_pos}", ($obj->reconstruct and $obj->date_start_reconstruct) ?
                    date('n, Y', strtotime($obj->date_start_reconstruct)) :
                    '-');
                $sheet->setCellValue("AB{$obj_cel_pos}", ($obj->reconstruct and $obj->date_end_reconstruct) ?
                    date('n, Y', strtotime($obj->date_end_reconstruct)) :
                    '-');
                $sheet->setCellValue("AC{$obj_cel_pos}", $v1 = $obj->rec_money_faip);
                $sheet->setCellValue("AD{$obj_cel_pos}", $v2 = $obj->rec_money_bud_sub);
                $sheet->setCellValue("AE{$obj_cel_pos}", $v3 = $obj->rec_money_vneb);
                $sheet->setCellValue("AF{$obj_cel_pos}", $v1 + $v2 + $v3);
                $sheet->setCellValue("AG{$obj_cel_pos}", $obj->ustav_dey ? 'Используется' : 'Не используется');
                $sheet->setCellValue("AH{$obj_cel_pos}", $obj->date_end_reconstruct);
                $sheet->setCellValue("AH{$obj_cel_pos}", $obj->reason);
                $sheet->setCellValue("AI{$obj_cel_pos}", $obj->uslovie);
                $sheet->setCellValue("AJ{$obj_cel_pos}", $obj->nevos_reason);
                $sheet->setCellValue("AK{$obj_cel_pos}", $obj->pandus);
                $sheet->setCellValue("AL{$obj_cel_pos}", $obj->mech_por);
                $sheet->setCellValue("AM{$obj_cel_pos}", $obj->sanusel);
                $sheet->setCellValue("AN{$obj_cel_pos}", $obj->signal);
                $sheet->setCellValue("AO{$obj_cel_pos}", $obj->pokr);
                $sheet->setCellValue("AP{$obj_cel_pos}", $obj->vives);
                $sheet->setCellValue("AQ{$obj_cel_pos}", $obj->wifi ? 'Да' : 'Нет');
                $sheet->setCellValue("AR{$obj_cel_pos}", $obj->min_per);
                $sheet->setCellValue("AS{$obj_cel_pos}", $obj->max_per);

                $sheet->setCellValue("AT{$obj_cel_pos}", $v1 = $obj->area->zan_obuch ?? 0);
                $sheet->setCellValue("AU{$obj_cel_pos}", $v2 = $obj->area->zan_inie ?? 0);
                $sheet->setCellValue("AV{$obj_cel_pos}", $v3 = $obj->area->svobod ?? 0);
                $sheet->setCellValue("AW{$obj_cel_pos}", $v4 = $obj->area->neisp ?? 0);
                $sheet->setCellValue("AX{$obj_cel_pos}", $v11 = $v1 + $v2 + $v3 + $v4);
                $sheet->setCellValue("AY{$obj_cel_pos}", $v1 = $obj->area->punkt_pit ?? 0);
                $sheet->setCellValue("AZ{$obj_cel_pos}", $v2 = $obj->area->pom_dlya_uch ?? 0);
                $sheet->setCellValue("BA{$obj_cel_pos}", $v3 = $obj->area->pom_dlya_med ?? 0);
                $sheet->setCellValue("BB{$obj_cel_pos}", $v4 = $obj->area->pom_dlya_sport ?? 0);
                $sheet->setCellValue("BC{$obj_cel_pos}", $v5 = $obj->area->pom_dlya_kult ?? 0);
                $sheet->setCellValue("BD{$obj_cel_pos}", $v6 = $obj->area->pom_dlya_soc ?? 0);
                $sheet->setCellValue("BE{$obj_cel_pos}", $v12 = $v1 + $v2 + $v3 + $v4 + $v5 + $v6);
                $sheet->setCellValue("BF{$obj_cel_pos}", $v7 = $obj->area->in_nezh_plosh ?? 0);
                $sheet->setCellValue("BG{$obj_cel_pos}", $v13 = $v1 + $v2 + $v3 + $v4 + $v5 + $v6 + $v7);
                $sheet->setCellValue("BH{$obj_cel_pos}", $v11 + $v13);
                $sheet->setCellValue("BI{$obj_cel_pos}", $obj->area->zhil_tkr ?? 0);
                $sheet->setCellValue("BJ{$obj_cel_pos}", $obj->area->zhil_nas ?? 0);
                $sheet->setCellValue("BK{$obj_cel_pos}", $obj->area->zhil_np ?? 0);
                $sheet->setCellValue("BL{$obj_cel_pos}", $obj->area->nzhil_tkr ?? 0);
                $sheet->setCellValue("BM{$obj_cel_pos}", $obj->area->nzhil_nas ?? 0);
                $sheet->setCellValue("BN{$obj_cel_pos}", $obj->area->nzhil_np ?? 0);
                $sheet->setCellValue("BO{$obj_cel_pos}", $v1 = ($obj->area->zhil_tkr ?? 0) + ($obj->area->nzhil_tkr ?? 0));
                $sheet->setCellValue("BP{$obj_cel_pos}", $v2 = ($obj->area->zhil_nas ?? 0) + ($obj->area->nzhil_nas ?? 0));
                $sheet->setCellValue("BQ{$obj_cel_pos}", $v3 = ($obj->area->zhil_np ?? 0) + ($obj->area->nzhil_np ?? 0));
                $sheet->setCellValue("BR{$obj_cel_pos}", $v2 + $v3);
                $sheet->setCellValue("BS{$obj_cel_pos}", $obj->area->aren ?? 0);
                $sheet->setCellValue("BT{$obj_cel_pos}", $obj->area->pbp ?? 0);
                $temp = ($obj->area->cnt_mest_zan_obuch ?? 0) + ($obj->area->cnt_mest_zan_in_obuch ?? 0);
                $temp = $temp ?: 1;

                $sheet->setCellValue("BU{$obj_cel_pos}", round($v11 / $temp, 2));
                $sheet->setCellValue("BV{$obj_cel_pos}", round(($v13 + $v11) / $temp, 2));

                $sheet->setCellValue("BW{$obj_cel_pos}", $v1 = $obj->area->cnt_mest_zan_obuch ?? 0);
                $sheet->setCellValue("BX{$obj_cel_pos}", $v2 = $obj->area->cnt_mest_zan_in_obuch ?? 0);
                $sheet->setCellValue("BY{$obj_cel_pos}", $v3 = $obj->area->cnt_svobod_mest ?? 0);
                $sheet->setCellValue("BZ{$obj_cel_pos}", $v4 = $obj->area->cnt_neisp_mest ?? 0);
                $sheet->setCellValue("CA{$obj_cel_pos}", $v1 + $v2 + $v3 + $v4);
                $sheet->setCellValue("CB{$obj_cel_pos}", $v5 = $obj->area->cnt_nepr_isp_mest ?? 0);
                $sheet->setCellValue("CC{$obj_cel_pos}", $v1 + $v2 + $v3 + $v4 + $v5);
                $sheet->setCellValue("CD{$obj_cel_pos}", $obj->area->cnt_mest_inv ?? 0);
                $sheet->setCellValue("CE{$obj_cel_pos}", $v1 = $obj->area->cnt_mest_vozm_neisp_mest ?? 0);
                $sheet->setCellValue("CF{$obj_cel_pos}", $v2 = $obj->area->cnt_mest_vozm_neprig_mest ?? 0);
                $sheet->setCellValue("CG{$obj_cel_pos}", $v1 + $v2);

                $sheet->setCellValue("CH{$obj_cel_pos}", $v1 = $obj->money->money_prozh_bez_dop ?? 0);
                $sheet->setCellValue("CI{$obj_cel_pos}", $v2 = $obj->money->money_prozh_dop ?? 0);
                $sheet->setCellValue("CJ{$obj_cel_pos}", $v3 = $obj->money->money_aren ?? 0);
                $sheet->setCellValue("CK{$obj_cel_pos}", $v4 = $obj->money->money_cel_sred ?? 0);
                $sheet->setCellValue("CL{$obj_cel_pos}", $v11 = $v1 + $v2 + $v3 + $v4);
                $sheet->setCellValue("CM{$obj_cel_pos}", $v1 = $obj->money->voda ?? 0);
                $sheet->setCellValue("CN{$obj_cel_pos}", $v2 = $obj->money->tep ?? 0);
                $sheet->setCellValue("CO{$obj_cel_pos}", $v3 = $obj->money->gaz ?? 0);
                $sheet->setCellValue("CP{$obj_cel_pos}", $v4 = $obj->money->elect ?? 0);
                $sheet->setCellValue("CQ{$obj_cel_pos}", $v12 = $v1 + $v2 + $v3 + $v4);
                $sheet->setCellValue("CR{$obj_cel_pos}", $v1 = $obj->money->uborka_ter ?? 0);
                $sheet->setCellValue("CS{$obj_cel_pos}", $v2 = $obj->money->uborka_pom ?? 0);
                $sheet->setCellValue("CT{$obj_cel_pos}", $v3 = $obj->money->tech_obs ?? 0);
                $sheet->setCellValue("CU{$obj_cel_pos}", $v4 = $obj->money->derivation ?? 0);
                $sheet->setCellValue("CV{$obj_cel_pos}", $v5 = $obj->money->tbo ?? 0);
                $sheet->setCellValue("CW{$obj_cel_pos}", $v6 = $obj->money->gos_prov ?? 0);
                $sheet->setCellValue("CX{$obj_cel_pos}", $v7 = $obj->money->attest ?? 0);
                $sheet->setCellValue("CY{$obj_cel_pos}", $v8 = $obj->money->prot_pozhar ?? 0);
                $sheet->setCellValue("CZ{$obj_cel_pos}", $v9 = $obj->money->inie_rash ?? 0);
                $sheet->setCellValue("DA{$obj_cel_pos}", $v13 = $v1 + $v2 + $v3 + $v4 + $v5 + $v6 + $v7 + $v8 + $v9);
                $sheet->setCellValue("DB{$obj_cel_pos}", $v1 = $obj->money->ohrana ?? 0);
                $sheet->setCellValue("DC{$obj_cel_pos}", $v2 = $obj->money->anti_ter ?? 0);
                $sheet->setCellValue("DD{$obj_cel_pos}", $v3 = $obj->money->inie_rash_ohrana ?? 0);
                $sheet->setCellValue("DE{$obj_cel_pos}", $v14 = $v1 + $v2 + $v3);
                $sheet->setCellValue("DF{$obj_cel_pos}", $v1 = $obj->money->nalog_imush ?? 0);
                $sheet->setCellValue("DG{$obj_cel_pos}", $v2 = $obj->money->zem_nalog ?? 0);
                $sheet->setCellValue("DH{$obj_cel_pos}", $v15 = $v1 + $v2);

                $sheet->setCellValue("DI{$obj_cel_pos}", $v1 = $obj->money->svaz ?? 0);
                $sheet->setCellValue("DJ{$obj_cel_pos}", $v2 = $obj->money->kap_rem ?? 0);

                $sheet->setCellValue("DK{$obj_cel_pos}", $v3 = $obj->money->tek_rem ?? 0);
                $sheet->setCellValue("DL{$obj_cel_pos}", $v4 = $obj->money->mygk_inv ?? 0);
                $sheet->setCellValue("DM{$obj_cel_pos}", $v5 = $obj->money->osn_sred ?? 0);
                $sheet->setCellValue("DN{$obj_cel_pos}", $v1 + $v2 + $v3 + $v4 + $v5 + $v15 + $v14 + $v13 + $v12);
                $sheet->setCellValue("DO{$obj_cel_pos}", $obj->money->opla_trud ?? 0);

                $sheet->setCellValue("DP{$obj_cel_pos}", $obj->tariff->u_t_b ?? 0);
                $sheet->setCellValue("DQ{$obj_cel_pos}", $obj->tariff->u_t_p ?? 0);
                $sheet->setCellValue("DR{$obj_cel_pos}", $obj->tariff->u_t_nr ?? 0);
                $sheet->setCellValue("DS{$obj_cel_pos}", $obj->tariff->u_t_do ?? 0);
                $sheet->setCellValue("DT{$obj_cel_pos}", $obj->tariff->u_t_in ?? 0);
                $sheet->setCellValue("DU{$obj_cel_pos}", $obj->tariff->k_u_b ?? 0);
                $sheet->setCellValue("DV{$obj_cel_pos}", $obj->tariff->k_u_p ?? 0);
                $sheet->setCellValue("DW{$obj_cel_pos}", $obj->tariff->k_u_nr ?? 0);
                $sheet->setCellValue("DX{$obj_cel_pos}", $obj->tariff->k_u_do ?? 0);
                $sheet->setCellValue("DY{$obj_cel_pos}", $obj->tariff->k_u_in ?? 0);
                $sheet->setCellValue("DZ{$obj_cel_pos}", $obj->tariff->p_p_b ?? 0);
                $sheet->setCellValue("EA{$obj_cel_pos}", $obj->tariff->p_p_p ?? 0);
                $sheet->setCellValue("EB{$obj_cel_pos}", $obj->tariff->p_p_nr ?? 0);
                $sheet->setCellValue("EC{$obj_cel_pos}", $obj->tariff->p_p_do ?? 0);
                $sheet->setCellValue("ED{$obj_cel_pos}", $obj->tariff->p_p_in ?? 0);
                $sheet->setCellValue("EE{$obj_cel_pos}", $obj->tariff->d_u_b ?? 0);
                $sheet->setCellValue("EF{$obj_cel_pos}", $obj->tariff->d_u_p ?? 0);
                $sheet->setCellValue("EG{$obj_cel_pos}", $obj->tariff->d_u_nr ?? 0);
                $sheet->setCellValue("EH{$obj_cel_pos}", $obj->tariff->d_u_do ?? 0);
                $sheet->setCellValue("EI{$obj_cel_pos}", $obj->tariff->d_u_in ?? 0);
            }
        }

        $budjet_types = [
            'За счёт федерального бюджета',
            'За счёт бюджета субъекта',
            'За счёт местного бюджета',
            'По договорам об оказании платных образовательных услуг',

        ];

        $arr = [];
        foreach ($contingers as $key => $item) {
            $arr[$key] = [
                'item' => $item,
                $item->type => $item
            ];
        }


        if (in_array('3', $pages)) {
            $spreadsheet->setActiveSheetIndex(2);
            $sheet = $spreadsheet->getActiveSheet();

            foreach ($this->generatorOrg($arr) as $key => $item) {
                $cell_pos = $key + 2;
                $sheet->setCellValue("A{$cell_pos}", $item['item']->id);
                $sheet->setCellValue("B{$cell_pos}", $item['item']->id_org);
                $sheet->setCellValue("C{$cell_pos}", $item['item']->org->full_name);
                $sheet->setCellValue("D{$cell_pos}", $item['item']->org->founder->founder);
                $sheet->setCellValue("E{$cell_pos}", $item['item']->org->region->region);
                $sheet->setCellValue("F{$cell_pos}", $item['item']->name);
                $sheet->setCellValue("G{$cell_pos}", $item['item']->country->ru);
                $sheet->setCellValue("H{$cell_pos}", $budjet_types[$item['item']->budjet_type]);
                $sheet->setCellValue("I{$cell_pos}", $v1 = ArrayHelper::getValue($item, 'in_och.spo', 0));
                $sheet->setCellValue("J{$cell_pos}", $v2 = ArrayHelper::getValue($item, 'in_zaoch.spo', 0));
                $sheet->setCellValue("K{$cell_pos}", $v3 = ArrayHelper::getValue($item, 'in_ochzaoch.spo', 0));
                $sheet->setCellValue("L{$cell_pos}", $v4 = ArrayHelper::getValue($item, 'in_och.bak', 0));
                $sheet->setCellValue("M{$cell_pos}", $v5 = ArrayHelper::getValue($item, 'in_zaoch.bak', 0));
                $sheet->setCellValue("N{$cell_pos}", $v6 = ArrayHelper::getValue($item, 'in_ochzaoch.bak', 0));
                $sheet->setCellValue("O{$cell_pos}", $v7 = ArrayHelper::getValue($item, 'in_och.spec', 0));
                $sheet->setCellValue("P{$cell_pos}", $v8 = ArrayHelper::getValue($item, 'in_zaoch.spec', 0));
                $sheet->setCellValue("Q{$cell_pos}", $v9 = ArrayHelper::getValue($item, 'in_ochzaoch.spec', 0));
                $sheet->setCellValue("R{$cell_pos}", $v10 = ArrayHelper::getValue($item, 'in_och.mag', 0));
                $sheet->setCellValue("S{$cell_pos}", $v11 = ArrayHelper::getValue($item, 'in_zaoch.mag', 0));
                $sheet->setCellValue("T{$cell_pos}", $v12 = ArrayHelper::getValue($item, 'in_ochzaoch.mag', 0));
                $sheet->setCellValue("U{$cell_pos}", $v13 = ArrayHelper::getValue($item, 'in_och.asp', 0));
                $sheet->setCellValue("V{$cell_pos}", $v14 = ArrayHelper::getValue($item, 'in_zaoch.asp', 0));
                $sheet->setCellValue("W{$cell_pos}", $v15 = ArrayHelper::getValue($item, 'in_ochzaoch.asp', 0));
                $sheet->setCellValue("X{$cell_pos}", $v16 = ArrayHelper::getValue($item, 'in_och.ord', 0));
                $sheet->setCellValue("Y{$cell_pos}", $v17 = ArrayHelper::getValue($item, 'in_zaoch.ord', 0));
                $sheet->setCellValue("Z{$cell_pos}", $v18 = ArrayHelper::getValue($item, 'in_ochzaoch.ord', 0));
                $sheet->setCellValue("AA{$cell_pos}", $v19 = ArrayHelper::getValue($item, 'in_och.in', 0));
                $sheet->setCellValue("AB{$cell_pos}", $v20 = ArrayHelper::getValue($item, 'in_zaoch.in', 0));
                $sheet->setCellValue("AC{$cell_pos}", $v21 = ArrayHelper::getValue($item, 'in_ochzaoch.in', 0));
                $sheet->setCellValue("AD{$cell_pos}", $v1 + $v4 + $v7 + $v10 + $v13 + $v16 + $v19);
                $sheet->setCellValue("AE{$cell_pos}", $v2 + $v5 + $v8 + $v11 + $v14 + $v17 + $v20);
                $sheet->setCellValue("AF{$cell_pos}", $v3 + $v6 + $v9 + $v12 + $v15 + $v18 + $v21);
                $sheet->setCellValue("AG{$cell_pos}", $v1 + $v4 + $v7 + $v10 + $v13 + $v16 + $v19 + $v2 + $v5 + $v8 + $v11 + $v14 + $v17 + $v20 + $v3 + $v6 + $v9 + $v12 + $v15 + $v18 + $v21);
            }
        }
        return $spreadsheet;
    }

    private function exportOne($rows, $orgs, $pages): Spreadsheet
    {
        if (!isset($orgs[0])) {
            throw new BadRequestHttpException('Ошибка с организацией');
        }

        /***
         * @var Organizations $org
         */

        $sum_attrs = [
            'spo',
            'bak',
            'spec',
            'mag',
            'asp',
            'ord',
            'in'
        ];

        $arr = [];

        foreach ($this->generatorOrg($rows) as $row) {
            $arr[$row['id_org']][$row['invalid']][$row['budjet_type']][$row['type']][] = [
                'in' => $row['in'] ?? 0,
                'ord' => $row['ord'] ?? 0,
                'asp' => $row['asp'] ?? 0,
                'mag' => $row['mag'] ?? 0,
                'spec' => $row['spec'] ?? 0,
                'bak' => $row['bak'] ?? 0,
                'spo' => $row['spo'] ?? 0,
                'name' => Countries::findOne(['code' => $row['name']])->ru ?? ''
            ];
        }

        $org = $orgs[0];
        $reader = new Xlsx();


        $spreadsheet = $reader->load(Yii::getAlias('@webroot') . '/templates/one.xlsx');

        $work = $spreadsheet->getActiveSheet();

        $liv_studs = OrgLiving::findOne(['id_org' => $org->id]);

        $work->setCellValue('B3', $org->full_name);
        $work->setCellValue('B4', $org->short_name);
        $work->setCellValue('B5', $org->founder->founder);
        $work->setCellValue('B6', $org->region->region);

        $info = $org->info;
        $info[0] = $info[0] ?? new OrgInfo();
        $info[1] = $info[1] ?? new OrgInfo();


        $work->setCellValue("B7", $v1 = $info[0]->s_f_b_spo ?? 0);
        $work->setCellValue("B8", $v2 = $info[0]->s_f_b_bak ?? 0);
        $work->setCellValue("B9", $v3 = $info[0]->s_f_b_spec ?? 0);
        $work->setCellValue("B10", $v4 = $info[0]->s_f_b_mag ?? 0);
        $work->setCellValue("B11", $v5 = $info[0]->s_f_b_asp ?? 0);
        $work->setCellValue("B12", $v6 = $info[0]->s_f_b_ord ?? 0);
        $work->setCellValue("B13", $v7 = $info[0]->s_f_b_in ?? 0);
        $work->setCellValue("B14", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);

        $work->setCellValue("B15", $v1 = $info[0]->s_b_s_spo ?? 0);
        $work->setCellValue("B16", $v2 = $info[0]->s_b_s_bak ?? 0);
        $work->setCellValue("B17", $v3 = $info[0]->s_b_s_spec ?? 0);
        $work->setCellValue("B18", $v4 = $info[0]->s_b_s_mag ?? 0);
        $work->setCellValue("B19", $v5 = $info[0]->s_b_s_asp ?? 0);
        $work->setCellValue("B20", $v6 = $info[0]->s_b_s_ord ?? 0);
        $work->setCellValue("B21", $v7 = $info[0]->s_b_s_in ?? 0);
        $work->setCellValue("B22", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);


        $work->setCellValue("B23", $v1 = $info[0]->s_m_b_spo ?? 0);
        $work->setCellValue("B24", $v2 = $info[0]->s_m_b_bak ?? 0);
        $work->setCellValue("B25", $v3 = $info[0]->s_m_b_spec ?? 0);
        $work->setCellValue("B26", $v4 = $info[0]->s_m_b_mag ?? 0);
        $work->setCellValue("B27", $v5 = $info[0]->s_m_b_asp ?? 0);
        $work->setCellValue("B28", $v6 = $info[0]->s_m_b_ord ?? 0);
        $work->setCellValue("B29", $v7 = $info[0]->s_m_b_in) ?? 0;
        $work->setCellValue("B30", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);


        $work->setCellValue("B31", $v1 = $info[0]->s_p_u_spo ?? 0);
        $work->setCellValue("B32", $v2 = $info[0]->s_p_u_bak ?? 0);
        $work->setCellValue("B33", $v3 = $info[0]->s_p_u_spec ?? 0);
        $work->setCellValue("B34", $v4 = $info[0]->s_p_u_mag ?? 0);
        $work->setCellValue("B35", $v5 = $info[0]->s_p_u_asp ?? 0);
        $work->setCellValue("B36", $v6 = $info[0]->s_p_u_ord ?? 0);
        $work->setCellValue("B37", $v7 = $info[0]->s_p_u_in ?? 0);
        $work->setCellValue("B38", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);


        $work->setCellValue(
            "B39",
            $v1 = $info[0]->s_f_b_spo +
                $info[0]->s_b_s_spo +
                $info[0]->s_m_b_spo +
                $info[0]->s_p_u_spo
        );
        $work->setCellValue(
            "B40",
            $v2 = $info[0]->s_f_b_bak +
                $info[0]->s_b_s_bak +
                $info[0]->s_m_b_bak +
                $info[0]->s_p_u_bak
        );
        $work->setCellValue(
            "B41",
            $v3 = $info[0]->s_f_b_spec +
                $info[0]->s_b_s_spec +
                $info[0]->s_m_b_spec +
                $info[0]->s_p_u_spec
        );
        $work->setCellValue(
            "B42",
            $v4 = $info[0]->s_f_b_mag +
                $info[0]->s_b_s_mag +
                $info[0]->s_m_b_mag +
                $info[0]->s_p_u_mag
        );
        $work->setCellValue(
            "B43",
            $v5 = $info[0]->s_f_b_asp +
                $info[0]->s_b_s_asp +
                $info[0]->s_m_b_asp +
                $info[0]->s_p_u_asp
        );
        $work->setCellValue(
            "B44",
            $v6 = $info[0]->s_f_b_ord +
                $info[0]->s_b_s_ord +
                $info[0]->s_m_b_ord +
                $info[0]->s_p_u_ord
        );
        $work->setCellValue(
            "B45",
            $v7 = $info[0]->s_f_b_in +
                $info[0]->s_b_s_in +
                $info[0]->s_m_b_in +
                $info[0]->s_p_u_in
        );
        $work->setCellValue(
            "B46",
            $v1 = $v1 + $v2 + $v3 + $v4 + $v5 + $v6 + $v7
        );

        $work->setCellValue("B47", $v1 = $info[1]->s_f_b_spo ?? 0);
        $work->setCellValue("B48", $v2 = $info[1]->s_f_b_bak ?? 0);
        $work->setCellValue("B49", $v3 = $info[1]->s_f_b_spec ?? 0);
        $work->setCellValue("B50", $v4 = $info[1]->s_f_b_mag ?? 0);
        $work->setCellValue("B51", $v5 = $info[1]->s_f_b_asp ?? 0);
        $work->setCellValue("B52", $v6 = $info[1]->s_f_b_ord ?? 0);
        $work->setCellValue("B53", $v7 = $info[1]->s_f_b_in ?? 0);
        $work->setCellValue("B54", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);

        $work->setCellValue("B55", $v1 = $info[1]->s_b_s_spo ?? 0);
        $work->setCellValue("B56", $v2 = $info[1]->s_b_s_bak ?? 0);
        $work->setCellValue("B57", $v3 = $info[1]->s_b_s_spec ?? 0);
        $work->setCellValue("B58", $v4 = $info[1]->s_b_s_mag ?? 0);
        $work->setCellValue("B59", $v5 = $info[1]->s_b_s_asp ?? 0);
        $work->setCellValue("B60", $v6 = $info[1]->s_b_s_ord ?? 0);
        $work->setCellValue("B61", $v7 = $info[1]->s_b_s_in ?? 0);
        $work->setCellValue("B62", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);


        $work->setCellValue("B63", $v1 = $info[1]->s_m_b_spo ?? 0);
        $work->setCellValue("B64", $v2 = $info[1]->s_m_b_bak ?? 0);
        $work->setCellValue("B65", $v3 = $info[1]->s_m_b_spec ?? 0);
        $work->setCellValue("B66", $v4 = $info[1]->s_m_b_mag ?? 0);
        $work->setCellValue("B67", $v5 = $info[1]->s_m_b_asp ?? 0);
        $work->setCellValue("B68", $v6 = $info[1]->s_m_b_ord ?? 0);
        $work->setCellValue("B69", $v7 = $info[1]->s_m_b_in ?? 0);
        $work->setCellValue("B70", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);


        $work->setCellValue("B71", $v1 = $info[1]->s_p_u_spo ?? 0);
        $work->setCellValue("B72", $v2 = $info[1]->s_p_u_bak ?? 0);
        $work->setCellValue("B73", $v3 = $info[1]->s_p_u_spec ?? 0);
        $work->setCellValue("B74", $v4 = $info[1]->s_p_u_mag ?? 0);
        $work->setCellValue("B75", $v5 = $info[1]->s_p_u_asp ?? 0);
        $work->setCellValue("B76", $v6 = $info[1]->s_p_u_ord ?? 0);
        $work->setCellValue("B77", $v7 = $info[1]->s_p_u_in ?? 0);
        $work->setCellValue("B78", $v7 + $v1 + $v2 + $v3 + $v4 + $v5 + $v6);


        $work->setCellValue(
            "B79",
            $v1 =
                ($info[1]->s_f_b_spo ?? 0) +
                ($info[1]->s_b_s_spo ?? 0) +
                ($info[1]->s_m_b_spo ?? 0) +
                ($info[1]->s_p_u_spo ?? 0)
        );

        $work->setCellValue(
            "B80",
            $v2 =
                ($info[1]->s_f_b_bak ?? 0) +
                ($info[1]->s_b_s_bak ?? 0) +
                ($info[1]->s_m_b_bak ?? 0) +
                ($info[1]->s_p_u_bak ?? 0)
        );
        $work->setCellValue(
            "B81",
            $v3 =
                ($info[1]->s_f_b_spec ?? 0) +
                ($info[1]->s_b_s_spec ?? 0) +
                ($info[1]->s_m_b_spec ?? 0) +
                ($info[1]->s_p_u_spec ?? 0)
        );
        $work->setCellValue(
            "B82",
            $v4 =
                ($info[1]->s_f_b_mag ?? 0) +
                ($info[1]->s_b_s_mag ?? 0) +
                ($info[1]->s_m_b_mag ?? 0) +
                ($info[1]->s_p_u_mag ?? 0)
        );
        $work->setCellValue(
            "B83",
            $v5 =
                ($info[1]->s_f_b_asp ?? 0) +
                ($info[1]->s_b_s_asp ?? 0) +
                ($info[1]->s_m_b_asp ?? 0) +
                ($info[1]->s_p_u_asp ?? 0)
        );
        $work->setCellValue(
            "B84",
            $v6 =
                ($info[1]->s_f_b_ord ?? 0) +
                ($info[1]->s_b_s_ord ?? 0) +
                ($info[1]->s_m_b_ord ?? 0) +
                ($info[1]->s_p_u_ord ?? 0)
        );
        $work->setCellValue(
            "B85",
            $v7 =
                ($info[1]->s_f_b_in ?? 0) +
                ($info[1]->s_b_s_in ?? 0) +
                ($info[1]->s_m_b_in ?? 0) +
                ($info[1]->s_p_u_in ?? 0)
        );
        $work->setCellValue("B86", $v1 + $v2 + $v3 + $v4 + $v5 + $v6 + $v7);

        $cnt = $this->cntArea($org->objs);
        $work->setCellValue("B87", $cnt['zil']['area_zan_obuch']);
        $work->setCellValue("B88", $cnt['zil']['area_in_kat_nan']);
        $work->setCellValue("B89", $cnt['zil']['svobod']);
        $work->setCellValue("B90", $cnt['zil']['ne_isp']);
        $work->setCellValue(
            "B91",
            $cnt['zil']['area_zan_obuch'] +
            $cnt['zil']['area_in_kat_nan'] +
            $cnt['zil']['svobod'] +
            $cnt['zil']['ne_isp']
        );
        $work->setCellValue("B92", $cnt['nezil']['obsh']);
        $work->setCellValue(
            "B93",
            $cnt['nezil']['obsh'] +
            $cnt['zil']['area_zan_obuch'] +
            $cnt['zil']['area_in_kat_nan'] +
            $cnt['zil']['svobod'] +
            $cnt['zil']['ne_isp']
        );
        $work->setCellValue("B94", $cnt['zil']['tkr']);
        $work->setCellValue("B95", $cnt['zil']['nas']);
        $work->setCellValue("B96", $cnt['zil']['np']);
        $work->setCellValue("B97", $cnt['nezil']['tkr']);
        $work->setCellValue("B98", $cnt['nezil']['nas']);
        $work->setCellValue("B99", $cnt['nezil']['np']);
        $work->setCellValue("B100", $cnt['zil']['tkr'] + $cnt['nezil']['tkr']);
        $work->setCellValue("B101", $cnt['zil']['nas'] + $cnt['nezil']['nas']);
        $work->setCellValue("B102", $cnt['zil']['np'] + $cnt['nezil']['np']);
        $work->setCellValue(
            "B103",
            $cnt['zil']['nas'] +
            $cnt['nezil']['nas'] +
            $cnt['zil']['np'] +
            $cnt['nezil']['np']
        );

        $a1 = array_reduce($org->objs ?? [], function ($a, $b) {
            $sum =
                (($b->area and $b->ustav_dey) ? $b->area->zan_obuch : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->zan_inie : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->svobod : 0);

            $mesta = (($b->area and $b->ustav_dey) ? $b->area->cnt_mest_zan_obuch : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->cnt_mest_zan_in_obuch : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->cnt_svobod_mest : 0);

            return $mesta ? $a + ($sum / ($mesta)) : $a + 0;
        }, 0);
        $c1 = array_reduce($org->objs ?? [], function ($a, $b) {
            $sum =
                (($b->area and $b->ustav_dey) ? $b->area->zan_obuch : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->zan_inie : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->svobod : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->punkt_pit : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->pom_dlya_uch : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->pom_dlya_med : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->pom_dlya_sport : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->pom_dlya_soc : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->pom_dlya_kult : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->in_nezh_plosh : 0);

            $mesta =
                (($b->area and $b->ustav_dey) ? $b->area->cnt_mest_zan_obuch : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->cnt_mest_zan_in_obuch : 0) +
                (($b->area and $b->ustav_dey) ? $b->area->cnt_svobod_mest : 0);

            return $mesta ? $a + ($sum / ($mesta)) : $a;
        }, 0);

        $cnt = count(array_filter($org->objs ?? [], function ($item) {
            return $item->ustav_dey;
        }));


        $work->setCellValue("B104", round(($cnt > 0) ? $a1 / $cnt : 0, 2));
        $work->setCellValue("B105", round(($cnt > 0) ? $c1 / $cnt : 0, 2));
        $work->setCellValue("B106", array_reduce($org->objs ?? [], function ($a, $b) {
            return $a + (($b->area && $b->ustav_dey==0) ?
                        $b->area->zan_obuch +
                        $b->area->zan_inie +
                        $b->area->svobod +
                        $b->area->neisp +
                        //$b->area->zhil_tkr +
                        //$b->area->nzhil_tkr +
                        $b->area->zhil_nas +
                        $b->area->nzhil_nas +
                        $b->area->zhil_np +
                        $b->area->nzhil_np
                        + (
                            $b->area->punkt_pit +
                            $b->area->pom_dlya_uch +
                            $b->area->pom_dlya_med +
                            $b->area->pom_dlya_sport +
                            $b->area->pom_dlya_soc +
                            $b->area->pom_dlya_kult +
                            $b->area->in_nezh_plosh
                        ) : 0);
        }, 0));

        $work->setCellValue("B107", $v1 = $org->area->m2_spo ?? 0);

        $work->setCellValue("B108", $v2 = $org->area->m2_vis ?? 0);
        $work->setCellValue("B109", $v3 = $org->area->m2_in ?? 0);
        $work->setCellValue("B110", $v1 + $v2 + $v3);
        $work->setCellValue("B111", $v1 = $org->area->c6m2_spo ?? 0);
        $work->setCellValue("B112", $v2 = $org->area->c6m2_vis ?? 0);

        $work->setCellValue("B113", $v3 = $org->area->c6m2_in ?? 0);
        $work->setCellValue("B114", $v1 + $v2 + $v3);
        $work->setCellValue("B115", $v1 = ($org->area->c6m2_spo ?? 0) + ($org->area->m2_spo ?? 0));
        $work->setCellValue("B116", $v2 = ($org->area->c6m2_vis ?? 0) + ($org->area->m2_vis ?? 0));

        $work->setCellValue("B117", $v3 = ($org->area->c6m2_in ?? 0) + ($org->area->m2_in ?? 0));
        $work->setCellValue("B118", $v11 = $v1 + $v2 + $v3);
        $work->setCellValue("B119", $v1 = array_reduce($org->objs, function ($a, $b) {
            return $a + (($b->area && $b->ustav_dey) ? $b->area->cnt_mest_zan_in_obuch : 0);
        }, 0));
        $work->setCellValue("B120", $v2 = array_reduce($org->objs, function ($a, $b) {
            return $a + (($b->area && $b->ustav_dey) ? $b->area->cnt_svobod_mest : 0);
        }, 0));
        $work->setCellValue("B121", $v3 = array_reduce($org->objs, function ($a, $b) {
            return $a + (($b->area && $b->ustav_dey) ? $b->area->cnt_neisp_mest : 0);
        }, 0));
        $work->setCellValue("B122", $v11 + $v1 + $v2 + $v3);
        $work->setCellValue("B123", $v4 = array_reduce($org->objs, function ($a, $b) {
            return $a + (($b->area && $b->ustav_dey) ? $b->area->cnt_nepr_isp_mest : 0);
        }, 0));
        $work->setCellValue("B124", $v11 + $v1 + $v2 + $v3 + $v4);
        $work->setCellValue("B125", array_reduce($org->objs, function ($a, $b) {
            return $a + (($b->area && $b->ustav_dey) ? $b->area->cnt_mest_inv : 0);
        }, 0));
        $work->setCellValue("B126", $org->area->area_cnt_nuzhd_zhil ?? 0);
        $work->setCellValue("B127", $org->area->area_cnt_prozh_u_drugih ?? 0);
        $work->setCellValue("B128", $v1 = array_reduce($org->objs, function ($a, $b) {
            return $a + (($b->area && $b->ustav_dey) ? $b->area->cnt_mest_vozm_neisp_mest : 0);
        }, 0));
        $work->setCellValue("B129", $v2 = array_reduce($org->objs, function ($a, $b) {
            return $a + (($b->area && $b->ustav_dey) ? $b->area->cnt_mest_vozm_neprig_mest : 0);
        }, 0));
        $work->setCellValue("B130", $v1 + $v2);

        $n = 0;
        $pl = 0;

        $all = 0;

        //dd($arr);

        foreach (range(0, 3) as $b_type) {
            $sum_b = [
                'in_och' => 0,
                'rf_och' => 0,
                'in_zaoch' => 0,
                'rf_zaoch' => 0,
                'in_ochzaoch' => 0,
                'rf_ochzaoch' => 0,
            ];

            foreach ($sum_attrs as $key => $attr) {
                $work->setCellValue("B" . (131 + $n + $pl + $key * 9), $v = ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.rf_och.0.{$attr}", 0));

                $sum_b['rf_och'] += $v;

                $arr2 = ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_och", []);
                $cnt = count($arr2);
                $sum = 0;


                if ($cnt > 1) {
                    $work->insertNewRowBefore(133 + $n + $pl + $key * 9, $cnt - 1);

                    foreach (range(0, $cnt - 1) as $kek) {
                        $val = ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_och.{$kek}.{$attr}", 0);
                        $sum += $val;
                        $work->setCellValue(
                            'A' . (133 + $n + $pl + $kek + $key * 9),
                            ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_och.{$kek}.name", '')
                        );
                        $work->setCellValue('B' . (133 + $n + $pl + $kek + $key * 9), $val);
                        $work->setCellValue('C' . (133 + $n + $pl + $kek + $key * 9), 'человек');
                        $work->getStyle('A' . (133 + $n + $pl + $kek + $key * 9))->getFont()->setBold(true);
                    }
                } else {
                    $work->setCellValue(
                        'B' . (133 + $n + $pl + $key * 9),
                        ($sum = ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_och.0.{$attr}", 0)) > 0 ? $sum : ''
                    );
                    $work->setCellValue('C' . (133 + $n + $pl + $key * 9), $sum ? 'человек' : '');

                    $work->setCellValue(
                        'A' . (133 + $n + $pl + $key * 9),
                        ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_och.0.name", '')
                    );
                }

                $work->setCellValue("B" . (132 + $n + $pl + $key * 9), $sum);

                $sum_b['in_och'] += $sum;
                $pl = ($cnt > 0) ? $pl + $cnt - 1 : $pl;
                $work->setCellValue("B" . (134 + $n + $pl + $key * 9), $v = ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.rf_zaoch.0.{$attr}", 0));

                $sum_b['rf_zaoch'] += $v;

                $arr2 = ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_zaoch", []);
                $cnt = count($arr2);
                $sum = 0;
                if ($cnt > 1) {
                    $work->insertNewRowBefore(136 + $n + $pl + $key * 9, $cnt - 1);

                    foreach (range(0, $cnt - 1) as $kek) {
                        $val = ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_zaoch.{$kek}.{$attr}", 0);
                        $sum += $val;

                        $work->setCellValue(
                            'A' . (136 + $n + $pl + $kek + $key * 9),
                            ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_zaoch.{$kek}.name", '')
                        );
                        $work->setCellValue('B' . (136 + $n + $pl + $kek + $key * 9), $val);
                        $work->setCellValue('C' . (136 + $n + $pl + $kek + $key * 9), 'человек');
                        $work->getStyle('A' . (136 + $n + $pl + $kek + $key * 9))->getFont()->setBold(true);
                    }
                } else {
                    $work->setCellValue(
                        'B' . (136 + $n + $pl + $key * 9),
                        ($sum = ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_zaoch.0.{$attr}", 0)) > 0 ? $sum : ''
                    );
                    $work->setCellValue('C' . (136 + $n + $pl + $key * 9), $sum ? 'человек' : '');

                    $work->setCellValue(
                        'A' . (136 + $n + $pl + $key * 9),
                        ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_zaoch.0.name", '')
                    );
                }
                $work->setCellValue("B" . (135 + $n + $pl + $key * 9), $sum);

                $sum_b['in_zaoch'] += $sum;

                $pl = ($cnt > 0) ? $pl + $cnt - 1 : $pl;

                $work->setCellValue("B" . (137 + $n + $pl + $key * 9), $v = ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.rf_ochzaoch.0.{$attr}", 0));

                $sum_b['rf_ochzaoch'] += $v;
                $arr2 = ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_ochzaoch", []);
                $cnt = count($arr2);
                $sum = 0;

                if ($cnt > 1) {
                    $work->insertNewRowBefore(139 + $n + $pl + $key * 9, $cnt - 1);

                    foreach (range(0, $cnt - 1) as $kek) {
                        $val = ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_ochzaoch.{$kek}.{$attr}", 0);
                        $sum += $val;

                        $work->setCellValue(
                            'A' . (139 + $n + $pl + $kek + $key * 9),
                            ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_ochzaoch.{$kek}.name", '')
                        );
                        $work->setCellValue('B' . (139 + $n + $pl + $kek + $key * 9), $val);
                        $work->setCellValue('C' . (139 + $n + $pl + $kek + $key * 9), 'человек');
                        $work->getStyle('A' . (139 + $n + $pl + $kek + $key * 9))->getFont()->setBold(true);
                    }
                } else {
                    $work->setCellValue(
                        'B' . (139 + $n + $pl + $key * 9),
                        ($sum = ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_ochzaoch.0.{$attr}", 0)) > 0 ? $sum : ''
                    );
                    $work->setCellValue('C' . (139 + $n + $pl + $key * 9), $sum ? 'человек' : '');

                    $work->setCellValue(
                        'A' . (139 + $n + $pl + $key * 9),
                        ArrayHelper::getValue($arr, "{$org->id}.0.{$b_type}.in_ochzaoch.0.name", '')
                    );
                }
                $work->setCellValue("B" . (138 + $n + $pl + $key * 9), $sum);
                $sum_b['in_ochzaoch'] += $sum;

                $pl = ($cnt > 0) ? $pl + $cnt - 1 : $pl;
                $l_key = (139 + $n + $pl + $key * 9);
            }

            $work->setCellValue("B" . ($l_key + 1), $v1 = $sum_b['rf_och']);
            $work->setCellValue("B" . ($l_key + 2), $v2 = $sum_b['in_och']);
            $work->setCellValue("B" . ($l_key + 3), $v3 = $sum_b['rf_zaoch']);
            $work->setCellValue("B" . ($l_key + 4), $v4 = $sum_b['in_zaoch']);
            $work->setCellValue("B" . ($l_key + 5), $v5 = $sum_b['rf_ochzaoch']);
            $work->setCellValue("B" . ($l_key + 6), $v6 = $sum_b['in_ochzaoch']);
            $work->setCellValue("B" . ($l_key = ($l_key + 7)), $v1 + $v2 + $v3 + $v4 + $v5 + $v6);
            $all += $v1 + $v2 + $v3 + $v4 + $v5 + $v6;

            $n += 70;
        }


        $work->setCellValue("B" . ($l_key + 1), $all);
        $n = 0;


        $all = 0;
        $l_key = 0;


        foreach (range(0, 3) as $b_type) {
            $sum_b = [
                'in_och' => 0,
                'rf_och' => 0,
                'in_zaoch' => 0,
                'rf_zaoch' => 0,
                'in_ochzaoch' => 0,
                'rf_ochzaoch' => 0,
            ];

            foreach ($sum_attrs as $key => $attr) {
                $work->setCellValue("B" . (412 + $n + $pl + $key * 7), $v1 = ArrayHelper::getValue($arr, "{$org->id}.1.{$b_type}.rf_och.0.{$attr}", 0));
                $work->setCellValue("B" . (413 + $n + $pl + $key * 7), $v2 = ArrayHelper::getValue($arr, "{$org->id}.1.{$b_type}.in_och.0.{$attr}", 0));
                $work->setCellValue("B" . (414 + $n + $pl + $key * 7), $v3 = ArrayHelper::getValue($arr, "{$org->id}.1.{$b_type}.rf_zaoch.0.{$attr}", 0));
                $work->setCellValue("B" . (415 + $n + $pl + $key * 7), $v4 = ArrayHelper::getValue($arr, "{$org->id}.1.{$b_type}.in_zaoch.0.{$attr}", 0));
                $work->setCellValue("B" . (416 + $n + $pl + $key * 7), $v5 = ArrayHelper::getValue($arr, "{$org->id}.1.{$b_type}.rf_ochzaoch.0.{$attr}", 0));
                $work->setCellValue("B" . (417 + $n + $pl + $key * 7), $v6 = ArrayHelper::getValue($arr, "{$org->id}.1.{$b_type}.in_ochzaoch.0.{$attr}", 0));
                $work->setCellValue("B" . (418 + $n + $pl + $key * 7), $v1 + $v2 + $v3 + $v4 + $v5 + $v6);

                $sum_b['rf_och'] += $v1;
                $sum_b['in_och'] += $v2;
                $sum_b['rf_zaoch'] += $v3;
                $sum_b['in_zaoch'] += $v4;
                $sum_b['rf_ochzaoch'] += $v5;
                $sum_b['in_ochzaoch'] += $v6;

                $l_key = (418 + $n + $pl + $key * 7);
                //$n += 7;
            }

            $work->setCellValue("B" . ($l_key + 1), $v1 = $sum_b['rf_och']);
            $work->setCellValue("B" . ($l_key + 2), $v2 = $sum_b['in_och']);
            $work->setCellValue("B" . ($l_key + 3), $v3 = $sum_b['rf_zaoch']);
            $work->setCellValue("B" . ($l_key + 4), $v4 = $sum_b['in_zaoch']);
            $work->setCellValue("B" . ($l_key + 5), $v5 = $sum_b['rf_ochzaoch']);
            $work->setCellValue("B" . ($l_key + 6), $v6 = $sum_b['in_ochzaoch']);
            $work->setCellValue("B" . ($l_key = ($l_key + 7)), $v1 + $v2 + $v3 + $v4 + $v5 + $v6);
            $all += $v1 + $v2 + $v3 + $v4 + $v5 + $v6;

            $n += 56;
        }


        $work->setCellValue("B" . ($l_key + 1), $all);
        $work->setCellValue("B" . ($l_key + 2), $liv_studs->cnt_stug_step ?? 0);
        $work->setCellValue("B" . ($l_key + 3), $v1 = $liv_studs->rab_p ?? 0);
        $work->setCellValue("B" . ($l_key + 4), $v2 = $liv_studs->rab_s ?? 0);
        $work->setCellValue("B" . ($l_key + 5), $v3 = $liv_studs->nauch_p ?? 0);
        $work->setCellValue("B" . ($l_key + 6), $v4 = $liv_studs->nauch_s ?? 0);

        $work->setCellValue("B" . ($l_key + 7), $v5 = $liv_studs->prof_p ?? 0);
        $work->setCellValue("B" . ($l_key + 8), $v6 = $liv_studs->prof_s ?? 0);
        $work->setCellValue("B" . ($l_key + 9), $v7 = $liv_studs->in_p ?? 0);
        $work->setCellValue("B" . ($l_key + 10), $v8 = $liv_studs->in_s ?? 0);
        $work->setCellValue("B" . ($l_key + 11), $v1 + $v2 + $v3 + $v4 + $v5 + $v6 + $v7 + $v8);
        $work->setCellValue("B" . ($l_key + 12), $liv_studs->inie_pr ?? 0);
        $work->setCellValue("B" . ($l_key + 13), $org->covid_var1 ? 'Да' : 'Нет');
        $work->setCellValue("B" . ($l_key + 14), $org->covid_var2 ?? '-');
        $work->setCellValue("B" . ($l_key + 15), $org->covid_var3 ?? 0);
        $work->setCellValue("B" . ($l_key + 16), $org->covid_var4 ?? 0);
        $work->setCellValue("B" . ($l_key + 17), $org->covid_var5 ?? 0);


        $pos = 18;

        $labels = [
            '1 Наименование жилого объекта',
            '2 Адрес жилого объекта',
            '3 Регион расположения объекта',
            '4 Кадастровый номер',
            '5 Основание для использования здания',
            '5.1 Дата регистрации права',
            '5.2 Номер регистрации права',
            '6 Планировка жилых помещений в общежитии ',
            '7 Тип размещения ',
            '8 Наличие приборов учета использования ресурсов ',
            '9 Сметная стоимость строительства (реконструкции) в ценах года её определения',
            '10 Год, в ценах которого определена стоимость строительства (реконструкции)',
            '11 Год начала строительства',
            '12 Год постройки здания',
            '13 Год ввода в эксплуатацию',
            '14.1 Объемы финансирования строительства за счёт средств федерального бюджета',
            '14.2 Объемы финансирования строительства за счёт средств бюджета субъекта',
            '14.3 Объемы финансирования строительства за счёт внебюджетных средств',
            '14 Объемы финансирования строительства',
            '15 Реконструкция или капитальный ремонт проводился, проводится или запланирован',
            '16 Месяц и год начала реконструкции или капитального ремонта',
            '17 Сроки ввода (месяц и год) в эксплуатацию после реконструкции или капитального ремонта',
            '18.1 Объемы финансирования реконструкции или капитального ремонта за счёт средств федерального бюджета',
            '18.2 Объемы финансирования реконструкции или капитального ремонта за счёт средств бюджета субъекта',
            '18.3 Объемы финансирования реконструкции или капитального ремонта за счёт внебюджетных средств',
            '18 Объемы финансирования реконструкции или капитального ремонта',
            '19 Используется ли объект в уставных целях',
            '19.1 Причина не использования в уставной деятельности',
            '19.2 Использование объекта возможно при условии',
            '19.3 Использование объекта невозможно по причине',
            '20 Наличие пандуса для лиц с ограниченными возможностями здоровья',
            '21 Наличие специализированных подъемных механизмов и поручней  для лиц с ограниченными возможностями здоровья',
            '22 Оборудование специализированными санузлами  для лиц с ограниченными возможностями здоровья',
            '23 Наличие систем сигнализации и оповещения  для лиц с ограниченными возможностями здоровья',
            '24 Наличие тактильных покрытий  для лиц с ограниченными возможностями здоровья',
            '25 Наличие тактильных вывесок со шрифтом Брайля  для лиц с ограниченными возможностями здоровья',
            '26 Минимальный период заключения договора аренды жилого помещения в общежитии',
            '27 Максимальный период заключения договора аренды жилого помещения в общежитии',
            '28 Наличие в общежитии бесплатного доступа к информационно-коммуникационной сети “Интернет”',
            '29.1.А Жилая площадь общежития, занятая обучающимися',
            '29.1.Б Жилая площадь общежития, занятая иными категориями нанимателей',
            '29.1.В Жилая свободная площадь общежития',
            '29.1.Г Жилая неиспользуемая площадь общежития',
            '29.1 Всего пригодно к использованию жилой площади',
            '29.2.А.1 Нежилая социальная площадь, являющаяся пунктом питания',
            '29.2.А.2 Нежилая социальная площадь для организации учебного процесса',
            '29.2.А.3 Нежилая социальная площадь для организации медицинского обслуживания',
            '29.2.А.4 Нежилая социальная площадь для организации спортивных занятий',
            '29.2.А.5 Нежилая социальная площадь для организации культурных программ',
            '29.2.А.6 Иная нежилая социальная площадь',
            '29.2.А Всего пригодно к использованию нежилой площади под соц инфраструктурой',
            '29.2.Б Иная нежилая площадь',
            '29.2 Всего пригодно к использованию нежилой площади',
            '29 Всего пригодно к использованию жилой и нежилой площади',
            '30.1.1 Жилая площадь, требующая капитального ремонта',
            '30.1.2 Жилая площадь, находящаяся в аварийном состоянии',
            '30.1.3 Жилая площадь, непригодная для проживания',
            '30.2.1 Нежилая площадь, требующая капитального ремонта',
            '30.2.2 Нежилая площадь, находящаяся в аварийном состоянии',
            '30.2.3 Нежилая площадь, непригодная для проживания',
            '30.3 Площадь, требующая капитального ремонта',
            '30.4 Площадь, находящаяся в аварийном состоянии',
            '30.5 Площадь, непригодная для проживания',
            '30 Площадь, непригодная к использованию (без учёта площади, требующей капитального ремонта)',
            '31 Площадь, предоставленная в аренду',
            '32 Площадь, предоставленная в безвозмездное пользование',
            '33 Количество общей площади на одного проживающего',
            '34 Количество жилой площади на одного проживающего',
            '35.1.1 Мест занято обучающимися',
            '35.1.2 Мест занято иными категориями нанимателей',
            '35.1.3 Мест свободно',
            '35.1.4 Мест не используется',
            '35.1 Всего мест пригодно к использованию',
            '35.2 Мест непригодно к использованию',
            '35 Всего мест',
            '36 Мест оборудованных для лиц с ограниченными возможностями',
            '37.1 Мест, возможных к вводу в эксплуатацию из числа неиспользуемых после проведения восстановительных работ',
            '38.2 Мест, возможных к вводу в эксплуатацию из числа непригодных к использованию после проведения восстановительных работ',
            '39 Всего мест, возможных к вводу в эксплуатацию после проведения восстановительных работ',
            '40.1 Поступления за проживание в общежитии без учёта дополнительных услуг',
            '40.2 Поступления за дополнительные услуги проживания в общежитии',
            '40.3 Поступления от аренды помещений общежития',
            '40.4 Поступления целевых средств',
            '40 Общий объём поступлений',
            '41.1.А Расходы на водоснабжение (холодное, горячие, водоотведение)',
            '41.1.Б Расходы на тепловую энергию',
            '41.1.В Расходы на природный газ',
            '41.1.Г Расходы на электрическую энергию',
            '41.1 Всего расходов на коммунальные услуги',
            '41.2.А Расходы на уборку территории',
            '41.2.Б Расходы на уборку помещений',
            '41.2.В Расходы на техническое обслуживание',
            '41.2.Г Расходы на дератизацию, дезинсекцию',
            '41.2.Д Расходы на вывоз ТБО',
            '41.2.Е Расходы на государственные поверки, паспортизации',
            '41.2.Ж Расходы на проведение обследования технического состояния (аттестация)',
            '41.2.З Расходы на противопожарные мероприятия',
            '41.2.И Иные расходы, связанные с содержанием имущества',
            '41.2 Расходы, связанные с содержанием имущества',
            '41.3.А Расходы на услуги охраны',
            '41.3.Б Расходы в рамках антитеррористической защиты, тыс.руб.',
            '41.3.В Иные расходы на обеспечение безопасности',
            '41.3 Расходы на обеспечение безопасности проживания',
            '41.4.А Расходы на налог на имущество',
            '41.4.Б Расходы на уплату земельного налога',
            '41.4 Расходы на уплату налогов',
            '41.5 Расходы на услуги связи',
            '41.6 Расходы на капитальный ремонт',
            '41.7 Расходы на текущий ремонт',
            '41.8 Расходы на приобретение мягкого инвентаря и других материальных запасов',
            '41.9 Расходы на приобретение основных средств, в том числе мебели',
            '41 Всего расходов',
            '42 Расходы на фонд оплаты труда',
            '43.1.1 Размер платы за коммунальные услуги с учетом усредненных тарифов для обучающихся за счёт бюджетных средств',
            '43.1.2 Размер платы за коммунальные услуги с учетом усредненных тарифов для обучающихся по договорам об оказании платных образовательных услуг ',
            '43.1.3 Размер платы за коммунальные услуги с учетом усредненных тарифов для лиц, не являющимися гражданами России',
            '43.1.4 Размер платы за коммунальные услуги с учетом усредненных тарифов для обучающихся других образовательных организаций',
            '43.1.5 Размер платы за коммунальные услуги с учетом усредненных тарифов для иных категорий нанимателей',
            '43.2.1 Размер платы за коммунальные услуги (по показаниям приборов учета) для обучающихся за счёт бюджетных средств',
            '43.2.2 Размер платы за коммунальные услуги (по показаниям приборов учета) для обучающихся по договорам об оказании платных образовательных услуг ',
            '43.2.3 Размер платы за коммунальные услуги (по показаниям приборов учета) для лиц, не являющимися гражданами России',
            '43.2.4 Размер платы за коммунальные услуги (по показаниям приборов учета) для обучающихся других образовательных организаций',
            '43.2.5 Размер платы за коммунальные услуги (по показаниям приборов учета) для иных категорий нанимателей',
            '43.3.1 Размер платы за пользование жилым помещением для обучающихся за счёт бюджетных средств',
            '43.3.2 Размер платы за пользование жилым помещением для обучающихся по договорам об оказании платных образовательных услуг ',
            '43.3.3 Размер платы за пользование жилым помещением для лиц, не являющимися гражданами России',
            '43.3.4 Размер платы за пользование жилым помещением для обучающихся других образовательных организаций',
            '43.3.5 Размер платы за пользование жилым помещением для иных категорий нанимателей',
            '43.4.1 Размер платы за дополнительные услуги (комфортность, иное) для обучающихся за счёт бюджетных средств',
            '43.4.2 Размер платы за дополнительные услуги (комфортность, иное) для обучающихся по договорам об оказании платных образовательных услуг ',
            '43.4.3 Размер платы за дополнительные услуги (комфортность, иное) для лиц, не являющимися гражданами России',
            '43.4.4 Размер платы за дополнительные услуги (комфортность, иное) для обучающихся других образовательных организаций',
            '43.4.5 Размер платы за дополнительные услуги (комфортность, иное) для иных категории нанимателей',
        ];

        $units = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'рублей',
            '',
            '',
            '',
            '',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            '',
            '',
            '',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            '',
            '',
            '',
            '',
            'штук',
            'штук',
            'штук',
            'штук',
            'штук',
            'штук',
            'месяцев',
            'месяцев',
            'да/нет',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'квадратных метров',
            'мест',
            'мест',
            'мест',
            'мест',
            'мест',
            'мест',
            'мест',
            'мест',
            'мест',
            'мест',
            'мест',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
            'рублей',
        ];

        $obj_vals = [];

        $obj_cnt = 0;

        $flats = [
            'odn' => 'Одноместный',
            'dvuh' => 'Двухместный',
            'treh' => 'Трёхместный и более',
            'smesh' => 'Смешанный',
        ];
        $plan = [
            'kor' => 'Коридорная',
            'bloch' => 'Блочная',
            'kvar' => 'Квартирная',
            'gost' => 'Гостиничная'
        ];
        $prib_type = [
            'ind' => 'Индивидуальные (на комнату)',
            'obsh' => 'Общедомовые',
            'ots' => 'Отсутствуют',
        ];

        $osn_isp = [
            1 => 'Право оперативного управления',
            3 => 'Договор аренды',
            4 => 'Договор о безвоздмездом пользовании',
            5 => 'Собственность',
            9 => 'Иное'
        ];

        $end = 0;
        if (isset($org->objs)) {
            foreach ($org->objs as $i => $obj) {
                $work->insertNewRowBefore($l_key + $pos + $obj_cnt, 133 + count($org->objs) - 1);

                /***
                 * @var Objects $obj
                 */

                $obj_vals[$i][] = $obj->name;
                $obj_vals[$i][] = $obj->address;
                $obj_vals[$i][] = $obj->region->region ?? '';
                $obj_vals[$i][] = $obj->kad_number;
                $obj_vals[$i][] = $osn_isp[$obj->osn_isp] ?? '';
                $obj_vals[$i][] = $obj->reg_zap;
                $obj_vals[$i][] = $obj->doc_number;
                $obj_vals[$i][] = $plan[$obj->flat_plan] ?? '';
                $obj_vals[$i][] = $flats[$obj->flat_type] ?? '';
                $obj_vals[$i][] = $prib_type[$obj->prib_type] ?? '';
                $obj_vals[$i][] = $obj->smet;
                $obj_vals[$i][] = $obj->year_cen;
                $obj_vals[$i][] = $obj->stroy_date_start ?? '-';
                $obj_vals[$i][] = $obj->stroy_date_end ?? '-';
                $obj_vals[$i][] = $obj->exp_date ?? '-';
                $obj_vals[$i][] = $v1 = $obj->money_faip ?? 0;
                $obj_vals[$i][] = $v2 = $obj->money_bud_sub ?? 0;
                $obj_vals[$i][] = $v3 = $obj->money_vneb ?? 0;
                $obj_vals[$i][] = $v1 + $v2 + $v3;
                $obj_vals[$i][] = $obj->reconstruct ? 'Да' : 'Нет';
                $obj_vals[$i][] = date("Y-m", strtotime($obj->date_start_reconstruct));
                $obj_vals[$i][] = date("Y-m", strtotime($obj->date_end_reconstruct));
                $obj_vals[$i][] = $v1 = $obj->rec_money_faip ?? 0;
                $obj_vals[$i][] = $v2 = $obj->rec_money_bud_sub ?? 0;
                $obj_vals[$i][] = $v3 = $obj->rec_money_vneb ?? 0;
                $obj_vals[$i][] = $v1 + $v2 + $v3;
                $obj_vals[$i][] = $obj->ustav_dey ? 'Используется' : 'Не используется';
                $obj_vals[$i][] = $obj->reason ?? '-';
                $obj_vals[$i][] = $obj->uslovie ?? '-';
                $obj_vals[$i][] = $obj->nevos_reason ?? '-';
                $obj_vals[$i][] = $obj->pandus;
                $obj_vals[$i][] = $obj->mech_por;
                $obj_vals[$i][] = $obj->sanusel;
                $obj_vals[$i][] = $obj->signal;
                $obj_vals[$i][] = $obj->pokr;
                $obj_vals[$i][] = $obj->vives;
                $obj_vals[$i][] = $obj->min_per;
                $obj_vals[$i][] = $obj->max_per;
                $obj_vals[$i][] = $obj->wifi ? 'Да' : 'Нет';
                $obj_vals[$i][] = $v1 = $obj->area->zan_obuch ?? 0;
                $obj_vals[$i][] = $v2 = $obj->area->zan_inie ?? 0;
                $obj_vals[$i][] = $v3 = $obj->area->svobod ?? 0;
                $obj_vals[$i][] = $v4 = $obj->area->neisp ?? 0;
                $obj_vals[$i][] = $v11 = $v1 + $v2 + $v3 + $v4;
                $obj_vals[$i][] = $v1 = $obj->area->punkt_pit ?? 0;
                $obj_vals[$i][] = $v2 = $obj->area->pom_dlya_uch ?? 0;
                $obj_vals[$i][] = $v3 = $obj->area->pom_dlya_med ?? 0;
                $obj_vals[$i][] = $v4 = $obj->area->pom_dlya_sport ?? 0;
                $obj_vals[$i][] = $v5 = $obj->area->pom_dlya_kult ?? 0;
                $obj_vals[$i][] = $v6 = $obj->area->pom_dlya_soc ?? 0;
                $obj_vals[$i][] = $v1 + $v2 + $v3 + $v4 + $v5 + $v6;
                $obj_vals[$i][] = $v7 = $obj->area->in_nezh_plosh ?? 0;
                $obj_vals[$i][] = $v12 = $v1 + $v2 + $v3 + $v4 + $v5 + $v6 + $v7;
                $obj_vals[$i][] = $v12 + $v11;
                $obj_vals[$i][] = $v1 = $obj->area->zhil_tkr ?? 0;
                $obj_vals[$i][] = $v3 = $obj->area->zhil_nas ?? 0;
                $obj_vals[$i][] = $v5 = $obj->area->zhil_np ?? 0;
                $obj_vals[$i][] = $v2 = $obj->area->nzhil_tkr ?? 0;
                $obj_vals[$i][] = $v4 = $obj->area->nzhil_nas ?? 0;
                $obj_vals[$i][] = $v6 = $obj->area->nzhil_np ?? 0;
                $obj_vals[$i][] = $v1 = $v2 + $v1;
                $obj_vals[$i][] = $v2 = $v4 + $v3;
                $obj_vals[$i][] = $v3 = $v6 + $v5;
                $obj_vals[$i][] =  $v2 + $v3;
                $obj_vals[$i][] = $v1 = $obj->area->aren ?? 0;
                $obj_vals[$i][] = $v3 = $obj->area->pbp ?? 0;
                $obj_vals[$i][] = $v1 = $obj->area->cnt_mest_obsh_na_odn ?? 0;
                $obj_vals[$i][] = $v3 = $obj->area->cnt_mest_pl_na_odn ?? 0;
                $obj_vals[$i][] = $v1 = $obj->area->cnt_mest_zan_obuch ?? 0;
                $obj_vals[$i][] = $v2 = $obj->area->cnt_mest_zan_in_obuch ?? 0;
                $obj_vals[$i][] = $v3 = $obj->area->cnt_svobod_mest ?? 0;
                $obj_vals[$i][] = $v4 = $obj->area->cnt_neisp_mest ?? 0;
                $obj_vals[$i][] = $v1 + $v2 + $v3 + $v4;
                $obj_vals[$i][] = $v5 = $obj->area->cnt_nepr_isp_mest ?? 0;
                $obj_vals[$i][] = $v1 + $v2 + $v3 + $v4 + $v5;
                $obj_vals[$i][] = $v5 = $obj->area->cnt_mest_inv ?? 0;
                $obj_vals[$i][] = $v3 = $obj->area->cnt_mest_vozm_neisp_mest ?? 0;
                $obj_vals[$i][] = $v4 = $obj->area->cnt_mest_vozm_neprig_mest ?? 0;
                $obj_vals[$i][] = $v3 + $v4;
                $obj_vals[$i][] = $v1 = $obj->money->money_prozh_bez_dop ?? 0;
                $obj_vals[$i][] = $v2 = $obj->money->money_prozh_dop ?? 0;
                $obj_vals[$i][] = $v3 = $obj->money->money_aren ?? 0;
                $obj_vals[$i][] = $v4 = $obj->money->money_cel_sred ?? 0;
                $obj_vals[$i][] = $v11 = $v1 + $v2 + $v3 + $v4;
                $obj_vals[$i][] = $v1 = $obj->money->voda ?? 0;
                $obj_vals[$i][] = $v2 = $obj->money->tep ?? 0;
                $obj_vals[$i][] = $v3 = $obj->money->gaz ?? 0;
                $obj_vals[$i][] = $v4 = $obj->money->elect ?? 0;
                $obj_vals[$i][] = $v12 = $v1 + $v2 + $v3 + $v4;
                $obj_vals[$i][] = $v1 = $obj->money->uborka_ter ?? 0;
                $obj_vals[$i][] = $v2 = $obj->money->uborka_pom ?? 0;
                $obj_vals[$i][] = $v3 = $obj->money->tech_obs ?? 0;
                $obj_vals[$i][] = $v4 = $obj->money->derivation ?? 0;
                $obj_vals[$i][] = $v5 = $obj->money->tbo ?? 0;
                $obj_vals[$i][] = $v6 = $obj->money->gos_prov ?? 0;
                $obj_vals[$i][] = $v7 = $obj->money->attest ?? 0;
                $obj_vals[$i][] = $v8 = $obj->money->prot_pozhar ?? 0;
                $obj_vals[$i][] = $v9 = $obj->money->inie_rash ?? 0;
                $obj_vals[$i][] = $v13 = $v1 + $v2 + $v3 + $v4 + $v5 + $v6 + $v7 + $v8 + $v9;
                $obj_vals[$i][] = $v1 = $obj->money->ohrana ?? 0;
                $obj_vals[$i][] = $v2 = $obj->money->anti_ter ?? 0;
                $obj_vals[$i][] = $v3 = $obj->money->inie_rash_ohrana ?? 0;
                $obj_vals[$i][] = $v14 = $v1 + $v2 + $v3;
                $obj_vals[$i][] = $v1 = $obj->money->nalog_imush ?? 0;
                $obj_vals[$i][] = $v2 = $obj->money->zem_nalog ?? 0;
                $obj_vals[$i][] = $v15 = $v1 + $v2;
                $obj_vals[$i][] = $v1 = $obj->money->svaz ?? 0;
                $obj_vals[$i][] = $v2 = $obj->money->kap_rem ?? 0;
                $obj_vals[$i][] = $v3 = $obj->money->tek_rem ?? 0;
                $obj_vals[$i][] = $v4 = $obj->money->mygk_inv ?? 0;
                $obj_vals[$i][] = $v5 = $obj->money->osn_sred ?? 0;
                $obj_vals[$i][] = $v15 + $v14 + $v13 + $v12 + $v1 + $v2 + $v3 + $v4 + $v5;
                $obj_vals[$i][] = $v5 = $obj->money->opla_trud ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->u_t_b ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->u_t_p ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->u_t_nr ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->u_t_do ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->u_t_in ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->k_u_b ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->k_u_p ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->k_u_nr ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->k_u_do ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->k_u_in ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->p_p_b ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->p_p_p ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->p_p_nr ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->p_p_do ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->p_p_in ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->d_u_b ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->d_u_p ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->d_u_nr ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->d_u_do ?? 0;
                $obj_vals[$i][] = $v1 = $obj->tariff->d_u_in ?? 0;


                $work->setCellValue("A" . ($l_key + $pos + $obj_cnt), "объект \"{$obj->name}\" (\"{$obj->kad_number}\")");
                $work->mergeCells("A" . ($l_key + $pos + $obj_cnt) . ":C" . ($l_key + $pos + $obj_cnt));

                $work->getStyle("A" . (($l_key + $pos + $obj_cnt)) . ":C" . ($l_key + $pos + $obj_cnt))->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => [
                                'rgb' => '808080'
                            ]
                        ]
                    ],
                    'font' => [
                        'name' => 'Times New Roman'
                    ]
                ]);

                $start = ($l_key + $pos + $obj_cnt) + 1;

                $pos++;
                foreach (range(0, 132) as $label) {
                    $work->setCellValue("A" . ($l_key + $pos + $obj_cnt + $label), $labels[$label]);
                    $work->setCellValue("B" . ($l_key + $pos + $obj_cnt + $label), $obj_vals[$i][$label] ?? '');
                    $work->setCellValue("C" . ($l_key + $pos + $obj_cnt + $label), $units[$label]);
                    $end = $l_key + $pos + $obj_cnt + $label;
                }

                $work->getStyle("A{$start}:C{$end}")->applyFromArray([
                    'alignment' => [
                        // 'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => [
                                'rgb' => '808080'
                            ]
                        ]
                    ],
                    'font' => [
                        'name' => 'Times New Roman'
                    ]
                ]);


                $obj_cnt += 133;
            }
        }

        $conts = 'Выгрузку из Системы произвёл: ';
        if ($org->usersInfo) {
            $conts .= ($org->usersInfo[0]->name . ' ' . $org->usersInfo[0]->phone . ' ' . $org->usersInfo[0]->email);
        }

        $work->setCellValue("A" . ($l_key + $pos + $obj_cnt + 1), 'Руководитель организации________________/_______________________');
        $work->setCellValue("A" . ($l_key + $pos + $obj_cnt + 2), $conts);
        $work->setCellValue("A" . ($l_key + $pos + $obj_cnt + 3), date("d.m.Y H:i:s"));


        return $spreadsheet;
    }

    /**
     * @inheritDoc
     * @throws BadRequestHttpException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws Exception
     */
    public function execute($queue)
    {
        $where = $this->where;
        $pages = $this->pages;

        $orgs = Organizations::find()
            ->where($where)
            ->with(['info', 'region', 'founder', 'objs'])
            ->all();

        $rows = OrgLivingStudents::cntStudents(isset($where['organizations.id']) ? $where : [], 0);

        ini_set('memory_limit', '-1');


        $spreadsheet = ($this->id_org) ?
            $this->exportOne($rows, $orgs, $pages) :
            $this->exportAll($rows, $orgs, $pages, $where);


        $spreadsheet->setActiveSheetIndex(0);
        $xlsx = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $path = Yii::getAlias('@webroot') .
            ($this->id_org ?
                "/uploads/{$this->id_org}/" :
                "/uploads/");

        if (!file_exists($path)) {
            FileHelper::createDirectory($path);
        }

        $path .= "{$this->fileName}.xlsx";

        $xlsx->save($path);

        Yii::$app->queue->push(new fileMail(
            [
                'file' => $path,
                'subject' => 'выгрузка ИАС',
                'mail' => $this->mail,
                'message' => 'выгрузка ИАС'
            ]
        ));
    }
}
