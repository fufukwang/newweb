<!-- START OF LEFT PANEL -->

<div class="leftpanel">
  <div class="logopanel" > 
    <!--<h1><a href="dashboard.php">&nbsp;&nbsp;&nbsp;S<span>acoa</span></a></h1>-->
    <h1 style="margin-left:40px;"><a href="dashboard.php"><span style="padding-left:10px;"><img src="img/sys_img/Logo.png" style="float:left;"/></span></a></h1>
  </div>
  <!--logopanel-->
  <div class="datewidget">Today is <?php echo date("Y-m-d H:i:s");?></div>
  <div style="height:46px;"></div>
  <div class="leftmenu">
    <ul class="nav nav-tabs nav-stacked">
      <li class="nav-header">Management menu</li>
      <li class="active dropdown"><a href=""><span class="iconsweets-suitcase"></span>Inventory Control</a>
            <ul style="display: block;">
              <li><a href="dashboard.php"><span class="iconsweets-list4"></span> Current Inventory</a></li>
              <? if ($_SESSION['super_power'] == 1 or $_SESSION['busin_power'] == 1){ ?>
              <li><a href="business_list.php"><span class="icon-shopping-cart"></span> Order System</a></li>
              <? }?>
              <? if ($_SESSION['super_power'] == 1 or $_SESSION['house_power'] == 1){ ?>
              <li><a href="business_list_house.php"><span class="icon-th-list"></span> Demand System</a></li>
              <? }?>
              <? if ($_SESSION['super_power'] == 1 or $_SESSION['house_power'] == 1){ ?>
              <li><a href="shipments_list.php"><span class="iconsweets-track"></span> Shipping System</a></li>
              <? }?>
              <? if ($_SESSION['super_power'] == 1){ ?>
              <li><a href="packing_list.php"><span class="iconsweets-dropbox"></span> Packing System</a></li>
              <? }?>
              <li><a href="inquiry_list.php"><span class="iconsweets-speech2"></span> Inquiry </a></li>
            </ul>
          </li>
      <? if ($_SESSION['super_power'] == 1 or $_SESSION['house_power'] == 1 ){ ?>
          <li class="active dropdown"><a href=""><span class="iconsweets-cog4"></span>零件管理系統</a>
            <ul style="display: block;">
              <li><a href="vendors_list.php"><span class="iconsweets-cog2"></span> 零件廠商管理</a></li>
              <li><a href="parts_list.php"><span class="iconsweets-cog2"></span> 零件管理</a></li>
              <li><a href="parts_needs_list.php"><span class="iconsweets-cog2"></span> 零件進貨管理</a></li>
            </ul>
          </li>
      <? }?>
      <? if ($_SESSION['super_power'] == 1 or $_SESSION['house_power'] == 1){ ?>
          <li class="active dropdown"><a href=""><span class="iconsweets-postcard"></span>品項管理</a>
            <ul style="display: block;">
              <li><a href="product_list.php"><span class="iconsweets-postcard"></span> 品項管理</a></li>
              <? if ($_SESSION['super_power'] == 1 or $_SESSION['house_power'] == 1){ ?>
              <li><a href="complete_list.php"><span class="iconsweets-postcard"></span> 品項進貨管理</a></li>
              <? }?>
            </ul>
          </li>
      <? }?>
      <? if ($_SESSION['super_power'] == 1 or $_SESSION['house_power'] == 1){ ?>
          <li class="active dropdown"><a href=""><span class="iconsweets-track"></span>貨運管理</a>
            <ul style="display: block;">
              <!--<li><a href="mail_list.php?key=1"><span class="iconsweets-mail"></span> 客戶Email(close)</a></li>-->
              <li><a href="mail_list.php?key=2"><span class="iconsweets-mail"></span> 貨運公司Email管理</a></li>
            </ul>
          </li>
      <? }?>
      <? if ($_SESSION['mpower'] == 1){ ?>
          <li class="active dropdown"><a href=""><span class="iconsweets-admin"></span>系統管理</a>
            <ul style="display: block;">
              <li><a href="member_list.php"><span class="iconsweets-user"></span> 管理帳號列表</a></li>
            </ul>
          </li>
      <? }?>
    </ul>
  </div>
  <!--leftmenu--> 
  
</div>
<!--mainleft--> 
<!-- END OF LEFT PANEL --> 
