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
$sql = 'select * from product_data';
$sql .=' Where product_id ='.$pid;
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
        	<h1>品項管理</h1> <span>This is a sample description for form styles page...</span>
        </div><!--pagetitle-->
        <div class="maincontent">
        	<div class="contentinner">
                <!--widgetcontent-->
                <h4 class="widgettitle nomargin shadowed">新增品項</h4>
                <div class="widgetcontent bordered shadowed nopadding">
                    <form class="stdform stdform2" action="product_edit_save.php" method="post"  name="formx" id="formx" >
                    <input type="hidden" name="pid"  value="<?=$pid?>"> 
                            <p>
                                <label>品項名稱</label>
                                <span class="field"><input type="text" name="name" id="name" value="<?=$data['name'];?>" class="input-xxlarge" /></span>
                                
                            </p>
                            <p>
                                <label>低庫存提醒</label>
                                <span class="field"><input type="text" name="lowalert" id="lowalert" value="<?=$data['lowalert'];?>" class="input-xxlarge" /></span>
                            </p>
                            <p>
                                <label>描述</label>
                                <span class="field"><textarea cols="80" rows="5" name="info" id="info" class="span5"><?=$data['info'];?></textarea></span>
                               
                            </p> 
                            <h4 class="widgettitle nomargin shadowed">所需零件</h4>                       
                            <table class="table table-bordered">
                                <colgroup>
                                    <col class="con0">
                                    <col class="con1">
                                    <col class="con0">
                                    <col class="con1">
                                    <col class="con0">
                                    <col class="con1">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>零件名稱</th>
                                        <th>所需數量</th>
                                    </tr>
                                </thead>
                                <?
								$sql = 'select * from parts_data';
								$sql .='  ORDER BY create_time DESC';
								$rs2 = mysql_query($sql)or die(mysql_error()); //sql查詢
								?>
                                <? while($row2 = mysql_fetch_assoc($rs2)){?>
                                	<?
									$sql = 'select * from product_detail_data';
									$sql .='  WHERE product_id='.$pid;
									$sql .='  AND parts_id='.$row2['parts_id'];
									$rs3 = mysql_query($sql)or die(mysql_error()); //sql查詢
									$data2 = mysql_fetch_assoc($rs3); //建立資料
									?>
                                <tbody> 
                                    <td><?=$row2['name'];?></td>
                                    <? if ($row2['parts_id'] == $data2['parts_id']){?>
                            		<td <? if($data2['count']!= 0){?>style="background-color:#F00;"<? }?>><input type="text" name="count[]" id="count" value="<?=$data2['count'];?>"></td>
                                    <? }else{?>
                                    <td><input type="text" name="count[]" id="count" value="0"></td>
                                    <? }?>
                                    <input type="hidden" name="parts_id[]" value="<?=$row2['parts_id'];?>"/>    
                                </tbody>
                                <? }?>
                            </table>
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
