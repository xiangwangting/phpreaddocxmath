<?php


namespace phpreaddocxmath\src\logic\Extract;


use phpreaddocxmath\src\logic\ExtractAbstruct;


/**
 * 字体样式转换
 * Class FontExtract
 * @package phpreaddocxmath\src\logic\Extract
 */
class FontExtract extends ExtractAbstruct
{
    /**
     * @var string
     */
    protected $grep = '/<w:r>.*?\/w:r>/';

    /**
     * @var string
     */
    protected $pre_index = '[文本]';
    /**
     * @var string
     */
    protected $end_index = '[/文本]';

    /**
     * @var string
     */
    protected $css_pre = '[样式]';
    /**
     * @var string
     */
    protected $css_end = '[/样式]';

    /**
     * @var string
     */
    protected $css_weight_bold = '[加粗]';

    /**
     * @var string
     */
    protected $css_underline = '[下划线]';

    /**
     * @var string
     */
    protected $css_lineThourgh = '[删除线]';

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
            $css = '';
            $css .= $this->matchFontWeightBold($v);
            $css .= $this->matchUnderline($v);
            $css .= $this->matchLineThrouth($v);
            $text = trim(strip_tags($v));
            $this->xml     = str_replace($v, $this->pre_index.$this->css_pre.$css.$this->css_end.$text.$this->end_index, $this->xml);
        }
        return $this->xml;
    }

    /**
     * @param $string
     * @return string|string[]
     */
    public function handelOver($string_before){
        $string_arr = explode($this->end_index,$string_before);
        $string_after = '';
        foreach ($string_arr as $string){
            if(!$string){
                continue;
            }
            $string .= $this->end_index;
            $style = "style='";
            if(strstr($string,$this->css_weight_bold)){
                $string = str_replace($this->css_weight_bold,'',$string);
                $style.= 'font-weight:bold;';
            }
            if(strstr($string,$this->css_underline)){
                $string = str_replace($this->css_underline,'',$string);
                $style.= 'text-decoration:underline;';
            }
            if(strstr($string,$this->css_lineThourgh)){
                $string = str_replace($this->css_lineThourgh,'',$string);
                $style.= 'text-decoration:line-through;';
            }
            $string = str_replace($this->css_pre,'',$string);
            $string = str_replace($this->css_end,'',$string);
            $style .= "'";
            $this->pre_index and $string = str_replace($this->pre_index, '<span '.$style.' >', $string);
            $this->end_index and $string = str_replace($this->end_index, '</span>', $string);
            $string_after .= $string;

        }
        return $string_after;
    }

    /**
     *匹配加粗
     */
    private function matchFontWeightBold($string){
        if(strstr($string,'<w:bCs/>')){
            return $this->css_weight_bold;
        }
        return '';
    }

    private function matchUnderline($string){
        if(strstr($string,'w:val="single"')){
            return $this->css_underline;
        }
        return '';
    }

    private function matchLineThrouth($string){
        if(strstr($string,'<w:strike/><w:dstrike')){
            return $this->css_lineThourgh;
        }
        return '';
    }

}