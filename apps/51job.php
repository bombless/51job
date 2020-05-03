#!/usr/bin/php
<?php
namespace apps;

use modelSpace\Record;
use models\Html as modelHtml;
use models\TclTk as modelTk;

include('./simple_html_dom.php');
include('./init.php');

$header = file_get_contents('cookie.txt');
$header = trim($header);
$header = str_replace("\n", "\r\n", $header);

$context_opts = ['http' => ['header' => $header]];
$context = stream_context_create($context_opts);


$html_output = new modelHtml();
$tk_output = new modelTk();

$json_object = [];

for ($page = 1;; $page += 1) {

    $url = url_page($page);
    $html = file_get_html($url, false, $context);

    echo 'fetched ', $url, "\n";
    $items_count = 0;
    foreach($html->find('#resultList div.el') as $t) {
        $find_title = $t->find('.t1 a');
        if (!$find_title) continue;
        $items_count += 1;
        $title = $find_title[0]->title;
        $company = $t->find('.t2 a')[0]->title;
        [$title, $company];
        $address = $t->find('.t3')[0]->plaintext;

        if ($address == '异地招聘') continue;

        $record = new Record();
        foreach (['title', 'company', 'address'] as $item) {
            $methodName = 'set' . ucfirst($item);
            $record->{ $methodName }($$item);
        }
        $html_output->addRecord($record);
        $tk_output->addRecord($record);
        $json_object[] = $record;

        //echo $title, "\t", $company, "\t", $address, "\n";
    }
    if (!$items_count) break;
    //sleep(2);
}




file_put_contents('../51job.json/' . time() . '.json', json_encode($json_object));


file_put_contents(
    '../51job.html',
    $html_output->export()
);
`open ../51job.html`;

file_put_contents(
    '../51job.sh',
    $tk_output->export()
);
`TK_SILENCE_DEPRECATION=1 wish ../51job.sh`;

function url_page($n) {
    return 'https://search.51job.com/list/030200,000000,0000,00,9,99,php,2,' . $n . '.html';
}