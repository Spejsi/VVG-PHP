<?php 

$articleId = 0;
if (isset($_SESSION['articleId'])) {
	$articleId = (int)$_SESSION['articleId'];
}

$articleUpdate = true;
$message = "";

if ($articleId == 0) {
	$query ="SELECT articleid FROM articles ORDER BY articleid DESC LIMIT 1";
	$result = @mysqli_query($MySQL, $query);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$articleId = $row["articleid"]+1;
	$articleUpdate = false;
}

function fileNameCheckInFolder($filename) {
    $fn = $filename;
	$fp = substr($fn, 0, (strrpos($fn, ".")) );
	$fe = strtolower(substr($fn, (strrpos($fn, ".")) ));
	
	if ( $fe != '.jpg' && $fe != '.jpeg' && $fe != '.png' && $fe != '.gif' ) {
		$fn = "-";
	} else {
		$ind = 0;
		while ( file_exists($fn) ){
			$ind++;
			$fn = $fp."_".$ind.$fe;
		}
	}
	return $fn;
}  

function articleDbQuery($art, $upd){
	$q = "";
	if ($upd == true){
		$q = "UPDATE articles SET title='".$art['title']."', shortdisplay='".$art['shortdisplay'];
		$q .= "', articledate='".$art['articledate']."', displayed='".$art['displayed']."', picfilename='".$art['picfilename'];
		$q .= "', pictext='".$art['pictext']."' WHERE articleid=".$art['articleid'];
	} else {
		$q = "INSERT INTO articles (articleid, title, shortdisplay, articledate, displayed, picfilename, pictext)";
		$q .= " VALUES (".$art['articleid'].", '".$art['title']."', '".$art['shortdisplay']."', '";
		$q .= $art['articledate']."', '".$art['displayed']."', '".$art['picfilename']."', '".$art['pictext']."')";
	}
	return $q;
}

function paragraphDbQuery($par){
	$q = "INSERT INTO paragraphs (articleid, paragraphindex, title, paragraphtext)";
	$q .= " VALUES (".$par['articleid'].", ".$par['paragraphindex'].", '".$par['title']."', '".$par['paragraphtext']."')";
	return $q;
}
function paragraphDbClearQuery($aid){
	$q = "DELETE FROM paragraphs WHERE articleid=".$aid;
	return $q;
}

function pictureDbQuery($pic){
	$q = "INSERT INTO pictures (articleid, picindex, picfilename, pictext)";
	$q .= " VALUES (".$pic['articleid'].", ".$pic['picindex'].", '".$pic['picfilename']."', '".$pic['pictext']."')";
	return $q;
}
function pictureDbClearQuery($aid){
	$q = "DELETE FROM pictures WHERE articleid=".$aid;
	return $q;
}


