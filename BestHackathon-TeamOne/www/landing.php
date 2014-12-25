<?
require_once('php/config.php');
require_once('php/functions.php');

if(!empty($_POST['em_log']) && !empty($_POST['pas_log']))
{
	if(validateUser($_POST['em_log'],$_POST['pas_log']))
	{
		header('Location: /user.php');
	}
}

if(!empty($_POST['token']))
{
        $token = $_POST['token'];

        $result = false;
		
        if (function_exists('file_get_contents') && ini_get('allow_url_fopen')){

        $result = file_get_contents('http://ulogin.ru/token.php?token=' . $token .
        '&host=' . $_SERVER['HTTP_HOST']);

        //если недоступна file_get_contents, пробуем использовать curl
        }elseif(in_array('curl', get_loaded_extensions())){

        $request = curl_init('http://ulogin.ru/token.php?token=' . $token .
        '&host=' . $_SERVER['HTTP_HOST']);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($request);

        }

        $data = $result ? json_decode($result, true) : array();
        //проверяем, чтобы в ответе были данные, и не было ошибки
        if (!empty($data) and !isset($data['error'])){
					if(!empty($data['first_name']) && !empty($data['last_name']))
					{
					$sql = "SELECT email FROM users WHERE email = '" . $data['email'] . "' LIMIT 1";
					
					$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
					
					if (mysql_num_rows($query) == 1) {
						$_SESSION['error'] = "Email already exists.";
					}else {
						// All errors passed lets
						// Create our insert SQL by hashing the password and using the escaped Email.
						$sql = "INSERT INTO users (`email`,`name`,`surname`) VALUES ('" . $data['email'] . "','" . $data['first_name'] . "','" . $data['last_name'] . "');";
						
						$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
						
						if ($query) {
							$sql = "SELECT * FROM users 
								WHERE email = '" . $data['email']  . "' LIMIT 1";
							$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
						
							$row = mysql_fetch_assoc($query);
							$_SESSION['id'] 		= $row['id'];
							$_SESSION['email']	 	= $row['email'];
							$_SESSION['name'] 		= $row['name'];
							$_SESSION['surname'] 	= $row['surname'];
							$_SESSION['loggedin']	= true;
							
							header('Location: /user.php');
							
						}	
					}
					}
					else
					{
							$sql = "SELECT * FROM users 
								WHERE email = '" . $data['email']  . "' LIMIT 1";
							$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
						
							$row = mysql_fetch_assoc($query);
							if(!empty($row['id']))
							{
							$_SESSION['id'] 		= $row['id'];
							$_SESSION['email']	 	= $row['email'];
							$_SESSION['name'] 		= $row['name'];
							$_SESSION['surname'] 	= $row['surname'];
							$_SESSION['loggedin']	= true;
							
							header('Location: /user.php');
							}
							else
							{
								echo "<script>alert('You are not registered!');</script>";
							}
					}

        }


        
                  
}	
if(!empty($_POST['user_email']) && !empty($_POST['user_pass_repeat']))
{
	if(createAccount($_POST['user_email'], $_POST['user_pass_repeat']))
	{
		echo "<script>location.href='/user.php';</script>";
	}
}
?>
    <!DOCTYPE HTML>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <title>Legend - One Page Bootstrap Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style_main.css" rel="stylesheet">
    <link rel='stylesheet' id='prettyphoto-css'  href="css/prettyPhoto.css" type='text/css' media='all'>
    <link href="css/fontello.css" type="text/css" rel="stylesheet">
    <!--[if lt IE 7]>
            <link href="css/fontello-ie7.css" type="text/css" rel="stylesheet">  
        <![endif]-->
    <!-- Google Web fonts -->
    <link href='http://fonts.googleapis.com/css?family=Quattrocento:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Patua+One' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <style>
    body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
    }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery.js"></script>
    <!-- Load ScrollTo -->
    <script type="text/javascript" src="js/jquery.scrollTo-1.4.2-min.js"></script>
    <!-- Load LocalScroll -->
    <script type="text/javascript" src="js/jquery.localscroll-1.2.7-min.js"></script>
    <!-- prettyPhoto Initialization -->
    <script type="text/javascript" charset="utf-8">
          $(document).ready(function(){
            $("a[rel^='prettyPhoto']").prettyPhoto();
          });
        </script>
			<script>
		/*______CALLBACK_______*/
		$(document).ready(function() {
     $('#go').click( function(event){ // ловим клик по ссылки с id="go"
         event.preventDefault(); // выключаем стандартную роль элемента
         $('body').css('overflow', 'hidden'); // выключаем скролл
         $('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
             function(){ // после выполнения предъидущей анимации
                 $('#modal_form') 
                     .css('display', 'block') // убираем у модального окна display: none;
                     .animate({opacity: 1, top: '50%'}, 200); // плавно прибавляем прозрачность одновременно со съезжанием вниз
         });
     });
     /* Закрытие модального окна, тут делаем то же самое но в обратном порядке */
     $('#modal_close, #overlay').click( function(){ // ловим клик по крестику или подложке
         $('body').css('overflow', 'auto'); // включаем скролл
         $('#modal_form')
             .animate({opacity: 0, top: '45%'}, 200,  // плавно меняем прозрачность на 0 и одновременно двигаем окно вверх
                 function(){ // после анимации
                     $(this).css('display', 'none'); // делаем ему display: none;
                     $('#overlay').fadeOut(400); // скрываем подложку
                 }
             );
     });
});
		</script>
    </head>
    <body>
		<div id="modal_form"><!-- Само окно --> 
      <span id="modal_close">X</span> <!-- Кнопка закрыть --> 
	  <br>
      <center>
		<form action="#" method="post">
			<table>
				<tr>
					<td><h3 style="display:inline;">Email:</h3></td><td><input type="text" style="margin:0px;color:#000;height:30px;width:170px;padding:5px;" name="em_log"></td>
				</tr>
				<tr>
					<td><h3 style="display:inline;">Password:</h3></td><td><input type="password" style="margin:0px;color:#000;height:30px;width:170px;padding:5px;" name="pas_log"></td>
				</tr>
			</table>
			<br>
			<center><input type="submit" style="width:200px;" class="button" value="Submit"></center>
			<br>
			<script src="//ulogin.ru/js/ulogin.js"></script>
