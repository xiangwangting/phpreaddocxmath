<?php


namespace phpreaddocxmath\src;


/**
 * 图片自定义处理handel
 * Interface ImageDiyHandelInterface
 * @package PHPReadDocx\src
 */
interface ImageDiyHandelInterface
{
    /**
     * 自定义图片处理
     * @param string $base64Img 图片base64数据流
     * @return string 处理后的图片url,会用于替换图片src显示
     */
    public function handel(string $base64Img) : string;
}