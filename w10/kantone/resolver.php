<?php

require_once('settings.php');
require_once('Util.php');
require_once('Logger.php');
require_once('Iterator.php');
require_once('Inspector.php');

$fields = array('Kuerzel', 'Kanton', 'Standesstimme', 'Beitritt',
                'Hauptort', 'Einwohner', 'Auslaender', 'Flaeche',
                'Dichte', 'Gemeinden', 'Amtssprache');

$services = array('kantone' => 'SchweizerKanton');
$methods  = array('list' => false, 'one' => true);
// some public names are mapped to internal names
$sorts    = array_merge(array('name' => 'Kanton'), array_combine($fields, $fields));
// some public names are mapped to internal names
$queries  = array_merge(array('id' => 'Kuerzel'), array_combine($fields, $fields));

$service = isset($_GET['service']) ? $_GET['service'] : null;
$method  = isset($_GET['method'])  ? $_GET['method']  : null;
$sort    = isset($_GET['sort'])    ? $_GET['sort']    : null;

if (is_null($service) || is_null($method)) {
    header('HTTP/ 400 service, method and are required');
    exit;
} else if (!isset($services[$service]) || !isset($methods[$method]) || (!is_null($sort) && !isset($sorts[$sort]))) {
    header('HTTP/ 400 invalid service, method or sort');
    exit;
}

// whether multiple should be returned
$one = $methods[$method];

$fieldName = null;
$fieldValue = null;

$queryFieldIterator = new MyArrayIterator(array_keys($queries));
while ($queryFieldIterator->hasNext()) {
    $field = $queryFieldIterator->next();
    if (isset($_GET[$field])) {
        $fieldName = $queries[$field];
        $fieldValue = $_GET[$field];
        break;
    }
}

$sortBy = is_null($sort) ? null : $sorts[$sort];

require_once(ucfirst($service).'.php');
$service = new $services[$service];
$service->registerLogger(new EchoLogger());

$result = $service->query($fieldName, $fieldValue, $one, $sortBy);

echo json_encode($result);
