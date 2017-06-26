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
	$jobtitle=$_POST["jobtitle"];//頭部菜單清單
	$snum2=count($jobtitle)-1;
	while( $sid2=$jobtitle[$snum2--])
	{
		$jobtitlelist.="'".$sid2."',";
	}
	$jobtitlelist=utf8Substr($jobtitlelist,0,strlen($jobtitlelist)-1);
	//UPDATE
$UpdateSQL = sprintf("UPDATE  mk_contact_unit SET `contactnum`= %s, `unitnum`= %s, `position`= %s, `jobtitle`= %s, `memo`= %s, `adddate`= %s, `lastrevisiondate`= %s, `lastrevision`= %s, `startdate`= %s, `enddate`= %s, `valid`= %s where   `id`= %s ",
	 GetSQLValueString($_POST['contactnum'] ,"int"),
	 GetSQLValueString($_POST['unitnum'] ,"int"),
	 GetSQLValueString($_POST['position'] ,"text"),
	 GetSQLValueString($jobtitlelist,"text"),
	 GetSQLValueString($_POST['memo'] ,"text"),
	 GetSQLValueString($_POST['adddate'] ,"date"),
	 GetSQLValueString($_POST['lastrevisiondate'] ,"date"),
	 GetSQLValueString($_SESSION['username'] ,"text"),
	 GetSQLValueString($_POST['startdate'] ,"date"),
	 GetSQLValueString($_POST['enddate'] ,"date"),
	 GetSQLValueString($_POST['valid'] ,"text"),
	 GetSQLValueString($id,"int"));
     $db->query($UpdateSQL);
    header("Location:contact-unit.php");
   
}

		$sql="select * from mk_contact_unit where id='".$id."'";
		$rs=$db->rows($sql);
		
		 $contactsql = "select * from mk_contact where contactnum='".$rs['contactnum']."'";
	     $rscontact=$db->rows($contactsql);
	     $unitsql = "select * from mk_unit where id='".$rs['unitnum']."'";
	     $rsunit=$db->rows($unitsql);
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
		  
$tl->set_file('editcontact-unit');
$tl->n();
$tl->p();
$db->close();
?>