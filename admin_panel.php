<?php
$current_page='adminpanel';
require_once('templates/header.php');
?>
<div class="row">
<?php include('templates/adminpanel/admin_nav.php'); ?>
  <div class="col-9 container admin-panel-container">
    <div class="tab-content vertical">
      <!--Panel 1-->
      <div class="tab-pane fade in show active" id="panel1" role="tabpanel">
        <?php include('templates/adminpanel/admin_users.php'); ?>
      </div>
      <!--Panel 2-->
      <div class="tab-pane fade" id="panel2" role="tabpanel">
        <?php include('templates/adminpanel/admin_auctions.php'); ?>
      </div>
      <!--Panel 3-->
      <div class="tab-pane fade" id="panel3" role="tabpanel">
        <?php include('templates/adminpanel/admin_verify_sellers.php'); ?>
      </div>
    </div>
  </div>
</div>
<?php include('templates/footer.php'); ?>
