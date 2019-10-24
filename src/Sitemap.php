<?php

namespace liliuwei\sitemap;
/*
 * <url>
<loc>http://www.youqunaya.com</loc>
<priority>1.00</priority>
<lastmod>2015-06-15T13:21:34+08:00</lastmod>
<changefreq>Always</changefreq>
</url>
*/

/**
 * Sitemap输出和生成类
 * @author
 */
class Sitemap
{//类定义开始

    private $config = array(
        'encoding' => 'UTF-8',
        'ver' => '1.0'
    );

    private $content = '';
    // Items部分
    private $items = array();

    public function __get($name)
    {
        if (isset($this->config[$name])) {
            return $this->config[$name];
        }
        return null;
    }

    public function __set($name, $value)
    {
        if (isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    public function __isset($name)
    {
        return isset($this->config[$name]);
    }

    public function content($name)
    {
        if (empty($this->content)) $this->Build();
        $this->content;
    }

    /**
     * 架构函数
     * @access public
     * @param array $config 上传参数
     */
    public function __construct()
    {

    }

    /**************************************************************************/
    // 函数名: AddItem
    // 功能: 添加一个节点
    //$changefreq | always 经常,hourly 每小时,daily 每天,weekly 每周,monthly 每月,yearly 每年,never 从不
    /**************************************************************************/

    function AddItem($loc, $priority, $changefreq = 'Always')
    {
        $arr = array(
            1,
            0.9,
            0.8,
            0.7,
            0.6,
            0.5
        );
        $this->items[] = array(
            'loc' => $loc,
            'priority' => $arr[$priority],
            'lastmod' => date('Y-m-d H:i:s', time()),
            'changefreq' => $changefreq
        );
    }
    /**************************************************************************/
    // 函数名: Build
    // 功能: 生成sitemap xml文件内容
    /**************************************************************************/
    function Build()
    {
        $s = "<?xml version='1.0' encoding='{$this->encoding}'?>\r\n";
        $s .= "\t<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\r\n";
        // items
        for ($i = 0; $i < count($this->items); $i++) {
            $s .= "\t\t<url>\n";
            $s .= "\t\t\t<loc>{$this->items[$i]['loc']}</loc>\r\n";
            $s .= "\t\t\t<priority>{$this->items[$i]['priority']}</priority>\r\n";
            $s .= "\t\t\t<lastmod>{$this->items[$i]['lastmod']}</lastmod>\r\n";
            $s .= "\t\t\t<changefreq>{$this->items[$i]['changefreq']}</changefreq>\r\n";
            $s .= "\t\t</url>\n";
        }
        // close
        $s .= "\t</urlset>";
        $this->content = $s;
    }

    /**************************************************************************/
    // 函数名: Show
    // 功能: 将产生的sitemap内容直接打印输出
    /**************************************************************************/
    function Show()
    {
        header("Content-Type: text/xml; charset=utf-8");
        if (empty($this->content)) $this->Build();
        echo($this->content);
    }

    /**************************************************************************/
    // 函数名: SaveToFile
    // 功能: 将产生的sitemap 内容保存到文件
    // 参数: $fname 要保存的文件名
    /**************************************************************************/
    function SaveToFile($fname)
    {
        if (empty($this->content)) $this->Build();
        $handle = fopen($fname, 'w+');
        if ($handle === false) return false;
        fwrite($handle, $this->content);
        fclose($handle);
    }

    /**************************************************************************/
    // 函数名: getFile
    // 功能: 从文件中获取输出
    // 参数: $fname 文件名
    /**************************************************************************/
    function getFile($fname)
    {
        $handle = fopen($fname, 'r');
        if ($handle === false) return false;
        while (!feof($handle)) {
            echo fgets($handle);
        }
        fclose($handle);
    }
}

//使用方法
//$site = new Sitemap();
//$cate = [
//    1 => '男装',
//    2 => '女装'
//];
//
//$article_list = [
//    1 => '怎么穿衣服有气质  教你身材不好也可以穿出女神范',
//    2 => '秋冬穿衣搭配图片  秋冬季内搭和大衣要如何搭配呢'
//];
//foreach ($cate as $key => $value) {
//    $site->AddItem('http://www.youqunaya.com/list.html?cid=' . $key, 1);
//}
//
//foreach ($article_list as $key => $value) {
//    $site->AddItem('http://www.youqunaya.com/article_list.html?id=' . $key, 1);
//}
////$site->AddItem();支持多次调用
//$site->SaveToFile('sitemap.xml');