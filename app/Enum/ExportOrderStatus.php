<?php

namespace App\Enum;

enum ExportOrderStatus: string
{
    case Pending = 'pending';
    case PdfSuccess = 'pdf_success';
    case PdfFailed = 'pdf_failed';
    case ExcelSuccess = 'csv_success';
    case ExcelFailed = 'csv_failed';
    case Success = 'success';
    case Failed = 'failed';
}
