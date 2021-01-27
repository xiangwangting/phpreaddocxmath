<?php

namespace PHPReadDocx\src\logic;

/**
 * Class DocxService
 * @package PHPReadDocx\src\logic
 */
class DocxService
{

    /**
     * 临时文件路径
     * @var
     */
    private $temp_patch;
    /**
     * @var
     */
    private $name = [];

    /**
     * @var \ZipArchive
     */
    private $docx;

    /**
     * @var \DOMDocument
     */
    private $domDocument;

    /**
     * @var
     */
    private $document;

    /**
     * @var array
     */
    public $docx_data_arr = [];

    /**
     * DocxService constructor.
     */
    public function __construct()
    {
        $this->docx = new \ZipArchive();
    }

    /**
     * @return
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @return mixed
     */
    public function getTempPatch()
    {
        return $this->temp_patch;
    }

    /**
     * @return \ZipArchive
     */
    public function getDoxc(): \ZipArchive
    {
        return $this->docx;
    }

    /**
     * @param $file_url
     * @throws \Exception
     */
    public function readFile($file_url)
    {
        $temp_file        = file_get_contents($file_url);
        $this->temp_patch = md5($temp_file);
        if (!is_dir('../temp/' . $this->temp_patch)) {
            mkdir('../temp/' . $this->temp_patch);//创建临时文件夹
        }
        $tmp_file_name = '../temp/' . $this->temp_patch . '/' . $this->temp_patch . '.docx';
        $myfile        = fopen($tmp_file_name, 'w');
        fwrite($myfile, $temp_file);
        fclose($myfile);
        $this->docx = new \ZipArchive();
        $ret        = $this->docx->open($tmp_file_name);
        if ($ret === true) {
            $this->document = $this->docx->getFromName('word/document.xml');
            $url            = '../temp/' . $this->temp_patch . '/media';
            for ($i = 0; $i < $this->docx->numFiles; $i++) {
                $f = $this->docx->getNameIndex($i);
                if (stripos($f, 'word/media/') !== false) {
                    $this->docx->extractTo($url, $f);
                    $this->img_dir = $url;
                    $this->name[]  = $f;
                }
            }
            $this->domDocument = new \DomDocument();
            $this->domDocument->loadXML($this->document);
        } else {
            throw new \Exception('open file error:' . $file_url);
        }
    }

    /**
     *
     */
    public function load()
    {
        $bodyNode = $this->domDocument->getElementsByTagNameNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'body'
        );
        //We get the body node. it is known that there is only one body tag
        $bodyNode = $bodyNode->item(0);
        /**@var \DOMElement $child */
        foreach ($bodyNode->childNodes as $child) {
            $this->docx_data_arr[] = $this->toText($child);
        }
        return $this->docx_data_arr;
    }

    /**
     * @param $node
     * @return mixed
     */
    private function toText($node)
    {
        $xml = $node->ownerDocument->saveXML($node);
        return $xml;
    }

    /**
     *
     */
    public function delTempFile()
    {
        $this->rm_dir('../temp/' . $this->temp_patch);
    }

    /**
     * 删除临时文件夹
     * @param $dir
     */
    private function rm_dir($dir)
    {
        if ($handle = opendir($dir)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {
                    if (is_dir("$dir/$item")) {
                        $this->rm_dir("$dir/$item");
                    } else {
                        unlink("$dir/$item");
                    }
                }
            }
            closedir($handle);
            rmdir($dir);
        }
    }

}