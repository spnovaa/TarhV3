<?php


namespace App\HelperClasses\Admin\Excel\Shop;


use App\Http\Controllers\Admin\StatsController;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ShopsBooksSellExcel implements FromCollection, WithHeadings
{
    public function collection()
    {
        return (new StatsController())->getShopsBooksSellData();
    }

    public function headings(): array
    {
        return [
            'فروشگاه',
            'نام کتاب',
            'تعداد جلد فروش',
        ];
    }
}
