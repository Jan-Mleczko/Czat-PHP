<?php
  function sprzalog () {
    global $zalogowany, $zal_nazwa;
    
    $zalogowany = False;
    $zal_nazwa = '';
    
    if (isset ($_COOKIE['uzytk']) && isset ($_COOKIE['haslo'])) {
      $aktuzytk = $_COOKIE['uzytk'];
      $akthasz = md5 ($_COOKIE['haslo']);
      $znal = True;
      $plik = fopen ('uzytk.txt', 'r');
      flock ($plik, LOCK_EX);
      while ($wiersz = chop (fgets ($plik, 200))) {
        $nazwa = rtrim (substr ($wiersz, 0, 10));
        if ($nazwa == $aktuzytk) {
          $hasz = substr ($wiersz, 10, 32);
          $znal = True;
          break;
        }
      }
      flock ($plik, LOCK_UN);
      fclose ($plik);
      
      if ($znal && $hasz == $akthasz) {
        $zalogowany = True;
        $zal_nazwa = $nazwa;
      }
    }
  }
  
  function prosbalog ($okolicznosc) {
    echo "<P>¯eby $okolicznosc, ";
    echo '<A HREF="logow.php">zaloguj siê</A>.</P>';
    echo '<P>Je¿eli nie masz jeszcze swojego konta, mo¿esz siê';
    echo ' <A HREF="rej.php">zarejestrowaæ</A>.</P>';
  }
?>
