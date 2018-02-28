<?php

function render_header($user_params = [])
{
	$params = [
		'title' => PROJECT_TITLE,
		'is_home' => false,
		'menu_active_item' => 'home'
	];
	$params = array_merge($params, $user_params);

	include PATH_PARTIALS . 'header.php';
}

function render_footer()
{
	include PATH_PARTIALS . 'footer.php';
}

function render_menu()
{
	global $db;
	ini_set('display_errors', '1');
	error_reporting(E_ALL);

	$sql = '
		SELECT * 
		FROM `menu_items`
		ORDER BY `ord` ASC
	';	
	$result = mysqli_query($db, $sql);

	$items = [];
	while($row = mysqli_fetch_assoc($result))
	{
		$items[$row['id']] = $row;
	}

	$result = build_menu_items($items);
	// echo '<pre>';
	// var_dump($result);
	// echo '</pre>';
	// exit;
}

function build_menu_items($items, $parent_id = 0)
{
	$return = [];

	foreach($items as $id => $item)
	{
		if($item['parent_id'] == $parent_id)
		{
			$has_children = false;
			foreach($items as $child_item)
			{
				if($id == (int)$child_item['parent_id'])
				{
					$has_children = true;
					break;
				}
			}

			if($has_children)
				$item['children'] = build_menu_items($items, $id);

			$return[] = $item;
		}
	}

	return $return;
}

function build_features()
{


global $db;
	ini_set('display_errors', '1');
	error_reporting(E_ALL);


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



}

render_menu();