<?php


namespace phpreaddocxmath\src\logic\Extract;


use phpreaddocxmath\src\logic\ExtractAbstruct;

/**
 * Class PopExtract 下标转换
 * @package PHPReadDocx\src\logic\Extract
 */
class SubExtract extends ExtractAbstruct
{
    /**
     *
     * @var string
     */
    protected $grep = '/<w:vertAlign w:val="subscript".*?w:r>/';

    /**
     * @var string
     */
    protected $pre_index = '[subtag]';
    /**
     * @var string
     */
    protected $end_index = '[/subtag]';

    /**
     * @var string
     */
    protected $pre_tag = '<sub>';

    /**
     * @var string
     */
    protected $end_tag = '</sub>';

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
            $string_after = str_replace('<w:t>'.$text.'</w:t>',$this->pre_index.$text.$this->end_index,$v);
            if($text){
                $this->xml     = str_replace($v, $string_after, $this->xml);
            }
        }
        return $this->xml;
    }
}