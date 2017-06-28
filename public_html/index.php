<?
require_once("data/conn.php");
require_once("public.php");
require_once("data/template.ease.php");
session_start();
$tl = new template();
$db=new Dirver();
$db->DBLink($db_server,$db_username,$db_password,$db_name);
$act=$_GET["act"];
$iserror="N";
switch($act)
{
	case "login":
		$loginname = $_POST['username'];
		$loginpws = $_POST['password'];	
		if($_SESSION['grouplist']<>""){$_SESSION['grouplist']=="";}
		$sql="select * from mk_user where username='".$loginname."' and isopen='Y' limit 1";
			$nums=$db->nums($sql);		
			
			$rs=$db->rows($sql);
			if($nums>0)
			{
				if($rs["password"]==$loginpws)
				{
					
					$_SESSION["username"]=$rs["username"];//用戶帳號
					$_SESSION['menulist']=$rs['menulist'];
					$_SESSION['grouplist']=$rs['grouplist'];
					$_SESSION['level']=$rs['level'];
					$logip=getIP();
					//INSEART
                     $InsertSQL = sprintf("INSERT INTO  mk_loglist (`log_name`,`log_date`,`log_ip`) VALUES (%s ,%s ,%s  )",
					 GetSQLValueString($rs["username"],"text"),
					 GetSQLValueString("","date"),
					 GetSQLValueString($logip,"text"));
					// echo $InsertSQL;
				     $db->query($InsertSQL);
					echo "<script>location.href='wellcome.php';</script>";	
				}
				else
				{
					$iserror="Y";
					$errmsg="密碼出錯！";
				}
			  
			}
	break;
	case "logout": 
	  session_unset();
      session_destroy(); 
	  header("Location:index.php");
   break; 
	
}

$tl->set_file('index');
$tl->n();
$tl->p();
$db->close();
?>