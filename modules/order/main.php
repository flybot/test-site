<?php
$context = array ();

$context['route_id'] = (!empty($_REQUEST['route']))? $_REQUEST['route'] : -1;
$context['selected_date'] = (isset($_REQUEST['date_start']))? $_REQUEST['date_start'] : -1;
if(isset($_REQUEST['name1']) && trim($_REQUEST['name1']) != "") $context['name'] = trim($_REQUEST['name1']);
if(isset($_REQUEST['phone']) && trim($_REQUEST['phone']) != "") $context['phone'] = trim($_REQUEST['phone']);
if(isset($_REQUEST['mail']) && trim($_REQUEST['mail']) != "") $context['email'] = trim($_REQUEST['mail']);
if(isset($_REQUEST['count']) && trim($_REQUEST['count']) != "") $context['person_count'] = trim($_REQUEST['count']);
if(isset($_REQUEST['from']) && trim($_REQUEST['from']) != "") $context['from_place'] = trim($_REQUEST['from']);
if(isset($_REQUEST['comment']) && trim($_REQUEST['comment']) != "") $context['comment'] = trim($_REQUEST['comment']);
if(count($context) > 4 && isset($context['email'])) { 
	//send mail
	$mail_template = new H2O($main_context['base_path']."/templates/mail-order.html");
	$mail_body = $mail_template->render($context);
	require_once 'common/swift/swift_required.php';
	$transport = Swift_MailTransport::newInstance();
	$mailer = Swift_Mailer::newInstance($transport);
	$message = Swift_Message::newInstance()
		->setSubject("Заказ похода")
		->setFrom(array($admin_email => $admin_email))
		->setTo(array($admin_email, $context['email']))
		->setBody($mail_body)
		->addPart($mail_body, 'text/html')	
		->attach(Swift_Attachment::fromPath($main_context['base_path'].'/files/анкета участника укр.xls'));
	$result = $mailer->send($message);
	
	//show 'thank you' page
	$mngrDB->mysqlInsertArray('requests', $context);
	$h2o = new H2O ( dirname ( __FILE__ ) . "/complete.html" );
	$main_context ['content'] = $h2o->render ( $context );
	return;
}


$regions =  $mngrDB->mysqlGet("SELECT id, name FROM regions ORDER BY name asc");
$context['regions'] = $regions;
$routes =  $mngrDB->mysqlGet("SELECT id, region_id, name FROM routes ORDER BY region_id asc, name asc");
$context['routes'] = $routes;


$context_period = array();
$id = (!empty($_REQUEST['route']))? $_REQUEST['route'] : $routes[0]['id'];
$periods = $mngrDB->mysqlGet("SELECT id, date_start, date_finish FROM hikes WHERE route_id = ".$id." ORDER BY date_start");
foreach($periods as $period) {
	$ds = new DateTime($period['date_start']);
	$df = new DateTime($period['date_finish']);
	$context_period[] = array('hike_id' => $period['id'], 'hike_date' => $ds->format('d.m') . ' - ' . $df->format('d.m'));
}
$context_period[] = array('hike_id' => 0, 'hike_date' => "Своя дата, укажу в комментариях");
$context['periods'] = $context_period;


$h2o = new H2O ( dirname ( __FILE__ ) . "/order.html" );
$main_context ['content'] = $h2o->render ( $context );

$main_context['page_footer'][] = '<script type="text/javascript" src="/templates/js/order.js"></script>';
$main_context['xpath'][] = array('name'=>'Заказ похода',  'link'=>'/order');