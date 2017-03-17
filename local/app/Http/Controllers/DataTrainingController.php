<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Training;

use App\Testing;

use App\Pengujian;

use Session;

class DataTrainingController extends Controller
{
    public function index(){
    	$halaman = 'training';
    	$data_training = Training::orderBy('id', 'asc')->paginate(10);
        $jumlah_data   = Training::count();
    	return view('textmining.index', compact('halaman', 'data_training', 'jumlah_data'));
    }
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
            $klasifikasi="Positif";
        }else{
            $klasifikasi="Negatif";
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

    public function show_testing(){
        $halaman = "testing";
        $data_testing = Testing::orderBy('id', 'asc')->paginate(10);
        $jumlah_data = Testing::count();
        return view('textmining.testing', compact('halaman','jumlah_data','data_testing'));
    }
    public function store_testing(Request $request){
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
        $hitung_kemunculan_kata = array_count_values($preprocessing);

        //+=======================+
        //|     text positif      |
        //+=======================+ 
        $positif = $this->data_positif();
        //jumlah data
        $jumlah_data_p = $this->hitung_data($positif);
        //preprocessing data
        $preprocessing_p = $this->preprocessing_data($positif);
        //hitung token
        $count_p = $this->hitung_token($preprocessing_p);
        $hitung_kemunculan_kata_p = array_count_values($preprocessing_p);

        //+=======================+
        //|     text negatif      |
        //+=======================+ 
        $negatif = $this->data_negatif();
        //jumlah data
        $jumlah_data_n = $this->hitung_data($negatif);
        //preprocessing data
        $preprocessing_n = $this->preprocessing_data($negatif);
        //hitung token
        $count_n = $this->hitung_token($preprocessing_n);
        $hitung_kemunculan_kata_n = array_count_values($preprocessing_n);

        //+=======================+
        //|     text dari form    |
        //+=======================+ 
        $text                   = $request->tweet;
        $preprocessing_testing  = $this->preprocessing_data($text);
        $unique                 = array_unique($preprocessing_testing);
  
        //probabilitas class     
        //positif
        $class_positif = $jumlah_data_p/$jumlah_data_training;
        //negatif
        $class_negatif = $jumlah_data_n/$jumlah_data_training;

        //class positif + jumlah
        $class_vocab_p = $count_p + $vocabulary;
        //class negatif + jumlah
        $class_vocab_n = $count_n + $vocabulary;

        //klasifikasi data tweet
        $p_positif   = $this->p_kata_kelas($unique, $preprocessing_p, $class_vocab_p, $class_positif);
        $p_negatif   = $this->p_kata_kelas($unique, $preprocessing_n, $class_vocab_n, $class_negatif);
        $klasifikasi = $this->klasifikasi($p_positif, $p_negatif);

        //jumlah data testing
        $jumlah_data_testing   = $this->jumlah_data_testing();
        $jumlah_data_testing_p = $this->jumlah_data_testing_p();
        $jumlah_data_testing_n = $this->jumlah_data_testing_n();

        // persentasi
        $persen_p = round($jumlah_data_testing_p/$jumlah_data_testing*100);
        $persen_n = round($jumlah_data_testing_n/$jumlah_data_testing*100);
        //mengubah array menjadi string 
        $input = implode(" ", $unique);
        $halaman = 'testing';
        $testing = new \App\Testing;
        $testing->tweet         = $input;
        $testing->p_positif     = $p_positif;
        $testing->p_negatif     = $p_negatif;
        $testing->class_prediksi= $klasifikasi;
        $testing->save();
        return view('textmining.hasil', compact('text','input','p_positif', 'p_negatif','klasifikasi','halaman','jumlah_data_testing_p','jumlah_data_testing_n','jumlah_data_testing', 'persen_p', 'persen_n'));
    }



    public function store_training(Request $request){
        //load library steming
        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer        = $stemmerFactory->createStemmer();
        //stop word removing
        $stopwordFactory = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
        $stopword        = $stopwordFactory->createStopWordRemover();
        //load library token
        $tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
        $tokenizer         = $tokenizerFactory->createDefaultTokenizer();

        $training        = $request->tweet;
        $rule_training   = $this->rules($training);
        $kecil           = strtolower($rule_training);

        //fungsi preprocessing inputan
        $stop_training   = $stopword->remove($kecil);
        $output_training = $stemmer->stem($stop_training);

        // //+========================================================================+
        // //|                     fungsi mencari matrix dari inputan                 |
        // //+========================================================================+
        // //+=======================+
        // //|     text training     |
        // //+=======================+ 
        // $txt = $this->data_training();
        // //jumlah data
        // $jumlah_data_training = $this->hitung_data($txt);
        // //preprocessing data
        // $preprocessing = $this->preprocessing_data($txt);
        // //hitung token
        // $vocabulary = $this->hitung_token($preprocessing);

        // //+=======================+
        // //|   training positif    |
        // //+=======================+ 
        // $positif = $this->data_positif();
        // $jumlah_data_p = $this->hitung_data($positif);
        // //preprocessing data
        // $preprocessing_p = $this->preprocessing_data($positif);
        // $count_p = $this->hitung_token($preprocessing_p);
        // //+=======================+
        // //|   training negatif    |
        // //+=======================+ 
        // $negatif = $this->data_negatif();
        // $jumlah_data_n = $this->hitung_data($negatif);
        // //preprocessing data
        // $preprocessing_n = $this->preprocessing_data($negatif);
        // $count_n = $this->hitung_token($preprocessing_n);
        
        // //+================================+
        // //|   klasifikasi data training    |
        // //+================================+ 
        // $preprocessing_training  = $this->preprocessing_data($training);
        // $unique                  = array_unique($preprocessing_training);
        // //probabilitas class     
        // //positif
        // $class_positif = $jumlah_data_p/$jumlah_data_training;
        // //negatif
        // $class_negatif = $jumlah_data_n/$jumlah_data_training;

        // //class positif + jumlah
        // $class_vocab_p = $count_p + $vocabulary;
        // //class negatif + jumlah
        // $class_vocab_n = $count_n + $vocabulary;

        // //klasifikasi data tweet
        // $p_positif = $this->p_kata_kelas($unique, $preprocessing_p, $class_vocab_p, $class_positif);
        // $p_negatif = $this->p_kata_kelas($unique, $preprocessing_n, $class_vocab_n, $class_negatif);
        // $klasifikasi = $this->klasifikasi($p_positif, $p_negatif);

        // //+=======================================+
        // //|   kondisional matrix data training    |
        // //+=======================================+ 

        // if($request->class=='positif' && $klasifikasi == 'Positif'){
        //     $matriks = 'TP';
        // }else if($request->class =='negatif' && $klasifikasi == 'Negatif'){
        //     $matriks = 'TN';
        // }else if($request->class =='positif' && $klasifikasi == 'Negatif'){
        //     $matriks = "FP";
        // }else if($request->class =='negatif' && $klasifikasi == 'Positif'){
        //     $matriks = 'FN';
        // }

        //relasi one to one
        $halaman  = 'training';
        $training = new \App\Training;
        $training->tweet           = $output_training;
        $training->class           = $request->class;
        $training->save();

        //fungsi klasifikasi data training untuk mencari nilai matrix
        

        // $insertedId = $training->id;
        // $pengujian = new \App\Pengujian;
        // $pengujian->id_tweet        = $insertedId;
        // $pengujian->predicted_class = $klasifikasi;
        // $pengujian->matriks         = $matriks;
        // $pengujian->save();

        Session::flash('flash_message' , 'Data training berhasil ditambahkan');
        return redirect('home');
    }

    public function destroy_training($id){
        $training = Training::findOrFail($id);
        $training->delete();
        Session::flash('flash_message' , 'Data training berhasil dihapus');
        return redirect('home');
    }

     public function presentase_testing(){
        //ambil data testing
        $data_testing_total = Testing::all()->count();
        $data_testing_p = Testing::select('tweet')->where('class_prediksi','=','Positif')->count();
        $data_testing_n = Testing::select('tweet')->where('class_prediksi','=','Negatif')->count();


        //text Training
        $txt = Training::all();
        $jumlah_training = $txt->count();
        //=====================================================================================
        
        //text positif
        $positif = Training::select('tweet')->where('class', '=','positif');
        $jumlah_positif = $positif->count();

        //=====================================================================================
       
        //text negatif
        $negatif = Training::select('tweet')->where('class', '=','negatif');
        $jumlah_negatif = $negatif->count();
        //probabilitas class
        //positif
        $class_positif = $jumlah_positif/$jumlah_training;
        //negatif
        $class_negatif = $jumlah_negatif/$jumlah_training;

        // persentasi
        $persen_p_training = round($class_positif*100, 2);
        $persen_n_training = round($class_negatif*100, 2);
        $persen_p = round($data_testing_p/$data_testing_total*100, 2);
        $persen_n = round($data_testing_n/$data_testing_total*100, 2);
        $halaman = 'presentase';

        return view('textmining.presentase', compact('halaman','data_testing_p','data_testing_n','data_testing_total', 'persen_p', 'persen_n', 'jumlah_training', 'jumlah_positif','jumlah_negatif', 'persen_p_training', 'persen_n_training'));
    }

    public function destroy_testing($id){
        $testing = Testing::findOrFail($id);
        $testing->delete();
        return redirect('home/testing');
    }

    public function pengujian_metode(){
        $total_matriks = $this->jumlah_matrik_total();
        $tp            = $this->jumlah_matrik_tp();
        $tn            = $this->jumlah_matrik_tn();
        $fp            = $this->jumlah_matrik_fp();
        $fn            = $this->jumlah_matrik_fn();

        //persen matriks 
        $persen_tp = round($tp/$total_matriks*100, 2);
        $persen_tn = round($tn/$total_matriks*100, 2);
        $persen_fp = round($fp/$total_matriks*100, 2);
        $persen_fn = round($fn/$total_matriks*100, 2);

        //akurasi dan error rate
        $akurasi   = round(($tp+$tn)/($tp+$tn+$fp+$fn)*100, 2);
        // $akurasi   = round((8+100)/(8+92+0+100)*100, 2);
        $errorrate = round(($fp+$fn)/($tp+$tn+$fp+$fn)*100, 2);
        return view('textmining.pengujian', compact('total_matriks','tp','tn','fp','fn','persen_tp','persen_tn','persen_fp','persen_fn','akurasi','errorrate'));
    }

    public function jajal(){
        return view('textmining.pengujian');
    }

    public function preprocessing(){
        //load library steming
        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();
        //stop word removing
        $stopwordFactory = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
        $stopword = $stopwordFactory->createStopWordRemover();
        //load library token
        $tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
        $tokenizer = $tokenizerFactory->createDefaultTokenizer();
        
        //text Training
        $txt = Training::all()->pluck('tweet');
        $jumlah_training = $txt->count();
        
        //fungsi preprocessing training
        $rule_training = $this->rules($txt);
        $stop = $stopword->remove($rule_training);
        $output =$stemmer->stem($stop);
        $token = $tokenizer->tokenize($output);

        //frekuensi term training
        $frek  = array_count_values($token);
        //jumlah kata dalam training
        $jumlah= count($frek);
        //=====================================================================================
        
        //text positif
        $positif = Training::select('tweet')->where('class', '=','positif')->pluck('tweet');
        $jumlah_positif = $positif->count();
        
        //fungsi preprocessing positif
        $rule_positif = $this->rules($positif);
        $stop_p = $stopword->remove($rule_positif);
        $output_p =$stemmer->stem($stop_p);
        $token_p = $tokenizer->tokenize($output_p);

        //frekuensi term positif
        $frek_p  = array_count_values($token_p);
        //jumlah kata dalam kelas positif
        $jumlah_p= count($frek_p);
        //=====================================================================================
       
        //text negatif
        $negatif = Training::select('tweet')->where('class', '=','negatif')->pluck('tweet');
        $jumlah_negatif = $negatif->count();
        
        //fungsi preprocessing negatif
        $rule_negatif = $this->rules($negatif);     
        $stop_n = $stopword->remove($rule_negatif);
        $output_n =$stemmer->stem($stop_n);
        $token_n = $tokenizer->tokenize($output_n);

        //frekuensi term negatif
        $frek_n  = array_count_values($token_n);
        //jumlah kata dalam kelas negatif
        $jumlah_n= count($frek_n);
        //===================================================================================      
        //                  CEK DATA TRAINING, DATA POSITIF DAN NEGATIF
        //===================================================================================
        echo $output;
        echo "<pre>";
        //tampil jumlah array
        //echo $frek['terus'];
        echo "<br>";
        print_r($frek);
        echo "</pre>";
        echo 'Vocabulary : '.$jumlah.'</br>';

        //frekuensi positif 
        echo $output_p;
        echo "<pre>";

        print_r($frek_p);
        echo "</pre>";
        echo 'Count P : '.$jumlah_p.'</br>';

        //frekuensi positif
        echo $output_n;
        echo "<pre>";

        print_r($frek_n);
        echo "</pre>";
        echo 'Count N : '.$jumlah_n.'</br>';

        // ============================================================
        

        $text = "kantor pos takut kirim alamat tuju terima ambil";
        $rule_text = $this->rules($text);

        //fungsi preprocessing inputan
        $stop_t = $stopword->remove($rule_text);
        $output_t =$stemmer->stem($stop_t);
        // $stop_t = $stopword->remove($output_t);
        $token_t = $tokenizer->tokenize($output_t);
        $unique = array_unique($token_t);

        //probabilitas class
       
        //positif
        $class_positif = $jumlah_positif/$jumlah_training;
        //negatif
        $class_negatif = $jumlah_negatif/$jumlah_training;

        //class positif + jumlah
        $class_vocab_p = $jumlah_p + $jumlah;
        //class negatif + jumlah
        $class_vocab_n = $jumlah_n + $jumlah;


        var_dump($unique);
        $input = implode(" ", $unique);
        echo $input; 
        echo "<p>";
        // Hitung Probabilitas Tiap Kata thd Kelas Positif
        $i=1;
        foreach($unique as $value){
            $kata = 0;
           foreach ($token_p as $value_p) {
               if($value == $value_p){
                
                    $kata++;
               }
           }
            $i=$i*($kata+1)/($class_vocab_p);
            echo $kata."<br>"; 
            echo ($kata+1)/($jumlah_p+$jumlah) ."<br><p>";
        }
        // echo "Probabilitas Kelas Negatif : ".$i*$class_negatif . "<br>";


        // menentukan class text 
        


        ///
        $p_positif = $this->p_kata_kelas($unique, $token_p, $class_vocab_p, $class_positif);
        $p_negatif = $this->p_kata_kelas($unique, $token_n, $class_vocab_n, $class_negatif);
        $klasifikasi = $this->klasifikasi($p_positif, $p_negatif);

        echo $p_positif . "<br>";
        echo $p_negatif . "<br>";
        echo "Kelas dari text Adalah : ".$klasifikasi ;
        print_r($unique);
        echo "<br>";
        echo "Jumlah Data Training : ".$jumlah_training ."<br>";
        echo "Jumlah Data Positif : ".$jumlah_positif ."<br>";
        echo "Jumlah Data negatif : ".$jumlah_negatif ."<br>";
        echo "Probabilitas Kelas Positif : ".$class_positif ."<br>";
        echo "Probabilitas Kelas Negatif : ".$class_negatif ."<br>";
    }
}
