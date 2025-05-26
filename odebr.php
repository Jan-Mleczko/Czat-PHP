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
    <TITLE>Odebrane - Czat pomi�dzy u�ytkownikami</TITLE>
    <LINK REL="stylesheet" HREF="style.css">
  </HEAD><BODY>
    <H1><IMG SRC="chmurki.png" ALT="Dymki czatu"> Czat</H1>
    <DIV CLASS="menu">
      <A HREF="index.htm">O serwisie</A>
      &bull; <A HREF="logow.php">Logowanie</A>
      &bull; <A HREF="rej.php">Rejestracja</A>
      &bull; <A HREF="odebr.php">Twoje wiadomo�ci</A>
      &bull; <A HREF="napisz.php">Napisz wiadomo��</A>
      &bull; <A HREF="wylog.php">Wyloguj si�</A>
    </DIV>
    <H2>Twoje wiadomo�ci</H2>
    <?php
      if ($zalogowany) {
        echo '<P CLASS="menu">Odebrane &bull;';
        echo ' <A HREF="wysl.php">Wys�ane</A></P>';
        
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
          echo '<P CLASS="czerswiatlo">Nie masz �adnych wiadomo�ci.</P>';
        } else {
          echo '</DL>';
          echo "<P>��cznie $ilosc wiadomo�ci odebranych.</P>";
          echo '<P STYLE="font-size:120%">';
          echo 'Od�wie�anie automatyczne wiadomo�ci jest ';
          if ($odswiezaj)
            echo 'w��czone. <A HREF="?odsw=nie">Wy��cz</A></P>';
          else
            echo 'wy��czone. <A HREF="?odsw=tak">W��cz</A></P>';
        }
      } else {
        # Niezalogowany
        prosbalog ('otrzymywa� wiadomo�ci od innych u�ytkownik�w');
      }
    ?>
  </BODY>
</HTML>
