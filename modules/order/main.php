<?php
$context = array ();
//echo "<h1>".$_REQUEST['route']."</h1><br>";
//print_r($_REQUEST);

$context['selected_route'] = (!empty($_REQUEST['route']))? $_REQUEST['route'] : -1;

$regions =  $mngrDB->mysqlGet("SELECT id, name FROM regions ORDER BY name asc");
$context['regions'] = $regions;
$routes =  $mngrDB->mysqlGet("SELECT id, region_id, name FROM routes ORDER BY region_id asc, name asc");
$context['routes'] = $routes;

$h2o = new H2O ( dirname ( __FILE__ ) . "/order.html" );
$main_context ['content'] = $h2o->render ( $context );

$main_context['xpath'][] = array('name'=>'Заказ похода',  'link'=>'/order');