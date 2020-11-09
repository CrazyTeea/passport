<?php

function cntObj($org)
{

}

function cntLiving($items, $inos = false, $inv = false)
{
    $cnt = 0;

    foreach ($items as $item) {
        foreach ($item as $key => $val) {
            if ($key == 'id' or
                $key == 'id_org' or
                $key == 'id_living' or
                $key == 'budjet_type' or
                $key == 'invalid' or $key == 'type')
                continue;
            if ($item->$key)
                if (!$inos and !$inv and !$item->invalid and in_array($item->type, ['rf_och', 'rf_zaoch', 'rf_ochzaoch']))
                    $cnt++;
                else if ($inos and !$inv and !$item->invalid)
                    $cnt++;
                else if ($item->invalid and $inv and $inos)
                    $cnt++;
        }
    }
    return $cnt;
}

function cnt($info)
{
    $cnt = 0;
    if ($info) {
        if (is_array($info))
            foreach ($info as $item) {
                foreach ($item as $key => $val) {

                    if ($key == 'id' or
                        $key == 'id_org' or
                        $key == 'stud_type')
                        continue;
                    if ($item->$key)
                        $cnt++;
                }
            }
        else {
            foreach ($info as $key => $val) {

                if ($key == 'id' or
                    $key == 'id_org' or
                    $key == 'stud_type')
                    continue;
                if ($info->$key)
                    $cnt++;
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
        <td>Субъект</td>
        <td>Фоив</td>
        <td>Количество заполненных полей в части информации об организации</td>
        <td>% заполненных полей в части информации об организации</td>
        <td>Количество внесённых стран в информации о проживающих</td>
        <td>Количество заполненных полей в информации о проживающих за исключением проживающих иностранцев и лиц с
            органиченными возможностями
        </td>
        <td>% заполненных полей в информации о проживающих за исключением проживающих иностранцев и лиц с органиченными
            возможностями
        </td>
        <td>Количество заполненных полей в информации о проживающих с ограниченными возможностями</td>
        <td>% заполненных полей в информации о проживающих с ограниченными возможностями</td>
        <td>Общее количество жилых объектов по данным Системы</td>
        <td>Количество жилых объектов у которых нажата кнопка "сохранить"</td>
        <td>% жилых объектов у которых нажата кнопка "сохранить"</td>

        <td>Суммарное количество прикреплённых файлов</td>
        <td>Внесение данных завершено</td>
        <td>Комментарии по заполненным общежитиям</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($orgs as $org): ?>
        <?php
        $cnt_r_objs = array_reduce($r_objs, function ($a, $b) use ($org) {
            if ($b['id_org'] == $org->id)
                $a++;
            $a += 0;
            return $a;
        }, 0);
        $cnt_objs = count($org->objs);

        if ($cnt_objs or $cnt_r_objs):?>
            <tr>
                <td><?= htmlspecialchars($org->id) ?></td>
                <td><?= htmlspecialchars($org->name) ?></td>
                <td><?= htmlspecialchars($org->region->region) ?></td>
                <td><?= htmlspecialchars($org->founder->founder) ?></td>
                <td><?= $cnt = cnt($org->info) + cnt($org->area) ?></td>
                <td><?= round($cnt * 100 / 72) ?>%</td>
                <td><?= \app\models\OrgLivingStudents::find()->where(['id_org' => $org->id])->andWhere(['is not', 'name', null])->groupBy('name')->count() ?></td>
                <td><?= $cnt = cntLiving($org->livingStudents) ?></td>
                <td><?= round($cnt * 100 / 84) ?>%</td>
                <td><?= $cnt = cntLiving($org->livingStudents, true, true) ?></td>
                <td><?= round($cnt * 100 / 168) ?>%</td>
                <td><?= $cnt_r_objs ?></td>
                <td><?= $cnt_objs ?></td>
                <td><?= $cnt_r_objs ? round($cnt_objs * 100 / $cnt_r_objs) : 0 ?>%</td>
                <td><?= count($org->orgDocs) ?></td>
                <td>NET</td>
                <td>AZAZAZAAZAZAZAZA!</td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
</table>
