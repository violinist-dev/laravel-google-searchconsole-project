<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class CsvExport implements FromView, WithColumnFormatting
{
    use Exportable;

    /**
     * @var object
     */
    protected $rows;

    /**
     * CsvExport constructor.
     *
     * @param object $rows
     */
    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('export.csv', [
            'rows' => $this->rows,
        ]);
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'E' => '0.0',
        ];
    }
}
