<?php
  $nazwau = False;
  if (isset ($_POST['nazwa'])) {
    $nazwau = $_POST['nazwa'];
  }
  $haslo = False;
  if (isset ($_POST['haslo'])) {
    $haslo = $_POST['haslo'];
    $hasz = md5 ($haslo);
  }
  $formularz = True;
  $dajzwrot = False;
  $izklasa = 'czerswiatlo';
  if ($nazwau && $haslo) {
    $dajzwrot = True;
    $znal = False;
    $plik = fopen ('uzytk.txt', 'r');
    flock ($plik, LOCK_EX);
    while ($wiersz = chop (fgets ($plik, 200))) {
      $nn = rtrim (substr ($wiersz, 0, 10));
      if ($nn == $nazwau) {
        $znal = True;
        $dbhasz = substr ($wiersz, 10, 32);
        break;
      }
    }
    flock ($plik, LOCK_UN);
    fclose ($plik);
    
    if ($znal) {
      if ($hasz == $dbhasz) {
        setcookie ('uzytk', "$nazwau");
        setcookie ('haslo', "$haslo");
        $infzwrot = "Logowanie udane.";
        $izklasa = 'zielswiatlo';
        $formularz = False;
      } else {
        $infzwrot = "Z³e has³o.";
      }
    } else {
      $infzwrot = "Nie ma takiego u¿ytkownika.";
    }
  }
?><HTML>
  <HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=x-cp1250">
    <META NAME="author" CONTENT="Jan Mleczko">
    <TITLE>Logowanie - Czat pomiêdzy u¿ytkownikami</TITLE>
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
    <H2>Logowanie</H2>
    <?php
      if ($dajzwrot) {
        echo "<P CLASS=\"$izklasa\">$infzwrot</P>";
      } else {
        if (isset ($_COOKIE['uzytk'])) {
          echo '<P>Ju¿ jesteœ zalogowany!</P>';
          $formularz = False;
        }
      }
      if ($formularz) {
    ?><FORM METHOD="POST">
      <TABLE>
        <TR>
          <TD>U¿ytkownik:&nbsp;&nbsp;</TD>
          <TD><INPUT TYPE="text" NAME="nazwa" AUTOFOCUS></TD>
        </TR><TR>
          <TD>Has³o:&nbsp;&nbsp;</TD>
          <TD><INPUT TYPE="password" NAME="haslo"></TD>
        </TR><TR>
          <TD COLSPAN="2" ALIGN="center">
            <BR><INPUT TYPE="submit" VALUE="Zaloguj siê">
          </TD>
        </TR>
      </TABLE>
    </FORM>
    <P>Nie masz konta? <A HREF="rej.php">Zarejestruj siê!</A></P>
    <?php
      }
    ?>
  </BODY>
</HTML>
