<?php


namespace phpreaddocxmath\src;

use phpreaddocxmath\src\logic\Extract\FontExtract;
use phpreaddocxmath\src\logic\Extract\ImgExtract;
use phpreaddocxmath\src\logic\Extract\MathExtract;
use phpreaddocxmath\src\logic\Extract\SubExtract;
use phpreaddocxmath\src\logic\Extract\SupExtract;
use phpreaddocxmath\src\logic\Extract\TableExtract;

/**
 * Class ExtractConfig
 * @package PHPReadDocx\src
 */
class ExtractConfig
{
    /**
     * 转换配置
     */
    const CONFIG = [
        ImgExtract::class,//图片必须最先处理
        SupExtract::class,//上标必须在字体处理前
        SubExtract::class,//下标必须在字体处理前
        FontExtract::class,//字体处理
        MathExtract::class,//公式必须在字体处理后
        TableExtract::class,
    ];
}