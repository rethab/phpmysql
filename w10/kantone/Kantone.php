<?php

abstract class Kanton extends Observable {

    private $logger;

    public function __construct() {
        $this->addObserver(new Inspector());    
    }

    public function registerLogger(Logger $logger) {
        $this->logger = $logger;    
    }

    public function query($fieldName, $fieldValue, $one, $sortBy, $order = 'ASC') {
        $this->notifyObservers("query($fieldName, $fieldValue, $one, $sortBy, $order)");

        $vals = $this->get_cantons();
        $this->logger->log('Found ' . count($vals) . ' Cantons');

        // filter if criteria is given
        if (!is_null($fieldName) && !is_null($fieldValue)) {
            $this->logger->log('Filter enabled');
            $vals = array_filter($vals,
                function ($elem) use ($fieldName, $fieldValue) {
                    return $elem[$fieldName] == $fieldValue;
                }
            );
        } else {
            $this->logger->log('Filter disabled');
        }

        if (!is_null($sortBy)) {
            $this->logger->log('Sorting enabled');
            $vals = Util::sort($vals, $sortBy, $order);
        } else {
            $this->logger->log('Sorting disabled');
        }

        $this->logger->log('Fetch mode ' . ($one ? 'single' : 'list'));
        if ($one) return empty($vals) ? null : $vals[0];
        else      return $vals;
    }

    /**
     * Template Method Pattern: Concrete Classes may provided their own
     * set of values
     */
    public abstract function get_cantons();

}

class SchweizerKanton extends Kanton {

