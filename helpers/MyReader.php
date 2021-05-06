<?php


namespace app\helpers;

class MyReader implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    public function readCell($column, $row, $worksheetName = ''): bool
    {

        //dd($column,$row,$worksheetName);

        //  Only read the heading row, and the configured rows
        if (($row == 1)) {
            return true;
        }
        return false;
    }
}
