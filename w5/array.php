<?php

$multiCity = array(
    array('Tokyo', 'Japan', 'Asia'),
    array('Mexico City','Mexico', 'North America'),
    array('New York City', 'USA', 'North America'),
    array('Mumbai', 'India', 'Asia'),
    array('Seoul', 'Korea', 'Asia'),
    array('Shanghai', 'China', 'Asia'),
    array('Lagos', 'Nigeria', 'Africa'),
    array('Buenos Aires', 'Argentina', 'South America'),
    array('Cairo', 'Egypt', 'Africa'),
    array('London', 'UK','Europe')
);

function print_cities($cities) {
        echo "<table><thead>";
        $titles = array('City', 'Country', 'Continent');
        echo "<tr>";
        foreach ($titles as $title) {
                echo '<th>' . $title . '</th>';
        }
        echo "</tr>";
        echo "</thead><tbody>";
        foreach ($cities as $city) {
                echo "<tr>";
                echo "<td>$city[0]</td><td>$city[1]</td><td>$city[2]</td>";
                echo "</tr>";
        }
        echo "</tbody></table>";
}

?>
<html>
<head>
<title>Multi-dimensional Array</title>
<style type="text/css">
td, th {width: 8em; border: 1px solid black; padding-left: 4px;}
th {text-align:center;}
table {border-collapse: collapse; border: 1px solid black;}
</style>
</head>
 <body>

<h2>Auflistung Array</h2>
<?php print_cities($multiCity); ?>
 
<h2>Auflistung der St&auml;dte in Asien</h2>
<?php print_cities(array_filter($multiCity, function ($row) { return $row[2] == 'Asia'; })); ?>
 
<h2>Auflistung der Kontinente, sowie die Zahl der L&auml;nder darin (im Array)<br /></h2>
<?php
$continents = array();
foreach ($multiCity as $row) {
        if (!array_key_exists($row[2], $continents)) {
                $continents[$row[2]] = 1;
        } else {
                $continents[$row[2]]++;
        }
}

echo "<table><thead><tr><th>Kontinent</th><th>Anzahl Laender</th></tr></thead></tbody>";
foreach ($continents as $continent => $count) {
        echo "<tr><td>$continent</td><td>$count</td></tr>";
}
echo "</tbody></table>";
?>
 
<h2>Auflistung nach L&auml;nder A-Z <br /></h2>
<?php
        $countries = array_map(function ($row) {return $row[1]; }, $multiCity);
        $countries = array_unique($countries);
        sort($countries);

        echo "<table><thead><tr><th>Land</th></tr></thead></tbody>";
        foreach ($countries as $country) {
                echo "<tr><td>$country</td></tr>";
        }
        echo "</tbody></table>";
?>
 
</body>
</html>
