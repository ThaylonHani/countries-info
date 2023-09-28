<style>
  <?php require_once 'style.css' ?>
</style>
<div id='countries-container'>
  <p>Select a country:</p>
  <form action=<?= $_SERVER['PHP_SELF'] ?> method='post'>
    <select onchange="this.form.submit()" name="country" id="country" class="form-control form-select-sm " aria-label="Default select example">
      <?php
      require './components/Api/api.php';
      $countriesName = [];

      foreach ($countries as $country) {
        if (!in_array($country->nome->abreviado, $countriesName)) {
          $countriesName[] = $country->nome->abreviado;
          if ($country->id->{'ISO-3166-1-ALPHA-2'} == $_POST['country']) {
            echo "<option selected value={$country->id->{'ISO-3166-1-ALPHA-2'}}>{$country->id->{'ISO-3166-1-ALPHA-2'}} - {$country->nome->abreviado}</option>";
          } else {
            echo "<option value={$country->id->{'ISO-3166-1-ALPHA-2'}}>{$country->id->{'ISO-3166-1-ALPHA-2'}} - {$country->nome->abreviado}</option>";
          }
        }
      }
      ?>
    </select>
  </form>
</div>
<div id='countries-info'>
  <?php
  $countryP = $_POST['country'] ?? 'AD';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
  curl_setopt($ch, CURLOPT_URL, "http://servicodados.ibge.gov.br/api/v1/paises/$countryP");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $res = json_decode(curl_exec($ch));
  $history = [];
  $links=[];
  $territorialExtension = number_format((float)$res[0]->area->total,0,',','.');
  if(strpos($res[0]->historico,'Fontes:')){
    array_push($history,...explode('Fontes:',$res[0]->historico))??'';
    array_push($links,...explode(' ',$history[1]));
  }
  elseif(strpos($res[0]->historico,'Fonte:')) {
    array_push($history,...explode('Fonte:',$res[0]->historico));
    array_push($links,...explode(' ',$history[1]));
  }
  else {
    array_push($history,$res[0]->historico);
    array_push($links,'Sem fontes');
  }
  $links[0] == '' ? array_shift($links) : false;
  echo <<<COUNTRY
      <h2>
        {$res[0]->nome->abreviado}
      </h2>
          <ul>
              <li>
                  <p>
                    Sigla:  
                  </p>
                  <p>
                  {$res[0]->id->{'ISO-3166-1-ALPHA-2'}}
                  </p>
              </li>
              <li>
                  <p>
                    Capital: 
                  </p>
                  <p>
                  {$res[0]->governo->capital->nome}
                  </p>
              </li>
              <li>
                  <p>Extensão territorial: </p>
                  <p>{$territorialExtension}{$res[0]->area->unidade->símbolo}</p>
              </li>
              <li>
                  <p>Localização: </p>
                  <p>{$res[0]->localizacao->{'sub-regiao'}->nome}</p>
              </li>
              <li>
                  <p>Idioma: </p>
                  <p>{$res[0]->linguas[0]->nome}
                  </p>
              </li>
              <li>
                  <p>Moeda: </p>
                  <p>{$res[0]->{'unidades-monetarias'}[0]->nome} </p>
              </li>
              <li id='history-country'>
                  <p>Historia: </p>
                  <p>$history[0]</p>
              </li>
              <li>
                  <p>Fonte: </p>
                  <div class='links'>
                  <a id='link' href={$links[0]}>$links[0]</a>
                  </div>
              </li>
           </ul>
COUNTRY;
  ?>
  <script>
    document.querySelector('#link').value = 'Sem fontes' ? document.querySelector('#link').href = '#' : false
  </script>
</div>
</div>