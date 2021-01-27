<?php


namespace PHPReadDocx\src\logic\Extract;


use PHPReadDocx\src\logic\ExtractAbstruct;

/**
 * Class PopExtract 上标转换
 * @package PHPReadDocx\src\logic\Extract
 */
class SupExtract extends ExtractAbstruct
{
    /**
     * <w:vertAlign w:val="superscript"/></w:rPr><w:t>
     * </w:t>
     * @var string
     */
    protected $grep = '/<w:vertAlign w:val="superscript".*?w:r>/';

    /**
     * @var string
     */
    protected $pre_index = '[上标前]';
    /**
     * @var string
     */
    protected $end_index = '[上标后]';

    /**
     * @var string
     */
    protected $pre_tag = '<sup>';

    /**
     * @var string
     */
    protected $end_tag = '</sup>';
}