<?php
error_reporting(E_ALL);
ini_set("display_errors","On");

class Nacitanie_rss {
    private $subor = __DIR__ . '/rss-obce.xml';

// Nacita RSS zo servera a ulozi lokalne
public function nacitaj($urlArr, $cesta) {
    $cesta = dirname(__FILE__) . '/stiahnute/' . $cesta;
    
    // Vymaze obsah priecinka
    $files = glob($cesta); // get all file names
    foreach($files as $file){ // iterate files
        if(is_file($file)) {
            unlink($file); // delete file
        }
    }
    
    // Stiahne RSS dokumenty z webu
    $pocitadlo = 1;
    foreach($urlArr as $url) {
        $this->stiahniZWebu($url, $cesta . '/' . $pocitadlo . '.rss');
        $pocitadlo++;
    }
       
    //$this->vypisAktuality();       
}

private function nacitajDoPola($cestaArr) {
    $pole = array();
    
    foreach($cestaArr as $cesta) {
        $cestaSub = $cesta[0];
        $zdroj = $cesta[1];
        // Ziska vsetky subory RSS z priecinka
        $cesta = dirname(__FILE__) . '/stiahnute/' . $cestaSub;
        $files = scandir($cesta); // get all file names
        //print_r($files);
        
        foreach($files as $subor) {
            if(strcmp($subor, '.') == 0 || strcmp($subor, '..') == 0) continue;
            //if(strcmp($subor, '2.rss') != 0) continue;
            
            // Nacita subor do pola
            $subor = $cesta . "/" . $subor;
            //echo $subor . '<br/>';
            $feed = file_get_contents($subor);
            //echo $feed . '<br/>';
            $xml = simplexml_load_string($feed);
            //echo '<pre>'; print_r($xml); echo '</pre>';
            
            // Zisti verziu RSS
            $verzia = 2;
            if (strpos($feed, 'rss version="2.0"') !== false) {
                $verzia = 2;
            } else {
                $verzia = 1;
            }
            
            // Nacita udaje do jednotnej struktury nezavisle na verzii
            if($verzia == 2) {
                for($i = 0; $i < count($xml->channel->item); $i++){ // pre kazdu aktualizaciu v RSS
                    $ntica = array();
                    $ntica['zdroj'] = $zdroj;
                    $ntica['nazov'] = $xml->channel->item[$i]->title;
                    $ntica['odkaz'] = $xml->channel->item[$i]->link;
                    $ntica['popis'] = $xml->channel->item[$i]->description;
                    $ntica['kategoria'] = $xml->channel->item[$i]->category;
                    
                    $ntica['cas'] = $xml->channel->item[$i]->pubDate;
                    $ntica['cas'] = strtotime($ntica['cas']);
                    
                    array_push($pole, $ntica);
                }
            } else { // Verzia 1
                for($i = 0; $i < count($xml->entry); $i++){ // pre kazdu aktualizaciu v RSS
                    $ntica = array();
                    $ntica['zdroj'] = $zdroj;
                    $ntica['nazov'] = (string) $xml->entry[$i]->title; // "string" kvoli pristupu k hodnote
                    $ntica['odkaz'] = (string) $xml->entry[$i]->id;
                    $ntica['popis'] = (string) $xml->entry[$i]->content; // prip. summary
                    $ntica['kategoria'] = (string) $xml->entry[$i]->category['term'];
                    
                    $ntica['cas'] = $xml->entry[$i]->published;
                    $ntica['cas'] = strtotime($ntica['cas']);
                    
                    //echo '<pre>'; print_r($ntica); echo '</pre>';
                    array_push($pole, $ntica);
                }
            }
        }
    }
    
    return $pole;
}

public function vykresliPodlaDatumu($cestaArr) {    
    $pole = $this->nacitajDoPola($cestaArr);
     
    // Zotriedi podla datumu
    usort($pole, function($a, $b) {
        return $b['cas'] <=> $a['cas'];
    });
       
    $predoslyDatum = null;
    foreach($pole as $u) {
        //$casUnix = strtotime($u['cas']);
        $datum = date('d.m.Y', $u['cas']);
        $hodina = date('H:i', $u['cas']);

        // Vykreslenie datumu
        if(strcmp($predoslyDatum, $datum) != 0 || $predoslyDatum == null) {
            echo '<hr/>';                     
            echo "<strong> " . $datum . ' </strong><br/>';
        }
        if($predoslyDatum == null) $predoslyDatum = $datum; // Musi ist za predoslou podmienkou
        $predoslyDatum = $datum;
        
        // Vykreslenie polozky
        echo '<p>';
        echo '<strong><i>' . $u['zdroj'] . '</i></strong>' . '<br/>';
        echo '<strong>' . $u['nazov'] . '</strong>' . '<br/>';
        echo 'Kategória: ' . $u['kategoria'] . '<br/>';
        if(strlen(trim($u['popis'])) > 0) echo 'Popis: <i>' . $u['popis'] . '</i><br/>';
        echo '<a href="' . $u['odkaz'] . '" target="_blank" >Bližšie v tomto odkaze</a>' . '<br/>';
        echo 'Zverejnené: ' . $datum . ' o ' . $hodina . '</strong>' . '<br/>';
        echo '</p>';
        //echo '<br/>';
                
    }
}

private function stiahniZWebu($url, $cesta) {  
    $obsah = file_get_contents($url);
    
    // Testy    
    $obsah = trim($obsah);     
    if(strlen($obsah) == 0) return;       
        
    //echo $obsah. '<br/>';
    //unlink($cesta);

    $myfile = fopen($cesta, "w") or die("Unable to open file!");
    fwrite($myfile, $obsah);
    fclose($myfile);
    
}

}



















































