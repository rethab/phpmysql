<?php

$fields = array('Kuerzel', 'Kanton', 'Standesstimme', 'Beitritt',
                'Hauptort', 'Einwohner', 'Auslaender', 'Flaeche',
                'Dichte', 'Gemeinden', 'Amtssprache');

$services = array('kantone');
$methods  = array_map(function ($field) { return "findBy$field"; }, $fields);
$sorts    = array_map(function ($field) { return "sortBy$field"; }, $fields);
            

$serivce = isset($_GET['service']) ? $_GET['service'] : null;
$method  = isset($_GET['method'])  ? $_GET['method']  : null;
$sort    = isset($_GET['sort'])    ? $_GET['sort']    : null;

if (is_null($service) || is_null($method) || is_null($sort)) {
    header('HTTP/ 400 service, method and sort are required');
    exit;
} else if (!in_array($service, $services) || !in_array($method, $methods) ||  !in_array($sort, $sorts)) {
    header('HTTP/ 400 invalid service, method or sort');
    exit;
}

require_once(ucfirst($service).'.php');
$serice = new ucfirst($serice);

echo '-------------Kuerzel';
$kantons = $service->findOneByKuerzel('ZH');
print_r($kantons);

echo '-------------Standesstimme';
$kantons = $service->findByStandesstimme('1');
print_r($kantons);

echo '-------------Beitritt';
$kantons = $service->sortByBeitritt('ASC');
print_r(array_map(function ($elem) { return $elem['Beitritt']; }, $kantons));

echo '-------------Kanton';
$kantons = $service->sortByKanton('DESC');
print_r(array_map(function ($elem) { return $elem['Kanton']; }, $kantons));
