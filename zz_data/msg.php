<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>news_new</title>
<?
include("template_meta.php");
?>
</head>
<?
$nid = $_GET['nid'];
?>
<body>
<?
include("template_top.php");
?>
<!--from-->
<div id="content">
<?
if ($nid == ''){
?>
<div id="page-heading"><h1>新增成功</h1></div>
<?
}
else
{
?>
<div id="page-heading"><h1>編輯成功</h1></div>
<?
}
?>
<div class="clear">&nbsp;</div>
<div id="page-heading"><a href="news_list.php">返回列表</a></div>
</div>

<!--footer-->
<div id="footer" style="margin-top:0px">
	<!--  start footer-left -->
	<div id="footer-left">
	Admin Skin &copy; Copyright Internet Dreams Ltd. <a href="">www.netdreams.co.uk</a>. All rights reserved.</div>
	<!--  end footer-left -->
	<div class="clear">&nbsp;</div>
</div>
</body>
</html>
