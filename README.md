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

## API – Teste

### Autenticação

As rotas da API são protegidas via token de autenticação.
Para obter um token, utilize o endpoint de login com o usuário padrão gerado pelo seeder:

#### Login
`POST /api/login`

**Body (JSON):**
```json
{
  "email": "test@example.com",
  "password": "password"
}
```

**Resposta: 200 OK**
```json
{
  "token": "2LjQHd2NHFvghXi2za5eKfW2...a4a063a",
  "type": "Bearer",
  "user": {
    "id": 1,
    "name": "Test User",
    "email": "test@example.com"
  }
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost/api/login \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'
```

### Produtos

Todas as rotas abaixo requerem autenticação via token.
Inclua o header:
`Authorization: Bearer TOKEN`

#### Listar produtos
`GET /api/produtos`

**Exemplo:**
```bash
curl -X GET http://localhost/api/produtos \
  -H "Accept: application/json" \
  -H "Authorization: Bearer TOKEN"
```

**Resposta: 200 OK**
```json
{
	"data": [
		{
			"id": 1,
			"nome": "Produto Exemplo",
			"descricao": "Descrição do produto.",
			"preco": 100.00,
			"quantidade_estoque": 10,
			"created_at": "2025-12-23T02:06:16.000000Z",
			"updated_at": "2025-12-23T02:33:47.000000Z"
		}
	],
	"message": "Produtos recuperados com sucesso."
}
```

#### Buscar produto por ID
`GET /api/produtos/{id}`

**Exemplo:**
```bash
curl -X GET http://localhost/api/produtos/1 \
  -H "Accept: application/json" \
  -H "Authorization: Bearer TOKEN"
```

**Resposta: 200 OK**
```json
{
  "data": {
    "id": 1,
    "nome": "Produto Exemplo",
    "descricao": "Descrição do produto.",
    "preco": 100.00,
    "quantidade_estoque": 10,
    "created_at": "2025-12-23T01:16:33.000000Z",
    "updated_at": "2025-12-23T01:16:33.000000Z"
  },
  "message": "Produto recuperado com sucesso."
}
```

#### Criar produto
`POST /api/produtos`

**Body (JSON):**
```json
{
  "nome": "Mouse Logitech",
  "descricao": "Mouse sem fio",
  "preco": 100,
  "quantidade_estoque": 2
}
```

**Resposta: 201 Created**
```json
{
	"data": {
		"id": 51,
		"nome": "Mouse Logitech",
		"descricao": "Mouse sem fio",
		"preco": 100,
		"quantidade_estoque": 2,
		"created_at": "2025-12-23T11:35:15.000000Z",
		"updated_at": "2025-12-23T11:35:15.000000Z"
	},
	"message": "Produto criado com sucesso."
}
```

#### Atualizar produto
`PUT /api/produtos/{id}`

**Body (JSON):**
```json
{
  "nome": "Teclado Corsair",
  "descricao": "Teclado sem fio",
  "preco": 150,
  "quantidade_estoque": 5
}
```

**Resposta: 200 OK**
```json
{
	"data": {
		"id": 51,
		"nome": "Teclado Corsair",
		"descricao": "Teclado sem fio",
		"preco": 150,
		"quantidade_estoque": 5,
		"created_at": "2025-12-23T01:16:33.000000Z",
		"updated_at": "2025-12-23T11:36:31.000000Z"
	},
	"message": "Produto atualizado com sucesso."
}
```

#### Excluir produto
`DELETE /api/produtos/{id}`

**Exemplo:**
```bash
DELETE /api/produtos/51
```

**Resposta: 200 OK**
```json
{
    "message": "Produto excluído com sucesso."
}
```

## Testando via Insomnia ou Postman

1. Faça o login para gerar o token JWT.
2. Copie o valor do campo token retornado.
3. Adicione o token no header `Authorization`: `Bearer TOKEN`.
4. Teste as rotas de listagem, criação, atualização e exclusão.

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
