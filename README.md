# Grupo Plan Marketing

Desafio - Grupo Plan Marketing - Back/Front - Utilizando o conceito de API e WEB

## Servidor:
PHP 8.2.8 | MySQL 8.0 | Node 18.16.0

# Requisitos:
BackEnd
- `Laravel 10`

FrontEnd
- `Quasar 2.12.3 com VueJS`

## Clona os projetos

```
git clone https://github.com/rjcfj/grupo-plan-marketing.git -b main

```

## BackEnd
~~~~
cd grupo-plan-marketing/backend
composer update
php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan key:generate
~~~~

Inicie um servidor de desenvolvimento backend com `./vendor/bin/sail up -d`

~~~~
./vendor/bin/sail artisan migrate
~~~~

## FrontEnd

~~~~
cd grupo-plan-marketing/frontend
yarn ou npm install
~~~~

Inicie um servidor de desenvolvimento frontend com `yarn dev` ou `npm run dev`

## API:
#### JSON: Eletrodomésticos
http://localhost/api/eletrodomestico

#### JSON: Marcas
http://localhost/api/marca

## WEB:
#### Tela: Home
http://localhost:8080

#### Tela: Eletrodomésticos
http://localhost:8080/eletrodomestico

#### Tela: Marcas
http://localhost:8080/marca
