<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class SastrawiController extends Controller
{
    public function index()
    {
       require_once __DIR__ . '/../../../vendor/autoload.php';
       $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
       $stemmer  = $stemmerFactory->createStemmer();

// stem
       $sentence = 'ngepel';
       $output   = $stemmer->stem($sentence);

       echo $output . "\n";
// ekonomi indonesia sedang dalam tumbuh yang bangga

       echo $stemmer->stem('Mereka meniru-nirukannya') . "\n";
// mereka tiru
    }
}
