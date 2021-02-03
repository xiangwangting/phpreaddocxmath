<?php


namespace phpreaddocxmath\src\logic\Extract;


use phpreaddocxmath\src\logic\ExtractAbstruct;

/**
 * Class TableExtract 表格转换
 * @package PHPReadDocx\src\logic\Extract
 */
class TableExtract extends ExtractAbstruct
{
    /**
     * @var string
     */
    protected $grep = '/<w:tbl.*?:tbl>/';

    /**
     * @var string
     */
    protected $tr_grep = '/<w:tr.*?w:tr>/';
    /**
     * @var string
     */
    protected $td_grep = '/<w:tc>.*?w:tc>/';

    /**
     * @var string
     */
    private $table_pre = '[表格]';
    /**
     * @var string
     */
    private $table_end = '[/表格]';
    /**
     * @var string
     */
    private $tr_pre = '[行]';
    /**
     * @var string
     */
    private $tr_end = '[/行]';
    /**
     * @var string
     */
    private $td_pre = '[列]';
    /**
     * @var string
     */
    private $td_end = '[/列]';

    /**
     * 重写公式转换
     * @return mixed|void
     */
    public function handel()
    {
        preg_match_all($this->grep, $this->xml, $arr);
        foreach ($arr[0] as $v) {
            $tmp = $this->table_pre.$v.$this->table_end ;
            $tmp = $this->matchTd($tmp);
            $tmp = $this->matchTr($tmp);
            $tmp = trim(strip_tags($tmp));
            if($tmp){
                $this->xml     = str_replace($v, $this->pre_index.$tmp.$this->end_index, $this->xml);
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
        $string = str_replace($this->table_pre, '<table style="text-align: center; border-collapse: collapse;">', $string);
        $string = str_replace($this->table_end, '</table>', $string);
        $string = str_replace($this->tr_pre, '<tr>', $string);
        $string = str_replace($this->tr_end, '</tr>', $string);
        $string = str_replace($this->td_pre, '<td style="border:1px solid black;padding: 2px;">', $string);
        $string = str_replace($this->td_end, '</td>', $string);
        return $string;
    }

    /**
     * @param $string
     * @return mixed
     */
    private function matchTd($string){
        preg_match_all($this->td_grep, $string, $arr);
        foreach ($arr[0] as $v) {
            $text = trim(strip_tags($v));
            if($text){
                $string     = str_replace($v, $this->td_pre.$text.$this->td_end, $string);
            }else{
                $string     = str_replace($v, '', $string);
            }
        }
        return $string;
    }

    /**
     * @param $string
     * @return mixed
     */
    private function matchTr(&$string){
        preg_match_all($this->tr_grep, $string, $arr);
        foreach ($arr[0] as $v) {
            $text = trim(strip_tags($v));
            if($text){
                $string     = str_replace($v, $this->tr_pre.$text.$this->tr_end, $string);
            }else{
                $string     = str_replace($v, '', $string);
            }
        }
        return $string;
    }
}