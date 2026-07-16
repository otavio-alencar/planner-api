# API do Planner Virtual

#Ricardo 


## Autenticação

As rotas de metas exigem autenticação.

Cabeçalho necessário:

```http
Authorization: Bearer TOKEN
Accept: application/json
```

---

## Listar metas

### Rota

```http
GET /api/metas
```

### Requisição

Não possui corpo.

### Resposta

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

---

## Criar meta

### Rota

```http
POST /api/metas
```

### Requisição

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

### Resposta

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
    }
  }
}
```

---

## Consultar uma meta

### Rota

```http
GET /api/metas/{id}
```

### Requisição

Não possui corpo.

### Resposta

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
    }
  }
}
```

---

## Atualizar meta

### Rota

```http
PUT /api/metas/{id}
```

### Requisição

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

### Resposta

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
    }
  }
}
```

---

## Excluir meta

### Rota

```http
DELETE /api/metas/{id}
```

### Requisição

Não possui corpo.

### Resposta

```json
{
  "message": "Meta excluída com sucesso."
}
```

---

## Valores aceitos

### Status

```text
EM_ANDAMENTO
CUMPRIDA
PARCIAL
NAO_CUMPRIDA
```

### Período

```text
SEMANAL
MENSAL
ANUAL
```

### Buscar metas por descrição

A busca é feita usando o parâmetro `busca`.

Exemplo de rota:

```http
GET /api/metas?busca=projeto

Requisição:

busca: texto que será procurado na descrição da meta.
O parâmetro é opcional.
Não possui corpo JSON.

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
      }
    }
  ]
}

Quando não existir nenhuma meta correspondente:

{
  "data": []
}


---

# Lembretes

Todas as rotas de lembretes exigem autenticação.

Cabeçalhos necessários:

```http
Authorization: Bearer TOKEN
Accept: application/json
```

## Listar lembretes

### Rota

```http
GET /api/lembretes
```

### Requisição

Não possui corpo.

### Resposta

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

## Criar lembrete

### Rota

```http
POST /api/lembretes
```

### Requisição

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

### Resposta

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
    }
  }
}
```

## Consultar um lembrete

### Rota

```http
GET /api/lembretes/{id}
```

### Requisição

Não possui corpo.

### Resposta

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
    }
  }
}
```

## Atualizar lembrete

### Rota

```http
PUT /api/lembretes/{id}
```

### Requisição

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

### Resposta

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
    }
  }
}
```

## Excluir lembrete

### Rota

```http
DELETE /api/lembretes/{id}
```

### Requisição

Não possui corpo.

### Resposta

```json
{
  "message": "Lembrete excluído com sucesso."
}
```

## Campos aceitos

```text
categoria_id: número inteiro ou null
descricao: texto com até 255 caracteres
data_hora: formato AAAA-MM-DD HH:MM:SS
recorrente: true ou false
frequencia: DIARIA, SEMANAL, MENSAL, ANUAL ou null
ativo: true ou false
```