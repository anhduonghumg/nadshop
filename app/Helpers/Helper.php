<?php

function currentcyFormat($val, $unit = "đ")
{
    $result = number_format($val, 0, '', '.') . $unit;
    return $result;
}

function formatDateToDMY($val)
{
    $result = date('d/m/Y H:i', strtotime($val));
    return $result;
}
