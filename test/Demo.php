<?php

include_once('../autoload.php');

use PHPReadDocx\src\ReadDocxService;

include_once('ImageDiyHandelDemo.php');


$file_url = 'https://zjx-worker-files-develop.oss-cn-shanghai.aliyuncs.com/10071/uploads/OnlineOfficeFiles/1475a9f9d6eda0678ca6fa29030d69cb';
//$file_url = 'https://zjx-worker-files-develop.oss-cn-shanghai.aliyuncs.com/10071/uploads/OnlineOfficeFiles/f97afb06d1864582433c5f7618cd3886';
var_dump('--开始读取文件---');
$docx = (new ReadDocxService())->setImgHandelClass(ImageDiyHandelDemo::class)->setFileUrl($file_url)->extractToHtml(
    'read_docx.html'
);
var_dump($docx);
var_dump('--完成--');