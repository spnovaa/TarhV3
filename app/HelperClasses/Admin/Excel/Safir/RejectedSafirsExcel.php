<?php


namespace App\HelperClasses\Admin\Excel\Safir;


use App\Http\Controllers\Admin\ResumeController;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class RejectedSafirsExcel implements FromCollection, WithHeadings
{
    public function collection()
    {
        return (new ResumeController())->getRejectedDataComplete();
    }

    public function headings(): array
    {
        return [
            'سطر',
            'ایمیل',
            'تایید مدیریت',
            'فعال',
            'کد',
            'نام',
            'نام خانوادگی',
            'نام پدر',
            'جنسیت',
            'کدملی',
            'همراه',
            'تاریخ تولد',
            'عکس پروفایل',
            'آدرس سکونت',
            'استان',
            'شهر',
            'منطقه',
            'خیابان',
            'کوچه',
            'پلاک',
            'کدپستی',
            'محل تحصیل',
            'تحصیلات',
            'شهرتحصیل',
            'شاخه تحصیلی',
            'سابقه فروش',
            'توضیح فعالیت',
            'آخرین سه کتاب خوانده شده',
            'پیشنهادات',
            'معرف',
            'پیامرسان',
            'شماره پیامرسان',
            'اینستا',
            'ارسال رزومه',
            'پورسانت',
            'شبا',
            'ارسال گزارش',
            'نام هیئت',
            'مدیرهیئت',
            'شماره مدیرهیئت',
            'آدرس هیئت',
            'توکن فراموشی',
            'سیستمی',
            'سیستمی',
        ];
    }
}
