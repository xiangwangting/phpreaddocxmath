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
    protected $pre_index = '[frontcontent]';
    /**
     * @var string
     */
    protected $end_index = '[/frontcontent]';

    /**
     * @var string
     */
    protected $css_pre = '[textcss]';
    /**
     * @var string
     */
    protected $css_end = '[/textcss]';

    /**
     * @var string
     */
    protected $css_weight_bold = '[weightbold]';

    /**
     * @var string
     */
    protected $css_underline = '[underline]';

    /**
     * @var string
     */
    protected $css_lineThourgh = '[linethrouh]';

    /**
     * @var string
     */
    protected $css_font_color = '[fontcolor]';

    /**
     * @var string
     */
    protected $css_bg_color = '[bgcolor]';

    /**
     * @return mixed
     */
    public function handel()
    {
        if (!$this->grep) {
            return $this->xml;
        }
        preg_match_all($this->grep, $this->xml, $arr);
        foreach ($arr[0] as $v) {
            $css       = '';
            $css       .= $this->matchFontWeightBold($v);
            $css       .= $this->matchUnderline($v);
            $css       .= $this->matchLineThrouth($v);
            $css       .= $this->matchFontColor($v);
            $css       .= $this->matchBgColor($v);
            $text      = trim(strip_tags($v));
            $this->xml = str_replace(
                $v,
                $this->pre_index . $this->css_pre . $css . $this->css_end . $text . $this->end_index,
                $this->xml
            );
        }
        return $this->xml;
    }

    /**
     * @param $string
     * @return string|string[]
     */
    public function handelOver($string_before)
    {
        $string_arr   = explode($this->end_index, $string_before);
        $string_after = '';
        foreach ($string_arr as $string) {
            if (!$string) {
                continue;
            }
            strstr($string, $this->pre_index) !== false and $string .= $this->end_index;
            $style = "style='";
            if (strstr($string, $this->css_weight_bold)) {
                $string = str_replace($this->css_weight_bold, '', $string);
                $style  .= 'font-weight:bold;';
            }
            if (strstr($string, $this->css_underline)) {
                $string = str_replace($this->css_underline, '', $string);
                $style  .= 'text-decoration:underline;';
            }
            if (strstr($string, $this->css_lineThourgh)) {
                $string = str_replace($this->css_lineThourgh, '', $string);
                $style  .= 'text-decoration:line-through;';
            }
            if (strstr($string, $this->css_font_color)) {
                $grep = '/' . $this->css_font_color . '.*?;/';
                preg_match_all($grep, $string, $text_arr);
                foreach ($text_arr[0] as $tmp) {
                    $color  = explode(':', $tmp);
                    $color  = $color[1];
                    $color  = str_replace(';', '', $color);
                    $style  .= 'color:' . $color . ';';
                    $string = str_replace($this->css_font_color . ':' . $color . ';', '', $string);
                }
                $string = str_replace($this->css_font_color, '', $string);
                $style  .= 'color';
            }
            if (strstr($string, $this->css_bg_color)) {
                $grep = '/' . $this->css_bg_color . '.*?;/';
                preg_match_all($grep, $string, $text_arr);
                foreach ($text_arr[0] as $tmp) {
                    $color  = explode(':', $tmp);
                    $color  = $color[1];
                    $color  = str_replace(';', '', $color);
                    $style  .= 'background:' . $color . ';';
                    $string = str_replace($this->css_bg_color . ':' . $color . ';', '', $string);
                }
                $string = str_replace($this->css_font_color, '', $string);
                $style  .= 'color';
            }
            $string = str_replace($this->css_pre, '', $string);
            $string = str_replace($this->css_end, '', $string);
            $style  .= "'";
            $this->pre_index and $string = str_replace($this->pre_index, '<span ' . $style . ' >', $string);
            $this->end_index and $string = str_replace($this->end_index, '</span>', $string);
            $string_after .= $string;
        }
        return $string_after;
    }

    /**
     *匹配加粗
     */
    private function matchFontWeightBold($string)
    {
        if (strstr($string, '<w:bCs/>')) {
            return $this->css_weight_bold;
        }
        return '';
    }

    /**
     * @param $string
     * @return string
     */
    private function matchUnderline($string)
    {
        if (strstr($string, 'w:val="single"')) {
            return $this->css_underline;
        }
        return '';
    }

    /**
     * @param $string
     * @return string
     */
    private function matchLineThrouth($string)
    {
        if (strstr($string, '<w:strike/><w:dstrike')) {
            return $this->css_lineThourgh;
        }
        return '';
    }

    /**
     * @param $string
     * @return string
     */
    private function matchFontColor($string)
    {
        if (strstr($string, '<w:color')) {
            preg_match_all('/<w:color w:val=".*?"\/>/', $string, $color);
            $color = isset($color[0][0]) ? $color[0][0] : '';
            if (!$color) {
                return '';
            }
            $color = explode('"', $color);
            $color = $color[1];
            $color = str_replace('"', '', $color);
            return $this->css_font_color . ':' . $color . ';';
        }
        return '';
    }

    /**
     * @param $string
     */
    protected function matchBgColor($string)
    {
        if (strstr($string, '<w:highlight')) {
            preg_match_all('/<w:highlight w:val=".*?"\/>/', $string, $color);
            $color = isset($color[0][0]) ? $color[0][0] : '';
            if (!$color) {
                return '';
            }
            $color = explode('"', $color);
            $color = $color[1];
            $color = str_replace('"', '', $color);
            return $this->css_bg_color . ':' . $color . ';';
        }
        return '';
    }

}