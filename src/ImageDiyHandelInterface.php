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
     * 自定义临时图片处理
     * @param string $base64Img 图片base64数据
     * @param string $image_patch 图片路径
     * @return string
     */
    public function handel(string $base64Img,string $image_patch) : string;
}