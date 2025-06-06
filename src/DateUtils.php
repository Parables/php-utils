<?php

namespace Parables\Utils;

trait DateUtils
{
  public static function excelDateToPhpDate(int|null $excelDate = null): ?string
  {
    if (empty($excelDate)) {
      return null;
    }

    $phpDate = $excelDate - 25569;  // to offset to Unix epoch

    return date(format: 'Y-m-d', timestamp: strtotime("+$phpDate days", mktime(0, 0, 0, 1, 1, 1970)));
  }
}
