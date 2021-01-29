<?php


namespace phpreaddocxmath\src\logic\Extract;


use phpreaddocxmath\src\ImageDiyHandelInterface;
use phpreaddocxmath\src\logic\ExtractAbstruct;

/**
 * Class ImgExtract 图片转换
 * @package PHPReadDocx\src\logic\Extract
 */
class ImgExtract extends ExtractAbstruct
{
    /**
     *
     * @var string
     */
    protected $grep = '#<a:blip[^>]*r:embed="rId[0-9]+"[^>]*>#';

    /**
     * @var string
     */
    protected $pre_index = '[图片前]';
    /**
     * @var string
     */
    protected $end_index = '[图片后]';

    /**
     * @var string
     */
    protected $pre_tag = '<';

    /**
     * @var string
     */
    protected $end_tag = '/>';

    /**
     * @var string
     */
    private $image_handel_class = '';

    /**
     * @return mixed
     */
    public function handel($image_handel_class = '')
    {
        $this->image_handel_class = $image_handel_class;
        $picdata = $this->docxService->getDoxc()->getFromName('word/_rels/document.xml.rels');
        preg_match_all($this->grep, $this->xml, $arr);
        foreach ($arr[0] as $v) {
            preg_match('#rId[0-9]+#', $v, $match);
            $str = '#<Relationship[^>]*Id="' . $match[0] . '"[^>]*>#';
            preg_match($str, $picdata, $st);
            preg_match('#media/image\d+.(png|jpg|jpeg|wmf)#', $st[0], $t);
            $img_patch = $this->docxService->getDiyTmpPatch().'/' . $this->docxService->getTempPatchName() . '/media/word/' . $t[0];
            //这里获取到了图片到base64encode数据,需要上传到oss,并把本地地址替换成oss地址
            $base64    = $this->base64EncodeImage($img_patch);
            $oss_url   = $this->saveOss($base64,$img_patch);
            $this->xml = str_replace(
                $v,
                $this->pre_index . 'img  style="vertical-align: middle;" src="' . $oss_url . '" '. $this->end_index,
                $this->xml
            );
        }
        return $this->xml;
    }

    /**
     * @param $image_file
     * @return string
     */
    private function base64EncodeImage($image_file)
    {
        $image_info   = getimagesize($image_file);
        $image_data   = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }

    /**
     * 保存图片到oss,或者自己项目目录，并返回完整的图片url
     * @param $base64_data
     * @param $image_patch
     * @return string
     */
    private function saveOss($base64_data,$image_patch)
    {
        if(!$this->image_handel_class){
            return $base64_data;
        }
        /**@var ImageDiyHandelInterface $imageHandel*/
        $imageHandel = new $this->image_handel_class();
        return $imageHandel->handel($base64_data,$image_patch);
    }
}