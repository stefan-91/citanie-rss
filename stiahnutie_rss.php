<?php
require_once '../aplikacie/citanie-rss/Nacitanie_rss.php';
$nr = new Nacitanie_rss();

// Lipovce
$poleUrl = array('http://www.lipovce.eu/?rss=200');
$nr->nacitaj($poleUrl, 'lipovce');

// Nizny Slavkov
    // https://www.niznyslavkov.sk/
$poleUrl = array('https://www.niznyslavkov.sk/?rss=200');
$nr->nacitaj($poleUrl, 'nizny-slavkov');

// Sindliar
    // https://www.sindliar.sk/rss.html
$poleUrl = array(
'https://www.sindliar.sk/get_rss.php?id=8_atom',
'https://www.sindliar.sk/get_rss.php?id=1_atom_8441',
'https://www.sindliar.sk/get_rss.php?id=1_atom_8455',
'https://www.sindliar.sk/get_rss.php?id=1_atom_8454',
'https://www.sindliar.sk/get_rss.php?id=1_atom_8446',
'https://www.sindliar.sk/get_rss.php?id=1_atom_10491',
'https://www.sindliar.sk/get_rss.php?id=1_atom_11821',
'https://www.sindliar.sk/get_rss.php?id=1_atom_11990',
'https://www.sindliar.sk/get_rss.php?id=1_atom_10492',
'https://www.sindliar.sk/get_rss.php?id=1_atom_13264',
'https://www.sindliar.sk/get_rss.php?id=1_atom_10493',
'https://www.sindliar.sk/get_rss.php?id=1_atom_9568',
'https://www.sindliar.sk/get_rss.php?id=4_atom',
'https://www.sindliar.sk/get_rss.php?id=5_atom',
'https://www.sindliar.sk/get_rss.php?id=7_atom',
'https://www.sindliar.sk/get_rss.php?id=12_atom'
);
$nr->nacitaj($poleUrl, 'sindliar');

// PSK
$poleUrl = array(
    'https://www.po-kraj.sk/sk/rss/spravy/',
    'https://www.po-kraj.sk/sk/rss/web/',
    'https://www.po-kraj.sk/sk/rss/kalendar/',
    'https://www.po-kraj.sk/sk/rss/podujatia/'//,
    //'https://www.po-kraj.sk/sk/samosprava/udaje/uradna-tabula/zmluvy-objednavky-faktury/ezmluvy/rss',
);
$nr->nacitaj($poleUrl, 'psk');

//  Mesto presov
$poleUrl = array(
    'https://www.presov.sk/get_rss.php?id=1_atom_5251',
    'https://www.presov.sk/get_rss.php?id=1_atom_5474',
    'https://www.presov.sk/get_rss.php?id=1_atom_5561',
    'https://www.presov.sk/get_rss.php?id=1_atom_6029',
    'https://www.presov.sk/get_rss.php?id=1_atom_9987'
);
$nr->nacitaj($poleUrl, 'presov');

echo 'Zapisalo aktuality z RSS <br>';






















