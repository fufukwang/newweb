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
		var ProSN = jQuery("#product_id").val();	
		var dnum = jQuery("#dom_"+ProSN).length;
		if(dnum == 0){ alert("還沒新增任何成品項目");  return false; }
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
        	<ul class="breadcrumb">
                <li><a href="dashboard.html">Home</a> <span class="divider">/</span></li>
                <li><a href="forms.html">進出貨管理</a> <span class="divider">/</span></li>
                <li class="active">成品建立</li>
            </ul>
        </div><!--breadcrumbs-->
        <div class="pagetitle">
        	<h1>進出貨管理</h1> <span>This is a sample description for form styles page...</span>
        </div><!--pagetitle-->
        <form action="business_save.php" method="post"  name="formx" id="formx" >
        <div class="maincontent">
        	<div class="contentinner">
            	<h4 class="widgettitle">取消成品</h4>
                <div class="alert alert-error">
                  <button data-dismiss="alert" class="close" type="button">×</button>
                  <strong>請注意!</strong> 請確定成品的數量在進行此操作,以免造成庫存混亂.
                </div> 
                <div class="widgetcontent">
                    <input type="hidden" id="tag" name="tag" value="complete_cancel" />
                        <div class="control-group">    

                            <p>
                                <label>取消日期</label>
                                <span class="field"><input type="text" name="over_date" id="datepicker"></span>
                            </p>


                        	<label class="control-label" for="number">品項:</label>
                                <select name="complete_id" id="complete_id" class="uniformselect" style="opacity: 0;">
                                    <option value="">Choose One</option>
                                    <?php
                                        $mysql->table = 'complete_data';
                                        $day = time()-(86400*14);
                                        $rs = $mysql->select("WHERE cancel=0 AND ATime>{$day}");
                                        while($row = mysql_fetch_assoc($rs)){
                                    ?><option value="<?=$row['complete_id']?>"><?=$row['number']?>(<?=$row['create_time']?>)</option>
                                    <?php }?>
                                <? /* while($row = mysql_fetch_assoc($rs)){?>    
                                	<?
									//計算進貨總量
									$sql = 'select * from purchase_detail_data';
									$sql .=' Where product_id ='.$row['product_id'];
									$rs2 = mysql_query($sql)or die(mysql_error()); //sql查詢
									$purchase_count = 0;
									$purchase_all = 0;
										while($row2 = mysql_fetch_assoc($rs2)){
										   $purchase_count = intval($row2['count']); 
										   $purchase_all = $purchase_all+ intval($purchase_count);   
										} 
									?> 
                                    <?
									//計算成品總量
									$sql = 'select * from complete_detail_data';
									$sql .=' Where product_id ='.$row['product_id'];
									$rs3 = mysql_query($sql)or die(mysql_error()); //sql查詢
									$complete_count = 0;
									$complete_all = 0;
										while($row3 = mysql_fetch_assoc($rs3)){
										   $complete_count = intval($row3['count']); 
										   $complete_all = $complete_all+ intval($complete_count);   
										} 
									?>
                                    <?
									//計算出貨總量
									$sql = 'select * from shipments_detail_data';
									$sql .=' Where product_id ='.$row['product_id'];
									$rs4 = mysql_query($sql)or die(mysql_error()); //sql查詢
									$shipments_count = 0;
									$shipments_all = 0;
										while($row4 = mysql_fetch_assoc($rs4)){
										   $shipments_count = intval($row4['count']); 
										   $shipments_all = $shipments_all + $shipments_count  ;
										} 
									?> 
                                    <? $all = intval($complete_all)- intval($shipments_all)?>   
                                    <option value="<?=$row['product_id'];?>" key="<?=$all?>"><?=$row['number']; ?>(<?=$row['name']; ?>) 可取消數量(<? echo $all;?>)</option>
                                    
                                <? } */?>    
                                </select>  14 天內新增成品可進行取消作業
                        </div>
                        <!--div class="control-group">
                        <label>成品數量</label>
                            <span class="field"><input type="text" id="count" name="count" class="input-small input-spinner" /></span>
                        </div>        
                        <p class="stdformbutton">
                            <button type="button" class="btn btn-primary" id="addpro" >新增</button>
                        </p-->
                                      
                </div><!--widgetcontent-->
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
                            <th>商品型號</th>
                            <th>預計成品數量</th>
                            <th>取消數量</th>
                        </tr>
                    </thead>
                    <tbody id="Pro_list"> 
                        
                    </tbody>
                </table>
                <p></p>
                <div class="control-group">
                    <label>備註</label>
                    <textarea cols="80" rows="5" name="info" id="info" class="span5"></textarea>
                </div> 
               		                 
                <p class="stdformbutton">
                    <button type="submit" class="btn btn-primary">儲存</button>
                </p>
                  
            </div><!--contentinner-->
        </div><!--maincontent--></form>      
    </div><!--mainright-->
    <!-- END OF RIGHT PANEL -->
<script language="javascript">
jQuery(function(){
	jQuery("#addpro").bind("click",function(){
		var ProSN = jQuery("#product_id").val();
		var count = parseInt(jQuery("#count").val());
		var name = jQuery("#product_id option:selected").text();
		var key = parseInt(jQuery("#product_id option:selected").attr('key'));
		if(ProSN==0){ alert("請選取品項");  return false; } //判斷是否有選取
		if(isNaN(count)){ alert("請填寫成品數量");  return false; } //判斷是否為空值
		//var PName = jQuery("#").val();
		//alert("庫存"+key);
		//alert("進貨量"+count);
		if(key < count){ alert("成品不足");  return false; }
		var dnum = jQuery("#dom_"+ProSN).length;
		if(dnum>0){ alert("有資料了啦");  return false; }
	var dom = '<tr id="dom_'+ProSN+'">' +
                            '<td><input type="hidden" type="text" name="ProName[]" value="'+name+'" readonly/>'+name+'</td>' +
                            '<td><input type="hidden" type="text" name="Num[]" value="'+count+'" readonly/>'+count+'</td>' +
                            '<td><input type="button" value="刪除" onclick="jQuery(\'#dom_'+ProSN+'\').remove();" />'+
							'<input type="hidden" name="ProSN[]" value="'+ProSN+'"  /></td>' +
                        '</tr>';
		jQuery("#test").append(dom);
		
	});
	jQuery("#complete_id").bind("change",function(){
        var complete_id = jQuery("#complete_id").val();
        if(parseInt(complete_id)>0){
          jQuery.post('business_save.php',{tag:'complete_c_list',complete_id:complete_id},function(data){
            var dom = '';
            for(i=0;i<data.length;i++){
                dom += '<input type="hidden" name="ProID[]" value="'+data[i].product_id+'" />';
                dom += '<tr><td>'+data[i].name+'</td><td>'+data[i].count+'</td>';//data[i].save
                dom += '<td><input type="text" name="Num[]" value="'+data[i].count+'" number min="0" max="'+data[i].count+'" /></td></tr>';
            }
            jQuery("#Pro_list").html(dom);
          },'json');
        } else { jQuery("#Pro_list").html(''); }
    });
    jQuery("#formx").validate();
	
});
</script>
    <div class="clearfix"></div>
    
<?
include("template_down.php");
?>   

    
</div><!--mainwrapper-->
</body>
</html>
