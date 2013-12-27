<?php
$context = array();
//Загрузка слайдов из БД
$rows = $mngrDB->mysqlGet("SELECT * FROM slides ORDER BY priority");
$context['regions'] = $rows;

if(empty($main_context['page_footer'])) {
	$main_context['page_footer'] = array();
}
$main_context['page_footer'][] = '<script src="/templates/js/jquery.bootstrap.wizard.min.js"></script>'; 
$main_context['page_footer'][] = '<script>$(document).ready(function() { $("#rootwizard").bootstrapWizard();});</script>';
//5 шагов 
$tmpl1 = new H2O(dirname(__FILE__)."/five-steps.html");
$context['steps'] = $tmpl1->render();

$reviews = $mngrDB->mysqlGet("SELECT * FROM reviews WHERE show_on_main_page=1 ORDER BY priority");
$context['reviews'] = $reviews;

$tmpl2 = new H2O(dirname(__FILE__)."/why-not.html");
$context['why-not'] = $tmpl2->render();

$context['nearest-routes'] = 'Ближайшие походы';

$h2o = new H2O(dirname(__FILE__)."/main-page.html");
$main_context['content'] =  $h2o->render($context);
$main_context['page_name'] = "Главная";