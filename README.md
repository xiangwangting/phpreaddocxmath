# phpreaddocxmath

#### 介绍
#####  php 读取远程docx文件，支持数学公式
这是一个php读取word的docx\
我写这个的目的是为了完成公司的一个需求，要求能读取word中的公式，图片，文字数据。大部分都是数学题，物理题，化学题\
目前支持读取文本，图片，公式
字体样式还没有做兼容，表格也没有做兼容，以后慢慢完善吧
不支持docx域。能读到内容，但是回现还没有找到解决方案
这个方案我参考了这个仓库 https://gitee.com/NanBinYueLiang/PHPReadWord  
但是这个仓库有的代码有bug。我重构了代码，并修复了部分bug，希望能给有需要的人提供参考

#### 安装教程

（1）git clone下来可以直接用cli运行demo    
```cli
   cd phpreadocxmath/test
   php Demo.php
```

 （2）支持composer安装
```cli
   composer require phpreaddocxmath/phpreaddocxmath
```

#### 使用说明

1.  php7.0以上版本
2.  需要php拓展  XSL extension
文档 https://www.php.net/manual/zh/class.xsltprocessor.php

#### 公式mathml兼容性
读取出出来的数学公式是mathml格式
IE浏览器，QQ浏览器，safri浏览器显示都没问题，但是Google显示有问题\
查询了相关资料,Chrome浏览器在版本24的时候曾经昙花一现支持了下，不过很快就取消了支持，据说是出于安全考虑
我查找了下，有个名叫mathml.css的项目：https://github.com/fred-wang/mathml.css


针对Chrome这类不支持的浏览器使用CSS进行了公式布局的模拟。使用方法可以是直接引入下面JS代码：

```html
<script src="//fred-wang.github.io/mathml.css/mspace.js"></script>
```

