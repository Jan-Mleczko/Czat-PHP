<?php
  include 'funkcje.php';
  sprzalog ();
?><HTML>
  <HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=x-cp1250">
    <META NAME="author" CONTENT="Jan Mleczko">
    <TITLE>Napisz wiadomoœæ - Czat pomiêdzy u¿ytkownikami</TITLE>
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
    <H2>Napisz wiadomoœæ</H2>
    <?php
      if ($zalogowany) {
        $edytodb = '';
        $edyttresc = '';
        if (isset ($_POST['odb']) && isset ($_POST['tresc'])) {
          $odbiorca = $_POST['odb'];
          $tresc = $_POST['tresc'];
          if (strlen ($tresc) <= 500) {
            $jest = False;
            $plik = fopen ('uzytk.txt', 'r');
            flock ($plik, LOCK_EX);
            while ($wiersz = chop (fgets ($plik, 200))) {
              if (rtrim (substr ($wiersz, 0, 10)) == $odbiorca) {
                $jest = True;
                break;
              }
            }
            flock ($plik, LOCK_UN);
            fclose ($plik);
            if ($jest) {
              $zapis = '';
              $zapis .= str_pad ($zal_nazwa, 10);
              $zapis .= str_pad ($odbiorca, 10);
              $zapis .= str_pad ($tresc, 500);
              $plik = fopen ('wiadom.txt', 'a');
              flock ($plik, LOCK_EX);
              fputs ($plik, "$zapis\r\n");
              flock ($plik, LOCK_UN);
              fclose ($plik);
              echo '<P CLASS="zielswiatlo">';
              echo 'Wiadomoœæ zosta³a wys³ana pomyœlnie!</P>';
            } else {
              $odbiorca = htmlentities ($odbiorca);
              echo '<P CLASS="czerswiatlo">Nie ma takiego u¿ytkownika jak';
              echo " <EM>$odbiorca</EM>.</P>";
              $edytodb = $odbiorca;
              $edyttresc = $tresc;
            }
          } else {
            echo '<P CLASS="czerswiatlo">Za d³uga wiadomosæ.</P>';
            $edyttresc = substr ($tresc, 0, 497) . "...";
          }
        } else if (isset ($_GET['kto'])) {
          $edytodb = $_GET['kto'];
        }
        $edytodb = htmlspecialchars ($edytodb);
        $edyttresc = htmlspecialchars ($edyttresc);
        $hnazwa = htmlspecialchars ($zal_nazwa);
        echo '<FORM METHOD="POST"><TABLE><TR>';
        echo '<TD>Piszesz jako:&nbsp;&nbsp;</TD>';
        echo "<TD><EM>$hnazwa</EM></TD></TR>";
        echo '<TR><TD>Nazwa odbiorcy:&nbsp;&nbsp;</TD>';
        echo "<TD><INPUT TYPE=\"text\" NAME=\"odb\" VALUE=\"$edytodb\">";
        echo '</TD></TR><TR><TD VALIGN="top">Treœæ:&nbsp;&nbsp;</TD><TD>';
        echo '<TEXTAREA NAME="tresc" COLS="50" ROWS="4">';
        echo $edyttresc;
        echo '</TEXTAREA></TD></TR><TR><TD COLSPAN="2" ALIGN="center">';
        echo '<INPUT TYPE="submit" VALUE="Wyœlij"></TD></TR></TABLE></FORM>';
      } else {
        prosbalog ('wysy³aæ wiadomoœci');
      }
    ?>
  </BODY>
</HTML>
