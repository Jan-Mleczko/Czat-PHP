<?php
  include 'funkcje.php';
  sprzalog ();
  
  $odswiezaj = False;
  if (isset ($_GET['odsw']) && $_GET['odsw'] == 'tak') {
    $odswiezaj = True;
    header ("Refresh: 5");
  }
?><HTML>
  <HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=x-cp1250">
    <META NAME="author" CONTENT="Jan Mleczko">
    <TITLE>Odebrane - Czat pomiêdzy u¿ytkownikami</TITLE>
    <LINK REL="stylesheet" HREF="style.css">
  </HEAD><BODY>
    <H1><IMG SRC="chmurki.png" ALT="Dymki czatu"> Czat</H1>
    <DIV CLASS="menu">
      <A HREF="index.htm">O serwisie</A>
      &bull; <A HREF="logow.php">Logowanie</A>
      &bull; <A HREF="rej.php">Rejestracja</A>
      &bull; <A HREF="odebr.php">Twoje wiadomoœci</A>
      &bull; <A HREF="napisz.php">Napisz wiadomoœæ</A>
      &bull; <A HREF="wylog.php">Wyloguj siê</A>
    </DIV>
    <H2>Twoje wiadomoœci</H2>
    <?php
      if ($zalogowany) {
        echo '<P CLASS="menu">Odebrane &bull;';
        echo ' <A HREF="wysl.php">Wys³ane</A></P>';
        
        $nicniema = True;
        $ilosc = 0;
        $plik = fopen ('wiadom.txt', 'r');
        flock ($plik, LOCK_EX);
        do {
          $w_nad = rtrim (fread ($plik, 10));
          $w_odb = rtrim (fread ($plik, 10));
          $w_tresc = rtrim (fread ($plik, 500));
          if (feof ($plik))
            break;
          fseek ($plik, 2, SEEK_CUR);
          if ($w_odb == $zal_nazwa) {
            if ($nicniema) {
              echo '<DL>';
              $nicniema = False;
            }
            $unad = urlencode ($w_nad);
            $w_nad = htmlspecialchars ($w_nad);
            $w_tresc = htmlspecialchars ($w_tresc);
            echo "<DT>Od <STRONG>$w_nad</STRONG></DT>";
            echo "<DD><PRE>$w_tresc</PRE>";
            echo "<A HREF=\"napisz.php?kto=$unad\">Odpisz</A>";
            echo '<BR><BR></DD>';
            ++$ilosc;
          }
        } while (True);
        flock ($plik, LOCK_UN);
        fclose ($plik);
        if ($nicniema) {
          echo '<P CLASS="czerswiatlo">Nie masz ¿adnych wiadomoœci.</P>';
        } else {
          echo '</DL>';
          echo "<P>£¹cznie $ilosc wiadomoœci odebranych.</P>";
          echo '<P STYLE="font-size:120%">';
          echo 'Odœwie¿anie automatyczne wiadomoœci jest ';
          if ($odswiezaj)
            echo 'w³¹czone. <A HREF="?odsw=nie">Wy³¹cz</A></P>';
          else
            echo 'wy³¹czone. <A HREF="?odsw=tak">W³¹cz</A></P>';
        }
      } else {
        # Niezalogowany
        prosbalog ('otrzymywaæ wiadomoœci od innych u¿ytkowników');
      }
    ?>
  </BODY>
</HTML>