if(isset($_POST['editArticle'])){
	
	# ARTICLES UPLOAD PIC AND UPDATE DATABASE
	
		$dbArticle = array();
		
		# slika od article za upload
		$target_dir = "images/Articles/";
		$target_file = $target_dir . basename($_FILES["picfile"]["name"]);
		
		#print $target_file."<hr />";
		$uploadArtFilename = fileNameCheckInFolder($target_file);
		#print "upload: ".$uploadArtFilename."<br>";
		
		# uploadaj sliku ako je postavljena nova
		if ($uploadArtFilename == "-"){
			$dbArtPicfilename = $_POST["artpicfilenamehidden"];
		} else {
			$dbArtPicfilename = substr($uploadArtFilename, (strrpos($uploadArtFilename, "/"))+1 );
			copy($_FILES['picfile']['tmp_name'], $uploadArtFilename);
		}
		
		$dbArticle["articleid"] = $articleId;
		$dbArticle["shortdisplay"] = $_POST["articleshortdisplay"];
		$dbArticle["title"] = $_POST["articlename"];
		$dbArticle["picfilename"] = $dbArtPicfilename;
		$dbArticle["pictext"] = $_POST["artpictext"];
		$dbArticle["articledate"] = date('Y-m-d H:i:s');
		$dbArticle["displayed"] = "N";
		#print "Za Article:<br>";
		$query = articleDbQuery($dbArticle, $articleUpdate);
		# ovdje šalji query za articles
		$result = @mysqli_query($MySQL, $query);
		#print $query."<br>";
	
	# PARAGRAPHS UPDATE DATABASE
		
		$dbParagraph = array();
		
		#print "<br>Za Paragraph:<br>";
		$query = paragraphDbClearQuery($articleId);
		# ovdje šalji query za brisanje podataka paragrapha za taj article
		$result = @mysqli_query($MySQL, $query);
		#print $query."<br>";
		$indx = 1;
		while ( isset($_POST["articlename".$indx] )){
			$dbParagraph["articleid"] = $articleId;
			$dbParagraph["paragraphindex"] = $indx;
			$dbParagraph["paragraphtext"] = $_POST["paragraphtext".$indx];
			$dbParagraph["title"] = $_POST["articlename".$indx];
			$query = paragraphDbQuery($dbParagraph);
			# ovdje šalji query za paragraph
			$result = @mysqli_query($MySQL, $query);
			#print $query."<br>";
			$indx++;
		}
		
	# PICTURES UPLOAD PICS AND UPDATE DATABASE
		
		$dbPicture = array();
		
		#print "<br>Za Pictures:<br>";
		$query = pictureDbClearQuery($articleId);
		# ovdje šalji query za brisanje podataka pictures za taj article
		$result = @mysqli_query($MySQL, $query);
		#print $query."<br>";
		$indx = 1;
		while ( isset($_POST["picfilenamehidden".$indx] )){
			
			# slika od article za upload
			$target_dir = "images/ArticleImages/";
			$target_file = $target_dir . basename($_FILES["picfile".$indx]["name"]);
			#print $target_file."<br />";
			$uploadArtFilename = fileNameCheckInFolder($target_file);
			#print "upload: ".$uploadArtFilename."<br>";
			
			# uploadaj sliku ako je postavljena nova
			if ($uploadArtFilename == "-"){
				$dbArtPicfilename = $_POST["picfilenamehidden".$indx];
			} else {
				$dbArtPicfilename = substr($uploadArtFilename, (strrpos($uploadArtFilename, "/"))+1 );
				copy($_FILES['picfile'.$indx]['tmp_name'], $uploadArtFilename);
			}

			$dbPicture["articleid"] = $articleId;
			$dbPicture["picindex"] = $indx;
			$dbPicture["pictext"] = $_POST["pictext".$indx];
			$dbPicture["picfilename"] = $dbArtPicfilename;
			$query = pictureDbQuery($dbPicture);
			# ovdje šalji query za paragraph
			$result = @mysqli_query($MySQL, $query);
			#print $query."<br>";
			$indx++;
		}
		$message = "Data successfully saved!";
		
		pictureFoldersCleanup($MySQL);
		createRssFeed($MySQL);
}


$query ="SELECT * FROM articles WHERE articleid=".$articleId;
$resultArt = @mysqli_query($MySQL, $query);
$query ="SELECT * FROM paragraphs WHERE articleid=".$articleId." ORDER BY paragraphindex ASC";
$resultPar = @mysqli_query($MySQL, $query);
$query ="SELECT * FROM pictures WHERE articleid=".$articleId." ORDER BY picindex ASC";
$resultPic = @mysqli_query($MySQL, $query);

$rowArt = @mysqli_fetch_array($resultArt);
$artName = $rowArt["title"];
$artShortdisplay = $rowArt["shortdisplay"];
$artPicfilename = $rowArt["picfilename"];
$artPictext = $rowArt["pictext"];
$artArticledate = $rowArt["articledate"];
$artDisplayed = "N";

