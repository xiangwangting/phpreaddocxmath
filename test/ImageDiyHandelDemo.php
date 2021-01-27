<?php

use PHPReadDocx\src\ImageDiyHandelInterface;

/**
 * demo自定义图片处理
 * Class ImageDiyHandelDemo
 */
class ImageDiyHandelDemo implements ImageDiyHandelInterface
{
    /**
     * 自定义图片处理
     * @param string $base64Img 图片数据流
     * @return string 图片处理后对url
     */
    public function handel(string $base64Img): string
    {
        // TODO: Implement handel() method.
        //这里是自定义代码，可以把图片放在本地其他地方，也可以放在oss
        return $base64Img;
    }
}