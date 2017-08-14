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
    <!-- START OF RIGHT PANEL -->
    <div class="rightpanel">
    	<div class="headerpanel">
        	<a href="" class="showmenu"></a>
            
<?
//載入共用的TOP
include("template_top.php");
?> 
<!--判斷必填欄位--> 
<script type="text/javascript">
	function su()
		{
		return Validate(
			TextValidate("id_name","帳號-必需填寫"),
			TextValidate("user_name","名稱-必需填寫"),
			TextValidate("password","密碼-必需填寫"),
			TextValidate("password2","第二次密碼-必需填寫")
						);
		}
</script> 
            
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
        	<h1>新增帳號</h1> <span>This is a sample description for form styles page...</span>
        </div><!--pagetitle-->
        <div class="maincontent">
        	<div class="contentinner">
                <!--widgetcontent-->
                <h4 class="widgettitle nomargin shadowed">新增帳號</h4>
                <div class="widgetcontent bordered shadowed nopadding">
                    <form class="stdform stdform2" action="member_edit_save.php" method="post"  name="formx" id="formx" onSubmit="return su();" >
                            <p>
                                <label>帳號</label>
                                <span class="field"><input type="text" name="id_name" id="id_name" class="input-xxlarge" /></span>
                            </p>
                            
                            <p>
                                <label>名稱</label>
                                <span class="field"><input type="text" name="user_name" id="user_name" class="input-xxlarge" /></span>
                            </p>

                            <p>
                                <label>密碼</label>
                                <span class="field"><input type="text" name="password" id="password" class="input-xxlarge" /></span>
                            </p>
                            
                            <p>
                                <label>請再輸入一次密碼</label>
                                <span class="field"><input type="text" name="password2" id="password2" class="input-xxlarge" /></span>
                            </p>
                            <p>
                                <label>EMail</label>
                                <span class="field"><input type="text" name="email" id="email" class="input-xxlarge" /></span>
                            </p>
                            <p>
                        	<label>權限設定</label>
                            <span class="field">
                            	<input type="checkbox" name="mpower" value="1" /> 系統權限<br />
                                <input type="checkbox" name="busin_power" value="1"/> 業務權限<br />
                            	<input type="checkbox" name="house_power" value="1"/> 倉儲權限<br />
                                <input type="checkbox" name="super_power" value="1"/> 最高權限<br />
                            	<!--<input type="checkbox" name="check2" checked="checked" /> Checked Checkbox <br />-->
                            </span>
                        	</p>
                            <? if (1==2) {?>
                            <p>
                        	<label>權限設定</label>
                            <span class="field">
                            	<input type="checkbox" name="mpower" value="1" /> 管理者權限<br />
                                <input type="checkbox" name="ppower" value="1"/> 產品<br />
                            	<input type="checkbox" name="apower" value="1"/> 進貨<br />
                                <input type="checkbox" name="cpower" value="1"/> 成品<br />
                                <input type="checkbox" name="spower" value="1"/> 出貨<br />
                                <input type="checkbox" name="mailpower" value="1"/> Mail<br />
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
		alert("兩次輸入的密碼不相同,請重新輸入");  return false; 
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

