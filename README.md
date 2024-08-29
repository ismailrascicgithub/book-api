# Book API

Ovo je jednostavan RESTful API za upravljanje knjigama. API podržava operacije za kreiranje, čitanje, ažuriranje i brisanje knjiga, kao i pretragu i paginaciju knjiga. Također, API podržava JWT autentifikaciju.

## Preduslovi

- PHP 7.4 ili noviji
- Composer
- MySQL
- Postman (za testiranje API zahtjeva)

## Pokretanje php koda 

1. **Klonirajte repozitorij u `htdocs` folder vašeg servera:**

   git clone https://github.com/ismailrascicgithub/book-api.git
   cd book-api
   composer install
   cp .env.example .env

## Pokretanje SQL skripte

1. **Pokrenite SQL skriptu za kreiranje tabele `books`:** U phpMyAdmin, odaberite opciju **Databases** da kreirate novu bazu podataka (ako već ne postoji), a zatim idite na karticu **Import**, izaberite `books.sql` datoteku i kliknite na **Go** kako biste kreirali tabelu i inicijalne podatke.

## Postman Kolekcija

### Uvoz Postman kolekcije

1. Otvorite Postman.
2. Kliknite na dugme **Import**.
3. Odaberite **Upload Files** i pronađite `BOOK API COLLECTION.postman_collection.json` datoteku.
4. Kliknite na **Import**.

### Korištenje Postman kolekcije

Nakon uvoza, vidjet ćete kolekciju pod nazivom **Book API**. Unutar nje ćete pronaći sljedeće rute:

- `GET /api/books` - Dohvata sve knjige.
- `GET /api/books/{id}` - Dohvata knjigu prema ID-u.
- `POST /api/books` - Kreira novu knjigu.
- `PUT /api/books/{id}` - Ažurira knjigu prema ID-u.
- `DELETE /api/books/{id}` - Briše knjigu prema ID-u.
- `POST /api/auth/token` - Generira JWT token.

Prije slanja `POST`, `PUT` ili `DELETE` zahtjeva, osigurajte da je autentifikacija postavljena. Postavite **Authorization** na **Bearer Token** i unesite JWT token koji dobijete iz `POST /api/auth/token` zahtjeva.

## Postman Kolekcija

U root direktoriju projekta nalazi se Postman kolekcija pod nazivom `BOOK API COLLECTION.postman_collection.json`. Ova kolekcija sadrži sve potrebne API zahtjeve za testiranje funkcionalnosti vašeg Book API-ja.

### Uvoz Postman kolekcije

1. Otvorite Postman.
2. Kliknite na dugme **Import**.
3. Odaberite **Upload Files** i pronađite `BOOK API COLLECTION.postman_collection.json` datoteku.
4. Kliknite na **Import**.

### Korištenje Postman kolekcije

Nakon uvoza, vidjet ćete kolekciju pod nazivom **Book API**. Unutar nje ćete pronaći sljedeće rute:

- `GET /api/books` - Dohvata sve knjige.
- `GET /api/books/{id}` - Dohvata knjigu prema ID-u.
- `POST /api/books` - Kreira novu knjigu.
- `PUT /api/books/{id}` - Ažurira knjigu prema ID-u.
- `DELETE /api/books/{id}` - Briše knjigu prema ID-u.
- `POST /api/auth/token` - Generira JWT token.

Prije slanja `POST`, `PUT` ili `DELETE` zahtjeva, osigurajte da je autentifikacija postavljena. Postavite **Authorization** na **Bearer Token** i unesite JWT token koji dobijete iz `POST /api/auth/token` zahtjeva.

> **Napomena:** Ovdje je opisan način pokretanja koji ja lično preferiram. Korisnici mogu koristiti i druge metode za pokretanje i testiranje API-ja, ako im više odgovara.

