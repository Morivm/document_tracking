<?php

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();

$st_merge_color = [
    'font' => [
        'bold' => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size'  => 11,
        'name'  => 'Arial'
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '0070C0',
        ],
    ],
];



$spreadsheet->getActiveSheet()->setCellValue('A1', 'BARCODE')->mergeCells("A1:A1");
$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($st_merge_color);
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);


$stmt1 = $conn->prepare("SELECT 
                            (@cnt := @cnt + 1) AS `NO`,
                            a.badgenumber AS `ID NO`,
                            CONCAT(a.client_name,' - ',a.areaname) AS `CLIENT / HUB`,
                            get_fullname_woutbadge(a.badgenumber) AS `NAME OF EMPLOYEE`,
                            b.`fst_latehr` AS `LATES`,
                            a.noofdaysbasicpay AS `REGULAR NO OF DAYS`,
                            b.rateperday AS `RATE/DAY`,
                            a.total_basicpay AS `AMOUNT`,
                            a.ot_hrs AS `OT # of hrs`,
                            a.ot_rate AS `OT Rate`,
                            a.ot_total AS `OT Amount`,
                            b.fst_legal_holiday_hrs AS `Legal Holiday Hrs`,
                            b.fst_legal_holiday_rate AS `Legal Holiday Rate`,
                            b.fst_legal_holiday_amount AS `Legal Holiday Amount`,
                            b.fst_legal_holiday_200 AS `Special Holiday Hrs`,
                            b.fst_legal_holiday_200rate AS `Special Holiday Rate`,
                            b.fst_legal_holiday_200amount AS `Special Holiday Amount`,
                            '-' AS `Cola`,
                            b.fst_nd_hrs AS `ND Hrs`,
                            a.nd_total AS `ND Amount`,
                            SUM(a.gas) AS `Gas`,
                            SUM(a.motor) AS `Motor`,
                            SUM(a.load_allow) AS `CP LOAD`,
                            SUM('') AS `ADJ SALARY`,
                            SUM(a.total_basicpay + a.ot_total + b.fst_legal_holiday_amount + b.fst_legal_holiday_200amount + nd_total + a.gas + a.motor + a.load_allow) AS `GROSS PAY`,
                            b.fst_retirementpay AS `RETIREMENT PAY`
                        FROM
                            payroll_yeartodatefigures a
                        LEFT JOIN 
                            payroll_new_attendance b ON b.`badgenumber` = a.`badgenumber`
                        CROSS JOIN (SELECT @cnt := 0) AS dummy
                        WHERE 
                            a.attendance_end BETWEEN '$datefrom' AND '$dateto'
                            $client_name
                            $hub
                            $agency
                        GROUP BY a.badgenumber
                        ORDER BY  a.ID ASC");

$stmt1->execute();
$count1 = $stmt1->rowCount();


$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode("Payroll_InternaL_".time().".xls").'"');

$writer->save('php://output');


?>