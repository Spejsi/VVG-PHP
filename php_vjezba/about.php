<?php 
if (!isset($_SESSION['anamUser']['user'])){
	header("Location: index.php?menu=6");
}

print '
	<h1>About new age music page</h1>
	
	<video controls poster="video/DeleriumAngelicus.jpg" >
		<source src="video/DeleriumAngelicus.mp4" type="video/mp4"/>
		Your browser does not support HTML5 video.
	</video>
	
	<h2>About music</h2>
	
	<p>NEW AGE music - spiritual, enigmatic, vocal, acoustic, ambient, chillout, electronic, ethereal, etno and instrumental songs.</p>

	<p>New Age music is music of various styles intended to create artistic inspiration, relaxation, and optimism. It is used by listeners for yoga, massage, meditation and reading as a method of stress management or to create a peaceful atmosphere in their home or other environments, and is often associated with environmentalism and New Age spirituality.</p>

	<p>The harmonies in New Age music are generally modal, consonant, or include a drone bass. The melodies are often repetitive, to create a hypnotic feeling, and sometimes recordings of nature sounds are used as an introduction to a track or throughout the piece. Pieces of up to thirty minutes are common.</p>

	<p>New Age music includes both electronic forms, frequently relying on sustained synth pads or long sequencer-based runs, and acoustic forms, featuring instruments such as flutes, piano, acoustic guitar and a wide variety of non-western acoustic instruments. In many cases, high-quality digitally sampled instruments are used instead of natural acoustic instruments. Vocal arrangements were initially rare in New Age music but as it has evolved vocals have become more common, especially vocals featuring Native American, Sanskrit, or Tibetan influenced chants, or lyrics based on mythology such as Celtic legends or the realm of Faerie.</p>

	<p>Some New Age music artists openly embrace New Age beliefs, while other artists and bands have specifically stated that they do not consider their own music to be New Age, even when their work has been labeled as such by record labels, music retailers, or radio broadcasters.</p>
	
	<hr/>
	
	<h2>New age artists</h2>
	<p>7and5, Achillea, Amethystium, Balligomingo, Beautiful World, Blue Stone, Conjure One, Dagda, Deep Forest, Delerium, Enigma, Enya, Era, F.R.E.U.D., Jean Michel Jarre, Lesiëm, Mike Oldfield, Ryan Farish, Sarah Brightman, Sleepthief, Ulrich Schnauss, ...</p>
';
?>