<?php

namespace phpreaddocxmath\src;


use phpreaddocxmath\src\ImageDiyHandelInterface;
use phpreaddocxmath\src\logic\DocxService;
use phpreaddocxmath\src\logic\Extract\ImgExtract;
use phpreaddocxmath\src\logic\Extract\MathExtract;
use phpreaddocxmath\src\logic\ExtractAbstruct;

/**
 * 读取dock服务
 * Class ReadDocxService
 * @package ReadDocxService
 */
class ReadDocxService
{
    /**
     * @var
     */
    private $file_url;

    /**
     * 临时文件存放路径
     * @var string
     */
    protected $tmp_patch = '';

    /**
     * @var DocxService;
     */
    private $docxService;

    /**
     * @var array
     */
    private $docx_arr = [];

    /**
     * @var
     */
    private $img_handel_class;

    /**
     * ReadDocxService constructor.
     */
    public function __construct($tmp_patch = '/tmp')
    {
        $this->docxService = new DocxService($tmp_patch);
    }

    /**
     * @param $file_url
     * @return $this
     * @throws \Exception
     */
    public function setFileUrl($file_url)
    {
        $this->file_url = trim($file_url);
        if (!@fopen($this->file_url, 'r')) {
            throw new \Exception('file is not exists:' . $file_url);
        }
        $this->docxService->readFile($file_url);
        return $this;
    }

    /**
     * 转换文档成html数据
     * @param string $filename 文件名称，如果为空，则不创建文件
     * @return array
     * @throws \Exception
     */
    public function extractToHtml($filename = '')
    {
        if (!$this->file_url) {
            throw new \Exception('file_url is required');
        }
        $this->docxService->load();
        foreach ($this->docxService->docx_data_arr as $xml) {
            $this->docx_arr [] = '<div>' . $this->getHtmlString($xml) . '</div>';
        }
        $this->docxService->delTempFile();
        if ($filename) {
            $docx = '';
            foreach ($this->docx_arr as $docx_string) {
                $docx .= $docx_string;
            }
            $filename = str_replace('.html', '', $filename);
            $html     = '
                        <html>
                        <head>
                            <title></title>
                            <meta http-equiv="content-type" content="text/html;charset=utf-8">
                            <script type="text/javascript" src="../src/tiny_mce_wiris/integration/WIRISplugins.js?viewer=image"></script>
                        </head>
                        <body>
                            ' . $docx . '
                        </body>
                        </html>
                    ';
            $filename = $filename . '.html';
            $myfile   = fopen($filename, 'w');
            fwrite($myfile, $html);
            fclose($myfile);
            return $this->docx_arr;
        }
        return $this->docx_arr;
    }

    /**
     * @param $xml
     * @return mixed
     */
    private function getHtmlString($xml)
    {
        $math = '';
        /**@var ExtractAbstruct $class */
        foreach (ExtractConfig::CONFIG as $class) {
            $class = new $class($xml, $this->docxService);
            if ($class instanceof MathExtract) {
                $math = $class;
            }
            if ($class instanceof ImgExtract) {
                $xml = $class->handel($this->img_handel_class);
            } else {
                $xml = $class->handel();
            }
        }
        $xml = trim(strip_tags($xml));
        /**@var ExtractAbstruct $class */
        foreach (ExtractConfig::CONFIG as $class) {
            $class = new $class($xml, $this->docxService);
            $xml   = $class->handelOver($xml);
        }
        if ($math instanceof MathExtract) {
            $xml = $math->handelOverDiy($xml);
        }
        return trim($xml);
    }

    /**
     * 自定义图片处理对象，可以不设置
     * @param string $class
     * @return $this
     */
    public function setImgHandelClass($class_name = '')
    {
        if (!$class_name) {
            return $this;
        }
        $class = new $class_name();
        if (!$class instanceof ImageDiyHandelInterface) {
            throw new \Exception($class_name . ' required ImageDiyHandelInterface');
        }
        $this->img_handel_class = $class;
        return $this;
    }


}