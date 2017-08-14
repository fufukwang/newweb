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
$mysql->table = 'Business_data';
$BID = _get('BID');
$data = array();
$data = mysql_fetch_assoc($mysql->select("WHERE BID='$BID'"));

$data['Info'] = unserialize($data['Info']);
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
<!--判斷必填欄位--> 
<script type="text/javascript">
	function su()
		{
		
		var dnum = jQuery(".count_tr").length;
		if(dnum == 0){ alert("Not add any demand items");  return false; }
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
        	<h1>Create New Order</h1> <span></span>
        </div><!--pagetitle-->
        <form action="business_save.php" method="post"  name="formx" id="formx" onSubmit="return su();" >
        <input type="hidden" id="tag" name="tag" value="busupdate" />
        <input type="hidden" id="BID" name="BID" value="<?=$data['BID']?>" />
        <div class="maincontent">
        	<div class="contentinner">
            	<h4 class="widgettitle">Create New Order</h4>
                <div class="widgetcontent">                      	
                                <p>
                                    <label>Invoice No.</label>
                                    <span class="field"><input type="text" name="SN" id="SN" class="input-xxlarge" value="<?=$data['SN']?>" required /></span>
                                </p>
                                <p>
                                    <label>Customer</label>
                                    <span class="field"><input type="text" name="IName" id="IName" class="input-xxlarge" value="<?=$data['Info']['IName']?>" /></span>
                                </p> 
                                <p>
                                    <label>Customer Address</label>
                                    <span class="field"><input type="text" name="IAddr" id="IAddr" class="input-xxlarge" value="<?=$data['Info']['IAddr']?>" /></span>
                                </p> 
                                <p>
                                    <label>Delivery charge</label>
                                    <span class="field"><input type="text" name="Freight" id="Freight" class="input-xxlarge" value="<?=$data['Freight']?>" required number /></span>
                                </p> 
                                <p>
                                    <label>Carrier</label>
                                    <select name="mail_id" id="mail_id" class="uniformselect" required>
                                        <option value="">Please select Carrier</option>
                                        <?php 
                                        $mysql->table = 'mail_data';
                                        $query = $mysql->select("WHERE tag=2");
                                        while($row = mysql_fetch_assoc($query)){
                                            echo '<option value="'.$row['mail_id'].'">'.$row['name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </p>
                                <p>
                                    <label>Shipping Address</label>
                                    <span class="field"><input type="text" name="ISite" id="ISite" class="input-xxlarge" value="<?=$data['Info']['ISite']?>" /></span>
                                </p> 
                                <p>
                                    <label>Per</label>
                                    <span class="field"><input type="text" name="Per" id="Per" class="input-xxlarge" value="<?=$data['Info']['Per']?>" /></span>
                                </p> 
                        <div class="control-group">    
                        	<label class="control-label" for="number">Item:</label>
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
                                    <option value="<?=$row['product_id'];?>" key="<?=$all?>"><?=$row['number']; ?>(<?=$row['name']; ?>)</option>
                                    
                                <? }?>    
                                </select>
                        </div>
                        <div class="control-group">
                        <label>Quantity</label>
                            <span class="field"><input type="text" id="count" name="count" class="input-small input-spinner" /></span>
                        <label>Unit Price USD</label>
                            <span class="field"><input type="text" id="price" name="price" class="input-small input-spinner" /></span>
                            </div>
                        
                        
                        <p class="stdformbutton">
                            <button type="button" class="btn btn-primary" id="addpro" >Confirm</button>
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
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Price USD</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody id="test"> 
<?php $mysql->table = 'BDataDetail';
$result = $mysql->select("LEFT JOIN product_data USING(product_id) WHERE BID='$BID'","name,product_data.product_id,count,price");
while($r = mysql_fetch_assoc($result)){?>
                        <tr class="count_tr" id="dom_<?=$r['product_id']?>">
                            <td><input type="hidden" type="text" name="ProName[]" value="<?=$r['name']?>" readonly/><?=$r['name']?></td>
                            <td><input type="hidden" type="text" name="Num[]" value="<?=$r['count']?>" readonly/><?=$r['count']?></td>
                            <td><input type="hidden" type="text" name="Price[]" value="<?=$r['price']?>" readonly/><?=$r['price']?></td>
                            <td><input type="button" value="刪除" onClick="remove_id(<?=$r['product_id']?>);" />
                            <input type="hidden" name="ProSN[]" value="<?=$r['product_id']?>"  /></td>
                        </tr>
<?php }?>
                    </tbody>
                </table>
                <p></p> 
                <div class="control-group">
                    <label>Remark</label>
                    <textarea cols="80" rows="5" name="INotes" id="INotes" class="span5"><?=$data['Info']['INotes']?></textarea>
                </div> 
               		                 
                <p class="stdformbutton">
                    <button type="submit" class="btn btn-primary">Submit</button>
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
        var price = parseInt(jQuery("#price").val());
		var name = jQuery("#product_id option:selected").text();
		var key = parseInt(jQuery("#product_id option:selected").attr('key'));
		if(ProSN==0){ alert("Please select Item");  return false; } //判斷是否有選取
		if(isNaN(count)){ alert("Please fill in Quantity");  return false; } //判斷是否為空值
        if(isNaN(price)){ alert("Please fill in Unit Price USD");  return false; } //判斷是否為空值
		//var PName = jQuery("#").val();
		//alert("庫存"+key);
		//alert("進貨量"+count);
		//if(key < count){ alert("成品不足");  return false; }
		var dnum = jQuery("#dom_"+ProSN).length;
		if(dnum>0){ alert("Have the same items");  return false; }
	var dom = '<tr class="count_tr" id="dom_'+ProSN+'">' +
                            '<td><input type="hidden" type="text" name="ProName[]" value="'+name+'" readonly/>'+name+'</td>' +
                            '<td><input type="hidden" type="text" name="Num[]" value="'+count+'" readonly/>'+count+'</td>' +
                            '<td><input type="hidden" type="text" name="Price[]" value="'+price+'" readonly/>'+price+'</td>' +
                            '<td><input type="button" value="Delete" onclick="jQuery(\'#dom_'+ProSN+'\').remove();" />'+
							'<input type="hidden" name="ProSN[]" value="'+ProSN+'"  /></td>' +
                        '</tr>';
		jQuery("#test").append(dom);
		
	});
	jQuery("#formx").validate();
});
function remove_id(id){
    jQuery('#dom_'+id).remove();
}
</script>
    <div class="clearfix"></div>
    
<?
include("template_down.php");
?>   

    
</div><!--mainwrapper-->
</body>
</html>
