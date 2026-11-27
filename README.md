# Wykresix

## Wymagania środowiskowe

- PHP w wersji 8.4.1 lub nowszej (zalecana wersja 8.5, na której przetestowano projekt oraz odkomentowanie tych zależności z lab E)
- Włączone rozszerzenie PHP `pdo_mysql`
- Composer
- Symfony CLI
- Git
- Docker Desktop (lub Docker Engine z Docker Compose na Linuksie)

Nie jest wymagana lokalna instalacja MySQL Server ani MySQL Workbench, ponieważ baza danych uruchamiana jest w kontenerze Dockera.

## Pierwsze uruchomienie projektu

### 1. Sklonowanie repozytorium

```bash
git clone https://github.com/konradol03/wykresix.git
cd wykresix
```

### 2. Instalacja zależności PHP

```bash
composer install
```

### 3. Instalacja zależności frontendowych

```bash
php bin/console importmap:install
```

### 4. Uruchomienie bazy danych

Uruchom Docker Desktop lub usługę Docker, a następnie wykonaj:

```bash
docker compose up -d --wait
```

Przy pierwszym uruchomieniu Docker automatycznie pobierze obraz MySQL 8.4, utworzy kontener, wolumen do przechowywania danych oraz bazę danych `wykresix`.

### 5. Sprawdzenie połączenia z bazą danych

```bash
php bin/console dbal:run-sql "SELECT DATABASE(), VERSION()"
```

Polecenie powinno zwrócić nazwę bazy danych `wykresix` oraz wersję MySQL.

### 6. Uruchomienie migracji

Jeżeli w projekcie dostępne są już migracje, wykonaj:

```bash
php bin/console doctrine:migrations:migrate
```

Polecenie utworzy lub zaktualizuje strukturę lokalnej bazy danych na podstawie migracji dostępnych w repozytorium.

### 7. Uruchomienie lokalnego serwera

```bash
symfony server:start
```

Aplikacja jest domyślnie dostępna pod adresem:

[http://127.0.0.1:8000](http://127.0.0.1:8000)

## Konfiguracja bazy danych

Projekt wykorzystuje MySQL 8.4 uruchamiany w kontenerze Dockera. Konfiguracja znajduje się w plikach `compose.yaml` oraz `compose.override.yaml`.

Parametry połączenia:

| Parametr | Wartość |
|---|---|
| Host | 127.0.0.1 |
| Port | 3307 |
| Nazwa bazy danych | wykresix |
| Użytkownik | wykresix_user |
| Hasło deweloperskie | password |

Konfiguracja połączenia znajduje się w pliku `.env`. Jeżeli istnieje plik `.env.local`, należy upewnić się, że nie nadpisuje on konfiguracji bazy danych nieprawidłowymi wartościami.

Podane dane dostępowe przeznaczone są wyłącznie do lokalnego środowiska deweloperskiego.

### Mapowanie portów

W pliku `compose.override.yaml` zastosowano następujące mapowanie:

```yaml
ports:
  - "127.0.0.1:3307:3306"
```

- `127.0.0.1` – ograniczenie dostępu do bazy danych do lokalnego komputera.
- `3307` – port komputera, przez który aplikacja łączy się z bazą danych.
- `3306` – port MySQL wewnątrz kontenera.

Port 3307 został wybrany w celu uniknięcia konfliktu z lokalnie zainstalowanymi serwerami MySQL, które domyślnie korzystają z portu 3306.

**Przed uruchomieniem kontenera należy upewnić się, że port 3307 nie jest zajęty przez inną usługę.**

## Codzienna praca z projektem

### Rozpoczęcie pracy

Pobranie aktualnych zmian z repozytorium:

```bash
git pull
```

Uruchomienie bazy danych:

```bash
docker compose up -d --wait
```

Jeżeli zmieniły się zależności projektu (`composer.json` lub `composer.lock`), należy ponownie wykonać:

```bash
composer install
```

Jeżeli zmieniły się zależności frontendowe (`importmap.php`), należy wykonać:

```bash
php bin/console importmap:install
```

Jeżeli w repozytorium pojawiły się nowe migracje, należy wykonać:

```bash
php bin/console doctrine:migrations:migrate
```

Uruchomienie aplikacji:

```bash
symfony server:start
```

### Zakończenie pracy

Zatrzymaj serwer Symfony za pomocą `Ctrl+C`, a następnie zatrzymaj kontener:

```bash
docker compose down
```

Dane zapisane w bazie zostaną zachowane dzięki wykorzystaniu wolumenu Dockera. Przy kolejnym uruchomieniu kontenera będą ponownie dostępne.


## Praca z bazą danych

Każdy członek zespołu posiada własną lokalną bazę danych. Dane nie są
współdzielone pomiędzy członkami zespołu, natomiast struktura bazy danych
jest synchronizowana za pomocą migracji Doctrine.

Migracje to pliki opisujące zmiany w strukturze bazy danych, np. tworzenie
tabel, dodawanie kolumn lub tworzenie relacji. Znajdują się w katalogu
`migrations/`.

### Tworzenie i modyfikowanie encji

```bash
php bin/console make:entity
```

### Generowanie migracji

Po utworzeniu lub zmodyfikowaniu encji należy wygenerować migrację:

```bash
php bin/console make:migration
```

Przed wykonaniem migracji należy sprawdzić jej zawartość.

### Wykonywanie migracji

Aby zastosować zmiany w lokalnej bazie danych, należy wykonać:

```bash
php bin/console doctrine:migrations:migrate
```

Doctrine wykona wszystkie migracje, które nie zostały jeszcze zastosowane
w lokalnej bazie danych.

### Zasady pracy z migracjami

- Przed wygenerowaniem nowej migracji należy pobrać i wykonać dotychczasowe migracje.
- Wygenerowane migracje należy przesyłać do repozytorium razem ze zmianami encji.
- Po pobraniu nowych migracji z repozytorium należy je wykonać, a nie generować ponownie.
- Nie należy modyfikować ani usuwać wcześniej udostępnionych i wykonanych migracji.
- Nie należy ręcznie zmieniać struktury bazy danych.
