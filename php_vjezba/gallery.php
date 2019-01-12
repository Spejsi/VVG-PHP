<?php 

if (!isset($_SESSION['anamUser']['user'])){
	header("Location: index.php?menu=6");
} else {
	print '
	<h1>Gallery</h1>
	<div id="gallery">
		<figure id="1">
			<a href="images/gallery/CretuPlaying.jpg" target="_blank">
			<img src="images/gallery/CretuPlaying.jpg" alt="Michael Cretu (Enigma)" title="Michael Cretu (Enigma)"/></a>
			<figcaption>Michael Cretu (Enigma) create his music in A.R.T. Studios on Ibiza</figcaption>
		</figure>
		<figure id="2">
			<a href="images/gallery/JarreConcert.jpg" target="_blank">
			<img src="images/gallery/JarreConcert.jpg" alt="Jean Michel Jarre\'s laser show" title="Jean Michel Jarre\'s laser show"/></a>
			<figcaption>Amazing laser show in Jean Michel Jarre Concert.</figcaption>
		</figure>
		<figure id="3">
			<a href="images/gallery/MikeOldfield2012.jpg" target="_blank">
			<img src="images/gallery/MikeOldfield2012.jpg" alt="Mike Oldfield 2012" title="Mike Oldfield 2012"/></a>
			<figcaption>Mike Oldfield playing guitar at Olympic Ceremony, 2012.</figcaption>
		</figure>
		<figure id="4">
			<a href="images/gallery/MikeOldfield2006.jpg" target="_blank">
			<img src="images/gallery/MikeOldfield2006.jpg" alt="Mike Oldfield 2006" title="Mike Oldfield 2006"/></a>
			<figcaption>Mike Oldfield at the Night of the Proms in 2006.</figcaption>
		</figure>
		<figure id="5">
			<a href="images/gallery/BillLeeb.jpg" target="_blank">
			<img src="images/gallery/BillLeeb.jpg" alt="Bill Leeb 2016" title="Bill Leeb 2016"/></a>
			<figcaption>Delerium founder Bill Leeb in 2016.</figcaption>
		</figure>
		<figure id="6">
			<a href="images/gallery/DeleriumYesStay.jpg" target="_blank">
			<img src="images/gallery/DeleriumYesStay.jpg" alt="Delerium - Stay feat. Yes" title="Delerium - Stay feat. Yes"/></a>
			<figcaption>Delerium performing song Stay featuring Yes</figcaption>
		</figure>
		<figure id="7">
			<a href="images/gallery/JarreRendezvousHouston.jpg" target="_blank">
			<img src="images/gallery/JarreRendezvousHouston.jpg" alt="Jean Michel Jarre\'s concert in Huston" title="Jean Michel Jarre\'s concert in Huston"/></a>
			<figcaption>Jean Michel Jarre\'s Rendez-Vous concert in Huston.</figcaption>
		</figure>
		<figure id="8">
			<a href="images/gallery/SandraCretu.jpg" target="_blank">
			<img src="images/gallery/SandraCretu.jpg" alt="Sandra and Michael Cretu" title="Sandra and Michael Cretu"/></a>
			<figcaption>Sandra and Michael Cretu from Enigma</figcaption>
		</figure>
		<figure id="9">
			<a href="images/gallery/OldfieldStudio.jpg" target="_blank">
			<img src="images/gallery/OldfieldStudio.jpg" alt="Mike Oldfield\'s studio" title="Mike Oldfield\'s studio"/></a>
			<figcaption>Mike Oldfield in his studio</figcaption>
		</figure>
		<figure id="10">
			<a href="images/gallery/JarreStudio.jpg" target="_blank">
			<img src="images/gallery/JarreStudio.jpg" alt="Jean-Michel Jarre\'s studio" title="Jean-Michel Jarre\'s studio"/></a>
			<figcaption>Jean-Michel Jarre in his studio</figcaption>
		</figure>
	</div>
	<hr>
';
}


?>