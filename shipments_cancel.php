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
        	<ul class="breadcrumb">
                <li><a href="dashboard.html">Home</a> <span class="divider">/</span></li>
                <li><a href="forms.html">進出貨管理</a> <span class="divider">/</span></li>
                <li class="active">商品出貨</li>
            </ul>
        </div><!--breadcrumbs-->
        <div class="pagetitle">
        	<h1>進出貨管理</h1> <span>This is a sample description for form styles page...</span>
        </div><!--pagetitle-->
        <form action="business_save.php" method="post"  name="formx" id="formx" >
        <input type="hidden" id="tag" name="tag" value="ship_canel" />
        <div class="maincontent">
        	<div class="contentinner">
            	<h4 class="widgettitle">商品退貨</h4>
                <div class="alert alert-error">
                  <button data-dismiss="alert" class="close" type="button">×</button>
                  <strong>請注意!</strong> 請確定出貨的數量在進行此操作,以免造成庫存混亂.
                </div> 
                <div class="widgetcontent">                      	
                                <p>
                                    <label>需求來源</label>
                                    <?php
                                    $mysql->table = 'shipments_data';
                                    $three = time() - 86400*30;
                                    $brs = $mysql->select("WHERE create_time>$three");
                                    ?>
                                    <select name="shipments_id" id="shipments_id" class="uniformselect" style="opacity: 0;" required>
                                        <option value="">請選擇退貨來源</option>
                                        <?php while($row = mysql_fetch_assoc($brs)){
                                            $info = unserialize($row['Info']);
                                            echo '<option value="'.$row['shipments_id'].'">'.$row['number'].'</option>';
                                        }?>
                                    </select>&nbsp;<span id="Name"></span>
                                </p>
                                <p>
                                    <label>退貨單號</label>
                                    <span class="field"><input type="text" name="number" id="number" class="input-xxlarge" required /></span>
                                </p>
                                <p>
                                    <label>貨運公司</label>
                                    <span class="field"><input type="text" name="Carrier" id="Carrier" class="input-xxlarge" /></span>
                                </p>
                                <p>
                                    <label>運送方式</label>
                                    <span class="field"><input type="text" name="Per" id="Per" class="input-xxlarge" /></span>
                                </p>
                                <p>
                                    <label>退貨運費</label>
                                    <span class="field"><input type="text" name="Invoice" id="Invoice" class="input-xxlarge" required number /></span>
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
                            <th>出貨量</th>
                            <th>數量</th>
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
		if(ProSN==0){ alert("請選取品項");  return false; } //判斷是否有選取
		if(isNaN(count)){ alert("請填寫退貨數量");  return false; } //判斷是否為空值
		//var PName = jQuery("#").val();
		//alert("庫存"+key);
		//alert("進貨量"+count);
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
	jQuery("#shipments_id").bind("change",function(){
        var shipments_id = jQuery("#shipments_id").val();
        //var info = jQuery("#BID option:selected").data('info');
        //jQuery("#Name").text(parseInt(BID) ? info : " ");
        if(parseInt(shipments_id)>0){
          jQuery.post('business_save.php',{tag:'ship_c_list',shipments_id:shipments_id},function(data){
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
