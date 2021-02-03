<?php

include_once('../autoload.php');

use phpreaddocxmath\src\ReadDocxService;

include_once('ImageDiyHandelDemo.php');

$file_url = 'https://zjx-worker-files-develop.oss-cn-shanghai.aliyuncs.com/10071/uploads/OnlineOfficeFiles/1475a9f9d6eda0678ca6fa29030d69cb';
//$file_url = 'https://zjx-worker-files-develop.oss-cn-shanghai.aliyuncs.com/10071/uploads/OnlineOfficeFiles/f97afb06d1864582433c5f7618cd3886';//纯公式
//$file_url = 'https://zjx-worker-files-develop.oss-cn-shanghai.aliyuncs.com/10071/uploads/OnlineOfficeFiles/2c2b5c346349eec35890896372d786ce';//纯表格
//$file_url = 'https://zjx-worker-files-develop.oss-cn-shanghai.aliyuncs.com/10071/uploads/OnlineOfficeFiles/c907e5ec17f7b72172cb9e79323ba33b';//字体
echo "--开始读取文件---\n";
$docx = (new ReadDocxService())->setImgHandelClass(ImageDiyHandelDemo::class)->setFileUrl($file_url)->extractToHtml(
    'read_docx.html'
);
echo "--完成--\n";