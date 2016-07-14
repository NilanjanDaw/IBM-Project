<?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header.html' ?>
<body>
  <script type="text/javascript">

  </script>
  <?php
      session_start();
      if(empty($_SESSION['login_user'])){
        header("location: index.php");
      }
      require_once './config.php';
      $con = mysqli_connect($hostname, $username, $password, $databasename);
      if (mysqli_connect_errno()) {
        //die("Failed to connect");
        header("location: error.html");
      }
  ?>
  <style>
  .demo-charts:hover {
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
  }

  </style>

  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header_bar.html' ?>
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'sidebar.php' ?>
    <main class="mdl-layout__content mdl-color--grey-100">
        <div class="demo-cards mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-grid mdl-grid--no-spacing">
          <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
            <h2 class="mdl-card__title-text">Help and Information</h2>
          </div>
          <?php
              echo '
              <div class="demo-charts mdl-color--white mdl-shadow--8dp mdl-cell mdl-cell--12-col mdl-grid">
                <div class="mdl-card__supporting-text mdl-color-text--black-500">
                <h3><font size="5"><b>About us and contact information</b></font></h3>
                <font size="4">
                StockHawk is a portfolio management system which helps you in  managing your stocks and shares.
                The market section displays all the companies that are listed in the market. Stock transaction can be made using
                from the stock page of each company. You can manage your cash as well, but please make sure you have sufficient cash before
                buying a share as transaction is not possible without it. You can sell your stock at will from Sell Stock section. Also you can
                submit a request to the moderator to sell the share at a definite price.<br> You can find all your transaction and portfolio details at
                the homepage. Please find your personal messages in the inbox and outbox section.<br><br>
                </font>
                <br>
                <h4><b>Moderators</b></h4>
                <h5><b>[Nilanjan Daw]</b></h5>          <b>email</b>: nilanjandaw[at]gmail[dot]com <br>      <b>phone:</b> [+91] 9674362607<br>
                <b><h5>[Priyangbada Ganguly]</b></h5>   <b>email</b>: xcspriya[at]gmail[dot]com<br>          <b>phone:</b> [+91] 9830944913<br>
                <b><h5>[Priyanjit Dey]</b></h5>         <b>email</b>: priyanjit[dot]dey[at]gmail[dot]com<br> <b>phone:</b> [+91] 9474851429<br>
                </div>
              </div>
              ';
          ?>
        </div>

      </main>
    </div>
    <script src="../../material.min.js"></script>
  </body>
  </html>
