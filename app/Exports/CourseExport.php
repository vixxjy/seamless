<?php

namespace App\Exports;

use App\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CourseExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Course::select('text','note','lecturer','code', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'Text',
            'Note',
            'Lecturer',
            'Course Code',
            'Created At',
        ];
    }
}
