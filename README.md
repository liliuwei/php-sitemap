# php-sitemap
PHP 网站地图 Sitemap工具类

Sitemap 可方便网站管理员通知搜索引擎他们网站上有哪些可供抓取的网页。
最简单的 Sitemap 形式，就是XML 文件，在其中列出网站中的网址以及关于每个网址的其他元数据（上次更新的时间、更改的频率以及相对于网站上其他网址的重要程度为何等），
以便搜索引擎可以更加智能地抓取网站。
## 安装

~~~php
composer require liliuwei/php-sitemap
~~~

## 用法示例

~~~php
<?php
$site = new \liliuwei\Sitemap();
$cate = [
    1 => '男装',
    2 => '女装'
];

$article_list = [
    1 => '怎么穿衣服有气质  教你身材不好也可以穿出女神范',
    2 => '秋冬穿衣搭配图片  秋冬季内搭和大衣要如何搭配呢'
];
foreach ($cate as $key => $value) {
    $site->AddItem('http://www.youqunaya.com/list.html?cid=' . $key, 1);
}

foreach ($article_list as $key => $value) {
    $site->AddItem('http://www.youqunaya.com/article_list.html?id=' . $key, 1);
}
//$site->AddItem();支持多次调用
$site->SaveToFile('sitemap.xml');
~~~
