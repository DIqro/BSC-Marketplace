<?php
$data = "1000"; //Ganti dengan consumerID dari BPJS
$secretKey = "7789"; //Ganti dengan consumerSecret dari BPJS
$url = "http://dvlp.bpjs-kesehatan.go.id:8081/devWsLokalRest/Peserta/Peserta/";  //Lihat katalog
$nok = $_POST["id"];  //ganti dengan NIK (nomor KTP) 0001037209061

date_default_timezone_set('UTC');
$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
$signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);
$encodedSignature = base64_encode($signature);
$urlencodedSignature = urlencode($encodedSignature);

// echo "X-cons-id: " .$data ."<br>";
// echo "X-timestamp:" .$tStamp ."<br>";
// echo "X-signature: " .$encodedSignature."<br>";

$opts = array(
	 'http'=>array(
	 'method'=>"GET",
	 'header'=>"Host: api.asterix.co.id\r\n".
	 "Connection: close\r\n".
	 "X-timestamp: ".$tStamp."\r\n".
	 "X-signature: ".$encodedSignature."\r\n".
	 "User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64)\r\n".
	 "X-cons-id: ".$data."\r\n".
	 "Accept: application/json\r\n"
	 )
);

$context = stream_context_create($opts);

$result = file_get_contents($url.$nok, false, $context);
if ($result === false) 
{ 
	echo "Tidak dapat menyambung ke server"; 
} 
else 
{ 
 	$resultarr=json_decode($result, true);
	// var_dump($resultarr);
	if (is_null($resultarr["response"]["peserta"])) {
		echo "Peserta tidak ditemukan";
	}
	else{
		echo "Nama : ".$resultarr["response"]["peserta"]["nama"]."<br>";
		echo "NIK : ".$resultarr["response"]["peserta"]["nik"]."<br>";
		echo "Tanggal Lahir : ".$resultarr["response"]["peserta"]["tglLahir"]."<br>";
		echo "Jenis Peserta : ".$resultarr["response"]["peserta"]["jenisPeserta"]["nmJenisPeserta"]."<br>";
		echo "Status Peserta : ".$resultarr["response"]["peserta"]["statusPeserta"]["keterangan"];
	}
}
	
	
?>
