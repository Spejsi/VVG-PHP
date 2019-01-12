<?php 

$articleId = 0;
if (isset($_SESSION['articleId'])) {
	$articleId = (int)$_SESSION['articleId'];
}

if ($articleId == 0 || !isset($_SESSION['anamUser']['user'])){
	header("Location: index.php?menu=6");
}

$query ="SELECT * FROM articles WHERE articleid=".$articleId;
$resultArt = @mysqli_query($MySQL, $query);
$query ="SELECT * FROM paragraphs WHERE articleid=".$articleId." ORDER BY paragraphindex ASC";
$resultPar = @mysqli_query($MySQL, $query);
$query ="SELECT * FROM pictures WHERE articleid=".$articleId." ORDER BY picindex ASC";
$resultPic = @mysqli_query($MySQL, $query);

$rowArt = @mysqli_fetch_array($resultArt);

print '
	<h1>'.$rowArt["title"].'</h1>
	<div id="article-gallery">';
	
while($rowPic = @mysqli_fetch_array($resultPic)) {
	print '
		<figure id="'.$rowPic["picindex"].'">
			<img src="images/ArticleImages/'.$rowPic["picfilename"].'" alt="'.$rowPic["picfilename"].'" title="'.$rowPic["picfilename"].'"/>
			<figcaption>'.$rowPic["pictext"].'</figcaption>
		</figure>';
}

	print '
	</div>
	
	<hr>
	
	<div class="articles">';

while($rowPar = @mysqli_fetch_array($resultPar)) {
	print '
		<h2>'.$rowPar["title"].'</h2>
		<p>'.nl2br($rowPar["paragraphtext"]).'</p>
		<hr/>';
}
		
print '
		<p><time datetime="'.$rowArt["articledate"].'">'.$rowArt["articledate"].'</time></p>
		<p><a href="index.php?menu=2">&lt;&lt; Back to Articles page &lt;&lt;</a></p>
	</div>
';
?>