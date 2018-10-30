<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class IndexController extends Controller {
//  <------------注释：侯鑫  2016-12-14----------------->
    //官网首页
    public function index(){
        $m = M("new");//连接新闻表
        $p = M("phone_banner");//连接手机banner图表
        $row = $m->where("status=0")->order("new_id desc")->limit(5)->select();//查询pc端新闻结果
        $url = $p->where("status=0")->order("banner_id desc")->select();//查询pc端banner图结果
        $goom = $p->where("status=2")->select();//查询pc端推荐图结果
        //传值
        $this->assign("row",$row);
        $this->assign("url",$url);
        $this->assign("goom",$goom);
        $this->display();
    }
    public function phoneUpdate(){
        $this->display();
    }
    //团队列表页面
    public function tuanduiliebiao(){
        $sql = M("ucredentials");//连接用户资质表
        $id = $_GET['id'];//接收资质表主键id
        $m = M("uaccount");//连接用户信息表
        $count = $sql->where("tid=$id and status=1")->count();//以接收id查询已激活资质的条数
        $p = getpage($count,6);//分页
        $arr = $sql->where("tid=$id and status=1")->limit($p->firstRow, $p->listRows)->select();//以接收id查询已激活资质的数组
        $array = $m->select();//查询用户信息表的结果
        //开始循环
        for($i=0;$i<count($arr);$i++){
            foreach($array as $val){
                if($val['tel']==$arr[$i]['tel']){//判断用户表中用户手机号字段与资质表手机号码相同的
                    $arr[$i]['real_name'] = $val['real_name'];//将信息表中真实姓名一列赋予资质数组
                }
                if($val['tel']==$arr[$i]['recommend_id']){//判断资质表的推荐人字段与用户表中手机号码相同的
                    $arr[$i]['tuijian'] = $val['real_name'];//将信息表中真实姓名一列赋予资质数组
                }
            }
        }
        for($i=0;$i<count($arr);$i++){
            $time[$i] = explode("-",$arr[$i]['approval_time']);
            if($time[$i][0] == "2016"){
            }else{
                if($arr[$i]['goods_id']=="2900"){
                    $arr[$i]['goods_id'] = 3200;
                }else if($arr[$i]['goods_id']=="29000"){
                    $arr[$i]['goods_id'] = 32000;
                }else if($arr[$i]['goods_id']=="290000"){
                    $arr[$i]['goods_id'] = 320000;
                }
            }
        }
        //循环结束
//        dump($arr);
        //传值
        $this->assign("ding",$arr);
        $this->assign('show', $p->show());
        $this->display();
    }
    //团队列表页点击子账户ajax页
    public function tidyanzheng(){
        $sql = M("ucredentials");//连接用户资质表
        $id = $_POST['id'];//接收资质表主键id
        $arr = $sql->where("tid=$id and status=1")->select();//查询已主键id并且已激活资质的结果
        if(count($arr)==0){//判断是否有值
            echo 1;//无值返回给ajax 1;  1:判断为无子账户
        }
    }
    //签署资质页面
    public function Joined2(){
        $sql = M("vgoods");//连接资质产品表
        $arr = $sql->where("status=0 and zhuangtai=0")->select();//查询普通产品的结果
        
        
        //针对某个人
        if($_COOKIE['LoginName']=="18640397217"){
            $arr[0]['goods_name'] = 3200;
            $arr[1]['goods_name'] = 32000;
            $arr[2]['goods_name'] = 320000;
        }
        $this->assign("shop",$arr);
        
        $array = $sql->where("status=1 and zhuangtai=0")->select();//查询家装产品的结果
        $this->assign("sp",$array);
        
        
        $shop_name=M("flagship");//连接旗舰店表
        $shopName=$shop_name->select();//查询所有旗舰店结果
        $manager = M("manager");
        $manager_arr = $manager->select();
        foreach($shopName as $val){
            for($i=0;$i<count($manager_arr);$i++){
                if($val['shop_id']==$manager_arr[$i]['shop_id']){
                    $manager_arr[$i]['shop_name'] = $val['shop_name'];
                }
            }
        }
        $this->assign("shopName",$manager_arr);
        
        $u = M("uaccount");
        $find = $u->where("tel={$_COOKIE['LoginName']}")->find();
        $this->assign("user",$find);
        
        $this->display();
    }
    //个人中心主框架页
    public function member(){
        if($_COOKIE['LoginName']){//判断是否登录(无登录状态下跳转至登录页)
            $sql = M("uaccount");
            $find = $sql->where("tel={$_COOKIE['LoginName']}")->find();
            $this->assign("user",$find);
            $this->display();
        }else{
            $this->redirect("login");
        }
        
    }
    //签署资质页(积分)
    public function Joined(){
        $sql = M("vgoods");//连接资质产品表
        $arr = $sql->where("status=0 and zhuangtai=0")->select();//查询普通产品结果
        
        //针对某个人
        if($_COOKIE['LoginName']=="18640397217"){
            $arr[0]['goods_name'] = 3200;
            $arr[1]['goods_name'] = 32000;
            $arr[2]['goods_name'] = 320000;
        }
        $this->assign("shop",$arr);
        $this->display();
    }
    //子账户管理页面
    public function subAccount(){
        $sql = M("ucredentials");//连接用户资质表
        $count = $sql->where("tel={$_COOKIE['LoginName']}")->count();//查询当前登录账号的子账户个数
        $p = getpage($count,10);//分页
        $array = $sql->where("tel={$_COOKIE['LoginName']}")->limit($p->firstRow, $p->listRows)->select();//查询当前登录账号的子账户结果
        $mysql = M("uaccount");//连接用户信息表
        $arr2 = $mysql->select();//查询所有用户的结果
        //循环开始
        foreach($arr2 as $value){
            for($i=0;$i<count($array);$i++){
                if($value['tel']==$array[$i]['tel']){//判断资质表中手机号码与用户表手机号码是否相同
                    $array[$i]['real_name'] = $value['real_name'];//相同则写入信息表的真实姓名字段
                }
            }
        }
        //针对某个人
        if($_COOKIE['LoginName']=="18640397217"){
            for($i=0;$i<count($array);$i++){
                if($array[$i]['goods_id']=="2900"){
                    $array[$i]['goods_id']="3200";
                }else if($array[$i]['goods_id']=="29000"){
                    $array[$i]['goods_id']="32000";
                }else if($array[$i]['goods_id']=="320000"){
                    $array[$i]['goods_id']="320000";
                }
            }
        }
        for($i=0;$i<count($array);$i++){
            $time[$i] = explode("-",$array[$i]['approval_time']);
            if($time[$i][0] != "2016"){
                    if($array[$i]['goods_id']=="2900"){
                        $array[$i]['goods_id'] = 3200;
                    }else if($array[$i]['goods_id']=="29000"){
                        $array[$i]['goods_id'] = 32000;
                    }else if($array[$i]['goods_id']=="290000"){
                        $array[$i]['goods_id'] = 320000;
                    }
            }
        }
        //循环结束
        //传值
        $this->assign("ding",$array);
        $this->assign('show', $p->show());
        $this->display();
    }
    //银行卡管理页面
    public function bankCard(){
        $sql = M("yinhangka");//连接银行卡信息表
        $arr = $sql->select();//查询所有结果
        //循环开始
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['user']){//判断当前登录账号是否等于银行卡信息表中的账号字段
                $array[] = $val;//赋值新数组
            }
        }
        //循环结束
        
        //传值
        $this->assign("ka",$array);
        $this->display();
    }
    //提现管理页面
    public function cashManagement(){
        $sql = M("tixian");//连接提现表
        $arr = $sql->select();//查询所有结果
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['user']){//判断当前登录账号是否等于提现表中账号
                $array[] = $val;
            }
        }
        $this->assign("tixian",$array);
        $this->display();
    }
    //电子币充值页面
    public function E_recharge(){
        $sql = M("e_list");//连接电子币充值表
        $arr = $sql->select();//查询所有结果
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){//判断当前登录账号是否等于充值表中账号
                $array[] = $val;
            }
        }
        $this->assign("Name",$array);
        $this->display();
    }
    //电子币转账页面
    public function E_giro(){
        $sql = M("zhuanzhang");//连接转账表
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName'] == $val['name']){
                $array[] = $val;
            }
        }
        foreach($arr as $val){
            if($_COOKIE['LoginName'] == $val['TagertUserName']){
                $array[] = $val;
            }
        }
        $mysql = M("uaccount");//连接用户信息表
        $arr2 = $mysql->select();
        foreach($arr2 as $value){
            for($i=0;$i<count($array);$i++){
                if($value['tel']==$_COOKIE['LoginName']){//匹配结果赋予真实姓名字段
                    $array[$i]['real_name'] = $value['real_name'];
                }
            }
        }
        //传值
        $this->assign("zhang",$array);
        $this->display();
    }
    //电子币充值操作页面
    public function E_list(){
        $sql = M("shoukuan");//连接收款人表
        $arr = $sql->select();//查询所有结果
        $this->assign("ren",$arr);
        $this->display();
    }
    //意义不明页?
    public  function hihihi(){
         $this->display();
    }
    //意义不明页?
    public  function  hihi_hi(){
        $val=$_POST["tel"];
        cookie("LoginName", $val);
        cookie("LoginName",null);
        $this->redirect("member");
    }
    //电子币转账操作页
    public function E_zz(){
        $this->display();
    }
    //取消功能-------------------------------------------------------------------------------------
    public function S_gm(){
        $sql = M("duihuan");
        $arr = $sql->select();
        foreach ($arr as $val){
            if($_COOKIE['LoginName']==$val['user']){
                $array[] = $val;
            }
        }
        $this->assign("qian",$array);
        $this->display();
    }
    //奖金记录主框架页
    public function bonus(){
        $this->display();
    }
    //消费分利记录页
    public function bonus_fenli(){
       $mysql = M("fenli");//连接分利表
        $count = $mysql->where("zhuangtai=1 and tel={$_COOKIE['LoginName']}")->count();//分页条数
        $p = getpage($count,6);//分页
        $a = $mysql->where("zhuangtai=1 and tel={$_COOKIE['LoginName']}")->limit($p->firstRow, $p->listRows)->select();//查询当前登录账号并且分利状态为已发放的结果
        //传值
        $this->assign("ren",$a);
        $this->assign('show', $p->show());
        $this->display();    
    }
    //推荐奖奖励记录页
    public function bonus_tuijian(){
        $sql = M("jiangli");//连接推荐奖奖励表
        $count = $sql->table("jiangli,uaccount")->where("jiangli.zhuangtai=1 and jiangli.tuijian={$_COOKIE['LoginName']} and jiangli.name=uaccount.tel")->count();//分页条数
        $p = getpage($count,6);//分页
        //多表联查
        //查询奖励表与用户信息表
        //查询推荐人姓名相同的结果
        $array = $sql->table("jiangli,uaccount")->where("jiangli.zhuangtai=1 and jiangli.tuijian={$_COOKIE['LoginName']} and jiangli.name=uaccount.tel")->field("jiangli.*,uaccount.real_name")->limit($p->firstRow, $p->listRows)->select(); 
        $this->assign('show', $p->show());
        $this->assign("ding",$array);         
        $this->display();    
    }
    //团队奖励记录页
     public function bonus_tuandui(){
        $tel=$_COOKIE["LoginName"];//当前登录账号cookie
        $m=M("tongji_fafang");//连接团队奖励发放表
        //查询当前登录账号的每月团队记录
        $tongji_fafang=$m->where("tel=$tel and status = 1")->group("tongji_date")->field("sum(emoney) as emoney,tongji_date,sum(guanlifei) as guanlifei,sum(smoney) as smoney,distribute_id")->select();
        $this->assign("tongji_fafang",$tongji_fafang);
        $this->display();
         
     }
     //团队奖励表点击显示详情ajax页
     public function bnous_ajax(){
        $str=file_get_contents('php://input', 'r');//接收页面
        $v=json_decode($str);
        $tel=$_COOKIE["LoginName"];
        $time=$v->time;//接收时间值
        $m=M("tongji_fafang");//连接团队统计发放表
        //以时间为条件查询表
        $tongji_fafang=$m->where("tel='$tel'and tongji_date='$time' and status = 1")->select();
        foreach ($tongji_fafang as $key=>$val){
            //更改zhuangtai为0字段的值为待发放;1为已发放
            switch($val["status"]){
                case 1:$tongji_fafang[$key]["zhuangtai"]="已发放";break;
            }
        }
        //返回数组值
        echo json_encode($tongji_fafang);
    }
    //----------------取消功能(旗舰店奖励)
     public function bonus_fiagship(){         
        $flagship=M("flagship");
        $count = $flagship->table("flagship,flagship_earning")->where("flagship.shop_id=flagship_earning.shop_id and flagship.tel={$_COOKIE['LoginName']}")->count();
        $p = getpage($count,6);
        $flagshi=$flagship->table("flagship,flagship_earning")->where("flagship.shop_id=flagship_earning.shop_id and flagship.tel={$_COOKIE['LoginName']}")->limit($p->firstRow, $p->listRows)->select();
        $this->assign("flagshi",$flagshi);
        $this->assign('show', $p->show());
        $this->display();
     }
    //以下为载入模板页面
    public function finance(){    
        $sql = M("finance");
        $count = $sql->where("user = {$_COOKIE['LoginName']}")->count();
        $p = getpage($count,12);//分页
        $arr = $sql->where("user = {$_COOKIE['LoginName']}")->limit($p->firstRow, $p->listRows)->select();
        $this->assign("arr",$arr);
        $this->assign('show', $p->show());   
        $this->display();
    }
    public function Exchangelist(){
        $this->display();
    }
    public function register(){
        $this->display();
    }
    public function authentication(){
        $this->display();
    }
    public function personalData(){
        $this->display();
    }
    public function modifyPassword(){
        $this->display();
    }
    public function modifyPassword2(){
        $this->display();
    }
    //提交注册页
    public function registerSuccess(){
    $number = 0;//验证变量
        $sql = M("uaccount");//连接用户信息表
        //判断身份证值不为空
        if(!empty($_POST['CodeID'])){
            $where['identity_card'] = $_POST['CodeID'];
            $number +=1;
        }else{
            $number -=1;
        }
        //判断真实姓名值不为空
        if(!empty($_POST['FullName'])){
            $str = $_POST['FullName'];
            if(!eregi("[^\x80-\xff]","$str")){
                $where['real_name'] = $_POST['FullName'];
                $number += 1;
            }
        }else{
            $number -= 1;
        }
        //判断手机号码值不为空
        if(!empty($_POST['fc_Phone'])){
            if(strlen($_POST['fc_Phone'])==11){
                if(is_numeric($_POST['fc_Phone'])){
                    $where['tel'] = $_POST['fc_Phone'];
                    $number += 1;
                }
            }
        }else{
            $number -= 1;
        }
        //判断登录密码值不为空
        if(!empty($_POST['UserPassword'])&&!empty($_POST['fc_TwoPassword'])){
            if(strlen($_POST['UserPassword'])>=6&&strlen($_POST['fc_TwoPassword'])>=6){
                    if($_POST['UserPassword']==$_POST['UserPassword1']){
                        $where['login_pwd'] = md5(md5($_POST['UserPassword']));
                        $number += 1;
                    }else{
                        $number -= 1;
                    }
                    if($_POST['fc_TwoPassword']==$_POST['fc_TwoPassword1']){
                        $where['security_pwd'] = md5(md5($_POST['fc_TwoPassword']));
                        $number += 1;
                    }else{
                        $number -= 1;
                    }
            }
        }
        //服务器时间
        date_default_timezone_set ("PRC");
        $time=time();
        $data=date("Y-m-d H:i:s",$time);
        //注册时间
        $where['created_date'] = $data ;
        //?无用
        $where['dengji'] = 3;
        
        //修改登录手机号码
        $where['change_tel'] = $_POST['fc_Phone'];
        if($number>0){
            $sql->add($where);//注册成功
            $time2= time()+60*60*24*7;
            $name = $_POST['fc_Phone'];
            cookie("LoginName","$name");//存入cookie
            
            //短信验证码接口
            function Post($data, $target){
                $url_info = parse_url($target);
                $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
                $httpheader .= "Host:" . $url_info['host'] . "\r\n";
                $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
                $httpheader .= "Content-Length:" . strlen($data) . "\r\n";
                $httpheader .= "Connection:close\r\n\r\n";
                $httpheader .= $data;
                $fd = fsockopen($url_info['host'], 80);
                fwrite($fd, $httpheader);
                $gets = "";
                while(!feof($fd)) {
                    $gets .= fread($fd, 128);
                }
                fclose($fd);
                if($gets != ''){
                    $start = strpos($gets, '<?xml');
                    if($start > 0) {
                        $gets = substr($gets, $start);
                    }        
                }
                return $gets;
            }
            //发送注册成功提示的短信
            $target = "http://cf.51welink.com/submitdata/service.asmx/g_Submit";
            $post_data = "sname=dlkeylzs&spwd=7521chengduicheng&scorpid=2476&sprdid=1012888&sdst=$name&smsg=".rawurlencode("恭喜您成功注册诚兑城！您的账号为:".$_POST['fc_Phone'].",请您关注微信公众号“诚兑城”以了解更多~"."【诚兑城】");
            $gets = Post($post_data, $target);
        }
        
        //站内信
        $m = M("mail");
        $user = M("uaccount");
        $zname = $user->where("tel='{$_COOKIE['LoginName']}'")->field("real_name")->find();
        $datw['accept_id'] = $_POST['TagertUserName'];
        $datw['send_id'] = $_COOKIE['LoginName'];
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d",$time);
        $datw['time'] = $times;
        $datw['title'] = "转账成功";
        $datw['content'] = "您好，恭喜您注册成功，成为诚兑城的会员，您的账号为".$_POST['fc_Phone'];
        $datw['status'] = 0;
        $datw['type'] = 1;
        $m->add($datw);
        $this->redirect('index',1); 
        
    }
    
    //注册验证码ajax页
    public function verificationCode233(){
       $verify = $_POST['value'];
       $m = M("zheng");
       $find = $m->where("ip = '{$_SERVER['REMOTE_ADDR']}'")->order("id desc")->find();
        if($find['ma'] != $verify){  
            echo "错误";
            die;
        }else{
            $phone = $_POST['user'];//接收注册手机号的值
            $yzm = $_POST['number'];//接收前端生成的验证码
            if($find){
                if($find['ma'] == $verify){
                    $sql = M("yan");
                    $where['yan'] = "验证成功";
                    $where['ip'] = $_SERVER['REMOTE_ADDR'];
                    $sql->add($where);
                }else{
                    $sql = M("yan");
                    $where['yan'] = "验证失败";
                    $where['ip'] = $_SERVER['REMOTE_ADDR'];
                    $sql->add($where);
                }
                $this->fanwen($phone,$yzm);
                echo $yzm;
            }
        }
        
    }
    public function fanwen($phone,$yzm){
        $sql = M("yan");
        $arr = $sql->where("ip='{$_SERVER['REMOTE_ADDR']}'")->order("id desc")->find();
        if($arr['yan'] != "验证成功"){  
            echo "错误";
            die;
        }else{
        //发送验证码短信
            $target = "http://cf.51welink.com/submitdata/service.asmx/g_Submit";
            $post_data = "sname=dlkeylzs&spwd=7521chengduicheng&scorpid=2476&sprdid=1012888&sdst=$phone&smsg=".rawurlencode("您的注册验证码为:".$yzm."【诚兑城】");
            if($find['ma'] == $verify){
                session("lalala","没毛病");
            }
            $gets = $this->Post233($post_data, $target);
        }
    }
    public function Post233($data, $target){
        if($_SESSION['lalala'] != "没毛病"){  
            echo "错误";
            die;
        }else{
            $url_info = parse_url($target);
            $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
            $httpheader .= "Host:" . $url_info['host'] . "\r\n";
            $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
            $httpheader .= "Content-Length:" . strlen($data) . "\r\n";
            $httpheader .= "Connection:close\r\n\r\n";
            $httpheader .= $data;
            $fd = fsockopen($url_info['host'], 80);
            fwrite($fd, $httpheader);
            $gets = "";
            while(!feof($fd)) {
                $gets .= fread($fd, 128);
            }
            fclose($fd);
            if($gets != ''){
                $start = strpos($gets, '<?xml');
                if($start > 0) {
                    $gets = substr($gets, $start);
                }        
            }
            return $gets;
        }
    }
            
    //验证手机号是否注册ajax页
    public function phoneSelect(){
        $phone = $_POST['user'];//接收注册手机号码
        $sql = M("uaccount");//连接用户信息表
        $arr = $sql->select();//查询所有结果
        foreach($arr as $val){
            if($val['change_tel']==$phone||$val['tel']==$phone){//判断表中是否有此账户
                echo 1;//存在便返回1
            }
        }
    }
    //找回密码手机验证码ajax页
    public function forgetCode(){
        //短信接口
        function Post($data, $target) {
            $url_info = parse_url($target);
            $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
            $httpheader .= "Host:" . $url_info['host'] . "\r\n";
            $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
            $httpheader .= "Content-Length:" . strlen($data) . "\r\n";
            $httpheader .= "Connection:close\r\n\r\n";
            $httpheader .= $data;
            $fd = fsockopen($url_info['host'], 80);
            fwrite($fd, $httpheader);
            $gets = "";
            while(!feof($fd)) {
                $gets .= fread($fd, 128);
            }
            fclose($fd);
            if($gets != ''){
                $start = strpos($gets, '<?xml');
                if($start > 0) {
                    $gets = substr($gets, $start);
                }        
            }
            return $gets;
        }
        $phone = $_POST['user'];//接收找回密码的手机号码
        $yzm = $_POST['number'];//接收前端生成的验证码
        //发送找回密码验证密码短信
        $target = "http://cf.51welink.com/submitdata/service.asmx/g_Submit";
        $post_data = "sname=dlkeylzs&spwd=7521chengduicheng&scorpid=2476&sprdid=1012888&sdst=$phone&smsg=".rawurlencode("您正在找回密码，短信验证码为:".$yzm."【诚兑城】");
        $gets = Post($post_data, $target);
        //返回验证码
        echo $yzm;
    }
    //找回密码页验证安全密码ajax页
    public function aPasswordAjax(){
        $pass = md5(md5($_POST['password']));//接收安全密码值并双层md5加密
        $sql = M("uaccount");//连接用户信息表
        $arr = $sql->select();//查询所有结果
        if($_COOKIE['LoginName']){//判断当前是否为登录状态
            foreach($arr as $val){
                if($_COOKIE['LoginName']==$val['tel']){//判断当前登录账号与信息表中是否匹配
                    if($val['security_pwd']==$pass){//判断接收安全密码的值与信息表中安全密码项是否匹配
                        echo 1;//匹配则返回1
                    }
                }
            }
        }
    }
    //查询当前登录账号信息ajax页
    public function cookSelect(){
        $sql = M("uaccount");//连接用户信息表
        $arr = $sql->select();
        if($_COOKIE['LoginName']){
            foreach($arr as $val){
                if($_COOKIE['LoginName']==$val['tel']){
                    echo json_encode($val);//返回当前登录账号的所有信息
                }
            }
        }
    }
    //查询当前登录账号信息ajax页
    public function cookSelect2(){
        $sql = M("uaccount");//连接用户信息表
        $arr = $sql->select();
        $m = M("ucredentials");//连接资质信息表
        $c = $m->select();
        $mysql = M("uassessor");//连接子账户表（此表无用）
        $a = $mysql->select();
        if($_COOKIE['LoginName']){
            foreach($arr as $val){
                if($_COOKIE['LoginName']==$val['tel']){
                    $array = $val;
                }
                foreach ($c as $v){
                    if($v['recommend_id']==$val['user_id']){
                        $array3 = $val;
                    }
                    foreach($a as $value){
                        if($_COOKIE['LoginName']==$value['tel']){
                            $array2 = $value;
                        }
                        if($v['assessor_id']==$value['assessor_id']){
                            $array4 = $value;
                        }
                    }
                    if($_COOKIE['LoginName']==$v['tel']){
                        $array5 = $v;
                    }
                }
            }
        }
        //返回查询所有结果
        $n = array($array,$array2,$array3,$array4,$array5);
        echo json_encode($n);
    }
    //退出登录功能
    public function signOut(){
        cookie('LoginName',null);//清空cookie值
        $this->redirect("index");
    }
    //登录验证ajax功能
    public function loginVerificationAjax(){
        $username = $_POST['user'];//接收登录账号的值
        $password = md5(md5($_POST['pass']));//接收登录密码的值并双层md5加密
        $sql = M("uaccount");//连接用户信息表
        $arr = $sql->select();
        foreach ($arr as $val){
            //重要修改！！！！！！！！！！！！！
            if($username == $val['change_tel']){//判断是否存在此账户
                if($password == $val['login_pwd']){//判断此账户密码是否正确
                    echo 1;
                }else{
                    echo 0;
                }
            }
        }
    }
    //登录表单验证
    public function loginVerification(){
        $username = $_POST['UserName'];//接收登录账号值
        $password = md5(md5($_POST['Password']));//接收登录密码值并双层md5加密
        $sql = M("uaccount");//连接用户信息表
        $arr = $sql->select();//查询所有结果
        foreach ($arr as $val){
            //重要修改
            if($username == $val['change_tel']){
                if($password == $val['login_pwd']){
                    //密码正确--登录成功--存写cookie
                    $time2= time()+60*60*24*7;
                    $name = $val['tel'];
                    cookie("LoginName","$name");
                    if(!empty($_SESSION['login_id'])){
                        $this->redirect("http://www.ch-d-ch.com/Index/product_details/id/".$_SESSION['login_id']);
                    }else{
                        $this->redirect("index");
                    }  
                }
            }
        }
    }
    //找回密码功能
    public function forgetPass(){
        $number = 0;
        $sql = M("uaccount");//连接用户信息表
        $arr = $sql->select();
        foreach($arr as $val){
            if($_POST['phone']==$val['change_tel']){
                $id = $val['user_id'];//取到当前登录账号的信息表主键id
            }
        }
        if(!empty($_POST['password'])){
            if(strlen($_POST['password'])>=6){
                    if($_POST['password']==$_POST['password1']){//修改当前登录账号的登录密码
                        $where['login_pwd'] = md5(md5($_POST['password']));
                        $number += 1;
                    }else{
                        $number -= 1;
                    }
            }
        }
        if($number>0){
            $sql->where("user_id=$id")->save($where);
        }
        $this->redirect('login',1); 
    }
    //找回密码功能ajax页
    public function userRepeat(){
        $name = $_POST['user'];//接收账号名值
        $sql = M("uaccount");//连接用户信息表
        $arr = $sql->select();
        foreach ($arr as $val){
            if($name == $val['change_tel']){//判断账户是否存在
                   echo 1;       
            }
        }
    }
    //同上
    public function UuserRepeat(){
        $name = $_POST['user'];
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach ($arr as $val){
                if($val['change_tel'] == $name||$val['tel']==$name){
                       echo 1;       
                }
        }
    }
    //-------------修改手机号码
    public function phoneUpdat(){
        $phone = $_POST['newpassword1'];
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                $where['change_tel'] = $phone;
                $sql->where("user_id={$val['user_id']}")->save($where);
                $time2= time()+60*60*24*7;
                cookie("LoginName","{$val['tel']}");
                $this->redirect("chenggong");
            }
        } 
    }
    //---------------取消功能（身份证实名验证功能）
    public function realNameAuthentication(){
        if($_COOKIE['LoginName']){
            $sql = M("uaccount");
            $arr = $sql->select();
            $name = $_POST['name'];
            $id = $_POST['idcd'];
            foreach ($arr as $val){
                if($val['tel']==$_COOKIE['LoginName']){
                    $array = $val;
                }
            }
                if(intval($array['auth_time'])<=2&&intval($array['auth_time'])>0){
                    if(!empty($name)){
                        $str = $name;
                        if(!eregi("[^\x80-\xff]","$str")){
                            $where['real_name'] = $name;
                            $number += 1;
                        }
                    }else{
                        $number -=1;
                    }
                    if(!empty($id)){
                        if(strlen($id)==15||  strlen($id)==18){
                            if(is_numeric($id)){
                                $where['identity_card'] = $id;
                                $number += 1;
                            }
                        }
                    }else{
                        $number -= 1;
                    }
                    if($number>0){
                        date_default_timezone_set ("PRC");
                        $time=time();
                        $data=date("Y-m-d H:i:s",$time);
                        $where['auth_date'] = $data ;
                        $where['auth_time'] = $array['auth_time'] - 1;
                        $sql->where("user_id={$array['user_id']}")->save($where);
                        echo $where['auth_time'];
                    }
                    }else{
                        echo 0;
                    }
        }
    }
    //查询当前登录账号信息ajax
    public function information(){
        if($_COOKIE['LoginName']){
            $sql = M("uaccount");
            $arr = $sql->select();
            foreach($arr as $val){
                if($val['tel']==$_COOKIE['LoginName']){
                    echo json_encode($val);
                }
            }
        }
    }
    //查询当前登录账号是否存在
    public function userNameAjax(){
        $user = $_POST['user'];
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach($arr as $val){
            if($val['change_tel']==$user){
                echo 1;
            }
        }
    }
    //判断当前登录账号安全密码是否正确
    public function securityVerification(){
        if($_COOKIE['LoginName']){
            $sql = M("uaccount");
            $arr = $sql->select();
            foreach($arr as $val){
                if($_COOKIE['LoginName']==$val['tel']){
                    $pass = md5(md5($_POST['pass']));
                    if($pass == $val['security_pwd']){
                        echo 1;
                    }
                }
            }
        }
    }
    //个人中心个人资料修改提交
    public function informationModification(){
        $number = 0;
        $sql = M("uaccount");//连接用户信息表
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                $yan = $val;//查询当前登录账号的信息
            }
        }
        $sex = $_POST['sex'];//性别
        $email = $_POST['email'];//电子邮箱
        $address = $_POST['address'];//地址
        $array=array("jpg","gif","png",);//图片后缀名
        //上传头像
        if(count($yan)>0){
            if(!empty($_FILES['files']['size'])){
                    $b=explode(".",$_FILES['files']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['files']['tmp_name'],"Public/upload/$file_name");
                }
            }
            if($file_name){
                $where['head_portrait'] = "/Public/upload/$file_name";
                $number +=1;
            }else{
                $number -=1;
            }
            if(!empty($email)){
                $where['email'] = $email;
                $number +=1;
            }else{
                $number -=1;
            }
            if(!empty($address)){
                $where['address'] = $address;
                $number +=1;
            }else{
                $number -=1;
            }
            //修改信息成功
            if($number>0){
                $where['sex'] = $sex;
                $sql->where("user_id={$yan['user_id']}")->save($where);
                $this->redirect("chenggong");
            }
        }
    }
    //判断当前登录账号的登录密码是否正确
    public function modifyPasswordAjax(){
        $pass = md5(md5($_POST['password']));
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                if($pass == $val['login_pwd']){
                    echo 1;
                }
            }
        }
    }
    //判断当前登录账号的安全密码是否正确
    public function modifyNewPassword(){
        $pass = md5(md5($_POST['password']));
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach ($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                if($pass == $val['security_pwd']){
                    echo 1;
                }
            }
        }
    }
    //修改登录密码功能
    public function updateLpassword(){
        $number = 0;
        $pass1 = $_POST['newpassword1'];//新登录密码的值
        $pass2 = $_POST['newpassword2'];//再次输入密码的值
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                $array = $val;
            }
        }
        if(!empty($pass1)&&!empty($pass2)){
            if(strlen($pass1)>=6&&strlen($pass2)>=6){
                    if($pass1==$pass2){
                        $where['login_pwd'] = md5(md5($pass1));
                        $number += 1;
                    }else{
                        $number -= 1;
                    }
            }
        }
        //修改密码成功
        if($number>0){
           $sql->where("user_id={$array['user_id']}")->save($where);
           $this->redirect("chenggong");
        }
    }
    //判断当前登录账号的安全密码是否正确
    public function modifyPassAjax(){
        $pass = md5(md5($_POST['password']));
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                if($pass == $val['security_pwd']){
                    echo 1;
                }
            }
        }
    }
    //判断当前登录账号的登录密码是否正确
    public function modifyNewPass(){
        $pass = md5(md5($_POST['password']));
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach ($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                if($pass == $val['login_pwd']){
                    echo 1;
                }
            }
        }
    }
    //修改登录密码功能
    public function updateSpassword(){
        $number = 0;
        $pass1 = $_POST['newpassword1'];
        $pass2 = $_POST['newpassword2'];
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                $array = $val;
            }
        }
        if(!empty($pass1)&&!empty($pass2)){
            if(strlen($pass1)>=6&&strlen($pass2)>=6){
                    if($pass1==$pass2){
                        $where['security_pwd'] = md5(md5($pass1));
                        $number += 1;
                    }else{
                        $number -= 1;
                    }
            }
        }
        if($number>0){
           $sql->where("user_id={$array['user_id']}")->save($where);
           $this->redirect("chenggong");
        }
    }
    //生成资质功能
    public function qualifications(){
        
        //-------------------------段立波编写 2016-11-11--------------------------------------
        $tabcredentials = M("ucredentials");
        $tabaccount = M("uaccount");
        $account=$tabaccount->where("tel={$_COOKIE['LoginName']}")->find();
        $m = M("uassessor");
        $zizhi = M("vgoods");
        //全部用户      
        $array = $m->select();
        //上一级的
        $credentials = $tabcredentials->where("zizhanghu='{$_POST['RefUserSubName']}'")->find();
        if($account['emoney']<$_POST['zizhi']){
            var_dump("余额不足!");
            return;
        } 
                //---------修改----------
                 $where['manager'] = $_POST["shopName"];
                 //---------修改----------
                 
                $where['goods_id'] = $_POST['zizhi'];
                $zh = $zizhi->where("price='{$_POST['zizhi']}'")->find();
                $where['zizhis'] = $zh['goods_name'];
                $where['contract_date'] = $_POST['Fc_HTdatetime'];
                $where['assessor_id'] = $_POST['RefUserSubName'];
                //旗舰店
              
                $where['recommend_id'] = $_POST['user_id'];
                
                $where['tid'] =$credentials["crdentials_id"];
                $where['status'] = 0;
                if($_POST['zizhi']==2900||$_POST['zizhi']==29000||$_POST['zizhi']==290000){
                    $where['type'] = 1;
                }elseif($_POST['zizhi']==99000||$_POST['zizhi']==149000||$_POST['zizhi']==199000){
                    $where['type'] = 2;
                    $upt['user_status'] = 1;
                    $tabaccount->where("user_id={$$account['user_id']}")->save($upt);
                }
                $date = $_POST['Fc_HTDateArea'];
                $str = explode("至",$date);
                $where['end_date'] = $str[1];
                ///随机生成编号
                $num = "9808".rand('100000','999999');
                $where['bianhao'] = $num;
                
                
                 $where['tel'] = $_COOKIE['LoginName'];
                   $c = $tabcredentials->where("tel={$_COOKIE['LoginName']}")->select();
                        if(count($c)>0){
                            $d = count($c)+1;
                            $where['zizhanghu'] = $_COOKIE['LoginName']."-".$d;
                        }else{
                            $where['zizhanghu'] = $_COOKIE['LoginName']."-"."1"; 
                        }                              
                $where['jibie'] = $credentials['jibie'] + 1;
                
                $tabcredentials->add($where); 

                $this->redirect("chenggong");
             
             
         
    }
    //生成资质功能（积分）
    public function qualifications2(){
        $sql = M("ucredentials");
        $mysql = M("uaccount");
        $m = M("uassessor");
        $arr = $mysql->select();
        $array = $m->select();
        $bbb = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                if($val['integral']>=$_POST['zizhi']){
                        $where['goods_id'] = $_POST['zizhi'];
                        $where['contract_date'] = $_POST['Fc_HTdatetime'];
                        $where['assessor_id'] = $_POST['RefUserSubName'];
                        $where['shop_id'] = $_POST['shop_id'];
                        $where['recommend_id'] = $_POST['user_id'];
                        foreach($bbb as $ccc){
                            if($_POST['user_id']==$ccc['tel']){
                                $where['tid'] = $ccc['crdentials_id'];
                            }
                        }
                        $where['status'] = 0;
                        $where['type'] = 0;
                        $date = $_POST['Fc_HTDateArea'];
                        $str = explode("至",$date);
                        $where['end_date'] = $str[1];
                        //修改注释
                        $num = "9808".rand('100000','999999');
                        $where['bianhao'] = $num;
                        $where['tel'] = $_COOKIE['LoginName'];
                        foreach($bbb as $e){
                            if($_COOKIE['LoginName']==$e['tel']){
                                $c = $sql->where("tel={$e['tel']}")->select();
                                if(count($c)>0){
                                    $d = count($c)+1;
                                    $where['zizhanghu'] = $_COOKIE['LoginName']."-".$d;
                                }else{
                                    $where['zizhanghu'] = $_COOKIE['LoginName']."-"."1"; 
                                }
                            }
                        }
                        $sql->add($where); 
                        $this->redirect("chenggong");
                    }else{
                    }
                }
            }
    }
    //查询当前登录账号信息
    public function peopleSelect(){
        $user = $_POST['value'];
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach($arr as $val){
                if($user == $val['tel']){
                    echo json_encode($val); 
                }
        }
    }
    //查询资质信息
    public function managerSelect(){
        $user = $_POST['value'];
        $sql = M("ucredentials");
        $arr = $sql->where("status = 1 and teshu !=1")->select();
        foreach($arr as $val){
                if($user == $val['tel']){
                    $array[] = $val;
                }
        }
        echo json_encode($array);
    }
    //查询旗舰店信息
    public function flagSelect(){
        $user = $_POST['value'];
        $sql = M("flagship");
        $arr = $sql->select();
        foreach($arr as $val){
            if($user == $val['shop_no']){
                echo json_encode($val);
            }
        }
    }
    //电子币充值功能
    public function E_money(){
        if(!empty($_POST)){
            $sql = M("E_list");//连接电子币充值表
            $mysql = M("uaccount");//连接用户信息表
            $arr = $mysql->select();
            foreach ($arr as $val){
                if($_COOKIE['LoginName']==$val['tel']){
                    $where['payee'] = $_POST['Fn_RemitAccount_ItemID'];//收款银行卡信息
                    $where['money'] = $_POST['Fn_Amount'];//充值金额
                    if(!empty($_POST['Fc_Remark'])){
                        $where['explain'] = $_POST['Fc_Remark'];//说明
                    }
                    $where['tel'] = $_COOKIE['LoginName'];//当前登录账号
                    $where['name'] = $val['real_name'];//当前登录账号的真实姓名
                    date_default_timezone_set ("PRC");//服务器时间
                    $time=time();
                    $data=date("Y-m-d H:i:s",$time);
                    $where['created_date'] = $data ;//?无此字段
                    $where['time'] = $data;//充值时间
                    $where['status'] = 0;//审核状态 0:未通过 1：已通过
                    $sql->add($where);//写入数据库
                    $this->redirect("chenggong");
                }
            }
        }
    }
    //验证当前登录账号是否存在
    public function useryanzheng(){
        $sql = M("uaccount");
        $arr = $sql->select();
        $user = $_POST['user'];
        foreach($arr as $val){
            if($user == $val['change_tel']){
                echo json_encode($val);
            }
        }
    }
    //同上
    public function useryanzheng2(){
        $user = $_POST['user'];
        if($_COOKIE['LoginName'] == $user){
            echo 1;
        }
    }
    //验证输入账号的真实姓名是否正确
    public function r_nameyanzheng(){
        $sql = M("uaccount");
        $arr = $sql->select();
        $user = $_POST['user'];
        $name = $_POST['val'];
        foreach ($arr as $val){
            if($user == $val['tel']){
                if($name == $val['real_name']){
                    echo 1;
                }
            }
        }
    }
    //转账验证账户电子币是否大于转账金额
    public function moneyyanzheng(){
        $sql = M("uaccount");
        $arr = $sql->select();
        $qian = $_POST['money'];
        $op = $_POST['xiala'];
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                if($val[$op]>=$qian){
                    echo 1;
                }
            }
        }
    }
    //转账验证账户电子币是否大于转账金额
    public function moneyyanzheng2(){
        $sql = M("uaccount");
        $arr = $sql->select();
        $qian = $_POST['money'];
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                if($val['emoney']>=$qian){
                    echo 1;
                }
            }
        }
    }
    //验证当前登录账号的安全密码是否正确
    public function passyanzheng(){
        $sql = M("uaccount");
        $arr = $sql->select();
        $pass = md5(md5($_POST['pass']));
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                if($pass == $val['security_pwd']){
                    echo 1;
                }
            }
        }
    }
    //转账功能
    public function zhuan(){
        $sql = M("uaccount");//连接用户信息表
        $arr = $sql->select();
        $user = $_POST['TagertUserName'];//收款人账号
        $MoveType = $_POST['MoveType'];//转账币种
        $TagertFullName = $_POST['TagertFullName'];//收款人真实姓名
        $Fn_Amount = $_POST['Fn_Amount'];//转账金额
        $Fc_Remark = $_POST['Fc_Remark'];//说明
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                $upt['emoney'] = $val['emoney'] - $Fn_Amount;//减去转出人账号电子币余额
                $sql->where("user_id={$val['user_id']}")->save($upt);
            }
            if($user==$val['change_tel']){
                $upt2['emoney'] = $val['emoney'] + $Fn_Amount;//增加收款人账号电子币余额
                $sql->where("user_id={$val['user_id']}")->save($upt2);
            }
        }
        $user_name = $sql->where("change_tel = $user")->find();
        $mysql = M("zhuanzhang");//连接转账表
        //记录转账明细
        $where['moveType'] = $MoveType;
        $where['TagertUserName'] = $user;
        $where['TagertFullName'] = $user_name['real_name'];
        $where['Fn_Amount'] = $Fn_Amount;
        $where['Fc_Remark'] = $Fc_Remark;
        $where['name'] = $_COOKIE['LoginName'];
        date_default_timezone_set ("PRC");
        $time=time();
        $data=date("Y-m-d H:i:s",$time);
        $where['time'] = $data ;
        $mysql->add($where); 
          //新增代码
        //站内信
        $m = M("mail");
        $user = M("uaccount");
        $zname = $user->where("tel='{$_COOKIE['LoginName']}'")->field("real_name")->find();
        $datw['accept_id'] = $_POST['TagertUserName'];
        $datw['send_id'] = $_COOKIE['LoginName'];
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d",$time);
        $datw['time'] = $times;
        $datw['title'] = "转账成功";
        $datw['content'] = $_POST['TagertFullName']."您好，您在".$times."收到".$zname['real_name']."的转账金额为".$_POST['Fn_Amount']."转账类型为电子币";
        $datw['status'] = 0;
        $datw['type'] = 1;
        $m->add($datw);
        $this->redirect("chenggong");
    }
        //新增代码
    //新闻具体页面
   public function kaiye() {
       $m =M("new");
       $row = $m->where("new_id='{$_GET['id']}'")->find();
       $this->assign('row',$row);
       $rows = $m->where("status=0")->order("new_id desc")->select();
       $this->assign('arr',$rows);
       $this->display();
   }
     //新闻中心
   public function xinwenzhongxin() {
       $m =M("new");
       $row = $m->where("status=0")->order("new_id desc")->select();
       $this->assign('row',$row);
        $rows = $m->where("new_id='{$_GET['id']}'")->find();
       $this->assign('arr',$rows);
       $this->display();
   }
       //身份证验证接口
    public function CodeId() {
        $sql = M("mingdan");
        $tel = $_POST['phone'];
        $where['tel'] = $tel;
        $sql->add($where);
        $arr = $sql->where("tel=$tel")->select();
        if(count($arr)>2){
            echo 123;
        }else{
            
        
        $codeId = "/^\d{14}(\d|x)$/";
        $codeId2 = "/^\d{17}(\d|x)$/";
        if (!preg_match($codeId,$_POST['CodeID']) && !preg_match($codeId2,$_POST['CodeID'])) {
            echo '1';
        } else {
                $host = "http://aliyunverifyidcard.haoservice.com";
                $path = "/idcard/VerifyIdcardv2";
                $method = "GET";
                $appcode = "f94fb87cc1e54a8c961d2294f4ca9037";     
                $headers = array();
                array_push($headers, "Authorization:APPCODE " . $appcode);
                $querys = "cardNo=".$_POST['CodeID']."&realName=".$_POST['FullName'];
                $bodys = "";
                $url = $host . $path . "?" . $querys;

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_FAILONERROR, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
                curl_setopt($curl, CURLOPT_HEADER, false);
                if (1 == strpos("$".$host, "https://"))
                {
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                }
                echo (curl_exec($curl));
            }
        }
    }
    //我的未读消息搜索
    public function mail_page() {
        if (!empty($_COOKIE['LoginName'])) {
            session_start();
            if (empty($_GET['qb'])) {
                session("wtime",$_POST['date']);
            } else {
                session("wtime",null);
            }
            $this->redirect("mail");
        }
    }
        //我的已读消息搜索
    public function mail_page2() {
        if (!empty($_COOKIE['LoginName'])) {
            session_start();
            if (empty($_GET['qb'])) {
                session("ytime",$_POST['date']);
            } else {
                session("ytime",null);
            }
            $this->redirect("mail2");
        }   
    }
    //我的未读消息
    public function mail() {
        if (!empty($_COOKIE['LoginName'])) {
            $m = M("mail");
            if (!empty($_SESSION['wtime'])) {
                $value = $_SESSION['wtime'];
                $data['time'] = array("like","%$value%");
                $data['status'] = 0;
            } else {
                $data['status'] = 0;
            }
            $data['accept_id'] = $_COOKIE['LoginName'];
            $count = $m->where($data)->count();
            $wdcount = $m->where("accept_id='{$_COOKIE['LoginName']}' and status =0")->count();
            $p = getpage($count,12); 
            $p->parameter['name'] =  urlencode($_SESSION['wtime']);
            $row = $m->order('mail_id desc')->where($data)->limit($p->firstRow, $p->listRows)->select();
            $date['accept_id'] = $_COOKIE['LoginName'];
            $date['status'] = 1;
            $rowyi = $m->where($date)->select();
            $ydcount = count($rowyi);
            $this->assign("row",$row);
            $this->assign("wdcount",$wdcount);
            $this->assign('show', $p->show());
            $this->assign("ydcount",$ydcount);
            $this->assign('value', $p->parameter['name']);
            $this->display();
        }
    }
    //已读消息
    public function mail2() {
        if (!empty($_COOKIE['LoginName'])) {
            $m = M("mail");
            $date['accept_id'] = $_COOKIE['LoginName'];
            if (!empty($_SESSION['ytime'])) {
                $value = $_SESSION['ytime'];
                $date['time'] = array("like","%$value%");
                $date['status'] = 1;
            } else {
                $date['status'] = 1;
            }
            $count = $m->where($date)->count();
            $ycount = $m->where("accept_id='{$_COOKIE['LoginName']}' and status =1")->count();
            $p = getpage($count,12); 
            $p->parameter['name'] =  urlencode($_SESSION['ytime']);
            $data['accept_id'] = $_COOKIE['LoginName'];
            $data['status'] = 0;
            $rowyi = $m->where($data)->select();
            $ydcount = count($rowyi);
            $row = $m->order('mail_id desc')->where($date)->limit($p->firstRow, $p->listRows)->select();
            $this->assign("row",$row);
            $this->assign("ydcount",$ycount);
            $this->assign('show', $p->show());
            $this->assign("wdcount",$ydcount);
            $this->assign('value', $p->parameter['name']);
            $this->display();
        }
    }
    //未读消息删除
    public function mail_delete() {
        if (!empty($_COOKIE['LoginName'])) {
            $m =M("mail");
            $data['status'] = 2;
            $row = $m->where("mail_id='{$_GET['id']}'")->save($data);
            $this->redirect("mail");
        }
    }
        //已读消息删除
    public function mail2_delete() {
        if (!empty($_COOKIE['LoginName'])) {
            $m =M("mail");
            $data['status'] = 2;
            $row = $m->where("mail_id='{$_GET['id']}'")->save($data);
            $this->redirect("mail2");
        }
    }
    //消息
    public  function mail_xq() {
        if (!empty($_COOKIE['LoginName'])) {
            $m =M("mail");
            $data['status'] = 1;
            $m->where("mail_id='{$_POST['id']}'")->save($data);
            $row =  $m->where("mail_id='{$_POST['id']}'")->find();
            echo json_encode($row);
        }    
        
    }
    //新增银行卡功能
    public function yinhangadd(){
        if(!empty($_POST)){
            $name = $_POST['fc_BankNamefc_BankName'];//开户银行名称
            $card = $_POST['fc_CardNumber'];//银行卡卡号
            $yinhang = $_POST['yinhang'];//银行名称
            $sql = M("yinhangka");//连接银行卡表
            $where['name'] = $name;
            $where['card'] = $card;
            $where['y_name'] = $yinhang;
            $where['k_name'] = $_POST['name'];//持卡人姓名
            date_default_timezone_set ("PRC");
            $time=time();
            $data=date("Y-m-d H:i:s",$time);
            $where['time'] = $data;//新增时间
            $where['user'] = $_COOKIE['LoginName'];//当前登录账号
            $sql->add($where);//写入数据库
            $this->redirect("chenggong");
        }
    }
    //修改银行卡信息
    public function updateyinhangka(){
        $id = $_GET['id'];//接收银行卡表主键id
        $sql = M("yinhangka");//连接银行卡表
        $arr = $sql->where("y_id=$id")->select();
        $this->assign("ka",$arr);
        //修改信息
        $name = $_POST['fc_BankNamefc_BankName'];
        $card = $_POST['fc_CardNumber'];
        $yinhang = $_POST['yinhang'];
        $where['name'] = $name;
        $where['card'] = $card;
        $where['y_name'] = $yinhang;
        $uid = $_GET['uid'];
        $sql->where("y_id=$uid")->save($where);
        $this->display();
    }
    //商品详情页面
    public function business_shop_beiyong(){
        $sql = M("item"); 
          $sq = M("item_category");
        if(!empty($_POST['searchProduct'])){
            $val = $_POST['searchProduct'];
            $datw['item_name'] = array("like","%$val%");
            $array = $sql->where($datw)->select();
            if (!empty($array)) {
                 $where['item_name'] = array("like","%$val%");
            } else {
              
                $date['category_name'] = array("like","%$val%");
                $ar = $sq->where($date)->field("category_id")->select();
                if (!empty($ar)) {
                     foreach ($ar as $val){
                         $a[]=$val["category_id"];                
                     }             
                     $where["category_id"]=array('in',$a); 
                }
            }      
        } else if(!empty ($_GET['category_id'])) {
//            $category = $sq->where("parent_id='{$_GET['category_id']}'")->select();
//            for($i=0;$i<count($category);$i++) {
//                $c[] = $category[$i]['category_id'];
//            }
//            $c[] = $_GET['category_id'];
//            $where['category_id'] = array("in",$c);
            $cate = $sq->where("category_id='{$_GET['category_id']}'")->find(); //查询这个大类的记录
            if($cate['parent_id'] == 0){
                $guize = $cate['fenleis'];
                if($cate['leiid'] !== ''){
                    $ass = $sq->where("leiid='{$cate['leiid']}'")->order("category_id desc")->find();
                    if($ass['fenleis'] !== $cate['fenleis']){
                        $guize2 = substr($ass['fenleis'],0,5);
                    }
                }
                $shangs = $sql->select(); //查询所有的商品
                for($a=0;$a<count($shangs);$a++){
                   if($guize2){
                        if(substr($shangs[$a]['bar_code'],0,5) == $guize || substr($shangs[$a]['bar_code'],0,5) == $guize2){
                            $sou[] = $shangs[$a]['item_id'];
                        }
                   }else{
                       if(substr($shangs[$a]['bar_code'],0,5) == $guize){
                            $sou[] = $shangs[$a]['item_id'];
                        }
                   }
                }
                $where['item_id'] = array("in",$sou);
            }else{
                $guize = $cate['fenleis'];
                $die = $sq->where("category_id='{$cate['parent_id']}'")->find();
                 if($die['leiid'] !== ''){
                    $ass = $sq->where("leiid='{$die['leiid']}'")->order("category_id desc")->find();
                    if($ass['fenleis'] !== $die['fenleis']){
                        $guize2 = substr($ass['fenleis'],0,5).substr($cate['fenleis'],5);
                    }
                }
                 $shangs = $sql->select(); //查询所有的商品
                for($a=0;$a<count($shangs);$a++){
                   if($guize2){
                        if(substr($shangs[$a]['bar_code'],0,7) == $guize || substr($shangs[$a]['bar_code'],0,7) == $guize2){
                            $sou[] = $shangs[$a]['item_id'];
                        }
                   }else{
                       if(substr($shangs[$a]['bar_code'],0,7) == $guize){
                            $sou[] = $shangs[$a]['item_id'];
                        }
                   }
                }
                $where['item_id'] = array("in",$sou);
            }
        }
        if(!empty($_GET["shopid"])){
            $where["item_id"]=$_GET["shopid"];  
        }
        if(!empty($_GET["id"])){
            $where["mall_id"]=$_GET["id"];
            $guizess = M("mall_guize");
            $scguize = $guizess->where("mall_id='{$_GET['id']}'")->select();
        }
        $where["status"]=0;   
        $count = $sql->where($where)->count();
        $p = getpage($count,20);
        $arr = $sql->where($where)->limit($p->firstRow, $p->listRows)->order("order_num asc,biaoji asc")->select();      
        $this->assign('show', $p->show()); 
        $this->assign("chan",$arr);
        if(!empty($_GET['id'])){
            if($_GET['id'] == 1){
                $fenlei = $sq->select();
                foreach ($fenlei as $vv){
                   $ser = $sq->where("category_id='{$vv['category_id']}'")->find();
                   $sers = $sq->where("leiid='{$ser['leiid']}'")->select();
                   if(count($sers)>1){
                       $wert[] = $ser['category_id'];    
                   }
                }
             $fenss['category_id'] = array("in",$wert);
            $fenss['parent_id'] = 0;
        }else{
                $fenlei = $sq->where("parent_id = 0")->select();
                if($scguize){
                   foreach($fenlei as $value){
                       for($i=0;$i<count($scguize);$i++){
                           if(substr($value['fenleis'],0,3) === $scguize[$i]['guize_name'] && substr($value['fenleis'],6) == ''){
                               $fenleiid[] = $value['category_id'];
                           }
                       }
                   }
                   $fenss['category_id'] = array("in",$fenleiid);
                   $fenss['parent_id'] = 0;
               }
            }
            
        }else{
            $fenss['parent_id'] = 0;
        }
       
        $ar = $sq->where($fenss)->select();
        foreach ($ar as $key=>$val){
            $arr=$sq->where("parent_id={$val["category_id"]}")->select();

            $ar[$key]["parent"]=$arr;
        }
        $this->assign("ren",$ar);
        $this->assign("getid",$_GET["id"]);
        $weizhi = $sq->where("category_id='{$_GET['category_id']}'")->find();
        $this->assign("weizhi",$weizhi);
        $this->display();
    }
    //商品详情页面
    public function business_shop2(){
        $sql = M("item"); 
          $sq = M("item_category");
        if(!empty($_POST['searchProduct'])){
            $val = $_POST['searchProduct'];
            $datw['item_name'] = array("like","%$val%");
            $array = $sql->where($datw)->select();
            if (!empty($array)) {
                 $where['item_name'] = array("like","%$val%");
            } else {
              
                $date['category_name'] = array("like","%$val%");
                $ar = $sq->where($date)->field("category_id")->select();
                if (!empty($ar)) {
                     foreach ($ar as $val){
                         $a[]=$val["category_id"];                
                     }             
                     $where["category_id"]=array('in',$a); 
                }
            }      
        } else if(!empty ($_GET['category_id'])) {
            $category = $sq->where("parent_id='{$_GET['category_id']}'")->select();
            for($i=0;$i<count($category);$i++) {
                $c[] = $category[$i]['category_id'];
            }
            $c[] = $_GET['category_id'];
            $where['category_id'] = array("in",$c);
        }
        if(!empty($_GET["shopid"])){
            $where["item_id"]=$_GET["shopid"];
        }
        if(!empty($_GET["id"])){
            $where["mall_id"]=$_GET["id"];
        }
        $where["status"]=0;   
        $count = $sql->where($where)->count();
        $p = getpage($count,20);
        $arr = $sql->where($where)->limit($p->firstRow, $p->listRows)->order("order_num asc")->select();      
        $this->assign('show', $p->show()); 
        $this->assign("chan",$arr);
        $this->assign("getid",$_GET["id"]);
        $ar = $sq->where("parent_id=0")->select();
        
        foreach ($ar as $key=>$val){
            $arr=$sq->where("parent_id={$val["category_id"]}")->select();

            $ar[$key]["parent"]=$arr;
        }
        $this->assign("ren",$ar);
         $weizhi = $sq->where("category_id='{$_GET['category_id']}'")->find();
        $this->assign("weizhi",$weizhi);
        $this->display();
    }
    //提现管理页面
    public function withdrawals(){
        //查询提现记录
        $sql =  M("yinhangka");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['user']){
                $array[] = $val;
            }
        }
        $this->assign("op",$array);
        $this->display();
    }
    //提现等级验证
     public function moneyyanzheng3(){
        $sql = M("ucredentials");
        $arr = $sql->where("tel='{$_COOKIE['LoginName']}'")->order("yingyee desc")->field("dengji")->limit(1)->find();
        if($arr["dengji"]<=8){
            echo 0; 
        }else{
            echo 1; 
        }
    }
    //---------------取消功能
    public function tixian(){
//        $_COOKIE["LoginName"]=15620526018;
        $ucredentials = M("ucredentials");
        $dengji = $ucredentials->where("tel='{$_COOKIE['LoginName']}'")->order("yingyee desc")->field("dengji")->limit(1)->find();//查等级

        $mysql = M("uaccount");
        $real_name = $mysql->where("tel='{$_COOKIE['LoginName']}'")->field("real_name")->find();//查名字

        
        $time=date("Y-m",time());
        $where["time"]=array("like","$time%");
        $tixian=M("tixian");        
        $sum=$tixian->where($where)->where("user='{$_COOKIE['LoginName']}'")->field("sum(money) as money")->find();//查本月体现金额
    }
    //提现申请
    public function tixianfang(){                
        $qian = $_POST['Fn_AmountRequest'];//提现金额
        $yinhang = $_POST['Fn_WithDraw_Bank'];//提现银行卡信息
        $str = explode(",", $yinhang);    
        
        
        $where['user'] = $_COOKIE['LoginName'];
        
        $mysql = M("uaccount");
        $real_name = $mysql->where("tel='{$_COOKIE['LoginName']}'")->field("real_name")->find();//查名字
        $find = $mysql->where("tel={$_COOKIE['LoginName']}")->find();
        $where['real_name'] = $real_name['real_name']; 
        
        
        $where['money'] = $qian;
        $shouxu = $qian * 0.03;
        if($shouxu>=100){//生成提现手续费
            $shouxu = 100;
            $where['shouxu'] = $shouxu;
            $where['shiji'] = $qian - $shouxu;
        }else{
            $where['shouxu'] = $shouxu;
            $where['shiji'] = $qian - $shouxu;
        }
        $where['yinhangka'] = $str[0];
        $where['y_name'] = $str[1];
        $where['zhihang'] = $str[2];
        $where['zhuangtai'] = 0;//0：未审核 1：已审核
        date_default_timezone_set ("PRC");
        $where['time'] = date("Y-m-d H:i:s",time());
        $a = M("ucredentials");
        $arri =  $a->where("tel = {$_COOKIE['LoginName']} and status = 1")->select();
        foreach($arri as $val){
            if($val['goods_id']==99000||$val['goods_id']==149000||$val['goods_id']==199000){
                $where['biao'] = 1;//家装提现标记
            }
        }
        $ucredentials = M("ucredentials");
        $dengji = $ucredentials->where("tel='{$_COOKIE['LoginName']}'")->order("yingyee desc")->field("dengji")->limit(1)->find();//查等级
        
        $time=date("Y-m",time());
        $w["time"]=array("like","$time%");
        $tixian=M("tixian");        
        $sum=$tixian->where($w)->where("user='{$_COOKIE['LoginName']}'")->field("sum(money) as money")->find();//查本月体现金额         
        $sql=M("tixian");
        //判断提现额度
        if($dengji["dengji"]<=8&&50000-$sum["money"]-$qian>=0){
               $upt['emoney'] = $find['emoney'] - $qian;
               $mysql->where("user_id={$find['user_id']}")->save($upt);
               $sql->add($where);
//               $this->tixian_phone($find['change_tel']);             
               $this->redirect("chenggong");
         }else if($dengji["dengji"]>8&&200000-$sum["money"]-$qian>=0){
               $upt['emoney'] = $find['emoney'] - $qian;
               $mysql->where("user_id={$find['user_id']}")->save($upt);
               $sql->add($where);
//               $this->tixian_phone($find['change_tel']);
               $this->redirect("chenggong");
         }else{
                $tishi = "您本月的提取额度已到上限!";
                echo $tishi;
         }
    }
    public function tixian_phone($tel){
            function Post10($data, $target){
                $url_info = parse_url($target);
                $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
                $httpheader .= "Host:" . $url_info['host'] . "\r\n";
                $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
                $httpheader .= "Content-Length:" . strlen($data) . "\r\n";
                $httpheader .= "Connection:close\r\n\r\n";
                $httpheader .= $data;
                $fd = fsockopen($url_info['host'], 80);
                fwrite($fd, $httpheader);
                $gets = "";
                while(!feof($fd)) {
                    $gets .= fread($fd, 128);
                }
                fclose($fd);
                if($gets != ''){
                    $start = strpos($gets, '<?xml');
                    if($start > 0) {
                        $gets = substr($gets, $start);
                    }        
                }
                return $gets;
            }
            //发送注册成功提示的短信
            $target = "http://cf.51welink.com/submitdata/service.asmx/g_Submit";
            $post_data = "sname=dlkeylzs&spwd=7521chengduicheng&scorpid=2476&sprdid=1012888&sdst=$tel&smsg=".rawurlencode("受春节假期影响，1月25日到2月3日期间提现的操作将在初七(2月3日)后进行审核，请谅解【诚兑城】");
            $gets = Post10($post_data, $target);
    }

    //------------取消功能(兑换电子币)
    public function gwduihuan(){
        $sql = M("duihuan");
        if(!empty($_POST)){
            $where['money'] = $_POST['Fn_Amount'];
            $where['shuoming'] = $_POST['Fc_Remark'];
            $where['user'] = $_COOKIE['LoginName'];
            $where['jifen'] = 1000;
            $where['zhuangtai'] = 0;
            date_default_timezone_set ("PRC");
            $time=time();
            $data=date("Y-m-d H:i:s",$time);
            $where['time'] = $data;
            $sql->add($where);
            $this->redirect("Exchangelist");
        }
    }
    //分利奖金详情页
    public function jiangjinxiangqing(){
        $sql = M("fenli");
        $arr = $sql->where("zhuangtai=1")->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                $array[] = $val;
            }
        }
        $this->assign("ren",$array);
        $this->display();
    }
    //子账户管理-----团队奖励页
    public function zhaoshange(){
        $sql = M("ucredentials");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                $array[] = $val;
            }
        }
        $m = M("uaccount");
        $a = $m->select();
        $mysql = M("tongji");
        $arr2 = $mysql->select();
        for($i=0;$i<count($array);$i++){
            foreach($a as $val){
                if($val['tel']==$array[$i]['tel']){
                    $array[$i]['real_name'] = $val['real_name'];
                }
            }
            foreach($arr2 as $value){
                if($value['name']==$array[$i]['tel']){
                    $array[$i]['yeji'] = $value['yeji'];
                }
            }
        }
        for($i=0;$i<count($array);$i++){
            $time[$i] = explode("-",$array[$i]['approval_time']);
            if($time[$i][0] != "2016"){
                    if($array[$i]['goods_id']=="2900"){
                        $array[$i]['goods_id'] = 3200;
                    }else if($array[$i]['goods_id']=="29000"){
                        $array[$i]['goods_id'] = 32000;
                    }else if($array[$i]['goods_id']=="290000"){
                        $array[$i]['goods_id'] = 320000;
                    }
            }
        }
        $this->assign("ren",$array);
        $this->display();
    }
    //签署资质验证账户电子币余额是否大于产品金额
    public function jineselect(){
        $zijin = $_POST['qian'];
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                if($val['emoney']>=$zijin){
                    echo 1;
                }
            }
        }
    }
    //签署资质验证账户积分余额是否大于产品金额
    public function jineselect2(){
        $zijin = $_POST['qian'];
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                if($val['integral']>=$zijin){
                    echo 1;
                }
            }
        }
    }
    //------------取消功能
    public function gouwuchetj(){
        $id = $_POST['s_id'];
        $sl = $_POST['zhi'];
        $sql = M("item");
        $arr = $sql->where("item_id")->find();
        $m = M("gouwuche");
        $where['item_id'] = $id;
        date_default_timezone_set ("PRC");
        $time=time();
        $data=date("Y-m-d H:i:s",$time);
        $where['created_date'] = $data ;
        $where['time'] = $data;
        $where['user'] = $_COOKIE['LoginName'];
        $where['shuliang'] = $sl;
        $where['status'] = 0;
        $m->add($where);
    }
   //查询银行卡卡号信息
    public function yinhangkasel(){
        $sql = M("yinhangka");
        $arr = $sql->select();
        $yinhang = $_POST['val'];
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['user']){
                if($yinhang==$val['y_name']){
                    echo 1;
                }
            }
        }
    }
    //验证当前登录账号的密码是否正确
    public function pass_back(){
        $pass = md5(md5($_POST['val']));
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                if($pass==$val['login_pwd']){
                    echo 1;
                }
            }
        }
    }
    //找回密码功能------修改原密码
    public function back_pass(){
        $pass = $_POST['newpassword1'];
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['LoginName']==$val['tel']){
                $where['security_pwd'] = md5(md5($pass));
                $sql->where("user_id={$val['user_id']}")->save($where);
            }
        }
        $this->redirect("chenggong");
    }
    //商品详情
    public function product_details_beiyong(){
        session("login_id",NULL);
        $id = $_GET['item_id'];
        $sql = M("item");
        $arr = $sql->where("item_id=$id")->select();
        $m = M("item_category");
        $fl = $m->where("category_id='{$arr[0]['category_id']}'")->find();
        $pp = M("brand");
        $pinpai = $pp->where("brand_id='{$arr[0]['brand_id']}'")->find();
        $this->assign("fenlei",$fl);
        $this->assign("pinpai",$pinpai);
        $this->assign("chan",$arr);
        $this->display();
    }
    //商品详情
    public function product_details2(){
        $id = $_GET['item_id'];
        $sql = M("item");
        $arr = $sql->where("item_id=$id")->select();
        $m = M("item_category");
        $fl = $m->where("category_id='{$arr[0]['category_id']}'")->find();
        $pp = M("brand");
        $pinpai = $pp->where("brand_id='{$arr[0]['brand_id']}'")->find();
        $this->assign("fenlei",$fl);
        $this->assign("pinpai",$pinpai);
        $this->assign("chan",$arr);
        $this->display();
    }
    //商品数量id 存cookie
     public function gouwucheAjax(){
         $str=file_get_contents('php://input', 'r');
         $a = json_decode($str);
         $q=M("item");
         $where["item_id"]=$a->item_id;
         $v=$q->where($where)->find();

         $number=$a->zhi;
         if($v["number"]<$number){
             echo 3;die;
         }         
         if(!empty($_COOKIE['LoginName'])){            
            $m=M("uaccount");
            $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();
            $n=M("uaccount_shop");
             $shop=$n->where("user_id={$arr["user_id"]} and item_id=$a->item_id")->find();
                if($shop){
                    $save["g_id"]=$shop["g_id"];
                    $save["count"]=$a->zhi+$shop["count"];
                    $n->save($save);
                }else{
                    $add["item_id"]=$a->item_id;
                    $add["user_id"]=$arr["user_id"];
                    $add["count"]=$a->zhi;
                    $n->add($add);
                }        
        }else{
              if(!empty($_COOKIE["shop_number"])&&!empty($_COOKIE["shop_item_id"])&&!in_array($a->item_id, explode(",", $_COOKIE["shop_item_id"]))){
                  $zhi=$_COOKIE["shop_number"].",".$a->zhi;
                  $item_id=$_COOKIE["shop_item_id"].",".$a->item_id;
                    cookie("shop_number",$zhi);
                    cookie("shop_item_id",$item_id);             
              }else if(in_array($a->item_id, explode(",", $_COOKIE["shop_item_id"]))){
                  echo 2;die;
              }else{
                   cookie("shop_number",$a->zhi);
                   cookie("shop_item_id",$a->item_id);
              }  
                
        }        
            echo 1;
                 
    }
    //验证商品数量是否充足
    public function loading(){
         $str=file_get_contents('php://input', 'r');
         $a = json_decode($str);
         $number=$a->zhi;
         $item_id=$a->item_id;

          $m=M("uaccount");
          $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();
          $n=M("item");
          $array=$n->where("item_id=$item_id")->find();
          
            if($array["number"]<$number){
                echo 3;die;
            }else{
                $uaccount_order=M("uaccount_order");
                $ad["total_price"]=$array["eMoney"]*$number+$array["sMoney"]*$number;
                $ad["status"]=1;
                $ad["integral"]=$array["Integral"];
                $ad["emenoy"]=$array["eMoney"]*$number;
                $ad["user_id"]=$arr["user_id"];
                $ad["smenoy"]=$array["sMoney"]*$number;
                $ad["order_no"]=date("YmdHis").rand(1000,9999);
                $order_id=$uaccount_order->add($ad);

                
                $uaccount_orderdetail=M("uaccount_orderdetail");
                    $add["item_id"]=$item_id;
                    $add["quantity"]=$number;
                    $add["price"]=$array["eMoney"]+$array["sMoney"];
                    $add["order_id"]=$order_id;
                    $uaccount_orderdetail->add($add);

                echo 1;
                
            }
                 
    }
    //验证商品数量是否充足
    public function loading2(){
         $str=file_get_contents('php://input', 'r');
         $a = json_decode($str);
         $number=$a->zhi;
         $item_id=$a->item_id;

          $m=M("uaccount");
          $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();
          $n=M("item");
          $array=$n->where("item_id=$item_id")->find();
          
            if($array["number"]<$number){
                echo 3;die;
            }else{
                $uaccount_order=M("uaccount_order");
                $ad["total_price"]=$array["eMoney"]*$number+$array["sMoney"]*$number;
                $ad["status"]=1;
                $ad["integral"]=$array["Integral"];
                $ad["emenoy"]=$array["eMoney"]*$number;
                $ad["user_id"]=$arr["user_id"];
                $ad["smenoy"]=$array['sMoney']*$number;
                $ad["order_no"]=date("YmdHis").rand(1000,9999);
                $order_id=$uaccount_order->add($ad);

                
                $uaccount_orderdetail=M("uaccount_orderdetail");
                    $add["item_id"]=$item_id;
                    $add["quantity"]=$number;
                    $add["price"]=$array["eMoney"]+$array["sMoney"];
                    $add["order_id"]=$order_id;
                    $uaccount_orderdetail->add($add);

                echo 1;
                
            }
                 
    }
    
   //购物车
    public function gouwuche(){
        if(!empty($_COOKIE['LoginName'])){
            $m=M("uaccount");
            $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();
            $n=M("uaccount_shop");
            $shop=$n->table("uaccount_shop,vitem")->where("uaccount_shop.user_id={$arr["user_id"]} and uaccount_shop.item_id=vitem.item_id")->order("uaccount_shop.creates_date")->select();
            $this->assign("arr",$shop);
                if(!$shop){
                    $this->redirect("gouwuchewu");
                }            
        }else{
            $m=D("vitem");
            $number=explode(",", $_COOKIE["shop_number"]);
            $item_id=explode(",", $_COOKIE["shop_item_id"]);
            
            for($i=0;$i<count($item_id);$i++){
                $arr[]=$m->where("item_id=$item_id[$i]")->find();
                $arr[$i]["count"]=$number[$i];
            }
             $this->assign("arr",$arr);
                if(empty($_COOKIE["shop_number"])||empty($_COOKIE["shop_item_id"])){
                    $this->redirect("gouwuchewu");
                }            
            
        }         
        $this->display();       
    }   
    //取消功能------------------
    public function gouwuche_shop(){
       $str=file_get_contents('php://input', 'r');
       $a = json_decode($str); 
       $save["g_id"]=$a->g_id;
       $save["count"]=$a->quantity;
       $m=M("uaccount_shop");
       $m->save($save);
    }
    //取消功能-----------------
    public function gouwuched(){
         $str=file_get_contents('php://input', 'r');
         $a = json_decode($str);
        $m=M("uaccount_shop");
        $where["g_id"]=$a->g_id;
        $arr=$m->where($where)->delete();
        if($arr){
        echo 1;
         }
    }
    //商城首页页面
    public function shop_index_beiyong(){
        $sq = M("item_category");//连接商品分类表
        $ar = $sq->where("parent_id=0")->select();
        
        foreach ($ar as $key=>$val){
            $arr=$sq->where("parent_id={$val["category_id"]}")->select();

            $ar[$key]["parent"]=$arr;
        }
        $this->assign("ren",$ar);
        $m =M("new");//连接商城新闻
        $new = $m->limit(3,3)->select();
        $this->assign("new",$new);
        
        $sql = M("phone_banner");//连接商城banner图
        $array = $sql->where("status = 3")->order("banner_id desc")->select();
        $this->assign("banner",$array);
          $p = M("phone_banner");
            $data['status'] = 7;
            $arrss = $p->where($data)->find();
            $this->assign("images",$arrss);
        $this->display();
    }
    
    //------------取消功能
    public function shop_cate(){
         $str=file_get_contents('php://input', 'r');
         $a = json_decode($str); 
         $id=$a->category_id;
         $sq = M("item_category");
         $ar = $sq->where("parent_id=$id")->field("category_id,category_name")->select();
         echo json_encode($ar);
    }

    public function gouwuchewu(){
        $this->display();
    }
    public function gouwutijiao_add(){
        $this->redirect("liulan");
    }
    //生成订单      
    public function loginajax(){
        if(!$_COOKIE['LoginName']){
            echo 1;
        }else{
             $m=M("uaccount");
             $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();
             $orderlist_copy=M("uaccount_shop");
             $money=$orderlist_copy->table("uaccount_shop,item")->where("uaccount_shop.item_id=item.item_id and uaccount_shop.user_id={$arr["user_id"]}")->field("item.eMoney,item.sMoney,item.integral,uaccount_shop.count")->select();
             foreach ($money as $val){
//                if($val['shop_biaoji']==1){
                    $total["price"]+=$val["eMoney"]*$val["count"]+$val["sMoney"]*$val["count"];
                    $total["emenoy"]+=$val["eMoney"]*$val["count"];
                    $total["smenoy"]+=$val["sMoney"]*$val["count"];
                    $total["integral"]+=$val["integral"]*$val["count"];
//                }
             }
             $uaccount_order=M("uaccount_order");
             $ad["total_price"]=$total["price"];             
             $ad["status"]=1;
             $ad["integral"]=$total["integral"];
             $ad["emenoy"]=$total["emenoy"];
             $ad["smenoy"]=$total["smenoy"];
             $ad["user_id"]=$arr["user_id"];       
             $ad["order_no"]=date("YmdHis").rand(1000,9999);
             $order_id=$uaccount_order->add($ad);
             $n=D("orderlist");
             $array=$n->where("user_id={$arr["user_id"]}")->select();  
            
             foreach ($array as $key=>$val){
//                 if($val['shop_biaoji']==1){
                    $uaccount_orderdetail=M("uaccount_orderdetail");
                    $add["item_id"]=$val["item_id"];
                    $add["quantity"]=$val["count"];
                    $add["price"]=$val["sMoney"]+$val["eMoney"];
                    $add["order_id"]=$order_id;
                   $uaccount_orderdetail->add($add);
//                 }
             }
             
             echo 2;
        }
        
    }
    //------------取消功能
     public function loginyes(){
        $str=file_get_contents('php://input', 'r');
        $v=json_decode($str);
        $pass=md5(md5($v->password));
        $m=M("uaccount");
        $arr=$m->where("tel=$v->name")->find();
        if($arr["login_pwd"]==$pass){
            echo 1;
        }
        
    }
    //-------------取消功能
    public function logincookie(){
        cookie("LoginName",$_POST["UserName"]);
          if(!empty($_COOKIE['LoginName'])){
            $number=explode(",", $_COOKIE["shop_number"]);
            $item_id=explode(",", $_COOKIE["shop_item_id"]);
            
            for($i=0;$i<count($item_id);$i++){          
                $m=M("uaccount");
                $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();
                $n=M("uaccount_shop");
                 $shop=$n->where("user_id={$arr["user_id"]} and item_id=$item_id[$i]")->find();
                    if($shop){
                        $save["g_id"]=$shop["g_id"];
                        $save["count"]=$number[$i]+$shop["count"];
                        $n->save($save);
                    }else{
                        $add["item_id"]=$item_id[$i];
                        $add["user_id"]=$arr["user_id"];
                        $add["count"]=$number[$i];
                        $n->add($add);
                    }
             }
          }
        $this->redirect("gouwuche");

    }   
  //团购添加地址
    public function group_address(){
        $str=file_get_contents('php://input', 'r');
        $v=json_decode($str);

        $user_id = $v->userId;
        $real_name=$v->name;
        $tel=$v->tel;
        $Address_Name=$v->text;

        $m=M("torderaddress");
        $arr=$m->where("User_ID=$user_id and status=1")->find();
        $this->assign("arr",$arr);

        if($arr){
            $save["status"]=0;
            $save["Address_id"]=$arr["Address_id"];
            $m->save($save);
        }
        $add["Address_Name"]=$Address_Name;
        $add["real_name"]=$real_name;
        $add["tel"]=$tel;
        $add["User_ID"]=$user_id;
        $add["status"]=1;
        $array = $m->add($add);
        $a=$m->where("User_ID=$user_id")->order("status desc")->select();
        if($a){
            echo 1;
        }
    }
    
  //获取我的地址
    public function GetMyAddress(){
        $m=M("uaccount");
        $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();
        if($arr){
            $n=M("uaccount_address");
            $address=$n->where("user_id={$arr["user_id"]}")->order("status desc")->select();
        }
        echo json_encode($address);
    }
