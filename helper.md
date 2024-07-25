1. Włączamy server za pomocą `php artisan serve` (it takes some good time)
2. Lista wszystkich routingów `php artistan route:list`
3. layouts -> tam dajemy wspólne el. html, które będa dziedziczone w blades
4. dodanie bazy danych: zmiana portu w dockerfile na 3305, w `.env` na 3305, zmieniamy w `.env` to `DB_DATABASE=laravel-10-task-list` zatrzymujemy server i robimy `php artisan migrate` Później piszemy `yes` gdy zapyta się czy stworzyć nową bazę. 
5. Jak mieliśmy otwartego `Adminer` to trzeba zamknąć i otworzyć przeglądarkę na `http://localhost:8080` i powinna być baza danych `laravel-10...` Ona ma też kilka defaultowych kolumn
6. Tworzenie modelu: `php artisan make:model Task -m` Task= nazwa modelu, `-m` -> stworzy całą migrację dla niego (ale jeszcze nie ma żadnych zmian w DB)
7. W laravel jak model jest Task, to tabela w DB będzie się nazywała 'tasks' (plural). Dlatego też Model "Task" będzie wiedział ze ma się odwoływać do tabeli 'tasks"
8. W ./database/migrations są migrations. One za pomocą php tworzą tabele w DB, są jakby vcs bazy danych. Można tworzyć, zmieniać ususwać kolumny za pom. php
9. W *Migration*  funkcja `up` -> coś wykonuję na tabelach. Funkcja `down` cofam
10. Migracje można też wykonać za pomocą komendy `php artisan make:migration` (ale nie mówił nic więcej o tym)
11. Po wykonaniu Modelu za pomocą komendy z p.6. , wchodizmy do ./Database/Migrations i szukamy tej migracji. Wewnątrz niej w funkcji `up` tworzymy potrzebne nowe kolumny. Żeby zastosować *Migration* wykonujemy komendę `php artisan migrate`
12. Aby zrobic roll-back to sosujemu `php artisan migrate:rollback`
13. Tworzenie fake-data w bazie danych. Wykorzysutjemy ./Database/factories i ./Database/seeders. W *Seeder* ładujemy dane do bazy danych; uruchamiamy factory. W *UserFactory* ustalamy jakie mają być wartości
14. Komenda do uruchomienia *seed* `php artisan db:seed` . *Ta komenda zawsze doda nowe dane do DB*. 
15. *Tworzenie factory dla nowego modelu #Nigdy na PROD!#* , w naszym przypadku Task komenda: `php artisan make:factory TaskFactory --model=Task` Tam wypełniamy jakimi fakowymi danymi ma być wypełniony obiekt. Następnie w `seeders` podajemy  ścieżke do Factory dla danego obiektu (u nas Task); podajemy ile ma być linii, i metodę `create`
15. 1. Komenda na dodanie do bazy danych `php artisan db:seed` ale to doda nowe rekordy w DB
15. 2. W przypadku, gdy już mamy jakies dane w DB (i nie chcemy żeby nowi Userzy się dodali przy dodawaniu np. Tasków) wykonujemy komndę: `php artisan migrate:refresh --seed` To robi roll-backa na wszystko i tworzy nową bazę danych.