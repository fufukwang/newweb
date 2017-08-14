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
        	<h1>Create New Packing</h1> <span></span>
        </div><!--pagetitle-->
        <form action="business_save.php" method="post"  name="formx" id="formx" >
        <input type="hidden" id="tag" name="tag" value="packing_update" />
        <div class="maincontent">
        	<div class="contentinner">
            	<h4 class="widgettitle">Create New Packing</h4>
                <div class="widgetcontent">                      	
                                <p>
                                    <label>Select Invoice No.</label>
                                    <select name="shipments_id" id="shipments_id" class="uniformselect" style="opacity: 0;" required>
                                        <option value="">Please select Invoice No.</option>
                                        <?php 
                                        $mysql->table = 'Packing';
                                        $sharr = $mysql->select("","shipments_id");
                                        $shin = '';
                                        while($shrow = mysql_fetch_assoc($sharr)){
                                          $shin = $shin=='' ? $shrow['shipments_id'] : ','.$shrow['shipments_id'];
                                        }
                                        $mysql->table = 'shipments_data';
                                        if($shin!='') $shin = " AND shipments_id NOT IN ($shin)";
                                        $brs = $mysql->select("WHERE cancel=0".$shin);
                                        while($row = mysql_fetch_assoc($brs)){
                                            echo '<option value="'.$row['shipments_id'].'">'.$row['number'].'</option>';
                                        }?>
                                    </select>
                                </p>
<table width="100%" id="tab" class="table table-bordered" style="display:none;">
      <tr>
        <td rowspan="4"><img src="img/sys_img/test.png" /></td>
        <td>Order Date:<span id="d2_1"></span></td>
      </tr>
      <tr>
        <td>Packing NO.:<span id="d2_8"></span></td>
      </tr>
      <tr>
        <td>Invoice No.:<span id="d2_2"></span></td>
      </tr>
      <tr>
        <td>Contact:<span id="d2_3"></span></td>
      </tr>
      <tr>
        <td>Shipping Address:<span id="d2_4"></span></td>
        <td>Shipping Date:<span id="d2_6"></span></td>
      </tr>
      <tr>
        <td>Customer:<span id="d2_5"></span></td>
        <td>Carrier:<span id="d2_7"></span></td>
      </tr>
      <tr>
        <td>Customer Addr:<span id="d2_Addr"></span></td>
        <td>Per:<span id="d2_Par"></span></td>
      </tr>
      <!--tr>
    <td>Per:<span id="d2_8"></span></td>
  </tr-->
      <tr>
        <td colspan="2"><table class="table table-bordered">
            <tr>
              <th>Item</th>
              <th>Quantity</th>
              <th>Description</th>
            </tr>
            <tbody id="d2_pro_list">
            </tbody>
          </table></td>
      </tr>
      <tr>
        <td colspan="2">Remark:<span id="d2_9"></span></td>
      </tr>
    </table>

				<!--table width="100%" class="table table-bordered">
  					<tbody>
                    <tr>
                        <td rowspan="4">Shipping Address:<br>
                        Taichung, Taiwan sincere 16th Street No. 39, 6th Floor -1</td>
                        <td>Date:2014/05/28 11:47:07</td>
                      </tr>
                      <tr>
                        <td>Packing NO.:PA--test-02</td>
                      </tr>
                      <tr>
                        <td>Invoice No.:PO-test2</td>
                      </tr>
                      <tr>
                        <td>Contact:Ken</td>
                      </tr>
                      <tr>
                        <td>Customer:Mary</td>
                        <td>Date:1970/01/01 08:33:34</td>
                      </tr>
                      <tr>
                        <td rowspan="2">Customer Addr:Taichung, Taiwan sincere 16th Street No. 39, 6th Floor -1</td>
                        <td>Carrier:DHC</td>
                      </tr>
                      <tr>
                        <td>Per:Air</td>
                      </tr>
                      <tr>
                        <td colspan="2">
                    
                        <table class="table table-bordered">
                          <tbody>
                          <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Description</th>
                            <!--<th>單價</th>
                            <th>小記</th>- ->
                          </tr>
                                <tr>
                            <th>DEMO_data</th>
                            <th>10</th>
                            <th>this is a test data</th>
                                  </tr>
                           
                        </tbody></table>
                        </td>
                      </tr>
                      <tr>
                        <td rowspan="3">Remark:</td>
                        <td></td>
                      </tr>
                      </tbody>
  				</table-->
                <p></p>
                <p></p>
                <h3 class="widgettitle">Packing List <a href="javascript:;" onclick="addnewbox();" class="btn btn-rounded" style="float:right"><i class="iconsweets-dropbox"></i> Add Box</a></h3>
                <div id="BoxList"></div>
                










                <!--table class="table table-bordered">
                    <colgroup>
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>CTN. NO.</th>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>N.W.</th>
                            <th>G.W.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" style="width:30px"  name="" value="2A" /></td>
                            <td><select name="" id="" class="uniformselect" style="opacity: 0;" required>
                            <option value="">Please select Item</option>
                             </select>&nbsp;選擇以後,右邊會出現Description</td>
                            <td>&nbsp;</td>
                            <td><input type="text" style="width:30px" name="" value="" /></td>
                            <td><input type="text" style="width:30px" name="" value="" /></td>
                            <td><input type="text" style="width:30px" name="" value="" /></td>
                        </tr>
                        <tr>
                        	<td colspan="6"><a href="" class="btn btn-rounded" style="float:right"><i class="icon-plus"></i> Add Item</a></td>
                        </tr>
                    </tbody>
                </table-->
                </div><!--widgetcontent-->
                <p></p>                 		                 
                <p class="stdformbutton">
                    <button type="submit" class="btn btn-primary" id="subbutton" disabled="true">Submit</button>
                </p>                
            </div><!--contentinner-->
        </div><!--maincontent--></form>      
    </div><!--mainright-->
    <!-- END OF RIGHT PANEL -->
    <div class="clearfix"></div>
    
