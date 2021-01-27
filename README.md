# phpreadocxmath

#### 介绍
#####  php 读取远程docx文件，支持数学公式
这是一个php读取word的docx\
我写这个的目的是为了完成公司的一个需求，要求能读取word中的公式，图片，文字数据。大部分都是数学题，物理题，化学题\
目前支持读取文本，图片，公式
字体样式还没有做兼容，表格也没有做兼容，以后慢慢完善吧
不支持docx域。能读到内容，但是回现还没有找到解决方案
这个方案我参考了这个仓库 https://gitee.com/NanBinYueLiang/PHPReadWord  
但是这个仓库有的代码有bug。我重构了代码，并修复了部分bug，希望能给有需要的人提供参考

公式回现插件 tiny_mce_wiris
http://www.wiris.com/en/plugins3/tinymce/download
如果本地公式无法正确显示，有可能是浏览器本地跨域问题，请查看是否有js报错


#### 安装教程

1.  git clone下来可以直接用cli运行demo    
   cd phpreadocxmath/test \
   php Demo.php

#### 使用说明

1.  php7.0以上版本
2.  需要php拓展  XSL extension
文档 https://www.php.net/manual/zh/class.xsltprocessor.php

