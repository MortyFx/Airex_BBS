<?php

//检查登陆状态
function checkLogin() {
    if (session('?user')) {
        return true;
    }
    return false;
}

//检查验证码
function check_verify($code, $id = '') {
    $verify = new \Think\Verify();
    return $verify->check($code, $id);

}


//返回真实IP
function get_real_ip() {
    $ip = false;
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) {
            array_unshift($ips, $ip);
            $ip = FALSE;
        }
        for ($i = 0; $i < count($ips); $i++) {
            if (!eregi("^(10|172\.16|192\.168)\.", $ips[$i])) {
                $ip = $ips[$i];
                break;
            }
        }
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

//邮件发送函数
function sendMail($to, $title, $content) {

    Vendor('PHPMailer.PHPMailerAutoload');
    $mail = new PHPMailer(); //实例化
    $mail->IsSMTP(); // 启用SMTP
    $mail->Host = C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
    $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
    $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
    $mail->Password = C('MAIL_PASSWORD'); //邮箱密码
    $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
    $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
    $mail->AddAddress($to, "Airex用户");
    $mail->WordWrap = 50; //设置每行字符长度
    $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
    $mail->CharSet = C('MAIL_CHARSET'); //设置邮件编码
    $mail->Subject = $title; //邮件主题
    $mail->Body = $content; //邮件内容
    $mail->AltBody = "Airex是一个基于ThinkPHP的轻量级bbs社区"; //邮件正文不支持HTML的备用显示
    return ($mail->Send());
}

//判断数据是否为null
function checkNull($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            if ($value && !is_array($value)) {
                return false;
            }
            if (!checkNull($value)) {
                return false;
            }
        }
        return true;
    } else {
        if (!$data) {
            return true;
        } else {
            return false;
        }
    }
}

//验证节点
function nodeValidate($node) {
    $nodes = M('node')->getField('node_name', true);
    if (!in_array($node, $nodes)) {
        return false;
    }
    return true;
}

//验证分类
function catValidate($catName) {
    $categorys = M('category')->getField('cat_name', true);
    if (!in_array($catName, $categorys)) {
        return false;
    }
    return true;
}