$paragraphsArray = array();
while($rowPar = @mysqli_fetch_array($resultPar)) {
	$par = array("paragraphindex"=>$rowPar["paragraphindex"], "paragraphtext"=>$rowPar["paragraphtext"], "title"=>$rowPar["title"]);
	array_push($paragraphsArray, $par);
}


$picturesArray = array();
while($rowPic = @mysqli_fetch_array($resultPic)) {
	$pic = array("picindex"=>$rowPic["picindex"], "picfilename"=>$rowPic["picfilename"], "pictext"=>$rowPic["pictext"]);
	array_push($picturesArray, $pic);
}




// javascript funkcije
print '
	<script>
		
		function onChangeBrowse(id){
			console.log("change on: "+id);
			var xx = document.getElementById("picfile" + id).required = false;
		}
		
		function addNewParagraph(){
			var allPars = [];
			var indx = 1;
			while (document.getElementById("articlename" + indx)){
				var ptitle = document.getElementById("articlename" + indx).value;
				var ptext = document.getElementById("paragraphtext" + indx).value;
				indx++;
			}
			var el = createParagraph(indx.toString(), "New paragraph", "Paragraph text");
			document.getElementById("allparagraphs").appendChild(el);
		}
		
		function addNewPicture(){
			var allPics = [];
			var indx = 1;
			while (document.getElementById("picfilenamehidden" + indx)){
				var ptitle = document.getElementById("picfilenamehidden" + indx).value;
				var ptext = document.getElementById("pictext" + indx).value;
				indx++;
			}
			var el = createPicture(indx.toString(), "-", "Picture text", true);
			document.getElementById("allpictures").appendChild(el);
		}
		
		function picUp(id){
			var allPics = [];
			var indx = 1;
			while (document.getElementById("picfilenamehidden" + indx)){
				var ptitle = document.getElementById("picfilenamehidden" + indx).value;
				var ptext = document.getElementById("pictext" + indx).value;
				var prequired = document.getElementById("picfile" + indx).required;
				if (ptitle == "-") { prequired = true; }
				allPics.push([ptitle, ptext, prequired]);
				indx++;
			}
			if (id>1) {
				var swp = allPics[id-1];
				allPics[id-1] = allPics[id-2];
				allPics[id-2] = swp;
				var element = document.getElementById("allpictures");
				while (element.firstChild) {
					element.removeChild(element.firstChild);
				}
				for (var i=0; i<allPics.length; i++){
					var el=createPicture((i+1), allPics[i][0], allPics[i][1], allPics[i][2]);
					element.appendChild(el);
				}
			}
		}
		
		function picDown(id){
			var allPics = [];
			var indx = 1;
			while (document.getElementById("picfilenamehidden" + indx)){
				var ptitle = document.getElementById("picfilenamehidden" + indx).value;
				var ptext = document.getElementById("pictext" + indx).value;
				var prequired = document.getElementById("picfile" + indx).required;
				if (ptitle == "-") { prequired = true; }
				allPics.push([ptitle, ptext, prequired]);
				indx++;
			}
			if (id<allPics.length) {
				var swp = allPics[id-1];
				allPics[id-1] = allPics[id];
				allPics[id] = swp;
				var element = document.getElementById("allpictures");
				while (element.firstChild) {
					element.removeChild(element.firstChild);
				}
				for (var i=0; i<allPics.length; i++){
					var el=createPicture((i+1), allPics[i][0], allPics[i][1], allPics[i][2]);
					element.appendChild(el);
				}
			}
		}
		
		function picDel(id){
			var allPics = [];
			var indx = 1;
			while (document.getElementById("picfilenamehidden" + indx)){
				var ptitle = document.getElementById("picfilenamehidden" + indx).value;
				var ptext = document.getElementById("pictext" + indx).value;
				var prequired = document.getElementById("picfile" + indx).required;
				if (ptitle == "-") { prequired = true; }
				if (indx.toString()!=id.toString()) {
					allPics.push([ptitle, ptext, prequired]);
				}
				indx++;
			}
			var element = document.getElementById("allpictures");
			while (element.firstChild) {
				element.removeChild(element.firstChild);
			}
			for (var i=0; i<allPics.length; i++){
				var el=createPicture((i+1), allPics[i][0], allPics[i][1], allPics[i][2]);
				element.appendChild(el);
			}
		}
		
		function removeParagraph(id){
			var allPars = [];
			var indx = 1;
			while (document.getElementById("articlename" + indx)){
				var ptitle = document.getElementById("articlename" + indx).value;
				var ptext = document.getElementById("paragraphtext" + indx).value;
				if (indx.toString()!=id.toString()){
					allPars.push([ptitle, ptext]);
				}
				indx++;
			}
			var element = document.getElementById("allparagraphs");
			while (element.firstChild) {
				element.removeChild(element.firstChild);
			}
			for (var i=0; i<allPars.length; i++){
				var el=createParagraph((i+1), allPars[i][0], allPars[i][1]);
				element.appendChild(el);
			}
		}
		
		function createParagraph(paragraphindex, title, paragraphtext){
			
			var element = document.createElement("DIV");
			
			var el = document.createElement("H2");
			var tx = document.createTextNode("Paragraph " + paragraphindex + ":");
			el.appendChild(tx);
			element.appendChild(el);
			
			el = document.createElement("LABEL");
			el.htmlFor = "paragraphname"+paragraphindex;
			tx = document.createTextNode("Paragraph title *");
			el.appendChild(tx);
			element.appendChild(el);
			
			el = document.createElement("INPUT");
			var att = document.createAttribute("type");
			att.value = "text";
			el.setAttributeNode(att);
			att = document.createAttribute("id");
			att.value = "articlename"+paragraphindex;
			el.setAttributeNode(att);
			att = document.createAttribute("name");
			att.value = "articlename"+paragraphindex;
			el.setAttributeNode(att);
			att = document.createAttribute("placeholder");
			att.value = "Enter name of an article";
			el.setAttributeNode(att);
			att = document.createAttribute("value");
			att.value = title;
			el.setAttributeNode(att);
			el.required = true;
			element.appendChild(el);
			
			el = document.createElement("LABEL");
			el.htmlFor = "paragraphtext"+paragraphindex;
			tx = document.createTextNode("Text *");
			el.appendChild(tx);
			element.appendChild(el);
			
			el = document.createElement("TEXTAREA");
			att = document.createAttribute("id");
			att.value = "paragraphtext" + paragraphindex;
			el.setAttributeNode(att);
			att = document.createAttribute("name");
			att.value = "paragraphtext" + paragraphindex;
			el.setAttributeNode(att);
			att = document.createAttribute("placeholder");
			att.value = "Write text...";
			el.setAttributeNode(att);
			att = document.createAttribute("style");
			att.value = "height:200px";
			el.setAttributeNode(att);
			att = document.createAttribute("required");
			att.value = "required";
			el.setAttributeNode(att);
			tx = document.createTextNode(paragraphtext);
			el.appendChild(tx);
			element.appendChild(el);
			
			el = document.createElement("INPUT");
			att = document.createAttribute("type");
			att.value = "button";
			el.setAttributeNode(att);
			att = document.createAttribute("value");
			att.value = "Remove this paragraph";
			el.setAttributeNode(att);
			att = document.createAttribute("onclick");
			att.value = "removeParagraph("+paragraphindex+")";
			
			el.setAttributeNode(att);
			element.appendChild(el);
			
			el = document.createElement("HR");
			element.appendChild(el);
			
			return element;
		}
		
		
		function createPicture(picindex, picfilename, pictext, prequired){
			
			var element = document.createElement("DIV");
			
			var el = document.createElement("P");
			var tx = document.createTextNode("Image "+picindex+": \""+picfilename+"\"");
			el.appendChild(tx);
			element.appendChild(el);
			
			el = document.createElement("INPUT");
			var att = document.createAttribute("type");
			att.value = "text";
			el.setAttributeNode(att);
			att = document.createAttribute("id");
			att.value = "picfilenamehidden" + picindex;
			el.setAttributeNode(att);
			att = document.createAttribute("name");
			att.value = "picfilenamehidden" + picindex;
			el.setAttributeNode(att);
			att = document.createAttribute("value");
			att.value = picfilename;
			el.setAttributeNode(att);
			att = document.createAttribute("hidden");
			att.value = "true";
			el.setAttributeNode(att);
			element.appendChild(el);

			var tbl = document.createElement("TABLE");
			att = document.createAttribute("class");
			att.value = "pictures";
			tbl.setAttributeNode(att);
				
				var ttr = document.createElement("TR");
			
					var ttd = document.createElement("TD");
					att = document.createAttribute("width");
					att.value = "80%";
					ttd.setAttributeNode(att);
						var timg = document.createElement("IMG");
						att = document.createAttribute("alt");
						att.value = pictext;
						timg.setAttributeNode(att);
						att = document.createAttribute("style");
						att.value = "width:40%; border:3px solid #29497c;";
						timg.setAttributeNode(att);
						att = document.createAttribute("src");
						if (picfilename != "-") att.value = "images/ArticleImages/"+picfilename;
						if (picfilename == "-") att.value = "images/no_image.jpg";
						timg.setAttributeNode(att);
					ttd.appendChild(timg);
				
				ttr.appendChild(ttd);
					
					ttd = document.createElement("TD");
					att = document.createAttribute("width");
					att.value = "20%";
					ttd.setAttributeNode(att);
						
						var tbut = document.createElement("BUTTON");
						att = document.createAttribute("type");
						att.value = "button";
						tbut.setAttributeNode(att);
						att = document.createAttribute("class");
						att.value = "pictures";
						tbut.setAttributeNode(att);
						att = document.createAttribute("value");
						att.value = "Delete";
						tbut.setAttributeNode(att);
						att = document.createAttribute("name");
						att.value = "picDel" + picindex;
						tbut.setAttributeNode(att);
						att = document.createAttribute("style");
						att.value = "width:90%";
						tbut.setAttributeNode(att);
						att = document.createAttribute("onclick");
						att.value = "picDel("+picindex+")";
						tbut.setAttributeNode(att);
						tx = document.createTextNode("Delete");
						tbut.appendChild(tx);
					ttd.appendChild(tbut);
					
						tbut = document.createElement("BUTTON");
						att = document.createAttribute("type");
						att.value = "button";
						tbut.setAttributeNode(att);
						att = document.createAttribute("class");
						att.value = "pictures";
						tbut.setAttributeNode(att);
						att = document.createAttribute("value");
						att.value = "Up";
						tbut.setAttributeNode(att);
						att = document.createAttribute("name");
						att.value = "picUp" + picindex;
						tbut.setAttributeNode(att);
						att = document.createAttribute("style");
						att.value = "width:90%";
						tbut.setAttributeNode(att);
						att = document.createAttribute("onclick");
						att.value = "picUp("+picindex+")";
						tbut.setAttributeNode(att);
							timg = document.createElement("IMG");
							att = document.createAttribute("src");
							att.value = "images/arrow_up.png";
							timg.setAttributeNode(att);
						tbut.appendChild(timg);
					ttd.appendChild(tbut);
						
						var tbr = document.createElement("BR");
					ttd.appendChild(tbr);
					
						tbut = document.createElement("BUTTON");
						att = document.createAttribute("type");
						att.value = "button";
						tbut.setAttributeNode(att);
						att = document.createAttribute("class");
						att.value = "pictures";
						tbut.setAttributeNode(att);
						att = document.createAttribute("value");
						att.value = "Down";
						tbut.setAttributeNode(att);
						att = document.createAttribute("name");
						att.value = "picDown" + picindex;
						tbut.setAttributeNode(att);
						att = document.createAttribute("style");
						att.value = "width:90%";
						tbut.setAttributeNode(att);
						att = document.createAttribute("onclick");
						att.value = "picDown("+picindex+")";
						tbut.setAttributeNode(att);
							timg = document.createElement("IMG");
							att = document.createAttribute("src");
							att.value = "images/arrow_down.png";
							timg.setAttributeNode(att);
						tbut.appendChild(timg);
						ttd.appendChild(tbut);
						
						tbr = document.createElement("BR");
					ttd.appendChild(tbr);
				
				ttr.appendChild(ttd);
			
			tbl.appendChild(ttr);
				
				ttr = document.createElement("TR");
			
					ttd = document.createElement("TD");
					att = document.createAttribute("colspan");
					att.value = 2;
					ttd.setAttributeNode(att);
					
						var tlab = document.createElement("LABEL");
						tlab.htmlFor = "pictext"+picindex;
						tx = document.createTextNode("Picture text: *");
						tlab.appendChild(tx);
					ttd.appendChild(tlab);
						
						var tinp = document.createElement("INPUT");
						att = document.createAttribute("type");
						att.value = "text";
						tinp.setAttributeNode(att);
						att = document.createAttribute("id");
						att.value = "pictext"+picindex;
						tinp.setAttributeNode(att);
						att = document.createAttribute("name");
						att.value = "pictext"+picindex;
						tinp.setAttributeNode(att);
						att = document.createAttribute("placeholder");
						att.value = "Enter text for picture";
						tinp.setAttributeNode(att);
						att = document.createAttribute("style");
						att.value = "width:90%";
						tinp.setAttributeNode(att);
						att = document.createAttribute("value");
						att.value = pictext;
						tinp.setAttributeNode(att);
						tinp.required = true;
					ttd.appendChild(tinp);
						
						tinp = document.createElement("INPUT");
						att = document.createAttribute("type");
						att.value = "file";
						tinp.setAttributeNode(att);
						att = document.createAttribute("id");
						att.value = "picfile"+picindex;
						tinp.setAttributeNode(att);
						att = document.createAttribute("name");
						att.value = "picfile"+picindex;
						tinp.setAttributeNode(att);
						att = document.createAttribute("class");
						att.value = "editsubmit";
						tinp.setAttributeNode(att);
						att = document.createAttribute("style");
						att.value = "width:60%";
						tinp.setAttributeNode(att);
						att = document.createAttribute("onchange");
						att.value = "onChangeBrowse("+picindex+")";
						tinp.setAttributeNode(att);
						tinp.required = prequired;
					ttd.appendChild(tinp);
				
				ttr.appendChild(ttd);
				
			tbl.appendChild(ttr);
			
			element.appendChild(tbl);
			
			
			
			el = document.createElement("HR");
			element.appendChild(el);	
			
			return element;
		}
	
	</script>
