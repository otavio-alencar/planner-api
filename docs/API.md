# API do Planner Virtual

Documentação das rotas disponíveis no back-end do Planner Virtual.

## Responsável

**Ricardo**

> Esta documentação será atualizada conforme novas funcionalidades forem integradas ao back-end.

---

## Sumário

- [Informações gerais](#informações-gerais)
- [Autenticação](#autenticação)
- [Padrão das respostas](#padrão-das-respostas)
- [Metas](#metas)
  - [Listar metas](#listar-metas)
  - [Buscar metas por descrição](#buscar-metas-por-descrição)
  - [Criar meta](#criar-meta)
  - [Consultar meta](#consultar-meta)
  - [Atualizar meta](#atualizar-meta)
  - [Excluir meta](#excluir-meta)
  - [Campos de meta](#campos-de-meta)
- [Lembretes](#lembretes)
  - [Listar lembretes](#listar-lembretes)
  - [Criar lembrete](#criar-lembrete)
  - [Consultar lembrete](#consultar-lembrete)
  - [Atualizar lembrete](#atualizar-lembrete)
  - [Excluir lembrete](#excluir-lembrete)
  - [Campos de lembrete](#campos-de-lembrete)
- [Códigos HTTP](#códigos-http)

---

# Informações gerais

## URL base local

```text
http://127.0.0.1:8000/api
```

Exemplo:

```http
GET http://127.0.0.1:8000/api/metas
```

## Formato dos dados

As requisições e respostas utilizam o formato JSON.

Cabeçalhos recomendados:

```http
Accept: application/json
Content-Type: application/json
```

O cabeçalho `Content-Type` deve ser enviado nas requisições que possuem corpo JSON, como `POST` e `PUT`.

---

# Autenticação

As rotas de metas e lembretes exigem autenticação por Bearer Token.

Cabeçalho obrigatório:

```http
Authorization: Bearer SEU_TOKEN
```

Exemplo completo:

```http
Authorization: Bearer 1|exemplo-de-token
Accept: application/json
Content-Type: application/json
```

Cada usuário autenticado deve acessar somente os próprios registros.

---

# Padrão das respostas

## Resposta com uma coleção

As rotas de listagem retornam os registros dentro da propriedade `data`.

```json
{
  "data": []
}
```

## Resposta com um único registro

```json
{
  "data": {
    "id": 1
  }
}
```

## Resposta após criação, atualização ou exclusão

As operações podem retornar uma mensagem indicando o resultado.

```json
{
  "message": "Operação realizada com sucesso."
}
```

Nas operações de criação e atualização, a resposta também apresenta o registro na propriedade `data`.

---

# Metas

As metas representam objetivos cadastrados pelo usuário.

## Resumo das rotas de metas

| Método | Rota | Descrição |
|---|---|---|
| `GET` | `/api/metas` | Lista as metas do usuário |
| `GET` | `/api/metas?busca={texto}` | Busca metas pela descrição |
| `POST` | `/api/metas` | Cria uma meta |
| `GET` | `/api/metas/{id}` | Consulta uma meta |
| `PUT` | `/api/metas/{id}` | Atualiza uma meta |
| `DELETE` | `/api/metas/{id}` | Exclui uma meta |

---

## Listar metas

Retorna todas as metas pertencentes ao usuário autenticado.

### Requisição

```http
GET /api/metas
```

Não possui corpo JSON.

### Resposta de sucesso

**Status:** `200 OK`

```json
{
  "data": [
    {
      "id": 1,
      "descricao": "Concluir o projeto",
      "status": "EM_ANDAMENTO",
      "periodo": "MENSAL",
      "data_inicio": "2026-07-01",
      "data_fim": "2026-07-31",
      "categoria": {
        "id": 1,
        "nome": "Faculdade",
        "cor": "#D45D8C"
      },
      "created_at": "2026-07-15T20:00:00.000000Z",
      "updated_at": "2026-07-15T20:00:00.000000Z"
    }
  ]
}
```

### Resposta sem metas cadastradas

```json
{
  "data": []
}
```

---

## Buscar metas por descrição

Busca metas cujo campo `descricao` contenha o texto informado.

A busca não exige correspondência exata. Por exemplo, o valor `projeto` pode encontrar a descrição `Finalizar projeto do planner`.

### Parâmetro de consulta

| Parâmetro | Tipo | Obrigatório | Descrição |
|---|---|---:|---|
| `busca` | string | Não | Texto procurado na descrição da meta |

### Requisição

```http
GET /api/metas?busca=projeto
```

Não possui corpo JSON.

### Resposta de sucesso

**Status:** `200 OK`

```json
{
  "data": [
    {
      "id": 2,
      "descricao": "Finalizar projeto do planner",
      "status": "EM_ANDAMENTO",
      "periodo": "MENSAL",
      "data_inicio": "2026-07-01",
      "data_fim": "2026-07-31",
      "categoria": {
        "id": 1,
        "nome": "Faculdade",
        "cor": "#D45D8C"
      },
      "created_at": "2026-07-15T20:00:00.000000Z",
      "updated_at": "2026-07-15T20:00:00.000000Z"
    }
  ]
}
```

### Resposta sem resultados

```json
{
  "data": []
}
```

---

## Criar meta

Cria uma nova meta para o usuário autenticado.

### Requisição

```http
POST /api/metas
```

### Corpo da requisição

```json
{
  "categoria_id": 1,
  "descricao": "Concluir o projeto",
  "status": "EM_ANDAMENTO",
  "periodo": "MENSAL",
  "data_inicio": "2026-07-01",
  "data_fim": "2026-07-31"
}
```

### Resposta de sucesso

**Status:** `201 Created`

```json
{
  "message": "Meta criada com sucesso.",
  "data": {
    "id": 1,
    "descricao": "Concluir o projeto",
    "status": "EM_ANDAMENTO",
    "periodo": "MENSAL",
    "data_inicio": "2026-07-01",
    "data_fim": "2026-07-31",
    "categoria": {
      "id": 1,
      "nome": "Faculdade",
      "cor": "#D45D8C"
    },
    "created_at": "2026-07-15T20:00:00.000000Z",
    "updated_at": "2026-07-15T20:00:00.000000Z"
  }
}
```

---

## Consultar meta

Retorna uma meta específica pertencente ao usuário autenticado.

### Parâmetro da rota

| Parâmetro | Tipo | Descrição |
|---|---|---|
| `id` | integer | Identificador da meta |

### Requisição

```http
GET /api/metas/{id}
```

Exemplo:

```http
GET /api/metas/1
```

Não possui corpo JSON.

### Resposta de sucesso

**Status:** `200 OK`

```json
{
  "data": {
    "id": 1,
    "descricao": "Concluir o projeto",
    "status": "EM_ANDAMENTO",
    "periodo": "MENSAL",
    "data_inicio": "2026-07-01",
    "data_fim": "2026-07-31",
    "categoria": {
      "id": 1,
      "nome": "Faculdade",
      "cor": "#D45D8C"
    },
    "created_at": "2026-07-15T20:00:00.000000Z",
    "updated_at": "2026-07-15T20:00:00.000000Z"
  }
}
```

---

## Atualizar meta

Atualiza os dados de uma meta pertencente ao usuário autenticado.

### Parâmetro da rota

| Parâmetro | Tipo | Descrição |
|---|---|---|
| `id` | integer | Identificador da meta |

### Requisição

```http
PUT /api/metas/{id}
```

Exemplo:

```http
PUT /api/metas/1
```

### Corpo da requisição

```json
{
  "categoria_id": 1,
  "descricao": "Concluir e apresentar o projeto",
  "status": "CUMPRIDA",
  "periodo": "MENSAL",
  "data_inicio": "2026-07-01",
  "data_fim": "2026-07-31"
}
```

### Resposta de sucesso

**Status:** `200 OK`

```json
{
  "message": "Meta atualizada com sucesso.",
  "data": {
    "id": 1,
    "descricao": "Concluir e apresentar o projeto",
    "status": "CUMPRIDA",
    "periodo": "MENSAL",
    "data_inicio": "2026-07-01",
    "data_fim": "2026-07-31",
    "categoria": {
      "id": 1,
      "nome": "Faculdade",
      "cor": "#D45D8C"
    },
    "created_at": "2026-07-15T20:00:00.000000Z",
    "updated_at": "2026-07-16T01:38:19.000000Z"
  }
}
```

---

## Excluir meta

Exclui uma meta pertencente ao usuário autenticado.

### Parâmetro da rota

| Parâmetro | Tipo | Descrição |
|---|---|---|
| `id` | integer | Identificador da meta |

### Requisição

```http
DELETE /api/metas/{id}
```

Exemplo:

```http
DELETE /api/metas/1
```

Não possui corpo JSON.

### Resposta de sucesso

**Status:** `200 OK`

```json
{
  "message": "Meta excluída com sucesso."
}
```

---

## Campos de meta

| Campo | Tipo | Obrigatório | Formato ou valores aceitos | Descrição |
|---|---|---:|---|---|
| `categoria_id` | integer | Sim | ID de uma categoria existente | Categoria relacionada à meta |
| `descricao` | string | Sim | Texto | Descrição da meta |
| `status` | string | Sim | `EM_ANDAMENTO`, `CUMPRIDA`, `PARCIAL`, `NAO_CUMPRIDA` | Situação atual da meta |
| `periodo` | string | Sim | `SEMANAL`, `MENSAL`, `ANUAL` | Período de acompanhamento |
| `data_inicio` | date | Sim | `AAAA-MM-DD` | Data inicial da meta |
| `data_fim` | date | Sim | `AAAA-MM-DD` | Data final da meta |

### Valores aceitos para `status`

```text
EM_ANDAMENTO
CUMPRIDA
PARCIAL
NAO_CUMPRIDA
```

### Valores aceitos para `periodo`

```text
SEMANAL
MENSAL
ANUAL
```

---

# Lembretes

Os lembretes representam compromissos ou avisos cadastrados pelo usuário.

## Resumo das rotas de lembretes

| Método | Rota | Descrição |
|---|---|---|
| `GET` | `/api/lembretes` | Lista os lembretes |
| `POST` | `/api/lembretes` | Cria um lembrete |
| `GET` | `/api/lembretes/{id}` | Consulta um lembrete |
| `PUT` | `/api/lembretes/{id}` | Atualiza um lembrete |
| `DELETE` | `/api/lembretes/{id}` | Exclui um lembrete |

---

## Listar lembretes

Retorna todos os lembretes pertencentes ao usuário autenticado.

Os lembretes são apresentados em ordem de data e hora.

### Requisição

```http
GET /api/lembretes
```

Não possui corpo JSON.

### Resposta de sucesso

**Status:** `200 OK`

```json
{
  "data": [
    {
      "id": 1,
      "descricao": "Reunião do projeto",
      "data_hora": "2026-07-20 19:00:00",
      "recorrente": false,
      "frequencia": null,
      "ativo": true,
      "categoria": {
        "id": 1,
        "nome": "Faculdade",
        "cor": "#D45D8C"
      },
      "created_at": "2026-07-16T01:35:18.000000Z",
      "updated_at": "2026-07-16T01:35:18.000000Z"
    }
  ]
}
```

### Resposta sem lembretes cadastrados

```json
{
  "data": []
}
```

---

## Criar lembrete

Cria um novo lembrete para o usuário autenticado.

### Requisição

```http
POST /api/lembretes
```

### Corpo da requisição

```json
{
  "categoria_id": 1,
  "descricao": "Reunião do projeto",
  "data_hora": "2026-07-20 19:00:00",
  "recorrente": false,
  "frequencia": null,
  "ativo": true
}
```

### Resposta de sucesso

**Status:** `201 Created`

```json
{
  "message": "Lembrete criado com sucesso.",
  "data": {
    "id": 1,
    "descricao": "Reunião do projeto",
    "data_hora": "2026-07-20 19:00:00",
    "recorrente": false,
    "frequencia": null,
    "ativo": true,
    "categoria": {
      "id": 1,
      "nome": "Faculdade",
      "cor": "#D45D8C"
    },
    "created_at": "2026-07-16T01:35:18.000000Z",
    "updated_at": "2026-07-16T01:35:18.000000Z"
  }
}
```

---

## Consultar lembrete

Retorna um lembrete específico pertencente ao usuário autenticado.

### Parâmetro da rota

| Parâmetro | Tipo | Descrição |
|---|---|---|
| `id` | integer | Identificador do lembrete |

### Requisição

```http
GET /api/lembretes/{id}
```

Exemplo:

```http
GET /api/lembretes/1
```

Não possui corpo JSON.

### Resposta de sucesso

**Status:** `200 OK`

```json
{
  "data": {
    "id": 1,
    "descricao": "Reunião do projeto",
    "data_hora": "2026-07-20 19:00:00",
    "recorrente": false,
    "frequencia": null,
    "ativo": true,
    "categoria": {
      "id": 1,
      "nome": "Faculdade",
      "cor": "#D45D8C"
    },
    "created_at": "2026-07-16T01:35:18.000000Z",
    "updated_at": "2026-07-16T01:35:18.000000Z"
  }
}
```

---

## Atualizar lembrete

Atualiza os dados de um lembrete pertencente ao usuário autenticado.

### Parâmetro da rota

| Parâmetro | Tipo | Descrição |
|---|---|---|
| `id` | integer | Identificador do lembrete |

### Requisição

```http
PUT /api/lembretes/{id}
```

Exemplo:

```http
PUT /api/lembretes/1
```

### Corpo da requisição

```json
{
  "categoria_id": 1,
  "descricao": "Reunião atualizada do projeto",
  "data_hora": "2026-07-21 20:00:00",
  "recorrente": false,
  "frequencia": null,
  "ativo": true
}
```

### Resposta de sucesso

**Status:** `200 OK`

```json
{
  "message": "Lembrete atualizado com sucesso.",
  "data": {
    "id": 1,
    "descricao": "Reunião atualizada do projeto",
    "data_hora": "2026-07-21 20:00:00",
    "recorrente": false,
    "frequencia": null,
    "ativo": true,
    "categoria": {
      "id": 1,
      "nome": "Faculdade",
      "cor": "#D45D8C"
    },
    "created_at": "2026-07-16T01:35:18.000000Z",
    "updated_at": "2026-07-16T01:38:19.000000Z"
  }
}
```

---

## Excluir lembrete

Exclui um lembrete pertencente ao usuário autenticado.

### Parâmetro da rota

| Parâmetro | Tipo | Descrição |
|---|---|---|
| `id` | integer | Identificador do lembrete |

### Requisição

```http
DELETE /api/lembretes/{id}
```

Exemplo:

```http
DELETE /api/lembretes/1
```

Não possui corpo JSON.

### Resposta de sucesso

**Status:** `200 OK`

```json
{
  "message": "Lembrete excluído com sucesso."
}
```

---

## Campos de lembrete

| Campo | Tipo | Obrigatório | Formato ou valores aceitos | Descrição |
|---|---|---:|---|---|
| `categoria_id` | integer ou null | Não | ID de uma categoria existente | Categoria relacionada ao lembrete |
| `descricao` | string | Sim | Máximo de 255 caracteres | Descrição do lembrete |
| `data_hora` | datetime | Sim | `AAAA-MM-DD HH:MM:SS` | Data e hora do lembrete |
| `recorrente` | boolean | Sim | `true` ou `false` | Informa se o lembrete se repete |
| `frequencia` | string ou null | Condicional | `DIARIA`, `SEMANAL`, `MENSAL`, `ANUAL` ou `null` | Frequência da recorrência |
| `ativo` | boolean | Sim | `true` ou `false` | Informa se o lembrete está ativo |

## Regras atuais de recorrência

Quando o lembrete não for recorrente:

```json
{
  "recorrente": false,
  "frequencia": null
}
```

Quando o lembrete for recorrente, uma frequência deve ser informada:

```json
{
  "recorrente": true,
  "frequencia": "DIARIA"
}
```

### Valores aceitos para `frequencia`

```text
DIARIA
SEMANAL
MENSAL
ANUAL
```

> O comportamento completo das ocorrências recorrentes será detalhado após a implementação da funcionalidade de recorrência.

---

# Códigos HTTP

| Código | Significado | Situação comum |
|---:|---|---|
| `200` | OK | Consulta, atualização ou exclusão concluída |
| `201` | Created | Registro criado com sucesso |
| `401` | Unauthorized | Token ausente ou inválido |
| `404` | Not Found | Registro não encontrado para o usuário |
| `422` | Unprocessable Entity | Dados enviados não passaram pela validação |
| `500` | Internal Server Error | Erro interno inesperado |

---

# Exemplo de erro de validação

Quando algum campo obrigatório não for enviado ou possuir valor inválido, a API pode retornar:

**Status:** `422 Unprocessable Entity`

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "descricao": [
      "O campo descrição é obrigatório."
    ]
  }
}
```

> O texto exato da propriedade `message` pode variar conforme a configuração global de tratamento de erros do Laravel.

---

# Observações para integração com o front-end

- Sempre enviar o Bearer Token nas rotas protegidas.
- Utilizar os nomes dos campos exatamente como documentados.
- Datas de metas utilizam o formato `AAAA-MM-DD`.
- A data e hora dos lembretes utilizam o formato `AAAA-MM-DD HH:MM:SS`.
- Os valores de `status`, `periodo` e `frequencia` devem ser enviados em letras maiúsculas.
- Uma listagem sem registros retorna `"data": []`.
- O front-end não deve depender somente das mensagens de texto; também deve verificar o código HTTP da resposta.