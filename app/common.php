<?php
// 应用公共文件
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function emailto($to,$title,$content)
{
    try {
        $email = new PHPMailer();
        //使用SMTP发送邮件
        $email->isSMTP();
        //调试模式
        $email->SMTPDebug = 0;
        $email->CharSet ='utf-8';
        //SMTP主机
        $email->Host = 'smtp.163.com';
        //SMTP用户名
        $email->Username = '18697703903@163.com';
        //SMTP密码
        $email->Password = 'yyou1995.';
        //设置邮件的发件人电子邮件地址
        $email->From = $to;
        //设置消息的主题。
        $email->Subject = $title;
        //本消息正文
        $email->Body = $content;
        //smtp需要鉴权 这个必须是true
        $email->SMTPAuth = true;
        //在SMTP连接上使用哪种加密
        $email->SMTPSecure = 'ssl';
        //SMTP服务器端口
        $email->Port = 465;
        //设置发送人
        $email->setFrom('18697703903@163.com','战士验证码');
        //添加收件人地址
        $email->addAddress($to);
        //创建并发送消息
        return $email->send();
    }catch (Exception $e){
        exception($email->ErrorInfo);
    }

}
function curl_get($url){

    $header = array(
        'Accept: application/json',
    );
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    // 超时设置,以秒为单位
    curl_setopt($curl, CURLOPT_TIMEOUT, 1);

    // 超时设置，以毫秒为单位
    // curl_setopt($curl, CURLOPT_TIMEOUT_MS, 500);

    // 设置请求头
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //执行命令
    $data = curl_exec($curl);

    // 显示错误信息
    if (curl_error($curl)) {
        print "Error: " . curl_error($curl);
    } else {
        // 打印返回的内容
        var_dump($data);
        curl_close($curl);
    }
}
function geturl($url){
    $headerArray =array("Content-type:application/json;","Accept:application/json");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
    $output = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($output,true);
    return $output;
}