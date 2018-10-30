<?php
namespace Home\Controller;
use Think\Controller;
//use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class WeixinController extends Controller{
    //存储asccesstoken
    public function getWxAccessToken(){
//        if(!empty(Session::get('access_token'))&&!empty(Session::get('access_token'))){
//            if(Session::get('access_token') && Session::get('access_token')>time()){
//                return Session::get('access_token');
//            }
//        }else{
            $data = M("weixin_config")->where("weixin_id = 1")->find();
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$data['appid']."&secret=".$data['secret'];
            $res = json_decode(file_get_contents($url));
            $access_token = $res->access_token;
            session('access_token',$access_token);
            session('expires_time',time()+7000);
            return $access_token;
//        }
    }
    public function index()
    {
        //获得参数 signature nonce token timestamp echostr
        $nonce     = $_GET['nonce'];
        $token     = 'cdc98956456156844561c';
        $timestamp = $_GET['timestamp'];
        $echostr   = $_GET['echostr'];
        $signature = $_GET['signature'];
        //形成数组，然后按字典序排序
        $array = array();
        $array = array($nonce, $timestamp, $token);
        sort($array);
        //拼接成字符串,sha1加密 ，然后与signature进行校验
        $str = sha1( implode( $array ) );
        if( $str  == $signature && $echostr ){
            //第一次接入weixin api接口的时候
            echo  $echostr;
            exit;
        }else{
            $this->reponseMsg();
        }
    }
    //默认菜单
    public function create_cau(){
        $data = M("weixin_config")->where("weixin_id = 1")->find();
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$data['appid']."&secret=".$data['secret'];
        $res = json_decode(file_get_contents($url));
        $access_token = $res->access_token;
//        $button = '{
//    "button":[
//        {
//            "type": "click", 
//            "name": "今日歌曲", 
//            "key": "V1001_TODAY_MUSIC", 
//            "sub_button": [ ]
//        }, 
//        {
//            "name": "产品介绍", 
//            "sub_button": [
//                {
//                    "type":"view",
//                    "name":"分利产品",
//                    "url":"http://e.eqxiu.com/s/NVg35qU4",
//                    "sub_button": [ ]
//                },
//                {
//                    "type":"特色家装产品",
//                    "name":"分利产品",
//                    "url":"http://e.eqxiu.com/s/NVg35qU4",
//                    "sub_button": [ ]
//                },
//                {
//                    "type":"立即报单",
//                    "name":"分利产品",
//                    "url":"http://e.eqxiu.com/s/NVg35qU4",
//                    "sub_button": [ ]
//                }]
//        }, 
//        {
//            "name": "平台商城", 
//            "sub_button": [
//                {
//                    "type":"click",
//                    "name":"平台商城",
//                    "key":"1.‘科艺隆装饰’官方微信号，留下您的姓名，联系方式，小区名即可。2.电话咨询：186-9809-8909 QQ咨询：17353455504 网站咨询：请输入网址www.keyilong.com,首页左侧咨询中心预约。",
//                    "sub_button": [ ]
//                }, 
//                {
//                    "type":"view",
//                    "name":"活动",
//                    "url":"http://e.eqxiu.com/s/NVg35qU4",
//                    "sub_button": [ ]
//                }]
//        }]
//}';
    $button = '{
    "button": [
        {
            "name": "平台商城", 
            "sub_button": [
                {
                    "type": "view", 
                    "name": "平台商城", 
                    "url": "http://www.ch-d-ch.com/Index/shop_index", 
                    "sub_button": [ ]
                },
                {
                    "type": "view", 
                    "name": "平台官网", 
                    "url": "http://www.ch-d-ch.com", 
                    "sub_button": [ ]
                }
                
            ]
        },
        {
            "name": "产品介绍", 
            "sub_button": [
                {
                    "type": "view_limited", 
                    "name": "创业卡介绍", 
                    "media_id": "7-Pg2M3VVEXORHdgEISSgRGjHSQE4ocygIVVU_mWq-0", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "view_limited", 
                    "name": "一卡通介绍", 
                    "media_id": "7-Pg2M3VVEXORHdgEISSgaWux5dAuIRLBuyo8kn8Hpc", 
                    "sub_button": [ ]
                },
                {
                    "type": "view", 
                    "name": "立即购买", 
                    "url": "http://www.ch-d-ch.com/Index/trained", 
                    "sub_button": [ ]
                }
            ]
        },
        {
            "name": "个人中心", 
            "sub_button": [
                {
                    "type": "view", 
                    "name": "个人中心", 
                    "url": "http://www.ch-d-ch.com/Index/myhome", 
                    "sub_button": [ ]
                },
                {
                    "type": "pic_photo_or_album", 
                    "name": "自拍抽奖", 
                    "key": "rselfmenu_1_1", 
                    "sub_button": [ ]
                }
            ]
        }
    ]
}';
//    {
//                    "type": "click", 
//                    "name": "活动介绍", 
//                    "key": "暂无活动", 
//                    "sub_button": [ ]
//                },
//    {
//                    "type": "pic_photo_or_album", 
//                    "name": "自拍抽奖", 
//                    "key": "rselfmenu_1_1", 
//                    "sub_button": [ ]
//                }
        $url ="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
//        echo $access_token;
        $res = $this->https($url,$button);
        dump($res);
        return $res;
    }
    //发送自定义菜单请求
    public function https($url,$data){
        $opts = array (
        "http" => array (
        "method" => "POST",
        "header"=> "Content-type: application/x-www-form-urlencodedrn" .
        "Content-Length:".strlen($data)."rn",
        "content" => $data
        )
        );

        $context = stream_context_create($opts);
        $html = file_get_contents($url, false, $context);
        return $html;
    }
    //获取永久素材media_id
    public function media(){
        $data = M("weixin_config")->where("weixin_id = 1")->find();
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$data['appid']."&secret=".$data['secret'];
        $res = json_decode(file_get_contents($url));
        $access_token = $res->access_token;
        $url ="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$access_token;
        $media_id = json_encode(array(
        'type' => 'news',
        'offset' => 20,
        'count' => 10,
        ));
        $res = $this->https($url,$media_id);
        dump($res);
    }
    public function img_id(){
        $data = M("weixin_config")->where("weixin_id = 1")->find();
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$data['appid']."&secret=".$data['secret'];
        $res = json_decode(file_get_contents($url));
        $access_token = $res->access_token;
        dump($access_token);
        $id = "M5xxwdoxFA3nD4aeXgLlivgMo4edsfrPmL_Ty7sPu3Rmoskj9G2JH_TTMEYf2GYU";
        $url ="https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$id;
//        $res2 = json_decode(file_get_contents($url));
        $ch = curl_init();
        $timeout = 5;
        curl_setopt ($ch, CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);

        echo $file_contents;
//        echo $res2;
    }
    public function ceshi_openid(){
//        $user = $postObj->FromUserName;
        $url2 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=GdoFuDxrW1Igp7RaqUKoMxJMdYV0GACjbtLXOOx-3rIarKDaiOGUmMtzJQnb-p8B-uyPSSeq7U_BQDkMFPprHKJjakW5V4kxasqDE2XyMs9g4GjhlvJyNUjCKBSX18ryGAWeADAVPL&openid=oXCqkwtqwtw8Pfrk_YqFmn23AJYw&lang=zh_CN";
        
        $res2 = json_decode(file_get_contents($url2));
        $arr = $res2->nickname;
        dump($arr);

    }
}