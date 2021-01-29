<?php

use phpreaddocxmath\src\ImageDiyHandelInterface;

/**
 * demo自定义图片处理
 * Class ImageDiyHandelDemo
 */
class ImageDiyHandelDemo implements ImageDiyHandelInterface
{
    /**
     * @param string $base64Img
     * @param string $image_patch
     * @return string
     */
    public function handel(string $base64Img, string $image_patch): string
    {
        // TODO: Implement handel() method.
        return $base64Img;
    }
}