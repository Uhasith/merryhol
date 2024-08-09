<?php

namespace App\Exports;

use App\Models\MpBook;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BookingExport implements FromCollection, WithHeadings
{
    protected $bookings;

    public function __construct($bookings)
    {
        $this->bookings = $bookings;
    }

    /**
     * Return the collection of bookings.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->bookings);
    }

    /**
     * Return the headings for the Excel sheet.
     */
    public function headings(): array
    {
        return [
            'Product Name',
            'Airport Name',
            'Supplier Name',
            'Commission',
            'CC Fee',
            'Net Total',
        ];
    }
}
