<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>news</title>
<?
include("template_meta.php");
?>
</head>
<body>
<?
include("template_top.php");
?>
<?
include("db.php");
?>
<?
$sql = 'select * from news_data';
$sql .='  ORDER BY inx DESC';
$rs = mysql_query($sql)or die(mysql_error()); //sql查詢
//$news = mysql_fetch_assoc($rs); //建立資料集
?>
<!--from-->
<div id="content">
<div id="page-heading"><h1>新聞列表test</h1></div>

<div id="content-table-inner">
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-check"><a id="toggle-all" ></a> </th>
					<th width="400" class="table-header-repeat line-left minwidth-1"><a href="">新聞標題</a>	</th>
					<th width="500" class="table-header-repeat line-left minwidth-1"><a href="">新聞內容</a></th>
					<th width="100" class="table-header-repeat line-left"><a href="">排序</a></th>
					<th width="100" class="table-header-repeat line-left"><a href="">建立時間</a></th>
					<th class="table-header-repeat line-left"><a href=""></a></th>
				</tr>
				<? while($row = mysql_fetch_assoc($rs)){?>
				<tr>
					<td><input  type="checkbox"/></td>
					<td><?=$row['title']?></td>
					<td><?=$row['content']; ?></td>
					<td><?=$row['inx']; ?></td>
					<td><?=$row['create_date']; ?></td>
					<td class="options-width">
					<a href="news_edit.php?nid=<?=$row['news_id'];?>" title="Edit" class="icon-1 info-tooltip"></a>
					<a href="news_del.php?nid=<?=$row['news_id'];?>" title="Delete" class="icon-2 info-tooltip"></a>
					</td>
				</tr>
				<? }?>
</table>
</div>
<div class="clear">&nbsp;</div>
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
