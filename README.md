## Setup

Standart Laravel stuff

fill `.env` file and run:

```bash
composer i
```

then

```bash
php artisan migrate --seed
```

### To work with backend

Run tests:

```bash
composer test
```

or

```bash
php artisan test
```

To check Code Quality, Static Analysis, Style and run tests:

```bash
composer check
```

### To work with frontend

just install [Bun](https://bun.sh) and run:

```bash
bun i
```

then

```bash
bun run dev
```

## API Integration

after creating/updating a client/order, a request is sent to the CRM system

also, client/order data is synchronized with the CRM system once an hour
