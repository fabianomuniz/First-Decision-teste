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
- **Usuário:** test@example.com
- **Senha:** password

## API RESTful Protegida

A API segue o padrão RESTful e utiliza tokens Bearer (Laravel Sanctum) para autenticação. Todas as respostas seguem uma estrutura padronizada:

```json
{
  "data": mixed,      // Dados da resposta (objeto, array ou null)
  "message": string,  // Mensagem descritiva
  "errors": mixed     // Detalhes de erros (ou null em caso de sucesso)
}
```

### 1. Autenticação (Login)

Para acessar os endpoints protegidos, primeiro você deve obter um token.

**Endpoint:** `POST /api/login`

**Exemplo de Requisição (cURL):**
```bash
curl -X POST http://localhost/api/login \
  -H "Accept: application/json" \
  -d "email=test@example.com" \
  -d "password=password"
```

**Exemplo de Resposta de Sucesso (200 OK):**
```json
{
  "data": {
    "token": "2|u7sZHfhkFB0DBirYBaIJpNiqJRvbFxcD0VzzwkoQf90969e3",
    "type": "Bearer",
    "user": {
      "id": 1,
      "name": "Test User",
      "email": "test@example.com",
      ...
    }
  },
  "message": "Login realizado com sucesso.",
  "errors": null
}
```

### 2. Listar Produtos

Utilize o token obtido no passo anterior para listar os produtos.

**Endpoint:** `GET /api/produtos`
**Header:** `Authorization: Bearer {SEU_TOKEN}`

**Exemplo de Requisição (cURL):**
```bash
# Substitua o token abaixo pelo que você recebeu no login
curl -X GET http://localhost/api/produtos \
  -H "Authorization: Bearer 2|u7sZHfhkFB0DBirYBaIJpNiqJRvbFxcD0VzzwkoQf90969e3" \
  -H "Accept: application/json"
```

**Exemplo de Resposta de Sucesso (200 OK):**
```json
{
  "data": {
    "current_page": 1,
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
    "first_page_url": "...",
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "total": 1
  },
  "message": "Produtos recuperados com sucesso.",
  "errors": null
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
          "email": "test@example.com",
          "password": "password"
        }
        ```
    *   Clique em **Send**. Copie o `token` retornado no corpo da resposta (ex: `2|u7sZHfhk...`).

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
          "email": "test@example.com",
          "password": "password"
        }
        ```
    *   Clique em **Send**. Copie o `token` retornado.

2.  **Requisições Protegidas (ex: Listar Produtos):**
    *   Crie uma nova requisição `GET` para `http://localhost/api/produtos`.
    *   Vá na aba **Auth**.
    *   Selecione **Bearer Token**.
    *   Cole o token no campo **Token**.
    *   Clique em **Send**.

## Tecnologias

- **PHP:** 8.2+
- **Laravel:** 12.x
- **Node.js** & **NPM**
- **MySQL:** 8.4
- **Docker** e **Docker Compose**

## Observações

- O banco de dados é inicializado automaticamente com dados de autenticação através dos seeders do Laravel.
- São gerados 50 produtos fictícios para popular a tabela inicial de produtos.
- O campo "Preço (R$)" aceita apenas números no formato float.
