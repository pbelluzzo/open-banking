# #############################################
# # Passo a passo para a execução do projeto ##
# #############################################

# 1 - Instale o docker 

https://docs.docker.com/get-docker/

# 2 - Clone o repositório do Github

https://docs.github.com/pt/github/creating-cloning-and-archiving-repositories/cloning-a-repository

# 3 - Faça uma cópia do arquivo .env.example e renomeie como .env

# 4 - Use o comando a seguir para instalar as dependencias via composer
    docker run --rm -v $(pwd):/opt -w /opt laravelsail/php80-composer:latest composer install

# 5 - Suba o docker Sail. A partir da pasta raiz do projeto:
    vendor/bin/sail up

# 6 - Utilize o comando para entrar no container docker:
    docker-compose exec laravel.test bash

# 7 - Utilize o comando para gerar a chave do aplicativo:
    php artisan key:generate

# 8 - Use o comando a seguir para instalar as dependencias via npm
    npm install

# 9 - Utilize o comando a seguir para processar as instruções do webpack.mix
    npm run dev

# 10 - Utilize o comando a seguir para rastrear as mudanças nos arquivos do frontend
    npm run watch-poll

# 11 - Dentro da raiz do projeto, use o comando para rodar as migrations:
    php artisan migrate

# 12 - Use o arquivo de texto dbexample, presente na pasta raiz do projeto, para criar os dados de teste no banco de dados.

# 13 - Ao acessar a aplicação, os seguintes usuários estão disponíveis:
    login: testInstitution  senha: password
    login: testInstitution2 senha: password
    login: testClient       senha: password


# ---------------------------------------------------------------------------------------------------

# Para rodar os feature tests, utilize o seguinte comando na pasta raiz do projeto:
    vendor/bin/sail artisan test

    Opcionalmente, use o parametro --filter ao final para filtrar o teste ou entidade de testes a ser executado.

    vendor/bin/sail artisan test --filter ClientsTest