
<aside class="main-sidebar">
  <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview menu-open">
          <a href="<?php echo ($this->uri->segment(1)=='absensi')? 'active': ''; ?>"><a href="<?php echo site_url('absensi')?>"/>
            <i class="fa fa-ship"></i> <span>PNBP</span>
            <span class="pull-right-container">
            </span>
          </a>
          <a href="#">
            <i class="fa fa-money"></i> <span>PNBP DETAIL</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <li class="<?php echo ($this->uri->segment(1)=='absensi')? 'active': ''; ?>"><a href="<?php echo site_url('pnbp_detail')?>"><i class="fa fa-circle-o"></i><span> PNBP DETAIL LIST</span></a></li>
           
          </ul>
        </li>   

    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">USER MANAGEMENT</li>
        <li class="active treeview menu-open">
          <a href="#">
            <i class="fa fa-wrench"></i> <span>USER</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <li class="<?php echo ($this->uri->segment(1)=='user')? 'active': ''; ?>"><a href="<?php echo site_url('user')?>"><i class="fa fa-circle-o"></i><span> User</span></a></li>
           
          </ul>
        </li>   

 </aside>
  