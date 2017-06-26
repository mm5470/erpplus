<?
require_once("data/conn.php");
require_once("public.php");
require_once("data/template.ease.php");
session_start();
$tl = new template();
$db=new Dirver();
$db->DBLink($db_server,$db_username,$db_password,$db_name);

$tl->set_file('wellcome');
$tl->n('wellcome');
$tl->p();
$db->close();
?>