    public function get_cantons() {
        return array(
            array (
                "Kuerzel" => "ZH",
                "Kanton" => "Zuerich",
                "Standesstimme" => "1",
                "Beitritt" => 1351,
                "Hauptort" => "Zuerich",
                "Einwohner" => "1'392'396",
                "Auslaender" => "24,9 %",
                "Flaeche" => "1'729",
                "Dichte" => "805",
                "Gemeinden" => 171,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "BE",
                "Kanton" => "Bern",
                "Standesstimme" => "1",
                "Beitritt" => 1353,
                "Hauptort" => "Bern",
                "Einwohner" => "985'046",
                "Auslaender" => "13,7 %",
                "Flaeche" => "5'959",
                "Dichte" => "165",
                "Gemeinden" => 382,
                "Amtssprache" => "deutsch, franzoesisch",
            ),
            array (
                "Kuerzel" => "LU",
                "Kanton" => "Luzern ",
                "Standesstimme" => "1",
                "Beitritt" => 1332,
                "Hauptort" => "Luzern",
                "Einwohner" => "381'966",
                "Auslaender" => "16,8 %",
                "Flaeche" => "1'493",
                "Dichte" => "256",
                "Gemeinden" => 87,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "UR",
                "Kanton" => "Uri ",
                "Standesstimme" => "1",
                "Beitritt" => 12917,
                "Hauptort" => "Altdorf",
                "Einwohner" => "35'382",
                "Auslaender" => "10,6 %",
                "Flaeche" => "1'077",
                "Dichte" => "33",
                "Gemeinden" => 20,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "SZ",
                "Kanton" => "Schwyz ",
                "Standesstimme" => "1",
                "Beitritt" => 12917,
                "Hauptort" => "Schwyz",
                "Einwohner" => "147'904",
                "Auslaender" => "19,3 %",
                "Flaeche" => "908",
                "Dichte" => "163",
                "Gemeinden" => 30,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "OW",
                "Kanton" => "Obwalden",
                "Standesstimme" => "0,5",
                "Beitritt" => 12917,
                "Hauptort" => "Sarnen",
                "Einwohner" => "35'878",
                "Auslaender" => "13,8 %",
                "Flaeche" => "491",
                "Dichte" => "73",
                "Gemeinden" => 7,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "NW",
                "Kanton" => "Nidwalden ",
                "Standesstimme" => "0,5",
                "Beitritt" => 12917,
                "Hauptort" => "Stans",
                "Einwohner" => "41'311",
                "Auslaender" => "12,4 %",
                "Flaeche" => "276",
                "Dichte" => "150",
                "Gemeinden" => 11,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "GL",
                "Kanton" => "Glarus ",
                "Standesstimme" => "1",
                "Beitritt" => 1352,
                "Hauptort" => "Glarus",
                "Einwohner" => "39'217",
                "Auslaender" => "21,6 %",
                "Flaeche" => "685",
                "Dichte" => "57",
                "Gemeinden" => 3,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "ZG",
                "Kanton" => "Zug ",
                "Standesstimme" => "1",
                "Beitritt" => 1352,
                "Hauptort" => "Zug",
                "Einwohner" => "115'104",
                "Auslaender" => "25,5 %",
                "Flaeche" => "239",
                "Dichte" => "482",
                "Gemeinden" => 11,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "FR",
                "Kanton" => "Freiburg ",
                "Standesstimme" => "1",
                "Beitritt" => 1481,
                "Hauptort" => "Freiburg",
                "Einwohner" => "284'668",
                "Auslaender" => "20,5 %",
                "Flaeche" => "1'671",
                "Dichte" => "170",
                "Gemeinden" => 165,
                "Amtssprache" => "franzoesisch, deutsch",
            ),
            array (
                "Kuerzel" => "SO",
                "Kanton" => "Solothurn ",
                "Standesstimme" => "1",
                "Beitritt" => 1481,
                "Hauptort" => "Solothurn",
                "Einwohner" => "257'393",
                "Auslaender" => "20,0 %",
                "Flaeche" => "791",
                "Dichte" => "325",
                "Gemeinden" => 120,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "BS",
                "Kanton" => "Basel-Stadt ",
                "Standesstimme" => "0,5",
                "Beitritt" => 1501,
                "Hauptort" => "Basel",
                "Einwohner" => "194'661",
                "Auslaender" => "34,1 %",
                "Flaeche" => "37",
                "Dichte" => "5'034",
                "Gemeinden" => 3,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "BL",
                "Kanton" => "Basel-Landschaft",
                "Standesstimme" => "0,5",
                "Beitritt" => 1501,
                "Hauptort" => "Liestal",
                "Einwohner" => "277'614",
                "Auslaender" => "19,9 %",
                "Flaeche" => "518",
                "Dichte" => "532",
                "Gemeinden" => 86,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "SH",
                "Kanton" => "Schaffhausen ",
                "Standesstimme" => "1",
                "Beitritt" => 1501,
                "Hauptort" => "Schaffhausen",
                "Einwohner" => "77'139",
                "Auslaender" => "24,2 %",
                "Flaeche" => "298",
                "Dichte" => "259",
                "Gemeinden" => 27,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "AR",
                "Kanton" => "Appenzell Ausserrhoden",
                "Standesstimme" => "0,5",
                "Beitritt" => 1513,
                "Hauptort" => "Herisau, Trogen5",
                "Einwohner" => "53'313",
                "Auslaender" => "14,5 %",
                "Flaeche" => "243",
                "Dichte" => "219",
                "Gemeinden" => 20,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "AI",
                "Kanton" => "Appenzell Innerrhoden",
                "Standesstimme" => "0,5",
                "Beitritt" => 1513,
                "Hauptort" => "Appenzell",
                "Einwohner" => "15'789",
                "Auslaender" => "9,9 %",
                "Flaeche" => "173",
                "Dichte" => "91",
                "Gemeinden" => 6,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "SG",
                "Kanton" => "St. Gallen",
                "Standesstimme" => "1",
                "Beitritt" => 1803,
                "Hauptort" => "St. Gallen",
                "Einwohner" => "483'156",
                "Auslaender" => "22,6 %",
                "Flaeche" => "2'026",
                "Dichte" => "239",
                "Gemeinden" => 85,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "GR",
                "Kanton" => "Graubuenden",
                "Standesstimme" => "1",
                "Beitritt" => 1803,
                "Hauptort" => "Chur",
                "Einwohner" => "193'388",
                "Auslaender" => "17,1 %",
                "Flaeche" => "7'105",
                "Dichte" => "27",
                "Gemeinden" => 176,
                "Amtssprache" => "deutsch, raetoromanisch, italienisch",
            ),
            array (
                "Kuerzel" => "AG",
                "Kanton" => "Aargau",
                "Standesstimme" => "1",
                "Beitritt" => 1803,
                "Hauptort" => "Aarau",
                "Einwohner" => "627'893",
                "Auslaender" => "22,9 %",
                "Flaeche" => "1'404",
                "Dichte" => "440",
                "Gemeinden" => 219,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "TG",
                "Kanton" => "Thurgau",
                "Standesstimme" => "1",
                "Beitritt" => 1803,
                "Hauptort" => "Frauenfeld",
                "Einwohner" => "251'973",
                "Auslaender" => "23,0 %",
                "Flaeche" => "991",
                "Dichte" => "254",
                "Gemeinden" => 80,
                "Amtssprache" => "deutsch",
            ),
            array (
                "Kuerzel" => "TI",
                "Kanton" => "Tessin",
                "Standesstimme" => "1",
                "Beitritt" => 1803,
                "Hauptort" => "Bellinzona",
                "Einwohner" => "336'943",
                "Auslaender" => "27,3 %",
                "Flaeche" => "2'812",
                "Dichte" => "120",
                "Gemeinden" => 147,
                "Amtssprache" => "italienisch",
            ),
            array (
                "Kuerzel" => "VD",
                "Kanton" => "Waadt",
                "Standesstimme" => "1",
                "Beitritt" => 1803,
                "Hauptort" => "Lausanne",
                "Einwohner" => "729'971",
                "Auslaender" => "32,2 %",
                "Flaeche" => "3'212",
                "Dichte" => "226",
                "Gemeinden" => 326,
                "Amtssprache" => "franzoesisch",
            ),
            array (
                "Kuerzel" => "VS",
                "Kanton" => "Wallis",
                "Standesstimme" => "1",
                "Beitritt" => 1815,
                "Hauptort" => "Sitten",
                "Einwohner" => "317'022",
                "Auslaender" => "22,0 %",
                "Flaeche" => "5'224",
                "Dichte" => "61",
                "Gemeinden" => 141,
                "Amtssprache" => "franzoesisch, deutsch",
            ),
            array (
                "Kuerzel" => "NE",
                "Kanton" => "Neuenburg ",
                "Standesstimme" => "1",
                "Beitritt" => 1815,
                "Hauptort" => "Neuenburg",
                "Einwohner" => "173'183",
                "Auslaender" => "24,4 %",
                "Flaeche" => "803",
                "Dichte" => "216",
                "Gemeinden" => 53,
                "Amtssprache" => "franzoesisch",
            ),
            array (
                "Kuerzel" => "GE",
                "Kanton" => "Genf",
                "Standesstimme" => "1",
                "Beitritt" => 1815,
                "Hauptort" => "Genf",
                "Einwohner" => "473'941",
                "Auslaender" => "37,0 %",
                "Flaeche" => "282",
                "Dichte" => "1'633",
                "Gemeinden" => 45,
                "Amtssprache" => "franzoesisch",
            ),
            array (
                "Kuerzel" => "JU",
                "Kanton" => "Jura ",
                "Standesstimme" => "1",
                "Beitritt" => 1979,
                "Hauptort" => "Delsberg",
                "Einwohner" => "70'542",
                "Auslaender" => "13,0 %",
                "Flaeche" => "838",
                "Dichte" => "84",
                "Gemeinden" => 64,
                "Amtssprache" => "franzoesisch",
            ),
        );
    }
}
