<?php

namespace App\Exports;

use Generator;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromGenerator;

class DataExport implements FromArray
{
    use Exportable;

    protected array $posts;

    public function __construct(array $posts)
    {
        $this->posts = $posts;
    }

    public function array(): array
    {
        return $this->posts;
    }
}
