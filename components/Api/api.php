<?php
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
  curl_setopt($ch, CURLOPT_URL, 'http://servicodados.ibge.gov.br/api/v1/paises/all');
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $countries = json_decode(curl_exec($ch), true);
  if (curl_errno($ch)) {
    echo 'Erro cURL: ' . curl_error($ch);
  }
  $countries = array_map('json_encode', $countries);
  array_unique($countries);
  $countries = array_map('json_decode', $countries);
  ?>