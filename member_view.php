<?
//載入共用的CSS 與 JQ
include("template_meta.php");
?>


<body>

<div class="mainwrapper">
<?
//載入共用的TOP
include("template_left.php");
?>
<?
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_GET['mid']!= ''){
  $mid=$_GET['mid'];
  }
?>
<?
$sql = 'select * from member_data';
$sql .='  WHERE member_id='.$mid;
$rs = mysql_query($sql)or die(mysql_error()); //sql查詢
?>		 	    
    <!-- START OF RIGHT PANEL -->
    <div class="rightpanel">
    	<div class="headerpanel">
        	<a href="" class="showmenu"></a>
            
<?
//載入共用的TOP
include("template_top.php");
?>  
            
    	</div><!--headerpanel-->
        <div class="breadcrumbwidget">
        	<ul class="skins">
                <li><a href="default" class="skin-color default"></a></li>
                <li><a href="orange" class="skin-color orange"></a></li>
                <li><a href="dark" class="skin-color dark"></a></li>
                <li>&nbsp;</li>
                <li class="fixed"><a href="" class="skin-layout fixed"></a></li>
                <li class="wide"><a href="" class="skin-layout wide"></a></li>
            </ul><!--skins-->
<?
//載入共用的麵包屑
include("template_bread.php");
?> 
        </div><!--breadcrumbs-->
        <div class="pagetitle">
        	<h1>編輯帳號</h1> <span>This is a sample description for form styles page...</span>
        </div><!--pagetitle-->
        <div class="maincontent">
        	<div class="contentinner">
                <!--widgetcontent-->
                <h4 class="widgettitle nomargin shadowed">編輯帳號</h4>
                <div class="widgetcontent bordered shadowed nopadding">
                <? while($row = mysql_fetch_assoc($rs)){?>
                    <form class="stdform stdform2" action="member_edit_save.php" method="post"  name="formx" id="formx" onSubmit="return su();" >
                    <input type="hidden" name="mid" id="mid" value="<?=$row['member_id'];?>">
                            <p>
                                <label>帳號</label>
                                <span class="field"><input type="text" name="id_name" id="id_name" class="input-xxlarge" value="<?=$row['id_name']; ?>" /></span>
                            </p>
                            <p>
                                <label>名稱</label>
                                <span class="field"><input type="text" name="user_name" id="user_name" class="input-xxlarge" value="<?=$row['user_name']; ?>" /></span>
                            </p>
                            <p>
                                <label>修改密碼(如果不須修改,請勿填寫)</label>
                                <span class="field"><input type="text" name="password" id="password" class="input-xxlarge" /></span>
                            </p>
                            
                            <p>
                                <label>請再輸入一次密碼</label>
                                <span class="field"><input type="text" name="password2" id="password2" class="input-xxlarge" /></span>
                            </p>
                            <p>
                                <label>EMail</label>
                                <span class="field"><input type="text" name="email" id="email" class="input-xxlarge" value="<?=$row['email']; ?>" /></span>
                            </p>
                            <p>
                        	<label>權限設定</label>
                            <span class="field">
                            	<input type="checkbox" name="mpower" value="1" <? if ($row['mpower']!= 0){ ?>checked="checked"<? }?> /> 系統權限<br />
                                <input type="checkbox" name="busin_power" value="1" <? if ($row['busin_power']!= 0){ ?>checked="checked"<? }?>/> 業務權限<br />
                            	<input type="checkbox" name="house_power" value="1" <? if ($row['house_power']!= 0){ ?>checked="checked"<? }?>/> 倉儲權限<br />
                                <input type="checkbox" name="super_power" value="1" <? if ($row['super_power']!= 0){ ?>checked="checked"<? }?>/> 最高權限<br />
                            	<!--<input type="checkbox" name="check2" checked="checked" /> Checked Checkbox <br />-->
                            </span>
                        	</p>
                            <? if (1==2) {?>
                            <p>
                        	<label>權限設定</label>
                            <span class="field">
                            	<input type="checkbox" name="mpower" value="1" <? if ($row['mpower']!= 0){ ?>checked="checked"<? }?> /> 管理者權限<br />
                                <input type="checkbox" name="ppower" value="1" <? if ($row['ppower']!= 0){ ?>checked="checked"<? }?>/> 產品<br />
                            	<input type="checkbox" name="apower" value="1" <? if ($row['apower']!= 0){ ?>checked="checked"<? }?>/> 進貨<br />
                                <input type="checkbox" name="cpower" value="1" <? if ($row['cpower']!= 0){ ?>checked="checked"<? }?>/> 成品<br />
                                <input type="checkbox" name="spower" value="1" <? if ($row['spower']!= 0){ ?>checked="checked"<? }?>/> 出貨<br />
                                <input type="checkbox" name="mailpower" value="1" <? if ($row['mailpower']!= 0){ ?>checked="checked"<? }?>/> Mail<br />
                            	<!--<input type="checkbox" name="check2" checked="checked" /> Checked Checkbox <br />-->
                            </span>
                        	</p>
                            <? }?>
                            <!--<p>
                                <label>Location <small>You can put your own description for this field here.</small></label>
                                <span class="field"><textarea cols="80" rows="5" name="location" id="location2" class="span5"></textarea></span>
                            </p>-->
                            
                            <!--<p>
                                <label>Select</label>
                                <span class="field"><select name="selection" id="selection2" class="uniformselect">
                                    <option value="">Choose One</option>
                                    <option value="1">Selection One</option>
                                    <option value="2">Selection Two</option>
                                    <option value="3">Selection Three</option>
                                    <option value="4">Selection Four</option>
                                </select></span>
                            </p>-->
                                                    
                            <p class="stdformbutton">
                                <button type="submit" id="addpro" class="btn btn-primary">儲存</button>
                                <button type="reset" class="btn">重新填寫</button>
                            </p>
                        </form>
                     <? }?>     
                    </div><!--widgetcontent-->
            </div><!--contentinner-->
        </div><!--maincontent-->
        
    </div>             
    <!-- END OF RIGHT PANEL -->
    <div class="clearfix"></div>
<script language="javascript">
jQuery(function(){
	jQuery("#addpro").bind("click",function(){
		var pw1 = jQuery("#password").val();
		var pw2 = jQuery("#password2").val();
		if(pw1 != pw2)
		{ 
		alert("密碼不相同,請檢查後重新輸入");  return false; 
		}	
		else
		{
		jQuery('#formx').submit();
		}	
	});	
});
</script>    
<?
include("template_down.php");
?>   

    
</div><!--mainwrapper-->
</body>
</html>

