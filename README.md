Budowa własnego framework'a. Projekt w budowie.

Idea projektu.:
Stworzyć szkielet infrastruktury routingu witryny internetowej, gdzie poszczególne kontrolery są definiowane w bazie danych.
Oprócz kontrolerów, także cała treść poszczególnych podstron w witrynie, w tym renderowanie stron HTML, plików PDF, pików graficznych (PNG, JPEG, GIF), mailingu (automatycznych treści maila), jest zapisywana w relacyjnej bazie danych, typu MariaDB lub Oracle PL/SQL. A nie jak to jest definiowane w znanych framework'ach Laravel czy w Symfony, w plikach projektu. Kolejną kwestią techniczną, którą chce poruszyć, a która nie jest jasno rozwiązana w framework'u Symfony i innych, jest podział funkcji w klasach projektu języka PHP, na funkcję deterministyczne – te które wykonują się cyklicznie, w określonym przedziale czasowym, a wynik ich działania jest zapisywany do pamięci podręcznej. I funkcje zwykłe – dynamiczne, wykonywane w czasie rzeczywistym. Jest to idea techniczna zaimplementowana do silników baz danych Oracle, i tę ideę techniczną ja chciałbym zaimplementować do języka PHP, tworząc własny oryginalny szkielet wzorca projektowego. Bez wątpienia, renderowane strony HTML, czy PDF, gdzie treść jest pobierana z bazy danych, jest znacznie szybsza, niż z plików serwera.

Autor projektu:

Adam Józef Demnicki. <adamdemnicki@gmail.com>

http://ad10.eu

http://www.fb.com/demnicki