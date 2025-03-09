<?php
function remove_xss($string) {
    $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S', '', $string); 
    $parm1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base'); 
    $parm2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'); 
    $parm = array_merge($parm1, $parm2);

    for ($i = 0; $i < sizeof($parm); $i++) {
        $pattern = '/';
        for ($j = 0; $j < strlen($parm[$i]); $j++) {
            if ($j > 0) {
                $pattern .= '(';
                $pattern .= '(&#[x|X]0([9][a][b]);?)?';
                $pattern .= '|(&#0([9][10][13]);?)?';
                $pattern .= ')?';
            } 
            $pattern .= $parm[$i][$j];
        } 
        $pattern .= '/i'; 
        $string = preg_replace($pattern, ' ', $string);
    } 
    return $string;
}

class ErcerLink_Action extends Typecho_Widget implements Widget_Interface_Do {
    public function execute() {
        //Do
    }
    public function action() {}
    public function link_add() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            die('欸！是不是走错路啦！😊');
        } else {
            function getUserIpAddr() {
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
                return $ip;
            }
            $reallip = getUserIpAddr();

            // 获取表单数据，并为 host_yes 设置默认值
            $host_name = remove_xss($_POST['host_name'] ?? '');
            $host_url = remove_xss($_POST['host_url'] ?? '');
            $host_png = remove_xss($_POST['host_png'] ?? '');
            $host_msg = remove_xss($_POST['host_msg'] ?? '');
            $host_yes = remove_xss($_POST['host_yes'] ?? 'no'); // 默认值为 'no'

            // 如果是从页面表单提交的，获取对应的值
            if (empty($host_name)) {
                $host_name = remove_xss($_POST['host_name_page'] ?? '');
                $host_url = remove_xss($_POST['host_url_page'] ?? '');
                $host_png = remove_xss($_POST['host_png_page'] ?? '');
                $host_msg = remove_xss($_POST['host_msg_page'] ?? '');
                $host_yes = remove_xss($_POST['host_yes_page'] ?? 'no'); // 默认值为 'no'
            }

            $db = Typecho_Db::get();
            $query_if_also_name = $db->select('name')->from('table.links')->where('name = ?', $host_name);
            $result_name = $db->fetchAll($query_if_also_name);

            $query_if_also_user = $db->select('user')->from('table.links')->where('user = ?', $reallip);
            $result_user = $db->fetchAll($query_if_also_user);

            if (!empty($result_name) or !empty($result_user)) {
                die('欸！你已经提交过啦😊');
            }

            $insert = $db->insert('table.links')
                ->rows(array(
                    'url' => $host_url,
                    'name' => $host_name,
                    'image' => $host_png,
                    'description' => $host_msg,
                    'user' => $reallip,
                    'sort' => 'others'
                ));
            $insertId = $db->query($insert);
            die('postok');
        }
    }
}