';



print '
	<h1>Edit article</h1>
	
	<div id="articleediting">
		<form action="" id="contact_form" name="contact_form" method="POST" enctype="multipart/form-data">
		
			<input type="submit" name="editArticle" value="Submit all article data" style="width:50%">';
		if ($message) {
			print '<p class="centerparagraph">'.$message.'</p>';
			$message = "";
		}
		print '
			<hr />
			
			<label for="articlename">Article name *</label>
			<input type="text" id="articlename" name="articlename" placeholder="Enter name of an article" required value="'.$artName.'">
			
			<label for="articleshortdisplay">Short display of an article *</label>
			<textarea id="articleshortdisplay" name="articleshortdisplay" placeholder="Write article short display..." style="height:100px" required="required">'.$artShortdisplay.'</textarea>
			
			<p class="centerparagraph">Article picture: "'.$artPicfilename.'"</p>
			
			<img alt="'.$artPictext.'" style="width:10%; border:3px solid #29497c;" src="';
			
			if (!$artPicfilename) { print 'images/no_image.jpg'; }
							 else { print 'images/Articles/'.$artPicfilename; }
			
			print '">
			
			<input type="file" id="picfile" name="picfile" class="editsubmit"';
			
			if (!$artPicfilename) { print ' required'; }
			
			print '>
			
			<br />
			<label for="artpictext">Article picture text *</label>
			<input type="text" id="artpictext" name="artpictext" placeholder="Enter text for picture" value="'.$artPictext.'" required>
			
			<input type="text" id="artpicfilenamehidden" name="artpicfilenamehidden" value="'.$artPicfilename.'" hidden="true">
			
			<br /><br />
			
			<hr />';
			
			
			# ------
			
			print '<div id="allparagraphs">';
			
			foreach ($paragraphsArray as $rowPar) {
				print '
				<h2>Paragraph '.$rowPar["paragraphindex"].':</h2>
				<label for="paragraphname'.$rowPar["paragraphindex"].'">Paragraph title *</label>
				<input type="text" id="articlename'.$rowPar["paragraphindex"].'" name="articlename'.$rowPar["paragraphindex"].'" placeholder="Enter name of an article" value="'.$rowPar["title"].'" required>
				<label for="paragraphtext'.$rowPar["paragraphindex"].'">Text</label>
				<textarea id="paragraphtext'.$rowPar["paragraphindex"].'" name="paragraphtext'.$rowPar["paragraphindex"].'" placeholder="Write text..." style="height:200px" required="required">'.$rowPar["paragraphtext"].'</textarea>
				<input type="button" value="Remove this paragraph" onclick="removeParagraph('.$rowPar["paragraphindex"].')">
				<hr />';
			}
			
			print '</div>';
			
			# ------
			
			print '
			<input type="button" value="Add new paragraph" name="addparagraph" onclick="addNewParagraph()" style="width:50%">
				
			<hr />
			
			<h2>Gallery:</h2>';
			
			# ------ Početak svih slika
			
			
			print '<div id="allpictures">';
			
			foreach ($picturesArray as $rowPic) {
			print '
				<p>Image '.$rowPic["picindex"].': "'.$rowPic["picfilename"].'"</p>
				<input type="text" id="picfilenamehidden'.$rowPic["picindex"].'" name="picfilenamehidden'.$rowPic["picindex"].'" value="'.$rowPic["picfilename"].'" hidden="true">
				<table class="pictures">
					<tr>
						<td width=80%>
							<img alt="'.$rowPic["pictext"].'" style="width:40%; border:3px solid #29497c;" src="images/ArticleImages/'.$rowPic["picfilename"].'">
						</td>
							
						<td width=20%>
							<button type="button" class="pictures" value="Delete" name="picDel'.$rowPic["picindex"].'" style="width:90%" onclick="picDel('.$rowPic["picindex"].')">
								Delete
							</button>
							<button type="button" class="pictures" value="Up" name="picUp'.$rowPic["picindex"].'" style="width:90%" onclick="picUp('.$rowPic["picindex"].')">
								<img src="images/arrow_up.png" />
							</button>
							<br />
							<button type="button" class="pictures" value="Down" name="picDown'.$rowPic["picindex"].'" style="width:90%" onclick="picDown('.$rowPic["picindex"].')">
								<img src="images/arrow_down.png" />
							</button>
						</td>
					<tr>
					<tr>
						<td colspan=2>
							<label for="pictext'.$rowPic["picindex"].'">Picture text: *</label>
							<input type="text" id="pictext'.$rowPic["picindex"].'" name="pictext'.$rowPic["picindex"].'" placeholder="Enter text for picture" required style="width:90%" value="'.$rowPic["pictext"].'">
							<input type="file" id="picfile'.$rowPic["picindex"].'" name="picfile'.$rowPic["picindex"].'" class="editsubmit" style="width:60%" onchange="onChangeBrowse('.$rowPic["picindex"].')">
						</td>
				</table>
				
				<hr />';
			}
			
			print '</div>';
			
			# ------ kraj svih slika
			
			print '
			<input type="button" value="Add new picture" name="addpicture" onclick="addNewPicture()" style="width:50%">
		</form>
	</div>
';



?>