<?php
namespace Home\Controller;
use Think\Controller;
//use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class HandleController extends Controller{
    public function admin(){
        if($_COOKIE['AdminName']){
            $this->display();
        }else{
            $this->redirect("tishi");
        }
    }
    public function admin_quanxian(){
        $m=M("admin_register");
        $name=$_COOKIE['AdminName'];
        $role_id=$m->where("username='$name'")->find();
        $admin_role_module=M("admin_role_module");
        $arr=$admin_role_module->where("role_id={$role_id["role_id"]}")->field("module_id")->select();
        foreach($arr as $val){
            $admin_module=M("admin_module");
            $array[]=$admin_module->where("module_id={$val["module_id"]}")->find();
        }
        
        foreach ($array as $value){
            $quanxian[]=$value["module_action"];
        }
            echo json_encode($quanxian);
    }
    public function cookSelect(){
        $sql = M("admin_register");
        $arr = $sql->select();
        if($_COOKIE['AdminName']){
            foreach($arr as $val){
                if($_COOKIE['AdminName']==$val['username']){
                    echo json_encode($val);
                }
            }
        }
    }
    public function signOut(){
        cookie('AdminName',null);
        $this->redirect("login");
    }
    public function weirenzheng(){
        if(empty($_POST['sea'])){
            $sql = M("uaccount");
            $count = $sql->count();
            $p = getpage($count,12);
            $list = $sql->order('emoney desc')->limit($p->firstRow, $p->listRows)->select();
            $this->assign('ren', $list);
            $this->assign('show', $p->show());
            $this->display();
        }else{
            $value = $_POST['sea'];
            if($value != ""){
                $sql = M("uaccount");
                $cha['tel'] = array("LIKE","%$value%");
                $cha['real_name'] = array("LIKE","%$value%");
                $cha[_logic]="or";
                $arr = $sql->where($cha)->select();
                $this->assign('ren',$arr);
                $this->display();         
            }
        }
    }
    public function zizhi(){
        if(empty($_POST['sea'])){
            $sql = M("ucredentials");
            $count= $sql->table("ucredentials,manager")->order('crdentials_id desc')->where("ucredentials.status=0 and ucredentials.manager=manager.manager_id")->count();
             $p = getpage($count,12);
           $arr = $sql->table("ucredentials,manager")->order('crdentials_id desc')->where("ucredentials.status=0 and ucredentials.manager=manager.manager_id")->limit($p->firstRow, $p->listRows)->select();
            $m = M("uaccount");
            $array = $m->select();
            foreach($array as $val){
                for($i=0;$i<count($arr);$i++){
                    if($arr[$i]['tel']==$val['tel']){
                        $arr[$i]['real_name'] = $val['real_name'];
                    }
                    if($arr[$i]['recommend_id']==$val['tel']){
                        $arr[$i]['tuijian_name'] = $val['real_name'];
                    }
                }
            }
            $mysql = M("manager");
            $jingli = $mysql->select();
            foreach($jingli as $value){
                for($i=0;$i<count($arr);$i++){
                    if($arr[$i]['manager']==$value['manager_id']){
                        $arr[$i]['manager_name'] = $value['manager_name'];
                    }
                }
            }
            $this->assign("ren",$arr);
            $this->assign("show",$p->show());
            $this->display();
        }else{
            $value = $_POST['sea'];
            if($value != ""){
                $sql = M("ucredentials");
                $bianhao= $value;
                $tel = $value;
//                $cha['recommend_id'] = array("LIKE","%$value%");
                $goods_id = $value;
//                $cha[_logic]="or";
                $count = $sql->table("ucredentials,flagship")->order('crdentials_id desc')->where("ucredentials.status=0 and ucredentials.shop_id=flagship.shop_id and(ucredentials.bianhao like '%$bianhao%' or ucredentials.tel like '%$tel%' or ucredentials.recommend_id like '%$recommend_id%' or ucredentials.goods_id like '%$goods_id%')")->field("flagship.shop_name,ucredentials.*")->count();
                 $p = getpage($count,12);
                $arr = $sql->table("ucredentials,flagship")->order('crdentials_id desc')->where("ucredentials.status=0 and ucredentials.shop_id=flagship.shop_id and(ucredentials.bianhao like '%$bianhao%' or ucredentials.tel like '%$tel%' or ucredentials.recommend_id like '%$recommend_id%' or ucredentials.goods_id like '%$goods_id%')")->field("flagship.shop_name,ucredentials.*")->limit($p->firstRow, $p->listRows)->select();
//                $arr = $sql->where($cha)->select();
                foreach($arr as $value){
                    if($value['status'] == "0"&&$value['type'] == "1"){
                        $a[] = $value;
                    }
                }

                $m = M("uaccount");
                $array = $m->select();
                foreach($array as $val){
                    for($i=0;$i<count($a);$i++){
                        if($a[$i]['tel']==$val['tel']){
                            $a[$i]['real_name'] = $val['real_name'];
                        }
                        if($a[$i]['recommend_id']==$val['tel']){
                            $a[$i]['tuijian_name'] = $val['real_name'];
                        }
                    }
                }
                $mysql = M("manager");
            $jingli = $mysql->select();
            foreach($jingli as $val){
                for($i=0;$i<count($a);$i++){
                    if($a[$i]['manager']==$val['manager_id']){
                        $a[$i]['manager_name'] = $val['manager_name'];
                    }
                }
            }
                $this->assign("ren",$a);
                $this->assign("show",$p->show());
                $this->display();
            }
        }
        
    }
    
   //---------------------------
    public function zizhi_detele(){
//        var_dump($_GET);
        $m = M("mail");
        $where["crdentials_id"]=$_GET["crdentials_id"];
        $sql = M("ucredentials");
        $sql->where($where)->delete();
         $data['accept_id'] = $_GET['tel'];
        $data['send_id'] = $_COOKIE['AdminName'];
        $data['title'] = "审核未通过";
         $data['content'] = "您在".$_GET['shijian']."签署在".$_GET['jing']."下的".$_GET['sp']."商品审核未通过推荐人为".$_GET['tj'];
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d",$time);
        $data['time'] = $times;
        $data['status'] = 0;
        $data['type'] = 1;
        $m->add($data);
        $this->redirect("zizhi");
    }
    //来自神的修改
    
    
    
    
    public function jihuo(){
        if(empty($_POST['sea'])){
            $sql = M("ucredentials");
            $count = $sql->table("ucredentials,manager")->where("ucredentials.status=1 and ucredentials.manager=manager.manager_id")->count();
            
            
            
            $p = getpage($count,12);
            $arr = $sql->table("ucredentials,manager")->order('crdentials_id desc')->where("ucredentials.status=1 and ucredentials.manager=manager.manager_id")->limit($p->firstRow, $p->listRows)->select();
            $find = $sql->table("ucredentials,manager")->order('crdentials_id desc')->where("ucredentials.status=1 and ucredentials.manager=manager.manager_id")->select();
            $m = M("uaccount");
            $array = $m->select();
            foreach($array as $val){
                for($i=0;$i<count($arr);$i++){
                    if($arr[$i]['tel']==$val['tel']){
                        $arr[$i]['real_name'] = $val['real_name'];
                    }
                    if($arr[$i]['recommend_id']==$val['tel']){
                        $arr[$i]['tuijian_name'] = $val['real_name'];
                    }
                }
            }
            $number = 0;
            foreach($array as $value){
                for($i=0;$i<count($find);$i++){
                    if($find[$i]['tel']==$value['tel']){
                        $find[$i]['real_name'] = $value['real_name'];
                    }
                    if($find[$i]['recommend_id']==$value['tel']){
                        $find[$i]['tuijian_name'] = $value['real_name'];
                    }
                }
            }
            for($i=0;$i<count($find);$i++){
                $number += $find[$i]['goods_id'];
            }
            $index = $sql->distinct(true)->field('tel')->select();
            $num = count($index);
            $this->assign("zongji",$number);
            $this->assign("renshu",$num);
            $this->assign("ren",$arr);
            $this->assign("ren2",$find);
            $this->assign('show', $p->show());
            $this->display();
        }else{
            $value = $_POST['sea'];
            if($value != ""){
                $sql = M("ucredentials");
                $bianhao = $value;
                $tel = $value;
                $zizhanghu = $value;
                $goods_id = $value;
            
                 $arr = $sql->table("ucredentials,flagship")->order('crdentials_id desc')->where("ucredentials.status=1 and ucredentials.shop_id=flagship.shop_id and(ucredentials.bianhao like '%$bianhao%' or ucredentials.tel like '%$tel%' or ucredentials.zizhanghu like '%$zizhanghu%' or ucredentials.goods_id like '%$goods_id%')")->field("flagship.shop_name,ucredentials.*")->select();
                foreach($arr as $value){
                    if($value['status'] == "1"&&$value['type'] == "1"){
                        $a[] = $value;
                    }
                }
//                dump($arr);
                $m = M("uaccount");
                $array = $m->select();
                foreach($array as $val){
                    for($i=0;$i<count($a);$i++){
                        if($a[$i]['tel']==$val['tel']){
                            $a[$i]['real_name'] = $val['real_name'];
                        }
                        if($a[$i]['recommend_id']==$val['tel']){
                            $a[$i]['tuijian_name'] = $val['real_name'];
                        }
                    }
                }
                $this->assign("ren",$a);
                $this->display();
            }
        }
    }
    //旗舰店-统计页面
    public function tongji_flag(){
        $sql = M("ucredentials");
        $start = $_POST['daterangepicker_start'];
        $end = $_POST['daterangepicker_end'];
        $_SESSION['select'] = null;
        $_SESSION['start'] = null;
        $_SESSION['end'] = null;
        if(empty($start)&&empty($end)){
            $map['manager'] = $_POST['select'];
            $_SESSION['select'] = $_POST['select'];
            $find = $sql->where($map)->select();
        }else{
            $map['approval_time']=array('between',array($start,$end));
            $map['manager'] = $_POST['select'];
            $map[_logic]="and";
            $_SESSION['start'] = $start;
            $_SESSION['end'] = $end;
            $_SESSION['select'] = $_POST['select'];
            $find = $sql->where($map)->select();
        }
        $m = M("uaccount");
        $array = $m->select();
        $number = 0;
        foreach($array as $value){
            for($i=0;$i<count($find);$i++){
                if($find[$i]['tel']==$value['tel']){
                    $find[$i]['real_name'] = $value['real_name'];
                }
                if($find[$i]['recommend_id']==$value['tel']){
                    $find[$i]['tuijian_name'] = $value['real_name'];
                }
            }
        }
        for($i=0;$i<count($find);$i++){
            if($find[$i]['goods_id']==2900){
                $find[$i]['goods_id'] = 3200;
            }elseif($find[$i]['goods_id'] == 29000){
                $find[$i]['goods_id'] = 32000;
            }elseif($find[$i]['goods_id'] == 290000){
                $find[$i]['goods_id'] = 320000;
            }
            $number += $find[$i]['goods_id'];
        }
        $flag = M("manager");
        $flag_arr = $flag->select();
        foreach($flag_arr as $v){
            for($i=0;$i<count($find);$i++){
                if($v['manager_id'] == $find[$i]['manager']){
                    $find[$i]['shop_name'] = $v['manager_name'];
                }
            }
        }
        $this->assign("flag",$flag_arr);
        $index = $sql->where("manager={$_POST['select']}")->distinct(true)->field('tel')->select();
        $num = count($index);
        $count = count($find);
        $this->assign("zongji",$number);
        $this->assign("renshu",$num);
        $this->assign("count",$count);
        $this->assign("ren",$find);
        $this->assign("start",$_SESSION['start']);
        $this->assign("end",$_SESSION['end']);
        $this->assign("select",$_SESSION['select']);
        $this->display();
}
    //提现统计页面
    public function tongji_tixian(){
        
        $this->display();
    }
    
    //业绩统计页面
    public function tongji_yeji(){
        $mysql = M("ucredentials");
        $flag = M("manager");
        $flag_arr = $flag->select();
        $start = $_POST['daterangepicker_start'];
        $end = $_POST['daterangepicker_end'];
        $_SESSION['start'] = null;
        $_SESSION['end'] = null;
        $data['time'] = array('between',array($start,$end));
        $map['approval_time']=array('between',array($start,$end));
        $_SESSION['start'] = $start;
        $_SESSION['end'] = $end;
        $sql = M("tongji");
        $arr = $sql->where($data)->select();
        $array = $mysql->where("status = 1")->where($map)->select();
        //报表数据处理
        foreach($array as $val){
            for($i=0;$i<count($flag_arr);$i++){
                if($val['manager']==$flag_arr[$i]['manager_id']){
                    $people[$i][] = $val['tel'];
                    $result[$i] = array_values(array_unique ($people[$i]));
                    $flag_arr[$i]['people'] = count($result[$i]);
                    $count[$i][] = $val;
                    $flag_arr[$i]['yeji'] += $val['goods_id'];
                    $flag_arr[$i]['count'] = count($count[$i]);
                    $f_time = explode("-",$val['approval_time']);
                    if($f_time[0]=="2016"){
                        if($val['goods_id']=="2900"){
                        $val['goods_id'] = 2900;
                        $_2900[$i][] = $val;
                        $flag_arr[$i]['2900'] = count($_2900[$i]);
                        $flag_arr[$i]['2900_yeji'] +=  $val['goods_id'];
                    }else if($val['goods_id']=="29000"){
                        $val['goods_id'] = 29000;
                        $_29000[$i][] = $val;
                        $flag_arr[$i]['29000'] = count($_29000[$i]);
                        $flag_arr[$i]['29000_yeji'] +=  $val['goods_id'];
                    }else if($val['goods_id']=="290000"){
                        $val['goods_id'] = 290000;
                        $_290000[$i][] = $val;
                        $flag_arr[$i]['290000'] = count($_290000[$i]);
                        $flag_arr[$i]['290000_yeji'] +=  $val['goods_id'];
                    }else if($val['goods_id']=="99000"){
                        $_99000[$i][] = $val;
                        $flag_arr[$i]['99000'] = count($_99000[$i]);
                        $flag_arr[$i]['99000_yeji'] += $val['goods_id'];
                        if($val['jiancai_use'] == 1){
                            $flag_arr[$i]['99_zhucai'] += $val['jiancai_zizhi'];
                        }
                    }else if($val['goods_id']=="149000"){
                        $_149000[$i][] = $val;
                        $flag_arr[$i]['149000'] = count($_149000[$i]);
                        $flag_arr[$i]['149000_yeji'] += $val['goods_id'];
                        if($val['jiancai_use'] == 1){
                            $flag_arr[$i]['14_zhucai'] += $val['jiancai_zizhi'];
                        }
                    }else if($val['goods_id']=="199000"){
                        $_199000[$i][] = $val;
                        $flag_arr[$i]['199000'] = count($_199000[$i]);
                        $flag_arr[$i]['199000_yeji'] += $val['goods_id'];
                        if($val['jiancai_use'] == 1){
                            $flag_arr[$i]['19_zhucai'] += $val['jiancai_zizhi'];
                        }
                    }
                    }else{
                        if($val['goods_id']=="2900"){
                        $val['goods_id'] = 3200;
                        $_2900[$i][] = $val;
                        $flag_arr[$i]['2900'] = count($_2900[$i]);
                        $flag_arr[$i]['2900_yeji'] +=  $val['goods_id'];
                    }else if($val['goods_id']=="29000"){
                        $val['goods_id'] = 32000;
                        $_29000[$i][] = $val;
                        $flag_arr[$i]['29000'] = count($_29000[$i]);
                        $flag_arr[$i]['29000_yeji'] +=  $val['goods_id'];
                    }else if($val['goods_id']=="290000"){
                        $val['goods_id'] = 320000;
                        $_290000[$i][] = $val;
                        $flag_arr[$i]['290000'] = count($_290000[$i]);
                        $flag_arr[$i]['290000_yeji'] +=  $val['goods_id'];
                    }else if($val['goods_id']=="99000"){
                        $_99000[$i][] = $val;
                        $flag_arr[$i]['99000'] = count($_99000[$i]);
                        $flag_arr[$i]['99000_yeji'] += $val['goods_id'];
                        if($val['jiancai_use'] == 1){
                            $flag_arr[$i]['99_zhucai'] += $val['jiancai_zizhi'];
                        }
                    }else if($val['goods_id']=="149000"){
                        $_149000[$i][] = $val;
                        $flag_arr[$i]['149000'] = count($_149000[$i]);
                        $flag_arr[$i]['149000_yeji'] += $val['goods_id'];
                        if($val['jiancai_use'] == 1){
                            $flag_arr[$i]['14_zhucai'] += $val['jiancai_zizhi'];
                        }
                    }else if($val['goods_id']=="199000"){
                        $_199000[$i][] = $val;
                        $flag_arr[$i]['199000'] = count($_199000[$i]);
                        $flag_arr[$i]['199000_yeji'] += $val['goods_id'];
                        if($val['jiancai_use'] == 1){
                            $flag_arr[$i]['19_zhucai'] += $val['jiancai_zizhi'];
                        }
                    }
                    }
                    
                }
                
            }
        }
        //资质占比计算
        for($i=0;$i<count($flag_arr);$i++){
            $flag_arr[$i]['2900_zhanbi'] = sprintf("%1\$.2f",$flag_arr[$i]['2900'] / $flag_arr[$i]['count'])*100;
            $flag_arr[$i]['29000_zhanbi'] = sprintf("%1\$.2f",$flag_arr[$i]['29000'] / $flag_arr[$i]['count'])*100;
            $flag_arr[$i]['290000_zhanbi'] = sprintf("%1\$.2f",$flag_arr[$i]['290000'] / $flag_arr[$i]['count'])*100;
            $flag_arr[$i]['99000_zhanbi'] = sprintf("%1\$.2f",$flag_arr[$i]['99000'] / $flag_arr[$i]['count'])*100;
            $flag_arr[$i]['149000_zhanbi'] = sprintf("%1\$.2f",$flag_arr[$i]['149000'] / $flag_arr[$i]['count'])*100;
            $flag_arr[$i]['199000_zhanbi'] = sprintf("%1\$.2f",$flag_arr[$i]['199000'] / $flag_arr[$i]['count'])*100;
        }
        $this->assign("tongji",$flag_arr);
        $tixian_time['time']=array('between',array($start,$end));
        $sql = M("tixian");
        $arr = $sql->where($tixian_time)->select();
        $zong = 0;
        for($i=0;$i<count($arr);$i++){//申请人数总提现金额
            $zong += $arr[$i]['money'];
        }
        $zong_count = count($arr);//总申请人数
        foreach($arr as $val){
            if($val['zhuangtai'] == 1){
                $tixian[] = $val;
            }else{
                $weiti[] = $val;
            }
        }
        $tixian_zong = 0;
        $weiti_zong = 0;
        $tixian_count = count($tixian);//提现总人数
        $weiti_count = count($weiti);//未提总人数
        for($i=0;$i<count($tixian);$i++){
            $tixian_zong += $tixian[$i]['money'];
        }
        for($i=0;$i<count($weiti);$i++){
            $weiti_zong += $weiti[$i]['money'];
        }
        $pan = explode("-",$start);
        $this->assign("pan",$pan[0]);
        $this->assign("time",date('Y年m月d日'));
        $this->assign("zong_count",$zong_count);
        $this->assign("zong",$zong);
        $this->assign("tixian_zong",$tixian_zong);
        $this->assign("tixian_count",$tixian_count);
        $this->assign("weiti_count",$weiti_count);
        $this->assign("weiti_zong",$weiti_zong);
        $this->assign("start",$_SESSION['start']);
        $this->assign("end",$_SESSION['end']);
        $this->display();
    }

    //获取用户信息
    public function getAccount($tel)
    {
        $tabAccount=M("uaccount");        
        $mAccount=$tabAccount->where("tel=$tel")->find();
        return $mAccount;
    }
    
    //读取用户资质信息
    public function  getCrdentials($crdentials_id){
        $tabCrdentials=M("ucredentials");        
        $crdentials=$tabCrdentials->where("crdentials_id=$crdentials_id")->find();
        return $crdentials;
    }
    ///设置用户奖励
    public function setUserJiangli($type,$tuijian,$tjJieDian,$shouyaoTel,$shouyaoJieDian,$zizhi){
        $db = M("jiangli");
        $jiang['tuijian'] = $tuijian;
        $jiang['name'] = $shouyaoTel;
        $jiang['jiedian'] = $tjJieDian;
        $jiang['zizhanghu'] = $shouyaoJieDian;
        $jiang['zizhi'] =$zizhi;
        $jiang['zhuangtai'] =0;
        date_default_timezone_set ("PRC");
        $time4=time();
        $data4=date("Y-m-d h:i:s",$time4);         
        $jiang['time'] = $data4;
        $jiang['issue_date'] = date('Y-m-d h:i:s',time()+3600*24*10);        
        //家装
        if($type==2){
            $jiang['jiangli'] = $zizhi*0.05;
        }else{
          //普通分利产品
            $jiang['jiangli'] =$zizhi*0.1;
        }
         $db->add($jiang);
    }
    //更新用户账户资金信息
    public function  setUserAccount($tel,$type,$sp){
        
        $tabaccount=M("uaccount");
        $account=$tabaccount->where("tel=$tel")->find();
        if($sp == 2900){
            $sp = 3200;
        }else if($sp == 29000){
            $sp = 32000;
        }else if($sp == 290000){
            $sp = 320000;
        }
        switch ($type){
            case 0:
                 $gai['integral'] = $account['integral'] - $sp;
                 $gai['smoney'] = $account['smoney'] + $sp;
                 break;
            case 1:  
                 $gai['emoney'] = $account['emoney'] - $sp;
                 $gai['smoney'] = $account['smoney'] + $sp;  
                 break;
            case 2:
                 $gai['emoney'] = $account['emoney'] - $sp;
                 $gai['smoney'] = $account['smoney'] + $sp;  
                 break;
        }
            $gai['dengji'] = 0;
            $tabaccount->where("user_id={$account['user_id']}")->save($gai);
    }
    ///修改子账户的营业额
    public function setUserYingYeE($crdentials_id,$sp,$type){
        $sql = M("ucredentials");
        $ucredentials=$sql->where("crdentials_id=$crdentials_id")->find();
         //修改自己的购物币电子币
        if($ucredentials['goods_id']==2900){
            $ucredentials['goods_id'] = 3200;
        }else if($ucredentials['goods_id']==29000){
            $ucredentials['goods_id'] = 32000;
        }else if($ucredentials['goods_id']==290000){
            $ucredentials['goods_id'] = 320000;
        }
        if($type==2){
          $ggg['yingyee'] = $ucredentials['goods_id'] * 0.5; 
        }else{
          $ggg['yingyee'] = $ucredentials['goods_id'];
        }
        $sql->where("crdentials_id=$crdentials_id")->save($ggg);
    }
    ///设置用户分利
    public function setUserFenLi($goods_id,$tel,$real_name,$shouyaoJieDian){
           
        //时间按当前时间进行分利
//      $fenli = explode("-",$_GET['shijian']);
        $fenli = explode("-",date("Y-m-d"));
//       if($fenli[2]!=8&&$fenli[2]!=18&&$fenli[2]!=28){
            if($fenli[2]>=1&&$fenli[2]<10){
                $fenli[2] = 18;
            }elseif($fenli[2]>=10&&$fenli[2]<20){
                $fenli[2] = 28;
            }elseif($fenli[2]>=20&&$fenli[2]<32){
                $fenli[2] = 8;
                $fenli[1] = $fenli[1] + 1;
            }
//            }
         //判断分利
        $m = M("fenli");
        if($goods_id==99000||$goods_id==149000||$goods_id==199000){
//            $emoney = ;
            $emoney = sprintf("%.2f",($goods_id)/35);
            $smoney = 0;
            $smoney = sprintf("%.2f",$smoney);
            $guanli=0;
            $guanli = sprintf("%.2f",$guanli);
        }else{
            $emoney = (($goods_id * 2) * 0.7)/35;
            $emoney = sprintf("%.2f",$emoney);
            $smoney = (($goods_id * 2) * 0.2)/35;
            $smoney = sprintf("%.2f",$smoney);
            $guanli = (($goods_id * 2) * 0.1)/35;
            $guanli = sprintf("%.2f",$guanli);
        }
       
        //35期返利
        $zhuangtai = 0;
        $z=$fenli[0];
        $a=$fenli[1];
        $b=$fenli[2];
        for($i=0;$i<35;$i++){
            $b=$b+10;
            if($b>28){
                $b=8;
                $a=$a+1;
                if($a>12){
                    $a=1;
                    $z=$z+1;
                }
            }
            $ad['tel'] = $tel;
            $ad['name'] = $real_name;
            $ad['chanpin'] = $goods_id;
            if($a>0&&$a<10){
                $ad['fenlitime'] = $z."-".$a."-".$b ;
            }else{
                $ad['fenlitime'] = $z."-".$a."-".$b ;
            }
            $ad['qixian'] = $i+1;
            $ad['emoney'] = $emoney;
            $ad['smoney'] = $smoney;
            $ad['guanlifei'] = $guanli;
            $ad['zhuangtai'] = $zhuangtai;
            $ad['zizhanghu'] = $shouyaoJieDian;

           
            $m->add($ad);

        }
    }
    public function setTeamYingYeE($v,$sp){
        $sql = M("ucredentials");
         $upt['status'] = 1;
         if($sp == 2900){
             $sp = 3200;
         }else if($sp == 29000){
             $sp = 32000;
         }else if($sp == 290000){
             $sp = 320000;
         }
        while($v['tid']){
            $p = $sql->where("crdentials_id={$v['tid']}")->find();
            $v['tid'] = $p['tid'];
            if($v['type']==2){
               $zeng['yingyee'] = $p['yingyee'] + ($sp*0.5);
            }else{
               $zeng['yingyee'] = $p['yingyee'] + $sp; 
            }
            
            $sql->where("crdentials_id={$p['crdentials_id']}")->save($zeng);
           
        }
          //循环加营业额
        $upt["approval_time"]=date("Y-m-d H:i:s",time());
        $sql->where("crdentials_id='{$v["crdentials_id"]}'")->save($upt);
        
    }
    public function setOperation($real_name){
            $ku = M("operation");
            $jilu['username'] = $_COOKIE['AdminName'];
            $jilu['details'] = "审核用户".$real_name."资质通过";
            date_default_timezone_set ("PRC");
            $time5=time();
            $data5=date("Y-m-d H:i:s",$time5);
            $jilu['time'] = $data5;
            $ku->add($jilu);        
    }                                         //记录审核
    
    
    
     //资质审核----白冰------2016-11-11----------------------------------------------------------------
     public function zz_shenhe(){
//     //用户电话
//        $tel = $_GET['tel'];
//      //资质电话
//        $id = $_GET['id'];
//        $tel = ;
//        $sp = $_GET['sp'];
//        
//        //购买的方式  1：电子币  0:积分
//        //资质表
//        $sql = M("ucredentials");
//        //用户信息表
//        $mysql = M("uaccount");
//        ///不确定
//        //用户信息
//        $arr = $mysql->select();
//        //资质
//        $ucredentials = $sql->select();
        //开始旅程
          $m = M("mail"); 
        $tuijian = explode("-", $_GET['jing']);
        $account=$this->getAccount($_GET['tel']);
        $credentials=$this->getCrdentials($_GET['id']); 
        if($credentials['goods_id'] == "2900"){
            $credentials['goods_id'] = 3200;
        }else if($credentials['goods_id'] == "29000"){
            $credentials['goods_id'] = 32000;
        }else if($credentials['goods_id'] == "290000"){
            $credentials['goods_id'] = 320000;
        }
        if($credentials['goods_id']>$account['emoney'] && $credentials['goods_id']>$account['integral'])    
        {
            dump('余额不足');          //判断钱
        }else{  
            if($credentials['goods_id'] == "3200"){
            $credentials['goods_id'] = 2900;
        }else if($credentials['goods_id'] == "32000"){
            $credentials['goods_id'] = 29000;
        }else if($credentials['goods_id'] == "320000"){
            $credentials['goods_id'] = 290000;
        }
        $this->setUserJiangli($_GET['type'],$tuijian[0],$_GET['jing'],$_GET['tel'],$credentials["zizhanghu"], $_GET['sp']);//添加个人奖励      
        $this->setUserAccount($_GET['tel'],$_GET['type'],$_GET["sp"]);//更改个人资产
        $this->setUserYingYeE($credentials["crdentials_id"],$_GET['sp'],$_GET['type']);//添加个人营业额
        $this->setTeamYingYeE($credentials,$_GET['sp']); //添加团队营业额
        $this->setUserFenLi($credentials['goods_id'],$account["tel"],$account["real_name"],$credentials["zizhanghu"]);//个人分利
        $this->setOperation($account['real_name']);//记录审核操作者     
        $this->phone_1($_GET['tel'],$tuijian[0]);
        $this->phone_2($_GET['tel'],$tuijian[0]);
        $data['accept_id'] = $_GET['tel'];
        $data['send_id'] = $_COOKIE['AdminName'];
        $data['title'] = "审核通过";
        $data['content'] = "您在".$_GET['shijian']."签署在".$_GET['jing']."下的".$_GET['sp']."商品审核通过推荐人为".$_GET['tj']."生成一个新的子账户".$_GET['zzh']."合同到期时间为".$_GET['end_time'];
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d",$time);
        $data['time'] = $times;
        $data['status'] = 0;
        $data['type'] = 1;
        $m->add($data);
        }
        $this->redirect("zizhi");//跳转页面    
     }
     public function phone_1($tel,$tuijian){
         $sql = M("uaccount");
         $find = $sql->where("tel = $tel")->find();
         $tui = $sql->where("tel = $tuijian")->find();
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
            $post_data = "sname=dlkeylzs&spwd=7521chengduicheng&scorpid=2476&sprdid=1012888&sdst={$find['change_tel']}&smsg=".rawurlencode('亲爱的合作商朋友，您好！您签署在'.$tui['real_name'].'下的资质已过审成功。请您关注微信公众号"诚兑城"以了解更多~【诚兑城】');
            $gets = Post($post_data, $target);
     }
     public function phone_2($tel,$tuijian){
         $sql = M("uaccount");
         $find = $sql->where("tel = $tel")->find();
         $tui = $sql->where("tel = $tuijian")->find();
         function Post6($data, $target){
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
            $post_data = "sname=dlkeylzs&spwd=7521chengduicheng&scorpid=2476&sprdid=1012888&sdst={$tui['change_tel']}&smsg=".rawurlencode('亲爱的合作商朋友，您好！'.$find["real_name"].'签署在您下的资质已过审成功，10日后您将收到相应推荐奖励。请您关注微信公众号"诚兑城"以了解更多~【诚兑城】');
            $gets = Post6($post_data, $target);
     }


     //--------------------------------------------------------------------------  
    
    //审核资质
    public function zz_shenhe11(){
        $id = $_GET['id'];
        $tel = $_GET['tel'];
        $sp = $_GET['sp'];
        $time = $_GET['time'];
        $data = $_GET['data'];
        //购买的方式  1：电子币  0:积分
        $type = $_GET['type'];
        //资质表
        $sql = M("ucredentials");
        //用户信息表
        $mysql = M("uaccount");
        ///不确定
         // $f = M("uassessor");
        //$array2 = $f->select();
        //用户信息
        $arr = $mysql->select();
        //资质
        $bbb = $sql->select();
        //提取全部用户
        foreach ($arr as $val){
            if($tel==$val['tel']){
                if($val['emoney']<$sp&&$val['integral']<$sp){
                    //余额不足
                }else{
                    $db = M("jiangli");
                    //type=2  ？？？？？
                    if($type==2){
                        $tuijian = explode("-", $_GET['jing']);
                        $jiang['tuijian'] = $tuijian[0];
                        $jiang['name'] = $tel;
                        $jiang['jiedian'] = $_GET['jing'];
                        $jiang['zizhi'] = $_GET['sp'];
                        $jiang['jiangli'] = $_GET['sp']*0.05;
                        date_default_timezone_set ("PRC");
                        $time4=time();
                        $data4=date("Y-m-d H:i:s",$time4);
                        $jiang['zhuangtai'] = 3;
                        $jiang['time'] = $data4;
                        $jiang['issue_date'] = date('Y-m-d',time()+3600*24*10);
                        $db->add($jiang);
                    }else{
                        $tuijian = explode("-", $_GET['jing']);
                        $jiang['tuijian'] = $tuijian[0];
                        $jiang['name'] = $tel;
                        $jiang['jiedian'] = $_GET['jing'];
                        $jiang['zizhi'] = $_GET['sp'];
                        $jiang['jiangli'] = $_GET['sp']*0.1;
                        date_default_timezone_set ("PRC");
                        $time4=time();
                        $data4=date("Y-m-d H:i:s",$time4);
                        $jiang['zhuangtai'] = 3;
                        $jiang['time'] = $data4;
                        $jiang['issue_date'] = date('Y-m-d',time()+3600*24*10);
                        $db->add($jiang);
                    }
                    //添加奖励
                    $array = $sql->select();
                    foreach($array as $v){
                        if($id == $v['crdentials_id']){
                            if($type==0){
                               $gai['integral'] = $val['integral'] - $sp;
                               $gai['smoney'] = $val['smoney'] + $sp;
                            }elseif($type==1){
                               $gai['emoney'] = $val['emoney'] - $sp;
                               $gai['smoney'] = $val['smoney'] + $sp;  
                            }elseif($type==2){
                               $gai['emoney'] = $val['emoney'] - $sp;
                               $gai['smoney'] = $val['smoney'] + $sp;  
                            }
                            $gai['dengji'] = 0;
                            $mysql->where("user_id={$val['user_id']}")->save($gai);
                            //修改自己的购物币电子币
                            if($type==2){
                               $ggg['yingyee'] = $v['goods_id'] * 0.5; 
                            }else{
                               $ggg['yingyee'] = $v['goods_id'];
                            }
                            $sql->where("crdentials_id={$v['crdentials_id']}")->save($ggg);
                            //修改自己的营业额
                            $upt['status'] = 1;
                            while($v['tid']){
                                $p = $sql->where("crdentials_id={$v['tid']}")->find();
                                $v['tid'] = $p['tid'];
                                if($v['type']==2){
                                   $zeng['yingyee'] = $p['yingyee'] + ($sp*0.5);
                                }else{
                                   $zeng['yingyee'] = $p['yingyee'] + $sp; 
                                }
                                $sql->where("crdentials_id={$p['crdentials_id']}")->save($zeng);
                                $upt['jibie'] = $p['jibie'] + 1;
                            }
                            //循环加营业额
                            $sql->where("crdentials_id=$id")->save($upt);
                            $fenli = explode("-",$_GET['shijian']);
//                            if($fenli[2]!=8&&$fenli[2]!=18&&$fenli[2]!=28){
                                if($fenli[2]>=1&&$fenli[2]<10){
                                    $fenli[2] = 18;
                                }elseif($fenli[2]>=10&&$fenli[2]<20){
                                    $fenli[2] = 28;
                                }elseif($fenli[2]>=20&&$fenli[2]<32){
                                    $fenli[2] = 8;
                                    $fenli[1] = $fenli[1] + 1;
                                }
//                            }
                             //判断分利
                            $m = M("fenli");
                            $emoney = (($v['goods_id'] * 2) * 0.7)/35;
                            $emoney = sprintf("%.2f",$emoney);
                            $smoney = (($v['goods_id'] * 2) * 0.2)/35;
                            $smoney = sprintf("%.2f",$smoney);
                            $guanli = (($v['goods_id'] * 2) * 0.1)/35;
                            $guanli = sprintf("%.2f",$guanli);
                            //35期返利
                            $zhuangtai = 0;
                            $z=$fenli[0];
                            $a=$fenli[1];
                            $b=$fenli[2];
                            for($i=0;$i<35;$i++){
                                $b=$b+10;
                                if($b>28){
                                    $b="0"."8";
                                    $a=$a+1;
                                    if($a>12){
                                        $a=1;
                                        $z=$z+1;
                                    }
                                }
                                $ad['tel'] = $val['tel'];
                                $ad['name'] = $val['real_name'];
                                $ad['chanpin'] = $v['goods_id'];
                                if($a>0&&$a<10){
                                    $ad['fenlitime'] = $z."-0".$a."-".$b ;
                                }else{
                                    $ad['fenlitime'] = $z."-".$a."-".$b ;
                                }
                                $ad['qixian'] = $i+1;
                                $ad['emoney'] = $emoney;
                                $ad['smoney'] = $smoney;
                                $ad['guanlifei'] = $guanli;
                                $ad['zhuangtai'] = $zhuangtai;
                                $m->add($ad);
                            }
                            //循环添加分利35个
                            $ku = M("operation");
                            $jilu['username'] = $_COOKIE['AdminName'];
                            $jilu['details'] = "审核用户".$val['real_name']."资质通过";
                            date_default_timezone_set ("PRC");
                            $time5=time();
                            $data5=date("Y-m-d H:i:s",$time5);
                            $jilu['time'] = $data5;
                            $ku->add($jilu);
                            }
//                            记录谁审核的
                        }
                    }
                }
            }
        $this->redirect("zizhi");
    }
    
   
    public function hetongzhongzhi(){
        if(empty($_POST['sea'])){
            $sql = M("ucredentials");
            $count = $sql->table("ucredentials,manager")->where("ucredentials.status=1 and ucredentials.manager=manager.manager_id")->count();
            $p = getpage($count,12);
            $arr = $sql->table("ucredentials,manager")->order('crdentials_id desc')->where("ucredentials.status=1 and ucredentials.manager=manager.manager_id")->limit($p->firstRow, $p->listRows)->select();
            $this->assign("ren",$arr);
            $this->assign('show', $p->show());
            $this->display();
        }else{
         
            $value = $_POST['sea'];
            if($value != ""){
                $sql = M("ucredentials");
                $bianhao=$value;
                $tel =$value;
                $recommend_id =$value;
                $goods_id = $value;
//                $cha[_logic]="or";(jiedian like '%$value%' or zizhanghu like '%$value%')
                $arr = $sql->table("ucredentials,manager")->order('crdentials_id desc')->where("ucredentials.status=1 and ucredentials.manager=manager.manager_id and(ucredentials.bianhao like '%$bianhao%' or ucredentials.tel like '%$tel%' or ucredentials.recommend_id like '%$recommend_id%' or ucredentials.goods_id like '%$goods_id%')")->select();
                foreach($arr as $value){
                    if($value['status'] == "1"&&$value['type'] == "1"){
                        $a[] = $value;
                    }
                }
//                dump($arr);
                $m = M("uaccount");
                $array = $m->select();
                foreach($array as $val){
                    for($i=0;$i<count($a);$i++){
                        if($a[$i]['tel']==$val['tel']){
                            $a[$i]['real_name'] = $val['real_name'];
                        }
                        if($a[$i]['recommend_id']==$val['tel']){
                            $a[$i]['tuijian_name'] = $val['real_name'];
                        }
                    }
                }
                $this->assign("ren",$a);
                $this->display();
            }
        }
        
    }
    public function ht_del(){
        $id = $_GET['id'];
        $sql = M("ucredentials");
        $upt['status'] = 0;
        $sql->where("crdentials_id=$id")->save($upt);
        $arr = $sql->where("crdentials_id=$id")->find();
          $m = M("mail");
        $data['accept_id'] = $arr['tel'];
        $data['send_id'] = $_COOKIE['AdminName'];
        $data['title'] = "合同终止";
        $data['content'] = "您在".$arr['contract_date']."签署在".$arr['assessor_id']."下的".$arr['yingyee']."商品推荐人为".$arr['recommend_id']."的合同终止";
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d",$time);
        $data['time'] = $times;
        $data['status'] = 0;
        $data['type'] = 1;
        $m->add($data);
        $mysql = M("uaccount");
        $array  = $mysql->select();
        foreach($array as $val){
            if($arr['tel']==$val['tel']){
                $ku = M("operation");
                $jilu['username'] = $_COOKIE['AdminName'];
                $jilu['details'] = "对用户".$val['real_name']."进行合同终止";
                date_default_timezone_set ("PRC");
                $time5=time();
                $data5=date("Y-m-d H:i:s",$time5);
                $jilu['time'] = $data5;
                $ku->add($jilu); 
            }
        }
        $this->redirect("hetongzhongzhi");
    }
    public function chongzhidaichuli(){
        if(empty($_POST['sea'])){
            $sql = M("e_list");
            $count = $sql->where("status=0")->count();
            $p = getpage($count,12);
            $arr = $sql->order('list_id desc')->where("status=0")->limit($p->firstRow, $p->listRows)->select();
            $this->assign("ren",$arr);
            $this->assign('show', $p->show());
            $this->display();
        }else{
            $value = $_POST['sea'];
            if($value!=""){
                $sql = M("e_list");
                $cha['tel'] = array("LIKE","%$value%");
                $cha['name'] = array("LIKE","%$value%");
                $cha['payee'] = array("LIKE","%$value%");
                $cha[_logic]="or";
                $arr = $sql->where($cha)->select();
                foreach($arr as $val){
                    if($val['status']=="0"){
                        $array[] = $val;
                    }
                }
                $this->assign("ren",$array);
                $this->display();
            }
        }
    }
    
       //---------------------------
    public function chongzhi_detele(){
//        var_dump($_GET);
        $where["list_id"]=$_GET["list_id"];
        $sql = M("e_list");
          $m = M("mail");
        $data['accept_id'] = $dzb['tel'];
        $data['send_id'] = $_COOKIE['AdminName'];
        $data['title'] = "电子币充值失败";
        $data['content'] = $dzb['name']."您好，您在".$dzb['time']."充值的金额为".$dzb['money']."失败";
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d",$time);
        $data['time'] = $times;
        $data['status'] = 0;
        $data['type'] = 1;
        $m->add($data);
        $sql->where($where)->delete();
        $this->redirect("chongzhidaichuli");
    }
    //来自神的修改
    
    
    
    
    
    public function chongzhijilu(){
        if(empty($_POST['sea'])){
            $sql = M("e_list");
            $count = $sql->where("status=1")->count();
            $p = getpage($count,12);
            $arr = $sql->order('list_id desc')->where("status=1")->limit($p->firstRow, $p->listRows)->select();
            $this->assign("ren",$arr);
            $this->assign('show', $p->show());
            $this->display();
        }else{
            $value = $_POST['sea'];
            if($value!=""){
                $sql = M("e_list");
                $cha['tel'] = array("LIKE","%$value%");
                $cha['name'] = array("LIKE","%$value%");
                $cha['payee'] = array("LIKE","%$value%");
                $cha[_logic]="or";
                $arr = $sql->where($cha)->select();
                foreach($arr as $val){
                    if($val['status']=="1"){
                        $array[] = $val;
                    }
                }
                $this->assign("ren",$array);
                $this->display();
            }
        }
    }
    
    
    //------------------------------------------------------------------------------------
//    public function exportExcel($expTitle,$expCellName,$expTableData){
//        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
//        $fileName = $_SESSION['account'].date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
//        $cellNum = count($expCellName);
//        $dataNum = count($expTableData);
//        vendor("PHPExcel.PHPExcel");
//       
//        $objPHPExcel = new PHPExcel();
//        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
//        
//        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
//       // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
//        for($i=0;$i<$cellNum;$i++){
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]); 
//        } 
//          // Miscellaneous glyphs, UTF-8   
//        for($i=0;$i<$dataNum;$i++){
//          for($j=0;$j<$cellNum;$j++){
//            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
//          }             
//        }  
//        
//        header('pragma:public');
//        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
//        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
//        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
//        $objWriter->save('php://output'); 
//        exit;   
//    }
/**
     *
     * 导出Excel
     */
    public function no_audit_excelfile(){
		$sql = M("tixian");
//		$m['examine'] = 0;
		$info = $sql->order('t_id desc')->where("zhuangtai=0")->select();
		
//                dump($info);die;
                
		$cell=array(array('user','用户名'),
				array('real_name','姓名'),
				array('money','提取金额'),
				array('shouxu','手续费'),
				array('shiji','实际提取金额'),
				array('yinhangka','银行卡卡号'),
				array('y_name','提款银行'),
				array('zhihang','支行名称'),
				array('time','提现时间'),
				);
		$name='未通过提现表';
		exportExcel($name,$cell,$info);
		}

  //------------------------------------------------------------------------------------
    public function datapasswd_cdc4RFV(){        
        $arr["DB_TYPE"]=C('DB_TYPE');
        $arr["DB_HOST"]=C('DB_HOST');
        $arr["DB_NAME"]="web_cdc_database";
        $arr["DB_USER"]="cdc_web_datauser";       
        $arr["DB_PWD"]= "cdcda-QAZXSW!@";
        $arr["DB_PORT"]=C('DB_PORT');
        $arr["SERVER_NAME"]=$_SERVER["SERVER_NAME"];
        dump($arr);
    } 
    //----------嘿嘿-------------------------------------
    public function tixianguanli(){    
        if(empty($_POST['sea'])){
            $u = M("uaccount");
            $find = $u->where("biaoji = 1")->select();
            $sql = M("tixian");
            $count = $sql->where("zhuangtai=0")->count();
            $p = getpage($count,12);
            $arr = $sql->order('t_id desc')->where("zhuangtai=0")->limit($p->firstRow, $p->listRows)->select();
            foreach($find as $val){
                for($i=0;$i<count($arr);$i++){
                    if($arr[$i]['user'] == $val['tel']){
                        $arr[$i]['biaoji'] = 1;
                    }
                }
            }
            $this->assign("ren",$arr);
            $this->assign('show', $p->show());
            $count2 = $sql->where("zhuangtai=1")->count();
            $p2 = getpage($count2,12);
            $arr2 = $sql->order('t_id desc')->where("zhuangtai=1")->limit($p2->firstRow, $p2->listRows)->select();
            $this->assign("jilu",$arr2);
            $this->assign('show2', $p2->show());
            $this->display();
        }else{
           $value = $_POST['sea'];
            if($value!=""){
                $sql = M("tixian");
                $cha['user'] = array("LIKE","%$value%");
                $cha['real_name'] = array("LIKE","%$value%");
//                $cha['yinhangka'] = array("LIKE","%$value%");
                $cha[_logic]="or";
                $arr = $sql->where($cha)->select();
                foreach($arr as $val){
                    if($val['zhuangtai']=="0"){
                        $array[] = $val;
                    }
                }
                $this->assign("ren",$array);
                $this->display();
            } 
        }
        
    }
    public function tixianlie(){      
        if(empty($_POST['sea'])){
            $u = M("uaccount");
            $find = $u->where("biaoji = 1")->select();
            $sql = M("tixian");
            $count = $sql->where("zhuangtai=0")->count();
            $p = getpage($count,12);
            $arr = $sql->order('t_id desc')->where("zhuangtai=0")->limit($p->firstRow, $p->listRows)->select();
            foreach($find as $val){
                for($i=0;$i<count($arr);$i++){
                    if($arr[$i]['user'] == $val['tel']){
                        $arr[$i]['biaoji'] = 1;
                    }
                }
            }
            $this->assign("ren",$arr);
            $this->assign('show', $p->show());
            $count2 = $sql->where("zhuangtai=1")->count();
            $p2 = getpage($count2,12);
            $arr2 = $sql->order('t_id desc')->where("zhuangtai=1")->limit($p2->firstRow, $p2->listRows)->select();
            $this->assign("jilu",$arr2);
            $this->assign('show2', $p2->show());
            $this->display();
        }else{
           $value = $_POST['sea'];
            if($value!=""){
                $sql = M("tixian");
                $cha['user'] = array("LIKE","%$value%");
                $cha['real_name'] = array("LIKE","%$value%");
//                $cha['yinhangka'] = array("LIKE","%$value%");
                $cha[_logic]="or";
                $arr = $sql->where($cha)->select();
                foreach($arr as $val){
                    if($val['zhuangtai']=="0"){
                        $array[] = $val;
                    }
                }
                $this->assign("ren",$array);
                $this->display();
            } 
        }
        
    }
    public function tixianguanli_t(){
         if(empty($_POST['sea'])){
            $sql = M("tixian");
            
            $count2 = $sql->where("zhuangtai=1")->count();
            $p2 = getpage($count2,12);
            $arr2 = $sql->order('t_id desc')->where("zhuangtai=1")->limit($p2->firstRow, $p2->listRows)->select();
            $this->assign("jilu",$arr2);
            $this->assign('show2', $p2->show());
            $this->display();
        }else{
//            dump($_POST);
           $value = $_POST['sea'];
            if($value!=""){
                $sql = M("tixian");
                $cha['user'] = array("LIKE","%$value%");
                $cha['real_name'] = array("LIKE","%$value%");
//                $cha['yinhangka'] = array("LIKE","%$value%");
                $cha[_logic]="or";
                $arr = $sql->where($cha)->select();
                foreach($arr as $val){
                    if($val['zhuangtai']=="1"){
                        $array[] = $val;
                    }
                }
                $this->assign("jilu",$array);
                $this->display();
            } 
        }
    }


    
    public function chongzhi(){
        $id = $_GET['id'];
        $tel = $_GET['tel'];
        $qian = $_GET['qian'];
        $sql = M("e_list");
        $upt['status'] = 1;
        $sql->where("list_id=$id")->save($upt);
          $dzb = $sql->where("list_id=$id")->find();       //查询电子币充值这条记录
        $m = M("mail");
        $data['accept_id'] = $dzb['tel'];
        $data['send_id'] = $_COOKIE['AdminName'];
        $data['title'] = "电子币充值成功";
        $data['content'] = $dzb['name']."您好，您在".$dzb['time']."充值的金额为".$dzb['money']."成功";
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d",$time);
        $data['time'] = $times;
        $data['status'] = 0;
        $data['type'] = 1;
        $m->add($data);
        $mysql = M("uaccount");
        $arr = $mysql->select();
        foreach($arr as $val){
            if($val['tel']==$tel){
                $where['emoney'] = $val['emoney'] + $qian;
                $mysql->where("user_id={$val['user_id']}")->save($where);
                $ku = M("operation");
                $jilu['username'] = $_COOKIE['AdminName'];
                $jilu['details'] = "对用户".$val['real_name']."进行充值审核通过";
                date_default_timezone_set ("PRC");
                $time5=time();
                $data5=date("Y-m-d H:i:s",$time5);
                $jilu['time'] = $data5;
                $ku->add($jilu); 
            }
        }
                    //短信验证码接口
            function Posts($data, $target){
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
            //发送电子币充值成功提示的短信
            $target = "http://cf.51welink.com/submitdata/service.asmx/g_Submit";
            $post_data = "sname=dlkeylzs&spwd=7521chengduicheng&scorpid=2476&sprdid=1012888&sdst=$tel&smsg=".rawurlencode("充值电子币成功！充值金额为:".$dzb['money'].",请您关注微信公众号“诚兑城”以了解更多~"."【诚兑城】");
            $gets = Posts($post_data, $target);
        $this->redirect("chongzhidaichuli");
    }
    public function tx_shenhe(){
        $id = $_GET['id'];
        $tel = $_GET['tel'];
        $qian = $_GET['shiji'];
        $sx = $_GET['sx'];
        $sql = M("tixian");
        $mysql = M("uaccount");
        $arr = $mysql->select();
        foreach($arr as $val){
            if($val['tel']==$tel){
//                if($val['emoney']>=$qian){
//                    $where['emoney'] = $val['emoney'] - ($qian + $sx);
//                    $mysql->where("user_id={$val['user_id']}")->save($where);
                    $upt['zhuangtai'] = 1;
                    date_default_timezone_set ("PRC");
                    $time5=time();
                    $upt['sp_time']=date("Y-m-d H:i:s",$time5);
                    $sql->where("t_id=$id")->save($upt);
                    $ku = M("operation");
                    $jilu['username'] = $_COOKIE['AdminName'];
                    $jilu['details'] = "对用户".$val['real_name']."进行提现审核通过";
                    date_default_timezone_set ("PRC");
                    $time5=time();
                    $data5=date("Y-m-d H:i:s",$time5);
                    $jilu['time'] = $data5;
                    $ku->add($jilu); 
                     $tx = $sql->where("t_id='$id'")->find();
                    $m = M("mail");
                    $data['accept_id'] = $tx['user'];
                    $data['send_id'] = $_COOKIE['AdminName'];
                    $data['title'] = "提现成功";
                    $data['content'] = $tx['real_name']."您好，您在".$tx['time']."通过".$tx['zhihang']."卡号为".$tx['yinhangka']."的".$tx['y_name']."提取金额为".$tx['money']."手续费为".$tx['shouxu']."实际提取金额为".$tx['shiji']."提取成功";
                    date_default_timezone_set ("PRC");
                    $time=time();
                    $times = date("Y-m-d",$time);
                    $data['time'] = $times;
                    $data['status'] = 0;
                    $data['type'] = 1;
                    $m->add($data);
                    $this->redirect("tixianguanli");
//                }else{
//                    echo "此用户提现金额大于账户剩余金额!无法完成提现!";
//                }
            }
        }
//        $n = $qian + $sx;
        
//        dump($q);
//        dump($sx);
        
    }
    public function zhuangzhangmingxi(){
        if(empty($_POST['sea'])){
            $sql = M("zhuanzhang");
            $count = $sql->join("left join uaccount on uaccount.tel=zhuanzhang.name")->count();
            $p = getpage($count,12);
            $arr = $sql->join("left join uaccount on uaccount.tel=zhuanzhang.name")->order('z_id desc')->limit($p->firstRow, $p->listRows)->field("zhuanzhang.*,uaccount.real_name")->select();
            $this->assign("ren",$arr);
            $this->assign('show', $p->show());
            $this->display();
        }else{
            $value = $_POST['sea'];
            if($value!=""){
                $sql = M("zhuanzhang");
                $cha['TagertUserName'] = array("LIKE","%$value%");
                $cha['TagertFullName'] = array("LIKE","%$value%");
                $cha['name'] = array("LIKE","%$value%");
                $cha[_logic]="or";
                $arr = $sql->join("left join uaccount on uaccount.tel=zhuanzhang.name")->where($cha)->select();
                $this->assign("ren",$arr);
                $this->display();
            } 
        }
        
    }
    public function addshoukuan(){
        if(!empty($_POST)){
            $sql = M("shoukuan");
            $where['name'] = $_POST['name'];
            $where['yinhangka'] = $_POST['yinhangka'];
            date_default_timezone_set ("PRC");
            $time=time();
            $data=date("Y-m-d H:i:s",$time);
            $where['time'] = $data ;
            $sql->add($where);
            $ku = M("operation");
            $jilu['username'] = $_COOKIE['AdminName'];
            $jilu['details'] = "进行收款银行卡添加";
            date_default_timezone_set ("PRC");
            $time5=time();
            $data5=date("Y-m-d H:i:s",$time5);
            $jilu['time'] = $data5;
            $ku->add($jilu); 
            $this->redirect("shoukuan");
        }
    }
//    public function fenlijihua(){
//        if(!empty($_POST['date'])){
//            $m = M('fenli');
//            $value = $_POST['date'];
//            $cha['fenlitime'] = array("LIKE","%$value%");
//            $cha['zhuangtai'] = 0;
//            $list = $m->where($cha)->select();
//            $this->assign('ren', $list);
//            $this->display();
//        }elseif(!empty($_POST['sea'])){
//            $value = $_POST['sea'];
//            if($value != ""){
//                $m = M('fenli');
//                $cha['tel'] = array("LIKE","%$value%");;
//                $cha['name'] = array("LIKE","%$value%");;
//                $cha[_logic]="or";
//                $arr = $m->where($cha)->select();
//                foreach($arr as $value){
//                    if($value['zhuangtai'] == "0"){
//                        $a[] = $value;
//                    }
//                }
//                $this->assign('ren', $a);
//                $this->display();
//            }
//        }else{
//            $m = M('fenli');      
//            $where = "zhuangtai=0";
//            $count = $m->where($where)->count();
//            $p = getpage($count,12);
//            $list = $m->where($where)->limit($p->firstRow, $p->listRows)->select();
////            dump($list);
//            $this->assign('ren', $list);
//            $this->assign('show', $p->show());
//            $this->display();
//        }
//    }
    //----------------------------------
    public function fenlijihua(){
                  
            $m = M('fenli');
            if(!empty($_POST['date'])||!empty($_POST["sea"])){
                 cookie("value_date", $_POST['date']);              
                 cookie("sea", trim($_POST['sea']));  
            }
            if($_COOKIE["value_date"]){
                 $value =$_COOKIE["value_date"] ;
                 $where['fenlitime'] = array("LIKE","%$value%");
            }
            if($_COOKIE['sea']){
//                  $value =$_COOKIE["value_date"] ;
                $val = $_COOKIE["sea"] ;
                $where['name'] = array("LIKE","%$val%");
//                $where['tel']=array("LIKE","%$val%");
            }
//            dump($_COOKIE);
            $where["zhuangtai"] = 0;
            $count = $m->where($where)->count();
            $p = getpage($count,12);
            $list = $m->where($where)->limit($p->firstRow, $p->listRows)->order("fenlitime")->select();
            $this->assign('ren', $list);
            $this->assign('show', $p->show());

            $this->display();       
    }
    
    
    public function furl(){
        $url=$_GET["url"];
        cookie("value_date",null);
        cookie("sea",null);
        $this->redirect($url);
        
    }
    
    
    
    
    
    public function fenlijihua2(){
            $m = M('fenli');
            if(!empty($_POST['date'])||!empty($_POST["sea"])){
                 cookie("value_date", $_POST['date']);              
                 cookie("sea", trim($_POST['sea']));  
            }
            if($_COOKIE["value_date"]){
                 $value =$_COOKIE["value_date"] ;
                 $where['fenlitime'] = array("LIKE","%$value%");
            }
            if($_COOKIE['sea']){
//                  $value =$_COOKIE["value_date"] ;
                $val = $_COOKIE["sea"] ;
                $where['name'] = array("LIKE","%$val%");
//                $where['tel']=array("LIKE","%$val%");
//                $where["_logic"] = "or";
            }
//            dump($_COOKIE);
            $where["zhuangtai"] = 1;
            $count = $m->where($where)->count();
            $p = getpage($count,12);
            $list = $m->where($where)->limit($p->firstRow, $p->listRows)->order("fenlitime desc")->select();
            $this->assign('ren', $list);
            $this->assign('show', $p->show());

            $this->display();     
//        if(empty($_POST['sea'])){
//            $m = M('fenli');      
//            $where = "zhuangtai=1";
//            $count = $m->where($where)->count();
//            $p = getpage($count,12);
//            $list = $m->where($where)->limit($p->firstRow, $p->listRows)->select();
//            $this->assign('ren', $list);
//            $this->assign('show', $p->show());
//            $this->display();
//        }else{
//            $value = $_POST['sea'];
//            if($value != ""){
//                $m = M('fenli');
//                $cha['tel'] = array("LIKE","%$value%");;
//                $cha['name'] = array("LIKE","%$value%");;
//                $cha[_logic]="or";
//                $arr = $m->where($cha)->select();
//                foreach($arr as $value){
//                    if($value['zhuangtai'] == "1"){
//                        $a[] = $value;
//                    }
//                }
////                dump($arr);
//                $this->assign('ren', $a);
//                $this->display();
//            }
//        }
    }
    public function fenlijin(){
        $sql = M("fenli");
        $id = $_GET['id'];
        $where['zhuangtai'] = 1;
        $sql->where("f_id=$id")->save($where);
        $arr = $sql->where("f_id=$id")->select();
        $m = M("mail");
        $data['accept_id'] = $arr[0]['tel'];
        $data['send_id'] = $_COOKIE['AdminName'];
        $data['title'] = "分利发放";
        $data['content'] = $arr[0]['name']."您好，您签约的".$arr[0]['chanpin']."商品，第".$arr[0]['qixian']."期已发放发放电子币为".$arr[0]['emoney']."积分为".$arr[0]['smoney']."管理费为".$arr[0]['guanlifei']."请您查收，发送时间为".$arr[0]['fenlitime'];
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d",$time);
        $data['time'] = $times;
        $data['status'] = 0;
        $data['type'] = 1;
        $m->add($data);
        $mysql = M("uaccount");
        $array = $mysql->select();
        foreach($array as $val){
            if($val['tel']==$arr[0]['tel']){
                $upt['emoney'] = $val['emoney'] + $arr[0]['emoney'];
                $upt['smoney'] = $val['smoney'] + $arr[0]['smoney'];
                $mysql->where("user_id={$val['user_id']}")->save($upt);
                $f = M("finance");
                $add['user'] = $arr[0]['tel'];
                $add['emoeny'] = $arr[0]['emoeny'];
                $add['smoeny'] = $arr[0]['smoeny'];
                date_default_timezone_set ("PRC");
                $time=time();
                $data=date("Y-m-d",$time);
                $add['date'] = $data;
                $add['type'] = "分利";
                $f->add($add);
            }
        }
//        dump($arr[0]['guanlifei']);
        $this->redirect("fenlijihua");
    }
    public function arr_fenlijin(){
        $sql = M("fenli");
        $id = $_POST['check'];
        $where['zhuangtai'] = 1;
        for($i=0;$i<count($id);$i++){
            $sql->where("f_id=$id[$i]")->save($where);
            $arr = $sql->where("f_id=$id[$i]")->find();
            $mysql = M("uaccount");
            $array = $mysql->where("tel='{$arr["tel"]}'")->find();
            $upt['emoney'] = $array['emoney'] + $arr["emoney"];
            $upt['smoney'] = $array['smoney'] + $arr["smoney"];
            $f = M("finance");
            $add['user'] = $arr['tel'];
            $add['emoeny'] = $arr['emoeny'];
            $add['smoeny'] = $arr['smoeny'];
            date_default_timezone_set ("PRC");
            $time=time();
            $data=date("Y-m-d",$time);
            $add['date'] = $data;
            $add['type'] = "分利";
            $f->add($add);
            $mysql->where("user_id={$array['user_id']}")->save($upt);
        }
        $this->redirect("fenlijihua");
    }
    public function weifafang(){
//        if(empty($_POST['sea'])){
            $sql = M("jiangli");

            $count = $sql->table("jiangli,uaccount")->where("zhuangtai=0 and tuijian=tel")->count();
            $p = getpage($count,12);
            $list = $sql->table("jiangli,uaccount")->where("zhuangtai=0 and tuijian=tel")->limit($p->firstRow, $p->listRows)->order("id desc")->select();
    //-------------------------------------------        
//            like '%%';
            if(!empty($_POST['sea'])){
                $value=$_POST['sea'];
                $count = $sql->table("jiangli,uaccount")->where("zhuangtai=0 and tuijian=tel and (jiedian like '%$value%' or zizhanghu like '%$value%')")->count();
                $p = getpage($count,12);
                $list = $sql->table("jiangli,uaccount")->order('issue_date')->where("zhuangtai=0 and tuijian=tel and (jiedian like '%$value%' or zizhanghu like '%$value%')")->limit($p->firstRow, $p->listRows)->select();    
//                dump($list);
             }     
   //------------------来自神的修改--------------          
             
            $m = M("uaccount");
            $array = $m->select();
            foreach($array as $val){
                for($i=0;$i<count($list);$i++){
                    if($list[$i]['name']==$val['tel']){
                        $list[$i]['real_name2'] = $val['real_name'];
                    }
                }           
            }
            $this->assign("ren",$list);
//            dump($list);
            $this->assign('show', $p->show());
            $this->display();
//        }else{
//            $value = $_POST['sea'];
//            if($value != ""){
//                $sql = M("jiangli");
//                $cha['tuijian'] = array("LIKE","%$value%");
//                $arr = $sql->where($cha)->select();
//                foreach($arr as $val){
//                    if($val['zhuangtai']=="0"){
//                        $a[] = $val;
//                    }
//                }
//                $m = M("uaccount");
//                $array = $m->select();
//                foreach($array as $val){
//                    for($i=0;$i<count($a);$i++){
////                        if($a[$i]['name']==$val['tel']){
////                            $a[$i]['real_name2'] = $val['real_name'];
////                        }
//                        if($a[$i]['tuijian']==$val['tel']){
//                            $a[$i]['real_name'] = $val['real_name'];
//                        }
//                    }
//                }
//                $this->assign("ren",$a);
//                $this->display();
//            }
//        }
        
    }
    public function yifafang(){
           $sql = M("jiangli");      
            if(!empty($_GET['tel'])){
                $value=$_GET['tel'];
                $count = $sql->table("jiangli,uaccount")->where("zhuangtai=1 and tuijian=tel and (jiedian like '%$value%' or zizhanghu like '%$value%')")->count();
                $c = getpage($count,12);
                $list = $sql->table("jiangli,uaccount")->order('issue_date')->where("zhuangtai=1 and tuijian=tel and (jiedian like '%$value%' or zizhanghu like '%$value%')")->limit($c->firstRow, $c->listRows)->select();   
                $m = M("uaccount");
                $array = $m->select();
                foreach($array as $val){
                    for($i=0;$i<count($list);$i++){
                        if($list[$i]['name']==$val['tel']){
                            $list[$i]['real_name2'] = $val['real_name'];
                        }
                    }
                }
//                $_SESSION['cunzhi'] = 1;
                $this->assign("ren",$list);
                $this->assign('show', $c->show());
                
             }else{
            $count = $sql->join("left join uaccount on jiangli.tuijian= uaccount.tel")->where("zhuangtai=1")->count();
            $p = getpage($count,12);
            $list = $sql->join("left join uaccount on jiangli.tuijian= uaccount.tel")->order("issue_date desc")->where("zhuangtai=1")->limit($p->firstRow, $p->listRows)->select();
                 $m = M("uaccount");
                $array = $m->select();
                foreach($array as $val){
                    for($i=0;$i<count($list);$i++){
                        if($list[$i]['name']==$val['tel']){
                            $list[$i]['real_name2'] = $val['real_name'];
                        }
                    }
                }               
//                $_SESSION['cunzhi'] = null;
                $this->assign("ren",$list);
                $this->assign('show', $p->show());
             }
            $this->display();
    }
    public function jianglifafang(){
        $sql = M("jiangli");
        $id = $_GET['id'];
        $jiang = $_GET['jiang'];
        $user = $_GET['tui'];
        date_default_timezone_set ("PRC");
        $time=time();
        $data=date("Y-m-d H:i:s",$time);
        $upt['time'] = $data;
        $upt['zhuangtai'] = 1;
        $sql->where("id=$id")->save($upt);
        $jl = $sql->where("id='$id'")->find();          //查询这条奖励记录
        $m = M("mail");
        $user_name = M("uaccount");
        $tjname = $user_name->where("tel='{$jl['tuijian']}'")->field("real_name")->find();   //推荐人名字
        $syname = $user_name->where("tel='{$jl['name']}'")->field("real_name")->find();   //受邀请的人
        $datw['accept_id'] = $jl['tuijian'];
        $datw['send_id'] = $_COOKIE['AdminName'];
        $datw['title'] = "推荐奖发放";
        $datw['content'] = $tjname['real_name']."您好，".$syname['real_name']."在签约".$jl['zizhi']."商品时"."填写了您为推荐人，所以给您发放".$jl['jiangli']."奖励，请您查收，发送时间为".$jl['time'];
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d",$time);
        $datw['time'] = $times;
        $datw['status'] = 0;
        $datw['type'] = 1;
        $m->add($datw);
        $mysql = M("uaccount");
        $arr = $mysql->select();
        foreach($arr as $val){
            if($user == $val['tel']){
                $where['emoney'] = $val['emoney'] +$jiang;
                $mysql->where("user_id={$val['user_id']}")->save($where);
                $f = M("finance");
                $add['user'] = $tjname['tel'];
                $add['emoeny'] = $jiang;
                $add['smoeny'] = 0;
                date_default_timezone_set ("PRC");
                $time=time();
                $data=date("Y-m-d",$time);
                $add['date'] = $data;
                $add['type'] = "推荐奖";
                $f->add($add);
            }
        }
        $this->redirect("weifafang");
    }
//    public function arrfafang(){
//        $id = $_POST['check'];
////        $tuijian = $_POST['tuijian'];
//
////        $jiangli = $_POST['jiangli'];
//        
//        $sql = M("jiangli");
//        date_default_timezone_set ("PRC");
//        $time=time();
//        $data=date("Y-m-d H:i:s",$time);
//        $upt['time'] = $data;
//        $upt['zhuangtai'] = 1;
//        for($i=0;$i<count($id);$i++){
//            $sql->where("id={$id[$i]}")->save($upt);
//        }
//        $mysql = M("uaccount");
//         
//        for($i=0;$i<count($id);$i++){
//           $tuijian= $sql->where("id={$id[$i]}")->find();
//           
//           $arr = $mysql->where("tel='{$tuijian["jiangli"]}'")->find();
//           $where['emoney'] = $arr['emoney'] + $tuijian["emoney"];
//           $mysql->where("user_id={$arr['user_id']}")->save($where);
//                    echo $mysql->getLastSql();
////                }
//            }
////        }
//        $this->redirect("weifafang");
//    }
    public function arrfafang(){
        $id = $_POST['check'];
//        $tuijian = $_POST['tuijian'];

//        $jiangli = $_POST['jiangli'];
        
        $sql = M("jiangli");
        date_default_timezone_set ("PRC");
        $time=time();
        $data=date("Y-m-d H:i:s",$time);
        $upt['time'] = $data;
        $upt['zhuangtai'] = 1;
        for($i=0;$i<count($id);$i++){
            $sql->where("id={$id[$i]}")->save($upt);
        }
        $mysql = M("uaccount");
         
        for($i=0;$i<count($id);$i++){
           $tuijian= $sql->where("id={$id[$i]}")->find();

           $arr = $mysql->where("tel='{$tuijian["tuijian"]}'")->find();

           $where['emoney'] = $arr['emoney'] + $tuijian['jiangli'];
           $f = M("finance");
                $add['user'] = $tuijian["tuijian"];
                $add['emoeny'] = $tuijian['jiangli'];
                $add['smoeny'] = 0;
                date_default_timezone_set ("PRC");
                $time=time();
                $data=date("Y-m-d",$time);
                $add['date'] = $data;
                $add['type'] = "推荐奖";
                $f->add($add);
           $mysql->where("user_id={$arr['user_id']}")->save($where);
                    echo $mysql->getLastSql();

            }

        $this->redirect("weifafang");
    }
    public function zuotongji(){
        $sql = M("uaccount");
        $count = $sql->count();
        $p = getpage($count,12);
        $arr = $sql->limit($p->firstRow, $p->listRows)->select();
        $this->assign("zhang",$arr);
        $this->assign('show', $p->show());
        $m = M("box");
        $array = $m->select();
        $this->assign("time",$array);
        $this->display();
    }
    public function youtongji(){
        $tel = $_GET['tel'];
        $sql = M("tongji");
        if($_GET['tel']==1){
            $arr = $sql->select();
        }else{
            $arr = $sql->where("name=$tel")->select();
        }
        $this->assign("ren",$arr);
        $m = M("box");
        $array = $m->select();
        $this->assign("time",$array);
        $this->display();
    }
    //新统计列表
    public function team_elist(){
        $sql = M("tongji_fafang");
        $arr = $sql->order("fafang_time asc,tongji_date asc,emoney desc")->select();
        $m = M("uaccount");
        $a = $m->select();
        for($i=0;$i<count($arr);$i++){
            foreach($a as $val){
                if($arr[$i]['tel']==$val['tel']){
                    $arr[$i]['real_name'] = $val['real_name'];
                }
            }
        }
        $array=array();
        foreach($arr as $k=>$v){
            if(!isset($item[$v['tel']])){
                $array[$v['tel']][]=$v;
            }else{
                $array[$v['tel']][]=$v;
            }
        }
//        dump($array);
        $this->assign("arr",$array);
        $this->display();
    }
    public function FetchRepeatMemberInArray($array) { 
    // 获取去掉重复数据的数组 
    $unique_arr = array_unique ( $array ); 
    // 获取重复数据的数组 
    $repeat_arr = array_diff_assoc ( $array, $unique_arr ); 
    return $repeat_arr; 
} 
    public function quanbu(){
        $sql = M("tongji");
        $arr = $sql->table("ucredentials,tongji")->where("ucredentials.zizhanghu=tongji.zizhanghu")->order("tongji.time desc,ucredentials.reward_use desc")->select();
//        dump($arr);
        $this->assign("ren",$arr);
        $m = M("box");
        $array = $m->select();
        $this->assign("time",$array);
        $this->display();  
    }
    
    public function quanbu_fafang(){
        $m=M("tongji_fafang");
        $arr=$m->where("zizhanghu='{$_GET["zizhanghu"]}'")->select();
        $this->assign("ren",$arr);
        $this->display();  
    }
    
    //来自神的修改
    public function fafang_dai(){
        $m=M("tongji_fafang");
        $arr=$m->table("tongji_fafang,ucredentials")->where("tongji_fafang.status=0 and ucredentials.zizhanghu=tongji_fafang.zizhanghu")->field("tongji_fafang.*,ucredentials.real_name,ucredentials.dengji,ucredentials.reward_use")->select();
//        dump($arr);
        foreach ($arr as $key=>$val){
            $time=explode("-", $val["fafang_time"]);
            $time2=$time[0]."-".$time[1];
            if($time2==date("Y-m",time())){
                $arr[$key]["fafa"]="ok";
            }else if($time[0]<date("Y",time())){
                $arr[$key]['fafa']="ok";
            }
        }
        $sql = M("uaccount");
        $arrau = $sql->select();
        foreach($arrau as $val){
            for($i=0;$i<count($arr);$i++){
                if($arr[$i]['tel']==$val['tel']){
                    $arr[$i]['real_name'] = $val['real_name'];
                }
            }
        }
//        dump($arr);
        $this->assign("ren",$arr);
        $this->display();  
    }
    public function fafang_yi(){
        $m=M("tongji_fafang");
        $arr=$m->table("tongji_fafang,ucredentials")->where("tongji_fafang.status=1 and ucredentials.zizhanghu=tongji_fafang.zizhanghu")->field("tongji_fafang.*,ucredentials.real_name,ucredentials.dengji,ucredentials.reward_use")->select();
        $this->assign("ren",$arr);
        $this->display();   
    }
    
    
    
    
    public function box(){
        $sql = M("box");
        $arr = $sql->select();
        $m = M("tongji");
        $array = $m->select();
        date_default_timezone_set ("PRC");
        $time=time();
        $data=date("Y-m-d",$time);
        foreach($array as $val){
            if($data>$val['time']){
                $upt['zhuangtai'] = "off";
                $sql->where("id=1")->save($upt);
            }
        }
        echo json_encode($arr);
    }
    public function login(){
        $this->display();
    }
//    public function tongji_ri(){
//            $sql = M("ucredentials");
//            $m = M("uaccount");
//            $n = $m->select();
//            $arr = $sql->where("status=1")->select();
//            $dengji = $sql->where("status=1")->select();
//            for($i=0;$i<count($arr);$i++){
//                foreach($n as $z){
//                    if($z['tel']==$arr[$i]['tel']){
//                        $arr[$i]['real_name'] = $z['real_name'];
//                    }
//                }
//            }
//            $flag=array();
//            $score=array();
//            $jiangli = array();
//            foreach($arr as $val){
//                $array[]= $sql->where("tid = {$val['crdentials_id']}")->select();
//            }
//                for($i=0;$i<count($array);$i++){
//                    $pai[] = $array[$i];
//                    $zong[] = $sql->where("crdentials_id={$array[$i][0]['tid']}")->find();
//                    foreach($array[$i] as $arr2){
//                        $flag[$i][]=$arr2;
//                    }
//                    foreach($flag[$i] as $k=>$v){
//                        $ids[$i][$k]=$v['yingyee'];    
//                    } 
//                    array_multisort($ids[$i],SORT_DESC,$pai[$i]);
//                    if(count($pai[$i])==1){
//                        $qian[$i] = 0;
//                    }else{
//                        $qian[$i] = $zong[$i]['yingyee'] - $pai[$i][0]['yingyee'];
//                    }
//                    if($qian[$i]>=100000){ 
//                        if($dengji[$i]['dengji']==0){
//                            $dengji[$i]['dengji'] = 1;
//                            $jiangli[$i] = $jiangli[$i] + 10000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=250000){
//                        if($dengji[$i]['dengji']==1){
//                            $dengji[$i]['dengji'] = 2;
//                            $jiangli[$i] = $jiangli[$i] + 20000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=500000){
//                        if($dengji[$i]['dengji']==2){
//                            $dengji[$i]['dengji'] = 3;
//                            $jiangli[$i] = $jiangli[$i] + 20000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=750000){
//                        if($dengji[$i]['dengji']==3){
//                            $dengji[$i]['dengji'] = 4;
//                            $jiangli[$i] = $jiangli[$i] + 50000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=1000000){
//                        if($dengji[$i]['dengji']==4){
//                            $dengji[$i]['dengji'] = 5;
//                            $jiangli[$i] = $jiangli[$i] + 50000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=1300000){
//                        if($dengji[$i]['dengji']==5){
//                            $dengji[$i]['dengji'] = 6;
//                            $jiangli[$i] = $jiangli[$i] + 50000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=1600000){
//                        if($dengji[$i]['dengji']==6){
//                            $dengji[$i]['dengji'] = 7;
//                            $jiangli[$i] = $jiangli[$i] + 50000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=2000000){
//                       if($dengji[$i]['dengji']==7){
//                            $dengji[$i]['dengji'] = 8;
//                            $jiangli[$i] = $jiangli[$i] + 50000;
//                            $xiugai['dengji'] = 1;
//                            $m->where("tel={$arr[$i]['tel']}")->save($xiugai);
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=3000000){
//                        if($dengji[$i]['dengji']==8){
//                            $dengji[$i]['dengji'] = 9;
//                            $jiangli[$i] = $jiangli[$i] + 500000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=5000000){
//                        if($dengji[$i]['dengji']==9){
//                            $dengji[$i]['dengji'] = 10;
//                            $jiangli[$i] = $jiangli[$i] + 1000000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=10000000){
//                        if($dengji[$i]['dengji']==10){
//                            $dengji[$i]['dengji'] = 11;
//                            $jiangli[$i] = $jiangli[$i] + 2000000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=20000000){
//                        if($dengji[$i]['dengji']==11){
//                            $dengji[$i]['dengji'] = 12;
//                            $jiangli[$i] = $jiangli[$i] + 2000000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=30000000){
//                        if($dengji[$i]['dengji']==12){
//                            $dengji[$i]['dengji'] = 13;
//                            $jiangli[$i] = $jiangli[$i] + 2000000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=40000000){
//                        if($dengji[$i]['dengji']==13){
//                            $dengji[$i]['dengji'] = 14;
//                            $jiangli[$i] = $jiangli[$i] + 2000000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=50000000){
//                        if($dengji[$i]['dengji']==14){
//                            $dengji[$i]['dengji'] = 15;
//                            $jiangli[$i] = $jiangli[$i] + 2000000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    $mysql = M("tongji");
//                    $time=time();
//                    $data=date("Y-m-d",$time);
//                    $where['time'] = $data;
//                    $where['yeji'] = $qian[$i];
//                    $where['name'] = $arr[$i]['tel'];
//                    $where['user'] = $arr[$i]['real_name'];
//                    $where['yingyee'] = $arr[$i]['yingyee'];
//                    $where['jiangli'] = $jiangli[$i];
//                    $mysql->add($where);
//                }
//            $mysql = M("box");
//            $add['zhuangtai'] = $data;
//            $mysql->add($add);
//            $this->redirect("quanbu");
//    }
    
    //段立波编写2016-11-9
      public function tongji_ri(){
          //资质表
//          dump(1);
            $sql = M("ucredentials");
            $m = M("uaccount");
            //查询用户表
            $n = $m->select();
            //查询已审核的资质（子账户）
           // $arr = $sql->where("status=1")->select();
           // $dengji = $arr;//$sql->where("status=1")->select();
//            for($i=0;$i<count($arr);$i++){
//                foreach($n as $z){
//                    if($z['tel']==$arr[$i]['tel']){
//                        $arr[$i]['real_name'] = $z['real_name'];
//                    }
//                }
//            }
            ///调用资质视图数据
            $vcredentials=D("vcredentials");
            $newCredentials = $vcredentials->where("status=1")->select();
            $dengji = $newCredentials;
            $flag=array();
            $score=array();
            $jiangli = array();
//                   dump($newCredentials);
            foreach($newCredentials as $val){
                //查询出该会员所推荐的子账户
                $array[]= $sql->where("tid = {$val['crdentials_id']}")->select();
                             
                //$array[]  保存着该资质所推荐的所有资质  N条数据
            }
                for($i=0;$i<count($array);$i++){
                    //获取该资质所推荐的资质
                    $pai[] = $array[$i];                   
                    //获取上一级的资质信息

                    $zong[] = $sql->where("crdentials_id={$array[$i][0]['tid']}")->find();
                    foreach($array[$i] as $arr2){
                        $flag[$i][]=$arr2;
                    }
                    foreach($flag[$i] as $k=>$v){
                        $ids[$i][$k]=$v['yingyee'];    
                    } 
                    array_multisort($ids[$i],SORT_DESC,$pai[$i]);
                 
                    if(count($pai[$i])==1){
                        $qian[$i] = 0;
                    }else{
//                        $qian[$i] = $zong[$i]['yingyee'];
                          $qian[$i] = $zong[$i]['yingyee']-$pai[$i][0]['yingyee'];
                    }
                    //生成统计表数据

                    $newjiang= $this->GetJianglLi($dengji[$i]['dengji'],$qian[$i]);
                    $save["dengji"]=$newjiang[0];
                    $save["reward_use"]=$zong[$i]['reward_use']+$newjiang[1];
                    $save["crdentials_id"]=$newCredentials[$i]['crdentials_id'];
                    $sql->save($save);  
                      

                  
                    $this->FaFangJiangli($newCredentials[$i]['zizhanghu'],$newCredentials[$i]['tel'],$newjiang[1],$newjiang[0]);
                    

                    $mysql = M("tongji");
                    $time=time();
                    $data=date("Y-m-d",$time);
                    $where['time'] = $data;
                    $where['yeji'] = $qian[$i];
                    $where['zizhanghu'] = $newCredentials[$i]['zizhanghu'];
                    $where['name'] = $newCredentials[$i]['tel']; 
                    $where['user'] = $newCredentials[$i]['real_name'];
                    $where['yingyee'] = $newCredentials[$i]['yingyee'];
                    $where['jiangli'] = $newjiang[1];
                    $mysql->add($where);

                }
            $mysql = M("box");
            $add['zhuangtai'] = $data;
            $mysql->add($add);
            $this->redirect("team_elist");
    }
//    public function FaFangJiangli($zizhanghu,$tel,$total,$newdengji)
//    {
//   
//        if($total>0){
//        date_default_timezone_set ("PRC");
//        $tongji_fafang=M("tongji_fafang");
//        $time=$tongji_fafang->where("tel=$tel")->order("distribute_id desc")->field("fafang_time")->find(); 
//        if($newdengji>=9)
//        {    
//            $sflag=false;
//            $add["zizhanghu"]=$zizhanghu;
//            $add["tel"]=$tel;
//            $add["amount"]=$total;
//            $total_xiaofei=0.1*$total;//  扣除手续费
//            $total=0.9*$total;
//            $add["guanlifei"]=$total_xiaofei;  
//            $emoney=0.7*$total;        
//            $add["tongji_date"]=date("Y-m-d",time());          
//            $sflag=false;
//            $limit=1;
//            $s=1;
//              while ($emoney>0){             
//                    if ($emoney>200000){
//                          $add["emoney"]=200000;                       
//                    }
//                    else{
//                          $add["emoney"]=$emoney;  
//                    }
//                        if($sflag==false){
//                              $add["smoney"]=0.3*$total;
//                              $add["guanlifei"]=$total_xiaofei;  
//                              $add["reward_fafang"]=$this->reward_fafang($total);
//                              $sflag=true;
//                          } 
//                          else{
//                               $add["reward_fafang"]="--";
//                               $add["guanlifei"]=0;
//                               $add["smoney"]=0;
//                          } 
//                           $add["limit"]=$s;  
//                  if(!empty($time["fafang_time"])&&$time["fafang_time"]!="0000-00-00"){
//                    $add["fafang_time"]=date("Y-m-d", strtotime("+$limit months", strtotime($time["fafang_time"])));
//                  }else{
//                    $limit=$limit-1;
//                    $add["fafang_time"]=date("Y-m",time());
//                    $time["fafang_time"]=$add["fafang_time"]."-25";
//                    $add["fafang_time"]=date("Y-m-d", strtotime("+$limit months", strtotime($time["fafang_time"])));                   
//                  }
//                  $emoney-=200000;
//                  $limit++;
//                  $s++;
//                  $tongji_fafang->add($add);
//            }
//            
//        }else{                        
//            $add["zizhanghu"]=$zizhanghu;
//            $add["tel"]=$tel;
//            $add["amount"]=$total;
//            $add["guanlifei"]=0.1*$total;  
//            $add["emoney"]=0.9*$total;
//            $emoney=0.9*$total;
//            $add["smoney"]=0;
//            $add["tongji_date"]=date("Y-m-d"); 
//            $sflag=false;
//            $s=1;
//            $limit=1;
//              while ($emoney>0)
//            {
//                  if ($emoney>50000){
//                         $add["emoney"]=50000;                       
//                  }
//                  else{
//                        $add["emoney"]=$emoney;  
//                  }
//                  if($sflag==false){
//                        $add["reward_fafang"]=$this->reward_fafang($total);
//                        $add["guanlifei"]=0.1*$total;  
//                        $sflag=true;
//                   } 
//                    else{
//                         $add["reward_fafang"]="--";
//                         $add["guanlifei"]=0;
//                         $add["smoney"]=0;
//                    }
//                     $add["limit"]=$s;  
//                    if(!empty($time["fafang_time"])&&$time["fafang_time"]!="0000-00-00"){
//                    $add["fafang_time"]=date("Y-m-d", strtotime("+$limit months", strtotime($time["fafang_time"])));                 }else{
//                    $limit=$limit-1;
//                    $add["fafang_time"]=date("Y-m",time());
//                    $time["fafang_time"]=$add["fafang_time"]."-25";
//                    $add["fafang_time"]=date("Y-m-d", strtotime("+$limit months", strtotime($time["fafang_time"])));
//                  }
//                  $emoney-=50000;
//                  $limit++;
//                  $s++;
//                 $tongji_fafang->add($add);
//            }
//       }
//      }
//    }
    
    public function textawdawd(){
             $time=$_GET["time"];
             $m=M("fenli");
                $uaccount=M("uaccount");
                          
             $count=$m->where("fenlitime='2016-12-08'")->count();
             $arr=$m->where("fenlitime='2016-12-08'")->order("tel")->field("tel,name,sum(emoney) as emoney,sum(smoney) as smoney")->group("tel")->select();
             foreach($arr as $key=>$val)
             {
                 $array=$uaccount->where("tel={$val["tel"]}")->find();
                 $arr[$key]["emoney"]=$array["emoney"]+$val["emoney"];
                 $arr[$key]["smoney"]=$array["smoney"]+$val["smoney"];
              
              }
              dump($count);
              dump($arr);
            
        
      }
      
    
    
        
    
    
    
        public function FaFangJiangli($zizhanghu,$tel,$total,$newdengji)
//        public function FaFangJiangli()
    {     
//            $zizhanghu = "18649004959-1";
//            $tel = 18649004959;
//            $total = 1000000;
//            $newdengji =  11;
        if($total>0){
        date_default_timezone_set ("PRC");
          $tongji_fafang=M("tongji_fafang");
        $time=$tongji_fafang->where("tel=$tel")->order("distribute_id desc")->field("fafang_time")->find();
            if($newdengji>=9){          
                $add["zizhanghu"]=$zizhanghu;
                $add["tel"]=$tel;
                $add["amount"]=$total;    
                $add["tongji_date"]=date("Y-m-d");          
                $sflag=false;
                $s=1;
                 $limit=1;
                    for($i=0;$i<($total/200000);$i++){
                        $add["emoney"]=sprintf("%.2f",0.63*$total/ceil(($total/200000)));   
                        $add["guanlifei"]=sprintf("%.2f",0.1*$total/ceil(($total/200000)));   
                            if($sflag==false){
                                $sflag=true;
                                $add["smoney"]=sprintf("%.2f",0.27*$total);;   
                            }else{
                                $add["smoney"]=0; 
                            }
                             $add["limit"]=$s; 
                              if(!empty($time["fafang_time"])&&$time["fafang_time"]!="0000-00-00"){
                                $add["fafang_time"]=date("Y-m-d", strtotime("+$limit months", strtotime($time["fafang_time"])));                    
                                
                              }else{
                                  //不明所以
//                                $limit=$limit-1;
                                $add["fafang_time"]=date("Y-m",time());
                                $time["fafang_time"]=$add["fafang_time"]."-25";
                                $add["fafang_time"]=date("Y-m-d", strtotime("+$limit months", strtotime($time["fafang_time"])));
                              }
                            $distribute_id[]=$tongji_fafang->add($add); 
                              $s++;
                              $limit++;
                    }
                    $save["reward_fafang"]=$this->reward_fafang($total);
                    $save["distribute_id"]=end($distribute_id);    
                    $tongji_fafang->save($save);    
            }else{                        
                $add["zizhanghu"]=$zizhanghu;
                $add["tel"]=$tel;
                $add["amount"]=$total;
                $add["smoney"]=0; 
                $add["tongji_date"]=date("Y-m-d"); 
                $add['tongji_yeji'] = $total;//统计个人业绩
                 $s=1;
                 $limit=1;
                    for($i=0;$i<($total/50000);$i++){
                        $add["emoney"]=sprintf("%.2f", 0.9*$total/ceil(($total/50000)));   
                        $add["guanlifei"]=sprintf("%.2f", 0.1*$total/ceil(($total/50000)));  
                      
//            
                         $add["limit"]=$s;  
                          if(!empty($time["fafang_time"])&&$time["fafang_time"]!="0000-00-00"){
                                $add["fafang_time"]=date("Y-m-d", strtotime("+$limit months", strtotime($time["fafang_time"])));                  
                            }else{
//                                $limit=$limit-1;
                                $add["fafang_time"]=date("Y-m",time());
                                $time["fafang_time"]=$add["fafang_time"]."-25";
                                $add["fafang_time"]=date("Y-m-d", strtotime("+$limit months", strtotime($time["fafang_time"])));
                            }
//                                dump($add);
                              $distribute_id[]=$tongji_fafang->add($add); 
                              $s++;
                              $limit++;
                    }
                    $save["reward_fafang"]=$this->reward_fafang($total);
                    $save["distribute_id"]=end($distribute_id);  

                    $tongji_fafang->save($save);    
            }
            dump($limit);
        }
    } 
    
    
    public function reward_fafang($total){        
        if($total>=5800000){
            $arr="50万住房一套";      
            return $arr;
        }
        if($total>=1800000){
            $arr="10万办公车一部";      
            return $arr;
        }
        if($total>=300000){
            $arr="国外旅游一次";      
            return $arr;
        }
        if($total>=150000){
            $arr="国内旅游一次";      
            return $arr;
        }        
        
        return $arr;
    }
            
   
   
       // tongji_fafang
    
    ///根据当前的统计金额及级别，判断奖励的金额
//    public function GetJianglLi($Curr_Dengji,$Money)
//    {
//             ///修改资质等级
//        $arr[]=array();
//        $arr[0]=0; //等级
//        $arr[1]=0;  //奖励的金额
//        
//          if($Money>=40000000 && $Curr_Dengji<14)
//        {                      
//            $arr[0]=14;
//            $arr[1]=2000000;          
//            return $arr;
//        }
//        if($Money>=30000000 && $Curr_Dengji<13)
//        {     
//              $arr[0]=13;
//              $arr[1]= 2000000;
//              return $arr;
//        }
//        if($Money>=20000000 && $Curr_Dengji<12)
//        {     
//              $arr[0]=12;
//              $arr[1]= 2000000;
//              return $arr;
//        }  
//        if($Money>=10000000 && $Curr_Dengji<11)
//        {     
//              $arr[0]=11;
//              $arr[1]= 2000000;
//              return $arr;
//        }  
//        if($Money>=5000000 && $Curr_Dengji<10)
//        {     
//              $arr[0]=10;
//              $arr[1]= 1000000;
//              return $arr;
//        }  
//        if($Money>=3000000 && $Curr_Dengji<9)
//        {    
//              $arr[0]=9;
//              $arr[1]= 500000;
//              return $arr;
//        }
//        if($Money>=2000000 && $Curr_Dengji<8)
//        {    
//              $arr[0]=8;
//              $arr[1]= 50000;
//              return $arr;
//        }
//        if($Money>=1600000 && $Curr_Dengji<7)
//        {    
//              $arr[0]=7;
//              $arr[1]= 50000;
//              return $arr;
//        } 
//        if($Money>=1300000 && $Curr_Dengji<6)
//        {    
//              $arr[0]=6;
//              $arr[1]= 50000;
//              return $arr;
//        } 
//        if($Money>=1000000 && $Curr_Dengji<5)
//        {    
//              $arr[0]=5;
//              $arr[1]= 50000;
//              return $arr;
//        } 
//        if($Money>=750000 && $Curr_Dengji<4)
//        {    
//              $arr[0]=4;
//              $arr[1]= 50000;
//              return $arr;
//        } 
//        if($Money>=500000 && $Curr_Dengji<3)
//        {    
//              $arr[0]=3;
//              $arr[1]= 20000;
//              return $arr;
//        } 
//        if($Money>=250000 && $Curr_Dengji<2)
//        {    
//              $arr[0]=2;
//              $arr[1]= 20000;
//              return $arr;
//        } 
//        if($Money>=100000 && $Curr_Dengji<1)
//        {    
//              $arr[0]=1;
//              $arr[1]= 10000;
//              return $arr;
//        } 
//                    
////        dump($arr);   
////        dump($Curr_Dengji);   
////        $arr;
//            return $arr;
//
//        
//    }
//    
        public function GetJianglLi($Curr_Dengji,$Money)
    {
             ///修改资质等级
        $arr[]=array();
        $arr[0]=0; //等级
        $arr[1]=0;  //奖励的金额
        if($Money>=100000 && $Curr_Dengji<1)
        {    
              $arr[0]=1;
              $arr[1]= 10000;
        } 
        if($Money>=250000 && $Curr_Dengji<2)
        {    
              $arr[0]=2;
              $arr[1]=$arr[1]+20000;

        } 
        if($Money>=500000 && $Curr_Dengji<3)
        {    
              $arr[0]=3;
              $arr[1]=$arr[1]+ 20000;
        }       
        if($Money>=750000 && $Curr_Dengji<4)
        {    
              $arr[0]=4;
              $arr[1]=$arr[1]+ 50000;

        }
         if($Money>=1000000 && $Curr_Dengji<5)
        {    
              $arr[0]=5;
              $arr[1]= $arr[1]+50000;

        } 
        if($Money>=1300000 && $Curr_Dengji<6)
        {    
              $arr[0]=6;
              $arr[1]= $arr[1]+50000;

        }
        if($Money>=1600000 && $Curr_Dengji<7)
        {    
              $arr[0]=7;
              $arr[1]=$arr[1]+ 50000;

        }
        if($Money>=2000000 && $Curr_Dengji<8)
        {    
              $arr[0]=8;
              $arr[1]= $arr[1]+50000;

        }
        if($Money>=3000000 && $Curr_Dengji<9)
        {    
              $arr[0]=9;
              $arr[1]= $arr[1]+500000;
        }
        if($Money>=5000000 && $Curr_Dengji<10)
        {     
              $arr[0]=10;
              $arr[1]=$arr[1]+ 1000000;

        } 
        if($Money>=10000000 && $Curr_Dengji<11)
        {     
              $arr[0]=11;
              $arr[1]=$arr[1]+ 2000000;

        } 
        if($Money>=20000000 && $Curr_Dengji<12)
        {     
              $arr[0]=12;
              $arr[1]= $arr[1]+2000000;
        }
         if($Money>=30000000 && $Curr_Dengji<13)
        {     
              $arr[0]=13;
              $arr[1]= $arr[1]+2000000;
        }
          if($Money>=40000000 && $Curr_Dengji<14)
        {                      
            $arr[0]=14;
            $arr[1]=$arr[1]+2000000;          
        }
          if($Money>=50000000 && $Curr_Dengji<15)
        {                      
            $arr[0]=15;
            $arr[1]=$arr[1]+2000000;          
        }
        if($arr[0]==0){
            $arr[0]=$Curr_Dengji;
            $arr[1]=0;
        }
            return $arr;

        
    }
//    
//    
//    
//    
    ///修改资质等级
    public function  UpdateCredentialsLevel($money,$currdengji,$jiangli)
    {
         //根据最新的数据变化等级
//                    if($qian[$i]>=100000){ 
//                        if($dengji[$i]['dengji']==0){
//                            $dengji[$i]['dengji'] = 1;
//                            $jiangli[$i] = $jiangli[$i] + 10000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=250000){
//                        if($dengji[$i]['dengji']==1){
//                            $dengji[$i]['dengji'] = 2;
//                            $jiangli[$i] = $jiangli[$i] + 20000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=500000){
//                        if($dengji[$i]['dengji']==2){
//                            $dengji[$i]['dengji'] = 3;
//                            $jiangli[$i] = $jiangli[$i] + 20000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=750000){
//                        if($dengji[$i]['dengji']==3){
//                            $dengji[$i]['dengji'] = 4;
//                            $jiangli[$i] = $jiangli[$i] + 50000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=1000000){
//                        if($dengji[$i]['dengji']==4){
//                            $dengji[$i]['dengji'] = 5;
//                            $jiangli[$i] = $jiangli[$i] + 50000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=1300000){
//                        if($dengji[$i]['dengji']==5){
//                            $dengji[$i]['dengji'] = 6;
//                            $jiangli[$i] = $jiangli[$i] + 50000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=1600000){
//                        if($dengji[$i]['dengji']==6){
//                            $dengji[$i]['dengji'] = 7;
//                            $jiangli[$i] = $jiangli[$i] + 50000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=2000000){
//                       if($dengji[$i]['dengji']==7){
//                            $dengji[$i]['dengji'] = 8;
//                            $jiangli[$i] = $jiangli[$i] + 50000;
//                            $xiugai['dengji'] = 1;
//                            $m->where("tel={$arr[$i]['tel']}")->save($xiugai);
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=3000000){
//                        if($dengji[$i]['dengji']==8){
//                            $dengji[$i]['dengji'] = 9;
//                            $jiangli[$i] = $jiangli[$i] + 500000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=5000000){
//                        if($dengji[$i]['dengji']==9){
//                            $dengji[$i]['dengji'] = 10;
//                            $jiangli[$i] = $jiangli[$i] + 1000000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=10000000){
//                        if($dengji[$i]['dengji']==10){
//                            $dengji[$i]['dengji'] = 11;
//                            $jiangli[$i] = $jiangli[$i] + 2000000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=20000000){
//                        if($dengji[$i]['dengji']==11){
//                            $dengji[$i]['dengji'] = 12;
//                            $jiangli[$i] = $jiangli[$i] + 2000000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=30000000){
//                        if($dengji[$i]['dengji']==12){
//                            $dengji[$i]['dengji'] = 13;
//                            $jiangli[$i] = $jiangli[$i] + 2000000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=40000000){
//                        if($dengji[$i]['dengji']==13){
//                            $dengji[$i]['dengji'] = 14;
//                            $jiangli[$i] = $jiangli[$i] + 2000000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
//                    if($qian[$i]>=50000000){
//                        if($dengji[$i]['dengji']==14){
//                            $dengji[$i]['dengji'] = 15;
//                            $jiangli[$i] = $jiangli[$i] + 2000000;
//                            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($dengji[$i]);
//                        }
//                    }else{
//                        $jiangli[$i] = $jiangli[$i] + 0;
//                    }
    }
    public function deltongji(){
        $time = $_POST['sel'];
        $sql = M("tongji");
        $m = M('box');
        $arr = $sql->select();
        foreach($arr as $val){
            if($val['time']==$time){
                $sql->where("id={$val['id']}")->delete();
            }
        }
        $array = $m->select();
        foreach($array as $value){
            if($value['zhuangtai']==$time){
                $m->where("id={$value['id']}")->delete();
            }
        }
        $this->redirect("quanbu");
    }
    public function E_bean(){
//        function Post($data, $target){
//                $url_info = parse_url($target);
//                $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
//                $httpheader .= "Host:" . $url_info['host'] . "\r\n";
//                $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
//                $httpheader .= "Content-Length:" . strlen($data) . "\r\n";
//                $httpheader .= "Connection:close\r\n\r\n";
//                $httpheader .= $data;
//                $fd = fsockopen($url_info['host'], 80);
//                fwrite($fd, $httpheader);
//                $gets = "";
//                while(!feof($fd)) {
//                    $gets .= fread($fd, 128);
//                }
//                fclose($fd);
//                if($gets != ''){
//                    $start = strpos($gets, '<?xml');
//                    if($start > 0) {
//                        $gets = substr($gets, $start);
//                    }        
//                }
//                return $gets;
//            }
//            $target = "http://60.205.168.151/index.php/Home/System/bean_upt";
//            $post_data =("tel=18649004959&bean=57");
        $name = $_GET['tel'];
        $sql = M("bean");
        $where['jilu'] = 5;
        $where['name'] = $name;
        date_default_timezone_set ("PRC");
        $time=time();
        $data=date("Y-m-d H:i:s",$time);
        $where['time'] = $data;
        $sql->add($where);
        echo 12321312312312312312;
//        header("location:http://www.baidu.com/tel/".$name."//");
    }
    public function bean_upt(){
        $tel = $_GET['tel'];
        $bean = $_GET['bean'];
        $sql = M("bean");
        $arr = $sql->select();
        foreach($arr as $val){
            if($tel==$val['name']){
                $array = $val;
            }
        }
        $where['jilu'] = $array['jilu'] + $bean;
        $sql->where("name={$tel}")->save($where); 
    }
    public function pl(){
        $sql = M("uaccount");
        $arr = $sql->select();
        for($i=0;$i<count($arr);$i++){
            $where['smoney'] = 2900;
            date_default_timezone_set ("PRC");
            $time=time();
            $data=date("Y-m-d H:i:s",$time);
            $sql->where("user_id={$arr[$i]['user_id']}")->save($where);
        }
//        dump($where);
    }
    public function zhuce(){
        $sql = M ("admin_register");
        $where['username'] = $_POST['username'];
        $where['name'] = $_POST['name'];
        $where['password'] = md5(md5($_POST['password']));
        date_default_timezone_set ("PRC");
        $time=time();
        $data=date("Y-m-d H:i:s",$time);
        $where['time'] = $data;
//        $where['quanxian'] = 1;
        $sql->add($where);
        $time2= time()+60*60*24*7;
        $name = $_POST['username'];
        cookie("AdminName","$name");
        $this->redirect("admin");
    }
    public function loginVerificationAjax(){
        $username = $_POST['user'];
        $password = md5(md5($_POST['pass']));
        $sql = M("admin_register");
        $arr = $sql->where("status!=1")->select();
        foreach ($arr as $val){
            if($username == $val['username']){
                if($password == $val['password']){
                    echo 1;
                }else{
                    echo 0;
                }
            }
        }
    }
    public function login_yanzheng(){
        if(!empty($_POST['username'])){
            $time2= time()+60*60*24*7;
            $name = $_POST['username'];
            cookie("AdminName","$name");
        }
        $this->redirect("admin");
    }
    public function loginUsernameAjax(){
        if(!empty($_POST['user'])){
            $sql = M ("admin_register");
            $arr = $sql->select();
            foreach ($arr as $val){
                if($_POST['user']==$val['username']){
                    echo 1;
                }
            }
        }
    }
    public function shoukuanguanli(){
        $sql = M("shoukuan");
        $arr = $sql->select();
        $this->assign("ren",$arr);
        $this->display();
    }
    public function uptshoukuan(){
        $id = $_GET['id'];
        $sql = M("shoukuan");
        $where['name'] = $_POST['name_upt'];
        $where['yinhangka'] = $_POST['ka_upt'];
        $sql->where("s_id=$id")->save($where);
        $ku = M("operation");
        $jilu['username'] = $_COOKIE['AdminName'];
        $jilu['details'] = "对收款银行卡进行修改操作";
        date_default_timezone_set ("PRC");
        $time5=time();
        $data5=date("Y-m-d H:i:s",$time5);
        $jilu['time'] = $data5;
        $ku->add($jilu); 
        $this->redirect("shoukuanguanli");
    }
    public function delshoukuan(){
        $id = $_GET['id'];
        $sql = M("shoukuan");
        $sql->where("s_id=$id")->delete();
        $ku = M("operation");
        $jilu['username'] = $_COOKIE['AdminName'];
        $jilu['details'] = "对收款银行卡进行删除操作";
        date_default_timezone_set ("PRC");
        $time5=time();
        $data5=date("Y-m-d H:i:s",$time5);
        $jilu['time'] = $data5;
        $ku->add($jilu); 
        $this->redirect("shoukuanguanli");
    }
    public function zizhispguanli(){
        $sql = M("vgoods");
        $arr = $sql->select();
        $this->assign("ren",$arr);
        $this->display();
    }
    public function uptchanpin(){
        $sql = M("vgoods");
        $where['goods_name'] = $_POST['name_upt'];
        $where['price'] = $_POST['ka_upt'];
        $id = $_GET['id'];
        $ku = M("operation");
        $jilu['username'] = $_COOKIE['AdminName'];
        $jilu['details'] = "对资质产品修改进行操作";
        date_default_timezone_set ("PRC");
        $time5=time();
        $data5=date("Y-m-d H:i:s",$time5);
        $jilu['time'] = $data5;
        $ku->add($jilu); 
        $sql->where("goods_id=$id")->save($where);
        $this->redirect("zizhispguanli");
    }
    public function uptheyue(){
        $sql = M("flagship");
        $id = $_GET['id'];
        $where['shop_name'] = $_POST['name_upt'];
        $where['address'] = $_POST['ka_upt'];
        $where['tel'] = $_POST['tel_upt'];
        $where['shop_boss'] = $_POST['boss_upt'];
        $where['shop_no'] = $_POST['hao_upt'];
        $sql->where("shop_id=$id")->save($where);
        $ku = M("operation");
        $jilu['username'] = $_COOKIE['AdminName'];
        $jilu['details'] = "对旗舰店进行修改操作";
        date_default_timezone_set ("PRC");
        $time5=time();
        $data5=date("Y-m-d H:i:s",$time5);
        $jilu['time'] = $data5;
        $ku->add($jilu); 
        $this->redirect("heyuedian");
    }
    
    
    
    public function addheyue(){
        $sql = M("flagship");
        $where['shop_name'] = $_POST['name'];
        $where['address'] = $_POST['address'];
        $where['tel'] = $_POST['tel'];
        $where['shop_no'] = $_POST['number'];      
        $sql->add($where);
        $this->redirect("heyuedian");
    }
    public function delheyue(){
        $sql = M("flagship");
        $id = $_GET['id'];
        $sql->where("shop_id=$id")->delete();
        $ku = M("operation");
        $jilu['username'] = $_COOKIE['AdminName'];
        $jilu['details'] = "对旗舰店进行删除操作";
        date_default_timezone_set ("PRC");
        $time5=time();
        $data5=date("Y-m-d H:i:s",$time5);
        $jilu['time'] = $data5;
        $ku->add($jilu); 
        $this->redirect("heyuedian");
    }
    //旗舰店详情
    public function shop_detail(){
        $m=M("flagship_earning");
        $flagship=M("flagship");
        $count =$m->where("vip=0")->count();
        $p = getpage($count,12);
        $arr=$m->order("earing_month desc")->where("vip=0")->limit($p->firstRow, $p->listRows)->select();
        foreach($arr as $key=>$val){

             $array=$flagship->where("shop_id='{$val["shop_id"]}'")->field("shop_name,admin_id")->find();

             $arr[$key]["shop_name"]=$array["shop_name"];
             $arr[$key]["admin_id"]=$array["admin_id"];


        }
//        dump($arr);
        $this->assign('show', $p->show());
        $this->assign("arr",$arr);
        $this->display();
    }
    //旗舰店统计
    public function shop_tongji(){
        $flagship=M("flagship");
        $ucredentials=M("ucredentials");
        $flagship_earning=M("flagship_earning");
        $arr=$flagship->select();
        foreach($arr as $key=>$val){
            $array=$ucredentials->where("shop_id={$val["shop_id"]} and status=1")->field("sum(goods_id) as volume")->find();
            $add["shop_id"]=$val["shop_id"];
            $add["volume"]=$array["volume"];
            if($array["volume"]<500000){
               $add["ratio"]=2;  
            }else{
               $add["ratio"]=4;   
            }
            $add["earing_month"]=date("Y-m",time());
            $add["created_time"]=date("Y-m-d H:i:s",time());
            $flagship_earning->add($add);           
        }
        $this->redirect("shop_detail");
    }
    //旗舰店发放
    public function shop_send(){
        $uaccount=M("uaccount");
        $flagship_earning=M("flagship_earning");
        $arr=$uaccount->where("user_id={$_GET["ucredentials_user_id"]}")->find();
        
        $flagship_e=$flagship_earning->where("earning_id={$_GET["earning_id"]}")->find();

        if($arr){
            $save_u["emoney"]=$arr["emoney"]+$flagship_e["volume"]*$flagship_e["ratio"]/100;
            $save_u["user_id"]=$arr["user_id"];
            $uaccount->save($save_u);    //给用户加钱

            $save_f["earning_id"]=$_GET["earning_id"];
            $save_f["status"]=2;
            $save_f["reward_time"]=date("Y-m-d H:i:s",time());
            $flagship_earning->save($save_f);         //发放修改
            
            $ku = M("operation");
            $jilu['username'] = $_COOKIE['AdminName'];
            $jilu['details'] = "对".$arr["real_name"]."进行收益发放，金额:".$flagship_e["volume"]*$flagship_e["ratio"]/100;
            date_default_timezone_set ("PRC");
            $jilu['time']=date("Y-m-d H:i:s",time());
            $ku->add($jilu);     //记录操作者
            $this->redirect("shop_detail");
        }
        else{
            echo "找不到该用户！";
            echo "<br>";
            $this->redirect('shop_detail', null, 2, '页面跳转中...');
           
        }
    }
    public function shop_delete(){
        $flagship_earning=M("flagship_earning");
        $where["earning_id"]=$_GET["earning_id"];
//        dump($where);
        $flagship_earning->where($where)->delete();
        $this->redirect("shop_detail");
    }
    
//--------------------------------------------------------------------------------    
    public function heyuedian(){
        $sql = M("flagship");
        $arr = $sql->join("left join uaccount on uaccount.user_id=flagship.admin_id")->field("flagship.*,uaccount.real_name,uaccount.tel")->select();
//        dump($arr);
        $this->assign("ren",$arr);
        $this->display();
    }
    public function heyuedian_U(){
        $sql = M("flagship");
        $arr = $sql->join("left join uaccount on uaccount.user_id=flagship.admin_id")->field("flagship.*,uaccount.real_name,uaccount.tel")->where("shop_id={$_GET["shop_id"]}")->find();
        
        $this->assign("arr",$arr);  
        
        $m=M("admin_register");
        $array=$m->where("id!={$arr["id"]}")->select();
        $this->assign("array",$array);        
        $this->display();
    }
    public function addheyuedian(){
//        $m=M("admin_register");
//        $arr=$m->select();
//        $this->assign("arr",$arr);
        $this->display();
    }   
    public function addheyuedian_ajax(){
        $m=M("uaccount");
        $value=$_POST["value"];
        $arr=$m->where("tel='$value'")->find();
        if($arr){
           echo json_encode($arr);
        }else{
            echo 1;
        }
        
    }
    
    
    
    public function add_heyue(){
        
        $sql = M("flagship");
        $where['shop_name'] = $_POST['name'];
        $where['address'] = $_POST['address'];
        $where['shop_no'] = $_POST['number'];
        
        
        $uaccount=M("uaccount");
        $arr=$uaccount->where("tel='{$_POST["admin_id"]}'")->find();
        $where['admin_id'] = $arr["user_id"];
          
        $where['created_date'] = date("Y-m-d H:i:s",time());
//        dump($where);
        $sql->add($where);

        $ku = M("operation");
        $jilu['username'] = $_COOKIE['AdminName'];
        $jilu['details'] = "对旗舰店进行新增操作";
        date_default_timezone_set ("PRC");
        $time5=time();
        $data5=date("Y-m-d H:i:s",$time5);
        $jilu['time'] = $data5;
        $ku->add($jilu); 
        
        $this->redirect("heyuedian");
    }
    
    public function heyuedian_uu(){
        $sql = M("flagship");
        $where['shop_name'] = $_POST['name'];
        $where['address'] = $_POST['address'];
        $where['shop_no'] = $_POST['number'];
        $uaccount=M("uaccount");
        $arr=$uaccount->where("tel='{$_POST["admin_id"]}'")->find();
        $where['admin_id'] = $arr["user_id"];
        $where['shop_id'] = $_POST["shop_id"];
        $sql->save($where);
        $this->redirect("heyuedian");
    }
    
    
    //---------------------旗舰店--------------------------------------------------
    public function sel_op(){
        $value = $_POST['val'];
        $user = $_POST['user'];
//        $value = "2016-10-14";
        $sql = M("tongji");
        $arr = $sql->select();
        foreach($arr as $val){
            if($user == $val['name']){
               if($val['time']==$value){
                    $array[] = $val;
                } 
            }
        }
        echo json_encode($array);
    }
    public function sel_op2(){
        $value = $_POST['val'];
        $sql = M("tongji");
        $arr = $sql->table("ucredentials,tongji")->where("ucredentials.zizhanghu=tongji.zizhanghu")->order("tongji.time desc,ucredentials.reward_use desc")->select();
        foreach($arr as $val){
            if($val['time']==$value){
                 $array[] = $val;
             } 
        }
        echo json_encode($array);
    }
//    public function zjiangli(){
//        $id = $_GET['id'];
//        $tel = $_GET['tel'];
//        $sql = M("tongji");
//        $where['status'] = 1;
//        date_default_timezone_set ("PRC");
//        $time=time();
//        $data=date("Y-m-d H:i:s",$time);
//        $where['f_time'] = $data;
//        $arr = $sql->where("id=$id")->find();
//        $sql->where("id=$id")->save($where);
//        $m = M("uaccount");
//        $array = $m->select();
//        foreach($array as $val){
//            if($val['tel']==$arr['name']){
//                $qian = $arr['jiangli'] * 0.1;
//                $upt['emoney'] = $val['emoney'] + $qian;
////                dump($upt);
//                $m->where("user_id={$val['user_id']}")->save($upt);
//            }
//        }
//        $this->redirect("quanbu");
//    }
    
    
     public function zjiangli(){
//      dump($_GET);
       $m=M("tongji_fafang");
       $arr=$m->where("distribute_id='{$_GET["distribute_id"]}'")->find();

       
       $save["distribute_time"]=date("Y-m-d H:i:s");
       $save["status"]=1;
       $save["fafang_user"]=$_COOKIE["AdminName"];
       $save["distribute_id"]=$_GET["distribute_id"];       
       $m->save($save);
                    
       $uaccount=M("uaccount");
       $uacco=$uaccount->where("tel='{$arr["tel"]}'")->find();
       
       $save_uacco["user_id"]=$uacco["user_id"];
       $save_uacco["emoney"]=$arr["emoney"]+$uacco["emoney"];
       $save_uacco["smoney"]=$arr["smoney"]+$uacco["smoney"];
       $f = M("finance");
                $add['user'] = $arr["tel"];
                $add['emoeny'] = $arr["emoney"];
                $add['smoeny'] = $arr["smoney"];
                date_default_timezone_set ("PRC");
                $time=time();
                $data=date("Y-m-d",$time);
                $add['date'] = $data;
                $add['type'] = "团队奖";
                $f->add($add);
       
       $uaccount->save($save_uacco);
//       $this->redirect("fafang_dai",array('zizhanghu'=>$arr["zizhanghu"]));
       $this->redirect("team_elist");
    }
    
    
    
    
    
    public function status_sel(){
        $sql = M("tongji");
        $id = $_POST['id'];
        $arr = $sql->where("id=$id")->find();
        if($arr['status']==1){
            echo 1;
        }
    }
    //改表用的
    public function xiuxiu(){
        $sql = M("ucredentials");
//        $sql = M("uaccount");
        $arr = $sql->select();
        for($i=0;$i<count($arr);$i++){
//            $upt['status'] = 0;
//            $upt['yingyee'] = 0;
//            $upt['emoney'] = 5000000;
            $upt['dengji'] = 0;
//            $upt['smoney'] = 0;
            $sql->where("crdentials_id={$arr[$i]['crdentials_id']}")->save($upt);
//            $sql->where("user_id={$arr[$i]['user_id']}")->save($upt);
        }
        $this->redirect("quanbu");
    }
    //修改
//    public function fenlixiu(){
//        $sql = M("fenli");
//        $arr = $sql->select();
//        $where['zhuangtai'] = 0;
//        for($i=0;$i<count($arr);$i++){
//            $sql->where("f_id={$arr[$i]['f_id']}")->save($where);
//        }
//    }
    public function qingling(){
        $sql = M("uaccount");
        $arr = $sql->select();
        for($i=0;$i<count($arr);$i++){
            $where['tixian'] = 0;
            $sql->where("user_id={$arr[$i]['user_id']}")->save($where);
        }
        $this->redirect("tixianguanli");
    }
    public function addrole(){
        if(!empty($_POST['role_name'])){
            $sql = M("role");
            $where['role_name'] = $_POST['role_name'];
            date_default_timezone_set ("PRC");
            $time=time();
            $data=date("Y-m-d H:i:s",$time);
            $where['time'] = $data;
            $sql->add($where);
            $ku = M("operation");
            $jilu['username'] = $_COOKIE['AdminName'];
            $jilu['details'] = "对权限角色进行新增操作";
            date_default_timezone_set ("PRC");
            $time5=time();
            $data5=date("Y-m-d H:i:s",$time5);
            $jilu['time'] = $data5;
            $ku->add($jilu); 
        }
        $this->redirect("role");
    }
    public function role(){
        $sql = M("role");
        $arr = $sql->select();
        $this->assign("ren",$arr);
        $this->display();
    }
    public function shenselect(){
        $sql = M("admin_register");
        $arr = $sql->select();
        foreach($arr as $val){
            if($val['username']==$_COOKIE['AdminName']){
                if($val['quanxian']==1){
                    echo 1;
                }
            }
        }
    }
    
    
    public function role_upt(){
        $sql = M("role");
        $id = $_POST['id'];
        $value = $_POST['value'];
        $where['role_name'] = $value;
        $sql->where("id=$id")->save($where);
        $ku = M("operation");
        $jilu['username'] = $_COOKIE['AdminName'];
        $jilu['details'] = "对权限角色进行修改操作";
        date_default_timezone_set ("PRC");
        $time5=time();
        $data5=date("Y-m-d H:i:s",$time5);
        $jilu['time'] = $data5;
        $ku->add($jilu); 
        echo $value;
    }
    public function quanxian(){
        $sql = M("admin_register");
        $arr = $sql->where("quanxian=0")->select();
        $this->assign("user",$arr);
        $sql = M("role");
        $arr = $sql->select();
        $this->assign("role",$arr);
        
        $admin_m=M("admin_module");
        
               
        $arr=$admin_m->select();
//        dump($arr);
        if(!empty($_GET["id"])){
            $admin_role_module=M("admin_role_module");
            $admin_role=$admin_role_module->where("role_id={$_GET["id"]}")->field("module_id")->select();
            foreach ($admin_role as $val){
                $v[]=$val["module_id"];
            }
//            dump($v);
            foreach ($arr as $key=>$value){
                   if(in_array($value["module_id"], $v)){
                       $arr[$key]["select"]=1;
                   }else{
                        $arr[$key]["select"]=0;
                   }

            }
        }
       
//        dump($arr);
        $this->assign("admin_m",$arr);
        $this->display();
    }
    public function addquanxian(){
        $sql = M("admin_role_module");
        $m=M("role");
        if(!empty($_POST["role_id"])){
            $r_add["role_name"]=$_POST["name"];
            $m->where("id={$_POST["role_id"]}")->data($r_add)->save();
            $sql->where("role_id={$_POST["role_id"]}")->delete();
            $role_id=$_POST["role_id"];
        }else{          
            $r_add["role_name"]=$_POST["name"];
            $role_id=$m->add($r_add);
        }
            $add["role_id"]=$role_id;
            $module_id=$_POST["check"];
     
        for($i=0;$i<count($module_id);$i++){
         
              $add["module_id"]=$module_id[$i];
              $sql->add($add);

        }
        $ku = M("operation");
        $jilu['username'] = $_COOKIE['AdminName'];
        $jilu['details'] = "对管理员".$_POST['username']."进行权限操作";
        date_default_timezone_set ("PRC");
        $time5=time();
        $data5=date("Y-m-d H:i:s",$time5);
        $jilu['time'] = $data5;
        $ku->add($jilu); 
        $this->redirect("role");
    }
    public function role_select(){
        $role_id=$_GET["id"];
        $admin_role_module=M("admin_role_module");
        $arr=$admin_role_module->where("role_id={$role_id}")->field("module_id")->select();
       
        foreach($arr as $val){
            $admin_module=M("admin_module");
            $array[]=$admin_module->where("module_id={$val["module_id"]}")->find();
        }
        $this->assign("admin_m",$array);
        $this->display();

    }
    public function quanxiansel(){
        $sql = M("admin_register");
        $arr = $sql->where("quanxian=0")->select();
        foreach($arr as $val){
            if($_COOKIE['AdminName']==$val['username']){
                $array = $val['quan'];
            }
        }
        $quanxian = explode(",",$array);
        array_pop($quanxian);
        echo json_encode($quanxian);
    }
    public function zui_quanxian(){
        $sql = M("admin_register");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['AdminName']==$val['username']){
                $array = $val;
            }
        }
        echo $array['quanxian'];
    }
    public function quan_upt(){
        $sql = M("admin_register");
        $count=$sql->join("left join role on admin_register.role_id=role.id")->join("left join flagship on flagship.shop_id=admin_register.fiagshop")->count();
        $p = getpage($count,12);
        $arr = $sql->join("left join role on admin_register.role_id=role.id")->join("left join flagship on flagship.shop_id=admin_register.fiagshop")->order("admin_register.status,admin_register.id")->limit($p->firstRow, $p->listRows)->field("admin_register.*,role.role_name,flagship.shop_name")->select();
//        dump($arr);
        $this->assign("ren",$arr);
        $this->assign('show', $p->show());
        $role = M("role");
        $ro = $role->select();
        $this->assign("re",$ro);

        $flagship=M("flagship");
        $shop_id=$flagship->field("shop_id,shop_name")->select();
        $this->assign("shop_id",$shop_id);
        $this->display();
    }
    //重置密码
    public function quan_pasd(){
        $sql = M("admin_register");
        $save["id"]=$_GET["role_id"];
        $s = "cdc654321";
        $save["password"]=md5(md5($s));
        $sql->save($save);
        $find = $sql->where("id = {$_GET['role_id']}")->find();
        $rizhi = M("operation"); //连接日志表
        $dato['username'] = $_COOKIE['AdminName'];
        $dato['details'] = "重置账号".$find['username']."登录密码";
        $dato['time'] = date("Y-m-d h:i:s",time());
        $rizhi->add($dato);
        $this->redirect("quan_upt");
    }
    //编辑
    public function quan_use(){
        $id=$_GET["role_id"];
        $sql = M("admin_register");
        $arr=$sql->where("id=$id")->find();
//        $arr["password"]=md5(md5($arr["password"]));
        $this->assign("arr",$arr);
        $role = M("role");

   
        $role_i=$sql->join("left join role on admin_register.role_id=role.id")->join("left join flagship on flagship.shop_id=admin_register.fiagshop")->where("admin_register.id=$id")->find();
        $this->assign("role",$role_i['shop_id']);
        $this->assign("role_i",$role_i);
        $ro = $role->select();
        $this->assign("re",$ro);
        
        $flagship=M("flagship");
        $shop_id=$flagship->field("shop_id,shop_name")->select();
        $this->assign("shop_id",$shop_id);
        $this->display();
    }
    public function quan_useU(){
        $sql = M("admin_register");
        $save["id"]=$_POST["id"];
        $save["role_id"]=$_POST["role_id"];
        $save["username"]=$_POST["username"];
        $save["name"]=$_POST["user"];
        $save["fiagshop"]=$_POST["fiagshop"];
//        $save["password"]=md5(md5($_POST["password"]));
        $sql->save($save);
        $this->redirect("quan_upt");
       
       
    }
    
    public function quan_useD(){
        $sql = M("admin_register");
        $save["id"]=$_GET["role_id"];
        $save["status"]=1;
//        $save["username"]=$_POST["username"];
//        $save["name"]=$_POST["user"];
//        $save["password"]=md5(md5($_POST["password"]));
        $sql->save($save);
        $this->redirect("quan_upt");
       
       
    }
    
    
    
    public function register(){
        $sql = M("admin_register");
        $where['username'] = $_POST['username'];
        $where['name'] = $_POST['user'];
        $where['password'] = md5(md5($_POST['password']));
        $where['role_id'] = $_POST['role_id'];
        $where['fiagshop'] = $_POST['fiagshop'];
        date_default_timezone_set ("PRC");
        $time=time();
        $data=date("Y-m-d H:i:s",$time);
        $where['time'] = $data;
        $where['quanxian'] = 0;
        $sql->add($where);
        
        $ku = M("operation");
        $jilu['username'] = $_COOKIE['AdminName'];
        $jilu['details'] = "对管理人员进行添加操作，新增".$_POST['user'];
        date_default_timezone_set ("PRC");
        $time5=time();
        $data5=date("Y-m-d H:i:s",$time5);
        $jilu['time'] = $data5;
        $ku->add($jilu); 
        $this->redirect("quan_upt");
    }
    public function user_sel(){
        $value = $_POST['value'];
        $sql = M("admin_register");
        $arr = $sql->select();
        foreach ($arr as $val){
            if($val['username']==$value){
                echo 1;
            }
        }
    }
    public function userqx_sel(){
        $user = $_POST['value'];
        $sql = M("admin_register");
        $arr = $sql->where("quanxian=0")->select();
        foreach($arr as $val){
            if($val['username']==$user){
                $array = $val['quan'];
            }
        }
        $quanxian = explode(",",$array);
        array_pop($quanxian);
        echo json_encode($quanxian);
    }
    public function operation(){
        if(!empty($_POST['date'])){
            $sql = M("operation");
            $value = $_POST['date'];
            $cha['time'] = array("LIKE","%$value%");
            $list = $sql->where($cha)->order('id desc')->select();
            $this->assign('ren', $list);
            $this->display();
        }else{
            $sql = M("operation");
            $count = $sql->count();
            $p = getpage($count,12);
            $list = $sql->order('id desc')->limit($p->firstRow, $p->listRows)->select();
            $this->assign('ren', $list);
            $this->assign('show', $p->show());
            $this->display();
        }
    }
    public function passselect(){
        $pass = md5(md5($_POST['pass']));
        $sql = M("admin_register");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['AdminName']==$val['username']){
                if($pass == $val['password']){
                    echo 1;
                }
            }
        }
    }
    public function pass_upt(){
        $sql = M("admin_register");
        $pass = md5(md5($_POST['password']));
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['AdminName']==$val['username']){
                $where['password'] = $pass;
                $sql->where("id={$val['id']}")->save($where);
                echo "修改成功";
                $rizhi = M("operation"); //连接日志表
                $dato['username'] = $_COOKIE['AdminName'];
                $dato['details'] = "修改账号".$_COOKIE['AdminName']."登录密码";
                $dato['time'] = date("Y-m-d h:i:s",time());
                $rizhi->add($dato);
            }
        }
        
    }
    public function jinyong(){
        $sql = M("vgoods");
        $id = $_GET['id'];
        $where['zhuangtai'] = 1;
        $sql->where("goods_id={$id}")->save($where);
        $this->redirect("zizhispguanli");
    }
    public function qiyong(){
        $sql = M("vgoods");
        $id = $_GET['id'];
        $where['zhuangtai'] = 0;
        $sql->where("goods_id={$id}")->save($where);
        $this->redirect("zizhispguanli");
    }
    //该表用
    public function qijian(){
        $sql = M("ucredentials");
        $arr = $sql->select();
        foreach($arr as $val){
            $where['shop_id'] = "天津市河西区友谊路旗舰店";
            $sql->where("crdentials_id={$val['crdentials_id']}")->save($where);
        }       
    }
     /**
 * 发送HTTP请求方法
 * @param  string $url    请求URL
 * @param  array  $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
  public function http(){
      $m = M("uaccount");
      $array = $m->select();
      $zhi = $_POST['username'];
      $zhi2 = $_POST['password'];
      if(!empty($zhi)&&!empty($zhi2)){
          foreach($array as $val){
              if($zhi==$val['tel']){
                  $upt['bean'] = $val['bean'] + $zhi2;
                  $m->where("user_id={$val['user_id']}")->save($upt);
              }
          }
      }
      $sql = M("bean");
      $where['name'] = $zhi;
      $where['jilu'] = $zhi2;
      date_default_timezone_set ("PRC");
      $time=time();
      $data=date("Y-m-d H:i:s",$time);
      $where['time'] = $data;
      $sql->add($where);
  }
  //倒库
//  public function daoku(){
//      $sql = M("ucustomer");
//      $arr = $sql->select();
//      $m = M("uaccount");
//      $array = $m->select();
//      foreach($array as $val){
//         for($i=0;$i<count($arr);$i++){
//             if($val['tel']==$arr[$i]['tel']){
//                 $where['bean'] = $arr[$i]['ebean'];
//                 $m->where("user_id={$val['user_id']}")->save($where);
//             }
//        } 
//      }
//      
//  }
  //接币
    public function borrow_money(){
        $m = M("borrow_money");
        $arr = $m->select();
        $this->assign("money",$arr);
        $this->display();
    }
    public function borrow_moneyAj(){
        $str=file_get_contents('php://input', 'r');
        $v=json_decode($str);
        $tel=$v->tel;
        $m=M("uaccount");
        $arr=$m->where("tel=$tel")->find();
        if($arr){
            echo json_encode($arr);
        }else{
            echo 1;
        }
        
    }
    public function borrow_moneyU(){
//        dump($_POST);
        $m=M("uaccount");
        $arr=$m->where("tel={$_POST["tel"]}")->find();
        $save["user_id"]=$arr["user_id"];
        $save["emoney"]=$arr["emoney"]-$_POST["money"];
        $m->save($save);
        
        //记录借币
        $b = M("borrow_money");
        $where['money'] = $_POST['money'];
        $where['username'] = $_COOKIE['AdminName'];
        $where['name'] = $arr['real_name'];
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d H:i:s",$time);
        $where['time'] = $times;
        $where['beizhu'] = $_POST['beizhu'];
        $b->add($where);
        
        //站内信
        $ku = M("operation");
        $jilu['username'] = $_COOKIE['AdminName'];
        $jilu['details'] = "对".$arr["real_name"]."进行借币操作，金额:".$_POST["money"];
        date_default_timezone_set ("PRC");
        $jilu['time']=date("Y-m-d H:i:s",time());
        $ku->add($jilu);
         $mail = M("mail");
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d",$time);
        $data['time'] = $times;
        $data['accept_id'] = $_POST['tel'];
        $data['send_id'] = $_COOKIE['AdminName'];
        $data['title'] = "借币成功";
        $data['content'] = "您在".$times."成功借币，借币金额为".$_POST['money'];   
        $data['status'] = 0;
        $data['type'] = 1;
        $mail->add($data);
        $this->redirect("borrow_money");
    }
      //新增内容
  public function peoselect(){
      $phone = $_POST['value'];
      $sql = M("uaccount");
      $arr = $sql->where("change_tel=$phone")->find();
      if(count($arr)>0){
          echo json_encode($arr);
      }else{
          echo 233;
      }
  }
  public function jiazhuang(){
      $tel = $_POST['tel'];
      $zizhi = $_POST['check'];
      $money = $_POST['money'];
      $chaochu = $_POST['chaochu'];
      $zongji = $_POST['zongji'];
      $jiancai = $_POST['jiancai'];
      $sql = M("uaccount");
      $find = $sql->where("change_tel=$tel")->find();
      $find2 = $sql->where("change_tel={$_POST['dianzhang']}")->find();
      $find3 = $sql->where("change_tel={$_POST['sheji']}")->find();
      $m = M("surpasses");
      $z = M("ucredentials");
      if(count($find)>0&&count($find2)>0&&count($find3)>0){
          for($i=0;$i<count($zizhi);$i++){
          $arr[] = $z->where("crdentials_id = {$zizhi[$i]}")->field("goods_id")->find();
            }
            for($i=0;$i<count($arr);$i++){
                $res .= $arr[$i].",";
                if($arr[$i]['goods_id']==99000){
                    $gai['jiancai_zizhi'] = 40600;
                }else if($arr[$i]['goods_id'] == 149000){
                    $gai['jiancai_zizhi'] = 60900;
                }else if($arr[$i]['goods_id'] == 190000){
                    $gai['jiancai_zizhi'] = 81200;
                }
                $gai['jiancai_use'] = 1;
                $z->where("crdentials_id = {$zizhi[$i]}")->save($gai);
            }
          $where['user_id'] = $find['user_id'];
          $where['dianzhang'] = $find2['user_id'];
          $where['sheji'] = $find3['user_id'];
          $where['danhao'] = $_POST['danhao'];
          $where['zizhi'] = $res;
          $where['hetong'] = $_POST['jine'];
          $where['chaochu'] = $chaochu;
          $where['ying'] = $zongji + $chaochu;
          $where['jiazhuang'] = $money;
          $where['yucun'] = $jiancai;
          $where['zongji'] = $zongji;
          date_default_timezone_set ("PRC");
          $time=time();
          $data=date("Y-m-d H:i:s",$time);
          $where['time'] = $data;
          $zongji = $chaochu + $zongji ;
          if($find['emoney']>=$zongji){
              $upt['emoney'] = $find['emoney'] - $zongji;
              $sql->where("user_id={$find['user_id']}")->save($upt);
              $where['jiaona'] = $zongji;
              $where['shengyu'] = 0;
              echo "提交成功";
              echo "<a href='handle'>返回</a>";
              $xiu['no_money'] =  $find['no_money'] + $_POST['zongji'];
              $sql->where("user_id={$find['user_id']}")->save($xiu);
          }else{
              $sheng = $zongji - $find['emoney'];
              $upt['emoney'] = $find['emoney'] - $find['emoney'];
              $sql->where("user_id={$find['user_id']}")->save($upt);
              $where['jiaona'] = $find['emoney'];
              $where['shengyu'] = $sheng;
              echo "用户电子币余额不足，需再缴纳".$sheng;
              $xiu['no_money'] =  $find['no_money'] + $_POST['zongji'];
              $sql->where("user_id={$find['user_id']}")->save($xiu);
          }
          $m->add($where);   
      }else{
          echo "此账号不存在,请重新核对";
      }
  }
  public function option_ucca(){
      $tel = $_POST['tel'];
      $sql = M("ucredentials");
      $arr = $sql->where("tel=$tel and type=2 and jiancai_use = 0")->select();
//      $arr = $sql->where("tel=$tel")->select();
      echo json_encode($arr);
  }
  public function send_phone(){
      function Post5($data, $target) {
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
        $phone = $_POST['tel'];
        $rand = $_POST['rand'];
        $target = "http://cf.51welink.com/submitdata/service.asmx/g_Submit";
        $post_data = "sname=dlkeylzs&spwd=7521chengduicheng&scorpid=2476&sprdid=1012888&sdst=$phone&smsg=".rawurlencode("您的验证码为".$rand.",您正在支付家装金额，如非本人操作请联系客服【诚兑城】");
        $gets = Post5($post_data, $target);
        echo $rand;
  }
     //新增代码
     //新闻list页面
  
    //站内信搜索存值
    public function mail_page() {
        if($_COOKIE['AdminName']){
            session_start();
            if (empty($_GET['qb'])) {
                session("time",$_POST['date']);
            } else {
                session("time",null);
            }
            $this->redirect("mail_list");
        }
    }
    //站内信列表
    public function mail_list() {
        if($_COOKIE['AdminName']){
            $m = M("mail");
            $user = M("uaccount");
            $admin = M("admin_register");
            if (!empty($_SESSION['time'])) {
                $value = $_SESSION['time'];
                $data['time'] = array("like","%$value%");
                $data['type'] = 0;
                $ar = $m->where($data)->group("num")->select();
                $count = count($ar);
                $p = getpage($count,12);
                $p->parameter['name'] =  urlencode($_SESSION['time']);
                $row = $m->order('mail_id desc')->where($data)->group("num")->limit($p->firstRow, $p->listRows)->select();
            } else {
                $ar = $m->where("type=0")->group("num")->select();
                $count = count($ar);
                $p = getpage($count,12);
                $row = $m->order('mail_id desc')->where("type=0")->group("num")->limit($p->firstRow, $p->listRows)->select();
            }
            if (!empty($row)) {
                foreach ($row as $val) {  
                    foreach ($val as $k=>$v) {
                        if ($k == "accept_id") {
                            $a[] = $v;   
                        }
                        if ($k == "send_id") {
                            $datq['username'] = $v;
                            for ($i=0;$i<count($row);$i++) {
                                $row[$i]['send_name'] = $admin->where($datq)->field("name")->find();
                            }
                        }
                    }
                }
                $datw['tel'] = array("in",$a);
                $accept_name = $user->where($datw)->field("real_name")->select();
                for ($z=0;$z<count($accept_name);$z++) {
                    $row[$z]['accept_name'] = $accept_name[$z];
                }
            }    
            $this->assign("row",$row);
            $this->assign('show', $p->show());
            $this->assign('value', $p->parameter['name']);
            $this->display();     
        }
    }
    //站内信发送
    public function send_mail() {
        if($_COOKIE['AdminName']){
            $this->display();
        }
    }
    //站内信新增
    public function add_mailedit() {
        if($_COOKIE['AdminName']){
            $m = M("mail");
            $user = M("uaccount");
            $row = $user->select();
            $data['num'] = $this->number();
            foreach ($row as $val) {
                foreach ($val as $k => $v) {
                    if ($k == "tel") {
                        $data['send_id'] = $_COOKIE['AdminName'];
                        $data['title'] = $_POST['title'];
                        $data['content'] = $_POST['content'];
                        date_default_timezone_set ("PRC");
                        $time=time();
                        $times = date("Y-m-d",$time);
                        $data['time'] = $times;
                        $data['status'] = 0;
                        $data['accept_id'] = $v;
                        $data['type'] = 0;
                        $m->add($data);
                    }
                } 
            }
            $ku = M("operation");
            $jilu['username'] = $_COOKIE['AdminName'];
            $jilu['details'] = "对所有人发送站内信";
            date_default_timezone_set ("PRC");
            $jilu['time']=date("Y-m-d H:i:s",time());
            $ku->add($jilu);
            $this->redirect("mail_list");
        }
    }
     //随机数
     public function number(){
        if($_COOKIE['AdminName']){
            if (is_null($chars)){
                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            }  
            mt_srand(10000000*(double)microtime());
            for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < 11; $i++){
                $str .= $chars[mt_rand(0, $lc)];  
            }
            return $str;
        }
    }
    //站内信删除
    public function delete_mail() {
        if($_COOKIE['AdminName']){
            $m =M("mail");
            $m->where("num='{$_GET['num']}'")->delete();
            $this->redirect("mail_list");
        }
    }
    //站内信详情
    public function mail_xx() {
        if($_COOKIE['AdminName']){
            $m = M("mail");
            $row = $m->where("mail_id='{$_GET['id']}'")->find();
            $this->assign("row",$row);
            $this->display();
        }
    }
    
    //删除提现申请
    public function tx_shenhe_del(){
        $m = M("tixian");
        $id = $_GET['id'];
        $arr = $m->where("t_id=$id")->find();
        $sql = M("uaccount");
        $find = $sql->where("tel={$arr['user']}")->find();
        $num = $find['tx'] + $arr['money'];
        if($num>50000){
            $num = 50000;
        }
        $upt['emoney'] = $find['emoney'] + $arr['money'];
        $upt['tx'] = $num;
        $sql->where("user_id={$find['user_id']}")->save($upt);
        $m->where("t_id=$id")->delete();
        $this->redirect("tixianguanli");
    }
    //查询资质页面
    public function tree_sel(){
        $this->display();
    }
    //树形图页面
    public function tree(){
        if($_GET['tel']){
            $menu = M('ucredentials');
            $arr = $menu->where("zizhanghu = '{$_GET['tel']}'")->find();
            $a = $menu->where("tid = {$arr['crdentials_id']}")->select();
            $arr['count'] = count($a);
            if(count($a[$i])==0){
                $arr['biaoshi'] = 1;
            }
            $time = explode("-", $arr['approval_time']);
            if($time[0]==2016){
            }else{
                if($arr['goods_id']==2900){
                    $arr['goods_id'] = 3200;
                }else if($arr['goods_id']==29000){
                    $arr['goods_id'] = 32000;
                }else if($arr['goods_id']==290000){
                    $arr['goods_id'] = 320000;
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
    public function ajax_tree2(){
        $tel = $_POST['tel'];
        $m = M("ucredentials");
        $arr = $m->where("tid=$tel")->select();
        echo json_encode($arr);
    }
    
    //后台注册账号
    public function user_register(){
        $tel = $_POST['tel'];
        $name = $_POST['real_name'];
        $code = $_POST['code'];
        $sql = M("uaccount");
        $where['tel'] = $tel;
        $where['real_name'] = $name;
        $where['identity_card'] = $code;
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d H:i:s",$time);
        $where['created_date'] = $times;
        $where['change_tel'] = $tel;
        $res = $sql->add($where);
        if($res){
            echo "注册成功!";
            $this->register_cg($tel);
        }else{
            echo "注册失败!";
        }
    }
    
    public function register_cg($tel){
        $sql = M("uaccount");
            $find = $sql->where("tel=$tel")->find();
            $name = $find['change_tel'];
        function Post3($data, $target){
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
            $post_data = "sname=dlkeylzs&spwd=7521chengduicheng&scorpid=2476&sprdid=1012888&sdst=$name&smsg=".rawurlencode('恭喜您成功注册诚兑城~请您关注微信公众号"诚兑城"以了解更多~您的初始登录密码为123456，安全密码为000000,如有疑问请联系客服【诚兑城】');
            $gets = Post3($post_data, $target);
    }


    //后台注册手机号码重复验证
    public function register_ajax(){
        $tel = $_POST['tel'];
        $sql = M("uaccount");
        $find = $sql->select();
        foreach($find as $val){
            if($val['tel']==$tel||$val['change_tel']==$tel){
                echo 1;
            }
        }
            
    }
    
    //后台充值电子币手机号码验证
    public function elist_ajax(){
        $tel = $_POST['tel'];
        $sql = M("uaccount");
        $find = $sql->where("change_tel = $tel")->find();
        if(count($find)>0){
            echo json_encode($find);
        }
    }
    
    //后台电子币充值处理方法
    public function user_elist(){
        $tel = $_POST['tel'];
        $money = $_POST['money'];
        $u = M("uaccount");
        $y = M("shoukuan");
        $y_arr = $y->find();
        $find = $u->where("change_tel={$tel}")->find();
        $sql = M("e_list");
        $where['money'] = $money;
        $where['tel'] = $tel;
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d H:i:s",$time);
        $where['time'] = $times;
        $where['name'] = $find['real_name'];
        $where['status'] = 0;
        $where['payee'] = $y_arr['yinhangka'];
        $where['beizhu'] = $_POST['beizhu'];
        $res = $sql->add($where);
        
        $mysql =M("e_list_mx");
        $add['mx_user_id'] = $find['user_id'];
        $add['mx_handle'] = $_COOKIE['AdminName'];
        $add['mx_money'] = $money;
        $add['mx_beizhu'] = $_POST['beizhu'];
        $add['mx_time'] = $times;
        $add['mx_status'] = 0;
        $mysql->add($add);
        if($res){
            echo "充值成功！请去审核！";
        }else{
            echo "充值失败！";
        }
    }
    public function system_elist(){
        $mysql = M("e_list_mx");
        $count = $mysql->count();
        $p = getpage($count,6);
        $arr = $mysql->table("e_list_mx,uaccount")->where("uaccount.user_id = e_list_mx.mx_user_id and e_list_mx.mx_status = 0")->order('mx_id desc')->limit($p->firstRow, $p->listRows)->select();
        $this->assign("arr",$arr);
        $this->assign("show",$p->show());
        $this->display();
    }
    //后台电子币充值处理方法
    public function user_elist2(){
        $tel = $_POST['tel'];
        $money = $_POST['money'];
        $u = M("uaccount");
        $y = M("shoukuan");
        $y_arr = $y->find();
        $find = $u->where("change_tel={$tel}")->find();
        $upt['biaoji'] = 1;
        $u->where("user_id={$find['user_id']}")->save($upt);
        $sql = M("e_list");
        $where['money'] = $money;
        $where['tel'] = $tel;
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d H:i:s",$time);
        $where['time'] = $times;
        $where['name'] = $find['real_name'];
        $where['status'] = 0;
        $where['payee'] = $y_arr['yinhangka'];
        $where['beizhu'] = $_POST['beizhu'];
        $res = $sql->add($where);
        
        $mysql =M("e_list_mx");
        $add['mx_user_id'] = $find['user_id'];
        $add['mx_handle'] = $_COOKIE['AdminName'];
        $add['mx_money'] = $money;
        $add['mx_beizhu'] = $_POST['beizhu'];
        $add['mx_time'] = $times;
        $add['mx_status'] = 1;
        $mysql->add($add);
        if($res){
            echo "充值成功！请去审核！";
        }else{
            echo "充值失败！";
        }
    }
    public function special_elist(){
        $mysql = M("e_list_mx");
        $count = $mysql->count();
        $p = getpage($count,6);
        $arr = $mysql->table("e_list_mx,uaccount")->where("uaccount.user_id = e_list_mx.mx_user_id and e_list_mx.mx_status = 1")->order('mx_id desc')->limit($p->firstRow, $p->listRows)->select();
        $this->assign("arr",$arr);
        $this->assign("show",$p->show());
        $this->display();
    }
    //合同列表页面
    public function handle_list(){
        $sql = M("surpasses");
        $count = $sql->count();
        $p = getpage($count,12);
        $list = $sql->order('surpasses_id desc')->limit($p->firstRow, $p->listRows)->select();
        $u = M("uaccount");
        $arr = $u->select();
        foreach($arr as $val){
            for($i=0;$i<count($list);$i++){
                if($list[$i]['user_id']==$val['user_id']){
                    $list[$i]['user_id'] = $val['real_name'];
                }
                if($list[$i]['dianzhang'] == $val['user_id']){
                    $list[$i]['dianzhang'] = $val['real_name'];
                }
                if($list[$i]['sheji'] == $val['user_id']){
                    $list[$i]['sheji'] = $val['real_name'];
                }
            }
        }
        $this->assign('ren', $list);
        $this->assign('show', $p->show());
        $this->display();
    }
    
    //后台扣除费用
    public function hush(){
        $tel =  $_POST['tel'];
        $sel = $_POST['bizhong'];
        $money = $_POST['money'];
        $beizhu = $_POST['beizhu'];
        $sql = M("uaccount");
        $find = $sql->where("change_tel = $tel")->find();
        if($sel=="emoney"){
            $a = "电子币";
        }else if($sel=="smoney"){
            $a = "积分";
        }else if($sel=="no_money"){
            $a = "建材电子币";
        }
        if($money > $find[$sel]){
            echo "账户".$a."余额不足，无法扣除费用";
        }else{
            $where[$sel] = $find[$sel] - $money;
            $sql->where("user_id = {$find['user_id']}")->save($where);
            $m = M("hush");
            $where['name'] = $_COOKIE['AdminName'];
            $where['user'] = $find['tel'];
            $where['real_name'] = $find['real_name'];
            $where['type'] = $a;
            $where['money'] = $money;
            $where['beizhu'] = $beizhu;
            date_default_timezone_set ("PRC");
            $time=time();
            $data=date("Y-m-d",$time);
            $where['time'] = $data;
            $m->add($where);
            echo "费用扣除成功";
            $ku = M("operation");
            $jilu['username'] = $_COOKIE['AdminName'];
            $jilu['details'] = "扣除客户".$find['real_name'].$a.$money."元";
            date_default_timezone_set ("PRC");
            $time5=time();
            $data5=date("Y-m-d H:i:s",$time5);
            $jilu['time'] = $data5;
            $ku->add($jilu);   
            $mysql = M("mail");
            $add['accept_id'] = $find['tel'];
            $add['send_id'] = $_COOKIE['AdminName'];
            $add['title'] = "会员扣费";
            $add['content'] = "系统扣除".$a.$money.",如有困惑请联系客服";
            date_default_timezone_set ("PRC");
            $time=time();
            $times = date("Y-m-d",$time);
            $add['time'] = $times;
            $add['status'] = 0;
            $add['type'] = 1;
        $mysql->add($add);
        }
    }
    //出库过申
    public function user_chuku() {
         $m = M("chuku"); //连接出库表
        $count = $m->where("status !=0")->count();
        $p = getpage($count,10);
        $arr = $m->where("status!=0")->order("sq_time desc")->limit($p->firstRow, $p->listRows)->select();
        $sp = M("item"); //连接商品表
        $sps = $sp->select(); //查询所有商品
        $flag = M("flagship"); //连接旗舰店
        $flags = $flag->select(); //去查询所以旗舰店
        $sc = M("item_mall"); //连接商城表
        $scs = $sc->select();//查询所有的商城
        for($i=0;$i<count($arr);$i++){
            for($a=0;$a<count($sps);$a++){
                if($arr[$i]['item_id'] == $sps[$a]['item_id']){
                    $arr[$i]['bar_code'] = $sps[$a]['bar_code'];
                    $arr[$i]['item_name'] = $sps[$a]['item_name'];
                    $arr[$i]['mall_id']= $sps[$a]['mall_id'];
                }
                
            }
             for($w=0;$w<count($flags);$w++){
                if($arr[$i]['flag_id'] == $flags[$w]['shop_id']){
                    $arr[$i]['shop_name'] = $flags[$w]['shop_name'];
                }
                
            }
              for($q=0;$q<count($scs);$q++){
                if($arr[$i]['mall_id'] == $scs[$q]['mall_id']){
                    $arr[$i]['mall_name'] = $scs[$q]['mall_name'];
                }
                
            }
            $arr[$i]['xuhao'] = $i+1;
        }
        $this->assign("show",$p->show());
        $this->assign("arr",$arr);
        $this->display();
    }
    //通过出货申请
    public function tongguo_chuku() {
        $m =M("chuku");//链接出库表
        $arr = $m->where("chuku_id='{$_POST['id']}'")->find();//查询出货表里的这条记录
        $int =M("inventory"); //连接库存表
        $sp =M("item"); //连接商品表
        $data['item_id'] = $arr['item_id'];
        $data['type']=1;
        $data['flag_id'] = $arr['flag_id'];
        $kucun = $int->where($data)->find();//查询库存这条记录
        $sps = $sp->where("item_id='{$arr['item_id']}'")->find(); //查询商品的这条数据
        if($kucun){
            if($kucun['sy_num'] - $arr['number'] <0 || $sps['number'] - $arr['number']<0){
                 echo 1; //证明库存不足
                 exit();
            }else{
                $datw['status']=2;
                $datw['shenhe']=1;
                $m->where("chuku_id='{$arr['chuku_id']}'")->save($datw); //修改这条记录的状态
                $datq['item_id'] = $arr['item_id'];
                $datq['inventory_new'] = $arr['number'];
                $datq['created_date']= date("Y-m-d h:i:s",time());
                $datq['inventory_use'] = $_COOKIE['AdminName'];
                $datq['flag_id']= $arr['flag_id'];
                $datq['status'] =4;
                $datq['sy_num'] = $kucun['sy_num'] - $arr['number'];
                $datq['shangcheng'] = $sps['mall_id'];
                $datq['type']=1;
                $datq['shenhe'] = 1;
                $datq['sqren'] = $arr['sqren'];
                $int->add($datq);//往库存表里插入数据
                $dat['type']=0;
                $int->where("inventory_id='{$kucun['inventory_id']}'")->save($dat);//替换掉之前的数据
                $sa['number'] = $sps['number'] - $arr['number'];
                $sp->where("item_id='{$sps['item_id']}'")->save($sa);//修改商品表的数量
                $rizhi = M("operation"); //连接日志表
                $dato['username'] = $_COOKIE['AdminName'];
                $dato['details'] = "对".$arr['sqren']."申请的".$sps['item_name']."商品，数量个数为:".$arr['number']."个，进行过审（出库）";
                $dato['time'] = date("Y-m-d h:i:s",time());
                $rizhi->add($dato);
                echo 3;
                exit();

            }
        }else{
                echo 2;
                exit();
        }
    }
    //活跃用户统计
    public function tongji_hy(){
        $sql = M("ucredentials");
        $start = $_POST['daterangepicker_start'];
        $end = $_POST['daterangepicker_end'];
        if(!empty($_POST['daterangepicker_start'])&&!empty($_POST['daterangepicker_end'])){
        $_SESSION['select'] = null;
        $_SESSION['start'] = null;
        $_SESSION['end'] = null;
        $map['approval_time']=array('between',array($start,$end));
        $map[_logic]="and";
        $_SESSION['start'] = $start;
        $_SESSION['end'] = $end;
        $find = $sql->where($map)->select();
        $uu = $sql->select();
        for($i=0;$i<count($uu);$i++){
            foreach($find as $val){
                if($val['tid']==$uu[$i]['crdentials_id']){
                    $array[$i][] = $val;
                    $uu[$i]['count'] = count($array[$i]);
                    $t = explode("-",$val['approval_time']);
                    if($t[0]=="2016"){
                        
                    }else{
                        if($val['goods_id']==2900){
                            $val['goods_id'] = 3200;
                        }else if($val['goods_id']==29000){
                            $val['goods_id'] = 32000;
                        }else if($val['goods_id']==290000){
                            $val['goods_id'] = 320000;
                        }
                    }
                    $uu[$i]['good_id'] += $val['goods_id'];
                    
                }
            }
        }
        $m = M("uaccount");
        $user = $m->select();
        for($i=0;$i<count($uu);$i++){
            if($uu[$i]['count']>0){
                $arr[$i] = $uu[$i];
                foreach($user as $val){
                    if($arr[$i]['tel']==$val['tel']){
                        $arr[$i]['real_name'] = $val['real_name'];
                    }
                }
            }
        }
        foreach($arr as $val){
            for($i=0;$i<count($arr);$i++){
                if($arr[$i]['tel']==$val['tel']){
                    $count[$i]['count'] += $val['count'];
                }
            }
        }
        $sort = array(
        'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
        'field'     => 'count',       //排序字段
        );
        $arrSort = array();
        foreach($arr AS $uniqid => $row){
            foreach($row AS $key=>$value){
                $arrSort[$key][$uniqid] = $value;
            }
        }
        if($sort['direction']){
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $arr);
        }
        for($i=0;$i<count($arr);$i++){
            $time[$i] = explode("-",$arr[$i]['approval_time']);
            if($time[$i][0]=="2016"){
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
        $this->assign("start",$_SESSION['start']);
        $this->assign("end",$_SESSION['end']);
        $this->assign("ren",$arr);
        }else{
            $find = $sql->select();
        $uu = $sql->select();
        for($i=0;$i<count($uu);$i++){
            foreach($find as $val){
                if($val['tid']==$uu[$i]['crdentials_id']){
                    $array[$i][] = $val;
                    $uu[$i]['count'] = count($array[$i]);
                    $t = explode("-",$val['approval_time']);
                    if($t[0]=="2016"){
                        
                    }else{
                        if($val['goods_id']==2900){
                            $val['goods_id'] = 3200;
                        }else if($val['goods_id']==29000){
                            $val['goods_id'] = 32000;
                        }else if($val['goods_id']==290000){
                            $val['goods_id'] = 320000;
                        }
                    }
                    $uu[$i]['good_id'] += $val['goods_id'];
                    
                }
            }
        }
        $m = M("uaccount");
        $user = $m->select();
        for($i=0;$i<count($uu);$i++){
            if($uu[$i]['count']>0){
                $arr[$i] = $uu[$i];
                foreach($user as $val){
                    if($arr[$i]['tel']==$val['tel']){
                        $arr[$i]['real_name'] = $val['real_name'];
                    }
                }
            }
        }
        foreach($arr as $val){
            for($i=0;$i<count($arr);$i++){
                if($arr[$i]['tel']==$val['tel']){
                    $count[$i]['count'] += $val['count'];
                }
            }
        }
        $sort = array(
        'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
        'field'     => 'count',       //排序字段
        );
        $arrSort = array();
        foreach($arr AS $uniqid => $row){
            foreach($row AS $key=>$value){
                $arrSort[$key][$uniqid] = $value;
            }
        }
        if($sort['direction']){
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $arr);
        }
        for($i=0;$i<count($arr);$i++){
            $time[$i] = explode("-",$arr[$i]['approval_time']);
            if($time[$i][0]=="2016"){
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
        $this->assign("start",$_SESSION['start']);
        $this->assign("end",$_SESSION['end']);
        $this->assign("ren",$arr);
        }
        $this->display();
    }
    //更改赠送购物币数量
    public function smoeny_upt(){
        $qian = $_POST['money'];
        $sql = M("money");
        $where['money'] = $qian;
        $sql->where("moeny_id = 1")->save($where);
        $this->redirect("smoney_handle");
    }
    //更换购物币页面
    public function smoney_handle(){
        $sql = M("money");
        $find = $sql->where("moeny_id = 1")->find();
        $this->assign("qian",$find);
        $this->display();
    }
    
    //特殊扣费
    public function user_hush(){
        $sql = M("hush");
        $count = $sql->count();
        $p = getpage($count,12);
        $list = $sql->order('hush_id desc')->limit($p->firstRow, $p->listRows)->select();
        $this->assign('arr', $list);
        $this->assign('show', $p->show());
        $this->display();
    }

    //该表
//    public function gaigaigai(){
//        $sql = M("fenli");
////        $arr = $sql->where("name = '韩莹' and qixian > 2")->select();
//        for($i=0;$i<count($arr);$i++){
//            $time[$i] = $arr[$i]['fenlitime'];
//            $fenli[$i] = explode("-",$time[$i]);
//            if($fenli[$i][1]<9){
//                $gai[$i] = "0".($fenli[$i][1] + 1);
//                $huan[$i] = $fenli[$i][0]."-".$gai[$i]."-".$fenli[$i][2];
//            }else{
//                $gai[$i] = $fenli[$i][1] + 1;
//                $huan[$i] = $fenli[$i][0]."-".$gai[$i]."-".$fenli[$i][2];
//            }
//            $upt[$i]['fenlitime'] = $huan[$i];
//            $sql->where("f_id={$arr[$i]['f_id']}")->save($upt[$i]);
//        }
//        dump($upt);
//    }
    //出库未通过
    public function shanchu_chuku(){
          $m =M("chuku");//链接出库表
          $data['status'] = 3;
        $arr = $m->where("chuku_id='{$_POST['id']}'")->save($data);//查询出货表里的这条记录
        if($arr){
            echo 1;
        }else{
            echo 2;
        }
        
    }
//    //家装提现标记()
    public function jiazhuangtixian(){
        $m = M("ucredentials");
        $arr = $m->where("goods_id = 99000 or goods_id = 149000 or goods_id = 199000")->select();
        $sql = M("tixian");
        $where['biao'] = 1;
        foreach($arr as $val){
            $sql->where("user = {$val['tel']}")->save($where);
        }
    }
    public function biaoji(){
        $sql = M("tixian");
        $arr = $sql->select();
        $where['biao'] = 0;
        foreach($arr as $val){
            $sql->where("t_id={$val['t_id']}")->save($where);
        }
    }
//    public function biaoji(){
//        $sql = M("item");
//        $arr = $sql->where("mall_id = 3")->select();
//        foreach($arr as $val){
//            $where['mall_id'] = 2;
//            $sql->where("item_id = {$val['item_id']}")->save($where);
//        }
//    }
    //电子币转换建材电子币
    public function user_jiancai(){
        $sql = M("uaccount");
        $find = $sql->where("change_tel = {$_POST['tel']}")->find();
        $qian = $_POST['money'];
        $where['emoney'] = $find['emoney'] - $qian;
        $where['no_money'] = $find['no_money'] + $qian;
        $a = $sql->where("user_id = {$find['user_id']}")->save($where);
        $mx = M("uaccount_mx");
        $add['user_id'] = $find['user_id'];
        $add['mx_money'] = $qian;
        $add['mx_beizhu'] = $_POST['beizhu'];
        $add['mx_handle'] = $_COOKIE['AdminName'];
         date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d H:i:s",$time);
        $add['mx_time'] = $times;
        $mx->add($add);
        if($a){
            echo "转换成功";
        }else{
            echo "转换失败";
        }
    }
    public function system_jiancai(){
        $mysql = M("uaccount_mx");
        $count = $mysql->count();
        $p = getpage($count,6);
        $arr = $mysql->table("uaccount_mx,uaccount")->where("uaccount.user_id = uaccount_mx.user_id")->order('mx_id desc')->limit($p->firstRow, $p->listRows)->select();
        $this->assign("arr",$arr);
        $this->assign("show",$p->show());
        $this->display(); 
    }
    //招商经理管理
    public function manager(){
        $m = M("flagship");
        $arr = $m->select();
        $this->assign("flagship",$arr);
        
        $sql = M("manager");
        $find = $sql->select();
        foreach($arr as $val){
            for($i=0;$i<count($find);$i++){
                if($val['shop_id']==$find[$i]['shop_id']){
                    $find[$i]['shop_name'] = $val['shop_name'];
                }
            }
        }
        $this->assign("shop",$find);
        $this->display();
    }
    //新增招商经理
    public function manager_add(){
        $name = $_POST['manager_name'];
        $shop = $_POST['shop'];
        $tel = $_POST['tel'];
        $sql = M("manager");
        $where['manager_name'] = $name;
//        $where['shop_id'] = $shop;
        $where['manager_tel'] = $tel;
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d H:i:s",$time);
        $where['creat_time'] = $times;
        $sql->add($where);
        $this->redirect("manager");
    }
    //删除招商经理
    public function manager_del(){
        $id = $_POST['id'];
        $sql = M("manager");
        $a = $sql->where("manager_id = $id")->delete();
        if($a){
            echo 1;
        }
    }
    public function jianshao(){
        $sql = M("uaccount");
        $arr = $sql->select();
        foreach($arr as $val){
            $where['emoney'] = $val['emoney'] - 45000;
            $where['smoney'] = $val['smoney'] - 50000;
            $sql->where("user_id={$val['user_id']}")->save($where);
        }
    }
    //抽奖取值(有奖项)
//    public function choujiang(){
////        session("li",null);
//        $sql = M("rand");
////        dump($_POST);
//        date_default_timezone_set ("PRC");
//        $time=time();
//        $start = date("Y-m-d 00:00:00",$time);
//        $end = date("Y-m-d 23:59:59",$time);
//        $map['rand_time']=array('between',array($start,$end));
//        $m = M("rand_shezhi");
//        $arr2 = $m->where("shezhi_status = 0")->select();
//        $this->assign("sel",$arr2);
////        dump($arr2);
//        if(!empty($_POST['sel'])){
//            for($i=0;$i<count($arr2);$i++){
//                if($arr2[$i]['shezhi_jiang']==$_POST['sel']){
//                    $jiang = $arr2[$i]['shezhi_num'];
//                    $name = $arr2[$i]['shezhi_name'];
////                    session("li","一等奖");
//                    $save['shezhi_status'] = 1;
//                    $b = $m->where("shezhi_jiang={$_POST['sel']}")->find();
//                    $m->where("shezhi_jiang = {$_POST['sel']}")->save($save); 
////                    echo 1;
//                }elseif($arr2[$i]['shezhi_jiang']==$_POST['sel']){
//                    $jiang = $arr2[$i]['shezhi_num'];
//                    $name = $arr2[$i]['shezhi_name'];
////                    session("li","二等奖");
//                    $save['shezhi_status'] = 1;
//                     $b = $m->where("shezhi_jiang={$_POST['sel']}")->find();
//                    $m->where("shezhi_jiang = {$_POST['sel']}")->save($save);
////                    echo 2;
//                }elseif($arr2[$i]['shezhi_jiang']==$_POST['sel']){
//                    $jiang = $arr2[$i]['shezhi_num'];
//                    $name = $arr2[$i]['shezhi_name'];
////                    $li = "三等奖";
//                    $save['shezhi_status'] = 1;
//                    $b = $m->where("shezhi_jiang={$_POST['sel']}")->find();
//                    $m->where("shezhi_jiang = {$_POST['sel']}")->save($save);
////                    echo 3;
//                }
//            }
//            
//            $arr = $sql->where($map)->where("rand_status = 0")->limit($jiang)->order('rand()')->select();
//            foreach($arr as $key => $val){
//                $new_arr[$key]['rand_phone'] = substr($val['rand_phone'],0,3)."****".substr($val['rand_phone'],-4,4);
//                $new_arr[$key]['rand_id'] = $val['rand_id'];
//                $upt2['rand_choujiang'] = $name;
//                $sql->where("rand_id={$val['rand_id']}")->save($upt2);
//            }
//            $array = $sql->select();
//            foreach($array as $val){
//                $new_array[]['rand_phone'] = substr($val['rand_phone'],0,3)."****".substr($val['rand_phone'],-4,4);
//            }
//            if($b['shezhi_status']==0){
//                $this->assign("arr",$new_arr);
//                $this->assign("array",$new_array);
//                $this->assign("jiang",$name);
//            }
//            
//        }
//        $this->display();
//    }
    //抽奖取值(无奖项)
    public function choujiang(){
        $sql = M("rand_ceshi");
        date_default_timezone_set ("PRC");
        $time=time();
        $start = date("Y-m-d 00:00:00",$time);
        $end = date("Y-m-d 23:59:59",$time);
        $map['rand_time']=array('between',array($start,$end));
//        dump($arr2);
//        if(!empty($_POST['sel'])){
//            for($i=0;$i<count($arr2);$i++){
//                if($arr2[$i]['shezhi_jiang']==$_POST['sel']){
//                    $jiang = $arr2[$i]['shezhi_num'];
//                    $name = $arr2[$i]['shezhi_name'];
////                    session("li","一等奖");
//                    $save['shezhi_status'] = 1;
//                    $b = $m->where("shezhi_jiang={$_POST['sel']}")->find();
//                    $m->where("shezhi_jiang = {$_POST['sel']}")->save($save); 
////                    echo 1;
//                }elseif($arr2[$i]['shezhi_jiang']==$_POST['sel']){
//                    $jiang = $arr2[$i]['shezhi_num'];
//                    $name = $arr2[$i]['shezhi_name'];
////                    session("li","二等奖");
//                    $save['shezhi_status'] = 1;
//                     $b = $m->where("shezhi_jiang={$_POST['sel']}")->find();
//                    $m->where("shezhi_jiang = {$_POST['sel']}")->save($save);
////                    echo 2;
//                }elseif($arr2[$i]['shezhi_jiang']==$_POST['sel']){
//                    $jiang = $arr2[$i]['shezhi_num'];
//                    $name = $arr2[$i]['shezhi_name'];
////                    $li = "三等奖";
//                    $save['shezhi_status'] = 1;
//                    $b = $m->where("shezhi_jiang={$_POST['sel']}")->find();
//                    $m->where("shezhi_jiang = {$_POST['sel']}")->save($save);
////                    echo 3;
//                }
//            }
            
//            $arr = $sql->where("rand_status = 0")->limit(5)->order('rand()')->select();
//            foreach($arr as $key => $val){
//                $new_arr[$key]['rand_phone'] = substr($val['rand_phone'],0,3)."****".substr($val['rand_phone'],-4,4);
//                $new_arr[$key]['rand_id'] = $val['rand_id'];
//                $upt2['rand_choujiang'] = "奖项";
////                $upt2['rand_choujiang'] = $name;
//                $sql->where("rand_id={$val['rand_id']}")->save($upt2);
//            }
            $array = $sql->where($map)->select();
            foreach($array as $val){
                $new_arr[]['rand_img'] = file_get_contents($val['rand_img']);
//                $new_array[]['rand_phone'] = substr($val['rand_phone'],0,3)."****".substr($val['rand_phone'],-4,4);
            }
           
//            $this->assign("arr",$new_arr);
            $this->assign("array",$array);
            $this->assign("jiang",$name);
            
//        }
        $this->display();
    }
    //抽奖数组
    public function selarr(){
        $sql = M("rand_ceshi");
        date_default_timezone_set ("PRC");
        $time=time();
        $start = date("Y-m-d 00:00:00",$time);
        $end = date("Y-m-d 23:59:59",$time);
        $map['rand_time']=array('between',array($start,$end));
        $arr = $sql->where($map)->where("rand_status = 0")->limit(5)->order('rand()')->select();
        foreach($arr as $key => $val){
//            $new_arr[$key]['rand_phone'] = substr($val['rand_phone'],0,3)."****".substr($val['rand_phone'],-4,4);
//            $new_arr[$key]['rand_id'] = $val['rand_id'];
            $upt2['rand_choujiang'] = "奖项";
    //                $upt2['rand_choujiang'] = $name;
            $sql->where("rand_id={$val['rand_id']}")->save($upt2);
        }
        echo json_encode($arr);
    }
    //抽奖——发送短信
    public function uptchou(){
        $sql = M("rand_ceshi");
        $arr = $_POST['arr'];
        foreach($arr as $val){
            $upt['rand_status'] = 1;
            $a = $sql->where("rand_id = {$val['rand_id']}")->save($upt);
            $find = $sql->where("rand_id = {$val['rand_id']}")->find();
            $this->send_mess($find['rand_opeanid']);
            //发送注册成功提示的短信
//            $target = "http://cf.51welink.com/submitdata/service.asmx/g_Submit";
//            $post_data = "sname=dlkeylzs&spwd=7521chengduicheng&scorpid=2476&sprdid=1012888&sdst={$find['rand_phone']}&smsg=".rawurlencode('恭喜您获得'.$find['rand_choujiang'].'，凭此短信，到领奖处领奖。【诚兑城】');
//            $gets = $this->Post233($post_data, $target);
        }
    }
    //抽奖发送消息
    public function send_mess($id){
        $postdata ='{"touser":"'.$id.'","msgtype":"text","text":{"content":"恭喜您中奖，请按大会安排领奖"}}';
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'Content-Length' => strlen($postdata),
                'Host' => 'api.weixin.qq.com',
                'Content-Type' => 'application/json',
                'content' => $postdata
            )
        );
        $data = M("weixin_config")->where("weixin_id = 1")->find();
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$data['appid']."&secret=".$data['secret'];
        $res = json_decode(file_get_contents($url));
        $access_token = $res->access_token;
        $context = stream_context_create($opts);
        $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token, true, $context);
        echo $result;
    }
    public function Post233($data, $target){
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
    public function guiling(){
        $sql = M("rand");
        $arr = $sql->select();
        foreach($arr as $val){
            $where['rand_status'] = 0;
            $where['rand_choujiang'] = "";
            $sql->where("rand_id = {$val['rand_id']}")->save($where);
        }
    }
//    public function wwww(){
//        $sql = M("rand_ceshi");
//        $arr = $sql->where("rand_status = 1 and rand_choujiang = '奖项'")->select();
//        foreach($arr as $val){
//            $target = "http://cf.51welink.com/submitdata/service.asmx/g_Submit";
//            $post_data = "sname=dlkeylzs&spwd=7521chengduicheng&scorpid=2476&sprdid=1012888&sdst={$val['rand_phone']}&smsg=".rawurlencode('亲爱的诚兑城用户您好，由于刚刚系统数据错误造成短信发送内容出错，抱歉打扰您了！【诚兑城】');
//            $gets = $this->Post233($post_data, $target);
//        }
//    }
    //抽奖设置
    public function choujiang_shezhi(){
        $sql = M("rand_shezhi");
        $arr = $sql->select();
        $this->assign("shezhi",$arr);
        $this->display();
    }
    public function choujiang_fa(){
        $sql = M("rand_shezhi");
        $yi = $_POST['yi'];
        $er = $_POST['er'];
        $san = $_POST['san'];
        $where['shezhi_num'] = $yi;
        $where2['shezhi_num'] = $er;
        $where3['shezhi_num'] = $san;
        $a = $sql->where("shezhi_id = 2")->save($where);
        $b = $sql->where("shezhi_id = 3")->save($where2);
        $c = $sql->where("shezhi_id = 4")->save($where3);
//        if($a||$b||$c){
            echo "设置成功";
//        }else{
//            echo "系统忙，请稍后";
//        }
    }
    public function chushihua(){
        $sql = M("rand_shezhi");
        $arr = $sql->select();
        foreach($arr as $val){
            $where['shezhi_status'] = 0;
            $a = $sql->where("shezhi_id = {$val['shezhi_id']}")->save($where);
        }
//        dump($arr);
        if($a){
            echo 1;
        }
    }
    //抽取中奖人数
    public function shezhi_choujiang(){
        
    }
    //几率抽奖
//    public function ccc(){
//        $data = $this->getReward();
//        echo $data;
//    }
//    public function getReward($total=1000)
//{
//        $win1 = floor((5*$total)/100);
//        $win2 = floor((15*$total)/100);
//        $win3 = floor((80*$total)/100);
//        $return = array();
//        for ($i=0;$i<$win1;$i++)
//        {
//        $return[] = 1;
//        }
//        for ($j=0;$j<$win2;$j++)
//        {
//        $return[] = 2;
//        }
//        for ($m=0;$m<$win3;$m++)
//        {
//        $return[] = 3;
//        }
//        shuffle($return);
//        return $return[array_rand($return)];
//}
    //2
//    public function gaifenli(){
//        $sql = M("fenli");
//        $m = M("uaccount");
//        $map['fenlitime'] = "2017-2-18";
//        $arr = $sql->where($map)->select();
//        foreach($arr as $val){
//            $find = $m->where("tel={$val['tel']}")->find();
//            if($val['chanpin']==2900||$val['chanpin']==29000||$val['chanpin']==290000){
//                $upt['emoney'] = $find['emoney'] + $val['guanlifei'];
//                $m->where("user_id = {$find['user_id']}")->save($upt);
//            }
//        } 
//    }
    //ajax轮询
    public function danmu_add(){  
                $sql = M("barrage");
                $arr = $sql->order("barrage_id desc")->find();
                echo json_encode($arr);     
                exit();     
        }         
        
        
//        if($arr){
//            $arr['status'] = "success";
//            echo json_encode($arr);
//        }else{
//            
//        }
//        foreach($arr as $val){
//            $upt['barrage_status'] = 1;
//            $sql->where("barrage_id = {$val['barrage_id']}")-save($upt);
//        }
    public function getAllMsgCount(){
        $sql = "select count(*) as count from barrage;";
        $res = M()->query($sql);
        $count = $res[0]['barrage_text'];           
        return $count; 
    }

    public function getAllMsgTradeCode(){       
        $oldCount = $this->getAllMsgCount();
        $sql = "select trade_code from barrage;";
        $data = M()->query($sql);
        if($_POST['msg'] == "init"){           
            $this->ajaxReturn($data);
            exit;
        }

        while(true){            
            set_time_limit(0);
            $newCount = $this->getAllMsgCount();
            if($newCount > $oldCount){
                $data = M()->query($sql);
                $this->ajaxReturn($data);
                break;
            }
            usleep(1000);
        }
    }
}
