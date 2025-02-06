# PromptProfile

Webová aplikácia pre komplexný manažment profilov postáv. Používa Laravel a Typescript.

## Požiadavky

- PHP 8.1+
- Node.js 18+
- MySQL
- Composer
- Laravel 11.34.2
- TypeScript

## Inštalácia

1. Naklonujte repozitár
2. Nainštalujte závislosti PHP:
```bash
composer install
```

3. Nainštalujte a spustite frontend:
```bash
npm install
npm run build
```

4. Nastavte svoju MySQL databázu a .env súbor 


5. Generujte kľúč aplikácie a spustite migrácie:
```bash
php artisan key:generate
php artisan migrate
```

6. Spustite backend:
```bash
php artisan serve
```
