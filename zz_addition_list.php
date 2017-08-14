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
$sql = 'select * from purchase_data';
$sql .=' Where tag = 1';
$sql .='  ORDER BY create_time DESC';
$rs = mysql_query($sql)or die(mysql_error()); //sql查詢
?>	    
    <!-- START OF RIGHT PANEL -->
    <div class="rightpanel">
    	<div class="headerpanel">
        	<a href="" class="showmenu"></a>
            
            <div class="headerright">
            	<div class="dropdown notification">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="/page.html">
                    	<span class="iconsweets-globe iconsweets-white"></span>
                    </a>
                    <ul class="dropdown-menu">
                    	<li class="nav-header">Notifications</li>
                        <li>
                        	<a href="">
                        	<strong>3 people viewed your profile</strong><br />
                            <img src="img/thumbs/thumb1.png" alt="" />
                            <img src="img/thumbs/thumb2.png" alt="" />
                            <img src="img/thumbs/thumb3.png" alt="" />
                            </a>
                        </li>
                        <li><a href=""><span class="icon-envelope"></span> New message from <strong>Jack</strong> <small class="muted"> - 19 hours ago</small></a></li>
                        <li><a href=""><span class="icon-envelope"></span> New message from <strong>Daniel</strong> <small class="muted"> - 2 days ago</small></a></li>
                        <li><a href=""><span class="icon-user"></span> <strong>Bruce</strong> is now following you <small class="muted"> - 2 days ago</small></a></li>
                        <li class="viewmore"><a href="">View More Notifications</a></li>
                    </ul>
                </div><!--dropdown-->
                
    			<div class="dropdown userinfo">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="/page.html">Hi, ThemePixels! <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="editprofile.html"><span class="icon-edit"></span> Edit Profile</a></li>
                        <li class="divider"></li>
                        <li><a href=""><span class="icon-wrench"></span> Account Settings</a></li>
                        <li><a href=""><span class="icon-eye-open"></span> Privacy Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="index.html"><span class="icon-off"></span> Sign Out</a></li>
                    </ul>
                </div><!--dropdown-->
    		
            </div><!--headerright-->
            
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
                <li class="active">進貨紀錄</li>
            </ul>
        </div><!--breadcrumbs-->
        <div class="pagetitle">
        	<h1>進出貨管理</h1> 
        </div><!--pagetitle-->
        
        <div class="maincontent">
        	<div class="contentinner">
            	<h4 class="widgettitle">進貨紀錄<a href="addition_new.php" title="編輯" class="btn btn-primary" style="float:right" ><span class="icon-plus"></span>進貨</a></h4>
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
                        	<th class="centeralign"><div class="checker" id="uniform-undefined"><span><input type="checkbox" class="checkall" style="opacity: 0;"></span></div></th>
                            <th>進貨編號</th>
                            <th>備註</th>
                            <th>時間</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody> 
					<? $x_pi=0;?>
                    <? while($row = mysql_fetch_assoc($rs)){?>
                    <script type="text/javascript">
					// delete row in a table
					jQuery(document).ready(function(){
						jQuery('#deleter<?=$row['product_id'];?>').click(function(){
						   var conf = confirm('是否確定刪除?');
						   if(conf)
							  window.location.href='product_del.php?pid=<?=$row['product_id'];?>';
						   return false;
						}); 
					});   
					</script>
                        <tr <? if ($row['cancel'] == 2){?> style="background-color:#e18d9a;" <? }?>>
                        	<td class="centeralign" ><div class="checker" id="uniform-undefined"><span><input type="checkbox" style="opacity: 0;"></span></div></td>
                            <?
							$sql = 'select * from product_data';
							$sql .=' Where product_id ='.$row['product_id'];
							$sql .='  ORDER BY inx DESC';
							$rs2 = mysql_query($sql)or die(mysql_error()); //sql查詢
							?>
                            <? while($row2 = mysql_fetch_assoc($rs2)){?>
                            <td><?=$row2['number']; ?>(<?=$row2['name']; ?>)</td>
                            <? }?> 
                            <td><?=$row['count']; ?></td>
                            <td><?=$row['create_time']; ?></td>
                            <td class="centeralign"> 
                            <? if ($row['cancel'] == 2){?>
                            	<sapn class="text-error">此筆已取消</span>
                            <? }else{?>
								<? if ($x_pi == 0) {?>
                                <a href="reserve_del.php?rid=<?=$row['reserve_id'];?>" title="取消進貨" class="btn" ><span class="icon-remove-circle"></span>&nbsp;取消進貨</a>
                                &nbsp;
                                <? }else{?>
                                <sapn class="text-success">只有最新一筆進貨,可以取消</span>	
                                <? }?>
                            <? }?>    
                            <? $x_pi = $x_pi+1 ;?> 
                            </td>
                        </tr>
                    <? }?>    
                    </tbody>
                </table>
            </div><!--contentinner-->
             	
        </div><!--maincontent-->
 		    	     
    </div><!--mainright-->
    <!-- END OF RIGHT PANEL -->

    <div class="clearfix"></div>
    
<?
include("template_down.php");
?>   

    
</div><!--mainwrapper-->
</body>
</html>
