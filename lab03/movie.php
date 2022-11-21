<!--
	Author:         Michele Lorenzo
	Course:         B
	Description:   We want to create a dynamic page for Rancid Tomatoes' reviews.
	Content:        PHP & HTML code
--> 

<?php
        /**
		 * Funzione che ritorna il file che contiene le informazioni el film diviso per righe.
		 * @param string $movie nome film richiesto dall'utente.
		 * @return array array contente le righe del file.
		 */
		function getInfo($movie) {
            return file("./$movie/info.txt");
        }
		
		/**
		 * Funzione che ritorna la overview del film richiesto divise per righe e per dt e dd.
		 * @param string $movie nome film richiesto dall'utente.
		 * @return array array bi-dimensionale che contiene le righe del file divise in
		 *  titolo della definizione e descrizione della definizione.
		 */
		function getOverviewContent($movie) {
			$file_row = file("./$movie/overview.txt");
			$row_split_array = array();

			for ($i = 0; $i < count($file_row); $i++) {
				$row_split_array[] = explode(":", $file_row[$i]);
			}
			
			return $row_split_array;
		}

		/**
		 * Funzione che ritorna il numero di recensione del film.
		 * @param string $movie nome del film richiesto dall'utente.
		 * @return int numero di recensioni.
		 */
		function nReviews($movie) {
			 return sizeof(glob("./$movie/review*.txt"));
		}

		/** 
		 * Funzione che ritorna il file diviso per righe dell'overview richiesta.
		 * @param int $nReview numero di recensioni del fim.
		 * @param string $movie nome del film richiesto dall'utente.
		 * @return array array contenente le righe del file.
		 */
		function getReview($movie, $nReview) {
			$index = "";

			if (nReviews($movie) < 10) 
				$index = $nReview;
			elseif ($nReview < 10) 
				$index = "0" . $nReview;
			else
				$index = $nReview;

			return  file("./$movie/review$index.txt");
		}
?>

<!DOCTYPE html>

<html lang="en">
    <?php $movie = $_GET['film'] ?>

	<head>
		<title><?= $movie ?> - Rancid Tomatoes</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="movie.css" type="text/css" rel="stylesheet">
		<link rel="icon" href="http://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/rotten.gif">
	</head>

	<body>
		<div id="top-banner">
			<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/banner.png"
			 alt="Rancid Tomatoes">
		</div>

		<div id="title">
			<h1><?= trim(getInfo($movie)[0]) . " (" . trim(getInfo($movie)[1]) . ")" ?></h1>
		</div>

		<div id="content">
			<div id="overview">
				<div id="overview-img">
					<img src="<?= "./$movie/overview.png" ?>" alt="general overview">
				</div>

				<div id="overview-content">
					<dl>
						<?php
						for ($i = 0; $i < count(getOverviewContent($movie)); $i++) {
						?>	
						<dt><?= trim(getOverviewContent($movie)[$i][0]); ?></dt>
						<dd><?= trim(getOverviewContent($movie)[$i][1]); ?></dd>
						<?php
						} 
						?> 
					</dl>
				</div>
			</div>
			
			<div id="reviews">
				<?php $nReview = nReviews($movie); ?>

				<div id="reviews-header">
					<div id="reviews-header-img"> 
						<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/<?= (getInfo($movie)[2] >= 60) ? "freshbig.png" : "rottenbig.png"; ?>"
						 alt="Rotten">
					</div>

					<span id="reviews-header-percentuale"><?= trim(getInfo($movie)[2]) . "%" ?></span>
				</div>

				<div id="reviews-content">
					<div id="reviews-content-left">
							<?php 
							$leftReview = ($nReview % 2 == 0) ? (int) ($nReview / 2) : (int) ($nReview / 2) + 1;
							for ($i=0; $i < $leftReview; $i++) { 
								$review = getReview($movie, $i + 1);
							?>

							<p>
								<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/<?= trim(strtolower($review[1])) ?>.gif"
								 alt="<?= $review[1] ?>">
								<q><?= $review[0] ?></q>
							</p>
						
							<p>
								<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif"
								 alt="Critic">
								<?= $review[2] ?><br>
								<span><?= $review[3] ?></span>
							</p>

							<?php
							}
							?>
					</div>

					<div id="reviews-content-right">
						<?php 
						for ($i=$leftReview; $i < $nReview; $i++) { 
							$review = getReview($movie, $i + 1);
						?>

						<p>
							<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/<?= trim(strtolower($review[1])) ?>.gif"
								alt="<?= $review[1] ?>">
							<q><?php echo $review[0] ?></q>
						</p>
					
						<p>
							<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif"
								alt="Critic">
							<?= $review[2] ?><br>
							<span><?= $review[3] ?></span>
						</p>

						<?php
						}
						?>
					</div>
				</div>
			</div>
			
			<div id="content-footer">
				<p>
					<?= "(1-$nReview) of $nReview" ?>
				</p>
			</div>
		</div>
		
		<div id="validators-icon">
			<p>
				<a href="http://validator.w3.org/check/referer">
					<img width="88" src="https://upload.wikimedia.org/wikipedia/commons/b/bb/W3C_HTML5_certified.png" alt="Valid HTML5!">
				</a>
			<p> <br>
				<a href="http://jigsaw.w3.org/css-validator/check/referer">
					<img src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!">
				</a>
		</div>
	</body>
</html>
