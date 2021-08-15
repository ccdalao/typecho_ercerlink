<?php
/**
* <a href='https://blog.ccdalao.cn/archives/197/' target='_blank'><<< handsome友链快速申请插件 >>></a>
*
* @package <strong style="color:red;">ErcerLink</strong>
* @author 二C
* @version 1.0.6
* @link https://blog.ccdalao.cn
*/
function higrid_compress_html($higrid_uncompress_html_source) {
    $chunks = preg_split('/(<pre.*?\/pre>)/ms', $higrid_uncompress_html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
    $higrid_uncompress_html_source = ''; //[higrid.net]修改压缩html : 清除换行符,清除制表符,去掉注释标记
    foreach ($chunks as $c) {
        if (strpos($c, '<pre') !== 0) {
            $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
            $c = preg_replace('/\\s{2,}/', ' ', $c);
            $c = preg_replace('/>\\s</', '><', $c);
            $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
        }
        $higrid_uncompress_html_source .= $c;
    }
    return $higrid_uncompress_html_source;
}
class ErcerLink_Plugin implements Typecho_Plugin_Interface {


    /* 插件配置方法 */
    public static function config(Typecho_Widget_Helper_Form $form) {}

    /* 个人用户的配置方法 */
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {}

    /* 插件实现方法 */
    public static function render() {}


    public static function activate() {
        Helper::addRoute("route_to_link_add", "/link_add", "ErcerLink_Action", 'link_add');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('ErcerLink_Plugin', 'footer');
    }

    public static function deactivate() {
        Helper::removeRoute("route_to_link_add");
    }

    public static function footer() {
        $Path = Helper::options()->pluginUrl . '/ErcerLink/';
        $ahh = higrid_compress_html(Content::returnLinkList("ten", "ErcerLink"));
        echo '<script type="text/javascript" src="' . $Path . 'js/ErcerLinks.js?v=122"></script>';
        echo ("
        <script>
            $(document).ready(function(){
                $('#addhere').append('$ahh')
            });
        </script>
        ");



    }


}