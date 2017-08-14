<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Katniss Premium Admin Template</title>
<?
//載入共用的CSS 與 JQ
include("template_meta.php");
?>
</head>

<body>

<div class="mainwrapper">
<?
//載入共用的TOP
include("template_left.php");
?>
<?
$sql = 'select * from product_data';
$sql .='  ORDER BY inx DESC';
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
        	<ul class="breadcrumb">
                <li><a href="dashboard.html">Home</a> <span class="divider">/</span></li>
                <li><a href="forms.html">進出貨管理</a> <span class="divider">/</span></li>
                <li class="active">商品出貨</li>
            </ul>
        </div><!--breadcrumbs-->
        <div class="pagetitle">
        	<h1>進出貨管理</h1> <span>This is a sample description for form styles page...</span>
        </div><!--pagetitle-->
        <form action="reserve_edit_save.php" method="post"  name="formx" id="formx" onsubmit="return su();" >
        <input type="hidden" id="tag" name="tag" value="3" />
        <div class="maincontent">
        	<div class="contentinner">
            	<h4 class="widgettitle">商品出貨</h4>
                <div class="widgetcontent">                      	
                                <p>
                                    <label>客戶名稱</label>
                                    <span class="field"><input type="text" name="client" id="client" class="input-xxlarge" /></span>
                                </p>
                                
                                <p>
                                    <label>出貨地點</label>
                                    <span class="field"><input type="text" name="location" id="location" class="input-xxlarge" /></span>
                                </p>                
                        <div class="control-group">    
                        	<label class="control-label" for="number">品項:</label>
                                <select name="product_id" id="product_id" class="uniformselect" style="opacity: 0;">
                                    <option value="">Choose One</option>
                                <? while($row = mysql_fetch_assoc($rs)){?>    
                                	<?
									//計算成品總量
									$sql = 'select * from complete_detail_data';
									$sql .=' Where product_id ='.$row['product_id'];
									$rs3 = mysql_query($sql)or die(mysql_error()); //sql查詢
									$complete_count = 0;
									$complete_all = 0;
										while($row3 = mysql_fetch_assoc($rs3)){
										   $complete_count = intval($row3['count']); 
										   $complete_all = $complete_all+ $complete_count;   
										} 
									?>
									<?
									//計算出貨總量
									$sql = 'select * from shipments_detail_data';
									$sql .=' Where product_id ='.$row['product_id'];
									$rs2 = mysql_query($sql)or die(mysql_error()); //sql查詢
									$shipments_count = 0;
									$shipments_all = 0;
										while($row2 = mysql_fetch_assoc($rs2)){
										   $shipments_count = intval($row2['count']); 
										   $shipments_all = $shipments_all + $shipments_count  ;
										} 
									?> 
                                    
                                    <? $all = intval($complete_all)-intval($shipments_all)?> 
                                    <option value="<?=$row['product_id'];?>" key="<?=$all?>"><?=$row['number']; ?>(<?=$row['name']; ?>) 可出貨量(<? echo $all;?>)</option>
                                    
                                <? }?>    
                                </select>
                        </div>
                        <div class="control-group">
                        <label>出貨數量</label>
                            <span class="field"><input type="text" id="count" class="input-small input-spinner" /></span>
                        </div>        
                        <p class="stdformbutton">
                            <button type="button" class="btn btn-primary" id="addpro" >新增</button>
                        </p>
                                      
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
                            <th>數量</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody id="test"> 
                        
                    </tbody>
                </table> 
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
		//var PName = jQuery("#").val();
		//alert("庫存"+key);
		//alert("進貨量"+count);
		if(key < count){ alert("成品不足");  return false; }
		var dnum = jQuery("#dom_"+ProSN).length;
		if(dnum>0){ alert("有資料了啦");  return false; }
	var dom = '<tr id="dom_'+ProSN+'">' +
                            '<td><input type="text" name="ProName[]" value="'+name+'" readonly/></td>' +
                            '<td><input type="text" name="Num[]" value="'+count+'" readonly/></td>' +
                            '<td><input type="button" value="刪除" onclick="jQuery(\'#dom_'+ProSN+'\').remove();" />'+
							'<input type="hidden" name="ProSN[]" value="'+ProSN+'"  /></td>' +
                        '</tr>';
		jQuery("#test").append(dom);
		
	});
	

	
	
});
</script>
    <div class="clearfix"></div>
    
<?
include("template_down.php");
?>   

    
</div><!--mainwrapper-->
</body>
</html>
