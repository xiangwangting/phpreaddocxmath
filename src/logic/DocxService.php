<?php

namespace phpreaddocxmath\src\logic;

/**
 * Class DocxService
 * @package PHPReadDocx\src\logic
 */
class DocxService
{
    /**
     * @var string
     */
    private $diy_tmp_patch;
    /**
     * 临时文件夹名字
     * @var
     */
    private $temp_patch_name;
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
     * @param string $diy_tmp_patch
     */
    public function __construct($diy_tmp_patch = 'tmp')
    {
        $this->diy_tmp_patch = $diy_tmp_patch;
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
    public function getTempPatchName()
    {
        return $this->temp_patch_name;
    }

    /**
     * @return \ZipArchive
     */
    public function getDoxc(): \ZipArchive
    {
        return $this->docx;
    }

    /**
     * @return string
     */
    public function getDiyTmpPatch(){
        return $this->diy_tmp_patch;
    }

    /**
     * @param $file_url
     * @throws \Exception
     */
    public function readFile($file_url)
    {
        $temp_file             = file_get_contents($file_url);
        $this->temp_patch_name = md5($temp_file);
        if (!is_dir($this->diy_tmp_patch.'/' . $this->temp_patch_name)) {
            mkdir($this->diy_tmp_patch.'/' . $this->temp_patch_name,0777,true);//创建临时文件夹
        }
        $tmp_file_name = $this->diy_tmp_patch.'/' . $this->temp_patch_name . '/' . $this->temp_patch_name . '.docx';
        $myfile        = fopen($tmp_file_name, 'w');
        fwrite($myfile, $temp_file);
        fclose($myfile);
        $this->docx = new \ZipArchive();
        $ret        = $this->docx->open($tmp_file_name);
        if ($ret === true) {
            $this->document = $this->docx->getFromName('word/document.xml');
            $url            = $this->diy_tmp_patch.'/' . $this->temp_patch_name . '/media';
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
        $this->rm_dir($this->diy_tmp_patch.'/' . $this->temp_patch_name);
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