<?php
if( empty( $_GET['child']) ) {
	// load list of article types
	$rows = $mngrDB->mysqlGet("SELECT * FROM article_types ORDER BY priority");
	
	$context = array();
	$context['rows'] = $rows;
	
	$h2o = new H2O(dirname(__FILE__)."/list_types.html");
	$main_context['content'] =  $h2o->render($context);
	return;
}

if( empty($_GET['param1']) ) {
	$articles_theme = mysql_real_escape_string($_GET['child']);
	
	//выбираем название темы статей и ее краткое описание
	$article_type = $mngrDB->mysqlGetOne("SELECT * FROM article_types WHERE title = '{$articles_theme}'");
	
	// list of articles under selected theme
	$rows = $mngrDB->mysqlGet("SELECT * FROM articles WHERE article_type = (SELECT id FROM article_types WHERE title = '{$articles_theme}') ORDER BY updated_on DESC");
	if( count($rows)) {
		$context = array();
		$context['article_type'] = $article_type;
		$context['rows'] = $rows;
		$h2o = new H2O(dirname(__FILE__)."/list_articles.html");
		$main_context['content'] =  $h2o->render($context);
		$main_context['page_name'] = "Список статей";
	}
	else {
		error404();
	}
	return;
}

// load article content
$article_name = mysql_real_escape_string($_GET['param1']);
$row = $mngrDB->mysqlGetOne("SELECT * FROM articles WHERE title = '{$article_name}'");
if( !empty($row)) {
	$context = array();
	$context['row'] = $row;
	$h2o = new H2O(dirname(__FILE__)."/article.html");
	$main_context['content'] =  $h2o->render($context);
	$main_context['page_name'] = $row['title'];
}
else {
	error404();
}
