<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Training;

use App\Testing;

use App\Pengujian;

class PengujianMetodeController extends Controller
{	
	//====================================
    //fungsi probabilitas kata setiap kelas
    public function p_kata_kelas ($a_text=[],$a_class=[], $class_vocab, $p_class){
        $i=1;
        foreach ($a_text as $value) {
            $kata=0;
            foreach ($a_class as $value_b) {
                if($value == $value_b){
                    $kata++;
                }
            }
            $i=$i*($kata+1)/($class_vocab);
        }
        return $i*$p_class;
    }
    //=======================
    //fungsi klasifikasi data
    public function klasifikasi ($p_positif, $p_negatif){
         if($p_positif > $p_negatif){
            $klasifikasi="positif";
        }else{
            $klasifikasi="negatif";
        }
        return $klasifikasi;
    }
    //=======================
    //fungsi rule
    public function rules($txt){
        // http:
        $txt = preg_replace('|http://www\.[a-z\.0-9]+|i', '', $txt);
        // only www.
        $txt = preg_replace('|www\.[a-z\.0-9]+|i', '', $txt);
        //mention
        $txt = preg_replace('|@[a-z\.0-9]+|i', '', $txt);
        //hashtag
        $txt = preg_replace('|#[a-z\.0-9]+|i', '', $txt);
        //https
        $txt = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $txt);
        $txt = str_replace('-', "", $txt);
        //angka
        $txt = preg_replace('/[0-9]+/', '', $txt);
        return $txt;
    }
    //==========================
    //mengumpulkan data TRAINING
    //==========================
    public function data_training(){
        $txt = Training::all()->pluck('tweet');
        return $txt;
    }

    public function data_positif(){
        $positif = Training::select('tweet')->where('class', '=','positif')->pluck('tweet');
        return $positif;   
    }

    public function data_negatif(){
        $negatif = Training::select('tweet')->where('class', '=','negatif')->pluck('tweet');
        return $negatif;
    }
    //==========================
    // Mengumpulkan Data Testing
    //==========================
    public function jumlah_data_testing(){
        $data_testing_total = Testing::all()->count();
        return $data_testing_total;
    }

    public function jumlah_data_testing_p(){
        $data_testing_p = Testing::select('tweet')->where('class_prediksi','=','Positif')->count();
        return $data_testing_p;
    }

    public function jumlah_data_testing_n(){
        $data_testing_n = Testing::select('tweet')->where('class_prediksi','=','Negatif')->count();
        return $data_testing_n;
    }
    //==========================
    // Data Pengujian Metode
    //==========================
    public function jumlah_matrik_total(){
        $total_matriks = Pengujian::all()->count();
        return $total_matriks;
    }

    public function jumlah_matrik_tp(){
        $matriks_tp = Pengujian::select('id')->where('matriks','=','TP')->count();
        return $matriks_tp;
    }

    public function jumlah_matrik_tn(){
        $matriks_tn = Pengujian::select('id')->where('matriks','=','TN')->count();
        return $matriks_tn;
    }
    public function jumlah_matrik_fp(){
        $matriks_fp = Pengujian::select('id')->where('matriks','=','FP')->count();
        return $matriks_fp;
    }
    public function jumlah_matrik_fn(){
        $matriks_fn = Pengujian::select('id')->where('matriks','=','FN')->count();
        return $matriks_fn;
    }
    //=============================      
        
    //PREPROCESSING DATA
    public function preprocessing_data($data){
        //load library steming
        $stemmerFactory    = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer           = $stemmerFactory->createStemmer();
        //stop word removing
        $stopwordFactory   = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
        $stopword          = $stopwordFactory->createStopWordRemover();
        //load library token
        $tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
        $tokenizer         = $tokenizerFactory->createDefaultTokenizer();

        $rule       = $this->rules($data);
        $stop       = $stopword->remove($rule);
        $output     = $stemmer->stem($stop);
        $token      = $tokenizer->tokenize($output);        
        return $token;
    }
    //=========================

    //hitung data
    public function hitung_data($data){
        $jumlah_data = $data->count();
        return $jumlah_data;
    }
    //=========================

    //hitung jumlah token (Count)
    public function hitung_token($token){
        $frek  = array_count_values($token);
        //jumlah kata dalam training
        $jumlah= count($frek);
        return $jumlah;
    }

    public function uji(){
    	//+=======================+
        //|     text training     |
        //+=======================+ 
        $txt = $this->data_training();
        //jumlah data
        $jumlah_data_training = $this->hitung_data($txt);
        //preprocessing data
        $preprocessing = $this->preprocessing_data($txt);
        //hitung token
        $vocabulary = $this->hitung_token($preprocessing);

        //+=======================+
        //|   training positif    |
        //+=======================+ 
        $positif = $this->data_positif();
        $jumlah_data_p = $this->hitung_data($positif);
        //preprocessing data
        $preprocessing_p = $this->preprocessing_data($positif);
        $count_p = $this->hitung_token($preprocessing_p);
        //+=======================+
        //|   training negatif    |
        //+=======================+ 
        $negatif = $this->data_negatif();
        $jumlah_data_n = $this->hitung_data($negatif);
        //preprocessing data
        $preprocessing_n = $this->preprocessing_data($negatif);
        $count_n = $this->hitung_token($preprocessing_n);

        //positif
        $class_positif = $jumlah_data_p/$jumlah_data_training;
        //negatif
        $class_negatif = $jumlah_data_n/$jumlah_data_training;

        //class positif + jumlah
        $class_vocab_p = $count_p + $vocabulary;
        //class negatif + jumlah
        $class_vocab_n = $count_n + $vocabulary;

        $training = Training::all();

        $tp=0;
        $tn=0;
        $fp=0;
        $fn=0;
    	foreach ($training as $data) {
    		$txt = $data->tweet;
    		$preprocessing = $this->preprocessing_data($txt);
    		$unique = array_unique($preprocessing);
    		$p_positif = $this->p_kata_kelas($unique,$preprocessing_p,$class_vocab_p,$class_positif);
    		$p_negatif = $this->p_kata_kelas($unique,$preprocessing_n,$class_vocab_n,$class_negatif);
    		$klasifikasi = $this->klasifikasi($p_positif,$p_negatif);

    		if($data->class == 'positif' && $klasifikasi == 'positif'){
    			$tp++;
    		}else if($data->class == 'negatif' && $klasifikasi == 'negatif'){
    			$tn++;
    		}else if($data->class == 'positif' && $klasifikasi == 'negatif'){
    			$fp++;
    		}else if($data->class == 'negatif' && $klasifikasi == 'positif'){
    			$fn++;
    		}
    		// echo $klasifikasi."<br>";
    	}
    	//persentase matriks
    	$persen_tp = round($tp/$jumlah_data_training*100, 2);
        $persen_tn = round($tn/$jumlah_data_training*100, 2);
        $persen_fp = round($fp/$jumlah_data_training*100, 2);
        $persen_fn = round($fn/$jumlah_data_training*100, 2);
    	//akurasi dan error rate
        $akurasi   = round(($tp+$tn)/($tp+$tn+$fp+$fn)*100, 2);
        $errorrate = round(($fp+$fn)/($tp+$tn+$fp+$fn)*100, 2);

        return view('textmining.pengujian', compact('akurasi','errorrate','tp','tn','fp','fn','jumlah_data_training','persen_tp','persen_fn','persen_fp','persen_tn'));
        // echo "<br>".$akurasi."<br>";
        // echo "<br>".$errorrate."<br>";
    }
}
