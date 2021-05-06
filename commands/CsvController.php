<?php


namespace app\commands;

use app\models\OrgInfo;
use Yii;
use yii\helpers\ArrayHelper;

class CsvController extends \yii\console\Controller
{
    public function actionVpo()
    {
        $org = 1;

        $g10 = 7;
        $g11 = 8;
        $g12 = 9;
        $g13 = 10;

        $g25 = 11;
        $g26 = 12;
        $g27 = 13;
        $g28 = 14;

        $g40 = 15;
        $g41 = 16;
        $g42 = 17;
        $g43 = 18;
        $csvP = Yii::getAlias('@webroot') . "/orgs.csv";
        $csv = fopen($csvP, 'r');

        $orgs = [];

        while (($row = fgetcsv($csv, 60000, ';')) != false) {
            $orgs[] = [
                'id' => $row[0],
                'id_e' => $row[1],
            ];
        }

        fclose($csv);

        $orgs = ArrayHelper::map($orgs, 'id_e', 'id');

        $csvP = Yii::getAlias('@webroot') . "/rus.csv";
        $csv = fopen($csvP, 'r');

        $arr = [];

        while (($row = fgetcsv($csv, 60000, ';')) != false) {
            $arr[$row[$org]][0]['bak'] = $arr[$row[$org]][0]['bak'] ?? 0;
            $arr[$row[$org]][1]['bak'] = $arr[$row[$org]][1]['bak'] ?? 0;
            $arr[$row[$org]][2]['bak'] = $arr[$row[$org]][2]['bak'] ?? 0;
            $arr[$row[$org]][3]['bak'] = $arr[$row[$org]][3]['bak'] ?? 0;

            $arr[$row[$org]][0]['spec'] = $arr[$row[$org]][0]['spec'] ?? 0;
            $arr[$row[$org]][1]['spec'] = $arr[$row[$org]][1]['spec'] ?? 0;
            $arr[$row[$org]][2]['spec'] = $arr[$row[$org]][2]['spec'] ?? 0;
            $arr[$row[$org]][3]['spec'] = $arr[$row[$org]][3]['spec'] ?? 0;

            $arr[$row[$org]][0]['mag'] = $arr[$row[$org]][0]['mag'] ?? 0;
            $arr[$row[$org]][1]['mag'] = $arr[$row[$org]][1]['mag'] ?? 0;
            $arr[$row[$org]][2]['mag'] = $arr[$row[$org]][2]['mag'] ?? 0;
            $arr[$row[$org]][3]['mag'] = $arr[$row[$org]][3]['mag'] ?? 0;

            $arr[$row[$org]][0]['bak'] = $arr[$row[$org]][0]['bak'] + $row[$g10];
            $arr[$row[$org]][1]['bak'] = $arr[$row[$org]][1]['bak'] + $row[$g11];
            $arr[$row[$org]][2]['bak'] = $arr[$row[$org]][2]['bak'] + $row[$g12];
            $arr[$row[$org]][3]['bak'] = $arr[$row[$org]][3]['bak'] + $row[$g13];


            $arr[$row[$org]][0]['spec'] = $arr[$row[$org]][0]['spec'] + $row[$g25];
            $arr[$row[$org]][1]['spec'] = $arr[$row[$org]][1]['spec'] + $row[$g26];
            $arr[$row[$org]][2]['spec'] = $arr[$row[$org]][2]['spec'] + $row[$g27];
            $arr[$row[$org]][3]['spec'] = $arr[$row[$org]][3]['spec'] + $row[$g28];

            $arr[$row[$org]][0]['mag'] = $arr[$row[$org]][0]['mag'] + $row[$g40];
            $arr[$row[$org]][1]['mag'] = $arr[$row[$org]][1]['mag'] + $row[$g41];
            $arr[$row[$org]][2]['mag'] = $arr[$row[$org]][2]['mag'] + $row[$g42];
            $arr[$row[$org]][3]['mag'] = $arr[$row[$org]][3]['mag'] + $row[$g43];
        }

        foreach ($arr as $id_org_e => $item) {
            if (!isset($orgs[$id_org_e])) {
                continue;
            }
            $org_info = OrgInfo::findOne(['stud_type' => 0, 'id_org' => $orgs[$id_org_e]]) ?? new OrgInfo();
            if ($org_info->isNewRecord) {
                $org_info->id_org = $orgs[$id_org_e];
                $org_info->stud_type = 0;
            }
            $org_info->s_f_b_bak = $arr[$id_org_e][0]['bak'];
            $org_info->s_f_b_spec = $arr[$id_org_e][0]['spec'];
            $org_info->s_f_b_mag = $arr[$id_org_e][0]['mag'];

            $org_info->s_b_s_bak = $arr[$id_org_e][1]['bak'];
            $org_info->s_b_s_spec = $arr[$id_org_e][1]['spec'];
            $org_info->s_b_s_mag = $arr[$id_org_e][1]['mag'];

            $org_info->s_m_b_bak = $arr[$id_org_e][2]['bak'];
            $org_info->s_m_b_spec = $arr[$id_org_e][2]['spec'];
            $org_info->s_m_b_mag = $arr[$id_org_e][2]['mag'];

            $org_info->s_p_u_bak = $arr[$id_org_e][3]['bak'];
            $org_info->s_p_u_spec = $arr[$id_org_e][3]['spec'];
            $org_info->s_p_u_mag = $arr[$id_org_e][3]['mag'];

            $org_info->save(false);
        }

        fclose($csv);


        $csvP = Yii::getAlias('@webroot') . "/in.csv";
        $csv = fopen($csvP, 'r');

        $arr = [];

        while (($row = fgetcsv($csv, 60000, ';')) != false) {
            $arr[$row[$org]][0]['bak'] = $arr[$row[$org]][0]['bak'] ?? 0;
            $arr[$row[$org]][1]['bak'] = $arr[$row[$org]][1]['bak'] ?? 0;
            $arr[$row[$org]][2]['bak'] = $arr[$row[$org]][2]['bak'] ?? 0;
            $arr[$row[$org]][3]['bak'] = $arr[$row[$org]][3]['bak'] ?? 0;

            $arr[$row[$org]][0]['spec'] = $arr[$row[$org]][0]['spec'] ?? 0;
            $arr[$row[$org]][1]['spec'] = $arr[$row[$org]][1]['spec'] ?? 0;
            $arr[$row[$org]][2]['spec'] = $arr[$row[$org]][2]['spec'] ?? 0;
            $arr[$row[$org]][3]['spec'] = $arr[$row[$org]][3]['spec'] ?? 0;

            $arr[$row[$org]][0]['mag'] = $arr[$row[$org]][0]['mag'] ?? 0;
            $arr[$row[$org]][1]['mag'] = $arr[$row[$org]][1]['mag'] ?? 0;
            $arr[$row[$org]][2]['mag'] = $arr[$row[$org]][2]['mag'] ?? 0;
            $arr[$row[$org]][3]['mag'] = $arr[$row[$org]][3]['mag'] ?? 0;

            $arr[$row[$org]][0]['bak'] = $arr[$row[$org]][0]['bak'] + $row[$g10];
            $arr[$row[$org]][1]['bak'] = $arr[$row[$org]][1]['bak'] + $row[$g11];
            $arr[$row[$org]][2]['bak'] = $arr[$row[$org]][2]['bak'] + $row[$g12];
            $arr[$row[$org]][3]['bak'] = $arr[$row[$org]][3]['bak'] + $row[$g13];


            $arr[$row[$org]][0]['spec'] = $arr[$row[$org]][0]['spec'] + $row[$g25];
            $arr[$row[$org]][1]['spec'] = $arr[$row[$org]][1]['spec'] + $row[$g26];
            $arr[$row[$org]][2]['spec'] = $arr[$row[$org]][2]['spec'] + $row[$g27];
            $arr[$row[$org]][3]['spec'] = $arr[$row[$org]][3]['spec'] + $row[$g28];

            $arr[$row[$org]][0]['mag'] = $arr[$row[$org]][0]['mag'] + $row[$g40];
            $arr[$row[$org]][1]['mag'] = $arr[$row[$org]][1]['mag'] + $row[$g41];
            $arr[$row[$org]][2]['mag'] = $arr[$row[$org]][2]['mag'] + $row[$g42];
            $arr[$row[$org]][3]['mag'] = $arr[$row[$org]][3]['mag'] + $row[$g43];
        }

        foreach ($arr as $id_org_e => $item) {

            if (!isset($orgs[$id_org_e])) {
                continue;
            }

            $org_info = OrgInfo::findOne(['stud_type' => 1, 'id_org' => $orgs[$id_org_e]]) ?? new OrgInfo();
            if ($org_info->isNewRecord) {
                $org_info->id_org = $orgs[$id_org_e];
                $org_info->stud_type = 1;
            }
            $org_info->s_f_b_bak = $arr[$id_org_e][0]['bak'];
            $org_info->s_f_b_spec = $arr[$id_org_e][0]['spec'];
            $org_info->s_f_b_mag = $arr[$id_org_e][0]['mag'];

            $org_info->s_b_s_bak = $arr[$id_org_e][1]['bak'];
            $org_info->s_b_s_spec = $arr[$id_org_e][1]['spec'];
            $org_info->s_b_s_mag = $arr[$id_org_e][1]['mag'];

            $org_info->s_m_b_bak = $arr[$id_org_e][2]['bak'];
            $org_info->s_m_b_spec = $arr[$id_org_e][2]['spec'];
            $org_info->s_m_b_mag = $arr[$id_org_e][2]['mag'];

            $org_info->s_p_u_bak = $arr[$id_org_e][3]['bak'];
            $org_info->s_p_u_spec = $arr[$id_org_e][3]['spec'];
            $org_info->s_p_u_mag = $arr[$id_org_e][3]['mag'];

            $org_info->save(false);
        }
    }
}
