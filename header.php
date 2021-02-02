<html lang="lv">
  <head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8"/>
    <meta name="keywords" content="UDHS, UDS, ADHD">
    <meta name="viewport" content="width=device-width, user-scalable=false;">

    <!-- Bootstraps -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <!-- Izmantotie fonti -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:100,300,400" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
    <link rel="preconnect" href="https://fonts.gstatic.com"><link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"> 

    <!-- Pielāgots stils -->
    <link type="text/css" rel="stylesheet" href="main.css" />
</head>


<script type="text/javascript">
//JS, kas noslēpj navigāciju un atkal parāda to, noritinot uz leju
 window.onscroll = function() {
    hideShowNavbar()
};

function hideShowNavbar() {

    var mainNav = $("nav");
    sticky = "sticky";
    inView = "inView";
    outView = "outView";
    headerHeight = $("nav").height();

    if (document.body.scrollTop > headerHeight * 1.5 || document.documentElement.scrollTop > headerHeight * 1.5 ) {
        mainNav.addClass(sticky);
        $('#Logo').css("height" , "25px");
        $('.second-nav').css("height" , "auto");
        $('.second-nav').css("min-height" , "50px");
        }
    else {
        $('.second-nav').css("height" , "auto");
        $('.second-nav').css("min-height" , "100px");
        $('#Logo').css("height" , "auto");
        mainNav.removeClass(sticky);
        mainNav.removeClass(outView);
    }

    if (document.body.scrollTop > headerHeight * 2.5 || document.documentElement.scrollTop > headerHeight * 2.5 ) {
        mainNav.addClass(inView);
        }
    else {
        if ( mainNav.hasClass(inView) ) {
            mainNav.removeClass(inView).addClass(outView);
            }
    }
}

//JS, kas navbar aizver uzklikšķināto dropdown, ja pārslēdzas uz citu dropdown vai saturu
$(function(){
    $('.dropdown').hover(function() {
        $(this).addClass('open');
    },
    function() {
        $(this).removeClass('open');
    });
});

</script>


<nav>
<!--Navbar pirmais - autentificēšanās -->
 <div class="navbar first-nav">
 <div class="container">
    <ul class="nav navbar-nav navbar-right pull-right">
    <li class="nav-item">

<?php if(isset($_SESSION['id'])): ?>
  <li><a href="login_page.php"><span class="glyphicon glyphicon-log-in"></span>Iziet</a></li>
<?php else: ?>
  <li><a href="login_page.php"><span class="glyphicon glyphicon-log-in"></span>Ienākt</a></li>
<?php endif; ?>

    </li>
  </ul>
</div>
</div>

<!--Navbar otrais - pamata sadaļas -->
 <div class="navbar navbar-default second-nav" id='SecondNav'>
  <div class="container">

  <div class="navbar-header">
    <li><a class="navbar-brand" href="index.php"><img src="img/Logo_crop2.png" id='Logo'></a></li>
      <button type="button" class="navbar-toggle navbar-toggler-right pull-right" data-toggle="collapse" data-target="#myNavSecond">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
</div>

    <div class="collapse navbar-collapse" id="myNavSecond">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="news_feed.php">Aktualitātes</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle dropdown-close" data-toggle="dropdown" href="#">Par UDHS<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="characteristics.php">Raksturojums</a></li>
            <li><a href="statistics.php">Statistika</a></li>
            <li><a href="online_test.php">Bērna UDHS novērtēšanas anketa</a></li>
          </ul>
        </li>
          <li class="dropdown">
          <a class="dropdown-toggle dropdown-close" data-toggle="dropdown" href="#">Materiāli<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="guidelines.php">UDHS vadlīnijas</a></li>
            <li><a href="video.php">Video</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle dropdown-close" data-toggle="dropdown" href="#">Atbalsts<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="support_events.php">Atbalsta pasākumi</a></li>
            <li><a href="medication.php">Medikamentu kompensēšana</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle dropdown-close" data-toggle="dropdown" href="#">Par apvienību<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="goals.php">Mērķi</a></li>
            <li><a href="contacts.php">Kontakti</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>

</nav>