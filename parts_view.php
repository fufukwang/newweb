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
$pid = $_GET['pid'];
$sql = 'select * from parts_data';
$sql .=' Where parts_id ='.$pid;
$rs = mysql_query($sql)or die(mysql_error()); //sql查詢
$data = mysql_fetch_assoc($rs); //建立資料集
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
			TextValidate("name","零件名稱-必需填寫")
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
        	<h1>零件管理</h1> <span>This is a sample description for form styles page...</span>
        </div><!--pagetitle-->
                <div class="maincontent">
        	<div class="contentinner">
                <!--widgetcontent-->
                <h4 class="widgettitle nomargin shadowed">編輯零件</h4>
                <div class="widgetcontent bordered shadowed nopadding">
                    <form class="stdform stdform2" action="parts_edit_save.php" method="post"  name="formx" id="formx" >
                    <input type="hidden" id="pid" name="pid" value="<?=$data['parts_id'];?>" />
                            <p>
                                <label>零件名稱</label>
                                <span class="field"><input type="text" name="name" id="name" value="<?=$data['name'];?>" class="input-xxlarge" /></span>
                            </p>
                            <p>
                                <label>低庫存提醒</label>
                                <span class="field"><input type="text" name="lowalert" id="lowalert" value="<?=$data['lowalert'];?>" class="input-xxlarge" /></span>
                            </p>
                            <p>
                                <label>所屬廠商</label>
                                <span class="field">								
								<?
                                //抓所有商資料
                                $sql = 'select * from vendors_data';
								$sql .='  ORDER BY create_time DESC';
                                $rs3 = mysql_query($sql)or die(mysql_error()); //sql查詢
                                ?>  
                                <? while($row3 = mysql_fetch_assoc($rs3)){?> 
									<?
                                    //抓本零件的廠商
                                    $sql = 'select COUNT(detail_id) AS con from parts_detail_data';
                                    $sql .=' Where pid ='.$data['parts_id'];
									$sql .=' And vid ='.$row3['vendors_id'];
                                    $rs2 = mysql_query($sql)or die(mysql_error()); //sql查詢
									$cont = mysql_fetch_assoc($rs2); //建立資料集
                                    ?>   
                                <input type="checkbox" id="vendors" name="vendors[]" value="<?=$row3['vendors_id'];?>" <? if ($cont['con'] != 0){ ?>checked="checked"<? }?> /><?=$row3['name'];?>
                                <? }?> 
                                </span>
                            </p>
                            <p>
                                <label>描述</label>
                                <span class="field"><textarea cols="80" rows="5" name="info" id="info" class="span5"><?=$data['info'];?></textarea></span>
                            </p>                                                    
                            <p class="stdformbutton">
                                <button type="submit" id="addpro" class="btn btn-primary">儲存</button>
                                <button type="reset" class="btn">重新填寫</button>
                            </p>
                        </form>
                    </div><!--widgetcontent-->
            </div><!--contentinner-->
        </div> 
    </div><!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
    
<?
include("template_down.php");
?>   
<script language="javascript">
jQuery(function(){
    jQuery("#formx").validate({
        rules:{
            lowalert:{
                required:true,
                number:true
            },
            name:{
                required:true
            }
        }
    });
});
</script>
    
</div><!--mainwrapper-->
</body>
</html>
