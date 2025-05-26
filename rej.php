<HTML>
  <HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=x-cp1250">
    <META NAME="author" CONTENT="Jan Mleczko">
    <TITLE>Rejestracja - Czat pomiêdzy u¿ytkownikami</TITLE>
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
    <H2>Rejestracja</H2>
    <?php
      # Skrypt rejestruj¹cy
      
      $nazwa = False;
      if (isset ($_POST['nazwa'])) {
        $nazwa = $_POST['nazwa'];
      }
      $haslo1 = False;
      if (isset ($_POST['has1'])) {
        $haslo1 = $_POST['has1'];
      }
      $haslo2 = False;
      if (isset ($_POST['has2'])) {
        $haslo2 = $_POST['has2'];
      }
      
      if ($nazwa || $haslo1 || $haslo2) {
        $blad = True;
        if (!$nazwa) {
          $opisbledu = "Nie wpisa³eœ nazwy u¿ytkownika.";
        } else if (strlen ($nazwa) > 10) {
          $opisbledu = "Za d³uga nazwa u¿ytkownika.";
        } else if (!($haslo1 && $haslo2)) {
          $opisbledu = "Nie wpisa³eœ has³a.";
        } else if (strlen ($haslo1) < 3) {
          $opisbledu = "Za krótkie has³o.";
        } else if (strlen ($haslo1) > 20) {
          $opisbledu = "Za d³ugie has³o.";
        } else if ($haslo1 != $haslo2) {
          $opisbledu = "Has³a siê nie zgadzaj¹.";
        } else {
          $plik = fopen ('uzytk.txt', 'r');
          flock ($plik, LOCK_EX);
          $znal = False;
          while ($wiersz = chop (fgets ($plik, 200))) {
            $istniejacy = rtrim (substr ($wiersz, 0, 10));
            if ($istniejacy == $nazwa) {
              $znal = True;
              break;
            }
          }
          flock ($plik, LOCK_UN);
          fclose ($plik);
          if ($znal) {
            $opisbledu = "Taki u¿ytkownik ju¿ istnieje.";
          } else {
            $zapis = $nazwa;
            while (strlen ($zapis) < 10)
              $zapis .= ' ';
            $zapis .= md5 ($haslo1);
            $zapis .= "\r\n";
            $plik = fopen ('uzytk.txt', 'a');
            flock ($plik, LOCK_EX);
            fputs ($plik, $zapis);
            flock ($plik, LOCK_UN);
            fclose ($plik);
            $blad = False;
          }
        }
        
        if ($blad) {
          echo "<P CLASS=\"czerswiatlo\">$opisbledu</P>";
        } else {
          echo '<P CLASS="zielswiatlo">Rejestracja udana.</P>';
        }
      }
    ?>
    <FORM METHOD="POST">
      <TABLE>
        <TR>
          <TD>Nazwa u¿ytkownika:&nbsp;&nbsp;</TD>
          <TD><INPUT TYPE="text" NAME="nazwa"></TD>
        </TR><TR>
          <TD></TD>
          <TD><EM>Nazwa u¿ytkownika mo¿e mieæ
          co najwy¿ej 10 znaków.</EM>
          <BR><BR></TD>
        </TR><TR>
          <TD>Has³o:&nbsp;&nbsp;</TD>
          <TD><INPUT TYPE="password" NAME="has1"></TD>
        </TR><TR>
          <TD>Has³o jeszcze raz:&nbsp;&nbsp;</TD>
          <TD><INPUT TYPE="password" NAME="has2"></TD>
        </TR><TR>
          <TD></TD>
          <TD><EM>Has³o musi mieæ od 3 do 20 znaków.
          Dla pewnoœci wpisz je dwukrotnie.</EM>
          <BR><BR></TD>
        </TR><TR>
          <TD COLSPAN="2" ALIGN="center">
            <INPUT TYPE="submit" VALUE="Zarejestruj siê">
          </TD>
        </TR>
      </TABLE>
    </FORM>
  </BODY>
</HTML>

