<HTML>
  <HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=x-cp1250">
    <META NAME="author" CONTENT="Jan Mleczko">
    <TITLE>Rejestracja - Czat pomi�dzy u�ytkownikami</TITLE>
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
    <H2>Rejestracja</H2>
    <?php
      # Skrypt rejestruj�cy
      
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
          $opisbledu = "Nie wpisa�e� nazwy u�ytkownika.";
        } else if (strlen ($nazwa) > 10) {
          $opisbledu = "Za d�uga nazwa u�ytkownika.";
        } else if (!($haslo1 && $haslo2)) {
          $opisbledu = "Nie wpisa�e� has�a.";
        } else if (strlen ($haslo1) < 3) {
          $opisbledu = "Za kr�tkie has�o.";
        } else if (strlen ($haslo1) > 20) {
          $opisbledu = "Za d�ugie has�o.";
        } else if ($haslo1 != $haslo2) {
          $opisbledu = "Has�a si� nie zgadzaj�.";
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
            $opisbledu = "Taki u�ytkownik ju� istnieje.";
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
          <TD>Nazwa u�ytkownika:&nbsp;&nbsp;</TD>
          <TD><INPUT TYPE="text" NAME="nazwa"></TD>
        </TR><TR>
          <TD></TD>
          <TD><EM>Nazwa u�ytkownika mo�e mie�
          co najwy�ej 10 znak�w.</EM>
          <BR><BR></TD>
        </TR><TR>
          <TD>Has�o:&nbsp;&nbsp;</TD>
          <TD><INPUT TYPE="password" NAME="has1"></TD>
        </TR><TR>
          <TD>Has�o jeszcze raz:&nbsp;&nbsp;</TD>
          <TD><INPUT TYPE="password" NAME="has2"></TD>
        </TR><TR>
          <TD></TD>
          <TD><EM>Has�o musi mie� od 3 do 20 znak�w.
          Dla pewno�ci wpisz je dwukrotnie.</EM>
          <BR><BR></TD>
        </TR><TR>
          <TD COLSPAN="2" ALIGN="center">
            <INPUT TYPE="submit" VALUE="Zarejestruj si�">
          </TD>
        </TR>
      </TABLE>
    </FORM>
  </BODY>
</HTML>

