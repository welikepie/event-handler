<?php
error_reporting(E_ALL);
snippet('page_sort');
$events = $pages->find('events');
$events = $events->children()->visible();
page_sort($events, array('date_sort', 'priority_sort'));	
//var_dump($site->modified());
header("Content-Type: text/xml; charset=utf-8");
if(array_key_exists("type", $_GET)){
	generateFeed($_GET["type"],$events);
}
else{
//	var_dump($pages);
	generateFeed("all",$events);
}


function generateFeed($type,$inputEvents){
	echo('<?xml version="1.0" encoding="utf-8"?>');
	echo('<rss version="2.0">');
	echo('<channel>');
	generateHeader($type);
	foreach ($inputEvents as $event) {
	$event_date = $event->date();
	$current_date = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
	if ($current_date > $event_date) { continue; }	
	//var_dump($event);
	generateContent($event);
	}

	echo('</channel>');
	echo('</rss>');
}

function generateHeader($type){
	 	echo("<title>Event Handler RSS feed for category: '".$type."'</title>");
        echo("<link>http://www.eventhandler.co.uk/</link>");
        echo("<description>This is an eventhandler driven event feed.</description>");
        echo("<language>en-gb</language>");
//		var_dump($site->modified());
	  	echo("<lastBuildDate>".date("D, d M Y H:i:s O",mktime(0, 0, 0, date('n'), date('j'), date('Y')))." CET</lastBuildDate>");
}

function generateContent($input){
	echo("<item>");
	echo("<title>".kirbytext($input->title())."</title>");
	echo("<pubDate>".date("D, d M Y H:i:s O",$input->date())."</pubDate>");
	echo("<url>".$input->url()."</url>");
	echo("<guid>".$input->url()."</guid>");
	echo("<description>".kirbytext($input->text())."</description>");
	
	echo("</item>");
}
?>