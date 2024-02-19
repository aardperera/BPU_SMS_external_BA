<?php
// Include the file that loads the PhpSpreadsheet classes
require 'spreadsheet/vendor/autoload.php';

// Include the classes needed to create and write .xlsx file
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Export
{
    function __construct()
    {
        ;
    }

    public function exportExcel($values, $columns, $properties)
    {
        // Object of the Spreadsheet class to create the Excel data
        $spreadsheet = new Spreadsheet();

        // Set Sinhala font
       // $spreadsheet->getActiveSheet()->getStyle('F2')->getFont()->setName('Iskoola Pota');

        $titles = $properties['titles'];
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
      
        // Add some data in Excel cells
        foreach ($titles as $key => $column) {
            // Set column title
            $spreadsheet->getActiveSheet()->setCellValue($this->getCode($key + 1) . '1', $column['name']);
            // Set columns width
            $spreadsheet->getActiveSheet()->getColumnDimension($this->getCode($key + 1))->setWidth($column['width']);
            // Set format
            $spreadsheet->getActiveSheet()
                ->getStyle($this->getCode($key + 1))
                ->getNumberFormat()
                ->setFormatCode($column['type']);
            // Set alignment
            $spreadsheet->getActiveSheet()
                ->getStyle($this->getCode($key + 1))
                ->getAlignment()
                ->setHorizontal($column['algn']);
        }

        $spreadsheet->getActiveSheet()
            ->getStyle('A1:' . $this->getCode(count($columns)) . '1')
            ->getAlignment()
            ->setWrapText(true);

        // Set style for A1,B1,C1 cells
        $cell_st = [
            'font' => ['bold' => true],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => ['bottom' => ['style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
        ];
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $this->getCode(count($columns)) . '1')->applyFromArray($cell_st);

        $rowCount = 2;
        if (!empty($values)) {
            foreach ($values as $key => $value) {
                foreach ($columns as $key1 => $value1) {
                    // Explicitly set cell value as a string and encode in UTF-8
                    $spreadsheet->getActiveSheet()->setCellValueExplicit($this->getCode($key1 + 1) . $rowCount, utf8_encode($value[$value1]), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);

                    if (isset($value['colour'])) {
                        $spreadsheet->getActiveSheet()->getStyle($this->getCode($key1 + 1) . $rowCount)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB($value['colour']);
                    }
                }
                $rowCount++;
            }
            $spreadsheet->getActiveSheet()
                ->getStyle('A2:' . $this->getCode(count($columns)) . ($rowCount - 1))
                ->getAlignment()
                ->setWrapText(true);

            $cell_st_row = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ]
            ];
            $spreadsheet->getActiveSheet()->getStyle('A2:' . $this->getCode(count($columns)) . ($rowCount - 1))->applyFromArray($cell_st_row);

            $spreadsheet->getActiveSheet()
                ->getRowDimension($rowCount)
                ->setRowHeight(-1);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        header('Content-Type: text/xls');
        $fileName = $properties['filename'] . date("Y-m-d h:i:sa") . '.xls';
        $headerContent = 'Content-Disposition: attachment;filename="' . $fileName . '"';
        header($headerContent);
        $writer->save('php://output');
    }

    public function getCode($col)
    {
        // 64+1 = 65 ==>> "A"
        $letter = '';
        if ($col <= 26) {
            $letter = chr(64 + $col);
        } else {
            $newCol = intdiv($col, 26);
            $resCol = ($col % 26);
            $letter = $this->getCode($newCol) . chr(64 + $resCol);
        }
        return $letter;
    }
}
?>
