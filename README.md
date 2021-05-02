# #############################################
# # Passo a passo para a execução do projeto ##
# #############################################

# 1 - Instale o docker 

https://docs.docker.com/get-docker/

# 2 - Clone o repositório do Github

https://docs.github.com/pt/github/creating-cloning-and-archiving-repositories/cloning-a-repository

# 3 - Suba o docker Sail. A partir da pasta raiz do projeto:
    vendor/bin/sail up


# 4 - Dentro do sail, execute:
    - composer install

# 5 - Faça uma cópia do arquivo .env.example e faça a configuração do banco de dados.

# 6 - Dentro da raiz do projeto, use o comando para rodar as migrations:
    vendor/bin/sail artisan migrate

