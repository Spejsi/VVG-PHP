<?php 

if  (!(isset($_SESSION['anamUser']['role']) && (
	$_SESSION['anamUser']['role'] == "Administrator" ||
	$_SESSION['anamUser']['role'] == "Editor")))
{
	header("Location: index.php?menu=1");
}

	$message = "";
	
	
	if(isset($_POST['DisplayDeleteArticle'])){
		
		foreach($_POST as $name => $value) {
			$message = "Articles data saved!";
			if(substr($name,0,3) == "art"){
				$articleid = (int)substr($name,3);
				
				if ($value=="Delete"){
					# briši article ako je odabrano "Delete"
					$query ="DELETE FROM articles WHERE articleid=".$articleid;
					$result = @mysqli_query($MySQL, $query);
					# briši sve podatke (pictures/paragraphs) vezane uz taj article ako je odabrano "Delete"
					$query ="DELETE FROM pictures WHERE articleid=".$articleid;
					$result = @mysqli_query($MySQL, $query);
					$query ="DELETE FROM paragraphs WHERE articleid=".$articleid;
					$result = @mysqli_query($MySQL, $query);
				} else {
					# ako je bilo što drugo odabrano, postavi tu vrijednost u role
					$query ="UPDATE articles SET displayed='".$value."' WHERE articleid=".$articleid;
					$result = @mysqli_query($MySQL, $query);
				}
			}
			
			pictureFoldersCleanup($MySQL);
			createRssFeed($MySQL);
			
		}
	}
	
	if(isset($_POST['addarticle'])){
		$_SESSION['articleId'] = 0;
		header("Location: index.php?menu=11");
	}
	
	
	# ako je odabran edit, skoči na editiranje tog article-a
	foreach($_POST as $name => $value){
		if( substr($name, 0, 11) == 'editarticle') {
			$aid = (int)substr($name, 11);
			$_SESSION['articleId'] = $aid;
			header("Location: index.php?menu=11");
		}
	}
	
	
	
	print '
	<h1>Articles administration</h1>
	
	<form action="" id="articles_editor" name="articles_editor" method="POST">
	
	<input type="submit" value="Add new article" name="addarticle" style="width:25%">
	<br />
	
	
	<table class="adminusers">
		<tr class="header">
			<th>&nbsp;Article</th>
			<th>&nbsp;Date</th>
			<th>&nbsp;Display/Delete</th>
			<th>&nbsp;Editing</th>
		</tr>
	';
		
	$query ="SELECT * FROM articles";
	$result = @mysqli_query($MySQL, $query);
	$red = 0;
	while($row = @mysqli_fetch_array($result)) {
		$red++;
		print '
		<tr class='.(($red%2==0) ? "odd" : "even").'>
				<td>&nbsp;'.$row['title'].'</td>
				<td>&nbsp;'.parseDate($row['articledate']).'</td>
				<td class="adminusers">
					<select class="adminusers" id="art'.$row['articleid'].'" name="art'.$row['articleid'].'">
						<option value="N"'. ($row['displayed']=="N" ? " selected" : "") .'>Hide</option>
						<option value="Y"'. ($row['displayed']=="Y" ? " selected" : "") .'>Show</option>';
				if ($_SESSION['anamUser']['role'] == "Administrator"){
					print '
						<option value="Delete">Delete</option>
					';
				}
		print '
					</select>
				</td>
				<td class="editart">
					<input class="editsubmit" type="submit" value="Edit" name="editarticle'.$row['articleid'].'" style="width:75%">
				</td>
		</tr>';
	}
	print '
	</table>
	<br />
	<input type="submit" value="Save edited data" name="DisplayDeleteArticle">
	
	</form>
	<p class="centerparagraph">'.$message.'</p>
	';
	$message = "";
?>