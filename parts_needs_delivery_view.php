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
$nid = $_GET['nid'];
$key = $_GET['key'];
$sql = 'select * from parts_needs_data';
$sql .=' Where needs_id ='.$nid;
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
                    <form class="stdform stdform2" action="parts_needs_delivery_edit_save.php" method="post"  name="formx" id="formx" onSubmit="return su();" >
                    <input type="hidden" name="nid"  value="<?=$nid?>"> 
                            <p>
                                <label>進貨編號</label>
                                <span class="field"><?=$data['number'];?></span>
                            </p>
                            <p>
                                <label>備註</label>
                                <span class="field"><?=$data['info'];?></span>
                                
                            </p>
                            <p>
                                <label>預計到貨日期</label>
                                <span class="field"><?=$data['over_date'];?></span>
                            </p>
                            <p>
                                <label>進貨廠商</label>
                                <span class="field"><?=mysql_result(mysql_query("SELECT name FROM(vendors_data) WHERE vendors_id='{$data['vendors_id']}'"),0,'name')?></span>
                            </p>
                            <p></p> 
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
                                        <th>未交訂單需求</th>
                                        <th>目前庫存</th>
                                        <th>建議進貨量</th>
                                        <th>進貨數量</th>
                                    </tr>
                                </thead>
                                <?
                                // 未出貨完成需求產品數量
                                $mysql->table = 'BDataDetail';
                                $rs = $mysql->select("LEFT JOIN Business_data USING(BID) WHERE End=0");
                                $Pro_List = array();
                                $BID = array();
                                $BID_str = '';
                                while($row = mysql_fetch_assoc($rs)){
                                    $tmp = array(
                                        'product_id' => $row['product_id'],
                                        'count'      => $row['count']
                                    );
                                    $IsSome = false;
                                    for($i=0;$i<count($Pro_List);$i++){
                                        if($row['product_id']==$Pro_List[$i]['product_id']){
                                            $Pro_List[$i]['count'] = $tmp['count'] + $Pro_List[$i]['count'];
                                            $IsSome = true;
                                            break;
                                        }
                                    }
                                    if(!in_array( $row['BID'],$BID)){
                                        array_push($BID, $row['BID']);
                                        $BID_str .= $BID_str=='' ? $row['BID'] : ','.$row['BID'];
                                    }
                                    if(!$IsSome) array_push($Pro_List, $tmp);
                                }
                                
                                $shiparr = array();
                                $ship_str = '';
                                if($BID_str!=''){
                                    $mysql->table = 'BShipLink';
                                    $rs = $mysql->select("WHERE BID IN ({$BID_str})");
                                    
                                    while($row = mysql_fetch_assoc($rs)){
                                        if(!in_array( $row['shipments_id'],$shiparr)){
                                            array_push($shiparr, $row['shipments_id']);
                                            $ship_str .= $ship_str=='' ? $row['shipments_id'] : ','.$row['shipments_id'];
                                        }
                                    }
                                }
                                if($ship_str!=''){
                                    $mysql->table = 'shipments_detail_data';
                                    $rs = $mysql->select("WHERE group_id IN ($ship_str)");
                                    while($row = mysql_fetch_assoc($rs)){
                                        for($i=0;$i<count($Pro_List);$i++){
                                            if($row['product_id']==$Pro_List[$i]['product_id']){
                                                $Pro_List[$i]['count'] = $Pro_List[$i]['count'] - $row['count'];
                                                break;
                                            }
                                        }
                                    }
                                }
                                $mysql->table = 'product_detail_data';
                                $Part_List = array();
                                foreach($Pro_List as $par){
                                    $rs = $mysql->select("WHERE product_id='{$par['product_id']}'");
                                    while ($row = mysql_fetch_assoc($rs)) {
                                        $tmp = array(
                                            'parts_id' => $row['parts_id'],
                                            'count'    => $row['count']*$par['count']
                                        );
                                        $IsSome = false;
                                        for($i=0;$i<count($Part_List);$i++){
                                            if($row['parts_id']==$Part_List[$i]['parts_id']){
                                                $Part_List[$i]['count'] = $tmp['count'] + $Part_List[$i]['count'];
                                                $IsSome = true;
                                                break;
                                            }
                                        }
                                        if(!$IsSome) array_push($Part_List, $tmp);
                                    }
                                }
								$sql = 'select * from parts_data';
								$sql .='  ORDER BY create_time DESC';
								$rs2 = mysql_query($sql)or die(mysql_error()); //sql查詢
								?>
                                <? while($row2 = mysql_fetch_assoc($rs2)){?>
                                	<?
									$sql = 'select * from parts_needs_detail_data';
									$sql .='  WHERE father_id='.$nid;
									$sql .='  AND parts_id='.$row2['parts_id'];
									$rs3 = mysql_query($sql)or die(mysql_error()); //sql查詢
									$data2 = mysql_fetch_assoc($rs3); //建立資料

                                    $mysql->table = 'parts_inven_data';
                                    $store = mysql_result($mysql->select("WHERE parts_id='{$row2['parts_id']}'",'SUM(count) AS C'),0,'C');
                                    $need = 0;
									?>
                                <tbody> 
                                    <td><?=$row2['name'];?></td>
                                    <td><span style="color:#00F;"><?php foreach($Part_List as $par){
                                        if($row2['parts_id']==$par['parts_id']){ $need = $par['count'];}
                                        }?><?=$need?></span></td>
                                    <td><?=$store?></td>
                                    <td><span style="color:#F00;"><?=$need - $store?></span></td>
                                    <? if ($row2['parts_id'] == $data2['parts_id']){?>
                            		<td <? if($data2['count']!= 0){?>style="background-color:#F00;"<? }?>>
                                    <span style="color:#00F"><?=$data2['count'];?></span>
                                    <input type="hidden" name="count[]" id="count" value="<?=$data2['count'];?>">
                                    </td>
                                    <? }else{?>
                                    <td><input type="text" name="count[]" id="count" value="0"></td>
                                    <? }?>
                                    <input type="hidden" name="parts_id[]" value="<?=$row2['parts_id'];?>"/>    
                                </tbody>
                                <? }?>
                            </table>
                            <p class="stdformbutton">
                            <? if ($key==''){?>
                                <button  type="submit" id="addpro" class="btn btn-warning ">零件已到貨</button>
                            <? }?>
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

    
</div><!--mainwrapper-->
</body>
</html>