<?
include("template_down.php");
?>   
<script language="javascript">
var nowboxnum = 0;
var itemlist = '';
var packingnum = '';
jQuery(function(){
    jQuery("#shipments_id").bind("change",function(){
      var ship_id = parseInt(jQuery("#shipments_id").val());
      jQuery("#subbutton").attr("disabled",true);
      if(ship_id>0){
          jQuery.post('business_save.php',{tag:'ajax_ship_info',ship_id:ship_id},function(data){
            jQuery("#d2_1").text(data.info.d2_1 ? data.info.d2_1 : '');
            jQuery("#d2_2").text(data.info.d2_2 ? data.info.d2_2 : '');
            jQuery("#d2_3").text(data.info.d2_3 ? data.info.d2_3 : '');
            jQuery("#d2_4").text(data.info.d2_4 ? data.info.d2_4 : '');
            jQuery("#d2_5").text(data.info.d2_5 ? data.info.d2_5 : '');
            jQuery("#d2_6").text(data.info.d2_6 ? data.info.d2_6 : '');
            jQuery("#d2_7").text(data.info.d2_7 ? data.info.d2_7 : '');
            jQuery("#d2_8").text(data.info.d2_8 ? data.info.d2_8 : '');
            jQuery("#d2_9").text(data.info.d2_9 ? data.info.d2_9 : '');
            jQuery("#d2_Addr").text(data.info.d2_Addr ? data.info.d2_Addr : '');
            jQuery("#d2_Par").text(data.info.d2_Par ? data.info.d2_Par : '');
            var list = '';
            var Tot = 0;
            itemlist = data.list;
            for(i=0;i<data.list.length;i++){
                var scount = parseInt(data.list[i].price)*parseInt(data.list[i].count);
                Tot += scount;
                list += '<tr><th>'+data.list[i].name+'</th><th id="pq_'+data.list[i].product_id+'">'+data.list[i].count+'</th><th>'+data.list[i].info+'</th></tr>'
            }
            jQuery("#d2_pro_list").html(list);
            jQuery("#NetValue").text(Tot);
            jQuery("#Invoice").text(data.info.Invoice);
            jQuery("#Tot").text(Tot+parseInt(data.info.Invoice));
            jQuery("#BoxList").html("");
            jQuery("#tab").show();
          },'json');
      } else {
        jQuery("#tab").hide();
        jQuery("#BoxList").html("");
      } 
    });
    jQuery("#formx").validate({
      submitHandler: function(form) {
        // 所有product 跑一次 看有沒有超過數量
        var IsOver = false;
        for(i=0;i<itemlist.length;i++){
            var co = 0;
            jQuery("input").each(function(){
                if(jQuery(this).data("proid")==itemlist[i].product_id){
                    co += parseInt(jQuery(this).val());
                }
            });
            var needpack = parseInt(itemlist[i].count);
            if(needpack!=co){
                IsOver = true;
            }
        }

        if(IsOver){
            alert('Quantity is over (包裝數量不等於出貨數量)');
        } else {
            form.submit();
        }
      }
     });
    
});
function addnewbox(){
    if(itemlist.length<1){
        alert('Please select Invoice No.');
        return false;
    }
    jQuery("#subbutton").attr("disabled",false);
    nowboxnum++;
    var selectlist = getselectitemlist();
    console.log(selectlist);
    var tablist = '<table class="table table-bordered"><thead><tr><th>CTN. NO.</th><th>Item</th><th>Description</th><th>Quantity</th><th>N.W.</th><th>G.W.</th></tr></thead>' +
                    '<tbody id="rbox_'+nowboxnum+'"><tr><td id="rno_'+nowboxnum+'" rowspan="1"><input type="text" style="width:30px" name="PNO[]" value="'+nowboxnum+'A" required /></td>' +
                            '<td><select name="product_id_'+nowboxnum+'[]" id="select_'+nowboxnum+'_1" onchange="showinfo('+nowboxnum+',1);" data-box="'+nowboxnum+'" class="uniformselect" style="opacity: 0;" required>' +
                            '<option value="" data-info="">Please select Item</option>'+selectlist+'</select></td>' +
                            '<td id="des_'+nowboxnum+'_1">&nbsp;</td><td><input type="text" style="width:30px" name="Quantity_'+nowboxnum+'[]" id="q_'+nowboxnum+'_1" number required min="0" max="" /></td>' +
                            '<td><input type="text" style="width:30px" name="NW_'+nowboxnum+'[]" value="" number required /></td>' +
                            '<td><input type="text" style="width:30px" name="GW_'+nowboxnum+'[]" value="" number required /></td>' +
                        '</tr></tbody></table><div><a href="javascript:;" onclick="addnewrow('+nowboxnum+');" class="btn btn-rounded" style="float:right;margin:7px"><i class="icon-plus"></i> Add Item</a></div>';
    jQuery("#BoxList").append(tablist);
    jQuery("#select_"+nowboxnum+'_1').uniform();
}
function addnewrow(boxnum){
    var rownum = parseInt(jQuery("#rno_"+boxnum).attr("rowspan"))+1; //取得目前列數
    var selectlist = getselectitemlist();
    var rowlist = '<tr><td><select name="product_id_'+boxnum+'[]" id="select_'+boxnum+'_'+rownum+'" class="uniformselect" onchange="showinfo('+boxnum+','+rownum+');" style="opacity: 0;" required>' +
                            '<option value="" data-info="">Please select Item</option>'+selectlist+'</select></td>' +
                            '<td id="des_'+boxnum+'_'+rownum+'">&nbsp;</td><td><input type="text" style="width:30px" name="Quantity_'+boxnum+'[]" id="q_'+boxnum+'_'+rownum+'" number required min="0" max="" /></td>' +
                            '<td><input type="text" style="width:30px" name="NW_'+boxnum+'[]" value="" number required /></td>' +
                            '<td><input type="text" style="width:30px" name="GW_'+boxnum+'[]" value="" number required /></td></tr>';
    jQuery("#rno_"+boxnum).attr("rowspan",rownum);
    jQuery("#rbox_"+boxnum).append(rowlist);
    jQuery("#select_"+boxnum+'_'+rownum).uniform();
}
function getselectitemlist(){
    var list = '';
    for(i=0;i<itemlist.length;i++){
        list += '<option value="'+itemlist[i].product_id+'" data-info="'+itemlist[i].info+'">'+itemlist[i].name+'</option>'
    }
    return list;
}
function showinfo(boxnum,rownum){
    var product_id = jQuery("#select_"+boxnum+'_'+rownum+' :selected').val();
    jQuery("#q_"+boxnum+'_'+rownum).data("proid",product_id);
    jQuery("#q_"+boxnum+'_'+rownum).attr("max",jQuery("#pq_"+product_id).text());
    jQuery("#des_"+boxnum+'_'+rownum).text(jQuery("#select_"+boxnum+'_'+rownum+' :selected').data('info'));
}
</script>
    
</div><!--mainwrapper-->
</body>
</html>
