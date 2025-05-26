# Czat w PHP
Czat, tzn. serwis WWW służący wymianie wiadomości tekstowych między zarejestrowanymi użytkownikami napisany w PHP.

Grafika dymków czatu pochodzi z [OpenClipart](https://openclipart.org/detail/129049/chat).

## Zrzuty ekranu

![Strona powitalna](https://github.com/Jan-Mleczko/Czat-PHP/blob/main/zrz_czat/01.png?raw=true)
_Strona powitalna_

![Wiadomości odebrane](https://github.com/Jan-Mleczko/Czat-PHP/blob/main/zrz_czat/04.png?raw=true)
_Wiadomości odebrane_

![Rejestracja konta](https://github.com/Jan-Mleczko/Czat-PHP/blob/main/zrz_czat/02.png?raw=true)
_Rejestracja konta_

![Tworzenie wiadomości](https://github.com/Jan-Mleczko/Czat-PHP/blob/main/zrz_czat/03.png?raw=true)
_Tworzenie wiadomości_

## Funkcjonalności

* Standardowy system rejestracji i logowania użytkowników korzystający z _ciasteczek_ (ang. _cookies_). Użytkownik może się zarejestrować ustalając sobie nazwę użytkownika i hasło, potem zalogować się podając te dane, a następnie się wylogować i przyszłości zalogować się ponownie.
* Użytkownik może wysłać wiadomość tekstową do dowolnego użytkownika znając jego nazwę oraz otrzymywać wiadomości od innych.
* Użytkownik widzi wszystkie wiadomości, które kiedykolwiek dostał, jak również wysłane przez siebie wiadomosci.
* Przy otrzymanych wiadomościach jest możliwość szybkiego przejścia do pisania odpowiedzi bez konieczności ręcznego przepisywania nazwy drugiego użytkownika.
* Widok wiadomości odebranych jest automatycznie odświeżany, jeśli użytkownik tego zechce.

## Wymagania, instalacja

**UWAGA: Aplikacja nie jest przeznaczona do uruchomienia na publicznie dostępnym serwerze! Nie ma ona odpowiednich zabezpieczeń. Testuj ją w zaufanej sieci lokalnej.**

Na serwerze jest wymagane PHP w wersji conajmniej 4.

Serwis nie ma szczególnych wymagań co do przeglądarki ponad obsługę formularzy HTML i (opcjonalnie, dla ładnego wyglądu stron) arkuszy stylów CSS.

W celu uruchomienia serwisu wystarczy utworzyć katalog wewnątrz katalogu na strony serwera, np. `C:\apache\htdocs` w przypadku Apache dla Windows&reg; i pobrać do niego wszystkie pliki z repozytorium z wyjątkiem niniejszego readme i zrzutów ekranu. Główną stroną serwisu jest plik `index.htm`.

Są dwa wstępnie utworzone konta (chociaż rejestracja nowych jest zawsze możliwa przez stronę rejestracji):

* `Pierwszy` z hasłem `abcd123`
* `Drugi` z hasłem `efgh456`

Żeby usunąć wszystkie treści z serwisu, skorzystaj z pliku wsadowego `zeruj.bat`. Usunie on wszystkich użytkowników (włącznie z wstępnie utworzonymi) i wiadomości, ale serwis będzie nadal działał i będzie można rejestrować się on nowa.
