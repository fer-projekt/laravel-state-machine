# Laravel State Machine

This package simplify controlling the transition between model states, allowing you to prevent unlogically transition and also controlling the initial state of the model using the PHP enums. 

Each enum allows you to define your states, the allowed transitions and the initial state, all in one place.

## Installation

You can install the package via composer:

```bash
composer require fer-projekt/laravel-state-machine
```

## Usage

## Development

Clone the package from the github:

```bash
git clone https://github.com/fer-projekt/laravel-state-machine.git

cd laravel-state-machine
```

Starting & stopping docker

```bash
docker-compose up -d
```

```bash
docker-compose down
```

Install dependencies via composer and testing:

```bash
docker-compose exec app bash
```

```bash
composer update
```

```bash
phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
