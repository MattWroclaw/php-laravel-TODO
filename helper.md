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
15. *Tworzenie factory dla nowego modelu* , w naszym przypadku Task komenda: `php artisan make:factory TaskFactory --model=Task` Tam wypełniamy jakimi fakowymi danymi ma być wypełniony obiekt. Następnie w `seeders` podajemy  ścieżke do Factory dla danego obiektu (u nas Task); podajemy ile ma być linii, i metodę `create`
15. 1. Komenda na dodanie do bazy danych `php artisan db:seed` ale to doda nowe rekordy w DB
15. 2. _Nigdy na PROD!_  W przypadku, gdy już mamy jakies dane w DB (i nie chcemy żeby nowi Userzy się dodali przy dodawaniu np. Tasków) wykonujemy komndę: `php artisan migrate:refresh --seed` To robi roll-backa na wszystko i tworzy nową bazę danych.
16. W web.php w kontorlerze odwołujemy się do Modelu (Task w naszym przykładzie) I tam korzystamy z metody statycznej `find()` . To jest w docu https://laravel.com/docs/11.x/queries#main-content 
Możemy zatrzymać server, i wpisać `php artisan tinker` i możemy pisać queries do applikacji. Np `\App\Models\Task::all();`  Możemy sobie sprawdzić czy mamy dobre query! ` \App\Models\Task::select('id' , 'title')->where('completed',true)->get() `
17. **Uwaga!! Kolejność kontrolerów ma znaczenie!!** Jak jest najpierw `/task/{id}` a potem zrobimy `/task/create` to się wysypie, 404!
18. `@csrf` że nie możne "zły skrypt" wysłać requesta na inny endpoint w imieniu tego zalogowanego usera. W kolejnym zdaniu mówi, że ktoś inny nie może za zalogowanego usra wysłać requestu na `tą` stronę. Ciekawostką jest to, że laravel dołącza do każdego forma inny token i będzie go veryfikował przy otrzymaniu danych z formularza. Jeśli zapomni się o `@csrf` dodać do formularza to jest błąd 419 (?) Można to excludnąć w `App\Middleware\VerifyCsrfToken.php`
19. W formularzu w <input> mamy `name=..` oraz `id=..`  Name -> odnosi się do danych dostarczony przez formularz; id -> łączy labelkę z Input'em, to znaczy, że jak ktoś kliknie na labelkę, to dany input będzie aktywny
20. Validation errors są przechowywane w User Session. W `Session` jest to sposób na zapisanie odwiedzin Usera na stronie, w serwisie. Tworzy się jak się loguje, niszczy się jak się wyloguje. Można przechowywać np. numer karty kredytowej. Nas interesuje `errors` które można wyświetlić oraz "flash messages" -> onSuccess. One są tylko w danej sessji.
21. 1. Kiedy wchodzisz na servis na Laravelu , to laravel tworzy session (przypisuje jakiś uniqueID). To jest przechowywane w cookie. Jak przechodzisz z widoku na widok, to zawsze to session też idzie. Na tej podstawie Laravel widzi że to ten sam user. Sessions są przechowywane w `./storage/framework/sessions`. Confifgurację przeprowadza się w `session.php` . Session dobrze jak jest przechowywana w `redis` a nie w file. Bo jak jest apka na kilku serverach to nie ma jak tego współdzielić.
20. 2. funkcja `session()` jest dostępna w blade i w `web.php`