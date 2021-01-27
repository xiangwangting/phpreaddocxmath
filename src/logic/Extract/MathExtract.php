<?php


namespace PHPReadDocx\src\logic\Extract;


use PHPReadDocx\src\logic\DocxService;
use PHPReadDocx\src\logic\ExtractAbstruct;

/**
 * Class MathExtract 公式转换
 * @package PHPReadDocx\src\logic\Extract
 */
class MathExtract extends ExtractAbstruct
{
    /**
     * @var
     */
    private $xml_document;

    /**
     * @var array
     */
    protected $mml_arr = [];

    /**
     * MatchExtract constructor.
     * @param $xml
     * @param DocxService $docxService
     */
    public function __construct($xml, DocxService $docxService)
    {
        parent::__construct($xml, $docxService);
        $xml_document_weizhi = stripos($docxService->getDocument(), '<w:body>');
        $this->xml_document  = substr($docxService->getDocument(), 0, $xml_document_weizhi);
        $this->xml           = preg_replace_callback(
            '/(<m:oMath>)([\s\S]*?)(<\/m:oMath>)/',
            function ($matches) {
                $mml         = $this->xml_document . '<w:body><m:oMathPara>' . $matches[0] . '</m:oMathPara></w:body></w:document>';
                $domDocument = new \DomDocument();
                $domDocument->loadXML($mml);
                $numberings = $domDocument->getElementsByTagNameNS(
                    'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                    'body'
                );
                $numberings = $numberings->item(0);
                $xsl        = new \DOMDocument();
                $xsl->load(__DIR__ . '/OMML2MML.XSL');
                $processor = new \XSLTProcessor();
                $processor->importStyleSheet($xsl);
                $omml                = $processor->transformToXML($numberings);
                $omml                = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $omml);
                $omml                = str_replace(
                    'xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"',
                    '',
                    $omml
                );
                $omml                = str_replace("mml:", '', $omml);
                $omml                = str_replace("\n", '', $omml);
                $num                 = count($this->mml_arr);
                $this->mml_arr[$num] = $omml;
                return 'mosoteach_math_xml' . $num;
            },
            $this->xml
        );
    }

    /**
     * 重写公式转换
     * @return mixed|void
     */
    public function handel()
    {
        if (!$this->mml_arr) {
            return $this->xml;
        };
        $this->xml = trim(strip_tags($this->xml));
        return $this->xml;
    }

    /**
     * @param $string
     * @return string|string[]
     */
    public function handelOverDiy($string)
    {
        if(!$this->mml_arr){
            return $string;
        }
        foreach ($this->mml_arr as $key => $value) {
            $str       = 'mosoteach_math_xml' . $key;
            $string = str_replace($str, $value, $string);
        }
        return $string;
    }
}