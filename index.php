<?php
	require "lib_imdb.php";

	$film = new imdb_getter('http://www.imdb.com/title/tt1981115/');
	$film->exec();

	echo $film->get_title();