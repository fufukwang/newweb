<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>news</title>
<?
include("template_meta.php");
?>
</head>
<script type="text/javascript">
	function su()
		{
		return Validate(
			TextValidate("title","標題必需填寫")
						);
		}
</script>
<body>
<?
include("template_top.php");
?>
<!--from-->
<div id="content">
<div id="page-heading"><h1>新增新聞</h1></div>
<form action="news_edit_save.php" method="post"  name="formx" id="formx" onsubmit="return su();" >
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
<div id="content-table-inner">
	<td id="tbl-border-left"></td>
	<td>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr valign="top">
			<td>
				<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<th valign="top">新聞標題:</th>
					<td><input type="text" id="title" name="title" class="inp-form-error" /></td>
					<td>
					<div class="error-left"></div>
					<div class="error-inner">此為必填欄位</div>
					</td>
				</tr>
				<tr>
					<th valign="top">分類（沒接）:</th>
					<td>	
					<select  class="styledselect_form_1">
						<option value="">All</option>
						<option value="">Products</option>
						<option value="">Categories</option>
						<option value="">Clients</option>
						<option value="">News</option>
					</select>
					</td>
				</tr>	
				<tr>
					<th valign="top">新聞內容:</th>
					<td><textarea rows="" cols="" id"content" name="content" class="form-textarea"></textarea></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">排序:</th>
					<td><input type="text" id="inx" name="inx" class="inp-form-error" /></td>
					<td>
					<div class="error-left"></div>
					<div class="error-inner">預設為0</div>
					</td>
				</tr>
			<tr>
				<th>圖片上傳（沒接）:</th>
				<td><input type="file" class="file_1" /></td>
				<td>
				<div class="bubble-left"></div>
				<div class="bubble-inner">JPEG, GIF 5MB max per image</div>
				<div class="bubble-right"></div>
				</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td valign="top">
					<input type="submit" value="" class="form-submit" />
					<input type="reset" value="" class="form-reset"  />
				</td>
				<td></td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td><img src="images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
			</tr>
		</table>
	</td>
	<td id="tbl-border-right"></td>
</div>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>
</form>	
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
