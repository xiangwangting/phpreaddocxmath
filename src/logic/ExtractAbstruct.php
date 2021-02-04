<?php


namespace phpreaddocxmath\src\logic;


/**
 * Interface ExtractInterface
 * @package PHPReadDocx\src\logic
 */
abstract class ExtractAbstruct
{

    /**
     * @var string
     */
    protected $grep = '';

    /**
     * @var string
     */
    protected $pre_tag = '';
    /**
     * @var string
     */
    protected $end_tag = '';

    /**
     * @var string
     */
    protected $pre_index = '';
    /**
     * @var string
     */
    protected $end_index = '';

    /**
     * @var
     */
    protected $xml;

    /**
     * @var DocxService
     */
    protected $docxService;

    /**
     * ExtractAbstract constructor.
     * @param $xml
     */
    public function __construct($xml,DocxService $docxService)
    {
        $this->xml = $xml;
        $this->docxService = $docxService;
    }

    /**
     * @return mixed
     */
    public function handel()
    {
        if(!$this->grep){
            return $this->xml;
        }
        preg_match_all($this->grep, $this->xml, $arr);
        foreach ($arr[0] as $v) {
            $text = trim(strip_tags($v));
            if($text){
                $this->xml     = str_replace($v, $this->pre_index.$text.$this->end_index, $this->xml);
            }else{
                $this->xml     = str_replace($v, '', $this->xml);
            }
        }
        return $this->xml;
    }

    /**
     * @param $string
     * @return string|string[]
     */
    public function handelOver($string){
        if(strstr($string,$this->pre_index) === false &&  strstr($string,$this->end_tag) === false){
            return $string;
        }
        $this->pre_index and $string = str_replace($this->pre_index, $this->pre_tag, $string);
        $this->end_index and $string = str_replace($this->end_index, $this->end_tag, $string);
        return $string;
    }


}