//添加地址
    public function addAddress(){
        $str=file_get_contents('php://input', 'r');
        $v=json_decode($str);
        $m=M("uaccount");
        $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();
        $n=M("uaccount_address");
        $array=$n->where("user_id={$arr["user_id"]} and status=1")->find();

        if($array){
            $save["status"]=0;
            $save["address_id"]=$array["address_id"];
            $n->save($save);
        }
        
        $add["user_id"]=$arr["user_id"];
        $add["address_people"]=$v->address_peopl;
        $add["address_tel"]=$v->address_tel;
        $add["address_details"]=$v->address_details;
        $add["status"]=1;
        $add["address_provinces"]=$v->address_provinces;
        $c = $n->add($add);
        if($c){
            echo 1;
        }
    }
    //删除地址
    public function delete_address(){
        $str=file_get_contents('php://input', 'r');
        $a = json_decode($str);
        $Address_id["address_id"]=$a->address_id;
        $m=M("uaccount_address");
         $result=$m->where($Address_id)->delete();
        if ($result)
        {
           echo 1;
        }
        else{
            echo 0;
        }


    }
    //修改默认地址
    public function setDefaultAddress(){
        $str=file_get_contents('php://input', 'r');
        $a = json_decode($str);
        $m=M("uaccount");
        $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();      
        $n=M("uaccount_address");
        $save["status"]=0;
        $n->where("user_id={$arr["user_id"]}")->data($save)->save();


        $s["address_id"]=$a->address_id;
        $s["status"]=1;

        $result = $n->save($s);
       

        if($result){
            echo 1;
        }else{
            echo 0;
        }

    }

    //编辑地址
    public function editAddress(){
        $str=file_get_contents('php://input', 'r');
        $a = json_decode($str);
        $save["Address_id"]=$a->address_id;
        $save["Address_Name"]=$a->address;
        $save["real_name"]=$a->name;
        $save["tel"]=$a->tel;
        $m=M("torderaddress");
        $m->save($save);
        $arr=$m->where("Address_id=$a->address_id")->select();
   if($arr){
       echo 1;
   }else{
       echo 0;
   }
    }
        //支付提交
    public function liulan(){
        $m=M("uaccount");
        $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();
        $n=D("payorder");        
        $array=$n->where("user_id={$arr["user_id"]} and status=1")->order("create_date desc")->find();
        $arra=$n->where("order_id={$array["order_id"]}")->select();
        $this->assign("val",$arra);
        $this->assign("arry",$arr);
        $this->display();
    }
    //当前登录账号登录密码验证
    public function pay_ajax(){
        $value=$_POST["value"];
        $username=$_COOKIE["LoginName"];
        $m=M("uaccount");
        $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();
        if($arr["security_pwd"]!=md5(md5($value))){           
            echo 1;
        }
    }
    //验证当前登录账号电子币余额是否足够
    public function pay_updatex(){
        $str=file_get_contents('php://input', 'r');
        $a = json_decode($str);

        $m=M("uaccount_order");
        $uaccount_order=$m->where("order_id=$a->order_id")->find();
       
        $n=M("uaccount");
        $uaccount=$n->where("tel={$_COOKIE["LoginName"]}")->find();
        
        $gouwuche=M("uaccount_shop");
        $gouwuche->where("user_id={$uaccount["user_id"]}")->delete();
       if($uaccount_order["emenoy"]>$uaccount["emoney"]||$uaccount_order["smenoy"]>$uaccount["smoney"]){
           echo 2;
       }else if($uaccount['no_money']>0){
           if($uaccount_order['emenoy']>$uaccount['no_money']){
               echo 3;
           }else{
            $save["pay_date"]=date("Y-m-d H:i:s");
           $save["address_id"]=$a->madress;
           $save["status"]=2;
           $save["bean"]=$uaccount["bean"];
           $save["order_id"]=$a->order_id;
           $m->save($save);
           $save_n["emoney"]=$uaccount["emoney"]+$uaccount["bean"]-$uaccount_order["emenoy"];
           $save_n["smoney"]=$uaccount["smoney"]+$uaccount["bean"]-$uaccount_order["smenoy"];
           $save_n["bean"]=0;
           $save_n["integral"]=$uaccount_order["integral"];
           $save_n["user_id"]=$uaccount["user_id"];
           $n->save($save_n);
           
                    $l=D("payorder");
                    $payorder=$l->where("order_id=$a->order_id")->select();
                        foreach($payorder as $value){
                            $q=M("item");
                            $save_item["item_id"]=$value["item_id"];
                            $save_item["number"]=$value["number"]-$value["quantity"];
                            $q->save($save_item);
                            
                            //-----------2016-12-23新增内容---------------
                            if($uaccount['no_money']>0){
                                $sql = M("item");
                                $item = $sql->where("biaoji = 1")->select();
                                for($i=0;$i<count($item);$i++){
                                    if($value['item_id'] == $item[$i]['item_id']){
                                        if($uaccount['no_money'] >= $value['g_xj_price']){
                                            $upt['no_money'] = $uaccount['no_money'] - $value['g_xj_price'];
                                            $upt['emoney'] = $uaccount['emoney'] + $value['q_xj_price'];
                                            $n->where("user_id={$uaccount['user_id']}")->save($upt);
                                        }
                                    }
                                }
                            }
                    }
           echo 1;
           }
       }else{
           $save["pay_date"]=date("Y-m-d H:i:s");
           $save["address_id"]=$a->madress;
           $save["status"]=2;
           $save["bean"]=$uaccount["bean"];
           $save["order_id"]=$a->order_id;
           $m->save($save);
           $save_n["emoney"]=$uaccount["emoney"]+$uaccount["bean"]-$uaccount_order["emenoy"];
           $save_n["smoney"]=$uaccount["smoney"]+$uaccount["bean"]-$uaccount_order["smenoy"];
           $save_n["bean"]=0;
           $save_n["integral"]=$uaccount_order["integral"];
           $save_n["user_id"]=$uaccount["user_id"];
           $n->save($save_n);
           
                    $l=D("payorder");
                    $payorder=$l->where("order_id=$a->order_id")->select();
                        foreach($payorder as $value){
                            $q=M("item");
                            $save_item["item_id"]=$value["item_id"];
                            $save_item["number"]=$value["number"]-$value["quantity"];
                            $q->save($save_item);
                            
                            //-----------2016-12-23新增内容---------------
                            if($uaccount['no_money']>0){
                                $sql = M("item");
                                $item = $sql->where("biaoji = 1")->select();
                                for($i=0;$i<count($item);$i++){
                                    if($value['item_id'] == $item[$i]['item_id']){
                                        if($uaccount['no_money'] >= $value['g_xj_price']){
                                            $upt['no_money'] = $uaccount['no_money'] - $value['g_xj_price'];
                                            $upt['emoney'] = $uaccount['emoney'] + $value['q_xj_price'];
                                            $n->where("user_id={$uaccount['user_id']}")->save($upt);
                                        }
                                    }
                                }
                            }
                    }
           echo 1;
       }
    }
    //门票付款
    public function pay_menpiao(){
        $str=file_get_contents('php://input', 'r');
        $a = json_decode($str);

        $m=M("uaccount_order");
        $uaccount_order=$m->where("order_id=$a->order_id")->find();
       
        $n=M("uaccount");
        $uaccount=$n->where("tel={$_COOKIE["LoginName"]}")->find();
        
        $gouwuche=M("uaccount_shop");
        $gouwuche->where("user_id={$uaccount["user_id"]}")->delete();
       if($uaccount_order["emenoy"]>$uaccount["emoney"]||$uaccount_order["smenoy"]>$uaccount["smoney"]){
           echo 2;
       }else{
           $save["pay_date"]=date("Y-m-d H:i:s");
           $save["address_id"]=$a->madress;
           $save["status"]=1;
           $save["bean"]=$uaccount["bean"];
           $save["order_id"]=$a->order_id;
           $m->save($save);
           $save_n["emoney"]=$uaccount["emoney"]+$uaccount["bean"]-$uaccount_order["emenoy"];
           $save_n["smoney"]=$uaccount["smoney"]+$uaccount["bean"]-$uaccount_order["smenoy"];
           $save_n["bean"]=0;
           $save_n["integral"]=$uaccount_order["integral"];
           $save_n["user_id"]=$uaccount["user_id"];
           $n->save($save_n);
           
                    $l=D("payorder");
                    $payorder=$l->where("order_id=$a->order_id")->select();
                        foreach($payorder as $value){
                            $q=M("item");
                            $save_item["item_id"]=$value["item_id"];
                            $save_item["number"]=$value["number"]-$value["quantity"];
                            $save_item["rale"] = $value['rale'] + $value['quantity'];
                            $q->save($save_item);
                    }
           $this->menpiao_creat($a->order_id);
           echo 1;   
       }
    }
    //创建门票
    public function menpiao_creat($id){
        $sql = M("uaccount_orderdetail");
        $mysql = M("item");
        $arr = $sql->where("order_id = $id")->select();
        $m = M("uaccount");
        $sq = M("kaquan");
        $user = $m->where("tel = {$_COOKIE['LoginName']}")->find();
        foreach($arr as $val){
            $find = $mysql->where("item_id = {$val['item_id']}")->find();
            for($i=0;$i<$val['quantity'];$i++){
                $time = $find['menpiao_time'];
                $time = substr($time,0,10);
                $data = explode("-",$time);
                $new_time = substr($data[0],2,2).$data[1].$data[2];
                $number = $this->number();
                $key = $new_time.$number;
                $add['kaquan_key'] = $key;
                $add['time'] = substr($find['menpiao_time'],0,10);
                $add['user_id'] = $user['user_id'];
                $add['status'] = 0;
                $add['piaojia'] = $find['eMoney'];
                $add['item_id'] = $find['item_id'];
                $sq->add($add);
            }
        }
    }
    //退票
    public function tuipiao(){
        $id = $_POST['id'];
        $sql = M("uaccount");
        $mysql = M("kaquan");
        $m = M("item");
        $find = $sql->where("tel = {$_COOKIE['LoginName']}")->find();
        $arr = $mysql->where("kaquan_id = $id")->find();
        $item = $m->where("item_id = {$arr['item_id']}")->find();
        
        $upt['emoney'] = $find['emoney'] + $arr['piaojia'];
        $a = $sql->where("user_id = {$find['user_id']}")->save($upt);
        $upt2['status'] = 3;
        $b = $mysql->where("kaquan_id = $id")->save($upt2);
        $upt3['number'] = $item['number'] + 1;
        $upt3['rale'] = $item['rale'] - 1;
        $c = $m->where("item_id = {$arr['item_id']}")->save($upt3);
        if($a && $b && $c){
            echo 1;
        }else{
            echo 2;
        }
    }
    //生成随机数
     public function number(){
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        mt_srand(10000000*(double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < 8; $i++){
            $str .= $chars[mt_rand(0, $lc)];  
        }
        return $str;
    }
    //订单
    public function dingdanxiangqing(){
        $m=M("uaccount");       
        $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();
        $n=M("uaccount_order");
//       
        $order=$n->where("user_id={$arr["user_id"]}  and status=2 and shenhe !=2")->order("create_date desc")->select(); 
      
          $dd = M("uaccount_orderdetail");
        foreach ($order as $v){
            $a[] = $v['order_id'];
        }
        $data['order_id'] = array("in",$a);
         $count = $dd->where($data)->count();
        $p = getpage($count,5);
        $dds = $dd->where($data)->limit($p->firstRow, $p->listRows)->select(); //查询订单
        for($i=0;$i<count($dds);$i++){
            for($w=0;$w<count($order);$w++){
                if(!in_array($dds[$i]['order_id'], $r)){
                    if($dds[$i]['order_id'] == $order[$w]['order_id']){
                        $dds[$i]['order_no'] = $order[$w]['order_no'];
                        $dds[$i]['total_price'] = $order[$w]['total_price'];
                        $dds[$i]['type'] = $order[$w]['type'];
                        $dds[$i]['emenoy'] = $order[$w]['emenoy'];
                        $dds[$i]['smenoy'] = $order[$w]['smenoy'];
                        $dds[$i]['status'] = $order[$w]['status'];
                        $dds[$i]['time'] = $order[$w]['create_date'];
                        $dds[$i]['tuihuo'] = $order[$w]['tuihuo'];
                        $r[] = $dds[$i]['order_id'];
                    }
                }
            }
        }
        $sp = M("item");
        $sps = $sp->select(); //查询商品
        for($q=0;$q<count($dds);$q++){
            for($s=0;$s<count($sps);$s++){
                if($dds[$q]['item_id'] == $sps[$s]['item_id']) {
                    $dds[$q]['item_name'] = $sps[$s]['item_name'];
                }
            }
        }
        $this->assign("dd",$dds);
        $this->assign('show', $p->show());
        $this->assign("arr",$order);       
        $this->display();
    }
    //已支付订单页面
    public function dingdanxiangqing_Y(){
        $m=M("uaccount");       
        $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();
        $n=M("uaccount_order");
//       
        $order=$n->where("user_id={$arr["user_id"]}  and shenhe=2")->order("create_date desc")->select(); 
      
          $dd = M("uaccount_orderdetail");
        foreach ($order as $v){
            $a[] = $v['order_id'];
        } 
        $data['order_id'] = array("in",$a);
         $count = $dd->where($data)->count();
        $p = getpage($count,15);
        $dds = $dd->where($data)->limit($p->firstRow, $p->listRows)->select(); //查询订单
        $time =date("Y-m-d",strtotime("-9 day"));
        //判断九天之内可以退货
        for($a=0;$a<count($dds);$a++){
            if($dds[$a]['create_date'] < $time){
                $dds[$a]['kt'] = 1;
            }else{
               $dds[$a]['kt'] = 2;
            }
        }
        for($i=0;$i<count($dds);$i++){
            for($w=0;$w<count($order);$w++){
                if(!in_array($dds[$i]['order_id'], $r)){
                    if($dds[$i]['order_id'] == $order[$w]['order_id']){
                        $dds[$i]['order_no'] = $order[$w]['order_no'];
                        $dds[$i]['total_price'] = $order[$w]['total_price'];
                        $dds[$i]['type'] = $order[$w]['type'];
                        $dds[$i]['emenoy'] = $order[$w]['emenoy'];
                        $dds[$i]['smenoy'] = $order[$w]['smenoy'];
                        $dds[$i]['status'] = $order[$w]['status'];
                        $dds[$i]['time'] = $order[$w]['create_date'];
//                        $dds[$i]['tuihuo'] = $order[$w]['tuihuo'];
                        $r[] = $dds[$i]['order_id'];
                    }
                }
            }
        }
        $sp = M("item");
        $sps = $sp->select(); //查询商品
        for($q=0;$q<count($dds);$q++){
            for($s=0;$s<count($sps);$s++){
                if($dds[$q]['item_id'] == $sps[$s]['item_id']) {
                    $dds[$q]['item_name'] = $sps[$s]['item_name'];
                    $dds[$q]['mall_id'] = $sps[$s]['mall_id'];
                    $dds[$q]['dianzi'] = $sps[$s]['eMoney'];
                    $dds[$q]['gouwu'] = $sps[$s]['sMoney'];
                }
            }
        }
        $this->assign("dd",$dds);
        $this->assign('show', $p->show());
        $this->assign("arr",$order);  
        $this->display();
    }
    //已支付订单详情页面
        public function dingdan_detail(){
        $m = M("uaccount_orderdetail");
        $arr = $m->where("detail_id='{$_GET['id']}'")->find();
        $sp = M("item"); 
        $sps = $sp->where("item_id='{$arr['item_id']}'")->find();
        $arr['item_name'] = $sps['item_name'];
        $this->assign("arr",$arr);
       
        $this->display();
    }
    //未支付订单支付电子币余额验证
    public function dingdan_pay(){
         $m = M("uaccount");
         $arr=$m->where("tel={$_COOKIE["LoginName"]}")->find();
         $uaccount_order = M("uaccount_order");
         $uaccount=$uaccount_order->where("order_id={$_POST["value"]}")->find();
            if($arr["emoney"]>=$uaccount["emenoy"]&&$arr["smoney"]>=$uaccount["smenoy"]){
                $save["emoney"]=$arr["emoney"]-$uaccount["emenoy"];
                $save["smoney"]=$arr["smoney"]-$uaccount["smenoy"];
                $save["user_id"]=$arr["user_id"];
                $m->save($save);
                $save_u["order_id"]=$_POST["value"];
                $save_u["status"]=2;
                $uaccount_order->save($save_u);
                $this->pay_inventory($_POST["value"]);
                echo 2;
            }else{
                echo 1;
            }
    }
    //支付成功修改商品数量
    public function pay_inventory($order_id){        
            $l=D("payorder");
            $payorder=$l->where("order_id=$order_id")->select();
            foreach($payorder as $value){
                $q=M("item");
                $save_item["item_id"]=$value["item_id"];
                $save_item["number"]=$value["number"]-$value["quantity"];
                $q->save($save_item);
           }
        
    }
    //---------------取消功能
    public  function shop_select(){  //ajax 调用链接 url：shop_select
       $value=$_POST["value"];     //传值data：{value:自取}
       $m=M("item");
       $arr=$m->where("item_name like '%$value%'")->field("item_name")->limit(5)->select();
       echo json_encode($arr);    //输出名  item_name
       
    }
    //取消功能------------------
      public  function shop_sel(){
       $value=$_POST["value"];    
       $m=M("item");
       $arr=$m->where("item_name like '%$value%'")->find();
       echo $arr["item_id"];    
       
    }
    //-------------取消功能（新主页）
    public function shop_index(){
        if($_COOKIE['LoginName']){
            $m = M("uaccount");
            $find = $m->where("tel = {$_COOKIE['LoginName']}")->find();
            $this->assign("find",$find);
            $sql = M("uaccount_shop");
            $arr = $sql->where("user_id = {$find['user_id']}")->count();
            $this->assign("gouwunum",$arr);
        }
        $sq = M("item_category");//连接商品分类表
        $sps = M("item");
        $span=$sps->select();
        $danwei = M("item_unit");
        $dw = $danwei->select();
        $ar = $sq->where("parent_id=0")->order("dalei_px asc")->select();
        for($a=0;$a<count($ar);$a++){
            for($w=0;$w<count($span);$w++){
                if($ar[$a]['item_tj1'] == $span[$w]['item_id']){
                    $ar[$a]['item_name1']=  $span[$w]['item_name'];
                    $ar[$a]['mall_id1']=  $span[$w]['mall_id'];
                    $ar[$a]['img_url1']=  $span[$w]['img_url'];
                    $ar[$a]['qian1']=  $span[$w]['eMoney'];
                    $ar[$a]['qian11']=  $span[$w]['sMoney'];
                    $ar[$a]['unit_id1'] = $span[$w]['unit_id'];
                }
            }
             for($k=0;$k<count($span);$k++){
                if($ar[$a]['item_tj2'] == $span[$k]['item_id']){
                    $ar[$a]['item_name2']=  $span[$k]['item_name'];
                    $ar[$a]['mall_id2']=  $span[$k]['mall_id'];
                    $ar[$a]['img_url2']=  $span[$k]['img_url'];
                    $ar[$a]['qian2']=  $span[$k]['eMoney'];
                    $ar[$a]['qian22']=  $span[$k]['sMoney'];
                    $ar[$a]['unit_id2'] = $span[$k]['unit_id'];
                }
            }
            for($q=0;$q<count($dw);$q++){
                if($ar[$a]['unit_id1'] == $dw[$q]['unit_id']){
                    $ar[$a]['unit_name1']=  $dw[$q]['unit_name'];
                }
            }
            for($e=0;$e<count($dw);$e++){
                if($ar[$a]['unit_id2'] == $dw[$e]['unit_id']){
                    $ar[$a]['unit_name2']=  $dw[$e]['unit_name'];
                }
            }
        }
//        dump($ar);
        foreach ($ar as $key=>$val){
            $arr=$sq->where("parent_id={$val["category_id"]}")->order("xiaolei_px asc")->select();

            $ar[$key]["parent"]=$arr;  
        }
        foreach($ar as $val){
            if($val['fenleis'] != 69310){
                $new_ar[] = $val;
            }
        }
//        dump($ar);
        $this->assign("ren",$new_ar);
        $m =M("new");//连接商城新闻
        $new = $m->where("gonggao=1")->order("new_px asc")->select();
        $this->assign("new",$new);
         $news = $m->where("xp_tj=1")->order("xp_px asc")->select();
        $this->assign("news",$news);
        
        $sql = M("phone_banner");//连接商城banner图
        $array = $sql->where("status = 3")->order("banner_id desc")->select();
        $this->assign("banner",$array);
        $p = M("phone_banner");
        $data['status'] = 7;
        $arrss = $p->where($data)->find();
        $this->assign("images",$arrss);
        
        $sq = M("item_category");
        $fenss['parent_id'] = 0;
        $ar = $sq->where($fenss)->select();
        foreach ($ar as $key=>$val){
            $arr=$sq->where("parent_id={$val["category_id"]}")->select();

            $ar[$key]["parent"]=$arr;
        }
        $tj = $sq->where("category_tj = 1 ")->order("category_px asc")->select();
        $this->assign("category_tj",$tj);
        $this->display();
    }
    public function seaajax(){
        $value = $_POST['value'];
//        $value = "珍珠";
        $sql = M("item");
        if(!empty($value)){
            $cha['item_name'] = array("LIKE","%$value%");
            $cha['status'] = 0;
            $arr = $sql->where($cha)->select();
//            dump($arr);
            echo json_encode($arr);               
        }
    }
    //树形图页面
    public function tree(){
        if($_COOKIE['LoginName']){
            $menu = M('ucredentials');
            $arr = $menu->where("tel = {$_COOKIE['LoginName']}")->select();
            foreach($arr as $val){
                $a[] = $menu->where("tid = {$val['crdentials_id']}")->select();
            }
            for($i=0;$i<count($a);$i++){
                $arr[$i]['count'] = count($a[$i]);
                if(count($a[$i])==0){
                    $arr[$i]['biaoshi'] = 1;
                }
                $time[$i] = explode("-", $arr[$i]['approval_time']);
                if($time[$i][0]==2016){
                }else{
                    if($arr[$i]['goods_id']==2900){
                        $arr[$i]['goods_id'] = 3200;
                    }else if($arr[$i]['goods_id']==29000){
                        $arr[$i]['goods_id'] = 32000;
                    }else if($arr[$i]['goods_id']==290000){
                        $arr[$i]['goods_id'] = 320000;
                    }
                }
            }
            $this->assign("user",$arr);
            $this->display();
        }      
    }
    //树形图查询ajax
    public function ajax_tree(){
        $id = $_POST['id'];
        $m = M("ucredentials");
        $arr = $m->where("tid=$id")->select();
        $sql = M("uaccount");
        $array = $sql->select();
        foreach($array as $val){
            for($i=0;$i<count($arr);$i++){
                if($val['tel']==$arr[$i]['tel']){
                    $arr[$i]['real_name'] = $val['real_name'];
                }
            }
        }
        foreach($arr as $val){
            $a[] = $m->where("tid = {$val['crdentials_id']}")->select();
        }
        for($i=0;$i<count($a);$i++){
            $arr[$i]['count'] = count($a[$i]);
            if(count($a[$i])==0){
                $arr[$i]['biaoshi'] = 1;
            }
            $time[$i] = explode("-", $arr[$i]['approval_time']);
            if($time[$i][0]==2016){
            }else{
                if($arr[$i]['goods_id']==2900){
                    $arr[$i]['goods_id'] = 3200;
                }else if($arr[$i]['goods_id']==29000){
                    $arr[$i]['goods_id'] = 32000;
                }else if($arr[$i]['goods_id']==290000){
                    $arr[$i]['goods_id'] = 320000;
                }
            }
        }
        echo json_encode($arr);
    }
    //ajax查询业绩与上月对比
    public function tree_data_ajax(){
        if($_POST['id']){
            $id = $_POST['id'];
            $sql = M("ucredentials");
            date_default_timezone_set ("PRC");
            $time=time();
            $data=date("Y-m-d",$time);
            $map['approval_time']=array('between',array(date('Y-m-01', strtotime('-1 month')),date('Y-m-t', strtotime('-1 month'))));
            $ben['approval_time'] = array('between',array(date("Y-m-01",$time),$data));
            $array = $sql->where($map)->where("tid = $id")->select();
            $arr = $sql->where($ben)->where("tid = $id")->select();
            echo json_encode(array("benyue"=>count($arr),"shangyue"=>count($array)));
        }
    }
    //已收货的退货
    public function tuihuo(){
        $m =M("uaccount_order"); //连接用户订单
        $data['tuihuo'] = 1;
        $arr =$m->where("order_id='{$_POST['id']}'")->save($data);
        if($arr){
            echo 1;
            exit();
        }else{
            echo 2;
            exit();
        }
        
    }
    //退货申请提交
    public function tuihuo_shenqing() {
        $m =M("uaccount_order");//连接用户订单表
        $arr = $m->where("order_id='{$_POST['order_id']}'")->find(); 
        $or = M("uaccount_orderdetail"); //连接订单详情表
        $ors = $or->where("detail_id='{$_POST['detail_id']}'")->find();
        $datw['tuihuo'] = 1; 
        $or->where("detail_id='{$_POST['detail_id']}'")->save($datw);
        $t = M("tuihuo");//连接退货表
        $data['order_id'] = $_POST['detail_id'];
        $data['user_id'] = $arr['user_id'];
        $data['item_id'] = $ors['item_id'];
        $data['number'] = $_POST['number'];
        $data['status'] = 0;
        $data['time'] = date("Y-m-d H:i:s",time());
        $data['beizhu'] = $_POST['beizhu'];
        $t->add($data);
        $this->redirect("dingdanxiangqing_y");
    }
    //取消退货
    public function qx_tuihuo() {
        $m =M('uaccount_orderdetail');
        $date['tuihuo'] = ''; 
        $a =$m->where("detail_id='{$_POST['id']}'")->save($date);
        $t = M("tuihuo");
        $datw['status'] = 3;
        $t->where("order_id='{$_POST['id']}'")->save($datw);
        if($a){
            echo 1;
        }else{
            echo 2;
        }
    }
    //取消订单  
    public function qx_dingding() {
        $m =M("uaccount_order");
        $data['tuihuo'] = 6;
        $aa = $m->where("order_id='{$_POST['id']}'")->save($data); 
        $a = $m->where("order_id='{$_POST['id']}'")->find(); 
        $user = M("uaccount");
        $us = $user->where("user_id='{$a['user_id']}'")->find();
        $date['emoney'] = $us['emoney'] + $a['emenoy'];
        $date['smoney'] = $us['smoney'] + $a['smenoy'];
        $user->where("user_id='{$us['user_id']}'")->save($date);
        if($aa){
            echo 1;
        }else{
            echo 2;
        }
    }
    public function selfverify(){
    $Verify = new \Think\Verify();  
    $Verify->fontSize = 18;  
    $Verify->length   = 4;  
    $Verify->useNoise = false;  
    $Verify->codeSet = '0123456789';  
    $Verify->imageW = 130;  
    $Verify->imageH = 50;  
    //$Verify->expire = 600;  
    $Verify->entry();  
    }	
    public function tuwenyanzheng(){
        $verify = $_POST['value'];
        if(!check_verify($verify)){  
            echo 1;
        }else{
            $sql = M("zheng");
            $where['ip'] = $_SERVER['REMOTE_ADDR'];
            $where['ma'] = $verify;
            $sql->add($where);
        }
    }
    public function ceshila(){
        $sql = M("yan");
        $where['yan'] = "测试";
        $where['ip'] = 233;
        $sql->add($where);
    }
    //签署资质-安全密码验证
    public function anquan_pass_yan(){
        $pass = md5(md5($_POST['pass']));
        $user = $_COOKIE['LoginName'];
        $sql = M("uaccount");
        $find = $sql->where("tel = $user")->find();
        if($find['security_pwd']==$pass){
            echo 1;
        }
    }
    public function business_shop() {
        if($_COOKIE['LoginName']){
            $m = M("uaccount");
            $find = $m->where("tel = {$_COOKIE['LoginName']}")->find();
            $this->assign("find",$find);
            $sql = M("uaccount_shop");
            $arr = $sql->where("user_id = {$find['user_id']}")->count();
            $this->assign("gouwunum",$arr);
        }
        $sql = M("item"); 
          $sq = M("item_category");
        if(!empty($_GET['mc'])){
                $val = $_GET['mc'];
                
//                $datw['item_name'] = $val;
                $array = $sql->where("item_name = '$val'")->select();
//                dump($array);
                if (!empty($array)) {
                     $where['item_name'] = $val;
//                     dump($where);
                } else {
                    $date['category_name'] = array("like","%$val%");
                    $ar = $sq->where($date)->field("category_id")->select();
                    if (!empty($ar)) {
                         foreach ($ar as $val){
                             $a[]=$val["category_id"];                
                         }             
                         $where["category_id"]=array('in',$a); 
                    }
                }     
            
        } else if(!empty ($_GET['category_id'])&& $_GET['fenlei'] !== 1) {
//            $category = $sq->where("parent_id='{$_GET['category_id']}'")->select();
//            for($i=0;$i<count($category);$i++) {
//                $c[] = $category[$i]['category_id'];
//            }
//            $c[] = $_GET['category_id'];
//            $where['category_id'] = array("in",$c);
            $cate = $sq->where("category_id='{$_GET['category_id']}'")->find(); //查询这个大类的记录
            if($cate['parent_id'] == 0){
                $guize = $cate['fenleis'];
                if($cate['leiid'] !== ''){
                    $ass = $sq->where("leiid='{$cate['leiid']}'")->order("category_id desc")->find();
                    if($ass['fenleis'] !== $cate['fenleis']){
                        $guize2 = substr($ass['fenleis'],0,5);
                    }
                }
                $shangs = $sql->select(); //查询所有的商品
                for($a=0;$a<count($shangs);$a++){
                   if($guize2){
                        if(substr($shangs[$a]['bar_code'],0,5) == $guize || substr($shangs[$a]['bar_code'],0,5) == $guize2){
                            $sou[] = $shangs[$a]['item_id'];
                        }
                   }else{
                       if(substr($shangs[$a]['bar_code'],0,5) == $guize){
                            $sou[] = $shangs[$a]['item_id'];
                        }
                   }
                }
                $where['item_id'] = array("in",$sou);
            }else{
                $guize = $cate['fenleis'];
                $die = $sq->where("category_id='{$cate['parent_id']}'")->find();
                 if($die['leiid'] !== ''){
                    $ass = $sq->where("leiid='{$die['leiid']}'")->order("category_id desc")->find();
                    if($ass['fenleis'] !== $die['fenleis']){
                        $guize2 = substr($ass['fenleis'],0,5).substr($cate['fenleis'],5);
                    }
                }
                 $shangs = $sql->select(); //查询所有的商品
                for($a=0;$a<count($shangs);$a++){
                   if($guize2){
                        if(substr($shangs[$a]['bar_code'],0,7) == $guize || substr($shangs[$a]['bar_code'],0,7) == $guize2){
                            $sou[] = $shangs[$a]['item_id'];
                        }
                   }else{
                       if(substr($shangs[$a]['bar_code'],0,7) == $guize){
                            $sou[] = $shangs[$a]['item_id'];
                        }
                   }
                }
                $where['item_id'] = array("in",$sou);
            }
        }
        if(!empty($_GET["shopid"])){
            $where["item_id"]=$_GET["shopid"];  
        }
        if(!empty($_GET["id"])&& empty($_POST['gjz'])){
            $where["mall_id"]=$_GET["id"];
            $guizess = M("mall_guize");
            $scguize = $guizess->where("mall_id='{$_GET['id']}'")->select();
        }
        if(!empty($_POST['gjz'])){
            $vals = $_POST['gjz'];
            $where['item_name'] = $vals;
        }
        $where["status"]=0;   
        $count = $sql->where($where)->count();
        $this->assign("shu",$count);
        $p = getpage($count,20);
        if(!empty($_GET['jg'])){
            session("seaxl",null);
            session("seajg",$_GET['jg']);
        }
        if(!empty($_GET['xl'])){
            session("seajg",null);
            session("seaxl",$_GET['xl']);
        }
        if(!empty($_SESSION['seajg'])){
            if($_GET['id'] == 1){
                if($_SESSION['seajg'] == 1){
                $arr = $sql->where($where)->limit($p->firstRow, $p->listRows)->order("sMoney desc")->select();
                }else{
                   $arr = $sql->where($where)->limit($p->firstRow, $p->listRows)->order("sMoney asc")->select();  
                }
            }else{
                if($_SESSION['seajg'] == 1){
                $arr = $sql->where($where)->limit($p->firstRow, $p->listRows)->order("eMoney desc")->select();
                }else{
                   $arr = $sql->where($where)->limit($p->firstRow, $p->listRows)->order("eMoney asc")->select();  
                }
            }
             
        }  
        if(!empty($_SESSION['seaxl'])){
         $arr = $sql->where($where)->limit($p->firstRow, $p->listRows)->order("rale desc")->select();    
        }  
        if(empty($_SESSION['seaxl']) && empty($_SESSION['seajg'])){
//            dump($where);
            $arr = $sql->where($where)->limit($p->firstRow, $p->listRows)->order("order_num asc,biaoji asc")->select();    
        }
        $futu = M("item_futu");
        foreach($arr as $k=>$value){
            $futus = $futu->where("item_id ='{$value['item_id']}'")->order("futu_id desc")->limit(4)->select();
            $arr[$k]['futu'] = $futus;
        }

        $this->assign('show', $p->show()); 
        $this->assign("arr",$arr);
        if(!empty($_GET['id'])){
                $fenlei = $sq->where("parent_id = 0")->select();
                if($scguize){
                   foreach($fenlei as $value){
                       for($i=0;$i<count($scguize);$i++){
                           if(substr($value['fenleis'],0,3) === $scguize[$i]['guize_name'] && substr($value['fenleis'],6) == ''){
                               $fenleiid[] = $value['category_id'];
                           }
                       }
                   }
                   $fenss['category_id'] = array("in",$fenleiid);
                   $fenss['parent_id'] = 0;
               }
            
        }else{
            $fenss['parent_id'] = 0;
        }
       
        $ar = $sq->where($fenss)->select();
        foreach ($ar as $key=>$val){
            $arr=$sq->where("parent_id={$val["category_id"]}")->select();

            $ar[$key]["parent"]=$arr;
        }
        $this->assign("ren",$ar);
        if( empty($_POST['gjz'])){
        $this->assign("getid",$_GET["id"]);
        }
        $weizhi = $sq->where("category_id='{$_GET['category_id']}'")->find();
        $this->assign("weizhi",$weizhi);
        if(!empty($_COOKIE['LoginName'])){
            $users = M("uaccount");
            $nicheng = $users->where("change_tel='{$_COOKIE['LoginName']}'")->find();
            $this->assign("nicheng",$nicheng);
        }
        $this->assign("fenleis",$_GET['category_id']);
         $tj = $sq->where("category_tj = 1 ")->order("category_px asc")->select();
        $this->assign("category_tj",$tj);
        $this->display();
    }
    public function loginajax2(){
        $sql = M("uaccount");
        $user = $_POST['user'];
        $arr = $sql->where("change_tel = $user or tel = $user")->select();
        if(count($arr)>0){
            echo 1;
        }
    }
    public function zhuceajax(){
        $sql = M("uaccount");
        $user = $_POST['user'];
        $arr = $sql->where("change_tel = $user or tel = $user")->select();
        if(count($arr)>0){
            echo 1;
        }else{
            session("zhuce2",$user);
        }
    }
    public function product_details(){
        if($_COOKIE['LoginName']){
            $m = M("uaccount");
            $find = $m->where("tel = {$_COOKIE['LoginName']}")->find();
            $this->assign("find",$find);
            $sql = M("uaccount_shop");
            $arr = $sql->where("user_id = {$find['user_id']}")->count();
            $this->assign("gouwunum",$arr);
        }
        $id = $_GET['id'];
        $sql = M("item");
        $arr = $sql->where("item_id=$id")->find();
        if(substr($arr['bar_code'],0,5)==69310){
              $arr['menpiao'] = 1;
        }
        $un = M("item_unit");
        $danwei = $un->where("unit_id='{$arr['unit_id']}'")->find();
        $this->assign("danwei",$danwei);
        $m = M("item_category");
        $fl = $m->where("category_id='{$arr['category_id']}'")->find();
        $pp = M("brand");
        $pinpai = $pp->where("brand_id='{$arr['brand_id']}'")->find();
        $this->assign("fenlei",$fl);
        $this->assign("pinpai",$pinpai);
        $this->assign("chan",$arr);
//        dump($arr);
        //右侧滚动产品
        $chan = $sql->where("mall_id = 2 and status = 0")->order("biaoji asc,order_num asc")->limit(0,3)->select();
        $chan2 = $sql->where("mall_id = 2 and status = 0")->order("biaoji asc,order_num asc")->limit(3,3)->select();
        $chan3 = $sql->where("mall_id = 2 and status = 0")->order("biaoji asc,order_num asc")->limit(6,3)->select();
        $chan4 = $sql->where("mall_id = 2 and status = 0")->order("biaoji asc,order_num asc")->limit(9,3)->select();
        $chan5 = $sql->where("mall_id = 2 and status = 0")->order("biaoji asc,order_num asc")->limit(12,3)->select();
        $this->assign("chanpin1",$chan);
        $this->assign("chanpin2",$chan2);
        $this->assign("chanpin3",$chan3);
        $this->assign("chanpin4",$chan4);
        $this->assign("chanpin5",$chan5);
        //看了最终买
        $zui = $sql->where("mall_id = 2 and status = 0")->order("biaoji asc,order_num asc")->limit(15,6)->select();
        $this->assign("zui",$zui);
        //销量排行榜
        if($arr['eMoney']>0){
            $xiao = $sql->where("mall_id = 2 and status = 0")->order("rale desc")->limit(0,8)->select();
            $this->assign("xiao",$xiao);
        }else{
            $xiao = $sql->where("mall_id = 1 and status = 0")->order("rale desc")->limit(0,8)->select();
            $this->assign("xiao",$xiao);
        }
        $sq = M("item_category");
         $tj = $sq->where("category_tj = 1 ")->order("category_px asc")->select();
        $this->assign("category_tj",$tj);
        $futu = M("item_futu");
        $fus = $futu->where("item_id ='$id'")->order("futu_id desc")->limit(4)->select();
        $this->assign("futu",$fus);
        $this->display();
    }
    public function paiming($a){
        $sql = M("item");
        if($_SESSION['paiming'] == 1){
            echo json_encode($xiao);
        }else{
            echo json_encode($xiao);
        }
    }
    public function seacookie() {
        session("seajg",null);
        session("seaxl",null);
        $id = $_GET['id'];
        $this->redirect("business_shop","id=$id");
    }
    public function seaxiaolei() {
        $sq = M("item_category");
        $sql = M("item");
         $cate = $sq->where("category_id='{$_POST['category_id']}'")->find(); //查询这个大类的记录
        $guize = $cate['fenleis'];
        $die = $sq->where("category_id='{$cate['parent_id']}'")->find();
         if($die['leiid'] !== ''){
            $ass = $sq->where("leiid='{$die['leiid']}'")->order("category_id desc")->find();
            if($ass['fenleis'] !== $die['fenleis']){
                $guize2 = substr($ass['fenleis'],0,5).substr($cate['fenleis'],5);
            }
        }
         $shangs = $sql->select(); //查询所有的商品
        for($a=0;$a<count($shangs);$a++){
           if($guize2){
                if(substr($shangs[$a]['bar_code'],0,7) == $guize || substr($shangs[$a]['bar_code'],0,7) == $guize2){
                    $sou[] = $shangs[$a]['item_id'];
                }
           }else{
               if(substr($shangs[$a]['bar_code'],0,7) == $guize){
                    $sou[] = $shangs[$a]['item_id'];
                }
           }
        }
        $where['item_id'] = array("in",$sou);
        $where['status'] = 0;
        $arr = $sql->where($where)->order("order_num asc")->limit(8)->select();
        $un = M("item_unit"); 
        $danwei = $un->select();
        for($w=0;$w<count($arr);$w++){
            for($s=0;$s<count($danwei);$s++){
                if($arr[$w]['unit_id'] == $danwei[$s]['unit_id']){
                    $arr[$w]['unit_name'] =$danwei[$s]['unit_name'];
                }
            }
        }
        echo json_encode($arr);
    }
    //新增地址
    public function adddizhi(){
        if($_COOKIE['LoginName']){
            $sql = M("uaccount_address");
            $m = M("uaccount");
            $name = $_POST['user'];
            $tel = $_POST['phone'];
            $yiji = $_POST['addyiji'];
            $erji = $_POST['adderji'];
            $sanji = $_POST['addsanji'];
            $address = $_POST['dizhi'];
            $moren = $_POST['moren'];
            $find = $m->where("tel = {$_COOKIE['LoginName']}")->find();
            $where['user_id'] = $find['user_id'];
            $where['address_people'] = $name;
            $where['address_tel'] = $tel;
            $where['address_details'] = $address;
            $where['address_provinces'] = $yiji."-".$erji."-".$sanji;
            $where['status'] = $moren;
            $arr = $sql->where("user_id = {$find['user_id']}")->select();
            if(count($arr)>0){
                if($moren == 1){
                    foreach($arr as $val){
                        if($val['status']==1){
                            $upt['status'] = 0;
                            $sql->where("address_id = {$val['address_id']}")->save($upt);
                        }
                    }
                }
            }
            $a = $sql->add($where);
            if($a){
                $this->redirect("dingdan");
            }else{
                echo "系统忙，请稍后重试";
            }
        }
    }
    public function adddizhi2(){
        if($_COOKIE['LoginName']){
            $sql = M("uaccount_address");
            $m = M("uaccount");
            $name = $_POST['user'];
            $tel = $_POST['phone'];
            $yiji = $_POST['addyiji'];
            $erji = $_POST['adderji'];
            $sanji = $_POST['addsanji'];
            $address = $_POST['dizhi'];
            $moren = $_POST['moren'];
            $find = $m->where("tel = {$_COOKIE['LoginName']}")->find();
            $where['user_id'] = $find['user_id'];
            $where['address_people'] = $name;
            $where['address_tel'] = $tel;
            $where['address_details'] = $address;
            $where['address_provinces'] = $yiji."-".$erji."-".$sanji;
            $where['status'] = $moren;
            $arr = $sql->where("user_id = {$find['user_id']}")->select();
            if(count($arr)>0){
                if($moren == 1){
                    foreach($arr as $val){
                        if($val['status']==1){
                            $upt['status'] = 0;
                            $sql->where("address_id = {$val['address_id']}")->save($upt);
                        }
                    }
                }
            }
            $a = $sql->add($where);
            if($a){
                $this->redirect("dizhi");
            }else{
                echo "系统忙，请稍后重试";
            }
        }
    }
    
    //订单结算页
    public function dingdan(){
        if($_COOKIE['LoginName']){
            $sql = M("uaccount_address");
            $m = M("uaccount");
            $find = $m->where("tel = {$_COOKIE['LoginName']}")->find();
            $arr = $sql->where("user_id = {$find['user_id']}")->select();
            $this->assign("address",$arr);
            $arr2=$m->where("tel={$_COOKIE["LoginName"]}")->find();
            $n=D("payorder");        
            $array=$n->where("user_id={$arr2["user_id"]} and status=1")->order("create_date desc")->find();
            $arra=$n->where("order_id={$array["order_id"]}")->select();
//            dump($arra);
            $this->assign("arr",$arra);
            $this->assign("arry",$arr2);
            foreach($arra as $val){
                $qian['emoney'] += $val['quantity']*$val['s_xj_price'];
                $qian['smoney'] += $val['quantity']*$val['g_xj_price'];
                $qian['zong'] =  $qian['emoney'] + $qian['smoney'];
                $qian['count'] += $val['quantity'];
            }
//            dump($qian);
            $this->assign("qian",$qian);
            $this->display();
        }
    }
    //订单结算页
    public function menpiao_dingdan(){
        if($_COOKIE['LoginName']){
            $sql = M("uaccount_address");
            $m = M("uaccount");
            $find = $m->where("tel = {$_COOKIE['LoginName']}")->find();
            $arr = $sql->where("user_id = {$find['user_id']}")->select();
            $this->assign("address",$arr);
            $arr2=$m->where("tel={$_COOKIE["LoginName"]}")->find();
            $n=D("payorder");        
            $array=$n->where("user_id={$arr2["user_id"]} and status=1")->order("create_date desc")->find();
            $arra=$n->where("order_id={$array["order_id"]}")->select();
//            dump($arra);
            $this->assign("arr",$arra);
            $this->assign("arry",$arr2);
            foreach($arra as $val){
                $qian['emoney'] += $val['quantity']*$val['s_xj_price'];
                $qian['smoney'] += $val['quantity']*$val['g_xj_price'];
                $qian['zong'] =  $qian['emoney'] + $qian['smoney'];
                $qian['count'] += $val['quantity'];
            }
//            dump($qian);
            $this->assign("qian",$qian);
            $this->display();
        }
    }
    public function dingdan_order($order){
        
        
    }
    //查询是否有地址
    public function dzajax(){
        $sql = M("uaccount_address");
        $m = M("uaccount");
        $find = $m->where("tel = {$_COOKIE['LoginName']}")->find();
        $arr = $sql->where("user_id = {$find['user_id']}")->select();
        echo count($arr);
    }
    //修改收货地址
    public function uptdizhi(){
        dump($_POST);
        if($_COOKIE['LoginName']){
            $sql = M("uaccount_address");
            $m = M("uaccount");
            $id = $_POST['tjid'];
            $name = $_POST['uptname'];
            $tel = $_POST['uptphone'];
            $yiji = $_POST['yiji'];
            $erji = $_POST['erji'];
            $sanji = $_POST['sanji'];
            $address = $_POST['uptdizhi'];
            $moren = $_POST['uptmoren'];
            $find = $m->where("tel = {$_COOKIE['LoginName']}")->find();
            $where['user_id'] = $find['user_id'];
            $where['address_people'] = $name;
            $where['address_tel'] = $tel;
            $where['address_details'] = $address;
            $where['address_provinces'] = $yiji."-".$erji."-".$sanji;
            $where['status'] = $moren;
            $arr = $sql->where("user_id = {$find['user_id']}")->select();
            if(count($arr)>0){
                if($moren == 1){
                    foreach($arr as $val){
                        if($val['status']==1){
                            $upt['status'] = 0;
                            $sql->where("address_id = {$val['address_id']}")->save($upt);
                        }
                    }
                }
            }
            $a = $sql->where("address_id = $id")->save($where);
            if($a){
                $this->redirect("dingdan");
            }else{
                echo "系统忙，请稍后重试";
            }
        }
    }
    public function ghmr(){
        if($_COOKIE['LoginName']){
            $id = $_GET['id'];
            $sql = M("uaccount_address");
            $m = M("uaccount");
            $find = $m->where("tel={$_COOKIE['LoginName']}")->find();
            $arr = $sql->where("address_id = $id")->find();
            if($find['user_id']==$arr['user_id']){
                $array = $sql->where("user_id = {$find['user_id']}")->select();
                $upt['status'] = 1;
                $upt2['status'] = 0;
                foreach($array as $val){
                    if($val['status']==1){
                        $sql->where("address_id={$val['address_id']}")->save($upt2);
                    }
                }
                $sql->where("address_id = $id")->save($upt);
                $this->redirect("dingdan");
            }else{
                echo "错误访问";
            }
        }
    }
    public function xiugaimoren(){
        if($_COOKIE['LoginName']){
            $id = $_GET['id'];
            $sql = M("uaccount_address");
            $m = M("uaccount");
            $find = $m->where("tel={$_COOKIE['LoginName']}")->find();
            $arr = $sql->where("address_id = $id")->find();
            if($find['user_id']==$arr['user_id']){
                $array = $sql->where("user_id = {$find['user_id']}")->select();
                $upt['status'] = 1;
                $upt2['status'] = 0;
                foreach($array as $val){
                    if($val['status']==1){
                        $sql->where("address_id={$val['address_id']}")->save($upt2);
                    }
                }
                $sql->where("address_id = $id")->save($upt);
                $this->redirect("dizhi");
            }else{
                echo "错误访问";
            }
        }
    }
    public function deldizhi(){
        if($_COOKIE['LoginName']){
            $id = $_GET['id'];
            $sql = M("uaccount_address");
            $m = M("uaccount");
            $find = $m->where("tel={$_COOKIE['LoginName']}")->find();
            $arr = $sql->where("address_id = $id")->find();
            if($find['user_id']==$arr['user_id']){
                $a = $sql->where("address_id = $id")->delete();
                if($a){
                    $this->redirect("dizhi");
                }else{
                    echo "系统忙，请稍后重试";
                }
            }else{
                echo "错误访问";
            }
        }
    }
    public function dzsc(){
        if($_COOKIE['LoginName']){
            $id = $_GET['id'];
            $sql = M("uaccount_address");
            $m = M("uaccount");
            $find = $m->where("tel={$_COOKIE['LoginName']}")->find();
            $arr = $sql->where("address_id = $id")->find();
            if($find['user_id']==$arr['user_id']){
                $a = $sql->where("address_id = $id")->delete();
                if($a){
                    $this->redirect("dingdan");
                }else{
                    echo "系统忙，请稍后重试";
                }
            }else{
                echo "错误访问";
            }
        }
    }
    //购物车成功页面
    public function gouwuchecg(){
        if($_COOKIE['LoginName']){
            $m2 = M("uaccount");
            $find2 = $m2->where("tel = {$_COOKIE['LoginName']}")->find();
            $this->assign("find3",$find2);
            $sql2 = M("uaccount_shop");
            $arr2 = $sql2->where("user_id = {$find2['user_id']}")->count();
            $this->assign("gouwunum",$arr2);
            
            
            $id = $_GET['item_id'];
            $number = $_GET['num'];
            $sql = M("item");
            $find = $sql->where("item_id=$id")->find();
            $num = substr($find['bar_code'],0,7);
            $arr = $sql->where("status = 0")->select();
            foreach($arr as $val){
                if($num==substr($val['bar_code'],0,7)&&$val['item_id']!=$id){
                    $array[] = $val;
                }
            }
            $m = M("uaccount");
            $user = $m->where("tel={$_COOKIE['LoginName']}")->find();
            $u = M("uaccount_shop");
            $gouwu = $u->where("user_id = {$user['user_id']}")->select();
            foreach($gouwu as $val){
                if($val['item_id']==$id){
                    $yan = 1;
                }
            }
            $where['item_id'] = $id;
            $where['user_id'] = $user['user_id'];
            $where['count'] = $number;
            date_default_timezone_set ("PRC");
            $time=time();
            $data=date("Y-m-d H:i:s",$time);
            $where['creates_date'] = $data;
//            $where['status'] = $find['mall_id'];
            if($yan!=1){
               $u->add($where); 
            }
            $this->assign("chan",$array);
            $this->assign("find",$find);
            $sq = M("item_category");
             $tj = $sq->where("category_tj = 1 ")->order("category_px asc")->select();
            $this->assign("category_tj",$tj);
            $this->display();
        }
    }
    //购物车判断是否登录状态
    public function loginpd(){
        if($_COOKIE['LoginName']){
            echo 123;
        }
    }
    public function gouwuchejs(){
        if($_COOKIE['LoginName']){
            $m2 = M("uaccount");
            $find2 = $m2->where("tel = {$_COOKIE['LoginName']}")->find();
            $this->assign("find",$find2);
            $sql2 = M("uaccount_shop");
            $arr2 = $sql2->where("user_id = {$find2['user_id']}")->count();
            $this->assign("gouwunum",$arr2);
            
            $sql = M("uaccount");
            $m = M("item");
            $mysql= M("uaccount_shop");
            $find = $sql->where("tel = {$_COOKIE['LoginName']}")->find();
            $arr = $mysql->where("user_id = {$find['user_id']}")->select();
            $array = $m->select();
            foreach($arr as $val){
                for($i=0;$i<count($array);$i++){
                    if($val['item_id']==$array[$i]['item_id']){
                        $item[$i] = $array[$i];
                        $item[$i]['goumai'] = $val['count'];
                        $item[$i]['shop_biaoji'] = $val['shop_biaoji'];
                    }
                }
            }
            $un = M("item_unit");
            $un_arr = $un->select();
            foreach($un_arr as $val){
                foreach($item as $value){
                   if($val['unit_id']==$value['unit_id']){
                        $value['unit_id'] = $val['unit_name'];
                        $item_arr[] = $value;
                    } 
                }
            }
            $this->assign("item",$item_arr);
            
            $cai = $m->where("status = 0")->order("rale desc")->select();
            $this->assign("lunbo",$cai);
            
            $s = M("item_shoucang");
            $s_arr = $s->table("item_shoucang,item")->where("user_id = {$find['user_id']} and item_shoucang.item_id = item.item_id")->select();
            $this->assign("shoucang",$s_arr);
            $this->display();
        }
    }
    //修改购物车数量
    public function upt_gouwuche(){
        if($_COOKIE['LoginName']){
            $id = $_POST['id'];
            $jiage = $_POST['jiage'];
            $m = M("uaccount_shop");
            $sql = M("uaccount");
            $find = $sql->where("tel={$_COOKIE['LoginName']}")->find();
            $arr = $m->where("user_id = {$find['user_id']} and item_id = $id")->find();
            $upt['count'] = $jiage;
            $a = $m->where("g_id = {$arr['g_id']}")->save($upt);
            if($a){
                echo "成功";
            }else{
                echo "失败";
            }
        }
    }
    public function duoxuan_gai(){
        if($_COOKIE['LoginName']){
            $m = M("uaccount_shop");
            $upt['shop_biaoji'] = $_POST['biao'];
            $id = $_POST['id'];
            $sql = M("uaccount");
            $find = $sql->where("tel = {$_COOKIE['LoginName']}")->find();
            $m->where("user_id = {$find['user_id']} and item_id = $id")->save($upt);
        }
    }
    public function login(){
        if(!empty($_GET['item_id'])){
            session("login_id",$_GET['item_id']);
        }
        $this->display();
    }
    public function yrsc(){
        if($_COOKIE['LoginName']){
            $sql = M("uaccount");
            $find = $sql->where("tel={$_COOKIE['LoginName']}")->find();
            $m = M("item_shoucang");
            $id = $_POST['id'];
            $arr = $m->where("item_id = $id and user_id = {$find['user_id']}")->find();
            if(count($arr)>0){
                echo 1;
            }else{
                $where['user_id'] = $find['user_id'];
                $where['item_id'] = $id;
                date_default_timezone_set ("PRC");
                $time=time();
                $data=date("Y-m-d H:i:s",$time);
                $where['creat_time'] = $data;
                $a = $m->add($where);
                $mysql = M("uaccount_shop");
                $b = $mysql->where("item_id = $id and user_id = {$find['user_id']}")->delete();
                if($a){
                    echo 2;
                }else{
                    echo 3;
                }
            }
        }
    }
    public function gonggong(){
        $id = $_POST['id'];
        if($_COOKIE['LoginName']){
            $m = M("uaccount");
            $find = $m->where("tel = {$_COOKIE['LoginName']}")->find();
            $sql = M("uaccount_shop");
            $arr = $sql->where("item_id = $id and user_id = {$find['user_id']}")->find();
            if(count($arr)>0){
                
            }else{
                $where['item_id'] = $id;
                $where['user_id'] = $find['user_id'];
                $where['count'] = 1;
                date_default_timezone_set ("PRC");
                $time=time();
                $data=date("Y-m-d H:i:s",$time);
                $where['creat_time'] = $data;
                $where['creates_date'] = $data;
                $a = $sql->add($where);
                if($a){
                    echo 1111;
                }
            }
        }
    }
    public function gddsc(){
        if($_COOKIE['LoginName']){
            $sql = M("uaccount");
            $find = $sql->where("tel={$_COOKIE['LoginName']}")->find();
            $m = M("uaccount_shop");
            $id = $_POST['id'];
            $arr = $m->where("item_id = $id and user_id = {$find['user_id']}")->delete();
            if($arr){
                echo 1;
            }else{
                echo 2;
            }
        }
    }
    public function xiangsi(){
        $num = $_POST['value'];
        if($_COOKIE['LoginName']){
            $number = substr($num,0,7);
            $m = M("item");
            $arr = $m->where("status = 0")->select();
            foreach($arr as $val){
                if($number==substr($val['bar_code'],0,7)){
                    $array[] = $val;
                }
            }
            echo json_encode($array);
        }
    }
    //商城个人中心
    public function myhome(){
        if($_COOKIE['LoginName']){
            $ab = M("uaccount");
            $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
            $this->assign("find",$find);
            $sql = M("uaccount_shop");
            $arr2 = $sql->where("user_id = {$find['user_id']}")->count();
            $this->assign("gouwunum",$arr2);
            
            $u = M("item_shoucang");
            $array = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->limit(0,9)->select();
            $count = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->count();
            $this->assign("shoucang",$array);
            $this->assign("shu",$count);
            
            $mysql = M("uaccount_shop");
            $array2 = $mysql->table("uaccount_shop,item")->where("uaccount_shop.item_id = item.item_id and uaccount_shop.user_id = {$find['user_id']}")->limit(0,9)->select();
            $count2 = $mysql->table("uaccount_shop,item")->where("uaccount_shop.item_id = item.item_id and uaccount_shop.user_id = {$find['user_id']}")->limit(0,9)->count();
            $this->assign("gouwuche",$array2);
            $this->assign("shu2",$count2);
            
            //订单详情
            $order = M("uaccount_order");//连接用户订单表
            $mysql2 = M("uaccount_orderdetail");//连接订单商品表
            $u2 = M("uaccount");//连接用户信息表
            $find2 = $u2->where("tel={$_COOKIE['LoginName']}")->find();
            $count4 = $order->where("user_id={$find2['user_id']} and status !=1")->order("order_id desc")->count();//以接收id查询已激活资质的条数
            $p = getpage($count4,6);//分页
            $arr_order = $order->where("user_id={$find2['user_id']} and status !=1")->order("order_id desc")->limit($p->firstRow, $p->listRows)->select();
            for($i=0;$i<count($arr_order);$i++){
                $arr_mysql[] = $mysql2->where("order_id={$arr_order[$i]['order_id']}")->order("detail_id desc")->select();
            }
            $item = M("item");
            $arr_item = $item->select();
            for($i=0;$i<count($arr_mysql);$i++){
                for($a = 0; $a<count($arr_mysql[$i]);$a++){
                    for($z = 0; $z<count($arr_item);$z++){
                        if($arr_mysql[$i][$a]['item_id']==$arr_item[$z]['item_id']){
                            for($y = 0;$y<count($arr_order);$y++){
                                if($arr_order[$y]['order_id']==$arr_mysql[$i][$a]['order_id']){
                                    $arr_item[$z]['quantity'] = $arr_mysql[$i][$a]['quantity'];
                                    $arr_order[$y]['arr'][] = $arr_item[$z];
                                }
                            }
                        }
                    }
                }
            }
                
            $this->assign("order",$arr_order);
            $this->assign("show",$p->show());
            $this->display();
        }else{
            echo "访问错误";
        }
    }
    public function kaquan(){
        if($_COOKIE['LoginName']){
            $ab = M("uaccount");
            $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
            $this->assign("find",$find);
            $sql = M("uaccount_shop");
            $arr2 = $sql->where("user_id = {$find['user_id']}")->count();
            $this->assign("gouwunum",$arr2);
            
            $u = M("item_shoucang");
            $array = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->limit(0,9)->select();
            $count = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->count();
            $this->assign("shoucang",$array);
            $this->assign("shu",$count);
            
            $mysql = M("uaccount_shop");
            $array2 = $mysql->table("uaccount_shop,item")->where("uaccount_shop.item_id = item.item_id and uaccount_shop.user_id = {$find['user_id']}")->limit(0,9)->select();
            $count2 = $mysql->table("uaccount_shop,item")->where("uaccount_shop.item_id = item.item_id and uaccount_shop.user_id = {$find['user_id']}")->limit(0,9)->count();
            $this->assign("gouwuche",$array2);
            $this->assign("shu2",$count2);
            
            //订单详情
            $order = M("uaccount_order");//连接用户订单表
            $mysql2 = M("uaccount_orderdetail");//连接订单商品表
            $u2 = M("uaccount");//连接用户信息表
            $find2 = $u2->where("tel={$_COOKIE['LoginName']}")->find();
            $count4 = $order->where("user_id={$find2['user_id']} and status !=1")->order("order_id desc")->count();//以接收id查询已激活资质的条数
            $p = getpage($count4,6);//分页
            $arr_order = $order->where("user_id={$find2['user_id']} and status !=1")->order("order_id desc")->limit($p->firstRow, $p->listRows)->select();
            for($i=0;$i<count($arr_order);$i++){
                $arr_mysql[] = $mysql2->where("order_id={$arr_order[$i]['order_id']}")->order("detail_id desc")->select();
            }
            $item = M("item");
            $arr_item = $item->select();
            for($i=0;$i<count($arr_mysql);$i++){
                for($a = 0; $a<count($arr_mysql[$i]);$a++){
                    for($z = 0; $z<count($arr_item);$z++){
                        if($arr_mysql[$i][$a]['item_id']==$arr_item[$z]['item_id']){
                            for($y = 0;$y<count($arr_order);$y++){
                                if($arr_order[$y]['order_id']==$arr_mysql[$i][$a]['order_id']){
                                    $arr_item[$z]['quantity'] = $arr_mysql[$i][$a]['quantity'];
                                    $arr_order[$y]['arr'][] = $arr_item[$z];
                                }
                            }
                        }
                    }
                }
            }
                
            $this->assign("order",$arr_order);
            $this->assign("show",$p->show());
            $sq = M("kaquan");
            $sq_arr = $sq->where("user_id = {$find['user_id']}")->order("kaquan_id desc")->select();
            $this->assign("kaquan",$sq_arr);
            $this->display();
        }else{
            echo "访问错误";
        }
    }
    public function shoucang(){
        if($_COOKIE['LoginName']){
            $ab = M("uaccount");
            $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
            $this->assign("find",$find);
            $sql = M("uaccount_shop");
            $arr2 = $sql->where("user_id = {$find['user_id']}")->count();
            $this->assign("gouwunum",$arr2);
            $u = M("item_shoucang");
            $array = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->select();
            $count = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->count();
            $this->assign("shoucang",$array);
            $this->assign("shu",$count);
            $this->display();
        }
    }
    public function shoucang2(){
        if($_COOKIE['LoginName']){
            $ab = M("uaccount");
            $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
            $this->assign("find",$find);
            $sql = M("uaccount_shop");
            $arr2 = $sql->where("user_id = {$find['user_id']}")->count();
            $this->assign("gouwunum",$arr2);
            $u = M("item_shoucang");
            $array = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->select();
            $count = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->count();
            $this->assign("shoucang",$array);
            $this->assign("shu",$count);
            $this->display();
        }
    }
    public function shoucang_del(){
        if($_COOKIE['LoginName']){
            $id = $_POST['id'];
            $sql = M("item_shoucang");
            $res = $sql->where("shoucang_id = $id")->delete();
            if($res){
                echo 1;
            }
        }
    }
    public function shoucang_add(){
        if($_COOKIE['LoginName']){
            $id = $_POST['id'];
            $sql = M("uaccount_shop");
            $m = M("uaccount");
            $find = $m->where("tel={$_COOKIE['LoginName']}")->find();
            $arr = $sql->where("user_id={$find['user_id']} and item_id = $id")->find();
            if(count($arr)>0){
                echo 2;
            }else{
                $where['item_id'] = $id;
                $where['user_id'] = $find['user_id'];
                date_default_timezone_set ("PRC");
                $time=time();
                $data=date("Y-m-d H:i:s",$time);
                $where['creates_date'] = $data;
                $where['count'] = 1;
                $res = $sql->add($where);
                if($res){
                    echo 1;
                }
            }
        }
    }
    public function scqs(){
        if($_COOKIE['LoginName']){
            $id = $_POST['xuanze'];
            $sql = M("item_shoucang");
            for($i=0;$i<count($id);$i++){
                $sql->where("shoucang_id={$id[$i]}")->delete();
            }
            $this->redirect("shoucang");
        }  
    }
    public function qbgw(){
        if($_COOKIE['LoginName']){
            $id = $_POST['xuanze'];
            $sql = M("item_shoucang");
            $mysql = M("uaccount_shop");
            $u = M("uaccount");
            $find = $u->where("tel={$_COOKIE['LoginName']}")->find();
            foreach($id as $val){
                $arr = $sql->where("shoucang_id = $val")->find();
                $where['item_id'] = $arr['item_id'];
                $where['user_id'] = $find['user_id'];
                date_default_timezone_set ("PRC");
                $time=time();
                $data=date("Y-m-d H:i:s",$time);
                $where['creates_date'] = $data;
                $where['count'] = 1;
                $mysql->add($where);
            }
            $this->redirect("shoucang");
        }
    }
    public function dizhi(){
        if($_COOKIE['LoginName']){
            $ab = M("uaccount");
            $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
            $this->assign("find",$find);
            $sql = M("uaccount_shop");
            $arr2 = $sql->where("user_id = {$find['user_id']}")->count();
            $this->assign("gouwunum",$arr2);
            $u = M("item_shoucang");
            $array = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->select();
            $count = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->count();
            $this->assign("shoucang",$array);
            $this->assign("shu",$count);
            
            $m = M("uaccount_address");
            $arr = $m->where("user_id = {$find['user_id']} and status = 1")->select();
            $this->assign("dizhi",$arr);
            $arr3 = $m->where("user_id = {$find['user_id']} and status != 1")->select();
            $this->assign("dizhi2",$arr3);
            $this->display();
        }
    }
    public function xiaoxi(){
        if($_COOKIE['LoginName']){
            $ab = M("uaccount");
            $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
            $this->assign("find",$find);
            $sql = M("uaccount_shop");
            $arr2 = $sql->where("user_id = {$find['user_id']}")->count();
            $this->assign("gouwunum",$arr2);
            $u = M("item_shoucang");
            $array = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->select();
            $count = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->count();
            $this->assign("shoucang",$array);
            $this->assign("shu",$count);
            
            $m = M("mail");
            $arr = $m->table("mail,uaccount")->where("mail.accept_id = {$_COOKIE['LoginName']} and mail.accept_id = uaccount.tel and mail.status = 0")->select();
            $arr3 = $m->table("mail,uaccount")->where("mail.accept_id = {$_COOKIE['LoginName']} and mail.accept_id = uaccount.tel and mail.status = 1")->count();
            $this->assign("du",$arr3);
            $this->assign("xiaoxi",$arr);
            $this->display();
        }
    }
    public function xiaoxi2(){
        if($_COOKIE['LoginName']){
            $ab = M("uaccount");
            $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
            $this->assign("find",$find);
            $sql = M("uaccount_shop");
            $arr2 = $sql->where("user_id = {$find['user_id']}")->count();
            $this->assign("gouwunum",$arr2);
            $u = M("item_shoucang");
            $array = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->select();
            $count = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->count();
            $this->assign("shoucang",$array);
            $this->assign("shu",$count);
            
            $m = M("mail");
            $arr = $m->table("mail,uaccount")->where("mail.accept_id = {$_COOKIE['LoginName']} and mail.accept_id = uaccount.tel and mail.status = 1")->select();
            $arr3 = $m->table("mail,uaccount")->where("mail.accept_id = {$_COOKIE['LoginName']} and mail.accept_id = uaccount.tel and mail.status = 0")->count();
            $this->assign("du",$arr3);
            $this->assign("xiaoxi",$arr);
            $this->display();
        }
    }
    public function xiaoxi_del(){
        if($_COOKIE['LoginName']){
            $id = $_GET['id'];
            $ab = M("uaccount");
            $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
            $sql = M("mail");
            $upt['status'] = 2;
            $res = $sql->where("mail_id = $id")->save($upt);
            if($res){
                $this->redirect("xiaoxi");
            }else{
                echo "系统忙，请稍后再试";
            }
        }
    }
    public function xiaoxi_del2(){
        if($_COOKIE['LoginName']){
            $id = $_GET['id'];
            $ab = M("uaccount");
            $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
            $sql = M("mail");
            $upt['status'] = 2;
            $res = $sql->where("mail_id = $id")->save($upt);
            if($res){
                $this->redirect("xiaoxi2");
            }else{
                echo "系统忙，请稍后再试";
            }
        }
    }
    public function xiaoxi_du(){
        if($_COOKIE['LoginName']){
            $id = $_GET['id'];
            $ab = M("uaccount");
            $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
            $sql = M("mail");
            $upt['status'] = 1;
            $res = $sql->where("mail_id = $id")->save($upt);
            if($res){
                $this->redirect("xiaoxi");
            }else{
                echo "系统忙，请稍后再试";
            }
        }
    }
    public function guanli(){
        if($_COOKIE['LoginName']){
            $ab = M("uaccount");
            $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
            $this->assign("find",$find);
            $sql = M("uaccount_shop");
            $arr2 = $sql->where("user_id = {$find['user_id']}")->count();
            $this->assign("gouwunum",$arr2);
            $u = M("item_shoucang");
            $array = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->select();
            $count = $u->table("item_shoucang,item")->where("item.item_id = item_shoucang.item_id and item_shoucang.user_id = {$find['user_id']}")->count();
            $this->assign("shoucang",$array);
            $this->assign("shu",$count);
            $this->display();
        }
    }
    public function touxiangsc(){
        if($_COOKIE['LoginName']){
            $ab = M("uaccount");
            $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
            $array=array("jpg","gif","png",);//图片后缀名
        //上传头像
            if(!empty($_FILES['file']['size'])){
                    $b=explode(".",$_FILES['file']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['file']['tmp_name'],"Public/upload/$file_name");
                }
            }
            if($file_name){
                $where['head_portrait'] = "/Public/upload/$file_name";
            }
            //修改信息成功
                $ab->where("user_id={$find['user_id']}")->save($where);
                $this->redirect("guanli");
            }
    }
    public function xttx(){
         if($_COOKIE['LoginName']){
                $ab = M("uaccount");
                $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
                $where['head_portrait'] = $_POST['xttj'];
                $ab->where("user_id={$find['user_id']}")->save($where);
                $this->redirect("guanli");
         }
    }
    public function upt_register(){
         if($_COOKIE['LoginName']){
            $ab = M("uaccount");
            $find = $ab->where("tel = {$_COOKIE['LoginName']}")->find();
            $where['email'] = $_POST['email'];
            $where['sex'] = $_POST['sex'];
            $ab->where("user_id={$find['user_id']}")->save($where);
            $this->redirect("guanli");
         }
    }
    //新闻公告
    public function gonggao(){
        $m = M("new");
        $arr = $m->where("xp_tj=1")->order("xp_px asc")->select();
        $arrs = $m->where("xp_tj=1")->order("xp_px asc")->find();
        $this->assign("arr",$arr);
        $this->assign("fir",$arrs);
        $this->display();
    }
    //新闻公共详情页面
    public function fafang(){
        $m = M("new");
        $arr= $m->where("new_id='{$_GET['id']}'")->find();
        $this->assign("arr",$arr);
        $this->display();
    }
        
}