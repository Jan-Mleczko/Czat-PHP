<?php
  include 'funkcje.php';
  sprzalog ();
?><HTML>
  <HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=x-cp1250">
    <META NAME="author" CONTENT="Jan Mleczko">
    <TITLE>Wys³ane - Czat pomiêdzy u¿ytkownikami</TITLE>
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
        echo '<P CLASS="menu"><A HREF="odebr.php">Odebrane</A>';
        echo ' &bull; Wys³ane</P>';
        
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
          echo '<P CLASS="czerswiatlo">Nie masz ¿adnych wiadomoœci.</P>';
        } else {
          echo '</DL>';
          echo "<P>£¹cznie $ilosc wiadomoœci wys³anych.</P>";
        }
      } else {
        # Niezalogowany
        prosbalog ('otrzymywaæ wiadomoœci od innych u¿ytkowników');
      }
    ?>
  </BODY>
</HTML>
