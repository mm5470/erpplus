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

$alertstr="";
  //list post
	$sql="select * from mk_jobtitle order by  squee desc,id desc";
   $query = $db->query($sql);
   $jobtitle_list = array();    
	while($jobtitle= $db->fetch_array($query))
	{	
        $kk++;
		$jobtitle['k']=$kk;
		$jobtitle_list[] = $jobtitle;
	}
if($act=="add")
{
		$jobtitle=$_POST["jobtitle"];
		$snum2=count($jobtitle)-1;
		while( $sid2=$jobtitle[$snum2--])
		{
			$jobtitlelist.="'".$sid2."',";
		}
		$jobtitlelist=utf8Substr($jobtitlelist,0,strlen($jobtitlelist)-1);
		//INSEART
$InsertSQL = sprintf("INSERT INTO  mk_contact_unit (`contactnum`,`unitnum`,`position`,`jobtitle`,`memo`,`adddate`,`startdate`,`enddate`,`valid`) VALUES (%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s ,%s )",
	 GetSQLValueString($_POST['contactnum'],"int"),
	 GetSQLValueString($_POST['unitnum'],"int"),
	 GetSQLValueString($_POST['position'],"text"),
	 GetSQLValueString($jobtitlelist,"text"),
	 GetSQLValueString($_POST['memo'],"text"),
	 GetSQLValueString($_POST['adddate'],"date"),	
	 GetSQLValueString($_POST['startdate'],"date"),
	 GetSQLValueString($_POST['enddate'],"date"),
	 GetSQLValueString($_POST['valid'],"text"));
$db->query($InsertSQL);
//echo $InsertSQL;
		 header("Location:contact-unit.php");
		
}
$tl->set_file('addcontact-unit');
$tl->n();
$tl->p();
$db->close();
?>