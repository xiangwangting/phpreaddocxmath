<?php


namespace PHPReadDocx\src;

use PHPReadDocx\src\logic\Extract\ImgExtract;
use PHPReadDocx\src\logic\Extract\MathExtract;
use PHPReadDocx\src\logic\Extract\SubExtract;
use PHPReadDocx\src\logic\Extract\SupExtract;

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