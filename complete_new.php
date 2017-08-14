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
        	<h1>品項進貨管理</h1>
        </div><!--pagetitle-->
        <div class="maincontent">
        	<div class="contentinner">
                <!--widgetcontent-->
                <h4 class="widgettitle nomargin shadowed">品項零件進貨</h4>
                <div class="widgetcontent bordered shadowed nopadding">
                    <form class="stdform stdform2" action="business_save.php" method="post"  name="formx" id="formx" >
                    <input type="hidden" name="tag" value="complete_update" />
                            <p>
                                <label>成品單號</label>
                                <span class="field"><input type="text" name="number" id="number" required /></span>
                            </p>
                            <p>
                                <label>備註</label>
                                <span class="field"><textarea cols="80" rows="5" name="info" id="info" class="span5"></textarea></span>
                            </p>
                            <p>
                                <label>預計完成日期</label>
                                <span class="field"><input type="text" name="over_date" id="datepicker"></span>
                            </p>  
                            <h4 class="widgettitle nomargin shadowed">進貨明細</h4>                       
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
                                        <th>品項名稱</th>
                                        <th>所需零件</th>
                                        <th>進貨數量</th>
                                    </tr>
                                </thead>
                                <?
								//品項資料庫
								$sql = 'select * from product_data';
								$sql .='  ORDER BY create_time DESC';
								$rs = mysql_query($sql)or die(mysql_error()); //sql查詢
								?>
                                <? while($row = mysql_fetch_assoc($rs)){?>
									<?
                                    //品項零件需求資料庫
                                    $sql = 'select * from product_detail_data';
									$sql .='  WHERE product_id ='.$row['product_id'];
                                    //$sql .='  ORDER BY create_time DESC';
                                    $rs2 = mysql_query($sql)or die(mysql_error()); //sql查詢
                                    ?>
                                <tbody> 
                                    <td><?=$row['name'];?></td>
                                    <td>
                                    <? while($row2 = mysql_fetch_assoc($rs2)){?>
										<?
                                        //零件資料庫
                                        $sql = 'select * from parts_data';
                                        $sql .='  WHERE parts_id ='.$row2['parts_id'];
                                        $sql .='  ORDER BY create_time DESC';
                                        $rs3 = mysql_query($sql)or die(mysql_error()); //sql查詢
                                        $data = mysql_fetch_assoc($rs3); //建立資料集
                                        ?>
                                        零件名稱:<?=$data['name'];?>&nbsp;需求數量/庫存數量:
                                        <span class="needs nedp_<?=$row['product_id'];?>" data-base="<?=$row2['count'];?>" data-parts="<?=$row2['parts_id'];?>">0</span>/<?php
                                            $mysql->table = 'parts_inven_data';
                                            echo mysql_result($mysql->select("WHERE parts_id='{$row2['parts_id']}'",'SUM(count) AS C'),0,'C');
                                        ?><br/>
                                    <? }?>
                                    </td>
                            		<td><input type="text" name="count[]" id="count" onKeyUp="base_parts_plus('<?=$row['product_id'];?>',this.value);" onChange="base_parts_plus('<?=$row['product_id'];?>',this.value);" value="0"></td>
                                    <input type="hidden" name="product_id[]" value="<?=$row['product_id'];?>"  />    
                                </tbody>
                                <? }?>
                            </table>
                            <p class="stdformbutton">
                                <button type="button" id="addpro" class="btn btn-primary">儲存</button>
                                <button type="reset" class="btn">重新填寫</button>
                                <input type="hidden" name="cutid" id="cutid" value="" />
                                <input type="hidden" name="cutnum" id="cutnum" value="" />
                            </p>
                    </form>
                    <table class="table table-bordered">
                        <caption>參考所有零件庫存</caption>
                        <thead>
                            <tr>
                                <th>零件名稱</th>
                                <th>所需數量</th>
                                <th>庫存數量</th>
                            </tr>
                            <?php
                            $mysql->table = 'parts_data';
                            $rs = $mysql->select();
                            while($row = mysql_fetch_assoc($rs)){
                            ?>
                            <tr>
                                <th><?=$row['name']?></th>
                                <th><span id="IsNeed_<?=$row['parts_id']?>">0</span></th>
                                <th><?$mysql->table = 'parts_inven_data';
                                echo mysql_result($mysql->select("WHERE parts_id='{$row['parts_id']}'",'SUM(count) AS C'),0,'C');?></th>
                            </tr>

                            <?php }?>
                        </thead>

                    </table>
                    </div><!--widgetcontent-->
            </div><!--contentinner-->
        </div> 
    </div><!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
    
<?
include("template_down.php");
?>   
<script type="text/javascript">
jQuery(function(){
    var parts_id = [];
    var num      = [];
    jQuery("#addpro").bind("click",function(){
        parts_id = [];
        num      = [];
        jQuery(".needs").each(function(){
            var thispart = jQuery(this).data("parts");
            var thisnum  = parseInt(jQuery(this).text());
            if(thisnum>0){
                var inArr = false;
                for(i=0;i<parts_id.length;i++){
                    if(thispart==parts_id[i]){
                        num[i] = parseInt(num[i]) + thisnum;
                        inArr = true;
                        break;
                    }
                }
                if(!inArr){
                    parts_id.push(thispart);
                    num.push(thisnum);
                }
            }
        });
        jQuery.post("business_save.php",{tag:'parts_num_validate',parts_id:parts_id,num:num},function(data){
            if(data.success=="Y"){
                console.log(data);
                jQuery("#cutid").val(data.cutid);
                jQuery("#cutnum").val(data.cutnum);
                jQuery("#formx").submit();
            } else {
                alert("需求數量超過庫存總數量!無法新增成品!");
            }
        },'json');
    });
    jQuery("#formx").validate();
    //jQuery( "#datepicker" ).datepicker({ dateFormat: "yyyy-mm-dd" });
});
function base_parts_plus(id,val){
    jQuery(".nedp_"+id).each(function(){
        var base = jQuery(this).data("base")
        var tot = base * val;
        jQuery(this).text(tot);
    });
    checkall();
}
function checkall(){
    parts_id = [];
    num      = [];
    jQuery(".needs").each(function(){
        var thispart = jQuery(this).data("parts");
        var thisnum  = parseInt(jQuery(this).text());
        if(thisnum>0){
            var inArr = false;
            for(i=0;i<parts_id.length;i++){
                if(thispart==parts_id[i]){
                    num[i] = parseInt(num[i]) + thisnum;
                    inArr = true;
                    break;
                }
            }
            if(!inArr){
                parts_id.push(thispart);
                num.push(thisnum);
            }
        }
    });
    for(i=0;i<parts_id.length;i++){
        jQuery("#IsNeed_"+parts_id[i]).text(num[i]);
    }
}
</script>
    
</div><!--mainwrapper-->
</body>
</html>
