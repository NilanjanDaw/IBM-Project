<div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
  <header class="demo-drawer-header">
    <img src="images/user.jpg" class="demo-avatar">
    <div class="demo-avatar-dropdown">
      <!--<span>hello@example.com</span>-->
      <span><?php echo $_SESSION['login_user']; ?></span>
      <div class="mdl-layout-spacer"></div>
      <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
        <i class="material-icons" role="presentation">arrow_drop_down</i>
        <span class="visuallyhidden">Accounts</span>
      </button>
      <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
        <li class="mdl-menu__item">hello@example.com</li>
        <li class="mdl-menu__item">info@example.com</li>
        <li class="mdl-menu__item"><i class="material-icons">add</i>Add another account...</li>
      </ul>
    </div>
  </header>
  <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
    <a class="mdl-navigation__link" href="land.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Home</a>
    <a class="mdl-navigation__link" href="inbox.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">inbox</i>Inbox</a>
    <a class="mdl-navigation__link" href="sentbox.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">message</i>Outbox</a>
    <a class="mdl-navigation__link" href="market.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">shopping_cart</i>Market</a>
    <?php
    if($_SESSION['user_type']=='admin' || $_SESSION['user_type']=='pm'){?>
    <a class="mdl-navigation__link" href="updatestock.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">flag</i>Update Stock</a>
    <a class="mdl-navigation__link" href="allocateuser.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person</i>Allocate User</a>
    <?php } ?>
    <a class="mdl-navigation__link" href="social.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">people</i>Social</a>
    <a class="mdl-navigation__link" href="error_submit.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">report</i>Report Error</a>
    <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help_outline</i>Help</a>
    <!--<a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">local_offer</i>Promos</a>-->
    <div class="mdl-layout-spacer"></div>

  </nav>
</div>
