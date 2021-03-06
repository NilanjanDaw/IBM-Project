<div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
  <header class="demo-drawer-header">
    <img src="images/user.jpg" class="demo-avatar">
    <div class="demo-avatar-dropdown">
      <!--<span>hello@example.com</span>-->
      <span><?php echo $_SESSION['login_user']; ?></span>
      <div class="mdl-layout-spacer"></div>
      
    </div>
  </header>
  <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
    <a class="mdl-navigation__link" href="land.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Home</a>
    <a class="mdl-navigation__link" href="inbox.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">inbox</i>Inbox</a>
    <a class="mdl-navigation__link" href="sentbox.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">markunread</i>Outbox</a>
    <a class="mdl-navigation__link" href="sellstock.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">trending_up</i>Sell Stock</a>
    <a class="mdl-navigation__link" href="market.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">shopping_cart</i>Market</a>
    <a class="mdl-navigation__link" href="managecash.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">euro_symbol</i>Manage Cash</a>
    <?php
    if($_SESSION['user_type']=='admin' || $_SESSION['user_type']=='pm'){?>
    <a class="mdl-navigation__link" href="updatestock.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">flag</i>Update Stock</a>
    <a class="mdl-navigation__link" href="allocateuser.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person</i>Allocate User</a>
    <?php } ?>
    <a class="mdl-navigation__link" href="error_submit.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">report</i>Report Error</a>
    <a class="mdl-navigation__link" href="help.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help_outline</i>Help</a>
    <!--<a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">local_offer</i>Promos</a>-->
    <div class="mdl-layout-spacer"></div>

  </nav>
</div>
