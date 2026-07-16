# API do Planner Virtual

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