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
        	<h1>Create New Shipping</h1> <span></span>
        </div><!--pagetitle-->
        <form action="business_save.php" method="post"  name="formx" id="formx" >
        <input type="hidden" id="tag" name="tag" value="ship_new" />
        <div class="maincontent">
        	<div class="contentinner">
            	<h4 class="widgettitle">Create New Shipping</h4>
                <div class="widgetcontent">                      	
                                <p>
                                    <label>Select Invoice No.</label>
                                    <?php
                                    $mysql->table = 'Business_data';
                                    $brs = $mysql->select("WHERE End=0 AND Checked=1");
                                    ?>
                                    <select name="BID" id="BID" class="uniformselect" style="opacity: 0;" required>
                                        <option value="">Please select Invoice No.</option>
                                        <?php while($row = mysql_fetch_assoc($brs)){
                                            $info = unserialize($row['Info']);
                                            echo '<option value="'.$row['BID'].'" data-info="'.$info['IName'].'('.$info['ISite'].')">'.$row['SN'].'</option>';
                                        }?>
                                    </select>&nbsp;<span id="Name"></span>
                                    <div id="custmer"></div>
                                </p>
                                <p>
                                    <label>Packing NO.</label>
                                    <span class="field"><input type="text" name="number" id="number" class="input-xxlarge" required /></span>
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
                                <!--p>
                                    <label>貨運公司</label>
                                    <span class="field"><input type="text" name="Carrier" id="Carrier" class="input-xxlarge" required /></span>
                                </p>
                                <p>
                                    <label>運送方式</label>
                                    <span class="field"><input type="text" name="Per" id="Per" class="input-xxlarge" required /></span>
                                </p-->
                                <p>
                                    <label>Delivery charge</label>
                                    <span class="field"><input type="text" name="Invoice" id="Invoice" class="input-xxlarge" required number /></span>
                                </p>
                                <p>
                                    <label>Shipping Address</label>
                                    <span class="field"><input type="text" name="OutAddr" id="OutAddr" class="input-xxlarge" required /></span>
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
                            <th>Inventory</th>
                            <th>Needs  Quantity</th>
                            <th>The Quantity of shipments at this time</th>
                        </tr>
                    </thead>
                    <tbody id="Pro_list"> 
                        
                    </tbody>
                </table>
                <p></p> 
                <div class="control-group">
                    <label>Remark</label>
                    <textarea cols="80" rows="5" name="info" id="info" class="span5"></textarea>
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
		var name = jQuery("#product_id option:selected").text();
		var key = parseInt(jQuery("#product_id option:selected").attr('key'));
		if(ProSN==0){ alert("Please select Item");  return false; } //判斷是否有選取
		if(isNaN(count)){ alert("Please fill in Shipping Quantity");  return false; } //判斷是否為空值
		//var PName = jQuery("#").val();
		//alert("庫存"+key);
		//alert("進貨量"+count);
		if(key < count){ alert("成品不足");  return false; }
		var dnum = jQuery("#dom_"+ProSN).length;
		if(dnum>0){ alert("Have the same items");  return false; }
	var dom = '<tr id="dom_'+ProSN+'">' +
                            '<td><input type="hidden" type="text" name="ProName[]" value="'+name+'" readonly/>'+name+'</td>' +
                            '<td><input type="hidden" type="text" name="Num[]" value="'+count+'" readonly/>'+count+'</td>' +
                            '<td><input type="button" value="刪除" onclick="jQuery(\'#dom_'+ProSN+'\').remove();" />'+
							'<input type="hidden" name="ProSN[]" value="'+ProSN+'"  /></td>' +
                        '</tr>';
		jQuery("#test").append(dom);
		
	});
	
    jQuery("#BID").bind("change",function(){
        var BID = jQuery("#BID").val();
        var info = jQuery("#BID option:selected").data('info');
        jQuery("#Name").text(parseInt(BID) ? info : " ");
        if(parseInt(BID)>0){
          jQuery.post('business_save.php',{tag:'ship_list',BID:BID},function(data){
            var dom = '';
            var Invoice = data.Invoice;
            var OutAddr = data.OutAddr;
            var IName = data.IName;
            var IAddr = data.IAddr ? data.IAddr : '';
            var SN = data.SN;
            var mail_id = data.mail_id;
            jQuery("#Invoice").val(Invoice);
            jQuery("#OutAddr").val(OutAddr);
            jQuery("#mail_id").val(mail_id);
            jQuery("#number").val(SN.replace(/PO/,"PA"));
            data = data.data;
            for(i=0;i<data.length;i++){
                dom += '<input type="hidden" name="ProID[]" value="'+data[i].product_id+'" />';
                dom += '<tr><td>'+data[i].name+'</td><td>'+data[i].save+'</td><td>'+data[i].out+'</td>';//data[i].save
                dom += '<td><input type="text" name="Num[]" value="'+data[i].Lim+'" number min="0" max="'+data[i].Lim+'" /></td>';
                /*dom += '<td><input type="text" name="Price[]" value="0" number min="1" max="999999999" /></td></tr>';*/
            }
            jQuery("#Pro_list").html(dom);
            jQuery("#custmer").html('<div>客戶名稱:'+IName+'</div><div>客戶地址:'+IAddr+'</div>');

          },'json');
        } else { jQuery("#Pro_list").html(''); jQuery("#custmer").html(''); }
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
