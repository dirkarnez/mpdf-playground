<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/names/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];

    $names = array("Peter", "Paul", "Mary");
    array_push($names, $name);

    sort($names);

    $response->getBody()->write("Hello, " . json_encode($names));
    return $response;
});

$app->get("/tcpdf", function (Request $request, Response $response, array $args) {
    // create new PDF document
    $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('TCPDF Example 033');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 033', PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // add a page
    $pdf->AddPage();

    // set default font subsetting mode
    $pdf->setFontSubsetting(false);

    $pdf->SetFont('helvetica', 'B', 20);

    $pdf->Write(0, 'Font Types', '', 0, 'C', 1, 0, false, false, 0);

    $pdf->Ln(10);

    $pdf->SetFont('times', '', 10);

    $pdf->MultiCell(80, 0, "[Core font] : Cras eros leo, porttitor porta, accumsan fermentum, ornare ac, est. Praesent dui lorem, imperdiet at, cursus sed, facilisis aliquam, nibh. Nulla accumsan nonummy diam. Donec tempus. Etiam posuere. Proin lectus. Donec purus. Duis in sem pretium urna feugiat vehicula. Ut suscipit velit eget massa. Nam nonummy, enim commodo euismod placerat, tortor elit tempus lectus, quis suscipit metus lorem blandit turpis.\n", 1, 'J', 0, 1, '', '', true, 0);

    $pdf->Ln(2);

    $pdf->SetFont('dejavusans', '', 10);

    $pdf->MultiCell(80, 0, "[True Type Unicode font] : Cras eros leo, porttitor porta, accumsan fermentum, ornare ac, est. Praesent dui lorem, imperdiet at, cursus sed, facilisis aliquam, nibh. Nulla accumsan nonummy diam. Donec tempus. Etiam posuere. Proin lectus. Donec purus. Duis in sem pretium urna feugiat vehicula. Ut suscipit velit eget massa. Nam nonummy, enim commodo euismod placerat, tortor elit tempus lectus, quis suscipit metus lorem blandit turpis.\n", 1, 'J', 0, 1, '', '', true, 0);

    $pdf->Ln(2);

    $pdf->SetFont('cid0jp', '', 9);

    $pdf->MultiCell(80, 0, "[CID-0 font] : 繁體中文 简体中文 Cras eros leo, porttitor porta, accumsan fermentum, ornare ac, est. Praesent dui lorem, imperdiet at, cursus sed, facilisis aliquam, nibh. Nulla accumsan nonummy diam. Donec tempus. Etiam posuere. Proin lectus. Donec purus. Duis in sem pretium urna feugiat vehicula. Ut suscipit velit eget massa. Nam nonummy, enim commodo euismod placerat, tortor elit tempus lectus, quis suscipit metus lorem blandit turpis.\n", 1, 'J', 0, 1, '', '', true, 0);

    $pdf->Ln(2);
    // ---------------------------------------------------------

    //Close and output PDF document
    $pdf->Output('example_033.pdf', 'I');

    return $response;

    // $response->getBody()->write($a);
    // return $response;
});

$app->get("/mpdf", function (Request $request, Response $response, array $args) {
    
    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    //Create an instance of the class:
    $mpdf = new \Mpdf\Mpdf(
        [
            'fontDir' => array_merge($fontDirs, [
                __DIR__ . '/../external-fonts',
            ]),
            'fontdata' => $fontData + [
                'notoserifcjkhkvf' => [
                    'R' => 'NotoSerifCJKhk-VF.ttf'
                ],
                'mytimes' => [
                    'R' => 'times.ttf'
                ],
                'mingliu' => [
                    'R' => 'mingliu.ttc',
                    'TTCfontID' => [
                        'R' => 1,
                    ],
                    'sip-ext' => 'mingliu-extb',
                ],
                'pmingliu' => [
                    'R' => 'mingliu.ttc',
                    'TTCfontID' => [
                        'R' => 2,
                    ],
                    'sip-ext' => 'pmingliu-extb',
                ],
                'mingliu_hkscs' => [
                    'R' => 'mingliu.ttc',
                    'TTCfontID' => [
                        'R' => 3,
                    ],
                    'sip-ext' => 'mingliu_hkscs-extb',
                ],
                'mingliu-extb' => [
                    'R' => 'mingliub.ttc',
                    'TTCfontID' => [
                        'R' => 1,
                    ],
                ],
                'pmingliu-extb' => [
                    'R' => 'mingliub.ttc',
                    'TTCfontID' => [
                        'R' => 2,
                    ],
                ],
                'mingliu_hkscs-extb' => [
                    'R' => 'mingliub.ttc',
                    'TTCfontID' => [
                        'R' => 3,
                    ],
                ],
            ],
            'default_font' => 'notoserifcjkhkvf'
        ]
    );

    // "Fonts with postscript outlines are not supported"
    // $mpdf = new \Mpdf\Mpdf([
    //     'fontDir' => array_merge($fontDirs, [
    //         __DIR__ . '/../external-fonts/NotoSerifTC',
    //     ]),
    //     'fontdata' => $fontData + [
    //         'notoseriftc' => [
    //             'R' => 'NotoSerifTC-Regular.otf'
    //         ]
    //     ],
    //     'default_font' => 'notoseriftc'
    // ]);
    
    // $stylesheet = "body { color: red; }";

    // $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
    // $mpdf->WriteHTML('Hello World 中文',\Mpdf\HTMLParserMode::HTML_BODY);

    $mpdf->AddPage();
    $mpdf->SetFont('notoserifcjkhkvf','', 14);
    $mpdf->MultiCell(0, 8, '[NotoSerifCJKhk-VF.ttf] Hello World 繁體中文 简体中文');
    $mpdf->MultiCell(0, 8, '');
    
    $mpdf->SetFont('mingliu','', 14);
    $mpdf->MultiCell(0, 8, '[新細明體] Hello World 繁體中文 简体中文');
    $mpdf->MultiCell(0, 8, '');
    
    $mpdf->SetFont('mytimes','', 14);
    $mpdf->MultiCell(0, 8, '[Times New Roman] Hello World');

    // Output a PDF file directly to the browser
    $mpdf->Output();

    return $response;
});

$app->run();

?>

