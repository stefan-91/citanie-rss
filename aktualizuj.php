<?php
error_reporting(E_ALL);
ini_set("display_errors","On");

require_once 'Nacitanie_rss.php';
$nr = new Nacitanie_rss();
$nr->nacitaj();
echo 'Aktualizovalo obecne dokumenty <br>';
