# Wykresix

## Wymagania środowiskowe

- PHP w wersji 8.2 lub nowszej
- Composer
- Symfony CLI
- Git

## Instalacja i uruchomienie projektu

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

### 4. Uruchomienie lokalnego serwera

```bash
symfony server:start
```

Aplikacja jest domyślnie dostępna pod adresem:

http://127.0.0.1:8000
