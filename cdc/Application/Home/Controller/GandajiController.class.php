<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class GandajiController extends Controller {
    public function index(){
        if($_COOKIE['ShopName']){
            cookie("fanhui",null);
            $this->display();
        }else{
            $this->redirect("tishi");
        }
    }
    public function admin_quanxian(){
        $m=M("admin_register");
        $name=$_COOKIE['ShopName'];
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
        if($_COOKIE['ShopName']){
            foreach($arr as $val){
                if($_COOKIE['ShopName']==$val['username']){
                    echo json_encode($val);
                }
            }
        } 
    }
    public function login_yanzheng(){
        if(!empty($_POST['username'])){
            $time2= time()+60*60*24*7;
            $name = $_POST['username'];
            cookie("ShopName","$name",$time2);
            $m =M("admin_register");
            $arr = $m->where("username='$name'")->find();
//            dump($arr);
            cookie("qxfenpei",$arr['fiagshop'],$time2);
        }
        $this->redirect("index");
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
    public function signOut(){
        cookie('ShopName',null);
        cookie('qxfenpei',null);
        $this->redirect("login");
    }
   
    //商品品牌
    public function brand(){
        $m=M("brand");
        $count=$m->count();
        $p = getpage($count,10);
        $arr=$m->limit($p->firstRow, $p->listRows)->order("brand_id desc")->select();
        $this->assign("arr",$arr);
        $this->assign('show', $p->show());
        $this->display();
        
    }
    public function brand_add(){
        $m=M("brand");
        $add["brand_name"]=$_POST["brand_name"];
        $m->add($add);
        $this->redirect("brand");
    }
    public function brand_delete(){
        $m=M("brand");
        $where["brand_id"]=$_GET["brand_id"];
        $m->where($where)->delete();
        $this->redirect("brand");       
    }
    //商品单位
    public function unit(){
        $m=M("item_unit");
        $count=$m->count();
        $p = getpage($count,10);
        $arr=$m->limit($p->firstRow, $p->listRows)->order("unit_id desc")->select();
        $this->assign("arr",$arr);
        $this->assign('show', $p->show());
        $this->display();
        
    }
    public function unit_add(){
        $m=M("item_unit");
        $add["unit_name"]=$_POST["unit_name"];
        $m->add($add);
        $this->redirect("unit");
    }
    public function unit_delete(){
        $m=M("item_unit");
        $where["unit_id"]=$_GET["unit_id"];
        $m->where($where)->delete();
        $this->redirect("unit");       
    }
    
      
    
    public function shangpin(){
        $sql = M("item_category");
        $arr = $sql->select();
        $a = $sql->where("parent_id=0")->select();
        foreach($arr as $val){
            for($i=0;$i<count($a);$i++){
                if($val['paeent_id']!="0"){
                    if($val['parent_id']==$a[$i]['category_id']){
                        $a[$i][0] .= $val['category_name'].",";
                        $a[$i][2] .= substr($val['fenleis'],5).",";
                        $a[$i][1] .= $val['category_id'].",";
                    }
                    if($val['leiid']==$a[$i]['leiid'] && $val['leiid'] !== ''){
                        $a[$i]['aa'][] = $val['fenleis'];
                        $a[$i]['bb'][] = $val['category_id'];
                    }
                }
                }
            }
        $this->assign("fenlei",$a);
        $this->assign("ren",$arr);
        $m = M("supplier");
        $a = $m->select();
        $this->assign("gong",$a);
        
        $d=M("brand");
        $brand=$d->select();
//        dump($brand);
        $this->assign("brand",$brand);
        
        $item_unit=M("item_unit");
        $c=$item_unit->select();
        $this->assign("item_unit",$c);  
        
        $item_mall=M("item_mall");
        $item_mal=$item_mall->select();
        $this->assign("item_mall",$item_mal);  
        $gui =M("mall_guize"); //连接商城规则表
        $guize =$gui->select();
        $z ='';
        for($a=0;$a<count($item_mal);$a++){
            for($i=0;$i<count($guize);$i++){
                if($item_mal[$a]['mall_id'] == $guize[$i]['mall_id']){
                    $z .= $guize[$i]['guize_name'].",";
                }
            }
            $item_mal[$a]['guize'] = $z;
            $z='';
            
        }
        $this->assign("arr",$item_mal);
        $this->display();
    }
    public function addfenlei(){
        $sql = M("item_category");
        if(!empty($_POST['addclass'])){
            $where['category_name'] = $_POST['addclass'];
            $id = $sql->add($where); 
            $data['leiid'] = $id;
             $arr = $sql->where("category_id='$id'")->save($data);
        }
        if(!empty($_POST['upt'])&&!empty($_POST['upt_id'])){
            $where['category_name'] = $_POST['upt'];
            $id = $_POST['upt_id'];
            $sql->where("category_id=$id")->save($where);
        }
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $sql->where("category_id=$id")->delete();
        }
        if(!empty($_POST['fenlei'])&&!empty($_POST['fenlei_id'])){
            $where['category_name'] = $_POST['fenlei'];
            $where['parent_id'] = $_POST['fenlei_id'];
            $sql->add($where);
        }
       if(!empty($_POST['mingzi'])){
            $data['category_name'] = $_POST['mingzi'];
            $data['parent_id'] = 0;
            $data['fenleis'] = $_POST['mingzi2'];
            $id = $sql->add($data);
            $datw['leiid'] = $id;
            $sql->where("category_id='$id'")->save($datw);
            $date['category_name'] = $_POST['mingzi'];
            $date['parent_id'] = 88;
            $date['fenleis'] = $_POST['mingzi6'];
            $date['leiid'] = $id;
            $sql->add($date);
       }
        $this->redirect("fenlei");
    }
    public function fenlei(){
        $sql = M("item_category");
        $arr = $sql->select();
        $count = $sql->where("parent_id=0")->count();
        $p = getpage($count,20);
        $sps = M("item");//连接商品表
        $spn = $sps->select();
        $a = $sql->where("parent_id=0")->limit($p->firstRow, $p->listRows)->order("dalei_px")->select();
        foreach($arr as $val){
            for($i=0;$i<count($a);$i++){
                if($val['paeent_id']!="0"){
                    if($val['parent_id']==$a[$i]['category_id']){
                        $a[$i][0] .= $val['category_name'].",";
                        $a[$i][1] .= $val['category_id'].",";
                    }
                    if($val['leiid']==$a[$i]['leiid'] && $val['leiid'] !== ''){
                        $a[$i]['aa'][] = $val['fenleis'];
                        $a[$i]['bb'][] = $val['category_id'];
                    }
                }
            }  
        }
        for($q=0;$q<count($a);$q++){
             for($w=0;$w<count($spn);$w++){
                if($a[$q]['item_tj1'] == $spn[$w]['item_id']){
                     $a[$q]['tj1'] = $spn[$w]['item_name'];
                     $a[$q]['bar1'] = $spn[$w]['bar_code'];
                }                 
            }
             for($k=0;$k<count($spn);$k++){
                if($a[$q]['item_tj2'] == $spn[$k]['item_id']){
                     $a[$q]['tj2'] = $spn[$k]['item_name'];
                    $a[$q]['bar2'] = $spn[$k]['bar_code'];
                }                 
            }
        }    
//        dump($a);
        $this->assign('show', $p->show());
        $this->assign("fenlei",$a);
        $this->display();
    }
    public function fenlei2(){
        $id = $_GET['id'];
        session("id", $id);
        $sql = M("item_category");
        $arr = $sql->where("parent_id=$id")->order("xiaolei_px asc")->select();
        for($a=0;$a<count($arr);$a++){
            $arr[$a]['calei'] = substr($arr[$a]['fenleis'],5);
        }
        $this->assign("fenlei",$arr);
        $this->assign("id",$_GET['id']);
        $this->display();
    }
    public function addzifenlei(){
        $sql = M("item_category");
        $id = $_SESSION['id'];
        if(!empty($_POST['addclass'])){
            $where['category_name'] = $_POST['addclass'];
            $where['parent_id'] = $id;
            $sql->add($where); 
        }
        if(!empty($_POST['upt'])&&!empty($_POST['upt_id'])){
            $where['category_name'] = $_POST['upt'];
            $zid = $_POST['upt_id'];
            $sql->where("category_id=$zid")->save($where);
        }
        if(!empty($_GET['tid'])){
            $tid = $_GET['tid'];
            $sql->where("category_id=$tid")->delete();
        }
        if(!empty($_POST['mingzi'])){
            $arr = $sql->where("category_id='{$_POST['ycid']}'")->find(); //查询这个子类的大类
            $a = $arr['fenleis']; //拿着大类的规则
            if($arr['lieid'] !== ''){
                $arr2 = $sql->where("leiid='{$arr['leiid']}'")->order("category_id desc")->find(); 
            }   
            $data['parent_id']= $_POST['ycid'];
            $data['category_name'] = $_POST['mingzi'];
            if(!empty($_POST['mingzi2'])){
                $data['fenleis'] = $a.$_POST['mingzi2'];
            }
            $sql->add($data);
            if($arr2&&$arr2['fenleis'] !== ''){
                $b = $arr2['fenleis'];
                $date['parent_id'] = 88;
                $date['category_name'] = $_POST['mingzi'];
                if(!empty($_POST['mingzi2'])){
                    $date['fenleis'] = $b.$_POST['mingzi2'];
                }
                $sql->add($date);
            }
        }
        $this->redirect("System:fenlei2","id=$id");
    }
    public function gongyingupt(){
        $id = $_GET['id'];
        $sql = M("supplier");
        $where['supplier_name'] = $_POST['name'];
        $where['contacts'] = $_POST['user'];
        $where['tel'] = $_POST['tel'];
        $sql->where("supplier_id=$id")->save($where);
        $this->redirect("gongyingshang");
    }
    public function gongyingdel(){
        $id = $_GET['id'];
        $sql = M("supplier");
        $sql->where("supplier_id=$id")->delete();
        $this->redirect("gongyingshang");
    }
    public function gongyingshang(){
        $sql = M("supplier");
        $count = $sql->count();
        $p = getpage($count,12);
        $a = $sql->limit($p->firstRow, $p->listRows)->select();
        $this->assign('show', $p->show());
        $this->assign("ren",$a);
        $this->display();
    }
    public function addgy(){
        $sql = M("supplier");
        $where['supplier_name'] = $_POST['name'];
        $where['contacts'] = $_POST['user'];
        $where['tel'] = $_POST['tel'];
        for($a=0;$a<count($_POST['brand']);$a++){
            $s .= $_POST['brand'][$a].",";   
        }
        $where['brands_id'] = $s;
        $sql->add($where);
        $this->redirect("gongyingshang");
    }
    //修改供应商
    public function addgy_save(){
       $sql = M("supplier");
        $where['supplier_name'] = $_POST['name'];
        $where['contacts'] = $_POST['user'];
        $where['tel'] = $_POST['tel'];
        for($a=0;$a<count($_POST['brand']);$a++){
            $s .= $_POST['brand'][$a].",";   
        }
        $where['brands_id'] = $s;
        $sql->where("supplier_id='{$_GET['id']}'")->save($where);
        $this->redirect("gongyingshang");
    }
    public function Select(){
        $value = $_POST['value'];
        $sql = M("item_category");
        $arr = $sql->where("parent_id=$value")->select();
        echo json_encode($arr);
    }
    //商品首页
    public function shop(){
//        dump($_COOKIE['mall_id']);
        $m=M("item");
        if(!empty($_COOKIE["item_name"])){
            $value=$_COOKIE["item_name"];
            $where["item_name"]=array("like","%$value%");
            $whee["item_name"]=array("like","%$value%");
        }
        if(!empty($_COOKIE["mall_id"])&&$_COOKIE["mall_id"]!=0){          
            $where["mall_id"]=$_COOKIE["mall_id"];
            $whee["mall_id"]=$_COOKIE["mall_id"];
            $w["mall_id"]=array("neq",$_COOKIE["mall_id"]);
        }
        if(!empty($_COOKIE["bar_code"])){          
              $val=$_COOKIE["bar_code"];
            $where["bar_code"]=array("like","%$val%");
            $whee["bar_code"]=array("like","%$val%");
        }
         
//         if(!empty($_COOKIE['kucun1']) || !empty($_COOKIE['kucun2'])) {
//            
//                  $where["number"]=  array(array("egt",$_COOKIE['kucun1']),
//                        array("elt",$_COOKIE['kucun2']));
//                  $whee["number"]=  array(array("egt",$_COOKIE['kucun1']),
//                        array("elt",$_COOKIE['kucun2']));
//             
//         }else if($_COOKIE['kucun2'] == '0'){
//             $where['number'] = 0;
//             $whee['number'] = 0;
//         }
        $count = $m->where($where)->where("status = 0")->count();
        $p = getpage($count,10);
        $arr = $m->where($where)->where("status = 0")->limit($p->firstRow, $p->listRows)->order("order_num asc")->select();
        $arrs = $m->where($whee)->where("rale!=''")->order("status asc ,mall_id asc,rale desc")->select();
       
        $sp = M("item_mall");
        $sps = $sp->select();
        for($a=0;$a<count($arr);$a++){
            for($i=0;$i<count($sps);$i++){
                if($arr[$a]['mall_id'] == $sps[$i]['mall_id']){
                    $arr[$a]['mall_name'] =$sps[$i]['mall_name'];
                }
            }
        }
        for($a=0;$a<count($arrs);$a++){
            for($i=0;$i<count($sps);$i++){
                if($arrs[$a]['mall_id'] == $sps[$i]['mall_id']){
                    $arrs[$a]['mall_name'] =$sps[$i]['mall_name'];
                }
            }
            $arrs[$a]['xuhao'] = $a+1;
        }
        $cagetory = M("item_category");
        $this->assign("arr",$arr);
        $this->assign("arrs",$arrs);
        $this->assign('show', $p->show());
        $item_mall=M("item_mall");        
        $item=$item_mall->where($w)->select();
        $this->assign("item",$item);
          $fl = M("flagship"); //连接旗舰店的表
        $qjd = $fl->select();//查询
        $this->assign("qjd",$qjd);
        $this->display();
      
    }
    //商品下架列表
    public  function xj_shop() {
         $m=M("item");
        if(!empty($_COOKIE["item_names"])){
            $value=$_COOKIE["item_names"];
            $where["item_name"]=array("like","%$value%");
        }
        if(!empty($_COOKIE["mall_ids"])&&$_COOKIE["mall_ids"]!=0){          
            $where["mall_id"]=$_COOKIE["mall_ids"];
            $w["mall_id"]=array("neq",$_COOKIE["mall_ids"]);;
        }
        if(!empty($_COOKIE["bar_codes"])){
            $val=$_COOKIE["bar_codes"];
           
            $where["bar_code"]=array("like","%$val%");
        }
        $where['status'] = 1;
        $count = $m->where($where)->count();
        $p = getpage($count,10);
        $arr = $m->where($where)->limit($p->firstRow, $p->listRows)->order("status asc ,mall_id asc, rale desc")->select();
         $sp = M("item_mall");
        $sps = $sp->select();
        for($a=0;$a<count($arr);$a++){
            for($i=0;$i<count($sps);$i++){
                if($arr[$a]['mall_id'] == $sps[$i]['mall_id']){
                    $arr[$a]['mall_name'] =$sps[$i]['mall_name'];
                }
            }
        }
        $this->assign("arr",$arr);
        $this->assign('show', $p->show());
        
        $item_mall=M("item_mall");        
        $item=$item_mall->where($w)->select();
        $this->assign("item",$item);
        $this->display();
    }
    //搜索存cookie函数
    public function shop_cookie(){
        if(!empty($_POST["item_name"])){
            cookie("item_name",trim($_POST["item_name"]));
        }else{
            cookie("item_name",null);
        }
         if(!empty($_POST["mall_id"])){
            cookie("mall_id",trim($_POST["mall_id"]));
            $m=M("item_mall");
            $arr=$m->where("mall_id='{$_COOKIE["mall_id"]}'")->find();
            cookie("mall_name",$arr["mall_name"]);
        }
        if(!empty($_POST["bar_code"])){
            cookie("bar_code",trim($_POST["bar_code"]));
        }else{
            cookie("bar_code",null);
        }
//        if(!empty($_POST["kucun1"])){
//            cookie("kucun1",trim($_POST["kucun1"]));
//   
//        }else{
//            cookie("kucun1",0);
//        }
//        if(!empty($_POST["kucun2"])){
//            cookie("kucun2",trim($_POST["kucun2"]));
//       
//        }else{
//            if($_POST['kucun2'] == "0"){
//                 cookie("kucun2",0);
//            }else{
//                 cookie("kucun2",9999999);
//            }
//           
//        }
        $this->redirect("shop");
        
    }
  
     public function shop_cookiee(){
        if(!empty($_POST["item_name"])){
            cookie("item_namese",trim($_POST["item_name"]));
        }else{
            cookie("item_namese",null);
        }
         if(!empty($_POST["mall_id"])){
            cookie("mall_idse",trim($_POST["mall_id"]));
            $m=M("item_mall");
            $arr=$m->where("mall_id='{$_COOKIE["mall_id"]}'")->find();
            cookie("mall_namese",$arr["mall_name"]);
        }
        if(!empty($_POST["bar_code"])){
            cookie("bar_codese",trim($_POST["bar_code"]));
        }else{
            cookie("bar_codese",null);
        }
        if(!empty($_POST["kucun1"])){
            cookie("kucun1se",trim($_POST["kucun1"]));
        }else{
            cookie("kucun1se",0);
        }
        if(!empty($_POST["kucun2"])){
            cookie("kucun2se",trim($_POST["kucun2"]));
        }else{
            cookie("kucun2se",9999999);
        }
        $this->redirect("shop_tuihui");
        
    }
    
    //下架商品上架
    public function shop_shang() {
        $m =M("item");
        $data['status'] = 0;
        $a = $m->where("item_id='{$_POST['item_id']}'")->save($data);
        if($a){
            echo 1;
        }
    }
    //搜索存cookie函数商品加下
    public function xj_shop_cookie(){
        if(!empty($_POST["item_name"])){
            cookie("item_names",trim($_POST["item_name"]));
        }else{
            cookie("item_name",null);
        }
         if(!empty($_POST["mall_id"])){
            cookie("mall_ids",trim($_POST["mall_id"]));
            $m=M("item_mall");
            $arr=$m->where("mall_id='{$_COOKIE["mall_ids"]}'")->find();
            cookie("mall_names",$arr["mall_name"]);
        }
        if(!empty($_POST["bar_code"])){
            cookie("bar_codes",trim($_POST["bar_code"]));
        }else{
            cookie("bar_codes",null);
        }
        $this->redirect("xj_shop");
        
    }
    //商品搜索清楚cookie
    public function shop_cookieD(){
          cookie("item_name",null);
          cookie("mall_id",null);
          cookie("mall_name",null);
          cookie("bar_code",null);
          cookie("kucun1",null);
          cookie("kucun2",null);
          $this->redirect("shop");
    }
    //商品统计搜索清空
    public function shop_cookiess(){
         cookie("mall_ids",null);
          cookie("mall_names",null);
          cookie("time",null);
          cookie("times",null);
          cookie("xx",null);
          $this->redirect("sptongji");
    }
      public function shop_cookieDse(){
          cookie("item_namese",null);
          cookie("mall_idse",null);
          cookie("mall_namese",null);
          cookie("bar_codese",null);
          cookie("kucun1se",null);
          cookie("kucun2se",null);
          $this->redirect("shop_tuihui");
    }
        //商品下架搜索清楚cookie
    public function xj_shop_cookieD(){
          cookie("item_names",null);
          cookie("mall_ids",null);
          cookie("mall_names",null);
          cookie("bar_codes",null);
          $this->redirect("xj_shop");
    }
    //商品下架
    public function shop_shelves(){
        $save["item_id"]=$_POST["item_id"];
        $save["status"]=1;
        $m=M("item");
        $a = $m->save($save);
        if($a){
            echo 1;
        }
    }
    
    
   public function shop_update(){
        $sql = M("item_category");
        $arr = $sql->select();
        $a = $sql->where("parent_id=0")->select();
        foreach($arr as $val){
            for($i=0;$i<count($a);$i++){
                if($val['paeent_id']!="0"){
                     if($val['parent_id']==$a[$i]['category_id']){
                        $a[$i][0] .= $val['category_name'].",";
                        $a[$i][2] .= substr($val['fenleis'],5).",";
                        $a[$i][1] .= $val['category_id'].",";
                    }
                    if($val['leiid']==$a[$i]['leiid'] && $val['leiid'] !== ''){
                        $a[$i]['aa'][] = $val['fenleis'];
                        $a[$i]['bb'][] = $val['category_id'];
                    }
                }
                }
            }
        $this->assign("fenlei",$a);
       $this->assign("ren",$arr);
        $m=D("vitem");
        $fenleiss = M("item");
        $ar = $m->where("item_id='{$_GET["item_id"]}'")->find();
        session("bianhao_yan",$ar['bar_code']);
        $this->assign("val",$ar);
        $ass = $fenleiss->where("item_id='{$_GET["item_id"]}'")->find();
        $spp = M("supplier");
        $spsp = $spp->select(); //查询供应商
        $this->assign("gong",$spsp);
        $spps = $spp->where("supplier_id='{$ass['supplier_id']}'")->find();
        $ass['supplier_name'] = $spps['supplier_name'];
        $this->assign("ass",$ass);
        $array =$fenleiss->where("item_id='{$_GET["item_id"]}'")->find();
        $fid=$sql->where("category_id={$array["category_id"]}")->find();
//        $zfid=$sql->where("parent_id={$array["parent_id"]}")->select();
         $this->assign('sp',$array);
        $this->assign("fid",$fid);
          if($fid["parent_id"] == '0') {
               $this->assign("fls",$fid);
        } else {
            $cd = $sql->where("category_id='{$fid["parent_id"]}'")->find();
            $this->assign("fls",$cd);
        }
//        $this->assign("zfid",$zfid);
        
//        dump($spp);
       $brand=M("brand");
       $b=$brand->select();
       for($a=0;$a<count($b);$a++) {
           if($array['brand_id'] == $b[$a]['brand_id']) {
               $b[$a]['sd'] = 1;
           }
       }
       $scs = M("item_mall");
       $item_mall = $scs->select();
       $this->assign("item_mall",$item_mall);
        $gui =M("mall_guize"); //连接商城规则表
        $guize =$gui->select();
        $z ='';
        for($a=0;$a<count($item_mall);$a++){
            for($i=0;$i<count($guize);$i++){
                if($item_mall[$a]['mall_id'] == $guize[$i]['mall_id']){
                    $z .= $guize[$i]['guize_name'].",";
                }
            }
            $item_mall[$a]['guize'] = $z;
            $z='';
            
        }
        $this->assign("arr",$item_mall);
       $this->assign("brand",$b);
       $item_unit=M("item_unit");
       $c=$item_unit->select();
       $this->assign("item_unit",$c);   
       $futu = M("item_futu");
       $futus = $futu->where("item_id='{$_GET["item_id"]}'")->order("futu_id desc")->limit(4)->select();
       $this->assign("futu",$futus);
       $this->display();
   }
   public function shops_update(){
       $sql = M("item_category");
       $arr = $sql->select();
        $a = $sql->where("parent_id=0")->select();
        foreach($arr as $val){
            for($i=0;$i<count($a);$i++){
                if($val['paeent_id']!="0"){
                     if($val['parent_id']==$a[$i]['category_id']){
                        $a[$i][0] .= $val['category_name'].",";
                        $a[$i][2] .= substr($val['fenleis'],5).",";
                        $a[$i][1] .= $val['category_id'].",";
                    }
                    if($val['leiid']==$a[$i]['leiid'] && $val['leiid'] !== ''){
                        $a[$i]['aa'][] = $val['fenleis'];
                        $a[$i]['bb'][] = $val['category_id'];
                    }
                }
                }
            }
        $this->assign("fenlei",$a);
       $this->assign("ren",$arr);
        $m=D("vitem");
        $fenleiss = M("item");
        $ar = $m->where("item_id='{$_GET["item_id"]}'")->find();
        session("bianhao_yan",$ar['bar_code']);
        $this->assign("val",$ar);
        $ass = $fenleiss->where("item_id='{$_GET["item_id"]}'")->find();
        $spp = M("supplier");
        $spsp = $spp->select(); //查询供应商
        $this->assign("gong",$spsp);
        $spps = $spp->where("supplier_id='{$ass['supplier_id']}'")->find();
        $ass['supplier_name'] = $spps['supplier_name'];
        $this->assign("ass",$ass);
        $array =$fenleiss->where("item_id='{$_GET["item_id"]}'")->find();
        $fid=$sql->where("category_id={$array["category_id"]}")->find();
//        $zfid=$sql->where("parent_id={$array["parent_id"]}")->select();
        $this->assign('sp',$array);
        $this->assign("fid",$fid);
//        $this->assign("zfid",$zfid);
        if($fid["parent_id"] == '0') {
               $this->assign("fls",$fid);
        } else {
            $cd = $sql->where("category_id='{$fid["parent_id"]}'")->find();
            $this->assign("fls",$cd);
        }
//        dump($spp);
       $brand=M("brand");
       $b=$brand->select();
        for($a=0;$a<count($b);$a++) {
           if($array['brand_id'] == $b[$a]['brand_id']) {
               $b[$a]['sd'] = 1;
           }
       }
         $scs = M("item_mall");
       $item_mall = $scs->select();
       $this->assign("item_mall",$item_mall);
        $gui =M("mall_guize"); //连接商城规则表
        $guize =$gui->select();
        $z ='';
        for($a=0;$a<count($item_mall);$a++){
            for($i=0;$i<count($guize);$i++){
                if($item_mall[$a]['mall_id'] == $guize[$i]['mall_id']){
                    $z .= $guize[$i]['guize_name'].",";
                }
            }
            $item_mall[$a]['guize'] = $z;
            $z='';
            
        }
        $this->assign("arr",$item_mall);
       $this->assign("brand",$b);
       $item_unit=M("item_unit");
       $c=$item_unit->select();
       $this->assign("item_unit",$c);   
       $futu = M("item_futu");
       $futus = $futu->where("item_id='{$_GET["item_id"]}'")->order("futu_id desc")->limit(4)->select();
       $this->assign("futu",$futus);
       $this->display();
   }
   public function shop_inventory(){
       date_default_timezone_set ("PRC");
        $time=time();
       $m=M("item");
       $arr=$m->where("item_id={$_POST["item_id"]}")->find();
       $save["item_id"]=$_POST["item_id"];
       $save["number"]=$_POST["item_number"]+$arr["number"];
       $m->save($save);
       $inventory=M("inventory");
       $add["item_id"]=$_POST["item_id"];
       $add["inventory_new"]=$_POST["item_number"];
       $add["created_date"]=date("Y-m-d h:i:s",$time);
       $add["inventory_use"]=$_COOKIE["ShopName"];
       $inventory->add($add);
       $this->redirect("shop");
   }
   //2016.12.15.李景志修改商品入库存
   public function ruku() {
       date_default_timezone_set ("PRC");
        $time=time();
       $inventory=M("inventory");  //连接库存表
        $m=M("item"); //连接商品表
       $arr=$m->where("item_id={$_POST["item_id"]}")->find(); //查询这个商品
       $row = $inventory->where("item_id='{$_POST['item_id']}' and flag_id='{$_POST['qjd_id']}'")->order("inventory_id desc")->find();//查询之前有没有这个商品的入库记录
       $add["item_id"]=$_POST["item_id"];   //商品id
       $add["inventory_new"]=$_POST["item_number"];     //入库数量
       $add["sqtime"]=date("Y-m-d h:i:s",$time);     //入库时间
       $add["sqren"]=$_COOKIE["ShopName"];   //操作人
       $add['status'] = 0; //状态为0的是入库操作
       $add['flag_id'] = $_POST['qjd_id'];  //旗舰店id
       $add['shangcheng'] = $arr['mall_id']; //所属商城
//       if(empty($row)) {
//           $add['sy_num'] = $_POST["item_number"];
          
//       } else {
//           $add['sy_num'] = $_POST["item_number"] + $row['sy_num'];
//           $datw['type'] = 0;
//           $inventorys->where("inventory_id='{$row['inventory_id']}'and flag_id='{$row['flag_id']}'")->find();
//           $inventory->where("inventory_id='{$row['inventory_id']}'and flag_id='{$row['flag_id']}'")->save($datw); //替换掉之前最新的记录
//       }
//        $add['type'] = 1 ; //证明这是最新的记录
        $add['shenhe'] = 0;
       $a = $inventory->add($add); //往库存表里增加数据
//       $save["number"]= $_POST["item_number"] +$arr['number']; //库存数量商品数量同步
//       $b = $m->where("item_id='{$_POST['item_id']}'")->save($save); //修改商品表数量
       $ins=$inventory->where("inventory_id='$a'")->find();
//       if($ins['shenhe'] == 0){
//           $dat['type'] = 2;
//           $inventory->where("inventory_id='{$row['inventory_id']}'and flag_id='{$row['flag_id']}'")->save($dat); //保留审核的最后的一条
//       }
       if($a) {
           echo 1;
       } else {
           echo 2 ;
       }
   }
    //2016.12.15.李景志修改商品入库存
   public function tuihuo() {
       date_default_timezone_set ("PRC");
        $time=time();
       $inventory=M("inventory");  //连接库存表
        $m=M("item"); //连接商品表
       $arr=$m->where("item_id={$_POST["item_id"]}")->find(); //查询这个商品
       $row = $inventory->where("item_id='{$_POST['item_id']}' and flag_id='{$_POST['qjd_id']}' and type=1")->find();//查询之前有没有这个商品的入库记录
       $add["item_id"]=$_POST["item_id"];   //商品id
       $add["inventory_new"]=$_POST["item_number"];     //入库数量
       $add["sqtime"]=date("Y-m-d h:i:s",$time);     //入库时间
       $add["sqren"]=$_COOKIE["ShopName"];   //操作人
       $add['status'] = 1; //状态为1的是退货操作
       $add['flag_id'] = $_POST['qjd_id'];  //旗舰店id
       $add['shenhe'] = 3;
       $add['shangcheng'] = $arr['mall_id'];
       if(empty($row)) {
           echo 1;  //没有这条记录
           exit();
       } 
//       else {
//           $add['sy_num'] = $row['sy_num']- $_POST["item_number"];
//       }
       if($row['sy_num']- $_POST["item_number"] >=0 && $arr['number'] - $_POST["item_number"] >=0) {
           $add['type'] = 0; 
             $a = $inventory->add($add); //往库存表里增加数据
             // 
             echo 2;
//             $cd = $inventory->where("inventory_id='$a'")->find();//查找刚进库的那条数据
//             $datw['type']=0;
//             $inventory->where("inventory_id='{$row['inventory_id']}'")->save($datw);
//            $save["number"]= $arr['number'] - $_POST["item_number"]; //库存数量商品数量同步
//            $b = $m->where("item_id='{$_POST['item_id']}'")->save($save); //修改商品表数量
//            $sps = $m->where("item_id='{$_POST['item_id']}'")->find(); //查询这个商品
       } else {
           echo 4; //没有那么多货
           exit();
       }
//       if($a && $b) {
//           echo 2;  //退货成功
//            $caozuo = M("operation"); //连接日志表
//            $ca['username'] = $_COOKIE['ShopName'];
//            $ca['time'] = date("Y-m-d h:i:s",time());
//            $ca['details'] = "退货数量为".$cd['inventory_new']."个".$sps['item_name']."的商品";
//            $caozuo->add($ca);
//       } else {
//           echo 3 ; //系统繁忙
//           exit();
//       }
   }
   
//    public function addshangpin(){
//        $sql = M("item");
//        $where['item_name'] = $_POST['name'];
//        $where['category_id'] = $_POST['fulei'].",".$_POST['zilei'];
//        $where['s_yj_price'] = $_POST['s_yuanjia'];
//        $where['s_xj_price'] = $_POST['s_jiage'];
//        $where['g_yj_price'] = $_POST['g_yuanjiag'];
//        $where['g_xj_price'] = $_POST['g_jiage'];
//        $where['s_jifen'] = $_POST['s_jifen'];
//        $where['g_jifen'] = $_POST['g_jifen'];
//        $where['shangcheng'] = $_POST['shangcheng'];
////        $where['number'] = $_POST['shuliang'];
//        $where['supplier_id'] = $_POST['gSupplier'];
//        $where['specifications'] = $_POST['guige'];
//        $where['pinpai'] = $_POST['pinpai'];
//        $array=array("jpg","gif","png",);
////        dump($_FILES);
//        if(!empty($_FILES['files']['size'])){
//                $b=explode(".",$_FILES['files']['name']);
//            if(!in_array(end($b),$array)){
//            }else{
//               $file_name=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
//                move_uploaded_file($_FILES['files']['tmp_name'],"Public/upload/$file_name");
//            }
//        }
//        if($file_name){
//            $where['img_url'] = "/Public/upload/$file_name";
//        }
//        date_default_timezone_set ("PRC");
//        $time=time();
//        $data=date("Y-m-d",$time);
//        $where['created_date'] = $data;
//        $where['remarks'] = $_POST['content'];
//        $where['status'] = 1;
////        dump($where);
//        $sql->add($where);
//        $this->redirect("shangpin");
//    }
   
   public function addshangpin(){       
       $sql = M("item");
       date_default_timezone_set ("PRC");
        $time=time();
        $where['item_name'] = $_POST['name'];
//        $where['category_id'] = $_POST['zilei'];
        $where['guige'] = $_POST['xh_name'];
        $where['eMoney'] = $_POST['s_jiage'];
        if($_POST['original_price1']==""||$_POST['original_price1']==0){
             $where['original_price'] = $_POST['original_price2'];
        }else{
             $where['original_price'] = $_POST['original_price1'];
        }
      
        $where['sMoney'] = $_POST['g_jiage'];
        $where['integral'] = $_POST['g_jifen'];
//        $where['supplier_id'] = $_POST['gSupplier'];
        $where['brand_id'] = $_POST['pinpai'];
        $array=array("jpg","gif","png","JPG","JPEG");
        if(!empty($_FILES['files']['size'])){
                $b=explode(".",$_FILES['files']['name']);
            if(!in_array(end($b),$array)){
            }else{
               $file_name=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                move_uploaded_file($_FILES['files']['tmp_name'],"Public/upload/$file_name");
            }
        }
        if($file_name){
            $where['img_url'] = "/Public/upload/$file_name";
        }else{
            $where['img_url'] = "/Public/upload/noitem.jpg";
        }
        $where['created_date'] =date("Y-m-d h:i:s",$time);
        if(!empty($_POST["content"])){
            $where['remarks'] = $_POST['content'];
        }
        $where['status'] = 0;
        $where['unit_id'] = $_POST["danwei"];
//        $where['mall_id'] = $_POST["shangcheng"];
        $where['bar_code'] = trim($_POST["bianma"]);
        if(substr(trim($_POST['bianma']),0,3) == 693){
            $where['biaoji'] = 1;
        }
        $sqs = M("mall_guize");
        $guize = substr(trim($_POST['bianma']),0,3);
        $arrgui = $sqs->where("guize_name='$guize'")->find();
        $where['mall_id'] = $arrgui['mall_id'];
        $where['type'] = $_POST["xh_name"];
        $where['menpiao_time'] = $_POST['menpiao'];
//        $where['Integral'] = $_POST["g_jifen"];
//        $where['gh_money'] = $_POST["s_ghjg"];
//        $where['item_id'] = $_GET["id"];
//        dump($where);
         $sid = $sql->add($where);
        $futu = M("item_futu");
        $_FILES=array_values($_FILES);
        $f=0;
        while($f<count($_FILES)){
              $b = explode(".", $_FILES[$f]['name']);
                if(in_array(end($b), $array)){
                    $file_name_big[$f]= $_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(10000,99999).".".end($b);
                    move_uploaded_file($_FILES[$f]["tmp_name"],"Public/upload/$file_name_big[$f]");
                    $see['item_id'] = $sid;
                    $see['futu_url'] = "/Public/upload/".$file_name_big[$f];
                    $futu->add($see);
                }else{
                    $see['item_id'] = $sid;
                    $see['futu_url'] = "";
                    $futu->add($see);
                }
            $f++;           
        } 
         if($sid){
              $gh = M("suppliers"); //连接供应商表
                $ghs['item_id'] = $sid;
                $ghs['time'] = date("Y-m-d h:i:s",$time);
                $ghs['bianma'] = trim($_POST["bianma"]);
                $ghs['shangcheng'] = $arrgui['mall_id'];
                $gh->add($ghs);
//        echo $sql->getlastsql();$
            $this->redirect("shangpin");
         } else{
             echo "新增商品失败，请检查编码";    
         }
   }
   
    public function shop_uu(){
        $sql = M("item");
        date_default_timezone_set ("PRC");
        $time=time();
         $shangcheng = $sql->where("item_id='{$_GET['id']}'")->find();
        $where['item_name'] = $_POST['name'];
//        $where['category_id'] = $_POST['zilei'];
//        $where['type'] = $_POST['xh_name'];
        $where['eMoney'] = $_POST['s_jiage'];
        if($_POST['original_price1']==""||$_POST['original_price1']==0){
             $where['original_price'] = $_POST['original_price2'];
        }else{
             $where['original_price'] = $_POST['original_price1'];
        }
      
        $where['sMoney'] = $_POST['g_jiage'];
//        $where['integral'] = $_POST['g_jifen'];
//        $where['supplier_id'] = $_POST['gSupplier'];
        $where['brand_id'] = $_POST['pinpai'];
        $array=array("jpg","gif","png","JPG","JPEG");
        if(!empty($_FILES['files']['size'])){
                $b=explode(".",$_FILES['files']['name']);
            if(!in_array(end($b),$array)){
            }else{
               $file_name=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                move_uploaded_file($_FILES['files']['tmp_name'],"Public/upload/$file_name");
            }
        }
        if($file_name){
            $where['img_url'] = "/Public/upload/$file_name";
        }   
        $where['created_date'] =date("Y-m-d h:i:s",$time);
        if(!empty($_POST["content"])){
            $where['remarks'] = $_POST['content'];
        }
        $where['status'] = $shangcheng['status'];
        $where['unit_id'] = $_POST["danwei"];
//        $where['mall_id'] = $_POST["shangcheng"];
        $where['bar_code'] = trim($_POST["bianma"]);
        if(substr(trim($_POST['bianma']),0,3) == 693){
            $where['biaoji'] = 1;
        }
        $where['guige'] = $_POST["xh_name"];
        $where['Integral'] = $_POST["g_jifen"];
        $where['item_id'] = $_GET["id"];
        $sqs = M("mall_guize");
        $guize = substr(trim($_POST['bianma']),0,3);
        $arrgui = $sqs->where("guize_name='$guize'")->find();
        $where['mall_id'] = $arrgui['mall_id'];
        $sup = M("suppliers");
        $add['shangcheng'] = $arrgui['mall_id'];
        $sup->where("item_id='{$_GET["id"]}'")->save($add);
//        $where['gh_money'] = $_POST['s_ghjg'];
//        $where['type'] = $_POST["xh_name"];
//        dump($where);
        $sql->save($where);
       
        $tj = M("diaojia"); //连接调价表
        $dats['item_id'] =  $_GET["id"];
        $dats['shangcheng'] = $shangcheng['mall_id'];
        $dats['emony_x'] = $_POST['s_jiage'];
        $dats['smony_x'] = $_POST['g_jiage'];
        $dats['emony_y'] = $_POST['original_price1'];
        $dats['smony_y'] = $_POST['original_price2'];
        $dats['gh_money'] = $_POST['s_ghjg'];
        $dats['time'] = date("Y-m-d h:i:s",$time);
        $dats['user'] = $_COOKIE['ShopName'];
       
        $tj->add($dats);
        $futu = M("item_futu");
                if(!empty($_FILES['files1']['size'])){
                 $b=explode(".",$_FILES['files1']['name']);
             if(!in_array(end($b),$array)){
             }else{
                $file_name2=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                 move_uploaded_file($_FILES['files1']['tmp_name'],"Public/upload/$file_name2");              
             }
         }
         
         if($file_name2){
            $sees['futu_url'] = "/Public/upload/$file_name2";
            $futu->where("futu_id='{$_POST['ids'][0]}'")->save($sees);
         }
          if(!empty($_FILES['files2']['size'])){
                 $b=explode(".",$_FILES['files2']['name']);
             if(!in_array(end($b),$array)){
             }else{
                $file_name3=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                 move_uploaded_file($_FILES['files2']['tmp_name'],"Public/upload/$file_name3");              
             }
         }
         if($file_name3){
            $sees['futu_url'] = "/Public/upload/$file_name3";
            $futu->where("futu_id='{$_POST['ids'][1]}'")->save($sees);
         }
          if(!empty($_FILES['files3']['size'])){
                 $b=explode(".",$_FILES['files3']['name']);
             if(!in_array(end($b),$array)){
             }else{
                $file_name4=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                 move_uploaded_file($_FILES['files3']['tmp_name'],"Public/upload/$file_name4");              
             }
         }
         if($file_name4){
            $sees['futu_url'] = "/Public/upload/$file_name4";
            $futu->where("futu_id='{$_POST['ids'][2]}'")->save($sees);
         }
        if(!empty($_FILES['files4']['size'])){
                 $b=explode(".",$_FILES['files4']['name']);
             if(!in_array(end($b),$array)){
             }else{
                $file_name5=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                 move_uploaded_file($_FILES['files4']['tmp_name'],"Public/upload/$file_name5");              
             }
         }
         if($file_name5){
            $sees['futu_url'] = "/Public/upload/$file_name5";
            $futu->where("futu_id='{$_POST['ids'][3]}'")->save($sees);
         }
//     $this->redirect("shop");
    }
     public function shops_uu(){
         date_default_timezone_set ("PRC");
        $time=time();
        $sql = M("item");
        $where['item_name'] = $_POST['name'];
//        $where['category_id'] = $_POST['zilei'];
//        $where['type'] = $_POST['xh_name'];
        $where['eMoney'] = $_POST['s_jiage'];
        if($_POST['original_price1']==""||$_POST['original_price1']==0){
             $where['original_price'] = $_POST['original_price2'];
        }else{
             $where['original_price'] = $_POST['original_price1'];
        }
      
        $where['sMoney'] = $_POST['g_jiage'];
//        $where['integral'] = $_POST['g_jifen'];
//        $where['supplier_id'] = $_POST['gSupplier'];
        $where['brand_id'] = $_POST['pinpai'];
        $array=array("jpg","gif","png","JPG","JPEG");
        if(!empty($_FILES['files']['size'])){
                $b=explode(".",$_FILES['files']['name']);
            if(!in_array(end($b),$array)){
            }else{
               $file_name=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                move_uploaded_file($_FILES['files']['tmp_name'],"Public/upload/$file_name");
            }
        }
        if($file_name){
            $where['img_url'] = "/Public/upload/$file_name";
        }   
       
        $where['created_date'] =date("Y-m-d h:i:s",$time);
        if(!empty($_POST["content"])){
            $where['remarks'] = $_POST['content'];
        }
        $where['status'] = 1;
        $where['unit_id'] = $_POST["danwei"];
//        $where['mall_id'] = $_POST["shangcheng"];
        $where['bar_code'] = trim($_POST["bianma"]);
         if(substr(trim($_POST['bianma']),0,3) == 693){
            $where['biaoji'] = 1;
        }
          $sqs = M("mall_guize");
        $guize = substr(trim($_POST['bianma']),0,3);
        $arrgui = $sqs->where("guize_name='$guize'")->find();
        $where['mall_id'] = $arrgui['mall_id'];
        $where['guige'] = $_POST["xh_name"];
        $where['Integral'] = $_POST["g_jifen"];
        $where['item_id'] = $_GET["id"];
         $sup = M("suppliers");
        $add['shangcheng'] = $arrgui['mall_id'];
        $sup->where("item_id='{$_GET["id"]}'")->save($add);
//        $where['gh_money'] = $_POST['s_ghjg'];
//        $where['type'] = $_POST["xh_name"];
//        dump($where);
        $sql->save($where);
        $shangcheng = $sql->where("item_id='{$_GET['id']}'")->find();
        $tj = M("diaojia"); //连接调价表
        $dats['item_id'] =  $_GET["id"];
        $dats['shangcheng'] = $shangcheng['mall_id'];
        $dats['emony_x'] = $_POST['s_jiage'];
        $dats['smony_x'] = $_POST['g_jiage'];
        $dats['emony_y'] = $_POST['original_price1'];
        $dats['smony_y'] = $_POST['original_price2'];
        $dats['gh_money'] = $_POST['s_ghjg'];
        $dats['time'] = date("Y-m-d h:i:s",$time);
        $dats['user'] = $_COOKIE['ShopName'];
        $tj->add($dats);
        $futu = M("item_futu");      
                       if(!empty($_FILES['files1']['size'])){
                 $b=explode(".",$_FILES['files1']['name']);
             if(!in_array(end($b),$array)){
             }else{
                $file_name2=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                 move_uploaded_file($_FILES['files1']['tmp_name'],"Public/upload/$file_name2");              
             }
         }
         if($file_name2){
            $sees['futu_url'] = "/Public/upload/$file_name2";
            $futu->where("futu_id='{$_POST['ids'][0]}'")->save($sees);
         }
          if(!empty($_FILES['files2']['size'])){
                 $b=explode(".",$_FILES['files2']['name']);
             if(!in_array(end($b),$array)){
             }else{
                $file_name3=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                 move_uploaded_file($_FILES['files2']['tmp_name'],"Public/upload/$file_name3");              
             }
         }
         if($file_name3){
            $sees['futu_url'] = "/Public/upload/$file_name3";
            $futu->where("futu_id='{$_POST['ids'][1]}'")->save($sees);
         }
          if(!empty($_FILES['files3']['size'])){
                 $b=explode(".",$_FILES['files3']['name']);
             if(!in_array(end($b),$array)){
             }else{
                $file_name4=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                 move_uploaded_file($_FILES['files3']['tmp_name'],"Public/upload/$file_name4");              
             }
         }
         if($file_name4){
            $sees['futu_url'] = "/Public/upload/$file_name4";
            $futu->where("futu_id='{$_POST['ids'][2]}'")->save($sees);
         }
        if(!empty($_FILES['files4']['size'])){
                 $b=explode(".",$_FILES['files4']['name']);
             if(!in_array(end($b),$array)){
             }else{
                $file_name5=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                 move_uploaded_file($_FILES['files4']['tmp_name'],"Public/upload/$file_name5");              
             }
         }
         if($file_name5){
            $sees['futu_url'] = "/Public/upload/$file_name5";
            $futu->where("futu_id='{$_POST['ids'][3]}'")->save($sees);
         }
        $this->redirect("xj_shop");
    }
    
    //订单详情
    public function orderlist_cookie(){
        cookie("type",null);
        cookie("status",null);
        cookie("shop_id",null);
        cookie("shop_name",null);
        $this->redirect("orderlist");
    }
    
    
    
    public function orderlist_s(){
        if(!empty($_GET["orderlistpay_type"])){
            if($_GET["orderlistpay_type"]!=$_COOKIE["type"]){
                cookie("type",$_GET["orderlistpay_type"]);  
            }else{
                cookie("type",null);
            }
        }
        if(!empty($_GET["orderlist_status"])){
            if($_GET["orderlist_status"]!=$_COOKIE["status"]){
                 cookie("status",$_GET["orderlist_status"]);
            }else{
                 cookie("status",null);
            }
        }
        if(!empty($_GET["shop_id"])){
            cookie("shop_id",$_GET["shop_id"]);
            $m=M("flagship");
            $arr=$m->where("shop_id={$_GET["shop_id"]}")->find();
            cookie("shop_name",$arr["shop_name"]);
        }
        $this->redirect("orderlist");
    }
     public function orderlist_lines(){
        if(!empty($_GET["orderlist_status"])){
            if($_GET["orderlist_status"]!=$_COOKIE["status"]){
                 cookie("statusline",$_GET["orderlist_status"]);
            }else{
                 cookie("statusline",null);
            }
        }
        if(!empty($_GET["shop_id"])){
            cookie("shop_idline",$_GET["shop_id"]);
            $m=M("flagship");
            $arr=$m->where("shop_id={$_GET["shop_idline"]}")->find();
            cookie("shop_nameline",$arr["shop_name"]);
        }
        $this->redirect("orderlist_line");
    }
    //清除线上订单处理的搜索
    public function cookielines(){
         cookie("statusline",null);
          $this->redirect("orderlist_line");
    }
    public function orderlist(){

        if(!empty($_COOKIE["type"])){
            $where["type"]=$_COOKIE["type"];
        }
        if(!empty($_COOKIE["status"])){
            $where["status"]=$_COOKIE["status"];
        }
        if(!empty($_COOKIE["shop_id"])){
            $where["shop_id"]=$_COOKIE["shop_id"];
            $w["shop_id"]=array('neq',$_COOKIE["shop_id"]);
        }else{
//            $where["shop_id"]=1;
        }
             
        $m=M("uaccount_order");
        $uaccount_address=M("uaccount_address");
        $count = $m->table("uaccount,uaccount_order")->where($where)->where("uaccount.user_id=uaccount_order.user_id and uaccount_order.status!=1")->count();
        $p = getpage($count,8);
        $arr = $m->table("uaccount,uaccount_order")->where($where)->where("uaccount.user_id=uaccount_order.user_id and uaccount_order.status!=1")->limit($p->firstRow, $p->listRows)->order("uaccount_order.create_date desc")->field("uaccount.real_name,uaccount.tel,uaccount_order.*")->select();
        foreach($arr as $key=>$val){
            $address=$uaccount_address->where("address_id={$val["address_id"]}")->find();
            $arr[$key]["address_name"]=$address["address_details"];
            $arr[$key]["shouhuo_name"]=$address["address_people"];
            $arr[$key]["shouhuo_tel"]=$address["address_tel"];
            
        }
        
//        if($_COOKIE[""])
        $flagship=M("flagship");
//        $w['shop_id'] = 1;
        $shop_id=$flagship->where($w)->field("shop_id,shop_name")->select();
        $this->assign("shop_id",$shop_id);
        
        
        $this->assign('show', $p->show());
        $this->assign("arr",$arr);
        
        $this->display();
    }
    //线上订单处理
        public function orderlist_line(){
        if(!empty($_COOKIE["statusline"])){
            $where["status"]=$_COOKIE["statusline"];
        }
        if(!empty($_COOKIE["shop_idline"])){
            $where["shop_id"]=$_COOKIE["shop_idline"];
            $w["shop_id"]=array('neq',$_COOKIE["shop_idline"]);
        }else{
//            $where["shop_id"]=1;
        }
        $where['type']= 1;   
        $m=M("uaccount_order");
        $uaccount_address=M("uaccount_address");
        $count = $m->table("uaccount,uaccount_order")->where($where)->where("uaccount.user_id=uaccount_order.user_id and uaccount_order.status!=1")->count();
        $p = getpage($count,8);
        $arr = $m->table("uaccount,uaccount_order")->where($where)->where("uaccount.user_id=uaccount_order.user_id and uaccount_order.status!=1")->limit($p->firstRow, $p->listRows)->order("uaccount_order.create_date desc")->field("uaccount.real_name,uaccount.tel,uaccount_order.*")->select();
        foreach($arr as $key=>$val){
            $address=$uaccount_address->where("address_id={$val["address_id"]}")->find();
            $arr[$key]["address_name"]=$address["address_details"];
            $arr[$key]["shouhuo_name"]=$address["address_people"];
            $arr[$key]["shouhuo_tel"]=$address["address_tel"];
            
        }
        
//        if($_COOKIE[""])
        $flagship=M("flagship");
//        $w['shop_id'] = 1;
        $shop_id=$flagship->where($w)->field("shop_id,shop_name")->select();
        $this->assign("shop_id",$shop_id);
        
        
        $this->assign('show', $p->show());
        $this->assign("arr",$arr);
        
        $this->display();
    }
    public function orderlist_ajax(){
        $order_id=$_POST["value"];
        $orderlist_detail=M("uaccount_orderdetail");
        $item=$orderlist_detail->join("left join item on item.item_id=uaccount_orderdetail.item_id")->where("uaccount_orderdetail.order_id=$order_id")->field("uaccount_orderdetail.*,item.*")->select();
        echo json_encode($item);
    }
    //2016.12.15李景志修改
    public function orderlist_send(){
        date_default_timezone_set ("PRC");
        $time=time();
        $save["express_no"]=$_POST["number"];
        $save["order_id"]=$_POST["order_id"];
//        $save["status"]=3;
        $save["send_date"]=  date("Y-m-d h:i:s");
        $save["express"]=$_POST["express"];
        $save['shenhe'] = 1; 
        $m=M("uaccount_order");
        $m->save($save);
        $sh = M("review_order");  //连接订单审核表
        $add['order_id'] = $_POST['order_id'];
        $add['status'] = 0;
        $add["time"]=  date("Y-m-d h:i:s",$time);
        $sh->add($add);
        $sp = M("uaccount_orderdetail"); //连接具体订单商品表
        $arr = $sp->where("order_id='{$_POST['order_id']}'")->select();
        $sp = M("item"); //连接商品表
        $sps = $sp->select();//查询商品
        
        for ($a=0;$a<count($arr);$a++){
            for($i=0;$i<count($sps);$i++) {
                if($arr[$a]['item_id'] == $sps[$i]['item_id']) {
                    $arr[$a]['item_name'] = $sps[$i]['item_name'];
                    $arr[$a]['bar_code'] = $sps[$i]['bar_code'];
                    $arr[$a]['mall'] = $sps[$i]['mall_id'];
                    if($sps[$i]['mall_id'] == 1){
                        $arr[$a]['jia'] = $sps[$i]['sMoney'];
                    } else if($sps[$i]['mall_id'] == 2 || $sps[$i]['mall_id'] ==3){
                        $arr[$a]['jia'] = $sps[$i]['eMoney'];
                    }else{
                         $arr[$a]['jia'] = $sps[$i]['eMoney']+ $sps[$i]['sMoney'];
                    }
                }
            }
        }
        $dd = $m->where("order_id='{$_POST['order_id']}'")->find();
        $user = M("uaccount");
        $addr = M("uaccount_address"); //连接地址表
        $address = $addr->where("address_id='{$dd['address_id']}'")->find();
        $users = $user->where("user_id='{$dd['user_id']}'")->find();
        $dd['real_name']  = $users['real_name'];
        $dd['time'] = date("Y-m-d h:i:s",$time);
        $dd['tel'] = $users['tel'];
        $dd['address_name'] = $address['address_provinces'].$address['address_details'];
        $dd['shouhuo_name'] = $address['address_people'];
        $dd['shouhuo_tel'] = $address['address_tel'];
        $array= array($dd,$arr);
        echo json_encode($array);
    }
    
    
    
    
    //订单查看明细
    public function orderlist_detail(){
        
//        $uaccount_order=M("uaccount_order");
//        $information=$uaccount_order->join("left join uaccount_address on uaccount_order.user_id=uaccount_address.user_id")->join("left join uaccount on uaccount_order.user_id=uaccount.user_id")->where("uaccount_address.status=1 and uaccount_order.order_id={$_GET["order_id"]}")->find();
//        $this->assign("information",$information);
//        
//        $orderlist_detail=M("uaccount_orderdetail");
//        $item=$orderlist_detail->join("left join item on item.item_id=uaccount_orderdetail.item_id")->where("uaccount_orderdetail.order_id={$_GET["order_id"]}")->field("uaccount_orderdetail.*,item.item_name")->select();
//        $this->assign("item",$item);
//        foreach ($item as $val){
//            $total["number"]+=$val["quantity"];
//            $total["price"]+=$val["quantity"]*$val["price"];           
//        }
//        $this->assign("total",$total);
//        $this->display();
    }

    
    //bug
    public function  shouyin_ajax (){
        $str=file_get_contents('php://input', 'r');
        $v=json_decode($str);
        $m=D("vitem");
        $bar_code=$v->itemname;
        $where["bar_code"]=$bar_code;
        $where["item_name"]=$bar_code;
        $where["_logic"] ="or";
        $arr=$m->where($where)->find();
        echo json_encode($arr);
    }
    public function shouyin_cookie(){
        $str=file_get_contents('php://input', 'r');
        $v=json_decode($str);
        cookie("item_id",$v->item_id);
        cookie("quantity",$v->quantity);
        echo 1;
        
    }
    public function shouyin(){
        if($_COOKIE['fanhui']){
            $m=D("vitem");
            $item_id= array_filter(explode(",", $_COOKIE["item_id"])); 
            $quantity= array_filter(explode(",",$_COOKIE["quantity"])); 
            for($i=0;$i<count($item_id);$i++){
                $arr[]=$m->where("item_id=$item_id[$i]")->find();
                $arr[$i]["quantity"]=$quantity[$i];           
            }
            $this->assign("item",$arr);
        }else{
            cookie("item_id",null);
            cookie("quantity",null);
        }
        $this->display();
    }
    
    //支付页面
    public function shouyin_user(){
        date_default_timezone_set ("PRC");
        $time=time();
        $m=D("vitem");
        $item_id= array_filter(explode(",", $_COOKIE["item_id"])); 
        $quantity= array_filter(explode(",",$_COOKIE["quantity"])); 
        for($i=0;$i<count($item_id);$i++){
            $arr[]=$m->where("item_id=$item_id[$i]")->find();
            if($arr[$i]['mall_id'] == 4){
                $arr[$i]["Money"] = intval($arr[$i]['sMoney']) + intval($arr[$i]['eMoney']);
                $arr[$i]['data-type'] = 3;
            }else{
                if($arr[$i]["eMoney"]==0){
                  $arr[$i]["Money"]= $arr[$i]["sMoney"];
                  $arr[$i]["data-type"]= 2;
                }else{
                    $arr[$i]["Money"]= $arr[$i]["eMoney"];
                    $arr[$i]["data-type"]= 1;
                }  
            }
            $arr[$i]["quantity"]=$quantity[$i];           
        }
//        dump($_COOKIE);
        foreach ($arr as $val){
            switch ($val["data-type"]){
                case 1:$toal_price["eMoney"]+=$val["eMoney"]*$val["quantity"];break;
                case 2:$toal_price["sMoney"]+=$val["sMoney"]*$val["quantity"];break;
                case 3:$toal_price["sMoney"]+=$val["sMoney"]*$val["quantity"];$toal_price["eMoney"]+=$val["eMoney"]*$val["quantity"];break;
                case 4:$toal_price["sMoney"]+=$val["sMoney"]*$val["quantity"];$toal_price["eMoney"]+=$val["eMoney"]*$val["quantity"];break;
            }
           $toal_price["integral"]+=$val["integral"]*$val["quantity"];
           
        }
        foreach ($arr as $val){
            switch ($val["mall_id"]){
                case 1:$array["chuangye"][]=$val;break;
                case 2:$array["dazhong"][]=$val;break;
                case 4:$array["nianhuo"][]=$val;break;
            }
        }
        $admin_register=M("admin_register");
        $shop_name=$admin_register->join("left join flagship on admin_register.fiagshop=flagship.shop_id")->field("flagship.shop_name")->where("admin_register.username='{$_COOKIE["ShopName"]}'")->find();
//        dump($_COOKIE);
//        dump($shop_name);
//        dump($_COOKIE);
        $this->assign("shop_name",$shop_name["shop_name"]);
        $time_now=date("Y.m.d h:i:s",$time);
        $this->assign("time_now",$time_now);
        $this->assign("toal_price",$toal_price);
        $this->assign("arr",$arr);
        $this->assign("array",$array);
        $this->display();
    }
    
    //验证手机号
    public function shouyin_usetel(){
        $m=M("uaccount");
        $str=file_get_contents('php://input', 'r');
        $v=json_decode($str);
        $tel=$v->tel;
        $arr=$m->where("change_tel=$tel")->find();
        if($arr){
            echo json_encode($arr);
        }else{
            echo 1; 
        }
    }
    //验证支付密码
    public function shouyin_usepwd(){
        $m=M("uaccount");
        $str=file_get_contents('php://input', 'r');
        $v=json_decode($str);
        $tel=$v->tel;
        $pwd=$v->pwd;
        $pwd=md5(md5($pwd));
        $arr=$m->where("change_tel='$tel' and security_pwd='$pwd'")->select();
        if($arr){
            echo 2;
        }else{
             echo 1;
        }       
    }
    //验证是否有钱
    public function shouyin_money(){
        $str=file_get_contents('php://input', 'r');
        $v=json_decode($str);
        $emoney=$v->eMoney;
        $smoney=$v->sMoney;
        $integral=$v->integral;
        $jiancaibi=$v->jiancaibi;
        $tel=$v->tel;
        $m=M("uaccount");
        $arr=$m->where("change_tel=$tel")->find();
   
        if($arr["emoney"]>=$emoney&&$arr["smoney"]>=$smoney){
            
            $save["user_id"]=$arr["user_id"];
            $save["emoney"]=$arr["emoney"]-$emoney;
            $save["smoney"]=$arr["smoney"]-$smoney;
//            $save["jiancaibi"]=$arr["jiancaibi"]-$jiancaibi;
            $save["integral"]=$arr["integral"]+$integral;
            $m->save($save);
//          
            $ids =$this->orderlist_emoney($arr["user_id"],$emoney,$smoney,$integral);
            $etime = date("Y-m-d",strtotime("+1 week"));
            $array = array($ids,$etime);
            echo json_encode($array);
        }else{
            echo 1;
        }
    }
    //生成订单
    public function orderlist_emoney($user_id,$emoney,$smoney,$integral){   
        date_default_timezone_set ("PRC");
        $time=time();
                $uaccount_order=M("uaccount_order");
                 $register=M("admin_register");
                 $admin_register=$register->where("username='{$_COOKIE["ShopName"]}'")->find();
//                 echo $register->getLastSql();
                $add["user_id"]=$user_id;       
                $add["total_price"]=$emoney+$smoney;
                $add["status"]=3;
                $add["integral"]=$integral;
                $add["emenoy"]=$emoney;
                $add["smenoy"]=$smoney;
                $add["type"]=2;
                $add["shop_id"]=$admin_register["fiagshop"];
                $add["order_no"]=date("YmdHis").rand(1000,9999);
                $add["pay_date"]=date("Y-m-d H:i:s",$time);
                $add['shenhe'] = 2;
                $order_id=$uaccount_order->add($add);
                $arrs = $uaccount_order->where("order_id='$order_id'")->find();
                $caozuo = M("operation"); //连接日志表
                $ca['username'] = $_COOKIE['ShopName'];
                $ca['time'] = date("Y-m-d h:i:s",$time);
                $ca['details'] = "生成订单，订单号为".$arrs['order_no']."(线下)";
               $caozuo->add($ca);
            
        $m=D("vitem");
        $item_id= array_filter(explode(",", $_COOKIE["item_id"])); 
        $quantity= array_filter(explode(",",$_COOKIE["quantity"])); 
        for($i=0;$i<count($item_id);$i++){
            $array[]=$m->where("item_id=$item_id[$i]")->find();
            $array[$i]["quantity"]=$quantity[$i];    
        }        
                foreach ($array as $key=>$val){
                    $uaccount_orderdetail=M("uaccount_orderdetail");
                    $ad["item_id"]=$val["item_id"];
                    $ad["quantity"]=$val["quantity"];
                    $ad["price"]=$val["sMoney"]+$val["eMoney"];
                    $ad["order_id"]=$order_id;
                    $ad['created_date'] = date("Y-m-d h:i:s",$time);
                    $uaccount_orderdetail->add($ad);
                    $a =$this->shouyin_item($val["item_id"],$val["quantity"],$arrs['user_id']);
//                    dump($a);
             }
        return $arrs['order_no'];
    }
    public function shouyin_item($item_id,$quantity,$danhao){
        
        $m=M("item");
        $arr=$m->where("item_id=$item_id")->find();
        $save["number"]=$arr["number"]-$quantity;
        $save['rale'] = $arr['rale'] + $quantity;
        $save["item_id"]=$item_id;
        $m->save($save);
        //减少库存
        $sql = M("inventory");
        $where['item_id'] = $item_id;
        $where['inventory_new'] = $quantity;
        date_default_timezone_set ("PRC");
        $time=time();
        $data=date("Y-m-d H:i:s",$time);
        $where['created_date'] = $data;
        $where['inventory_use'] = $_COOKIE['ShopName'];
        $u = M("admin_register");
        $user = $u->where("username='{$_COOKIE['ShopName']}'")->find();
        $find = $sql->where("item_id={$item_id} and type = 1 and flag_id={$user['fiagshop']}")->find();
        $where['flag_id'] = $user['fiagshop'];
        $where['status'] = 3;
        $where['sy_num'] = $find['sy_num'] - $quantity;
        
        $where['shangcheng'] = $arr['mall_id'];
        $where['user_id'] = $danhao;
        $where['type'] = 1;
        $where['shenhe'] = 1;
        $upt['type'] = 0;
        $sql->where("inventory_id={$find['inventory_id']}")->save($upt);
        $sql->add($where);
        
       
        
    }
     public function ddgl(){
          $this->display();
     }
     
     //商品库存 2016.12.15李景志改动
     public function inventory(){
        $m=M("inventory"); 
        $qjd = M("flagship"); //连接旗舰店的表
        $qd = $qjd->select(); //查询旗舰店
         $datw['shenhe'] = 1;
        if($_COOKIE['qxfenpei'] == '0'){
            
        }else{
            $datw['flag_id'] = $_COOKIE['qxfenpei'];
        }   
        if(!empty($_COOKIE['kuncus'])){
            $datw['sy_num'] = array("elt",0);
        }
        $count = $m->where($datw)->count();
        $p = getpage($count,10);
        $mall = M("item_mall");
        $mall_id = $mall->select();
        $sp = M("item"); //连接商品表
        $sprow = $sp->select();
        $datw['shenhe'] = 1;
        if($_COOKIE['qxfenpei'] == '0'){
            
        }else{
            $datw['flag_id'] = $_COOKIE['qxfenpei'];
        }
        $users = M("uaccount");
        $yonghu = $users->select();
        $arr = $m->where($datw)->limit($p->firstRow, $p->listRows)->order("shangcheng ,created_date desc")->select();
//        dump($datw);
        //不带分页的查询为了导出exal
        $arrhidd = $m->where($datw)->order("shangcheng ,created_date desc")->select();
        for($i=0;$i<count($arr);$i++) {   //根据对应的旗舰店id去查询旗舰店名字
            for($z=0;$z<count($qd);$z++) {
                if($arr[$i]['flag_id'] == $qd[$z]['shop_id']){
                    $arr[$i]['qijiand'] = $qd[$z]['shop_name'];
                }
            for($q=0;$q<count($mall_id);$q++) {
                if($arr[$i]['shangcheng'] == $mall_id[$q]['mall_id']) {
                    $arr[$i]['scname'] = $mall_id[$q]['mall_name'];
                }
            }    
            }
             for($w=0;$w<count($sprow);$w++) {
                if($arr[$i]['item_id'] == $sprow[$w]['item_id']) {
                   
                    $arr[$i]['item_name'] = $sprow[$w]['item_name'];
                    $arr[$i]['bar_code'] = $sprow[$w]['bar_code'];
                }
            }   
             for($k=0;$k<count($yonghu);$k++) {
                if($arr[$i]['user_id'] == $yonghu[$k]['user_id']) {
                    $arr[$i]['real_name'] = $yonghu[$k]['real_name'];
                }
            }   
              $arr[$i]['xuhao'] = $i+1;
        }
        
         for($i=0;$i<count($arrhidd);$i++) {   //根据对应的旗舰店id去查询旗舰店名字
            for($z=0;$z<count($qd);$z++) {
                if($arrhidd[$i]['flag_id'] == $qd[$z]['shop_id']){
                    $arrhidd[$i]['qijiand'] = $qd[$z]['shop_name'];
                }
            for($q=0;$q<count($mall_id);$q++) {
                if($arrhidd[$i]['shangcheng'] == $mall_id[$q]['mall_id']) {
                    $arrhidd[$i]['scname'] = $mall_id[$q]['mall_name'];
                }
            }    
            }
             for($w=0;$w<count($sprow);$w++) {
                if($arrhidd[$i]['item_id'] == $sprow[$w]['item_id']) {
                    $arrhidd[$i]['item_name'] = $sprow[$w]['item_name'];
                    $arrhidd[$i]['bar_code'] = $sprow[$w]['bar_code'];
                }
            }   
            for($k=0;$k<count($yonghu);$k++) {
                if($arrhidd[$i]['user_id'] == $yonghu[$k]['user_id']) {
                    $arrhidd[$i]['real_name'] = $yonghu[$k]['real_name'];
                }
            }
            $arrhidd[$i]['xuhao'] = $i+1;
        }
        //查询type=1的最新商品库存表
        if($_COOKIE['qxfenpei'] == '0'){
            
        }else{
           $dats['flag_id'] = $_COOKIE['qxfenpei'];
        }
        $dats['type'] = 1;
        $dats['shenhe'] = 1;
        
        $xin = $m->where($dats)->select();
         for($i=0;$i<count($xin);$i++) {   //根据对应的旗舰店id去查询旗舰店名字
            for($z=0;$z<count($qd);$z++) {
                if($xin[$i]['flag_id'] == $qd[$z]['shop_id']){
                    $xin[$i]['qijiand'] = $qd[$z]['shop_name'];
                }
            for($q=0;$q<count($mall_id);$q++) {
                if($xin[$i]['shangcheng'] == $mall_id[$q]['mall_id']) {
                    $xin[$i]['scname'] = $mall_id[$q]['mall_name'];
                }
            }    
            }
              for($w=0;$w<count($sprow);$w++) {
                if($xin[$i]['item_id'] == $sprow[$w]['item_id']) {
                    $xin[$i]['spname'] = $sprow[$w]['item_name'];
                    $xin[$i]['code'] = $sprow[$w]['bar_code'];
                }
            }   
             for($k=0;$k<count($yonghu);$k++) {
                if($xin[$i]['user_id'] == $yonghu[$k]['user_id']) {
                    $xin[$i]['real_name'] = $yonghu[$k]['real_name'];
                }
            }
              $xin[$i]['xuhao'] = $i+1;
        }
        $this->assign("pandian",$xin);
        $this->assign("hiddenarr",$arrhidd);
        $this->assign("arr",$arr);
        $this->assign('show', $p->show());
        $this->assign("qd",$qd);
        $this->assign("shangcheng",$mall_id);
        $this->display();
        

     }
       //入库申请 2016.12.15李景志改动
     public function rukusq(){
        $m=M("inventory"); 
        $qjd = M("flagship"); //连接旗舰店的表
        $qd = $qjd->select(); //查询旗舰店
        $dats['status'] = 0;
        if($_COOKIE['qxfenpei'] == 0){
            
        }else{
            $dats['flag_id'] = $_COOKIE['qxfenpei'];
        }
        $count = $m->where($dats)->count();
        $p = getpage($count,10);
        $mall = M("item_mall");
        $mall_id = $mall->select();
        $arr = $m->where($dats)->limit($p->firstRow, $p->listRows)->order("sqtime desc")->select();
       $sp = M("item"); //连接商品表
       $sprow = $sp->select();
        for($i=0;$i<count($arr);$i++) {   //根据对应的旗舰店id去查询旗舰店名字
            for($z=0;$z<count($qd);$z++) {
                if($arr[$i]['flag_id'] == $qd[$z]['shop_id']){
                    $arr[$i]['qijiand'] = $qd[$z]['shop_name'];
                }
            for($q=0;$q<count($mall_id);$q++) {
                if($arr[$i]['shangcheng'] == $mall_id[$q]['mall_id']) {
                    $arr[$i]['scname'] = $mall_id[$q]['mall_name'];
                }
            }    
            }
            for($w=0;$w<count($sprow);$w++) {
                if($arr[$i]['item_id'] == $sprow[$w]['item_id']) {
                    $arr[$i]['item_name'] = $sprow[$w]['item_name'];
                    $arr[$i]['bar_code'] = $sprow[$w]['bar_code'];
                }
            }   
              $arr[$i]['xuhao'] = $i+1;
        } 
        
        $this->assign("arr",$arr);
        $this->assign('show', $p->show());
//        dump($arr);
        $this->assign("qd",$qd);
        $this->assign("shangcheng",$mall_id);
        $this->display();

     }
     
     public function PrintSample11(){
           $this->display();

     }
       //多图上传
    public function testUp(){
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
 
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit; // finish preflight CORS requests here
        }
        if ( !empty($_REQUEST[ 'debug' ]) ) {
            $random = rand(0, intval($_REQUEST[ 'debug' ]) );
            if ( $random === 0 ) {
                header("HTTP/1.0 500 Internal Server Error");
                exit;
            }
        }
 
        // header("HTTP/1.0 500 Internal Server Error");
        // exit;
        // 5 minutes execution time
        @set_time_limit(5 * 60);
        // Uncomment this one to fake upload time
         usleep(5000);
        // Settings
        // $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
//        $targetDir = 'uploads'.DIRECTORY_SEPARATOR.'file_material_tmp';
        $targetDir = './Public'.DIRECTORY_SEPARATOR.'file_material_tmp';
//        $uploadDir = 'uploads'.DIRECTORY_SEPARATOR.'file_material'.DIRECTORY_SEPARATOR.date('Ymd');
        $uploadDir = './Public'.DIRECTORY_SEPARATOR.'file_material'.DIRECTORY_SEPARATOR.'upload';
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds
 
        // Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir,0777,true);
        }
        // Create target dir
        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir,0777,true);
        }
        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }
 
        $oldName = $fileName;
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        // $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
        // Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;
        // Remove old temp files
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory111."}, "id" : "id"}');
            }
            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                    continue;
                }
                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }
 
        // Open temp file
        if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream222."}, "id" : "id"}');
        }
 
        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file333."}, "id" : "id"}');
            }
            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream444."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream555."}, "id" : "id"}');
            }
        }
        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }
        @fclose($out);
        @fclose($in);
        rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");
        $index = 0;
        $done = true;
        for( $index = 0; $index < $chunks; $index++ ) {
            if ( !file_exists("{$filePath}_{$index}.part") ) {
                $done = false;
                break;
            }
        }
 
 
 
        if ( $done ) {
            $pathInfo = pathinfo($fileName);
            $hashStr = substr(md5($pathInfo['basename']),8,16);
            $hashName = time() . $hashStr . '.' .$pathInfo['extension'];
            $uploadPath = $uploadDir . DIRECTORY_SEPARATOR .$hashName;
 
            if (!$out = @fopen($uploadPath, "wb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream666."}, "id" : "id"}');
            }
            if ( flock($out, LOCK_EX) ) {
                for( $index = 0; $index < $chunks; $index++ ) {
                    if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                        break;
                    }
                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }
                    @fclose($in);
                    @unlink("{$filePath}_{$index}.part");
                }
                flock($out, LOCK_UN);
            }
            @fclose($out);
            $response = [
                'success'=>true,
                'oldName'=>$oldName,
                'filePath'=>$uploadPath,
//                'fileSize'=>$data['size'],
                'fileSuffixes'=>$pathInfo['extension'],
//                'file_id'=>$data['id'],
            ];
 
            die(json_encode($response));
        }
 
        // Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }
    //banner区域图片上传
    public function addbanner(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $array=array("jpg","gif","png","JPG","JPEG");
            if(!empty($_FILES['images']['size'])){
                $b=explode(".",$_FILES['images']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['images']['tmp_name'],"Public/phone_banner/$file_name");
                }
            }
            if(!empty($file_name)){
//                $where['images_url'] = "/Public/phone_banner/$file_name";
                $where['images_url'] = "/Public/phone_banner/$file_name";
                $where['status'] = 1;
                $m->add($where);
            }
            
            if(!empty($_FILES['upt_files']['size'])){
                $b=explode(".",$_FILES['upt_files']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name2=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['upt_files']['tmp_name'],"Public/phone_banner/$file_name2");
                }
            }
            if($file_name2){
//                $upt['images_url'] = "/Public/phone_banner/$file_name2";
                $upt['images_url'] = "/Public/phone_banner/$file_name2";
            }
            if(!empty($_POST['banner_id'])){
                $m->where("banner_id={$_POST['banner_id']}")->save($upt);
            }
            $this->redirect("phone_banner");
        }
    }
     //商城小图片上传
    public function addbanner_shangcheng(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $array=array("jpg","gif","png","JPG","JPEG");
            if(!empty($_FILES['images']['size'])){
                $b=explode(".",$_FILES['images']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['images']['tmp_name'],"Public/phone_banner/$file_name");
                }
            }
            if(!empty($file_name)){
//                $where['images_url'] = "/Public/phone_banner/$file_name";
                $where['images_url'] = "/Public/phone_banner/$file_name";
                $where['status'] = 7;
                $m->add($where);
            }
            
            if(!empty($_FILES['upt_files']['size'])){
                $b=explode(".",$_FILES['upt_files']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name2=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['upt_files']['tmp_name'],"Public/phone_banner/$file_name2");
                }
            }
            if($file_name2){
//                $upt['images_url'] = "/Public/phone_banner/$file_name2";
                $upt['images_url'] = "/Public/phone_banner/$file_name2";
            }
            if(!empty($_POST['banner_id'])){
                $m->where("banner_id={$_POST['banner_id']}")->save($upt);
            }
            $this->redirect("shangcheng_tu");
        }
    }
        //手机首页banner区域图片上传
    public function addbanner_shouji(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $array=array("jpg","gif","png","JPG","JPEG");
            if(!empty($_FILES['images']['size'])){
                $b=explode(".",$_FILES['images']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['images']['tmp_name'],"Public/phone_banner/$file_name");
                }
            }
            if(!empty($file_name)){
//                $where['images_url'] = "/Public/phone_banner/$file_name";
                $where['images_url'] = "/Public/phone_banner/$file_name";
                $where['status'] = 5;
                $m->add($where);
            }
            
            if(!empty($_FILES['upt_files']['size'])){
                $b=explode(".",$_FILES['upt_files']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name2=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['upt_files']['tmp_name'],"Public/phone_banner/$file_name2");
                }
            }
            if($file_name2){
//                $upt['images_url'] = "/Public/phone_banner/$file_name2";
                $upt['images_url'] = "/Public/phone_banner/$file_name2";
            }
            if(!empty($_POST['banner_id'])){
                $m->where("banner_id={$_POST['banner_id']}")->save($upt);
            }
            $this->redirect("sphone_bannerss");
        }
    }
    //phone_banner页
    public function phone_banner(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $data['status'] = 1;
            $arr = $m->where($data)->select();
            $this->assign("images",$arr);
            $this->display();
        }
    }
    //手机首页banner图
    public function sphone_bannerss(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $data['status'] = 5;
            $arr = $m->where($data)->select();
            $this->assign("images",$arr);
            $this->display();
        }
    }
      //pc商城小图片
    public function shangcheng_tu(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $data['status'] = 7;
            $arr = $m->where($data)->select();
            $this->assign("images",$arr);
            $this->display();
        }
    }
    //删除banner
    public function phone_banner_del(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $id = $_GET['id'];
            $m->where("banner_id=$id")->delete();
            $this->redirect("phone_banner");
        }
    }
    //新增商城新闻
    public function addshop_new(){
        if($_COOKIE['ShopName']){
            $m = M("new");
            $where['title'] = $_POST['biaoti'];
            $where['content'] = $_POST['content'];
            date_default_timezone_set ("PRC");
            $time=time();
            $data=date("Y-m-d",$time);
            $where['time'] = $data;
            $where['status'] = 1;
            $m->add($where);
            $this->redirect("shop_new");
        }
    }
     public function addshop_new2(){
        if($_COOKIE['ShopName']){
            $m = M("new");
            $where['title'] = $_POST['biaoti'];
            $where['content'] = $_POST['content'];
            date_default_timezone_set ("PRC");
            $time=time();
            $data=date("Y-m-d",$time);
            $where['time'] = $data;
            $where['status'] = 4;
            $m->add($where);
            $this->redirect("shop_dc");
        }
    }
    //shop_new页面
    public function shop_new(){
        if($_COOKIE['ShopName']){
            $m = M("new");
            $arr = $m->where("status=1")->select();
            $this->assign("centent",$arr);
            $this->display();
        }
    }
    //phone首页弹层维护
    public function shop_dc() {
         if($_COOKIE['ShopName']){
            $m = M("new");
            $arr = $m->where("status=4")->select();
            $sql = M("tanceng");
            $find = $sql->where("id = 1")->find();
            $this->assign("handle",$find);
            $this->assign("centent",$arr);
            $this->display();
        }
        
    }
    //开启弹层
    public function tanceng_on(){
        $sql = M('tanceng');
        $where['handle'] = "block";
        $find = $sql->where("id = 1")->save($where);
        if($find){
            echo 1;
        }else{
            echo 2;
        }
    }
    //关闭弹层
    public function tanceng_off(){
       $sql = M('tanceng');
        $where['handle'] = "none";
        $find = $sql->where("id = 1")->save($where);
        if($find){
            echo 1;
        }else{
            echo 2;
        } 
    }
    //删除商城新闻
    public function delshop_new(){
        if($_COOKIE['ShopName']){
            $m = M("new");
            $id = $_POST['new_id'];
            $m->where("new_id={$id}")->delete();
            $this->redirect("shop_new");
        }
    }
    public function shop_dc_del(){
        if($_COOKIE['ShopName']){
            $m = M("new");
            $id = $_GET['id'];
            $m->where("new_id={$id}")->delete();
            $this->redirect("shop_dc");
        }
    }
    //修改密码
    public function passselect(){
        $pass = md5(md5($_POST['pass']));
        $sql = M("admin_register");
        $arr = $sql->select();
        foreach($arr as $val){
            if($_COOKIE['ShopName']==$val['username']){
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
            if($_COOKIE['ShopName']==$val['username']){
                $where['password'] = $pass;
                $sql->where("id={$val['id']}")->save($where);
                echo "修改成功";
            }
        }
    }
    public function new_list() {
         if($_COOKIE['ShopName']){
            $m = M("new");
            $list = $m->where("status=0")->select();
            $this->assign('list',$list);
            $this->display(); 
         }
     }
      public function new_list2() {
         if($_COOKIE['ShopName']){
            $m = M("new");
            $list = $m->where("status=0")->select();
            $this->assign('list',$list);
            $this->display(); 
         }
     }
     //新闻新增
     public function add_new() {
         if($_COOKIE['ShopName']){
            $this->display();
         }
     }
     //提交新增的新闻内容
     public function add_newedit() {
         if($_COOKIE['ShopName']){
            $m = M("new");
            $data['title'] = $_POST['title'];
            $data['content'] = $_POST['content'];
            $data['status'] = 0;
            date_default_timezone_set ("PRC");
            $time=time();
            $times = date("Y-m-d",$time);
            $data['time'] = $times;
            $row = $m->add($data);
            $this->redirect("new_list");
         }
     }
     //修改新闻页面
     public function save_new() {
         if($_COOKIE['ShopName']){
            $m =M("new");
            $row = $m->where("new_id='{$_GET['id']}'")->find();
            $this->assign('row',$row);
            $this->display();
         }
     }
     //修改新闻的值
     public function save_newedit() {
         if($_COOKIE['ShopName']){
            $m = M("new");
            $data['title'] = $_POST['title'];
            $data['content'] = $_POST['content'];
            $data['status'] = 0;
            date_default_timezone_set ("PRC");
            $time=time();
            $times = date("Y-m-d",$time);
            $data['time'] = $times;
            $row = $m->where("new_id='{$_GET['id']}'")->save($data);
            $this->redirect("new_list");
         }
     }
     //删除新闻
     public function delete_new() {
         if($_COOKIE['ShopName']){
            $m = M("new");
            $row = $m->where("new_id='{$_GET['id']}'")->delete();
            $this->redirect("new_list");
         }
     }
     //新闻详情
     public function new_xx() {
         if($_COOKIE['ShopName']){
            $m = M("new");
            $row = $m->where("new_id='{$_GET['id']}'")->find();
            $this->assign("row",$row);
            $this->display();
         }
     }
     
     //banner区域图片上传
    public function addbanners(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $array=array("jpg","gif","png","JPG","JPEG");
            if(!empty($_FILES['images']['size'])){
                $b=explode(".",$_FILES['images']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['images']['tmp_name'],"Public/phone_banner/$file_name");
                }
            }
            if(!empty($file_name)){
//                $where['images_url'] = "/Public/phone_banner/$file_name";
                $where['images_url'] = "/Public/phone_banner/$file_name";
                $where['status'] = 0;
                $m->add($where);
            }
            if(!empty($_FILES['upt_files']['size'])){
                $b=explode(".",$_FILES['upt_files']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name2=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['upt_files']['tmp_name'],"Public/phone_banner/$file_name2");
                }
            }
            if($file_name2){
//                $upt['images_url'] = "/Public/phone_banner/$file_name2";
                $upt['images_url'] = "/Public/phone_banner/$file_name2";
            }
            if(!empty($_POST['banner_id'])){
                $m->where("banner_id={$_POST['banner_id']}")->save($upt);
            }
            $this->redirect("phone_banners");
        }
    }
    //pc商城增加banner图
     public function addbannerss(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $array=array("jpg","gif","png","JPG","JPEG");
            if(!empty($_FILES['images']['size'])){
                $b=explode(".",$_FILES['images']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['images']['tmp_name'],"Public/phone_banner/$file_name");
                }
            }
            if(!empty($file_name)){
//                $where['images_url'] = "/Public/phone_banner/$file_name";
                $where['images_url'] = "/Public/phone_banner/$file_name";
                $where['status'] = 3;
                $m->add($where);
            }
            if(!empty($_FILES['upt_files']['size'])){
                $b=explode(".",$_FILES['upt_files']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name2=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['upt_files']['tmp_name'],"Public/phone_banner/$file_name2");
                }
            }
            if($file_name2){
//                $upt['images_url'] = "/Public/phone_banner/$file_name2";
                $upt['images_url'] = "/Public/phone_banner/$file_name2";
            }
            if(!empty($_POST['banner_id'])){
                $m->where("banner_id={$_POST['banner_id']}")->save($upt);
            }
            $this->redirect("phone_bannerss");
        }
    }
    //phone_banner页
    public function phone_banners(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $arr = $m->where("status=0")->select();
            $this->assign("images",$arr);
            $this->display();
        }
    }
    //PCphone_banner页
    public function phone_bannerss(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $arr = $m->where("status=3")->select();
            $this->assign("images",$arr);
            $this->display();
        }
    }
    //删除banner
    public function phone_banner_dels(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $id = $_GET['id'];
            $m->where("banner_id=$id")->delete();
            $this->redirect("phone_banners");
        }
    }
     //删除banner
    public function sphone_banner_dels(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $id = $_GET['id'];
            $m->where("banner_id=$id")->delete();
            $this->redirect("sphone_bannerss");
        }
    }
    //商城小图片删除
    public function shangcheng_tu_del() {
          if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $id = $_GET['id'];
            $m->where("banner_id=$id")->delete();
            $this->redirect("shangcheng_tu");
        }
    }
     //删除banner
    public function phone_banner_delss(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $id = $_GET['id'];
            $m->where("banner_id=$id")->delete();
            $this->redirect("phone_bannerss");
        }
    }
    //推荐图片页面
    public function phone_goom() {
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $arr = $m->where("status=2")->select();
            $this->assign("images",$arr);
            $this->display();
        }
    }
        //删除推荐图片
    public function phone_goom_del(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $id = $_GET['id'];
            $m->where("banner_id=$id")->delete();
            $this->redirect("phone_banner");
        }
    }
         //banner区域图片上传
    public function addgoom(){
        if($_COOKIE['ShopName']){
            $m = M("phone_banner");
            $array=array("jpg","gif","png","JPG","JPEG");
            if(!empty($_FILES['images']['size'])){
                $b=explode(".",$_FILES['images']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['images']['tmp_name'],"Public/phone_banner/$file_name");
                }
            }
            if(!empty($file_name)){
//                $where['images_url'] = "/Public/phone_banner/$file_name";
                $where['images_url'] = "/Public/phone_banner/$file_name";
                $where['status'] = 2;
                $m->add($where);
            }
            if(!empty($_FILES['upt_files']['size'])){
                $b=explode(".",$_FILES['upt_files']['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name2=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES['upt_files']['tmp_name'],"Public/phone_banner/$file_name2");
                }
            }
            if($file_name2){
//                $upt['images_url'] = "/Public/phone_banner/$file_name2";
                $upt['images_url'] = "/Public/phone_banner/$file_name2";
            }
            if(!empty($_POST['banner_id'])){
                $m->where("banner_id={$_POST['banner_id']}")->save($upt);
            }
            $this->redirect("phone_goom");
        }
    }
    //2016.12.15李景志修改
    public function seach_kc() {
            $m = M("item"); //连接商品表
            $name = $_POST['name']; //搜索的产品名字
            $code =$_POST['code'];  //搜索的条形码
            $sname['item_name'] = array("like","%$name%");  // 后台传过来的搜索产品名字
            $sname['bar_code'] = array("like","%$code%");  // 后台传过来的搜索产品名字
            $row = $m->where($sname)->field("item_id")->select(); //查询这些数据
            $int = M("inventory");
            $users = M("uaccount");
            $yonghu = $users->select();
            if($_POST['qjd'] == 'ad') {
                if($_COOKIE['qxfenpei'] == 0){
                    
                }else{
                     $where['flag_id'] =$_COOKIE['qxfenpei'];    
                    $pd['flag_id'] = $_COOKIE['qxfenpei'];    
                }
            } else {
                $where['flag_id'] = $_POST['qjd'];    
                $pd['flag_id'] = $_POST['qjd'];    
                
            }
            if($_POST['sc'] == 'sc'){
                
            }else {
                $where['shangcheng'] = $_POST['sc']; //商城搜索
                $pd['shangcheng'] = $_POST['sc']; //商城搜索
            }
            foreach ($row as $val) {
                foreach ($val as $v) {
                    $a[]= $v;
                }
            }
            $where['item_id'] = array("in",$a);
            $pd['item_id'] = array("in",$a);
            if($_POST['dz'] == 5) {
                
            }else {
                $where['status'] = $_POST['dz'];
                $pd['status'] = $_POST['dz'];
            }
            $pd['type'] = 1;
            $pd['shenhe'] = 1;
            $where['shenhe'] = 1;
            $list = $int->where($where)->order("shangcheng ,created_date desc")->select(); //搜索出来的库存数据
            $pdrow = $int->where($pd)->order("shangcheng ,created_date desc")->select(); //搜索出来的盘点库存数据
           
            $flag = M("flagship");
            $fl = $flag->select();
            $mall = M("item_mall");
            $mall_id = $mall->select(); //查询所有的商城
            
            for($a=0;$a<count($list);$a++){
                for($i=0;$i<count($fl);$i++) {
                    if($list[$a]['flag_id'] == $fl[$i]['shop_id']) {
                        $list[$a]['qjdname'] = $fl[$i]['shop_name'];
                    }
                }
                 for($q=0;$q<count($mall_id);$q++) {
                    if($list[$a]['shangcheng'] == $mall_id[$q]['mall_id']) {
                        $list[$a]['scname'] = $mall_id[$q]['mall_name'];
                    }
                }
                $z[] = $list[$a]['item_id'];
            }
            
            $data['item_id'] = array("in",$z);
            $rows = $m->where($data)->select();
            
           for($a=0;$a<count($list);$a++){
                for($i=0;$i<count($rows);$i++) {
                    if($list[$a]['item_id'] == $rows[$i]['item_id']) {
                        $list[$a]['name'] = $rows[$i]['item_name'];
                        $list[$a]['code'] = $rows[$i]['bar_code'];
                    }
                }  
                 for($k=0;$k<count($yonghu);$k++) {
                    if($list[$a]['user_id'] == $yonghu[$k]['user_id']) {
                        $list[$a]['real_name'] = $yonghu[$k]['real_name'];
                      
                    }
                }  
            }
            
            
            for($a=0;$a<count($pdrow);$a++){
                for($i=0;$i<count($fl);$i++) {
                    if($pdrow[$a]['flag_id'] == $fl[$i]['shop_id']) {
                        $pdrow[$a]['qjdname'] = $fl[$i]['shop_name'];
                    }
                }
                 for($q=0;$q<count($mall_id);$q++) {
                    if($pdrow[$a]['shangcheng'] == $mall_id[$q]['mall_id']) {
                        $pdrow[$a]['scname'] = $mall_id[$q]['mall_name'];
                    }
                }
                $z[] = $pdrow[$a]['item_id'];
            }
            
            $data['item_id'] = array("in",$z);
            $rows = $m->where($data)->select();
            
           for($a=0;$a<count($pdrow);$a++){
                for($i=0;$i<count($rows);$i++) {
                    if($pdrow[$a]['item_id'] == $rows[$i]['item_id']) {
                        $pdrow[$a]['name'] = $rows[$i]['item_name'];
                        $pdrow[$a]['code'] = $rows[$i]['bar_code'];
                    }
                }  
                 for($k=0;$k<count($yonghu);$k++) {
                    if($pdrow[$a]['user_id'] == $yonghu[$k]['user_id']) {
                        $pdrow[$a]['real_name'] = $yonghu[$k]['real_name'];
                      
                    }
                }  
            }
            $arrays = array($list,$pdrow);
            echo json_encode($arrays);
    }
     //2016.12.19李景志修改
    public function seach_kc2() {
            $m = M("item"); //连接商品表
            $name = $_POST['name']; //搜索的产品名字
            $code =$_POST['code'];  //搜索的条形码
            $sname['item_name'] = array("like","%$name%");  // 后台传过来的搜索产品名字
            $sname['bar_code'] = array("like","%$code%");  // 后台传过来的搜索产品名字
            $row = $m->where($sname)->field("item_id")->select(); //查询这些数据
            $int = M("inventory");
            if($_POST['qjd'] == 'ad') {
                
            } else {
                $where['flag_id'] = $_POST['qjd'];             
            }
            if($_POST['sc'] == 'sc'){
                
            }else {
                $where['shangcheng'] = $_POST['sc']; //商城搜索
            }
            foreach ($row as $val) {
                foreach ($val as $v) {
                    $a[]= $v;
                }
            }
            $where['item_id'] = array("in",$a);
            $where['status'] = 0;
            $list = $int->where($where)->order("shangcheng ,sqtime desc")->select(); //搜索出来的库存数据 
            $flag = M("flagship");
            $fl = $flag->select();
            $mall = M("item_mall");
            $mall_id = $mall->select(); //查询所有的商城
            
            for($a=0;$a<count($list);$a++){
                for($i=0;$i<count($fl);$i++) {
                    if($list[$a]['flag_id'] == $fl[$i]['shop_id']) {
                        $list[$a]['qjdname'] = $fl[$i]['shop_name'];
                    }
                }
                 for($q=0;$q<count($mall_id);$q++) {
                    if($list[$a]['shangcheng'] == $mall_id[$q]['mall_id']) {
                        $list[$a]['scname'] = $mall_id[$q]['mall_name'];
                    }
                }
                $z[] = $list[$a]['item_id'];
            }
            
            $data['item_id'] = array("in",$z);
            $rows = $m->where($data)->select();
            
           for($a=0;$a<count($list);$a++){
                for($i=0;$i<count($rows);$i++) {
                    if($list[$a]['item_id'] == $rows[$i]['item_id']) {
                        $list[$a]['name'] = $rows[$i]['item_name'];
                        $list[$a]['code'] = $rows[$i]['bar_code'];
                    }
                }  
            }
            echo json_encode($list);
    }
    //搜索入库申请（采购）
    public function seac_caigou() {
          $m = M("item"); //连接商品表
            $name = $_POST['name']; //搜索的产品名字
            $code =$_POST['code'];  //搜索的条形码
            $sname['item_name'] = array("like","%$name%");  // 后台传过来的搜索产品名字
            $sname['bar_code'] = array("like","%$code%");  // 后台传过来的搜索产品名字
            $row = $m->where($sname)->field("item_id")->select(); //查询这些数据
            $int = M("inventory");
            if($_POST['qjd'] == 'ad') {
                
            } else {
                $where['flag_id'] = $_POST['qjd'];             
            }
            if($_POST['sc'] == 'sc'){
                
            }else {
                $where['shangcheng'] = $_POST['sc']; //商城搜索
            }
            foreach ($row as $val) {
                foreach ($val as $v) {
                    $a[]= $v;
                }
            }
            $where['item_id'] = array("in",$a);
            $where['status'] = 0;
            $list = $int->where($where)->order("shangcheng ,sqtime desc")->select(); //搜索出来的库存数据 
            $flag = M("flagship");
            $fl = $flag->select();
            $mall = M("item_mall");
            $mall_id = $mall->select(); //查询所有的商城
            
            for($a=0;$a<count($list);$a++){
                for($i=0;$i<count($fl);$i++) {
                    if($list[$a]['flag_id'] == $fl[$i]['shop_id']) {
                        $list[$a]['qjdname'] = $fl[$i]['shop_name'];
                    }
                }
                 for($q=0;$q<count($mall_id);$q++) {
                    if($list[$a]['shangcheng'] == $mall_id[$q]['mall_id']) {
                        $list[$a]['scname'] = $mall_id[$q]['mall_name'];
                    }
                }
                $z[] = $list[$a]['item_id'];
            }
            
            $data['item_id'] = array("in",$z);
            $rows = $m->where($data)->select();
            
           for($a=0;$a<count($list);$a++){
                for($i=0;$i<count($rows);$i++) {
                    if($list[$a]['item_id'] == $rows[$i]['item_id']) {
                        $list[$a]['name'] = $rows[$i]['item_name'];
                        $list[$a]['code'] = $rows[$i]['bar_code'];
                    }
                }  
            }
            echo json_encode($list);
    }
    //收银页面返回验证
    function fanhui_yanzheng(){
        if($_GET['id']){
            $num = 123;
            cookie("fanhui","$num");
            $this->redirect("shouyin");
        }
    }
    
    //2016-12-18批量改表
    public function cdc_gaibiao(){
////        $ming = "FLN";
////        $where["item_name"]=array("like","%FLN%");
//        $m = M("item");
//        $arr = $m->where("unit_id = 23")->select();
//        $text = "<p>1、纯杨木基材,E0级环保,6000转耐磨,仿榆木同步花纹,立体感强</p><p>2、经久耐用。彩信地板 蜡覆膜防水</p><p>3、纳米防水蜡分子深度渗入地板四边榫槽，有效封闭潮气浸入基材，提高产品稳定性。&nbsp;</p><p>4、彩信地板 地热专家通过多次采用高温热压技术，使彩信地板导热快，耐高温不变形。</p><p>5、含标配踢脚线，15平米配过门铜条（90公分以内）等基础辅料,地台及异形的安装费用是由客户自行付费，并且地板安装的损耗量会比普通铺装偏大；</p><p>6、踢脚线等辅料安装我们选择的是二次上门安装，避免随地板一并安装后会遭到后续工艺的破坏；</p><p>7、根据自己的实际情况选择强化复合或实木等材质地板，并提前通知装修师傅所选地板的厚度</p><p>8、地采暖用户建议选购强化复合地板。 &nbsp;</p>";
////        dump($arr);
////////        $upt['brand_id'] = 67;
//        $upt['remarks'] = $text;
//        for($i=0;$i<count($arr);$i++){
//            $m->where("item_id={$arr[$i]['item_id']}")->save($upt);
//        }
    }
    //2016.12.19 李景志
    public function rkcg() {
        $m =M("inventory"); //连接库存表
        $data['shenhe'] = 1;
        date_default_timezone_set ("PRC");
        $time=time();
        $data['created_date'] = date("Y-m-d h:i:s",$time);
        $data['inventory_use'] = $_COOKIE['ShopName'];
//        $data['type']=1;
        $arr =$m->where("inventory_id='{$_POST['inventory_id']}'")->find();
//        $datq['type']=0;
        $a = $m->where("item_id='{$arr['item_id']}'and flag_id='{$arr['flag_id']}'and type=1")->find();
        if(empty($a)){
            $data['sy_num'] = $arr['inventory_new'];
        } else {
             $data['sy_num'] = $arr['inventory_new'] + $a['sy_num'];
             $dat['type'] = 0;
             $m->where("inventory_id='{$a['inventory_id']}'")->save($dat);
        }
        $data['type'] = 1;
        $row = $m->where("inventory_id='{$_POST['inventory_id']}'")->save($data);
        $sp = M("item"); //连接商品表
        $sps = $sp->where("item_id='{$arr['item_id']}'")->find(); //找到这条商品
        $datw['number'] = $arr['inventory_new'] + $sps['number'];
        $sprow = $sp->where("item_id='{$arr['item_id']}'")->save($datw);
        if($row) {
            $caozuo = M("operation"); //连接日志表
            $ca['username'] = $_COOKIE['ShopName'];
            $ca['time'] = date("Y-m-d h:i:s",$time);
            $ca['details'] = "审批".$arr['sqren']."申请的".$arr['inventory_new']."个".$sps['item_name']."的商品（入库）";
            $caozuo->add($ca);
            echo 1 ;
        } else {
            echo 2 ;
        }
    }
        //李景志2017.1.3 入库退回
        public function tuihuis(){
              $m =M("inventory"); //连接库存表
            $data['shenhe'] = 2;
            date_default_timezone_set ("PRC");
            $time=time();
            $data['created_date'] = date("Y-m-d h:i:s",$time);
            $data['inventory_use'] = $_COOKIE['ShopName'];
            $data['beizhu'] = $_POST['yuanyin'];
            $a =$m->where("inventory_id='{$_POST['inventory_id']}'")->save($data);
            if($a){
                echo 1;
                exit();
            }else{
                echo 2;
            }
        }
        
    //2016.12.20李景志
    public function fahsq() {
        $sh =M("review_order"); //连接审核订单表
        $array = $sh->order("time desc")->select(); //查询待审核里面的列表
        $m = M("uaccount_order"); //连接用户订单表 
        foreach ($array as $val) {
            foreach ($val as $k=>$v) {
//                dump($k);
                if($k == 'order_id') {
                    $a[]=$v;
                }
            }
        }
        if(!empty($_COOKIE['fahuo_bianhao'])) {
            $where['order_no'] = array("like","%{$_COOKIE['fahuo_bianhao']}%");
        }
        $where['order_id'] = array("in",$a); //根据审核表查询来的订单id
        $co= $m->where($where)->select();
        $count = count($co);
        $p = getpage($count,8);
        $arr = $m->where($where)->limit($p->firstRow, $p->listRows)->order("create_date desc")->select(); //查出对应的用户订单
   
        $user = M("uaccount"); //连接用户表
        $u =$user->select();
        $addr = M("uaccount_address"); //连接地址表
        $address = $addr->select(); //查询地址表
        for($a=0;$a<count($arr);$a++) {
            for($i=0;$i<count($u);$i++) {
                if($arr[$a]['user_id'] == $u[$i]['user_id']) {
                    $arr[$a]['user_name'] = $u[$i]['real_name'];
                }
            }
            for($i=0;$i<count($address);$i++) {
                if($arr[$a]['address_id'] == $address[$i]['address_id']) {
                    $arr[$a]['address'] = $address[$i]['address_details'];
                    $arr[$a]['address_name'] = $address[$i]['address_people'];
                    $arr[$a]['address_tel'] = $address[$i]['address_tel'];
                }
            }
        }
//       dump($arr);
        $this->assign("arr",$arr);
        $this->assign("show",$p->show());
        $qjd = M("flagship");
        $qijd = $qjd->where("shop_id=1")->find(); //查询旗舰店写四的
        $this->assign("shop",$qijd);
        $this->display();
    }
    //12.20 李景志发货申请
    public function dd_shenhe() {
        date_default_timezone_set ("PRC");
        $time=time();
        $m =M("uaccount_order"); //连接订单表
        $re = M("review_order"); //连接待审核发货的表
        $jkc = M("uaccount_orderdetail"); //连接订单对应表
        $int = M("inventory"); //连接库存；
        
        $item_id = $jkc->where("order_id='{$_POST['order_id']}'")->select(); //查询对应的商品id
       for($i =0;$i<count($item_id);$i++){
           $a[] = $item_id[$i]['item_id'];
       }
////       dump($_POST['order_id']);
        $data['flag_id'] = 1;
        $data['item_id'] = array("in",$a);
        
        $row= $int->where($data)->select(); //查询这个旗舰店对应的库存最后一条的
////        dump($row);
        if(!$row) {
            echo 2;
            exit();
        }  
      
        foreach ($row as $val) {  //把查询出来的数据取商品id
            foreach ($val as $k =>$v) {
                if($k == "item_id") {
                    if(!in_array($v, $w)){
                        $w[] = $v;
                    }
                }
            }
        }       
        $sp = M("item"); //连接商品表
        $sps = $sp->select(); //查询所有的商品
         for($a=0;$a<count($w);$a++) {
            $rows = $int->where("item_id='{$w[$a]}'and flag_id=1")->order("inventory_id desc")->find(); //查询最新的商品对应的库存
             for($z=0;$z<count($item_id);$z++)  {
                 if($rows['item_id'] == $item_id[$z]['item_id']) {
                    $datw['sy_num'] = $rows['sy_num'] - $item_id[$z]['quantity']; //库存数量减去发货的数量 
                    $datw['inventory_new'] =$item_id[$z]['quantity']; 
                    if($rows['sy_num'] - $item_id[$z]['quantity'] <0) {
                        echo 3;
                        exit();
                    }
                 }   
             }
               $sta['shenhe'] = 2;
        $sta['status'] = 3;
        $m->where("order_id='{$_POST['order_id']}'")->save($sta); //修改订单表的状态
        $dingdan =  $m->where("order_id='{$_POST['order_id']}'")->find(); //查询这条订单
        $s['status']= 1;
        $re->where("order_id='{$_POST['order_id']}'")->save($s); //修改发货申请表里的状态
            $spid = $sp->where("item_id='{$rows['item_id']}'")->find();
            $datw['shangcheng'] = $spid['mall_id'];
            $datw['item_id']  = $rows['item_id'];
            $datw['created_date'] =date("Y-m-d h:i:s",$time);
            $datw['flag_id'] = 1;
            $datw['status'] = 2;
            $datw['inventory_use'] = $_COOKIE["ShopName"];
            $datw['type']=1;
            $datw['shenhe'] = 1;
            $datw['user_id'] = $dingdan['user_id'];
            $int->add($datw);
            $dw['type'] = 0;
            $int->where("inventory_id='{$rows['inventory_id']}'")->save($dw);
         }
          $caozuo = M("operation"); //连接日志表
            $ca['username'] = $_COOKIE['ShopName'];
            $ca['time'] = date("Y-m-d h:i:s",$time);
            $ca['details'] = $_COOKIE['ShopName']."审批,订单号为".$dingdan['order_no']."的订单(线上)";
            $caozuo->add($ca);
            for($j=0;$j<count($item_id);$j++){
                for($o=0;$o<count($sps);$o++){
                    if($item_id[$j]['item_id'] == $sps[$o]['item_id']){
                        $datss['rale'] = $sps[$o]['rale'] + $item_id[$j]['quantity'];
                        $sp->where("item_id='{$sps[$o]['item_id']}'")->save($datss);
                    }
                }
            }
         echo 1;
    }
    //发货申请的搜索
    public function fahuo_send() {
        if(!empty($_POST['bianhao'])) {
            cookie("fahuo_bianhao",$_POST['bianhao']);
        }
        $this->redirect("fahsq");
    }
    //清除搜索发货申请的值
    public function fahuoq() {
         cookie("fahuo_bianhao",NULL);
          $this->redirect("fahsq");
    }
    //搜索具体手机号的合同订单
        public function hetong_cookie() {
            
        if(!empty($_POST['tel'])) {
             cookie("user_id_tel",$_POST['tel']);
            $m =M("uaccount");
            $arr = $m->where("change_tel='{$_POST['tel']}'")->find();
//            dump($arr['user_id']);
            if($arr){
                cookie("user_id_ht",$arr['user_id']);
               
//                dump($_COOKIE['ht_tel']);
            }else {
                cookie("user_id_ht","funck");
            }
        }
         $this->redirect("dy_orderlist");
    }
    //清空合同搜索
    public function qing_ht() {
        cookie("user_id_ht",null);
        cookie("user_id_tel",null);
        $this->redirect("dy_orderlist");
    }
    //打印订单2016.12.22 李景志
    public function dy_orderlist() {
        $userdd = M("uaccount_orderdetail"); 
        $dd = $userdd->select(); //查询具体订单里的所有具体商品
        $m =M("item");//连接商品表
        $sp = $m->select(); //查询所有商品
        for($a=0;$a<count($dd);$a++) {
            for($w=0;$w<count($sp);$w++) {
                if($dd[$a]['item_id'] == $sp[$w]['item_id']){
                    if($sp[$w]['biaoji'] == 1) {
                        if(!in_array($dd[$a]['order_id'], $q)){
                            $q[] = $dd[$a]['order_id'];
                        }
                    }
                }
            }
        }
        $dingdan =  M("uaccount_order"); //连接用户订单表
        $where['order_id'] = array("in",$q);
        $where['type'] = 2;
//        $asd = $dingdan->where("user_id=352 && type=2")->select();
        if(!empty($_COOKIE['user_id_ht'])){
            
            $data['user_id'] = $_COOKIE['user_id_ht'];
            $data['order_id'] = array("in",$q);
            $data['type'] = 2;
           $counts = $dingdan->where($data)->select();
           $count=count($counts);
           $p = getpage($count,8);
           $arr =  $dingdan->where($data)->limit($p->firstRow, $p->listRows)->select();
           $userr = M("uaccount");//连接用户表
           $us = $userr->select(); //查询用户
           $qian = 0;
           for($i=0;$i<count($arr);$i++){
               $qian += $arr[$i]['emenoy'];
               for($w=0;$w<count($us);$w++){
                   if($arr[$i]['user_id'] == $us[$w]['user_id']) {
                       $arr[$i]['real_name'] = $us[$w]['real_name'];
                       $arr[$i]['tel'] = $us[$w]['tel'];
                   }
               }
           }
           if($arr){
               $this->assign("heji",'1');
           }
           $this->assign("qian",$qian);
        }else {
        $count = $dingdan->where($where)->where("uaccount.user_id=uaccount_order.user_id")->count();
        $p = getpage($count,8);
        $arr = $dingdan->table("uaccount,uaccount_order")->where($where)->where("uaccount.user_id=uaccount_order.user_id")->limit($p->firstRow, $p->listRows)->order("uaccount_order.create_date desc")->field("uaccount.real_name,uaccount.tel,uaccount_order.*")->select();
        }
//        dump($where);
//        dump($asd);
//        dump($_COOKIE['user_id_ht']);
        $uaccount_address=M("uaccount_address");
    
//        echo $dingdan->getlastsql();
        foreach($arr as $key=>$val){
            $address=$uaccount_address->where("status=1 and address_id={$val["address_id"]}")->find();
            $arr[$key]["address_name"]=$address["address_details"];
            
        }
//        dump($_COOKIE['user_id_ht']);
//        if($_COOKIE[""])
        $flagship=M("flagship");
        $w['shop_id'] = 1;
        $shop_id=$flagship->where($w)->field("shop_id,shop_name")->select();
        $this->assign("shop_id",$shop_id);
        
//        dump($arr);
        $this->assign('show', $p->show());
        $this->assign("arr",$arr);
//        dump($arr);
        $this->display();
    }
    //订单详情打印合同
    public function hetong() {
        $or = M("uaccount_orderdetail");
        $dd = $or->where("order_id='{$_GET['id']}'")->select();
        $m = M("item"); //连接商品表
        $sp = $m->select();
        for($a=0;$a<count($dd);$a++) {
            for($i=0;$i<count($sp);$i++) {
                if($dd[$a]['item_id'] == $sp[$i]['item_id']) {
                    if(!in_array($sp[$i]['brand_id'], $q)) {
                        $q[] = $sp[$i]['brand_id'];
                    }
                }
            }
        }
        $brand = M("brand"); //连接品牌表
        $where['brand_id'] = array("in",$q);
        $pp = $brand->where($where)->select(); //查询品牌名字
        $this->assign('pp',$pp);
        $this->assign('order_id',$_GET['id']);
        $this->display();
    }
    //打印
 public function dayin() {
        $order_id = $_GET['order_id']; //对应的用户订单表id
        $brand_id  = $_GET['id']; //对应的品牌名字
        $userdd = M("uaccount_order"); //连接用户订单表
        $user_dd = $userdd->where("order_id='{$order_id}'")->find();
        $ur = M("surpasses"); //连接合同
        $dayin = M("hetongbm"); //连接对应的合同信息表
        $fenlei = M("item_category"); //分类表
        $fenl = $fenlei->select();
        $sp = M("item");  //连接商品表
        $sps = $sp->select(); //查询所有的商品
        $row = $dayin->where("order_no='{$user_dd['order_no']}'and brand_id='{$brand_id}'and status=1")->select();//查询之前有没有信息
        $fei = $dayin->where("order_no='{$user_dd['order_no']}'and brand_id='{$brand_id}'and status=1")->find();//查询这条合同的费用
        
        if($row) {
            $sss = $ur->where("surpasses_id='{$row[0]['surpasses_id']}'")->find(); //查询之前编辑的这条合同id
            $userss = M("uaccount"); //连接用户表
            $kehu = $userss->where("user_id='{$sss['user_id']}'")->find();//查询客户
            $sheji = $userss->where("user_id='{$sss['sheji']}'")->find(); //查询对应的设计师
            $jl = $userss->where("user_id='{$sss['dianzhang']}'")->find(); //查询对应的客户经理
            $sss['kehu_name'] = $kehu['real_name'];
            $sss['kehu_tel'] = $kehu['change_tel'];
            $sss['sheji_name'] = $sheji['real_name'];
            $sss['sheji_tel'] = $sheji['change_tel'];
            $sss['jl_name'] = $jl['real_name'];
            $sss['jl_tel'] = $jl['change_tel'];        
            $this->assign("you",1); //证明是有信息的
            $this->assign("sss",$sss); //证明是有信息的
            $this->assign("bianmaid",$row[0]['bianma']); //这条合同的id传过去
            $this->assign("fei",$fei); 
           
        } 
        $sur = $ur->where("user_id='{$user_dd['user_id']}'")->select();
       
        
        
        $bar =M("brand"); //连接品牌表
        $brand = $bar->where("brand_id='{$brand_id}'")->find();
        $m =M("uaccount_orderdetail");
        $or = $m->where("order_id='{$order_id}'")->select(); //去查询对应的订单信息
     
        $unit = M("item_unit"); //连接单位表
        $danwei = $unit->select(); //查询所有的单位
        for($a=0;$a<count($or);$a++) {
            for($i=0;$i<count($sps);$i++) {
                if($or[$a]['item_id'] == $sps[$i]['item_id'] && $sps[$i]['brand_id'] == $brand_id) {
                    $or[$a]['item_name'] = $sps[$i]['item_name'];
                    $or[$a]['guige'] = $sps[$i]['guige'];
                    $or[$a]['unit_id'] = $sps[$i]['unit_id'];
                    $or[$a]['eMoney'] = $sps[$i]['eMoney'];
                    $fenlei_name = $fenlei->where("category_id='{$sps[$i]['category_id']}'")->find();
                    
                    
                }
            }
             for($w=0;$w<count($danwei);$w++) {
                if($or[$a]['unit_id'] == $danwei[$w]['unit_id'] ) {
                   $or[$a]['unit_name'] = $danwei[$w]['unit_name'];       
                }
            }
              for($g=0;$g<count($row);$g++) {
                if($or[$a]['item_id'] == $row[$g]['item_id'] && $row[$g]['brand_id'] == $brand_id) {
                    $or[$a]['sywz'] = $row[$g]['sywz'];
                    $or[$a]['mianji'] = $row[$g]['mianji'];
                    $or[$a]['beizhu'] = $row[$g]['beizhu'];
                }
            }
//            for($u=0;$u<count($fenl);$u++){
//                if($or[$a]['category_id'] == $fenl[$u]['category_id']){
//                    $or[$a]['category_name']=$fenl[$u]['category_name'];
//                }
//            }
            
        }
  
        $this->assign("dan",$sur);
      
        $this->assign("user",$sur[0]['user_id']);
        $this->assign('sp',$or);
        $this->assign('brand',$brand);
        $this->assign('brand_id',$brand_id);
        $this->assign("danhao",$user_dd);
        $this->assign("fenlei_name",$fenlei_name);
        
        $this->display();
    }
    //订货单
     public function dinghuo() {
        $order_id = $_GET['order_id']; //对应的用户订单表id
        $brand_id  = $_GET['id']; //对应的品牌名字
        $userdd = M("uaccount_order"); //连接用户订单表
        $user_dd = $userdd->where("order_id='{$order_id}'")->find();
        $ur = M("surpasses"); //连接合同
        $dayin = M("hetongbm"); //连接对应的合同信息表
        $fenlei = M("item_category"); //分类表
        $fenl = $fenlei->select();
        $sp = M("item");  //连接商品表
        $sps = $sp->select(); //查询所有的商品
        $row = $dayin->where("order_no='{$user_dd['order_no']}'and brand_id='{$brand_id}'and status=1")->select();//查询之前有没有信息
        $fei = $dayin->where("order_no='{$user_dd['order_no']}'and brand_id='{$brand_id}'and status=1")->find();//查询这条合同的费用
        
        if($row) {
            $sss = $ur->where("surpasses_id='{$row[0]['surpasses_id']}'")->find(); //查询之前编辑的这条合同id
            $userss = M("uaccount"); //连接用户表
            $kehu = $userss->where("user_id='{$sss['user_id']}'")->find();//查询客户
            $sheji = $userss->where("user_id='{$sss['sheji']}'")->find(); //查询对应的设计师
            $jl = $userss->where("user_id='{$sss['dianzhang']}'")->find(); //查询对应的客户经理
            $sss['kehu_name'] = $kehu['real_name'];
            $sss['kehu_tel'] = $kehu['change_tel'];
            $sss['sheji_name'] = $sheji['real_name'];
            $sss['sheji_tel'] = $sheji['change_tel'];
            $sss['jl_name'] = $jl['real_name'];
            $sss['jl_tel'] = $jl['change_tel'];        
            $this->assign("you",1); //证明是有信息的
            $this->assign("sss",$sss); //证明是有信息的
            $this->assign("bianmaid",$row[0]['bianma']); //这条合同的id传过去
            $this->assign("fei",$fei); 
           
        } 
        $sur = $ur->where("user_id='{$user_dd['user_id']}'")->select();
       
        
        
        $bar =M("brand"); //连接品牌表
        $brand = $bar->where("brand_id='{$brand_id}'")->find();
        $m =M("uaccount_orderdetail");
        $or = $m->where("order_id='{$order_id}'")->select(); //去查询对应的订单信息
     
        $unit = M("item_unit"); //连接单位表
        $danwei = $unit->select(); //查询所有的单位
        for($a=0;$a<count($or);$a++) {
            for($i=0;$i<count($sps);$i++) {
                if($or[$a]['item_id'] == $sps[$i]['item_id'] && $sps[$i]['brand_id'] == $brand_id) {
                    $or[$a]['item_name'] = $sps[$i]['item_name'];
                    $or[$a]['guige'] = $sps[$i]['guige'];
                    $or[$a]['unit_id'] = $sps[$i]['unit_id'];
                    $or[$a]['eMoney'] = $sps[$i]['eMoney'];
                    $fenlei_name = $fenlei->where("category_id='{$sps[$i]['category_id']}'")->find();
                    
                    
                }
            }
             for($w=0;$w<count($danwei);$w++) {
                if($or[$a]['unit_id'] == $danwei[$w]['unit_id'] ) {
                   $or[$a]['unit_name'] = $danwei[$w]['unit_name'];       
                }
            }
              for($g=0;$g<count($row);$g++) {
                if($or[$a]['item_id'] == $row[$g]['item_id'] && $row[$g]['brand_id'] == $brand_id) {
                    $or[$a]['sywz'] = $row[$g]['sywz'];
                    $or[$a]['mianji'] = $row[$g]['mianji'];
                    $or[$a]['beizhu'] = $row[$g]['beizhu'];
                }
            }
//            for($u=0;$u<count($fenl);$u++){
//                if($or[$a]['category_id'] == $fenl[$u]['category_id']){
//                    $or[$a]['category_name']=$fenl[$u]['category_name'];
//                }
//            }
            
        }
  
        $this->assign("dan",$sur);
      
        $this->assign("user",$sur[0]['user_id']);
        $this->assign('sp',$or);
        $this->assign('brand',$brand);
        $this->assign('brand_id',$brand_id);
        $this->assign("danhao",$user_dd);
        $this->assign("fenlei_name",$fenlei_name);
        
        $this->display();
    }
    //查询对应的合同单号信息
    public function ht_xinxi() {
        $m = M("surpasses");
        $dd = $m->where("surpasses_id='{$_POST['dan']}'")->find();
        $user = M("uaccount"); //连接用户表
        $kehu = $user->where("user_id='{$dd['user_id']}'")->find();//查询客户
        $sheji = $user->where("user_id='{$dd['sheji']}'")->find(); //查询对应的设计师
        $jl = $user->where("user_id='{$dd['dianzhang']}'")->find(); //查询对应的客户经理
        $dd['kehu_name'] = $kehu['real_name'];
        $dd['kehu_tel'] = $kehu['change_tel'];
        $dd['sheji_name'] = $sheji['real_name'];
        $dd['sheji_tel'] = $sheji['change_tel'];
        $dd['jl_name'] = $jl['real_name'];
        $dd['jl_tel'] = $jl['change_tel'];
        $bianma = M("hetongbm"); //连接合同编码
        $users = $bianma->where("user_id='{$kehu['user_id']}'and status=1")->order("bianma_id desc")->find();
        if($users) {
//            if($users['bianma'] !== $_POST['hao']) { //判断是否有这条记录的编码
                $arr = explode("-d", $users['bianma']);
           
                $dd['bianma'] =  $kehu['change_tel']."-d".($arr[1]+1);
           
             
        } else {
            $dd['bianma'] = $kehu['change_tel']."-d1";
        }
//        echo $users['brand_id'];
        echo json_encode($dd);
////        echo $_POST['hao'];
//        echo $users['bianma_id'];
    }
    //合同订货单的查询合同信息
     public function ht_dinghuo() {
        $m = M("surpasses");
        $dd = $m->where("surpasses_id='{$_POST['dan']}'")->find();
        $user = M("uaccount"); //连接用户表
        $kehu = $user->where("user_id='{$dd['user_id']}'")->find();//查询客户
        $sheji = $user->where("user_id='{$dd['sheji']}'")->find(); //查询对应的设计师
        $jl = $user->where("user_id='{$dd['dianzhang']}'")->find(); //查询对应的客户经理
        $dd['kehu_name'] = $kehu['real_name'];
        $dd['kehu_tel'] = $kehu['change_tel'];
        $dd['sheji_name'] = $sheji['real_name'];
        $dd['sheji_tel'] = $sheji['change_tel'];
        $dd['jl_name'] = $jl['real_name'];
        $dd['jl_tel'] = $jl['change_tel'];
        $bianma = M("hetongbm"); //连接合同编码
        $users = $bianma->where("user_id='{$kehu['user_id']}'and status=3")->order("bianma_id desc")->find();
        if($users) {
//            if($users['bianma'] !== $_POST['hao']) { //判断是否有这条记录的编码
                $arr = explode("-h", $users['bianma']);
           
                $dd['bianma'] =  $kehu['change_tel']."-h".($arr[1]+1);
           
             
        } else {
            $dd['bianma'] = $kehu['change_tel']."-h1";
        }
//        echo $users['brand_id'];
        echo json_encode($dd);
////        echo $_POST['hao'];
//        echo $users['bianma_id'];
    }
    //查询退货合同单号
    public function tui_xinxi() {
        $m = M("surpasses");
        $dd = $m->where("surpasses_id='{$_POST['dan']}'")->find();
        $user = M("uaccount"); //连接用户表
        $kehu = $user->where("user_id='{$dd['user_id']}'")->find();//查询客户
        $sheji = $user->where("user_id='{$dd['sheji']}'")->find(); //查询对应的设计师
        $jl = $user->where("user_id='{$dd['dianzhang']}'")->find(); //查询对应的客户经理
        $dd['kehu_name'] = $kehu['real_name'];
        $dd['kehu_tel'] = $kehu['change_tel'];
        $dd['sheji_name'] = $sheji['real_name'];
        $dd['sheji_tel'] = $sheji['change_tel'];
        $dd['jl_name'] = $jl['real_name'];
        $dd['jl_tel'] = $jl['change_tel'];
        $bianma = M("hetongbm"); //连接合同编码
        $users = $bianma->where("user_id='{$kehu['user_id']}'and status=2")->order("bianma_id desc")->find();
        if($users) {
//            if($users['bianma'] !== $_POST['hao']) { //判断是否有这条记录的编码
                $arr = explode("-t", $users['bianma']);
           
                $dd['bianma'] =  $kehu['change_tel']."-t".($arr[1]+1);
           
             
        } else {
            $dd['bianma'] = $kehu['change_tel']."-t1";
        }
//        echo $users['brand_id'];
        echo json_encode($dd);
////        echo $_POST['hao'];
//        echo $users['bianma_id'];
    }
    public function ht_baocun() {
        $m =M("hetongbm");    
        if(empty($_POST['save'])){
            for($i=0;$i<count($_POST['item']);$i++) {
                $where['bianma'] = $_POST['zbianma'];
                $where['surpasses_id'] = $_POST['danhao'];
                $where['time'] = $_POST['time'];
                $where['address'] = $_POST['address'];
                $where['dianmian'] = $_POST['dianmian'];
                $where['order_no'] = $_POST['ddhao'];
                $where['item_id'] = $_POST['item'][$i];
                $where['sywz'] = $_POST['weizhi'][$i];
                $where['mianji'] = $_POST['mianji'][$i];
                $where['beizhu'] = $_POST['beizhu'][$i];
                $where['qita'] = $_POST['qita'];
                $where['type'] = $_POST['type'];
                $where['yuan_fei'] = $_POST['yc_fei'];
                $where['jia_fei']= $_POST['jg_fei'];
                $where['an_fei'] = $_POST['an_fei'];
                $where['shoukuan'] = $_POST['shoukuan'];
                $where['status'] = 1;
                $where['user_id'] = $_POST['users'];
                if(!empty($_POST['kehu_qz'])){
                    $where['qianzi'] = 1;
                } else{
                    $where['qianzi'] = 0;
                }
                $where['brand_id'] = $_POST['brand_id'];
                $where['times'] = $_POST['times'];
                $m->add($where);
    //            echo json_encode($where);

            }
           echo 1;
        }else {
            for($i=0;$i<count($_POST['item']);$i++) {
                $where['bianma'] = $_POST['zbianma'];
                $where['surpasses_id'] = $_POST['danhao'];
                $where['time'] = $_POST['time'];
                $where['address'] = $_POST['address'];
                $where['dianmian'] = $_POST['dianmian'];
                $where['order_no'] = $_POST['ddhao'];
                $where['item_id'] = $_POST['item'][$i];
                $where['sywz'] = $_POST['weizhi'][$i];
                $where['mianji'] = $_POST['mianji'][$i];
                $where['beizhu'] = $_POST['beizhu'][$i];
                $where['qita'] = $_POST['qita'];
                $where['type'] = $_POST['type'];
                $where['yuan_fei'] = $_POST['yc_fei'];
                $where['jia_fei']= $_POST['jg_fei'];
                $where['an_fei'] = $_POST['an_fei'];
                $where['shoukuan'] = $_POST['shoukuan'];
                $where['status'] = 1;
                $where['user_id'] = $_POST['users'];
                if(!empty($_POST['kehu_qz'])){
                    $where['qianzi'] = 1;
                } else{
                    $where['qianzi'] = 0;
                }
                $where['brand_id'] = $_POST['brand_id'];
                $where['times'] = $_POST['times'];
                $data['brand_id'] = $_POST['brand_id'];
                $data['order_no'] = $_POST['ddhao'];
                $data['item_id'] = $_POST['item'][$i];
                $m->where($data)->save($where);
    //            echo json_encode($where);

            }
           echo 2;
        }

    }
    //订货单保存
    public function dinghuo_baocun() {
        $m =M("hetongbm");    
//        if(empty($_POST['save'])){
            for($i=0;$i<count($_POST['item']);$i++) {
                $where['bianma'] = $_POST['zbianma'];
                $where['surpasses_id'] = $_POST['danhao'];
                $where['time'] = $_POST['time'];
                $where['address'] = $_POST['address'];
                $where['dianmian'] = $_POST['dianmian'];
                $where['order_no'] = $_POST['ddhao'];
                $where['item_id'] = $_POST['item'][$i];
                $where['sywz'] = $_POST['weizhi'][$i];
                $where['mianji'] = $_POST['mianji'][$i];
                $where['beizhu'] = $_POST['beizhu'][$i];
//                $where['qita'] = $_POST['qita'];
//                $where['type'] = $_POST['type'];
//                $where['yuan_fei'] = $_POST['yc_fei'];
//                $where['jia_fei']= $_POST['jg_fei'];
//                $where['an_fei'] = $_POST['an_fei'];
//                $where['shoukuan'] = $_POST['shoukuan'];
                $where['status'] = 3;
                $where['user_id'] = $_POST['users'];
               
                $where['brand_id'] = $_POST['brand_id'];
//                $where['times'] = $_POST['times'];
                $m->add($where);
    //            echo json_encode($where);

            }
           echo $_POST['danhao'];
//        }else {
//            for($i=0;$i<count($_POST['item']);$i++) {
//                $where['bianma'] = $_POST['zbianma'];
//                $where['surpasses_id'] = $_POST['danhao'];
//                $where['time'] = $_POST['time'];
//                $where['address'] = $_POST['address'];
//                $where['dianmian'] = $_POST['dianmian'];
//                $where['order_no'] = $_POST['ddhao'];
//                $where['item_id'] = $_POST['item'][$i];
//                $where['sywz'] = $_POST['weizhi'][$i];
//                $where['mianji'] = $_POST['mianji'][$i];
//                $where['beizhu'] = $_POST['beizhu'][$i];
////                $where['qita'] = $_POST['qita'];
//                $where['type'] = $_POST['type'];
////                $where['yuan_fei'] = $_POST['yc_fei'];
////                $where['jia_fei']= $_POST['jg_fei'];
////                $where['an_fei'] = $_POST['an_fei'];
////                $where['shoukuan'] = $_POST['shoukuan'];
//                $where['status'] = 3;
//                $where['user_id'] = $_POST['users'];
//                if(!empty($_POST['kehu_qz'])){
//                    $where['qianzi'] = 1;
//                } else{
//                    $where['qianzi'] = 0;
//                }
//                $where['brand_id'] = $_POST['brand_id'];
//                $where['times'] = $_POST['times'];
//                $data['brand_id'] = $_POST['brand_id'];
//                $data['order_no'] = $_POST['ddhao'];
//                $data['item_id'] = $_POST['item'][$i];
//                $m->where($data)->save($where);
//    //            echo json_encode($where);
//
//            }
//           echo 2;
//        }
    }
    //保存退货合同信息
    public function htui_baocun() {
         $m =M("hetongbm");    
            for($i=0;$i<count($_POST['item']);$i++) {
                $where['bianma'] = $_POST['zbianma'];
                $where['surpasses_id'] = $_POST['danhao'];
                $where['time'] = $_POST['time'];
                $where['address'] = $_POST['address'];
                $where['dianmian'] = $_POST['dianmian'];
                $where['order_no'] = $_POST['ddhao'];
                $where['item_id'] = $_POST['item'][$i];
                $where['sywz'] = $_POST['weizhi'][$i];
                $where['mianji'] = $_POST['mianji'][$i];
                $where['beizhu'] = $_POST['beizhu'][$i];
                $where['qita'] = $_POST['qita'];
                $where['type'] = $_POST['type'];
                $where['yuan_fei'] = $_POST['yc_fei'];
                $where['jia_fei']= $_POST['jg_fei'];
                $where['an_fei'] = $_POST['an_fei'];
                $where['shoukuan'] = $_POST['shoukuan'];
                $where['status'] = 2;
                $where['numbers'] =$_POST['number'][$i];
                $where['user_id'] = $_POST['users'];
                if(!empty($_POST['kehu_qz'])){
                    $where['qianzi'] = 1;
                } else{
                    $where['qianzi'] = 0;
                }
                $where['brand_id'] = $_POST['brand_id'];
                $where['times'] = $_POST['times'];
                $m->add($where);
    //            echo json_encode($where);

            }
           echo 1;
    }
    //保存合同扣钱2016 12 24 李景志
    public function hetong_kou() {
        $m =M("uaccount");
        $ar =$m->where("user_id='{$_POST['user']}'")->find(); //查找这个用户
        if($ar['security_pwd'] == md5(md5($_POST['ps']))) {
            $data['emoney'] = $ar['emoney'] - $_POST['fei']; //扣钱
            if( $ar['emoney'] - $_POST['fei'] <0) {
                echo 3;
                exit();
            }
            $m->where("user_id='{$_POST['user']}'")->save($data);
            echo 1 ;
            exit();
        } else{
            echo 2;
            exit();
        }
    }
    //保存退货弹扣钱
    public function hestong_kou() {
         $m =M("uaccount");
        $ar =$m->where("user_id='{$_POST['user']}'")->find(); //查找这个用户
        if($ar['security_pwd'] == md5(md5($_POST['ps']))) {
            $data['emoney'] = $ar['emoney'] + $_POST['fei']; //扣钱
            $m->where("user_id='{$_POST['user']}'")->save($data);
            echo 1 ;
            exit();
        } else{
            echo 2;
            exit();
        }
    }
    //退货合同
    public function tuihuo_hetonglist() {
        $order_id = $_GET['order_id']; //对应的用户订单表id
        $brand_id  = $_GET['id']; //对应的品牌名字
        $userdd = M("uaccount_order"); //连接用户订单表
        $user_dd = $userdd->where("order_id='{$order_id}'")->find();
        $ur = M("surpasses"); //连接合同
        $dayin = M("hetongbm"); //连接对应的合同信息表
        $sp = M("item");  //连接商品表
        $sps = $sp->select(); //查询所有的商品
        $row = $dayin->where("order_no='{$user_dd['order_no']}'and brand_id='{$brand_id}'and status =2")->group("bianma")->select();//查询之前有没有信息
        if($row) {
            $this->assign("hetong",$row);
        } 
        $this->assign('order_id',$order_id);
        $this->assign('brand_id',$brand_id);
//        dump($row);
        $this->display();
    }
    //新增退货合同
    public function tuihuo_add() {
        $order_id = $_GET['id'];  //对应的订单id
        $brand_id = $_GET['brand']; //品牌id
        $userdd = M("uaccount_order"); //连接用户订单表
        $user_dd = $userdd->where("order_id='{$order_id}'")->find();
        $ur = M("surpasses"); //连接合同
        $dayin = M("hetongbm"); //连接对应的合同信息表
        $sp = M("item");  //连接商品表
        
        $fenlei = M("item_category"); //分类表
        $fenl = $fenlei->select();
        $sps = $sp->select(); //查询所有的商品
        $row = $dayin->where("order_no='{$user_dd['order_no']}'and brand_id='{$brand_id}'")->select();//查询之前有没有信息
        $fei = $dayin->where("order_no='{$user_dd['order_no']}'and brand_id='{$brand_id}'")->find();//查询这条合同的费用
        
        if($row) {
            $sss = $ur->where("surpasses_id='{$row[0]['surpasses_id']}'")->find(); //查询之前编辑的这条合同id
            $userss = M("uaccount"); //连接用户表
            $kehu = $userss->where("user_id='{$sss['user_id']}'")->find();//查询客户
            $sheji = $userss->where("user_id='{$sss['sheji']}'")->find(); //查询对应的设计师
            $jl = $userss->where("user_id='{$sss['dianzhang']}'")->find(); //查询对应的客户经理
            $sss['kehu_name'] = $kehu['real_name'];
            $sss['kehu_tel'] = $kehu['change_tel'];
            $sss['sheji_name'] = $sheji['real_name'];
            $sss['sheji_tel'] = $sheji['change_tel'];
            $sss['jl_name'] = $jl['real_name'];
            $sss['jl_tel'] = $jl['change_tel'];        
//            $this->assign("you",1); //证明是有信息的
            $this->assign("sss",$sss); //证明是有信息的
            $this->assign("bianmaid",$row[0]['bianma']); //这条合同的id传过去
            $this->assign("fei",$fei); 
           
        } 
        $sur = $ur->where("user_id='{$user_dd['user_id']}'")->select();
       
        
        
        $bar =M("brand"); //连接品牌表
        $brand = $bar->where("brand_id='{$brand_id}'")->find();
        $m =M("uaccount_orderdetail");
        $or = $m->where("order_id='{$order_id}'")->select(); //去查询对应的订单信息
     
        $unit = M("item_unit"); //连接单位表
        $danwei = $unit->select(); //查询所有的单位
        for($a=0;$a<count($or);$a++) {
            for($i=0;$i<count($sps);$i++) {
                if($or[$a]['item_id'] == $sps[$i]['item_id'] && $sps[$i]['brand_id'] == $brand_id) {
                    $or[$a]['item_name'] = $sps[$i]['item_name'];
                    $or[$a]['guige'] = $sps[$i]['guige'];
                    $or[$a]['unit_id'] = $sps[$i]['unit_id'];
                    $or[$a]['eMoney'] = $sps[$i]['eMoney'];
                    $fenlei_name = $fenlei->where("category_id='{$sps[$i]['category_id']}'")->find();
                }
            }
             for($w=0;$w<count($danwei);$w++) {
                if($or[$a]['unit_id'] == $danwei[$w]['unit_id'] ) {
                   $or[$a]['unit_name'] = $danwei[$w]['unit_name'];       
                }
            }
            for($g=0;$g<count($row);$g++) {
                if($or[$a]['item_id'] == $row[$g]['item_id'] && $row[$g]['brand_id'] == $brand_id) {
                    $or[$a]['sywz'] = $row[$g]['sywz'];
                    $or[$a]['mianji'] = $row[$g]['mianji'];
                    $or[$a]['beizhu'] = $row[$g]['beizhu'];
                }
            }
          
            
        }
       
  
        $this->assign("dan",$sur);
         
        $this->assign("user",$sur[0]['user_id']);
        $this->assign('sp',$or);
        $this->assign('brand',$brand);
        $this->assign('brand_id',$brand_id);
        $this->assign('orders',$order_id);
        $this->assign("danhao",$user_dd);
         $this->assign("fenlei_name",$fenlei_name);
        $this->display();
    }
    //判断退货的数量是否大于购买的数量
    public function tuihuo_number() {
        $ht = M("hetongbm"); //连接合同表;
        $da['order_no'] = $_POST['ddhao']; //订单号
        $da['item_id'] = $_POST['brand']; //商品id
        $da['brand_id'] = $_POST['pin'];//品牌id
        $hts = $ht->where($da)->select(); //查询这个商品退货数量
        if($hts){ 
            $num = 0;
            for($i=0;$i<count($hts);$i++){
                $num += $hts[$i]['numbers'];
            }
        }
        $m =M("uaccount_orderdetail");//连接合同信息表
        $dd = M("uaccount_order");
        $data['order_no'] = $_POST['ddhao']; //后台传过来的订单号
        $arr = $dd->where($data)->find(); //查询订单号对应的订单
        $datw['order_id'] = $arr['order_id'];
        $datw['item_id'] = $_POST['brand']; //后台传过来的商品id
        $array = $m->where($datw)->find();
        if($_POST['shu'] <= ($array['quantity'] - $num)){
            echo 1;
            exit();
        } else{
            $arrs = array($array['quantity'],($array['quantity'] - $num),$num);
            echo json_encode($arrs);
        }
    }
    //查看已推过货的合同
    public function chakan_hetong() {
        $sp = M("item");  //连接商品表
        $sps = $sp->select(); //查询所有的商品
        $ddhao =$_GET['ddhao']; //订单号
        $brand_id = $_GET['brand']; //品牌号
        $bianma_id = $_GET['bianma']; //编码id
        $m =M("hetongbm");
        $fei =$m->where("bianma_id='{$bianma_id}'")->find();
        $userss = M("uaccount"); //连接用户表
        $ur = M("surpasses"); //连接合同
            $fenlei = M("item_category"); //分类表
        $fenl = $fenlei->select();
        $sss= $ur->where("surpasses_id='{$fei['surpasses_id']}'")->find();
        $kehu = $userss->where("user_id='{$sss['user_id']}'")->find();//查询客户
        $sheji = $userss->where("user_id='{$sss['sheji']}'")->find(); //查询对应的设计师
        $jl = $userss->where("user_id='{$sss['dianzhang']}'")->find(); //查询对应的客户经理
        $sss['kehu_name'] = $kehu['real_name'];
        $sss['kehu_tel'] = $kehu['change_tel'];
        $sss['sheji_name'] = $sheji['real_name'];
        $sss['sheji_tel'] = $sheji['change_tel'];
        $sss['jl_name'] = $jl['real_name'];
        $sss['jl_tel'] = $jl['change_tel'];        
        $data['order_no'] =$ddhao; //订单号
        $data['brand_id'] = $brand_id;//品牌id
        $data['status'] = 2;//退货状态
        $row = $m->where($data)->select();
        $dingdans = M("uaccount_order"); //连接订单表
        $dds = $dingdans->where("order_no='{$ddhao}'")->find(); //查询订单id
        $bar =M("brand"); //连接品牌表
        $brand = $bar->where("brand_id='{$brand_id}'")->find();
        $m =M("uaccount_orderdetail");
        $or = $m->where("order_id='{$dds['order_id']}'")->select(); //去查询对应的订单信息
//        dump($or);
        $unit = M("item_unit"); //连接单位表
        $danwei = $unit->select(); //查询所有的单位
        for($a=0;$a<count($or);$a++) {
            for($i=0;$i<count($sps);$i++) {
                if($or[$a]['item_id'] == $sps[$i]['item_id'] && $sps[$i]['brand_id'] == $brand_id) {
                    $or[$a]['item_name'] = $sps[$i]['item_name'];
                    $or[$a]['guige'] = $sps[$i]['guige'];
                    $or[$a]['unit_id'] = $sps[$i]['unit_id'];
                    $or[$a]['eMoney'] = $sps[$i]['eMoney'];
                    $fenlei_name = $fenlei->where("category_id='{$sps[$i]['category_id']}'")->find();
                    
                }
            }
             for($w=0;$w<count($danwei);$w++) {
                if($or[$a]['unit_id'] == $danwei[$w]['unit_id'] ) {
                   $or[$a]['unit_name'] = $danwei[$w]['unit_name'];       
                }
            }
            for($g=0;$g<count($row);$g++) {
                if($or[$a]['item_id'] == $row[$g]['item_id'] && $row[$g]['brand_id'] == $brand_id) {
                    $or[$a]['sywz'] = $row[$g]['sywz'];
                    $or[$a]['mianji'] = $row[$g]['mianji'];
                    $or[$a]['beizhu'] = $row[$g]['beizhu'];
                    $or[$a]['numbers']=$row[$g]['numbers'];
                }
            }
            
        }
  
//        $this->assign("dan",$sur);
         
//        $this->assign("user",$sur[0]['user_id']);
        $this->assign('sp',$or);
       $this->assign("fei",$fei);
       $this->assign("sss",$sss);
       $this->assign("brand",$brand);
       $this->assign('danhao',$ddhao);
        $this->assign("fenlei_name",$fenlei_name);
        $this->display();
       
    }
   //对应的退货的供应商退货弹
    //查看已推过货的合同
    public function chakan_hetong_tuihuo() {
        $sp = M("item");  //连接商品表
        $sps = $sp->select(); //查询所有的商品
        $ddhao =$_GET['ddhao']; //订单号
        $brand_id = $_GET['brand']; //品牌号
        $bianma_id = $_GET['bianma']; //编码id
        $m =M("hetongbm");
        $fei =$m->where("bianma_id='{$bianma_id}'")->find();
        $userss = M("uaccount"); //连接用户表
        $ur = M("surpasses"); //连接合同
            $fenlei = M("item_category"); //分类表
        $fenl = $fenlei->select();
        $sss= $ur->where("surpasses_id='{$fei['surpasses_id']}'")->find();
        $kehu = $userss->where("user_id='{$sss['user_id']}'")->find();//查询客户
        $sheji = $userss->where("user_id='{$sss['sheji']}'")->find(); //查询对应的设计师
        $jl = $userss->where("user_id='{$sss['dianzhang']}'")->find(); //查询对应的客户经理
        $sss['kehu_name'] = $kehu['real_name'];
        $sss['kehu_tel'] = $kehu['change_tel'];
        $sss['sheji_name'] = $sheji['real_name'];
        $sss['sheji_tel'] = $sheji['change_tel'];
        $sss['jl_name'] = $jl['real_name'];
        $sss['jl_tel'] = $jl['change_tel'];        
        $data['order_no'] =$ddhao; //订单号
        $data['brand_id'] = $brand_id;//品牌id
        $data['status'] = 2;//退货状态
        $row = $m->where($data)->select();
        $dingdans = M("uaccount_order"); //连接订单表
        $dds = $dingdans->where("order_no='{$ddhao}'")->find(); //查询订单id
        $bar =M("brand"); //连接品牌表
        $brand = $bar->where("brand_id='{$brand_id}'")->find();
        $m =M("uaccount_orderdetail");
        $or = $m->where("order_id='{$dds['order_id']}'")->select(); //去查询对应的订单信息
//        dump($or);
        $unit = M("item_unit"); //连接单位表
        $danwei = $unit->select(); //查询所有的单位
        for($a=0;$a<count($or);$a++) {
            for($i=0;$i<count($sps);$i++) {
                if($or[$a]['item_id'] == $sps[$i]['item_id'] && $sps[$i]['brand_id'] == $brand_id) {
                    $or[$a]['item_name'] = $sps[$i]['item_name'];
                    $or[$a]['guige'] = $sps[$i]['guige'];
                    $or[$a]['unit_id'] = $sps[$i]['unit_id'];
                    $or[$a]['eMoney'] = $sps[$i]['eMoney'];
                    $fenlei_name = $fenlei->where("category_id='{$sps[$i]['category_id']}'")->find();
                    
                }
            }
             for($w=0;$w<count($danwei);$w++) {
                if($or[$a]['unit_id'] == $danwei[$w]['unit_id'] ) {
                   $or[$a]['unit_name'] = $danwei[$w]['unit_name'];       
                }
            }
            for($g=0;$g<count($row);$g++) {
                if($or[$a]['item_id'] == $row[$g]['item_id'] && $row[$g]['brand_id'] == $brand_id) {
                    $or[$a]['sywz'] = $row[$g]['sywz'];
                    $or[$a]['mianji'] = $row[$g]['mianji'];
                    $or[$a]['beizhu'] = $row[$g]['beizhu'];
                    $or[$a]['numbers']=$row[$g]['numbers'];
                }
            }
            
        }
  
//        $this->assign("dan",$sur);
         
//        $this->assign("user",$sur[0]['user_id']);
        $this->assign('sp',$or);
       $this->assign("fei",$fei);
       $this->assign("sss",$sss);
       $this->assign("brand",$brand);
       $this->assign('danhao',$ddhao);
        $this->assign("fenlei_name",$fenlei_name);
        $this->display();
       
    }
    //2016.12.29出库申请列表
    public function chuku() {
        $m = M("chuku"); //连接出库表
        $count=$m->count();
        $p = getpage($count,10);
        $arr=$m->limit($p->firstRow, $p->listRows)->order("sq_time desc")->select();
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
        $this->assign("arr",$arr);
        $this->assign("show",$p->show());
        $this->display();
    }
    //新增申请出库
    public function add_chuku() {
        $m = M("flagship");//连接旗舰店
        $arr = $m->select(); //查询所以旗舰店
        $this->assign("arr",$arr);
        $this->display();
    }
    //根据输入的商品条形码查询这个商品
    public function cxsp() {
        $m = M("item");//连接商品表
        $arr = $m->where("bar_code='{$_POST['zhi']}'")->find(); //查询这条商品
        if($arr) {
            echo json_encode($arr) ;
            exit();
        } else {
            echo 2;
            exit();
        }
    }
    //出库申请提交
    public function chuku_shenqing() {
        $m = M("chuku"); //连接出库表
        $add['item_id'] = $_POST['item_id'];
        $add['number'] =$_POST['num'];
        $add['flag_id'] =$_POST['flag'];
        $add['status'] = 0;
        $add['sq_time'] = date("Y-m-d h:i:s",time());
        $add['sqren'] = $_COOKIE['ShopName'];
        $add['shenhe']=0;
        $add['beizhu'] = $_POST['beizhu'];
        $m->add($add);
        $this->redirect("chuku");
    }
    //发起申请
    public function sq_chuku() {
        $m = M("chuku"); //连接出库表
        $data['status']=1;
        $arr = $m->where("chuku_id='{$_POST['id']}'")->save($data);
        if($arr){
            echo 1;
            exit();
        } else{
            echo 2;
            exit();
        }
    }
    //出库申请编辑
    public function chuku_bianji() {
        $m = M("chuku"); //连接出库表
        $arr = $m->where("chuku_id='{$_GET['id']}'")->find(); //查询这条数据
        $sp = M("item"); //连接商品表
        $sps = $sp->where("item_id='{$arr['item_id']}'")->find(); //查询这个商品
        $arr['item_name'] = $sps['item_name'];
        $arr['bar_code'] = $sps['bar_code'];
        $flag = M("flagship"); //连接旗舰店
        $flags = $flag->select(); //去查询所以旗舰店
        $this->assign("arr",$arr);
        $this->assign("qjd",$flags);
        $this->display();
    }
    //出库申请修改提交
    public function chuku_save() {
        $m =M("chuku");
        $data['item_id'] = $_POST['item_id'];
        $data['number'] = $_POST['num'];
        $data['flag_id'] = $_POST['flag'];
        $data['beizhu'] = $_POST['beizhu'];
        $m->where("chuku_id='{$_GET['id']}'")->save($data);//修改
        $this->redirect("chuku");
    }
    public function option_ucca(){
      $tel = $_POST['tel'];
      $sql = M("ucredentials");
      $arr = $sql->where("tel=$tel and type=2 and jiancai_use = 0")->select();
//      $arr = $sql->where("tel=$tel")->select();
      echo json_encode($arr);
  }
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
  public function jiazhuang(){
      $tel = $_POST['tel'];
      $zizhi = $_POST['check'];
      $money = $_POST['money'];
      $chaochu = $_POST['chaochu'];
      $zongji = $_POST['zongji'];
      $jiancai = $_POST['jiancai'];
//      dump($_POST);
      $sql = M("uaccount");
      $find = $sql->where("change_tel=$tel")->find();
      $find2 = $sql->where("change_tel={$_POST['dianzhang']}")->find();
      $find3 = $sql->where("change_tel={$_POST['sheji']}")->find();
      $m = M("surpasses");
      $z = M("ucredentials");
      if(count($find)>0&&count($find2)>0&&count($find3)>0){
          for($i=0;$i<count($zizhi);$i++){
          $arr[] = $z->where("crdentials_id = {$zizhi[$i]}")->field("goods_id")->find();
//          dump($arr);
            }
            for($i=0;$i<count($arr);$i++){
                $res .= $arr[$i]['goods_id'].",";
//                dump($res);
                if($arr[$i]['goods_id']==99000){
                    $gai['jiancai_zizhi'] = 36000;
                }else if($arr[$i]['goods_id'] == 149000){
                    $gai['jiancai_zizhi'] = 55000;
                }else if($arr[$i]['goods_id'] == 190000){
                    $gai['jiancai_zizhi'] = 73000;
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
//          $where['zongji'] = $zongji;
          date_default_timezone_set ("PRC");
          $time=time();
          $data=date("Y-m-d H:i:s",$time);
          $where['time'] = $data;
          $zongji = $chaochu + $zongji ;
          if($find['emoney']>=$chaochu){
//              $upt['emoney'] = $find['emoney'] - $chaochu;
//              $sql->where("user_id={$find['user_id']}")->save($upt);
              $where['jiaona'] = $chaochu;
              $where['shengyu'] = 0;
              echo "提交成功";
              echo "<a href='handle'>返回</a>";
//              $xiu['no_money'] =  $find['no_money'] + $_POST['jiancai'];
//              $sql->where("user_id={$find['user_id']}")->save($xiu);
              $this->send_zhucemess($tel,$_POST['danhao']);
          }else{
              $sheng = $chaochu - $find['emoney'];
              $where['jiaona'] = $find['emoney'];
//              $upt['emoney'] = $find['emoney'] - $find['emoney'];
//              $sql->where("user_id={$find['user_id']}")->save($upt);
              $where['shengyu'] = $sheng;
              echo "用户电子币余额不足，需再缴纳".$sheng."元现金";
//              $xiu['no_money'] =  $find['no_money'] + $_POST['jiancai'];
//              $sql->where("user_id={$find['user_id']}")->save($xiu);
              $this->send_zhucemess($tel,$_POST['danhao']);
          }
          $m->add($where);   
      }else{
          echo "此账号不存在,请重新核对";
      }
  }
  public function phone_list(){
      $sql = M("send_phone");
      $arr = $sql->select();
      $this->assign("ren",$arr);
      $this->display();
  }
  public function add_sendphone(){
      $sql = M("send_phone");
      $where['phone'] = $_POST['phone'];
      $where['name'] = $_POST['name'];
      $where['status'] = 0;
      $sql->add($where);
      $this->redirect("phone_list");
  }
  public function send_jinyong(){
      $id = $_POST['id'];
      $sql = M("send_phone");
      $upt['status'] = 1;
      $a = $sql->where("send_id = $id")->save($upt);
      if($a){
          echo 1;
      }
  }
  public function send_qiyong(){
      $id = $_POST['id'];
      $sql = M("send_phone");
      $upt['status'] = 0;
      $a = $sql->where("send_id = $id")->save($upt);
      if($a){
          echo 1;
      }
  }
  public function send_del(){
      $id = $_POST['id'];
      $sql = M("send_phone");
      $a = $sql->where("send_id = $id")->delete();
      if($a){
          echo 1;
      }
  }
  public function send_zhucemess($tel,$danhao){
//      $tel = 18649004959;
//      $danhao = 233;
      $sql = M("uaccount");
      $m = M("send_phone");
      $arr = $m->where("status = 0")->select();
      $find = $sql->where("change_tel = $tel")->find();
//      dump($find);
      if($find){
        function Post8($data, $target) {
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
          foreach($arr as $val){
              $target = "http://cf.51welink.com/submitdata/service.asmx/g_Submit";
              $phone = $val['phone'];
              $post_data = "sname=dlkeylzs&spwd=7521chengduicheng&scorpid=2476&sprdid=1012888&sdst=$phone&smsg=".rawurlencode("客户".$find['real_name']."(".$find['change_tel'].")已支付装修合同金额，合同单号为:".$danhao."，请准备好主材相关服务【诚兑城】");
              $gets = Post8($post_data, $target);
//              dump($gets);
//              dump($phone);
          }
      } 
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
    public function rukushenqing() {
          $m=M("inventory"); 
        $qjd = M("flagship"); //连接旗舰店的表
        $qd = $qjd->select(); //查询旗舰店
        $count = $m->where("status=0")->count();
        $p = getpage($count,10);
        $mall = M("item_mall");
        $mall_id = $mall->select();
        $arr = $m->where("status=0")->limit($p->firstRow, $p->listRows)->order("sqtime desc")->select();
       $sp = M("item"); //连接商品表
       $sprow = $sp->select();
        for($i=0;$i<count($arr);$i++) {   //根据对应的旗舰店id去查询旗舰店名字
            for($z=0;$z<count($qd);$z++) {
                if($arr[$i]['flag_id'] == $qd[$z]['shop_id']){
                    $arr[$i]['qijiand'] = $qd[$z]['shop_name'];
                }
            for($q=0;$q<count($mall_id);$q++) {
                if($arr[$i]['shangcheng'] == $mall_id[$q]['mall_id']) {
                    $arr[$i]['scname'] = $mall_id[$q]['mall_name'];
                }
            }    
            }
            for($w=0;$w<count($sprow);$w++) {
                if($arr[$i]['item_id'] == $sprow[$w]['item_id']) {
                    $arr[$i]['item_name'] = $sprow[$w]['item_name'];
                    $arr[$i]['bar_code'] = $sprow[$w]['bar_code'];
                }
            }   
              $arr[$i]['xuhao'] = $i+1;
        } 
        
        $this->assign("arr",$arr);
        $this->assign('show', $p->show());
//        dump($arr);
        $this->assign("qd",$qd);
        $this->assign("shangcheng",$mall_id);
        $this->display();
    }
    //退货申请
    public function shop_tuihui() {
        $m=D("vitem");
        if(!empty($_COOKIE["item_namese"])){
            $value=$_COOKIE["item_namese"];
            $where["item_name"]=array("like","%$value%");
        }
        if(!empty($_COOKIE["mall_idse"])&&$_COOKIE["mall_idse"]!=0){          
            $where["mall_id"]=$_COOKIE["mall_idse"];
            $w["mall_id"]=array("neq",$_COOKIE["mall_idse"]);
        }
        if(!empty($_COOKIE["bar_codese"])){          
              $val=$_COOKIE["bar_codese"];
            $where["bar_code"]=array("like","%$val%");
        }
         
         if(!empty($_COOKIE['kucun1se']) || !empty($_COOKIE['kucun2se'])) {
              $where["number"]=  array(array("egt",$_COOKIE['kucun1se']),
                        array("elt",$_COOKIE['kucun2se']));
         }
        
        $count = $m->where($where)->count();
        $p = getpage($count,10);
        $arr = $m->where($where)->limit($p->firstRow, $p->listRows)->order("status,mall_id")->select();
//        dump($where);
        $cagetory = M("item_category");
        $this->assign("arr",$arr);
        $this->assign('show', $p->show());
        $item_mall=M("item_mall");        
        $item=$item_mall->where($w)->select();
        $this->assign("item",$item);
          $fl = M("flagship"); //连接旗舰店的表
        $qjd = $fl->select();//查询
        $this->assign("qjd",$qjd);
        $this->display();
      
    }
    //退货申请列表
    public function shop_tuihuisq() {
           $m=M("inventory"); 
        $qjd = M("flagship"); //连接旗舰店的表
        $qd = $qjd->select(); //查询旗舰店
        $dats['status'] = 1;
        if($_COOKIE['qxfenpei'] ==0){
            
        }else {
            $dats['flag_id'] = $_COOKIE['qxfenpei'];
        }
        $count = $m->where($dats)->count();
        $p = getpage($count,10);
        $mall = M("item_mall");
        $mall_id = $mall->select();
        $arr = $m->where($dats)->limit($p->firstRow, $p->listRows)->order("sqtime desc")->select();
       $sp = M("item"); //连接商品表
       $sprow = $sp->select();
        for($i=0;$i<count($arr);$i++) {   //根据对应的旗舰店id去查询旗舰店名字
            for($z=0;$z<count($qd);$z++) {
                if($arr[$i]['flag_id'] == $qd[$z]['shop_id']){
                    $arr[$i]['qijiand'] = $qd[$z]['shop_name'];
                }
            for($q=0;$q<count($mall_id);$q++) {
                if($arr[$i]['shangcheng'] == $mall_id[$q]['mall_id']) {
                    $arr[$i]['scname'] = $mall_id[$q]['mall_name'];
                }
            }    
            }
            for($w=0;$w<count($sprow);$w++) {
                if($arr[$i]['item_id'] == $sprow[$w]['item_id']) {
                    $arr[$i]['item_name'] = $sprow[$w]['item_name'];
                    $arr[$i]['bar_code'] = $sprow[$w]['bar_code'];
                }
            }   
              $arr[$i]['xuhao'] = $i+1;
        } 
        
        $this->assign("arr",$arr);
        $this->assign('show', $p->show());
//        dump($arr);
        $this->assign("qd",$qd);
        $this->assign("shangcheng",$mall_id);
        $this->display();

    }
    //退货审核
    public function tuihuoshenhe() {
            $m=M("inventory"); 
        $qjd = M("flagship"); //连接旗舰店的表
        $qd = $qjd->select(); //查询旗舰店
        $count = $m->where("status=1")->count();
        $p = getpage($count,10);
        $mall = M("item_mall");
        $mall_id = $mall->select();
        $arr = $m->where("status=1")->limit($p->firstRow, $p->listRows)->order("sqtime desc")->select();
       $sp = M("item"); //连接商品表
       $sprow = $sp->select();
        for($i=0;$i<count($arr);$i++) {   //根据对应的旗舰店id去查询旗舰店名字
            for($z=0;$z<count($qd);$z++) {
                if($arr[$i]['flag_id'] == $qd[$z]['shop_id']){
                    $arr[$i]['qijiand'] = $qd[$z]['shop_name'];
                }
            for($q=0;$q<count($mall_id);$q++) {
                if($arr[$i]['shangcheng'] == $mall_id[$q]['mall_id']) {
                    $arr[$i]['scname'] = $mall_id[$q]['mall_name'];
                }
            }    
            }
            for($w=0;$w<count($sprow);$w++) {
                if($arr[$i]['item_id'] == $sprow[$w]['item_id']) {
                    $arr[$i]['item_name'] = $sprow[$w]['item_name'];
                    $arr[$i]['bar_code'] = $sprow[$w]['bar_code'];
                }
            }   
              $arr[$i]['xuhao'] = $i+1;
        } 
        
        $this->assign("arr",$arr);
        $this->assign('show', $p->show());
//        dump($arr);
        $this->assign("qd",$qd);
        $this->assign("shangcheng",$mall_id);
        $this->display();

    }
    //通过退货申请
    public function tuihuitg() {
        date_default_timezone_set ("PRC");
        $time=time();
           $m =M("inventory"); //连接库存表
        $data['shenhe'] = 1;
        $data['created_date'] = date("Y-m-d h:i:s",$time);
        $data['inventory_use'] = $_COOKIE['ShopName'];
//        $data['type']=1;
        $arr =$m->where("inventory_id='{$_POST['inventory_id']}'")->find();
//        $datq['type']=0;
        $a = $m->where("item_id='{$arr['item_id']}'and flag_id='{$arr['flag_id']}'and type=1")->find();
        if(empty($a)){
            echo 1;
            exit();
        } else {
             $data['sy_num'] = $a['sy_num']- $arr['inventory_new'] ;
             if($a['sy_num']- $arr['inventory_new']<0){
                 echo 2;
                 exit();
             }
             $dat['type'] = 0;
             $m->where("inventory_id='{$a['inventory_id']}'")->save($dat);
        }
        $data['type'] = 1;
        $row = $m->where("inventory_id='{$_POST['inventory_id']}'")->save($data);
        $sp = M("item"); //连接商品表
        $sps = $sp->where("item_id='{$arr['item_id']}'")->find(); //找到这条商品
        $datw['number'] =  $sps['number']- $arr['inventory_new'];
        $sprow = $sp->where("item_id='{$arr['item_id']}'")->save($datw);
        if($row) {
            $caozuo = M("operation"); //连接日志表
            $ca['username'] = $_COOKIE['ShopName'];
            $ca['time'] = date("Y-m-d h:i:s",$time);
            $ca['details'] = "审批".$arr['sqren']."申请的".$arr['inventory_new']."个".$sps['item_name']."的商品（退货）";
            $caozuo->add($ca);
            echo 3 ;
            exit();
        } else {
            echo 4 ;
            exit();
        }
    }
    //通过退货搜索
        public function seach_kc3() {
            $m = M("item"); //连接商品表
            $name = $_POST['name']; //搜索的产品名字
            $code =$_POST['code'];  //搜索的条形码
            $sname['item_name'] = array("like","%$name%");  // 后台传过来的搜索产品名字
            $sname['bar_code'] = array("like","%$code%");  // 后台传过来的搜索产品名字
            $row = $m->where($sname)->field("item_id")->select(); //查询这些数据
            $int = M("inventory");
            if($_POST['qjd'] == 'ad') {
                
            } else {
                $where['flag_id'] = $_POST['qjd'];             
            }
            if($_POST['sc'] == 'sc'){
                
            }else {
                $where['shangcheng'] = $_POST['sc']; //商城搜索
            }
            foreach ($row as $val) {
                foreach ($val as $v) {
                    $a[]= $v;
                }
            }
            $where['item_id'] = array("in",$a);
            $where['status'] = 1;
            $list = $int->where($where)->order("shangcheng ,sqtime desc")->select(); //搜索出来的库存数据 
            $flag = M("flagship");
            $fl = $flag->select();
            $mall = M("item_mall");
            $mall_id = $mall->select(); //查询所有的商城
            
            for($a=0;$a<count($list);$a++){
                for($i=0;$i<count($fl);$i++) {
                    if($list[$a]['flag_id'] == $fl[$i]['shop_id']) {
                        $list[$a]['qjdname'] = $fl[$i]['shop_name'];
                    }
                }
                 for($q=0;$q<count($mall_id);$q++) {
                    if($list[$a]['shangcheng'] == $mall_id[$q]['mall_id']) {
                        $list[$a]['scname'] = $mall_id[$q]['mall_name'];
                    }
                }
                $z[] = $list[$a]['item_id'];
            }
            
            $data['item_id'] = array("in",$z);
            $rows = $m->where($data)->select();
            
           for($a=0;$a<count($list);$a++){
                for($i=0;$i<count($rows);$i++) {
                    if($list[$a]['item_id'] == $rows[$i]['item_id']) {
                        $list[$a]['name'] = $rows[$i]['item_name'];
                        $list[$a]['code'] = $rows[$i]['bar_code'];
                    }
                }  
            }
            echo json_encode($list);
    }
      public function seach_kc4() {
            $m = M("item"); //连接商品表
            $name = $_POST['name']; //搜索的产品名字
            $code =$_POST['code'];  //搜索的条形码
            $sname['item_name'] = array("like","%$name%");  // 后台传过来的搜索产品名字
            $sname['bar_code'] = array("like","%$code%");  // 后台传过来的搜索产品名字
            $row = $m->where($sname)->field("item_id")->select(); //查询这些数据
            $int = M("inventory");
            if($_POST['qjd'] == 'ad') {
                if($_COOKIE['qxfenpei'] ==0){
                    
                }else{
                  $where['flag_id'] = $_COOKIE['qxfenpei'];        
                }
            } else {
                $where['flag_id'] = $_POST['qjd'];             
            }
            if($_POST['sc'] == 'sc'){
                
            }else {
                $where['shangcheng'] = $_POST['sc']; //商城搜索
            }
            foreach ($row as $val) {
                foreach ($val as $v) {
                    $a[]= $v;
                }
            }
            $where['item_id'] = array("in",$a);
            $where['status'] = 1;
            $list = $int->where($where)->order("shangcheng ,sqtime desc")->select(); //搜索出来的库存数据 
            $flag = M("flagship");
            $fl = $flag->select();
            $mall = M("item_mall");
            $mall_id = $mall->select(); //查询所有的商城
            
            for($a=0;$a<count($list);$a++){
                for($i=0;$i<count($fl);$i++) {
                    if($list[$a]['flag_id'] == $fl[$i]['shop_id']) {
                        $list[$a]['qjdname'] = $fl[$i]['shop_name'];
                    }
                }
                 for($q=0;$q<count($mall_id);$q++) {
                    if($list[$a]['shangcheng'] == $mall_id[$q]['mall_id']) {
                        $list[$a]['scname'] = $mall_id[$q]['mall_name'];
                    }
                }
                $z[] = $list[$a]['item_id'];
            }
            
            $data['item_id'] = array("in",$z);
            $rows = $m->where($data)->select();
            
           for($a=0;$a<count($list);$a++){
                for($i=0;$i<count($rows);$i++) {
                    if($list[$a]['item_id'] == $rows[$i]['item_id']) {
                        $list[$a]['name'] = $rows[$i]['item_name'];
                        $list[$a]['code'] = $rows[$i]['bar_code'];
                    }
                }  
            }
            echo json_encode($list);
    }
    //供应商对账表
    public function gys_duizhang() {
        $m = M("item"); //连接商品表
        $sp = $m->select(); //查询所有的商品  
        $b = M("brand"); //连接品牌表
        $bs = $b->select();
        $mall = M("item_mall"); //连接商城表
        $malls = $mall->select(); //查询所有的商城
        
        $f = M("flagship");//连接旗舰店表
        $fs = $f->select(); //查询所有的旗舰店
        $this->assign("qd",$fs);
        $where['shenhe'] = 1;
        $data['shenhe'] = 1;
        $in = M("inventory"); //连接库存表
        $count=$m->where($where)->count();
//        dump($count);
        $p = getpage($count,10);
        $ins = $in->where($where)->limit($p->firstRow, $p->listRows)->order("shangcheng ,created_date desc")->select();
        //查询所有的库存
         $inss = $in->where($data)->order("shangcheng ,created_date desc")->select();
        //查询所有的库存
        for($a=0;$a<count($ins);$a++){
            for($i=0;$i<count($sp);$i++){
                if($ins[$a]['item_id'] == $sp[$i]['item_id']){
                    $ins[$a]['item_name'] = $sp[$i]['item_name'];
                    $ins[$a]['bar_code'] = $sp[$i]['bar_code'];
                    $ins[$a]['brand_id'] = $sp[$i]['brand_id'];
                    $ins[$a]['gh_money'] = $sp[$i]['gh_money'];
                }
            }
            for($q=0;$q<count($bs);$q++){
                if($ins[$a]['brand_id'] == $bs[$q]['brand_id']){
                    $ins[$a]['brand_name'] = $bs[$q]['brand_name'];
                }
            }
            for($w=0;$w<count($malls);$w++){
                if($ins[$a]['shangcheng'] == $malls[$w]['mall_id']){
                    $ins[$a]['mall_name'] = $malls[$w]['mall_name'];
                }
            }
            for($r=0;$r<count($fs);$r++){
                if($ins[$a]['flag_id'] == $fs[$r]['shop_id']){
                    $ins[$a]['shop_name'] = $fs[$r]['shop_name'];
                }
            }
            $ins[$a]['xuhao'] = $a+1;
        }
        
        for($a=0;$a<count($inss);$a++){
            for($i=0;$i<count($sp);$i++){
                if($inss[$a]['item_id'] == $sp[$i]['item_id']){
                    $inss[$a]['item_name'] = $sp[$i]['item_name'];
                    $inss[$a]['bar_code'] = $sp[$i]['bar_code'];
                    $inss[$a]['brand_id'] = $sp[$i]['brand_id'];
                    $inss[$a]['gh_money'] = $sp[$i]['gh_money'];
                }
            }
            for($q=0;$q<count($bs);$q++){
                if($inss[$a]['brand_id'] == $bs[$q]['brand_id']){
                    $inss[$a]['brand_name'] = $bs[$q]['brand_name'];
                }
            }
            for($w=0;$w<count($malls);$w++){
                if($inss[$a]['shangcheng'] == $malls[$w]['mall_id']){
                    $inss[$a]['mall_name'] = $malls[$w]['mall_name'];
                }
            }
            for($r=0;$r<count($fs);$r++){
                if($inss[$a]['flag_id'] == $fs[$r]['shop_id']){
                    $inss[$a]['shop_name'] = $fs[$r]['shop_name'];
                }
            }
            $inss[$a]['xuhao'] = $a+1;
        }
        $this->assign("arr",$ins);
        $this->assign("arrr",$inss);
        $this->assign("show",$p->show());
        $this->assign("shangcheng",$malls);
        $this->display();
    }
    //供货商对账搜索
        public function seach_kcc() {
            $m = M("item"); //连接商品表
            $name = $_POST['name']; //搜索的产品名字
            $code =$_POST['code'];  //搜索的条形码
            $sname['item_name'] = array("like","%$name%");  // 后台传过来的搜索产品名字
            $sname['bar_code'] = array("like","%$code%");  // 后台传过来的搜索产品名字
            $row = $m->where($sname)->field("item_id")->select(); //查询这些数据
            $int = M("inventory");
            $b = M("brand");
            $bs= $b->selecT();
            if($_POST['qjd'] == 'ad') {
                if($_COOKIE['qxfenpei'] == 0){
                    
                }else{
                     $where['flag_id'] =$_COOKIE['qxfenpei'];      
                }
            } else {
                $where['flag_id'] = $_POST['qjd'];    
                
            }
            if($_POST['sc'] == 'sc'){
                
            }else {
                $where['shangcheng'] = $_POST['sc']; //商城搜索
            }
            foreach ($row as $val) {
                foreach ($val as $v) {
                    $a[]= $v;
                }
            }
            $where['item_id'] = array("in",$a);
            if(empty($_POST["times"])){
               $time =  "0000-00-00 00:00:00";
            } else{
                $time = $_POST['times'];
            }
             if(empty($_POST["timess"])){
               $times =  "9999-99-99 23:59:59";
            } else{
                 $times = $_POST['timess'];
            }
              $where["created_date"] = array(
                        array("egt",$time),
                        array("elt",$times));
            $where['shenhe'] = 1;
            $list = $int->where($where)->order("shangcheng ,created_date desc")->select(); //搜索出来的库存数据
           
            $flag = M("flagship");
            $fl = $flag->select();
            $mall = M("item_mall");
            $mall_id = $mall->select(); //查询所有的商城
            
            for($a=0;$a<count($list);$a++){
                for($i=0;$i<count($fl);$i++) {
                    if($list[$a]['flag_id'] == $fl[$i]['shop_id']) {
                        $list[$a]['qjdname'] = $fl[$i]['shop_name'];
                    }
                }
                 for($q=0;$q<count($mall_id);$q++) {
                    if($list[$a]['shangcheng'] == $mall_id[$q]['mall_id']) {
                        $list[$a]['scname'] = $mall_id[$q]['mall_name'];
                    }
                }
                $z[] = $list[$a]['item_id'];
            }
            
            $data['item_id'] = array("in",$z);
            $rows = $m->where($data)->select();
            
           for($a=0;$a<count($list);$a++){
                for($i=0;$i<count($rows);$i++) {
                    if($list[$a]['item_id'] == $rows[$i]['item_id']) {
                        $list[$a]['name'] = $rows[$i]['item_name'];
                        $list[$a]['code'] = $rows[$i]['bar_code'];
                        $list[$a]['gh_money'] = $rows[$i]['gh_money'];
                        $list[$a]['brand_id'] = $rows[$i]['brand_id'];
                    }
                }  
                 for($q=0;$q<count($bs);$q++){
                if($list[$a]['brand_id'] == $bs[$q]['brand_id']){
                    $list[$a]['brand_name'] = $bs[$q]['brand_name'];
                }
            }
            }
           
            echo json_encode($list);
    }
      //商城统计搜索
    public function mx_cookie(){
        if(!empty($_POST["mall_id"])&&$_POST['mall_id']!==0){
            cookie("mall_idss",trim($_POST["mall_id"]));
            $m=M("item_mall");
            $arr=$m->where("mall_id='{$_COOKIE["mall_idss"]}'")->find();
            cookie("mall_namess",$arr["mall_name"]);
        }
         if(empty($_POST["times"])){
              cookie("time","0000-00-00 00:00:00");
            } else{
              cookie("time",$_POST['times']);
            }
             if(empty($_POST["timess"])){
              cookie("times","9999-99-99 23:59:59");
            } else{
                cookie("times",$_POST['timess']);
            } 
            if($_POST['xx'] == 'aa'){
                cookie("xx",null);
            }else{
                cookie("xx",$_POST['xx']);
            }
            $this->redirect("sptongji");
    }
    //商品统计
    public function sptongji(){
        $m = M("uaccount_order"); //连接订单表
        if(!empty($_COOKIE['xx'])){
            $where['type'] = $_COOKIE['xx'];
        }
        $where['shenhe']= 2;
        $dd = $m->where($where)->order("send_date desc")->select();
        foreach($dd as $val){
            $a[] = $val['order_id'];
        }
        $or = M("uaccount_orderdetail"); //连接订单具体表
        $data['order_id'] = array("in",$a);
        $datw['order_id'] = array("in",$a);
        if(!empty($_COOKIE['time'])){
            $time = $_COOKIE['time'];
        }else{
            $time = "0000-00-00 00:00:00";
        }
        if(!empty($_COOKIE['times'])){
            $times = $_COOKIE['times'];
        }else{
            $times = "9999-99-99 23:59:59";
        }
         $data["created_date"] = array(
                        array("egt",$time),
                        array("elt",$times
                 ));
          $datw["created_date"] = array(
                        array("egt",$time),
                        array("elt",$times
                 ));       
        $counts=$or->where($data)->select();
        $count = count($counts);
        $p = getpage($count,10);  
        $ddxq = $or->where($data)->limit($p->firstRow, $p->listRows)->order("created_date desc")->select();
        $ddxqs = $or->where($datw)->order("created_date desc")->select();
        $sp = M("item"); //连接商品表
        $sps = $sp->select(); //查询所有的商品
        $mal = M("item_mall"); //连接商城表
        $mall = $mal->select(); //查询商城
        $this->assign("item",$mall);
        $users = M("uaccount");
        $yonghu = $users->select();
        for($w=0;$w<count($ddxq);$w++){
                for($q=0;$q<count($sps);$q++){
                if($ddxq[$w]['item_id'] == $sps[$q]['item_id']){
                    $ddxq[$w]['mall_id'] = $sps[$q]['mall_id'];
                    $ddxq[$w]['item_name'] = $sps[$q]['item_name'];
                    $ddxq[$w]['bar_code'] = $sps[$q]['bar_code'];
                    $ddxq[$w]['eMoney'] = $sps[$q]['eMoney'];
                    $ddxq[$w]['sMoney'] = $sps[$q]['sMoney'];
                }
            }
            for($z=0;$z<count($mall);$z++){
               if($ddxq[$w]['mall_id'] == $mall[$z]['mall_id']){
                   $ddxq[$w]['mall_name'] = $mall[$z]['mall_name'];
               }
            }    
            for($t=0;$t<count($dd);$t++){
                if($ddxq[$w]['order_id'] == $dd[$t]['order_id']){
                    $ddxq[$w]['type'] = $dd[$t]['type'];
                    $ddxq[$w]['user_id'] = $dd[$t]['user_id'];
                }
            }
            for($k=0;$k<count($yonghu);$k++){
                if($ddxq[$w]['user_id'] == $yonghu[$k]['user_id']){
                    $ddxq[$w]['real_name'] = $yonghu[$k]['real_name'];
                }
            }
            $ddxq[$w]['xuhao']= $w+1;
        }
             for($w=0;$w<count($ddxqs);$w++){
                for($q=0;$q<count($sps);$q++){
                if($ddxqs[$w]['item_id'] == $sps[$q]['item_id']){
                    $ddxqs[$w]['mall_id'] = $sps[$q]['mall_id'];
                    $ddxqs[$w]['item_name'] = $sps[$q]['item_name'];
                    $ddxqs[$w]['bar_code'] = $sps[$q]['bar_code'];
                    $ddxqs[$w]['eMoney'] = $sps[$q]['eMoney'];
                    $ddxqs[$w]['sMoney'] = $sps[$q]['sMoney'];
                }
            }
            for($z=0;$z<count($mall);$z++){
               if($ddxqs[$w]['mall_id'] == $mall[$z]['mall_id']){
                   $ddxqs[$w]['mall_name'] = $mall[$z]['mall_name'];
               }
            }    
            for($t=0;$t<count($dd);$t++){
                if($ddxqs[$w]['order_id'] == $dd[$t]['order_id']){
                    $ddxqs[$w]['type'] = $dd[$t]['type'];
                    $ddxqs[$w]['user_id'] = $dd[$t]['user_id'];
                }
            }
             for($k=0;$k<count($yonghu);$k++){
                if($ddxqs[$w]['user_id'] == $yonghu[$k]['user_id']){
                    $ddxqs[$w]['real_name'] = $yonghu[$k]['real_name'];
                }
            }
            $ddxqs[$w]['xuhao']= $w+1;
        }
        $this->assign("arr",$ddxq);
        $this->assign("arrs",$ddxqs);
        $this->assign("show",$p->show());
        $this->display();
    }
    //订单退货列表
    public function orderlist_tuihuo(){
        $m =M("tuihuo"); //连接退货表
        if(!empty($_COOKIE['tuihuo_user'])){
            $dath['user_id'] = $_COOKIE['tuihuo_user'];
            $dp['user_id'] = $_COOKIE['tuihuo_user'];
      
        }
        if(!empty($_COOKIE['time_th'])){
            $time = $_COOKIE['time_th'];
        }else{
            $time = "0000-00-00 00:00:00";
        }
        if(!empty($_COOKIE['times_th'])){
            $times = $_COOKIE['times_th'];
        }else{
            $times = "9999-99-99 23:59:59";
        }
         $dath["time"] = array(
                        array("egt",$time),
                        array("elt",$times
                 ));
         $dp["time"] = array(
                        array("egt",$time),
                        array("elt",$times
                 ));
        $count =$m->where($dath)->count();
        $p = getpage($count,10);
        $arr = $m->where($dath)->limit($p->firstRow, $p->listRows)->order("time desc")->select(); //查询所有的退货申请
        $arrs = $m->where($dp)->order("time desc")->select(); //查询所有的退货申请
        $sp = M("item"); //连接商品表
        $sps = $sp->select(); //查询所有商品
        $d = M("uaccount_order");
        $or = M("uaccount_orderdetail");
        $ors = $or->select();
        $dd = $d->select(); //查询所有订单号
        $user = M('uaccount'); //连接用户表
        $users = $user->select(); //查询所有用户
        for($a=0;$a<count($arr);$a++){
            for($z=0;$z<count($ors);$z++){
                if($arr[$a]['order_id'] == $ors[$z]['detail_id']){
                    $arr[$a]['order_s'] = $ors[$z]['order_id'];
                }
            }
            for($i=0;$i<count($sps);$i++){
                if($arr[$a]['item_id'] == $sps[$i]['item_id']){
                    $arr[$a]['item_name'] = $sps[$i]['item_name']; 
                }
            }
            for($w=0;$w<count($dd);$w++){
                if($arr[$a]['order_s'] == $dd[$w]['order_id']){
                    $arr[$a]['order_no'] = $dd[$w]['order_no'];
                }
            }
            for($r=0;$r<count($users);$r++){
                if($arr[$a]['user_id'] == $users[$r]['user_id']){
                    $arr[$a]['real_name'] = $users[$r]['real_name'];
                }
            }
            $arr[$a]['xuhao'] = $a+1;
        }
         for($a=0;$a<count($arrs);$a++){
            for($z=0;$z<count($ors);$z++){
                if($arrs[$a]['order_id'] == $ors[$z]['detail_id']){
                    $arrs[$a]['order_s'] = $ors[$z]['order_id'];
                }
            }
            for($i=0;$i<count($sps);$i++){
                if($arrs[$a]['item_id'] == $sps[$i]['item_id']){
                    $arrs[$a]['item_name'] = $sps[$i]['item_name']; 
                }
            }
            for($w=0;$w<count($dd);$w++){
                if($arrs[$a]['order_s'] == $dd[$w]['order_id']){
                    $arrs[$a]['order_no'] = $dd[$w]['order_no'];
                }
            }
            for($r=0;$r<count($users);$r++){
                if($arrs[$a]['user_id'] == $users[$r]['user_id']){
                    $arrs[$a]['real_name'] = $users[$r]['real_name'];
                }
            }
            $arrs[$a]['xuhao'] = $a+1;
        }
        $this->assign("arr",$arr);
        $this->assign("arrs",$arrs);
        $this->assign("show",$p->show());
        $this->display();
    }
    //通过退货
    public function tuihuo_sh(){
        $m =M("tuihuo"); //连接退货表
        $arr = $m->where("tuihuo_id='{$_POST['id']}'")->find(); //查询退货表
        $data['status'] = 1;
        $m->where("tuihuo_id='{$_POST['id']}'")->save($data); //修改退货的状态;
        $or = M("uaccount_orderdetail");
        $datw['tuihuo'] = 2;
        $or->where("detail_id='{$arr['order_id']}'")->save($datw);
        echo 1;
    } 
    //退货完成从友谊路旗舰店加回来有变化在改！！！
    public function tuihuo_ws() {
        date_default_timezone_set ("PRC");
        $time=time();
        $m =M("tuihuo");
         $arr = $m->where("tuihuo_id='{$_POST['id']}'")->find(); //查询退货表
       
        $data['status'] = 2;
        $m->where("tuihuo_id='{$_POST['id']}'")->save($data); //修改退货的状态;
         $or = M("uaccount_orderdetail");
        $datw['tuihuo'] = 3;
        $dd=$or->where("detail_id='{$arr['order_id']}'")->find();//查找这条记录
        $or->where("detail_id='{$arr['order_id']}'")->save($datw);
        $d =M("uaccount_order"); //连接用户订单表
        $ds = $d->where("order_id='{$dd['order_id']}'")->find();
        $sp = M("item"); //连接商品表
        $sps = $sp->where("item_id='{$arr['item_id']}'")->find();//找到对应的商品
        $in = M("inventory");
        $date['rale'] = $sps['rale'] - $arr['number'];
        $date['number'] = $sps['number'] + $arr['number'];
        $sp->where("item_id='{$arr['item_id']}'")->save($date);
        if($ds['type'] ==1){
            //线上订单从友谊路
           $is = $in->where("item_id='{$arr['item_id']}'and flag_id=1 and type=1")->find();
           $da['type'] = 0;
           $in->where("item_id='{$arr['item_id']}'and flag_id=1 and type=1")->save($da);
        }else{
            $da['type'] = 0;
             $is = $in->where("item_id='{$arr['item_id']}'and flag_id='{$ds['shop_id']}' and type=1")->find();
             $is = $in->where("item_id='{$arr['item_id']}'and flag_id='{$ds['shop_id']}' and type=1")->save($da);
        }
         $dats['item_id'] = $arr['item_id'];
           $dats['inventory_new'] = $arr['number'];
           $dats['created_date'] = date("Y-m-d H:i:s",$time);
           $dats['inventory_use'] = $_COOKIE['ShopName'];
           $dats['flag_id'] = $is['flag_id'];
           $dats['status'] = 6;
           $dats['sy_num'] = $is['sy_num'] + $arr['number'];
           $dats['shangcheng'] = $sps['mall_id'];
           $dats['type'] = 1;
           $dats['shenhe']=1;
           $in->add($dats);
           $user = M("uaccount"); //连接用户表
           $users = $user->where("user_id='{$arr['user_id']}'")->find();
           if($sps['mall_id'] == 1 ){
             
               $qian['smoney'] = $users['smoney'] + ($sps['sMoney']*$arr['number']);
           }else if($sps['mall_id'] == 2 || $sps['mall_id'] == 3){
            
                $qian['emoney'] = $users['emoney'] + ($sps['eMoney']*$arr['number']);
           }else{
               $qian['smoney'] = $users['smoney'] + ($sps['sMoney']*$arr['number']);
                $qian['emoney'] = $users['emoney'] + ($sps['eMoney']*$arr['number']);
           }
           $user->where("user_id='{$arr['user_id']}'")->save($qian);
          
            $caozuo = M("operation"); //连接日志表
            $ca['username'] = $_COOKIE['ShopName'];
            $ca['time'] = date("Y-m-d h:i:s",$time);
            $ca['details'] = "订单号".$ds['order_no']."商品名字:".$sps['item_name']."退货数量为：".$arr['number'];
            $caozuo->add($ca);
        $f = M("finance");
        $add['user'] = $users['tel'];
        $add['emoeny'] = $sps['eMoney']*$arr['number'];
        $add['smoeny'] = $sps['sMoney']*$arr['number'];
        
        $data=date("Y-m-d",$time);
        $add['date'] = $data;
        $add['type'] = "退货";
        $f->add($add);
        $mail = M("mail"); 
        $dat['accept_id'] = $users['tel'];
        $dat['send_id'] = $_COOKIE['ShopName'];
        $dat['title'] = "退货成功!";
         $dat['content'] = "商品名字:".$sps['item_name']."数量为：".$arr['number']."退货成功。返还电子币：".$sps['eMoney']*$arr['number']."返还积分：".$sps['sMoney']*$arr['number'];
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d",$time);
        $dat['time'] = $times;
        $dat['status'] = 0;
        $dat['type'] = 1;
        $mail->add($dat);
        echo 1;
    }
    //退货搜素
    public function cookie_tuihuo() {
        $m = M("uaccount");
        if(!empty($_POST['tel'])){
            cookie("tuihuo_tel",$_POST['tel']);
            $a = $m->where("tel='{$_POST['tel']}'")->find();
            cookie("tuihuo_user",$a['user_id']);
        }else{
           cookie("tuihuo_tel",null); 
           cookie("tuihuo_user",null); 
        }
        if(empty($_POST["times"])){
         cookie("time_th","0000-00-00 00:00:00");
       } else{
         cookie("time_th",$_POST['times']);
       }
        if(empty($_POST["timess"])){
         cookie("times_th","9999-99-99 23:59:59");
       } else{
           cookie("times_th",$_POST['timess']);
       } 
       $this->redirect("orderlist_tuihuo");
    }
    //清空退货列表的搜索
    public function tuihuo_cookieD(){
          cookie("tuihuo_tel",null); 
           cookie("tuihuo_user",null); 
           cookie("time_th",null); 
           cookie("times_th",null); 
           $this->redirect("orderlist_tuihuo");
    }
    //调价记录
    public function diaojia_jl() {
        $m =M("diaojia"); //连接调价表
        if(!empty($_COOKIE['dj_sc']) && $_COOKIE['dj_sc'] !== 'xz'){
            $date['shangcheng'] = $_COOKIE['dj_sc'];
            $whee['shangcheng'] = $_COOKIE['dj_sc'];
        }
          if(!empty($_COOKIE['time_dj'])){
            $tim = $_COOKIE['time_dj'];
        }else{
            $tim = "0000-00-00 00:00:00";
        }
        if(!empty($_COOKIE['times_dj'])){
            $tims = $_COOKIE['times_dj'];
        }else{
            $tims = "9999-99-99 23:59:59";
        }
         $date["time"] = array(
                        array("egt",$tim),
                        array("elt",$tims
                 ));
         $whee["time"] = array(
                        array("egt",$tim),
                        array("elt",$tims
                 ));
        $count = $m->where($date)->count();
        $p = getpage($count,10);
        $arr = $m->where($date)->limit($p->firstRow, $p->listRows)->order("time desc")->select();
        $arrs = $m->where($whee)->order("time desc")->select();
        $sp = M("item");
        $sps = $sp->select(); //查询所有的商品
        $mall = M("item_mall"); //连接商城表
        $malls = $mall->select();
        $this->assign("mall",$malls);
        for($a=0;$a<count($arr);$a++){
            for($w=0;$w<count($sps);$w++){
                if($arr[$a]['item_id'] == $sps[$w]['item_id']){
                    $arr[$a]['item_name'] = $sps[$w]['item_name'];
                    $arr[$a]['mall_id'] = $sps[$w]['mall_id'];
                    $arr[$a]['bar_code'] = $sps[$w]['bar_code'];
                }
            }
            for($z=0;$z<count($malls);$z++){
                if($arr[$a]['mall_id'] == $malls[$z]['mall_id']){
                    $arr[$a]['mall_name'] = $malls[$z]['mall_name'];
                }
            }
            $arr[$a]['xuhao'] = $a+1;
        }
         for($a=0;$a<count($arrs);$a++){
            for($w=0;$w<count($sps);$w++){
                if($arrs[$a]['item_id'] == $sps[$w]['item_id']){
                    $arrs[$a]['item_name'] = $sps[$w]['item_name'];
                    $arrs[$a]['mall_id'] = $sps[$w]['mall_id'];
                    $arrs[$a]['bar_code'] = $sps[$w]['bar_code'];
                }
            }
            for($z=0;$z<count($malls);$z++){
                if($arrs[$a]['mall_id'] == $malls[$z]['mall_id']){
                    $arrs[$a]['mall_name'] = $malls[$z]['mall_name'];
                }
            }
            $arrs[$a]['xuhao'] = $a+1;
        }
        $this->assign("arr",$arr);
        $this->assign("arrs",$arrs);
        $this->assign("show",$p->show());
        $this->display();
        
    }
    //掉价记录搜素
    public function diaojia_cookie() {
        if(empty($_POST["times"])){
         cookie("time_dj","0000-00-00 00:00:00");
       } else{
         cookie("time_dj",$_POST['times']);
       }
        if(empty($_POST["timess"])){
         cookie("times_dj","9999-99-99 23:59:59");
       } else{
           cookie("times_dj",$_POST['timess']);
       } 
       if(!empty($_POST['xx'])){
           cookie("dj_sc",$_POST['xx']);
           if($_COOKIE['dj_sc'] !== 'xz'){
             $m=M("item_mall");
            $arr=$m->where("mall_id='{$_COOKIE["dj_sc"]}'")->find();
            cookie("dj_scname",$arr["mall_name"]);
           }
       }else{
           cookie("dj_sc",null);
       }
       $this->redirect("diaojia_jl");
    }
    //掉价搜索清空
    public function dj_cookiess() {
         cookie("dj_sc",null);
         cookie("times_dj",null);
         cookie("time_dj",null);
          $this->redirect("diaojia_jl");
    }
    
    //排序
    public function order_pai(){
        $num = $_GET['num'];
        $upt3 = $_POST['order_num'];
        $a = $upt3;
        $id = $_GET['id'];
        $sql = M("item");
        $this->order_suan($upt3,$id,$num);
        $this->redirect("shop");
    }
    public function order_suan($upt3,$id,$num){
        $sql = M("item");
        $a = $upt3;
        $arr = $sql->where("mall_id = $id and order_num <9223372036854775807 and item_id != $num")->select();
        for($i=$upt3;$i<count($arr)+1;$i++){
            $array = $sql->where("mall_id = $id and order_num = $i and item_id != $num")->find();
            if(!empty($array)){
            $c['order_num'] = $array['order_num'] + 1 ;
            $sql->where("mall_id = $id and item_id = {$array['item_id']}")->save($c); 
            }
        }
        $this->order_upts($a,$num);
    }
    public function order_upts($a,$num){
        $sql = M("item");
        $upt['order_num'] = $a;
        $sql->where("item_id = $num")->save($upt);
    }
    //修改通知标题
    public function shop_uptdc(){
        $id = $_GET['id'];
        $sql = M("new");
        $arr = $sql->where("new_id = $id")->find();
        $this->assign("new",$arr);
        $this->display();
    }
    public function addshop_upt(){
        $m = M("new");
        $id = $_POST['id'];
        $where['title'] = $_POST['biaoti'];
        $where['content'] = $_POST['content'];
        $m->where("new_id=$id")->save($where);
        $this->redirect("shop_dc");
    }
    //补打小票
    public function budaxiaopiao() {
        $this->display();
    }
    //验证商品编码是否重复
    public function code_barcode() {
        $m =M("item");
        if($_POST['bar_code']!=$_SESSION['bianhao_yan']){
          $a = $m->where("bar_code='{$_POST['bar_code']}'")->select();
            if(count($a)>0){
                echo 1;
            }  
        }
    }
    //验证商品编码是否重复
    public function code_barcode2() {
        $m =M("item");
          $a = $m->where("bar_code='{$_POST['bar_code']}'")->select();
            if(count($a)>0){
                echo 1;
            }  
    }
    //补打小票
    public function chaxun_xiaopiao() {
        $m =M("uaccount_order"); //连接用户订单表
        $user = M("uaccount_address");
        $users = M("uaccount");
        $arr = $m->where("order_no='{$_POST['id']}'")->find();
        if($arr){
            if($arr['type'] == 1){
                $addres = $user->where("address_id='{$arr['address_id']}'")->find();
                $arr['shouhuo'] = $addres['address_people'];
                $arr['tel'] = $addres['address_tel'];
                $arr['dizhi'] = $addres['address_provinces'].$addres['address_details'];
            }else{
                $yonghu = $users->where("user_id='{$arr['user_id']}'")->find();
                $arr['tel'] = $yonghu['change_tel'];
                $arr['shouhuo'] = $yonghu['real_name'];
            }
            echo json_encode($arr);
        }else{
            echo 2;
            exit();
        }
    }
    //补打小票打印
    public function budaajax() {
        $m=M("uaccount_order");
        $sp = M("uaccount_orderdetail"); //连接具体订单商品表
        $arr = $sp->where("order_id='{$_POST['inventory_id']}'")->select();
        $sp = M("item"); //连接商品表
        $sps = $sp->select();//查询商品
        
        for ($a=0;$a<count($arr);$a++){
            for($i=0;$i<count($sps);$i++) {
                if($arr[$a]['item_id'] == $sps[$i]['item_id']) {
                    $arr[$a]['item_name'] = $sps[$i]['item_name'];
                    $arr[$a]['bar_code'] = $sps[$i]['bar_code'];
                    $arr[$a]['mall'] = $sps[$i]['mall_id'];
                    if($sps[$i]['mall_id'] == 1){
                        $arr[$a]['jia'] = $sps[$i]['sMoney'];
                    } else if($sps[$i]['mall_id'] == 2 || $sps[$i]['mall_id'] ==3){
                        $arr[$a]['jia'] = $sps[$i]['eMoney'];
                    }else{
                         $arr[$a]['jia'] = $sps[$i]['eMoney']+ $sps[$i]['sMoney'];
                    }
                }
            }
        }
        $dd = $m->where("order_id='{$_POST['inventory_id']}'")->find();
        $user = M("uaccount");
         date_default_timezone_set ("PRC");
        $time=time();
        $addr = M("uaccount_address"); //连接地址表
        $address = $addr->where("address_id='{$dd['address_id']}'")->find();
        $users = $user->where("user_id='{$dd['user_id']}'")->find();
        $dd['real_name']  = $users['real_name'];
        $dd['time'] = date("Y-m-d h:i:s",$time);
        $dd['tel'] = $users['tel'];
        $dd['address_name'] = $address['address_provinces'].$address['address_details'];
        $dd['shouhuo_name'] = $address['address_people'];
        $dd['shouhuo_tel'] = $address['address_tel'];
        $bd = M("bdxp");
        $add['order_id'] = $_POST['inventory_id'];
        $add['time'] = date("Y-m-d h:i:s",$time);
        $add['people']=$_COOKIE['ShopName'];
        $add['beizhu'] =$_POST['yuanyin'];
        $bd->add($add);
        $array= array($dd,$arr);
        echo json_encode($array);
    }
    //补打小列表
    public function budaxiaopiaols() {
        $bd = M("bdxp"); //连接不大小票表
        $count = $bd->count();
        $p = getpage($count,10);
        $bds = $bd->limit($p->firstRow, $p->listRows)->order("time desc")->select();
        $m =M("uaccount_order"); //连接用户订单表
        $arr = $m->select();
        $user = M("uaccount_address");
        $addrs = $user->select();
        $yh = M("uaccount");
        $yonghu = $yh->select();
        for($a=0;$a<count($bds);$a++){
            for($i=0;$i<count($arr);$i++){
                if($bds[$a]['order_id'] == $arr[$i]['order_id']){
                    $bds[$a]['user_id'] = $arr[$i]['user_id'];
                    $bds[$a]['addres_id'] = $arr[$i]['address_id'];
                    $bds[$a]['order_no'] = $arr[$i]['order_no'];
                    $bds[$a]['emenoy'] = $arr[$i]['emenoy'];
                    $bds[$a]['smenoy'] = $arr[$i]['smenoy'];
                    $bds[$a]['type'] = $arr[$i]['type'];
                }
            }
            for($w=0;$w<count($addrs);$w++){
                 if($bds[$a]['address_id'] == $addrs[$w]['address_id']){
                    $bds[$a]['shouhuo_name'] = $addrs[$w]['address_people'];
                    $bds[$a]['shouhuo_tel'] = $addrs[$w]['address_tel'];
                    $bds[$a]['address_name'] = $addrs[$w]['address_province'].$addrs[$w]['address_details'];
                }
            }
            for($k=0;$k<count($yonghu);$k++){
                 if($bds[$a]['user_id'] == $yonghu[$k]['user_id']){
                    $bds[$a]['real_name'] =  $yonghu[$k]['real_name'];
                    $bds[$a]['tel'] =  $yonghu[$k]['tel'];
                }
            }
        }
        $this->assign("arr",$bds);
        $this->assign("show",$p->show());
        $this->display();
    }
   //供货商价格列表
    public function supplier_list() {
        $m = M("suppliers"); //连接供货商价格表
        if(!empty($_COOKIE["mall_gh"])&&$_COOKIE["mall_gh"]!=0){          
            $where["shangcheng"]=$_COOKIE["mall_gh"];
        }
        if(!empty($_COOKIE["bar_codegh"])){          
              $val=$_COOKIE["bar_codegh"];
            $where["bianma"]=array("like","%$val%");
        }
        $count = $m->where($where)->count();
        $p = getpage($count,10);
        $arr = $m->where($where)->limit($p->firstRow, $p->listRows)->order("time desc")->select();
        $sp = M("item"); //连接商品表
        $sps = $sp->select(); //查询所有的商品
        $mall = M("item_mall"); //连接商城表
        $malls = $mall->select();
        for($a=0;$a<count($arr);$a++){
            for($q=0;$q<count($sps);$q++){
                if($arr[$a]['item_id'] == $sps[$q]['item_id']){
                    $arr[$a]['item_name'] = $sps[$q]['item_name'];
                    $arr[$a]['mall_id'] = $sps[$q]['mall_id'];
                    $arr[$a]['bar_code'] = $sps[$q]['bar_code'];
                    $arr[$a]['img_url'] = $sps[$q]['img_url'];
                    $arr[$a]['gh_money'] = $sps[$q]['gh_money'];
                    $arr[$a]['guige'] = $sps[$q]['guige'];
                }
            }
            for($w=0;$w<count($malls);$w++){
                if($arr[$a]['mall_id'] == $malls[$w]['mall_id']){
                    $arr[$a]['mall_name'] = $malls[$w]['mall_name'];
                }
            }
        }
        $this->assign("arr",$arr);
        $this->assign("show",$p->show());
        $this->assign("item",$malls);
        $this->display();
    }
    //供应商调价
    public function gh_jiage() {
        $m = M("item");
        $data['gh_money'] = $_POST['zhi'];
        $a = $m->where("item_id='{$_POST['id']}'")->save($data);
        if($a){
            echo 1;
        }else{
            echo 2;
        }
    }
    //供应商价格搜索
    public function gh_cookie() {
         if(!empty($_POST["mall_id"])){
            cookie("mall_gh",trim($_POST["mall_id"]));
            $m=M("item_mall");
            $arr=$m->where("mall_id='{$_COOKIE["mall_gh"]}'")->find();
            cookie("mall_ghname",$arr["mall_name"]);
        }
        if(!empty($_POST["bar_code"])){
            cookie("bar_codegh",trim($_POST["bar_code"]));
        }else{
            cookie("bar_codegh",null);
        }
        $this->redirect("supplier_list");
        
    }
    //供应商搜索清空
    public function gh_cookieD() {
        cookie("mall_gh",null);
        cookie("mall_ghname",null);
        cookie("bar_codegh",null);
        $this->redirect("supplier_list");
    }
    //新增供应商
    public function addgongying(){
        $m =M("brand"); //连接品牌表
        $arr = $m->select(); 
        $this->assign("arr",$arr);
        $this->display();
    }
    //修改供应商
    public function save_gongying() {
        $m =M("supplier");//连接供应商表
        $arr = $m->where("supplier_id='{$_GET['id']}'")->find();
        $brand = explode(",", $arr['brands_id']);
        $b = M("brand");//连接品牌表
        $bs = $b->select();
        for($a=0;$a<count($brand);$a++){
            $w[] = $brand[$a];
        }
        for($i=0;$i<count($bs);$i++){
            if(in_array($bs[$i]['brand_id'], $w)){
                $bs[$i]['moren'] = 1;
            }else{
                $bs[$i]['moren'] = 2;
            }
        }
        $this->assign("arr",$arr);
        $this->assign("brand",$bs);
        $this->display();
    }
    //商品商城名字维护
    public function item_mall(){
        $m = M("item_mall"); //连接商城
        $arr = $m->select();
        $gui =M("mall_guize"); //连接商城规则表
        $guize =$gui->select();
        $z ='';
        for($a=0;$a<count($arr);$a++){
            for($i=0;$i<count($guize);$i++){
                if($arr[$a]['mall_id'] == $guize[$i]['mall_id']){
                    $z .= $guize[$i]['guize_name'].",";
                }
            }
            $arr[$a]['guize'] = $z;
            $z='';
            
        }
        $this->assign("arr",$arr);
        $this->display();
    }
    //商城删除
    public function mall_delete() {
        $m = M("item_mall");
        $m->where("mall_id='{$_GET['id']}'")->delete();
        $this->redirect("item_mall");
    }
    //商城名字编辑
    public function save_mall() {
        $m = M("item_mall");
        $data['mall_name'] = $_POST['zhi'];
         $a = $m->where("mall_id='{$_POST['id']}'")->save($data);
         if($a){
             echo 1;
         }else{
             echo 2;
         }
    }
    //新增商城
    public function mall_add(){
        $m = M("item_mall"); //连接商城表
        $data['mall_name']= $_POST['name'];
        $m->add($data);
        $this->redirect("item_mall");
    }
    //修改商城规则
    public function save_guize(){
        $m = M("mall_guize");//连接商城表
        $arr = $m->where("mall_id='{$_GET['id']}'")->select();
        $this->assign("arr",$arr);
        $this->assign("id",$_GET['id']);
        $this->display();
    }
    //编辑商城规则
     public function addguize(){
        $sql = M("mall_guize");
        $id = $_POST['ycid'];
        if(!empty($_POST['addclass'])){
            $where['guize_name'] = $_POST['addclass'];
            $where['mall_id'] = $id;
            $sql->add($where); 
        }
        if(!empty($_POST['upt'])&&!empty($_POST['upt_id'])){
            $where['guize_name'] = $_POST['upt'];
            $zid = $_POST['upt_id'];
            $sql->where("guize_id=$zid")->save($where);
        }
        if(!empty($_GET['tid'])){
            $tid = $_GET['tid'];
            $sql->where("guize_id=$tid")->delete();
        }
        $this->redirect("save_guize","id=$id");
    }
    //编辑大类分类规则
    public function save_categui() {
        $m = M("item_category"); //连接分类表
        $a = $m->where("category_id='{$_GET['id']}'")->find();
        $arr =$m->where("leiid='{$a['leiid']}'")->select();
        $this->assign("fenlei",$arr);
        $this->assign("id",$_GET['id']);
        $this->display();
    }
    //修改大类规则
    public function save_dagui() {
        $sql = M("item_category");
        $id = $_POST['ycid'];
        if(!empty($_POST['addclass'])){
            $arr =$sql->where("category_id='$id'")->find();
            $where['category_name'] = $arr['category_name'];
            $where['parent_id']=111;
            $where['leiid'] = $arr['leiid'];
            $where['fenleis'] = $_POST['addclass'];
            $sql->add($where); 
        }
        if(!empty($_POST['upt'])&&!empty($_POST['upt_id'])){
            $zid = $_POST['upt_id'];
            $arr =$sql->where("category_id='$zid'")->find();
            $where['fenleis'] = $_POST['upt'];
            $sql->where("category_id=$zid")->save($where);
        }
        if(!empty($_GET['tid'])){
            $tid = $_GET['tid'];
            $sql->where("category_id=$tid")->delete();
        }
        $this->redirect("save_categui","id=$id");
    }
//    public function ceshi(){
//        $m = M("item_category");
//        $arr = $m->select();
//        for($a=0;$a<count($arr);$a++){
//            $data['leiid'] = '';
//            $m->where("category_id='{$arr[$a]['category_id']}'")->save($data);
//        }
//    }
    //修改分类信息
    public function save_lei(){
        $m = M("item_category"); //连接分类表
        $sp = M("item"); //连接商品表
        if(!empty($_POST['tj1'])){
            $tj1 = $sp->where("bar_code='{$_POST['tj1']}'")->find();
        }
        if(!empty($_POST['tj2'])){
            $tj2 = $sp->where("bar_code='{$_POST['tj2']}'")->find();
        }
        if(!empty($_POST['zhi2'])){
             $data['fenleis'] = $_POST['zhi'];
            $date['fenleis'] = $_POST['zhi2'];
            $date['category_name'] = $_POST['name'];
            if($tj1){
                $date['item_tj1'] = $tj1['item_id'];
            }
            if($tj2){
                 $date['item_tj2'] = $tj2['item_id'];
            }
            
            $date['dalei_px']= $_POST['px'];
            $m->where("category_id='{$_POST['id']}'")->save($data);
            $m->where("category_id='{$_POST['id2']}'")->save($date);
        }else{
            $date['fenleis'] = $_POST['id2'];
            $date['category_name'] = $_POST['name'];
             $date['dalei_px']= $_POST['px'];
              if($tj1){
                $date['item_tj1'] = $tj1['item_id'];
            }
            if($tj2){
                 $date['item_tj2'] = $tj2['item_id'];
            }
            $date['item_tj'] = $str;
            $m->where("category_id='{$_POST['id']}'")->save($date);
        }
        echo 1;
    }
    //小分类该
    public function save_xiaoleis(){
        $m = M("item_category"); //连接分类表；
        $arr = $m->where("category_id='{$_POST['id']}'")->find(); //查询到这个子分类
        $data['fenleis'] = substr($arr['fenleis'],0,5).$_POST['zhi2']; //把这个子分类之前的规则前3位商城规则拼接上输入的内容
        $data['category_name'] = $_POST['name'];
        $data['xiaolei_px'] = $_POST['px'];
        $a = $m->where("category_id='{$arr['parent_id']}'")->find(); //查找这个子类的大类
        if($a['lieid'] !== ''){
            $b = $m->where("leiid='{$a['leiid']}'")->order("category_id desc")->find(); //找到最新的大类规则看看有没有对应两条的
        }
        if($b&&$b['fenleis'] !== ''){
            if($b['fenleis'] !== $a['fenleis']){
                $c = $b['fenleis'].substr($arr['fenleis'],5); //把小类规则拼上
                $d = $m->where("fenleis='$c'")->find();
                $date['fenleis'] = substr($d['fenleis'],0,5).$_POST['zhi2']; //拼接规则
                $s = $m->where("category_id='{$d['category_id']}'")->save($date);
            }
        }
          $ss = $m->where("category_id='{$_POST['id']}'")->save($data);
          if($s || $ss){
              echo 1;
          }
    }
    //修改大类图
    public function save_fltu() {
        $m = M("item_category"); //连接分类表
        $_FILES=array_values($_FILES);
        $array=array("jpg","gif","png","JPG","JPEG");
        $f=0;
        while($f<count($_FILES)){
              $b = explode(".", $_FILES[$f]['name']);
                if(in_array(end($b), $array)){
                    $file_name_big[$f]= $_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(10000,99999).".".end($b);
                    move_uploaded_file($_FILES[$f]["tmp_name"],"Public/upload/$file_name_big[$f]");
                    $see['category_url'] = "/Public/upload/".$file_name_big[$f];
                    $m->where("category_id='{$_POST['ycid'][$f]}'")->save($see);
                }else{
                }
            $f++;           
        } 
        $this->redirect("fenlei");
    }
    //小分类推荐
    public function fenlei_tj() {
        $m =M("item_category");
        $arr = $m->where("parent_id !=0 and parent_id != 88 ")->select();
        $this->assign("arr",$arr);
//        dump($arr);
        $this->display();
    }
    //提交推荐分类
    public function tuijian_category() {
        $m = M("item_category"); //连接分类表
        $arr = $m->where("category_tj =1")->select();
        foreach($arr as $val){
            $date['category_tj'] = '';
            $date['category_px'] = '';
            $m->where("category_id='{$val['category_id']}'")->save($date);
        }
        for($a=0;$a<count($_POST['check']);$a++){
            $data['category_tj'] = 1;
            $data['category_px'] = $_POST[$_POST['check'][$a]];
            $m->where("category_id='{$_POST['check'][$a]}'")->save($data);
        }
        $this->redirect("fenlei_tj");
    }
    //新闻推荐公告
    public function new_tuij() {
        $m = M("new");
        $arr = $m->where("gonggao =1")->select();
        foreach($arr as $val){
            $date['gonggao'] = '';
            $date['new_px'] = '';
            $m->where("new_id='{$val['new_id']}'")->save($date);
        }
        for($a=0;$a<count($_POST['check']);$a++){
            $data['gonggao'] = 1;
            $data['new_px'] = $_POST[$_POST['check'][$a]];
            $m->where("new_id='{$_POST['check'][$a]}'")->save($data);
        }
        $this->redirect("new_list"); 
    }
     //新闻推荐新品
    public function new_tuij2() {
        $m = M("new");
        $arr = $m->where("xp_tj =1")->select();
        foreach($arr as $val){
            $date['xp_tj'] = '';
            $date['xp_px'] = '';
            $m->where("new_id='{$val['new_id']}'")->save($date);
        }
        for($a=0;$a<count($_POST['check']);$a++){
            $data['xp_tj'] = 1;
            $data['xp_px'] = $_POST[$_POST['check'][$a]];
            $m->where("new_id='{$_POST['check'][$a]}'")->save($data);
        }
        $this->redirect("new_list2"); 
    }
    //大分类推荐商品查询名字
    public function fenlei_tjs(){
        $m = M("item");
        $arr = $m->where("bar_code='{$_POST['zhi']}'and status=0")->find();
        if($arr){
            echo $arr['item_name'];
        }
    }
     //站内信搜索存值
    public function mail_page() {
        if($_COOKIE['ShopName']){
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
        if($_COOKIE['ShopName']){
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
                for($w=0;$w<count($row);$w++){
                    $a[] = $row[$w]['accept_id'];
                    $datq['username'] = $row[$w]['send_id'];
                        $send_names = $admin->where($datq)->field("name")->find();
                        $row[$w]['send_name'] = $send_names['name'];
                }
                $datw['tel'] = array("in",$a);
                $accept_name = $user->where($datw)->field("real_name")->select();
                for ($z=0;$z<count($accept_name);$z++) {
                    $row[$z]['accept_name'] = $accept_name[$z];
                }
            }    
            $this->assign("row",$row);
//            dump($row);
            $this->assign('show', $p->show());
            $this->assign('value', $p->parameter['name']);
            $this->display();     
        }
    }
      //站内信发送
    public function send_mail() {
        if($_COOKIE['ShopName']){
            $this->display();
        }
    }
     //随机数
     public function number(){
        if($_COOKIE['ShopName']){
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
    //站内信新增
    public function add_mailedit() {
        if($_COOKIE['ShopName']){
            $m = M("mail");
            $user = M("uaccount");
            $row = $user->select();
            $data['num'] = $this->number();
            foreach ($row as $val) {
                foreach ($val as $k => $v) {
                    if ($k == "tel") {
                        $data['send_id'] = $_COOKIE['ShopName'];
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
     //站内信删除
    public function delete_mail() {
        if($_COOKIE['ShopName']){
            $m =M("mail");
            $m->where("num='{$_GET['num']}'")->delete();
            $this->redirect("mail_list");
        }
    }
    //站内信详情
    public function mail_xx() {
        if($_COOKIE['ShopName']){
            $m = M("mail");
            $row = $m->where("mail_id='{$_GET['id']}'")->find();
            $this->assign("row",$row);
            $this->display();
        }
    }
    //库存列表搜索库存《=0的
    public function kcxo(){
        cookie("kuncus","1");
        $this->redirect("inventory");
    }
    //显示全部
    public function inventory_cook() {
        cookie("kuncus", null);
         $this->redirect("inventory");
    }
    //手机版大类推荐
    public function phonefl_tj() {
        $m = M("item_category"); //连接分类表
        $arr =$m->where("parent_id=0")->select();
        $this->assign("arr",$arr);
        $this->display();
    }
    //分类上传图片
    public function phonetj_img() {
        $m = M("item_category"); //连接分类表      
        $array=array("jpg","gif","png","JPG","JPEG");
         for($a=0;$a<count($_POST['fenleis']);$a++){
            $id = $_POST['fenleis'][$a];
            $data['daleis'] = $_POST[$id];
            $img1 = "files".$id;
            $img2 = "files".$id."s";
            if(!empty($_FILES[$img1]['size'])){
                $b=explode(".",$_FILES[$img1]['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_name=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES[$img1]['tmp_name'],"Public/category_img/$file_name");
                }
             }
            if($file_name){
                $data['fenlei_img2'] = "/Public/category_img/$file_name";
            }
            if(!empty($_FILES[$img2]['size'])){
                $b=explode(".",$_FILES[$img2]['name']);
                if(!in_array(end($b),$array)){
                }else{
                   $file_names=$_SERVER["REQUEST_TIME_FLOAT"]*1000 .rand(100000,200000).".".end($b);
                    move_uploaded_file($_FILES[$img2]['tmp_name'],"Public/category_img/$file_names");
                }
             }
            if($file_names){
                $data['fenlei_img3'] = "/Public/category_img/$file_names";
            }
            $m->where("category_id='{$id}'")->save($data);
        }
       
    }
    //新增手机新闻内容
    public function con_add(){
        $sql = M("news_neirong");//连接内容表
        $user = $_COOKIE['ShopName'];//操作人名称
        $title = trim($_POST['title']);//内容标题
        $mokuai = $_POST['mokuai'];//模块名称
        $content = $_POST['content'];//正文内容;
        date_default_timezone_set ("PRC");
        $time=time();
        $times = date("Y-m-d H:i:s",$time);//服务器时间
        $add['news_title'] = $title;
        $add['news_content'] = $content;
        $add['news_time'] = $times;
        $add['news_user'] = $user;
        $add['news_status'] = 0;//0为启用
        $add['news_mokuai'] = $mokuai;
        $res = $sql->add($add);
        $upt['sort'] = $res;
        $sql->where("news_id = $res")->save($upt);
        if($res){
            $this->redirect("fabu_news");
        }else{
            echo "系统忙，请稍后重试";
        }
    }
    //内容发布页
    public function fabu_news(){
        $sql = M("news_neirong");
        $arr = $sql->order("sort asc")->select();
        $this->assign("arr",$arr);
        $this->display();
    }
    //拖拽排序
    public function sortarray(){
        $sql =  M('news_neirong');
        $arr = $sql->order("sort asc")->select();
        $id = $_POST['id'];
        foreach($arr as $key=>$val){
            if($val['news_id']!=$id[$key]){
                $result['sort'] = $val['sort'];
                $con['news_id'] = $id[$key];
                $sql->where($con)->save($result);
            }
        }
    }
    //禁用新闻
    public function news_jinyong(){
        $sql = M("news_neirong");
        $id = $_POST['id'];
        $upt['news_status'] = 1;//禁用状态
        $res = $sql->where("news_id = $id")->save($upt);
        if($res){
            echo 1;
        }
    }
    //启用新闻
    public function news_qiyong(){
        $sql = M("news_neirong");
        $id = $_POST['id'];
        $upt['news_status'] = 0;//启用状态
        $res = $sql->where("news_id = $id")->save($upt);
        if($res){
            echo 1;
        }
    }
    //删除新闻
    public function news_del(){
        $sql = M("news_neirong");
        $id = $_POST['id'];
        $res = $sql->where("news_id = $id")->delete();
        if($res){
            echo 1;
        }
    }
    //新闻修改页
    public function news_upt(){
        $id = $_GET['id'];
        $sql = M("news_neirong");
        $find = $sql->where("news_id = $id")->find();   
        $this->assign("find",$find);
        $this->display();
    }
    //修改新闻
    public function con_upt(){
        $sql = M("news_neirong");//连接内容表
        $title = trim($_POST['title']);//内容标题
        $mokuai = $_POST['mokuai'];//模块名称
        $content = $_POST['content'];//正文内容;
        $id = $_POST['id'];//主键id
        $add['news_title'] = $title;
        $add['news_content'] = $content;
        $add['news_mokuai'] = $mokuai;

        $res = $sql->where("news_id = $id")->save($add);
        if(!empty($res)){
            $this->redirect("fabu_news");
        }else{
            echo "系统忙，请稍后重试";
        }
    }
    //预览页面
    public function news_sel(){
        $id = $_GET['id'];
        session("sel_id",null);
        session("sel_id",$id);
        $this->display();
    }
    //手机预览
    public function phone_sel(){
        $id = $_SESSION['sel_id'];
        $sql = M("news_neirong");
        $find = $sql->where("news_id = $id")->find();   
        $this->assign("find",$find);
        $this->display();
    }
}