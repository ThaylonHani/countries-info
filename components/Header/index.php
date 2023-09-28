  <style>
    <?php
    require 'style.css';
    ?>
  </style>
  <header class=" bg-two">

    <nav class="navbar bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="/">
          Countries Info
        </a>
        <form action=<?= $_SERVER['PHP_SELF'] ?> method='post' class="d-flex" id="form-header" role="search">
          <datalist id="countries-list">
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
          </datalist>
          <input class="form-control me-2" name="country" id="src-header" type="search"  placeholder="Search a country" list='countries-list' maxlength="20" title="Coloque apenas as siglas" aria-label="Search">
          </input>
          <button class="btn search-button position-relative " type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg>
          </button>
        </form>
      </div>
    </nav>
  </header>