# First Decision Teste

Cadastro de produtos com Laravel.

## Requisitos

- Docker instalado e configurado
- Docker Compose instalado

## Instalação e Execução

1. Clone o repositório
   ```bash
   git clone https://github.com/fabianomuniz/First-Decision-teste.git
   cd first-decision-teste
   ```

2. Suba os containers com Docker Compose
   ```bash
   docker compose up --build -d
   ```
   Durante o processo de build, o Docker executará automaticamente as configurações necessárias.

## Acesso ao painel via WEB

- **URL:** http://localhost
- **Usuário:** teste@teste.com
- **Senha:** password

## API RESTful Protegida

A API segue o padrão RESTful e utiliza **JSON Web Tokens (JWT)** para autenticação. Todas as respostas seguem uma estrutura padronizada.

**Resposta Padrão:**

```json
{
  "data": mixed,      // Dados da resposta (objeto, array ou null)
  "message": string,  // Mensagem descritiva
  "errors": mixed     // Detalhes de erros (ou null em caso de sucesso)
}
```

**Resposta com Paginação:**

Quando o endpoint retorna uma lista paginada (ex: listar produtos), a estrutura inclui o campo `meta` e os itens ficam diretamente em `data`:

```json
{
  "data": [...],          // Array de itens
  "meta": { ... }         // Metadados da paginação (current_page, total, etc.)
}
```

### 1. Autenticação

#### Login
**Endpoint:** `POST /api/login`

**Exemplo de Requisição (cURL):**
```bash
curl -X POST http://localhost/api/login \
  -H "Accept: application/json" \
  -d "email=teste@teste.com" \
  -d "password=password"
```

**Exemplo de Resposta de Sucesso (200 OK):**
```json
{
  "data": {
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "token_type": "bearer",
    "expires_in": 3600
  },
  "message": "Success",
  "errors": null
}
```

#### Perfil do Usuário (Me)
**Endpoint:** `GET /api/me`
**Header:** `Authorization: Bearer {TOKEN}`

#### Atualizar Token (Refresh)
**Endpoint:** `POST /api/refresh`
**Header:** `Authorization: Bearer {TOKEN}`

#### Logout
**Endpoint:** `POST /api/logout`
**Header:** `Authorization: Bearer {TOKEN}`

### 2. Listar Produtos

Utilize o `access_token` obtido no login para acessar os endpoints protegidos.

**Endpoint:** `GET /api/produtos`
**Header:** `Authorization: Bearer {SEU_TOKEN}`

**Exemplo de Requisição (cURL):**
```bash
# Substitua o token abaixo pelo que você recebeu no login
curl -X GET http://localhost/api/produtos \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..." \
  -H "Accept: application/json"
```

**Exemplo de Resposta de Sucesso (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "nome": "Produto Exemplo",
      "descricao": "Descrição do produto.",
      "preco": "100.00",
      "quantidade_estoque": 10,
      "created_at": "...",
      "updated_at": "..."
    },
    ...
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 10,
    "total": 1
  }
}
```

### 3. Outras Operações (CRUD)

Você pode realizar operações de criação, atualização e exclusão utilizando os verbos HTTP correspondentes (`POST`, `PUT`, `DELETE`) e enviando o token no header.

**Criar Produto:** `POST /api/produtos`  
**Ver Produto:** `GET /api/produtos/{id}`  
**Atualizar Produto:** `PUT /api/produtos/{id}`  
**Excluir Produto:** `DELETE /api/produtos/{id}`

## Testando via Insomnia ou Postman

### Postman

1.  **Login (Obter Token):**
    *   Crie uma nova requisição `POST` para `http://localhost/api/login`.
    *   Na aba **Body**, selecione `raw` e escolha `JSON`.
    *   Insira o JSON de credenciais:
        ```json
        {
          "email": "teste@teste.com",
          "password": "password"
        }
        ```
    *   Clique em **Send**. Copie o `access_token` retornado no corpo da resposta.

2.  **Requisições Protegidas (ex: Listar Produtos):**
    *   Crie uma nova requisição `GET` para `http://localhost/api/produtos`.
    *   Vá na aba **Authorization**.
    *   No menu "Type", selecione **Bearer Token**.
    *   Cole o token copiado no campo **Token**.
    *   Clique em **Send**.

---

### Insomnia

1.  **Login (Obter Token):**
    *   Crie uma nova requisição `POST` para `http://localhost/api/login`.
    *   Na aba **Body**, selecione `JSON`.
    *   Insira o JSON de credenciais:
        ```json
        {
          "email": "teste@teste.com",
          "password": "password"
        }
        ```
    *   Clique em **Send**. Copie o `access_token` retornado.

2.  **Requisições Protegidas (ex: Listar Produtos):**
    *   Crie uma nova requisição `GET` para `http://localhost/api/produtos`.
    *   Vá na aba **Auth**.
    *   Selecione **Bearer Token**.
    *   Cole o token no campo **Token**.
    *   Clique em **Send**.

## Testes Automatizados

O projeto conta com uma suíte de testes automatizados (Feature Tests e Unit Tests) para garantir a integridade da aplicação.

Para executar os testes, utilize o seguinte comando no terminal (dentro do container ou ambiente configurado):

```bash
php artisan test
```

## Tecnologias

- **PHP:** 8.2+
- **Laravel:** 12.x
- **Node.js** & **NPM**
- **MySQL:** 8.4
- **Docker** e **Docker Compose**

## Observações

- O banco de dados é inicializado automaticamente com dados de autenticação através dos seeders do Laravel.
- São gerados 30 produtos fictícios para popular a tabela inicial de produtos.
