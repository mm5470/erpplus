<?
require_once("data/conn.php");
require_once("public.php");
require_once("data/template.ease.php");
session_start();
$db=new Dirver();
$db->DBLink($db_server,$db_username,$db_password,$db_name);
$tl = new template();

if(!isset($_SESSION["username"])||$_SESSION["username"]=="")
{
	header("Location:index.php");
}
$act=$_POST["act"];
$id=$_GET["id"];
//echo $act;
if($act=="edit")
{
	$menuid=$_POST["menuid"];//菜單清單
	$snum=count($menuid)-1;
	while( $sid1=$menuid[$snum--])
	{
		$menulist.="'".$sid1."',";
	}
	$groupid=$_POST["groupid"];//頭部菜單清單
	$snum2=count($groupid)-1;
	while( $sid2=$groupid[$snum2--])
	{
		$grouplist.="'".$sid2."',";
	}
	$jobtitle=$_POST["jobtitle"];//頭部菜單清單
	$snum3=count($jobtitle)-1;
	while( $sid3=$jobtitle[$snum3--])
	{
		$jobtitlelist.="'".$sid3."',";
	}
	$grouplist=utf8Substr($grouplist,0,strlen($grouplist)-1);
	$menulist=utf8Substr($menulist,0,strlen($menulist)-1);
	//更新客戶的權限
	//UPDATE
$UpdateSQL = sprintf("UPDATE  mk_user SET `userid`= %s, `username`= %s, `cnname`= %s, `birthday`= %s, `email`= %s, `phone`= %s, `qq`= %s, `password`= %s, `wage`= %s, `bonus`= %s, `level`= %s,`isopen`= %s, `menulist`= %s, `grouplist`= %s,  `jobtitle`= %s,`open_date`= %s, `cls_date`= %s, `add_date`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['userid'] ,"text"),
	 GetSQLValueString($_POST['username'] ,"text"),
	 GetSQLValueString($_POST['cnname'] ,"text"),
	 GetSQLValueString($_POST['birthday'] ,"date"),
	 GetSQLValueString($_POST['email'] ,"text"),
	 GetSQLValueString($_POST['phone'] ,"text"),
	 GetSQLValueString($_POST['qq'] ,"text"),
	 GetSQLValueString($_POST['password'] ,"text"),
	 GetSQLValueString($_POST['wage'] ,"double"),
	 GetSQLValueString($_POST['bonus'] ,"double"),
	 GetSQLValueString($_POST['level'] ,"text"),
	 GetSQLValueString($_POST['isopen'] ,"text"),
	 GetSQLValueString($menulist ,"text"),
	 GetSQLValueString($grouplist ,"text"),
	 GetSQLValueString($jobtitlelist,"text"),
	 GetSQLValueString($_POST['open_date'] ,"date"),
	 GetSQLValueString($_POST['cls_date'] ,"date"),
	 GetSQLValueString($_POST['add_date'] ,"date"),
	 GetSQLValueString($_POST['id'],"int"));
$db->query($UpdateSQL);
     header("Location:employeelist.php");
   
}

		$sql="select * from mk_user where id='".$id."'";
		$rs=$db->rows($sql);
		//職務別
		$sql="select * from mk_jobtitle order by  squee desc,id desc";
        $query = $db->query($sql);
        $jobtitle_list = array();    
	    while($jobtitle= $db->fetch_array($query))
	   {	
         $kk++;
		  if(strstr($rs['jobtitle'],"'".$jobtitle['id']."'"))
					{
						$chk="checked";
					}else{
						$chk="";
						}
		$jobtitle['k']=$kk;
		$jobtitle['chk']=$chk;
		$jobtitle_list[] = $jobtitle;
	  }
		       $sql="SELECT * FROM mk_menugroup ORDER BY mk_menugroup.squee desc,mk_menugroup.id desc";
				$query=$db->query($sql);
				$menugroup1_list =array();
				while($menugroup1=$db->fetch_array($query))
				{
					$k++;
					if(strstr($rs['grouplist'],"'".$menugroup1['id']."'"))
					{
						$chk="checked";
					}else{
						$chk="";
						}
					$sqls="select * from mk_menu where menugroup='".$menugroup1['id']."'";
					$query1=$db->query($sqls);
					$menu2_list=array();
					while($menu2=$db->fetch_array($query1)){
						if(strstr($rs['menulist'],"'".$menu2['id']."'")){
							$chk2="checked";
						}else{
							$chk2="";
							}
						$menu2['chk']=$chk2;
						$menu2_list[]=$menu2;
						}
					$menugroup1['k']=$k;
					$menugroup1['chk']=$chk;
					$menugroup1['sub']=$menu2_list;
					$menugroup1_list[]=$menugroup1;
				}
$tl->set_file('editemployee');
$tl->n();
$tl->p();
$db->close();
?>