<?php

use app\models\Objects;
use app\models\Organizations;
use app\models\OrgDocs;
use app\models\OrgLivingStudents;
use app\models\UsersInfo;

/**
 * @var Organizations[] $orgs
 * @var Objects[] $r_objs
 */


function cnt($info): int
{
    $cnt = 0;
    if ($info) {
        if (is_array($info)) {
            foreach ($info as $item) {
                foreach ($item as $key => $val) {
                    if ($key == 'id' or $key == 'id_org' or $key == 'stud_type') {
                        continue;
                    }
                    if ($item->$key) {
                        $cnt++;
                    }
                }
            }
        } else {
            foreach ($info as $key => $val) {
                if ($key == 'id' or $key == 'id_org' or $key == 'stud_type') {
                    continue;
                }
                if ($info->$key) {
                    $cnt++;
                }
            }
        }
    }
    return $cnt;
}

?>

<table>
    <thead>
    <tr>
        <td>ID организации</td>
        <td>Организация (полное наименование организации)</td>
        <td>Дата изменения</td>
        <td>Субъект</td>
        <td>ФОИВ</td>
        <td>Количество контактных данных</td>
        <td>Заполнено полей в части информации об организации</td>
        <td>Внесено стран в информации о проживающих</td>
        <td>Общее количество жилых объектов</td>
        <td>Среднее кол-во заполененых полей по объектам</td>
        <td>Количество прикреплённых файлов</td>
    </tr>
    </thead>
    <tbody>

    <?php
    $objects = Objects::find()->where(['system_status' => 1])->asArray()->all();
    $keks = [];
    foreach ($objects as $object) {
        $keks[$object['id_org']][] = $object;
    }
    $objects = $keks;
    $keys = array_keys($objects);
    ?>

    <?php foreach ($orgs as $org): ?>

        <?php

        $cnt_r_objs = isset($objects[$org->id]) ? count($objects[$org->id]) : 0;

        $cnt2 = $cnt_r_objs > 0 ? array_reduce($objects[$org->id], function ($a, $b) {
            return $a + $b['count_pol'];
        }, 0) : 0;

        $cnt2 = $cnt_r_objs > 0 ? $cnt2 / $cnt_r_objs : 0


        ?>
        <tr>
            <td><?= htmlspecialchars($org->id) ?></td>
            <td><?= htmlspecialchars($org->name) ?></td>
            <td><?= $org->last_updated_at ?></td>
            <td><?= htmlspecialchars($org->region->region) ?></td>
            <td><?= htmlspecialchars($org->founder->founder) ?></td>
            <td><?= UsersInfo::find()
                    ->where(['id_org' => $org->id])
                    ->andWhere(['is not', 'name', null])
                    ->count() ?></td>
            <td><?= $org->count_pol ?></td>
            <td><?= OrgLivingStudents::find()
                    ->where(['id_org' => $org->id])
                    ->andWhere(['is not', 'name', null])
                    ->groupBy('name')
                    ->count() ?></td>
            <td><?= $cnt_r_objs ?></td>
            <td><?= $cnt2 ?? 0 ?></td>
            <td><?= OrgDocs::find()
                    ->where(['id_org' => $org->id])
                    ->andWhere(['is not', 'id_file', null])
                    ->count() ?></td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>