<div id="uLogin1" data-ulogin="display=panel;fields=email;providers=vkontakte,odnoklassniki,facebook,googleplus;redirect_uri=http%3A%2F%2Fbest.udesgo.com"></div>
		</center>
		</div>
		<div id="overlay"></div>
    <!--******************** NAVBAR ********************-->
    <div class="navbar-wrapper">
      <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container_menu">
            <!-- Responsive Navbar Part 1: Button for triggering responsive navbar (not covered in tutorial). Include responsive CSS to utilize. -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
            <h1 class="brand"><a href="#top">Aimy</a></h1>
            <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
            <nav class="pull-right nav-collapse collapse">
              <ul id="menu-main" class="nav">
                <li><a title="portfolio" href="#portfolio">Portfolio</a></li>
                <li><a title="services" href="#services">Services</a></li>
                <li><a title="news" href="#news">News</a></li>
                <li><a title="team" href="#team">Team</a></li>
                <li><a title="contact" href="#contact">Contact</a></li>
				<li><input type="button" style="height:38px;width:80px;border-radius:5px;border:0px;margin-left:10px;" id="go" class="button" value="Log In"></li>
              </ul>
            </nav>
			
          </div>
		  
          <!-- /.container -->
        </div>
        <!-- /.navbar-inner -->
      </div>
      <!-- /.navbar -->
    </div>
    <!-- /.navbar-wrapper -->
    <div id="top"></div>
    <!-- ******************** HeaderWrap ********************-->
    <div id="headerwrap">
      <header class="clearfix">
        <div class="container">
			 <center>
					<div class="text_main"><div>Take your achievements to a new level with Aimy.<br>
Become a part of a global successful community that is fun and motivational.<br>
Aimy is the best helper to follow your dreams.<br>
Aimy creates aims, reminds to follow an aim, shares aims with others.<br>
You can see achievements of any person and repeat his or her success.</div></div>
					<div class="register_main"><div>
					<h2 style="display:inline;">REGISTER NOW!</h2>
					<br><br>
					<form method="post" action="#">
						<input type="text" style="color:#000;height:40px;width:330px;padding:5px;" name="user_email" placeholder="Your Email">
						<input type="password" style="color:#000;height:40px;width:330px;padding:5px;" name="user_pass" placeholder="Password">
						<input type="password" style="color:#000;height:40px;width:330px;padding:5px;" name="user_pass_repeat" placeholder="Repeat Password">
						<center><input type="submit" style="width:200px;" class="button" value="Submit"></center>
						<script src="//ulogin.ru/js/ulogin.js"></script>
<div id="uLogin2" data-ulogin="display=panel;fields=first_name,last_name,email;providers=vkontakte,odnoklassniki,facebook,googleplus;redirect_uri=http%3A%2F%2Fbest.udesgo.com"></div>
					</form>
					</div></div><br><br><br><br>
			</center>
        </div>
      </header>
    </div>
    <!--******************** Feature ********************-->
    <div class="scrollblock">
      <section id="feature">
       
        <!-- ./container -->
      </section>
    </div>
    <hr>
    <!-- Loading the javaScript at the end of the page -->
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
    <script type="text/javascript" src="js/site.js"></script>
    
    <!--ANALYTICS CODE-->
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-29231762-1']);
	  _gaq.push(['_setDomainName', 'dzyngiri.com']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
    </body>
    </html>
