<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToArray;


class DataImport implements ToArray
{
    use Importable;

    public function array(array $array): array
    {
        return $array;
    }
}
