<?php


namespace phpreaddocxmath\src;

use phpreaddocxmath\src\logic\Extract\ImgExtract;
use phpreaddocxmath\src\logic\Extract\MathExtract;
use phpreaddocxmath\src\logic\Extract\SubExtract;
use phpreaddocxmath\src\logic\Extract\SupExtract;

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
        MathExtract::class,
        SupExtract::class,
        SubExtract::class,
        ImgExtract::class,
    ];
}