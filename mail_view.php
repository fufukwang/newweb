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
//接收資料
  if ($_GET['key']!= ''){
  $key=$_GET['key'];
  }  
?>
<?
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_GET['mid']!= ''){
  $mid=$_GET['mid'];
  }
?>
<?
$sql = 'select * from mail_data';
$sql .='  WHERE mail_id='.$mid;
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
        	<h1>編輯Mail</h1> <span>This is a sample description for form styles page...</span>
        </div><!--pagetitle-->
        <div class="maincontent">
        	<div class="contentinner">
                <!--widgetcontent-->
                <h4 class="widgettitle nomargin shadowed">編輯Mail</h4>
                <div class="widgetcontent bordered shadowed nopadding">
                <? while($row = mysql_fetch_assoc($rs)){?>
                    <form class="stdform stdform2" action="mail_edit_save.php" method="post"  name="formx" id="formx" onSubmit="return su();" >
                    <input type="hidden" name="mid" id="mid" value="<?=$row['mail_id'];?>">
                    <? if ($key==1){?><input type="hidden" id="tag" name="tag" value="1" /><? }?>
					<? if ($key==2){?><input type="hidden" id="tag" name="tag" value="2" /><? }?>
							<p>
                                <label>名稱</label>
                                <span class="field">
                                <input type="text" name="name" id="name" class="input-xxlarge" value="<?=$row['name']; ?>" />
                                </span>
                            </p>
							<? if($key==2){?>
                            <p>
                            	<label>地址</label>
                                <span class="field">
                                <input type="text" name="location" id="location" class="input-xxlarge" value="<?=$row['location']; ?>"/>
                                </span>
                            </p>
							<? }?> 
                            <p>
                                <label>Email</label>
                                <span class="field">
                                <input type="text" name="mail" id="mail" class="input-xxlarge" value="<?=$row['mail']; ?>" />
                                </span>
                            </p>                                                 
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
<?
include("template_down.php");
?>   

    
</div><!--mainwrapper-->
</body>
</html>

