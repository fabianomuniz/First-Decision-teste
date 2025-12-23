# Gerenciador de Produtos

Este é um projeto de teste técnico para a vaga de Desenvolvedor PHP (Laravel), implementando um sistema de gerenciamento de produtos com autenticação, API e interface web.

## Tecnologias Utilizadas

- **Laravel 11**: Framework PHP principal.
- **Docker & Docker Compose**: Para ambiente de desenvolvimento containerizado.
- **Laravel Breeze**: Para autenticação (login, registro, recuperação de senha).
- **Laravel Sanctum**: Para autenticação de API.
- **MySQL**: Banco de dados relacional.
- **PHPUnit**: Para testes automatizados.
- **Tailwind CSS**: Para estilização da interface web (via Breeze).

## Pré-requisitos

- Docker e Docker Compose instalados.

## Instalação e Configuração

1.  **Clone o repositório:**
    ```bash
    git clone <url-do-repositorio>
    cd first-decision-teste
    ```

2.  **Configure as variáveis de ambiente:**
    Copie o arquivo `.env.example` para `.env`:
    ```bash
    cp .env.example .env
    ```

3.  **Instale as dependências via Docker (Sail):**
    Este comando irá instalar as dependências do Composer usando um container temporário.
    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php84-composer:latest \
        composer install --ignore-platform-reqs
    ```

4.  **Inicie o ambiente Docker:**
    ```bash
    ./vendor/bin/sail up -d
    ```
    *Nota: Se você não tiver o alias `sail` configurado, use `./vendor/bin/sail`. Recomendamos criar um alias: `alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'`*

5.  **Gere a chave da aplicação:**
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

6.  **Execute as migrações e seeders:**
    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```

## Executando a Aplicação

- A aplicação estará acessível em: [http://localhost](http://localhost)
- O Mailpit (para visualizar emails) estará acessível em: [http://localhost:8025](http://localhost:8025)

## Executando Testes

Para executar os testes automatizados (Unitários e Feature):

```bash
./vendor/bin/sail artisan test
```

## API

A API segue os princípios REST e retorna respostas em formato JSON.

### Autenticação

Para acessar os endpoints protegidos, é necessário enviar o token de autenticação no header `Authorization`: `Bearer <seu-token>`.
*Nota: Para obter um token, você pode criar um endpoint de login específico para API ou usar a autenticação de sessão do Laravel Sanctum para SPAs.*

### Endpoints de Produtos

- **GET /api/produtos**: Lista todos os produtos (com paginação e filtros).
- **POST /api/produtos**: Cria um novo produto.
- **GET /api/produtos/{id}**: Exibe detalhes de um produto.
- **PUT /api/produtos/{id}**: Atualiza um produto.
- **DELETE /api/produtos/{id}**: Remove um produto.

### Estrutura de Resposta

Sucesso:
```json
{
    "data": { ... },
    "message": "Mensagem de sucesso"
}
```

Erro de Validação (padrão Laravel):
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "campo": ["Erro de validação"]
    }
}
```

## Funcionalidades Implementadas

- **CRUD de Produtos**: Web e API.
- **Autenticação**: Login, Registro, Logout.
- **Validação**: Request Form Validation para garantir integridade dos dados.
- **Busca e Filtros**: Pesquisa por nome/descrição e filtros por preço/estoque.
- **Testes**: Cobertura de testes para fluxos principais.
- **SOLID**: Uso de Service Pattern (`ProdutoService`) para isolar regras de negócio dos Controllers.
- **Localização**: Interface e mensagens em Português.
# First-Decision-teste
