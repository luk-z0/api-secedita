Requisitos principais
1. Docker
Obrigatório
Usado pelo Sail para subir containers (PHP, MySQL, Redis, etc.)

Instalação:

Linux: sudo apt install docker.io
Verificar:
docker --version
2. Docker Compose
Necessário para orquestrar os containers

Verificar:

docker compose version

Observação:

Versões mais novas do Docker já incluem o Compose
3. PHP (opcional)
Não é obrigatório para rodar com Sail
Mas útil para rodar comandos fora do container
4. Composer
Necessário para criar o projeto Laravel inicialmente

Verificar:

composer --version
Criando um projeto Laravel 12 com Sail
composer create-project laravel/laravel:^12.0 nome-do-projeto
cd nome-do-projeto
Instalando o Sail
php artisan sail:install

Durante a instalação você pode escolher:

MySQL ou PostgreSQL
Redis
Mailpit
Meilisearch
Subindo o ambiente
./vendor/bin/sail up -d

Ou criar alias:

alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'

Depois:

sail up -d
Rodando comandos dentro do container

Exemplos:

sail artisan migrate
sail artisan key:generate
sail npm install
sail npm run dev
Acessos padrão
Aplicação: http://localhost
Banco:
host: mysql
user: sail
password: password
Estrutura que o Sail sobe

Containers comuns:

app (Laravel + PHP)
mysql ou pgsql
redis (opcional)
mailpit (email fake)
node (build frontend)
Resumo direto

Para rodar Laravel 12 com Sail você precisa apenas:

Docker
Docker Compose
Composer

Todo o resto roda dentro dos containers.
