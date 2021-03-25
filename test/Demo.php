<?php

include_once('../autoload.php');

use phpreaddocxmath\src\ReadDocxService;

include_once('ImageDiyHandelDemo.php');

//$file_url = 'https://zjx-worker-files-develop.oss-cn-shanghai.aliyuncs.com/10071/uploads/OnlineOfficeFiles/b74ec6cf2fa812546c3511c32ad91faf';
//$file_url = 'https://zjx-worker-files-develop.oss-cn-shanghai.aliyuncs.com/10071/uploads/OnlineOfficeFiles/f97afb06d1864582433c5f7618cd3886';//纯公式
//$file_url = 'https://zjx-worker-files-develop.oss-cn-shanghai.aliyuncs.com/10071/uploads/OnlineOfficeFiles/2c2b5c346349eec35890896372d786ce';//纯表格
//$file_url = 'https://zjx-worker-files-develop.oss-cn-shanghai.aliyuncs.com/10071/uploads/OnlineOfficeFiles/c907e5ec17f7b72172cb9e79323ba33b';//字体
//$file_url = 'https://zjx-worker-files-develop.oss-cn-shanghai.aliyuncs.com/10071/uploads/OnlineOfficeFiles/cb14c416fdb90c46d7dca37d6238d5b1';//字体颜色
$file_url = 'https://zjx-worker-files-develop.oss-cn-shanghai.aliyuncs.com/10071/uploads/HomeWork/a8ee4a75ef4d5bd43bb406dfcbd07990';
echo "--开始读取文件---\n";
$docx = (new ReadDocxService())->setImgHandelClass(ImageDiyHandelDemo::class)->setFileUrl($file_url)->extractToHtml(
    'read_docx.html'
);
echo "--完成--\n";