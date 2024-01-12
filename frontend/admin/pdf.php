<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <?php
    // เริ่มคำสั่ง Export ไฟล์ PDF
    require_once __DIR__ . '/vendor/autoload.php';

    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new \Mpdf\Mpdf([
        'fontDir' => array_merge($fontDirs, [
            __DIR__ . '/tmp',
        ]),
        'fontdata' => $fontData + [
            'sarabun' => [
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNew Italic.ttf',
                'B' => 'THSarabunNew Bold.ttf',
                'BI' => 'THSarabunNew BoldItalic.ttf'
            ]
        ],
        'default_font' => 'sarabun',
        'format' => [70, 150]
    ]);
    // สิ้นสุดคำสั่ง Export ไฟล์ PDF ในส่วนบน เริ่มกำหนดตำแหน่งเริ่มต้นในการนำเนื้อหามาแสดงผลผ่าน
    $mpdf->SetFont('sarabun', '', 14);
    $mpdf->AddPageByArray([
        'margin-left' => 5,
        'margin-right' => 5,
        'margin-top' => 10,
        'margin-bottom' => 10,
    ]);
    // $mpdf->AddPage();
    ob_start();  //ฟังก์ชัน ob_start()
    
    //-------------------------------------------------------
    include('../../backend/connect_db.php');
    $idTable = $_GET['idTable'];
    $tableRe = $conn->query("SELECT * FROM tables WHERE id_table = '$idTable'");
    $table = $tableRe->fetch_assoc();
    $orderRe = $conn->query("SELECT * FROM orders WHERE id_table = '$idTable'");
    $order = $orderRe->fetch_assoc();
    $qrRe = $conn->query("SELECT * FROM qrcode WHERE id_table = '$idTable'");
    $qr = $qrRe->fetch_assoc();
    $html = '<div style="text-align: center;font-size:28px; font-weight: bold;">' .
        $table['name'] . '
</div>
<div style="text-align: center;font-size:22px; margin-top: -20px;">
    <hr>
</div>
<div style="text-align: center;font-size:22px; font-weight: bold; margin-top: -5px;">จิ้มจุ่มรั้วหลากสี</div>
<div style="text-align: center;font-size:16px; margin-top: -5px;">ถนน นครปฐม</div>
<div style="text-align: center;font-size:16px; margin-top: -5px;">โทร: 0987654321</div>
<div style="text-align: center;font-size:20px; font-weight: bold;">ใบสั่งอาหาร</div>
<div style="text-align: center;font-size:22px; margin-top: -5px;">
    <hr>
</div>
<div style="text-align: left;font-size:16px; margin-top: -5px;">
' . $table['name'] . '
</div>
<div style="text-align: left;font-size:16px;">วันที่ :
' . $order['date'] . '
</div>
<div style="text-align: left;font-size:16px;">เวลา :
    ' . $order['time'] . ' น.
</div>
<div style="text-align: left;font-size:16px;">จำนวนลูกค้า :
    ' . $order['numCustomer'] . ' คน
</div>
<div style="text-align: center;font-size:22px; margin-top: -5px;">
    <hr>
</div>
<div style="text-align: center;"><img src="images/'.$qr['qrimage'].'" style="width: 150px;"></div>
<div style="text-align: center;font-size:22px; font-weight: bold;">สแกนเพื่อสั่งอาหาร</div>'
        ?>


    <?php
    // คำสั่งการ Export ไฟล์เป็น PDF
    // $html = ob_get_contents();      // เรียกใช้ฟังก์ชัน รับข้อมูลที่จะมาแสดงผล
    $mpdf->WriteHTML($html);        // รับข้อมูลเนื้อหาที่จะแสดงผลผ่านตัวแปร $html
    $mpdf->Output();  //สร้างไฟล์ PDF ชื่อว่า myReport.pdf
    ob_end_flush();                 // ปิดการแสดงผลข้อมูลของไฟล์ HTML ณ จุดนี้
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>