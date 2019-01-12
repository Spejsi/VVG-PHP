<?php

# Stop Hacking attempt
define('__APP__', TRUE);

# Start session
session_start();

$MySQL = mysqli_connect("localhost","root","","phpproject") or die('Error connecting to MySQL server.');

# Variables MUST BE INTEGERS
if(isset($_GET['menu'])) { $menu   = (int)$_GET['menu']; }
if(isset($_GET['action'])) { $action   = (int)$_GET['action']; }

# Variables MUST BE STRINGS A-Z
if(!isset($_POST['_action_']))  { $_POST['_action_'] = FALSE;  }

if (!isset($menu)) { $menu = 1; }

function createRssFeed($MySQL){
	
	$query ="SELECT * FROM articles WHERE displayed='Y' ORDER BY articledate DESC";
	$result = @mysqli_query($MySQL, $query);
	
	$rssfeed  = '<?xml version="1.0" encoding="utf-8"?>';
	$rssfeed .= '<rss version="2.0">';
	$rssfeed .= '<channel>';
	$rssfeed .= '<title>Acoustic new age music</title>';
	$rssfeed .= '<link>http://localhost/php_vjezba_rss/index.php</link>';
	$rssfeed .= '<description>News from Acoustic new age music site</description>';
	
	while($row = @mysqli_fetch_array($result)){
		$rssfeed .= '<item>';
		$rssfeed .= '<title>'.$row['title'].'</title>';
		$rssfeed .= '<link>http://localhost/php_vjezba_rss/commands.php?command=2&amp;articleId='.$row['articleid'].'</link>';
		$rssfeed .= '<description>'.$row['shortdisplay'].'</description>';
		$rssfeed .= '<pubDate>'.$row['articledate'].'</pubDate>';
		$rssfeed .= '</item>';
	}
	$rssfeed .= '</channel>';
	$rssfeed .= '</rss>';
	
	$file = 'feed/rss.xml';
	file_put_contents($file, $rssfeed);
}

# http://localhost/php_vjezba_rss/commands.php?command=2&articleId=2


function parseDate($dtm){
	$date = DateTime::createFromFormat('Y-m-d H:i:s', $dtm);
	return $date->format('d.m.Y, H:i:s');
}

# Funkcija za brisanje svih datoteka (slika) koje nisu u bazi
function pictureFoldersCleanup($MySQL){
	# provjera svih glavnih slika article-a
	$dirArticles = "images/Articles";
	$files = scandir($dirArticles);
	foreach ($files as $value){
		if($value != "." && $value != "..") {
			$query = "SELECT * FROM articles WHERE picfilename='".$value."'";
			$resultPic = @mysqli_query($MySQL, $query);
			$rowArt = @mysqli_fetch_array($resultPic);
			if (!$rowArt) {
				unlink($dirArticles."/".$value);
			}
		}
	}
	
	# provjera svih slika iz article-a
	$dirArticles = "images/ArticleImages";
	$files = scandir($dirArticles);
	foreach ($files as $value){
		if($value != "." && $value != "..") {
			$query = "SELECT * FROM pictures WHERE picfilename='".$value."'";
			$resultPic = @mysqli_query($MySQL, $query);
			$rowArt = @mysqli_fetch_array($resultPic);
			if (!$rowArt) {
				unlink($dirArticles."/".$value);
			}
		}
	}
}



print '

<!DOCTYPE html>
<html lang="hr">

	<head>
		<link rel="stylesheet" href="style.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet"> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="Prvi projektni zadatak" />
		<meta name="keywords" content="projektni zadatak,PHP" />
		<meta name="author" content="Mario Pavše" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Projektni zadatak PHP</title>
	</head>

	<body>
		<header>
			<div class="banner-image"></div>
			<nav>
				<ul>
					<li><a href="index.php?menu=1">Home</a></li>
					<li><a href="index.php?menu=2">Articles</a></li>
					<li><a href="index.php?menu=3">Contact</a></li>
					<li><a href="index.php?menu=4">About</a></li>
					<li><a href="index.php?menu=5">Gallery</a></li>';
					
					if (isset($_SESSION['anamUser']['role']) && (
						$_SESSION['anamUser']['role'] == "Administrator" ||
						$_SESSION['anamUser']['role'] == "Editor"))
					{
						print'<li><a href="index.php?menu=9">Edit articles</a></li>';
					}
					
					if (isset($_SESSION['anamUser']['role']) && 
						$_SESSION['anamUser']['role'] == "User")
					{
						print'<li><a href="index.php?menu=11">Add article</a></li>';
					}
					
					if (isset($_SESSION['anamUser']['role']) &&
						$_SESSION['anamUser']['role'] == "Administrator")
					{
						print'<li><a href="index.php?menu=10">User administration</a></li>';
					}
					
					
					if (!isset($_SESSION['anamUser']['user'])){
						print '<li class="nav-right"><a href="index.php?menu=7">Register</a></li>';
					}
					if (!isset($_SESSION['anamUser']['user'])){
						print '<li class="nav-right"><a href="index.php?menu=6">Log in</a></li>';
					} else {
						print '<li class="nav-right"><a href="commands.php?command=1">Log out</a></li>';
					}
				print '
				</ul>
			</nav>
		</header>';	
print '
		<div class="user-message">';
		if(isset($_SESSION['anamUser']['user'])) print 'User: '.$_SESSION['anamUser']['name'].' ('.$_SESSION['anamUser']['user'].')';
		print '</div>
		<main>';
		
		if (!isset($_GET['article'])) {
			if (!isset($_GET['menu']) || $_GET['menu'] == 1) { include("home.php"); }
			else if ($_GET['menu'] == 2) { include("articles.php"); }
			else if ($_GET['menu'] == 3) { include("contact.php"); }
			else if ($_GET['menu'] == 4) { include("about.php"); }
			else if ($_GET['menu'] == 5) { include("gallery.php"); }
			else if ($_GET['menu'] == 6) { include("login.php"); }
			else if ($_GET['menu'] == 7) { include("register.php"); }
			else if ($_GET['menu'] == 8) { include("registration_data.php"); }
			else if ($_GET['menu'] == 9) { include("articles_administration.php"); }
			else if ($_GET['menu'] == 10) { include("user_administration.php"); }
			else if ($_GET['menu'] == 11) { include("edit_article.php"); }
			else if ($_GET['menu'] == 12) { include("show_article.php"); }
		}
		
		print '
		
		</main>
			
		<footer>
		  <p>Copyright: &copy; Mario Pavše, 2018. | Contact information: <a href="mailto:mario_pavse@yahoo.com">mario_pavse@yahoo.com</a> | Github link: 
		  <a href="https://github.com/Spejsi/VVG-PHP">Spacedancer</a> | RSS feed: <a type="application/rss+xml" href="http://localhost/php_vjezba_rss/feed/rss.xml" target="_blank">
		  Acoustic New Age Music</a> <img src="images/rss_feed_icon_16.gif" style="width:10px;" alt="RSS feed" title="RSS feed for Acoustic New Age Music"/>
		  </p>
		</footer> 
	</body>

</html> ';

?>