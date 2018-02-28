<?php
global $db;
	ini_set('display_errors', '1');
	error_reporting(E_ALL);

	if($lang == 'ru') {
		$sqlFeatures = '	
		SELECT `block_id`, `image_class`, `block_title_ru` AS `title`, `block_text_ru` AS `text`
		FROM `features`
		ORDER BY `block_id` ASC	
	';
	}

	$sqlFeatures = '	
		SELECT `block_id`, `image_class`, `block_title_en` AS `title`, `block_text_en` AS `text`
		FROM `features`
		ORDER BY `block_id` ASC	
	';

	$resultFeatures = mysqli_query($db, $sqlFeatures);

	$rowFeatures = [];

	$itemsFeatures = [];

 	$count = 1;

 echo '<div class="features-row">' ;

 while($rowFeatures = mysqli_fetch_assoc($resultFeatures)):  //star cicle for array
  echo '
  			<section>
				<span class="icon ' . $rowFeatures['image_class'] . '"></span>
				<h3>' . $rowFeatures['title'] . '</h3>
				<p>' .  $rowFeatures['text'] . '</p>
			</section>
		';

if($count % 2 == 0 AND $count != count($rowFeatures)) { 
echo '
	</div>
	<div class="features-row"> 
';
    } 
    $count++; //increment counter
   endwhile;
echo '</div>';
