<?php
namespace app\library;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Excel
{
    protected $title = '导出数据';
    protected $header = [];

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    public function write($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheetIndex = $spreadsheet->setActiveSheetIndex(0);
        $rowIndex = 1;
        $colIndex = 'A';
        foreach ($this->header as $header) {
            $sheetIndex->setCellValue($colIndex . $rowIndex, $header['title']);
            if (isset($header['format'])) {
                $format = self::format($header['format']);
                $spreadsheet->getActiveSheet()->getStyle($colIndex)->getNumberFormat()->setFormatCode($format);
            }
            $colIndex++;
        }
        $rowIndex++;
        foreach ($data as $row) {
            $colIndex = 'A';
            foreach ($this->header as $key => $header) {
                $sheetIndex->setCellValue($colIndex . $rowIndex, $row[$key]);
                $colIndex++;
            }
            $rowIndex++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $this->title . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    private static function format($type)
    {
        switch ($type) {
            case 'number':
                return NumberFormat::FORMAT_NUMBER;
                break;

            default:
                return NumberFormat::FORMAT_GENERAL;
                break;
        }
    }
}
