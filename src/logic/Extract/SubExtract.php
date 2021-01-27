<?php


namespace PHPReadDocx\src\logic\Extract;


use PHPReadDocx\src\logic\ExtractAbstruct;

/**
 * Class PopExtract 下标转换
 * @package PHPReadDocx\src\logic\Extract
 */
class SubExtract extends ExtractAbstruct
{
    /**
     *
     * @var string
     */
    protected $grep = '/<w:vertAlign w:val="subscript".*?w:r>/';

    /**
     * @var string
     */
    protected $pre_index = '[下标前]';
    /**
     * @var string
     */
    protected $end_index = '[下标后]';

    /**
     * @var string
     */
    protected $pre_tag = '<sub>';

    /**
     * @var string
     */
    protected $end_tag = '</sub>';
}