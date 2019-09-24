#!/usr/bin/php -q
<?php
require_once("phpagi.php");

$agi = new AGI();
$cpfdigits = $argv[1];

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://api-integrator.directcallsoft.com/api/v1/providers/salesforce/account/search/cpf?format=json",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{ \"cpf\": \"$cpfdigits\"}",
  CURLOPT_HTTPHEADER => array(
    "App-Origin: jaci@directcall.com.br",
    "Authorization: Bearer bb9abbca834847a2a65f9fb8ec2a5980",
    "Cache-Control: no-cache",
    "Connection: keep-alive",
    "Content-Type: application/json",
    "Host: api-integrator.directcallsoft.com",
    "Postman-Token: b755a8de-1360-432c-9476-44ae3ce8c3ef",
    "accept: application/json",
    "cache-control: no-cache"
 ),
));
$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
$dados = json_decode($response);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
	
    $dados = json_decode($response);
  if(!empty($dados->data->records[0]->Name)){	
    $agi->set_variable("phonecliente", $dados->data->records[0]->Phone);
    $agi->set_variable("NOME","Bem Vindo ".$dados->data->records[0]->Name);
    $agi->set_variable("cpfcliente", $dados->data->records[0]->CPF__c);
  }else{

    $agi->set_variable("NOME", "CLIENTE NAO LOCALIZADO");
}

}

?>
