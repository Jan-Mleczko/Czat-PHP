<?php
  include 'funkcje.php';
  sprzalog ();
?><HTML>
  <HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=x-cp1250">
    <META NAME="author" CONTENT="Jan Mleczko">
    <TITLE>Wys�ane - Czat pomi�dzy u�ytkownikami</TITLE>
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
        echo '<P CLASS="menu"><A HREF="odebr.php">Odebrane</A>';
        echo ' &bull; Wys�ane</P>';
        
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
          if ($w_nad == $zal_nazwa) {
            if ($nicniema) {
              echo '<DL>';
              $nicniema = False;
            }
            $w_odb = htmlspecialchars ($w_odb);
            $w_tresc = htmlspecialchars ($w_tresc);
            echo "<DT>Do <STRONG>$w_odb</STRONG></DT>";
            echo "<DD><PRE>$w_tresc</PRE></DD>";
            ++$ilosc;
          }
        } while (True);
        flock ($plik, LOCK_UN);
        fclose ($plik);
        if ($nicniema) {
          echo '<P CLASS="czerswiatlo">Nie masz �adnych wiadomo�ci.</P>';
        } else {
          echo '</DL>';
          echo "<P>��cznie $ilosc wiadomo�ci wys�anych.</P>";
        }
      } else {
        # Niezalogowany
        prosbalog ('otrzymywa� wiadomo�ci od innych u�ytkownik�w');
      }
    ?>
  </BODY>
</HTML>
