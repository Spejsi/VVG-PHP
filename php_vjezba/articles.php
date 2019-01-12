<?php 
if (!isset($_SESSION['anamUser']['user'])){
	header("Location: index.php?menu=6");
}

print '
	<h1>Articles list</h1>
	<div class="articles">';

$query ="SELECT * FROM articles";
$result = @mysqli_query($MySQL, $query);
while($row = @mysqli_fetch_array($result)) {
	
	if ($row['displayed'] == "Y"){
		print '
		<a href="commands.php?command=2&articleId='.$row['articleid'].'"><img src="images/Articles/'.$row['picfilename'].'" alt="'.$row['pictext'].'" title="'.$row['pictext'].'"></a>
		<a href="commands.php?command=2&articleId='.$row['articleid'].'"><h2>'.$row['title'].'</h2></a>
		<p>'.nl2br($row['shortdisplay']).' <a href="commands.php?command=2&articleId='.$row['articleid'].'">More ...</a></p>
		<p><time datetime="'.parseDate($row['articledate']).'">Date of article: '.parseDate($row['articledate']).'</time></p>
		<hr />
	';
	}
}
print '
	</div>
';
?>