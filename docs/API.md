# API do Planner Virtual

Documentação das rotas disponíveis no back-end do Planner Virtual.

## Responsável pela documentação

**Ricardo**

> Este documento descreve o comportamento atual da API integrada. Funcionalidades implementadas por outros integrantes também são documentadas aqui para servir como referência de integração do projeto.

---

## Sumário

- [Informações gerais](#informações-gerais)
- [Autenticação](#autenticação)
- [Padrão das respostas](#padrão-das-respostas)
- [Categorias](#categorias)
- [Metas](#metas)
- [Tarefas](#tarefas)
- [Lembretes](#lembretes)
- [Dashboard](#dashboard)
- [Códigos HTTP](#códigos-http)
- [Erros de validação](#erros-de-validação)
- [Observações para integração com o front-end](#observações-para-integração-com-o-front-end)

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

As requisições e respostas utilizam JSON.

Cabeçalhos recomendados:

```http
Accept: application/json
Content-Type: application/json
```

O cabeçalho `Content-Type` deve ser enviado nas requisições que possuem corpo JSON.

## Rotas públicas e protegidas

As rotas de registro e login são públicas:

```text
POST /api/registrar
POST /api/login
```

As demais rotas descritas neste documento estão no grupo protegido por `auth:sanctum` e exigem autenticação.

---

# Autenticação

A API utiliza autenticação por Bearer Token com Laravel Sanctum.

Nas rotas protegidas, envie:

```http
Authorization: Bearer SEU_TOKEN
Accept: application/json
Content-Type: application/json
```

## Resumo das rotas de autenticação

- **Método:** `POST` — **Rota:** `/api/registrar` — **Protegida:** Não — **Descrição:** Registra um usuário
- **Método:** `POST` — **Rota:** `/api/login` — **Protegida:** Não — **Descrição:** Autentica e retorna um token
- **Método:** `POST` — **Rota:** `/api/logout` — **Protegida:** Sim — **Descrição:** Revoga o token atual
- **Método:** `GET` — **Rota:** `/api/perfil` — **Protegida:** Sim — **Descrição:** Retorna o usuário autenticado


## Registrar usuário

```http
POST /api/registrar
```

Corpo:

```json
{
  "nome": "Usuário Exemplo",
  "email": "usuario@example.com",
  "password": "1234",
  "password_confirmation": "1234"
}
```

Regras principais:

- **Campo:** `nome` — **Regra:** obrigatório, texto, máximo de 255 caracteres
- **Campo:** `email` — **Regra:** obrigatório, e-mail válido, único em `usuarios`, máximo de 255 caracteres
- **Campo:** `password` — **Regra:** obrigatório, texto, mínimo de 4 caracteres e confirmação obrigatória
- **Campo:** `password_confirmation` — **Regra:** deve coincidir com `password`


Sucesso: `201 Created`.

A resposta contém a mensagem `Usuário registrado com sucesso` e o objeto `usuario`.

## Login

```http
POST /api/login
```

Corpo:

```json
{
  "email": "usuario@example.com",
  "password": "1234"
}
```

Sucesso: `200 OK`.

A resposta contém:

```json
{
  "message": "Login bem-sucedido",
  "token": "TOKEN_GERADO",
  "usuario": {}
}
```

Credenciais inválidas retornam:

```json
{
  "message": "Credenciais inválidas"
}
```

Status: `401 Unauthorized`.

## Perfil

```http
GET /api/perfil
```

Retorna diretamente os dados do usuário autenticado.

## Logout

```http
POST /api/logout
```

Revoga o token de acesso utilizado na requisição.

Resposta:

```json
{
  "message": "Logout bem-sucedido"
}
```

Status: `200 OK`.

---

# Padrão das respostas

A API possui formatos de resposta diferentes entre alguns módulos porque as funcionalidades foram integradas em etapas distintas.

Metas e lembretes utilizam principalmente:

```json
{
  "data": []
}
```

Categorias e tarefas retornam, em algumas operações, o objeto ou a coleção diretamente.

Nas operações de criação e atualização, é comum existir também uma mensagem de sucesso.

---

# Categorias

As categorias organizam os demais elementos do planner.

## Resumo das rotas de categorias

- **Método:** `GET` — **Rota:** `/api/categorias` — **Descrição:** Lista categorias
- **Método:** `POST` — **Rota:** `/api/categorias` — **Descrição:** Cria categoria
- **Método:** `GET` — **Rota:** `/api/categorias/{id}` — **Descrição:** Consulta categoria
- **Método:** `PUT` / `PATCH` — **Rota:** `/api/categorias/{id}` — **Descrição:** Atualiza categoria
- **Método:** `DELETE` — **Rota:** `/api/categorias/{id}` — **Descrição:** Exclui categoria


Todas exigem Bearer Token.

## Listar categorias

```http
GET /api/categorias
```

Sucesso: `200 OK`.

A resposta é uma coleção JSON de categorias.

## Criar categoria

```http
POST /api/categorias
```

Corpo:

```json
{
  "nome": "Faculdade",
  "cor": "#D45D8C"
}
```

Campos:

- **Campo:** `nome` — **Obrigatório na criação:** Sim — **Regra:** texto, máximo de 255 caracteres
- **Campo:** `cor` — **Obrigatório na criação:** Sim — **Regra:** texto, máximo de 20 caracteres


Sucesso: `201 Created`.

```json
{
  "message": "Categoria criada com sucesso",
  "categoria": {}
}
```

## Consultar categoria

```http
GET /api/categorias/{id}
```

Sucesso: `200 OK`.

Se não existir:

```json
{
  "message": "Categoria não encontrada"
}
```

Status: `404 Not Found`.

## Atualizar categoria

```http
PUT /api/categorias/{id}
```

ou

```http
PATCH /api/categorias/{id}
```

A atualização aceita campos parciais.

Exemplo:

```json
{
  "cor": "#3366FF"
}
```

Sucesso: `200 OK`.

## Excluir categoria

```http
DELETE /api/categorias/{id}
```

Sucesso:

```json
{
  "message": "Categoria excluída com sucesso"
}
```

Status: `200 OK`.

---

# Metas

As metas representam objetivos cadastrados pelo usuário.

## Resumo das rotas de metas

- **Método:** `GET` — **Rota:** `/api/metas` — **Descrição:** Lista metas do usuário autenticado
- **Método:** `GET` — **Rota:** `/api/metas?busca={texto}` — **Descrição:** Busca pela descrição
- **Método:** `GET` — **Rota:** `/api/metas/status/{status}` — **Descrição:** Filtra por status
- **Método:** `GET` — **Rota:** `/api/metas/categoria/{id}` — **Descrição:** Filtra por categoria
- **Método:** `GET` — **Rota:** `/api/metas/periodo/{periodo}` — **Descrição:** Filtra por período
- **Método:** `GET` — **Rota:** `/api/metas/usuario/{id}` — **Descrição:** Lista metas pelo ID de usuário informado
- **Método:** `POST` — **Rota:** `/api/metas` — **Descrição:** Cria meta
- **Método:** `GET` — **Rota:** `/api/metas/{id}` — **Descrição:** Consulta meta
- **Método:** `PUT` / `PATCH` — **Rota:** `/api/metas/{id}` — **Descrição:** Atualiza meta
- **Método:** `DELETE` — **Rota:** `/api/metas/{id}` — **Descrição:** Exclui meta


## Listar e buscar metas

```http
GET /api/metas
```

A rota aceita o parâmetro opcional `busca`:

```http
GET /api/metas?busca=projeto
```

A busca procura o texto em qualquer parte da descrição.

Resposta:

```json
{
  "data": [
    {
      "id": 1,
      "descricao": "Finalizar projeto do planner",
      "status": "EM_ANDAMENTO",
      "periodo": "MENSAL",
      "data_inicio": "2026-08-01",
      "data_fim": "2026-08-31",
      "categoria": {
        "id": 1,
        "nome": "Faculdade",
        "cor": "#D45D8C"
      },
      "created_at": "2026-08-01T12:00:00.000000Z",
      "updated_at": "2026-08-01T12:00:00.000000Z"
    }
  ]
}
```

Sem resultados:

```json
{
  "data": []
}
```

## Filtros de metas

### Por status

```http
GET /api/metas/status/EM_ANDAMENTO
```

### Por categoria

```http
GET /api/metas/categoria/1
```

### Por período

```http
GET /api/metas/periodo/MENSAL
```

### Por usuário

```http
GET /api/metas/usuario/1
```

Os filtros retornam a coleção dentro de `data`.

## Criar meta

```http
POST /api/metas
```

Corpo:

```json
{
  "categoria_id": 1,
  "descricao": "Concluir o projeto",
  "status": "EM_ANDAMENTO",
  "periodo": "MENSAL",
  "data_inicio": "2026-08-01",
  "data_fim": "2026-08-31"
}
```

Sucesso: `201 Created`.

## Consultar meta

```http
GET /api/metas/{id}
```

A consulta é feita dentro das metas do usuário autenticado.

## Atualizar meta

```http
PUT /api/metas/{id}
```

ou

```http
PATCH /api/metas/{id}
```

A atualização aceita campos parciais. Exemplo:

```json
{
  "status": "CUMPRIDA"
}
```

Quando `data_inicio` ou `data_fim` for alterada isoladamente, a validação também considera a outra data já armazenada na meta. A data final não pode ser anterior à data inicial.

## Excluir meta

```http
DELETE /api/metas/{id}
```

Sucesso:

```json
{
  "message": "Meta excluída com sucesso."
}
```

## Campos de meta

- **Campo:** `categoria_id` — **Criação:** Opcional — **Atualização:** Opcional — **Valores / formato:** ID existente ou `null`
- **Campo:** `descricao` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** texto, máximo 255
- **Campo:** `status` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** `EM_ANDAMENTO`, `CUMPRIDA`, `PARCIAL`, `NAO_CUMPRIDA`
- **Campo:** `periodo` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** `SEMANAL`, `MENSAL`, `ANUAL`
- **Campo:** `data_inicio` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** `AAAA-MM-DD`
- **Campo:** `data_fim` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** `AAAA-MM-DD`, igual ou posterior a `data_inicio`


---

# Tarefas

As tarefas representam atividades planejadas pelo usuário.

## Resumo das rotas de tarefas

- **Método:** `GET` — **Rota:** `/api/tarefas` — **Descrição:** Lista tarefas do usuário autenticado
- **Método:** `GET` — **Rota:** `/api/tarefas/status/{status}` — **Descrição:** Filtra por status
- **Método:** `GET` — **Rota:** `/api/tarefas/categoria/{id}` — **Descrição:** Filtra por categoria
- **Método:** `GET` — **Rota:** `/api/tarefas/prioridade/{prioridade}` — **Descrição:** Filtra por prioridade
- **Método:** `GET` — **Rota:** `/api/tarefas/data/{data}` — **Descrição:** Filtra por data
- **Método:** `GET` — **Rota:** `/api/tarefas/turno/{turno}` — **Descrição:** Filtra por turno
- **Método:** `GET` — **Rota:** `/api/tarefas/usuario/{id}` — **Descrição:** Lista tarefas pelo ID de usuário informado
- **Método:** `POST` — **Rota:** `/api/tarefas` — **Descrição:** Cria tarefa
- **Método:** `GET` — **Rota:** `/api/tarefas/{id}` — **Descrição:** Consulta tarefa
- **Método:** `PUT` / `PATCH` — **Rota:** `/api/tarefas/{id}` — **Descrição:** Atualiza tarefa
- **Método:** `DELETE` — **Rota:** `/api/tarefas/{id}` — **Descrição:** Exclui tarefa


## Listar tarefas

```http
GET /api/tarefas
```

Retorna diretamente uma coleção JSON das tarefas do usuário autenticado, com a relação `categoria` carregada.

## Criar tarefa

```http
POST /api/tarefas
```

Corpo:

```json
{
  "categoria_id": 1,
  "descricao": "Estudar para a apresentação",
  "status": "NAO_CUMPRIDA",
  "data": "2026-08-15",
  "hora_inicio": "19:00",
  "hora_fim": "20:00",
  "turno": "NOITE",
  "prioridade": "ALTA"
}
```

O campo `status` é opcional na criação. Quando não informado, o Controller utiliza `NAO_CUMPRIDA`.

Sucesso: `201 Created`.

```json
{
  "message": "Tarefa criada com sucesso",
  "tarefa": {}
}
```

## Consultar tarefa

```http
GET /api/tarefas/{id}
```

A consulta restringe a tarefa ao usuário autenticado.

Se não for encontrada:

```json
{
  "message": "Tarefa não encontrada"
}
```

Status: `404 Not Found`.

## Atualizar tarefa

```http
PUT /api/tarefas/{id}
```

ou

```http
PATCH /api/tarefas/{id}
```

Aceita atualização parcial.

Exemplo:

```json
{
  "prioridade": "MEDIA"
}
```

Quando uma das horas é informada, a validação exige também a outra. `hora_fim` deve ser posterior a `hora_inicio`.

## Excluir tarefa

```http
DELETE /api/tarefas/{id}
```

Sucesso:

```json
{
  "message": "Tarefa excluída com sucesso"
}
```

## Filtros de tarefas

```http
GET /api/tarefas/status/CUMPRIDA
GET /api/tarefas/categoria/1
GET /api/tarefas/prioridade/ALTA
GET /api/tarefas/data/2026-08-15
GET /api/tarefas/turno/NOITE
GET /api/tarefas/usuario/1
```

Os filtros retornam diretamente uma coleção JSON.

## Campos de tarefa

- **Campo:** `categoria_id` — **Criação:** Opcional — **Atualização:** Opcional — **Valores / formato:** ID existente ou `null`
- **Campo:** `descricao` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** texto, máximo 255
- **Campo:** `status` — **Criação:** Opcional — **Atualização:** Opcional — **Valores / formato:** `CUMPRIDA`, `PARCIAL`, `NAO_CUMPRIDA`
- **Campo:** `data` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** data válida
- **Campo:** `hora_inicio` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** `HH:MM`
- **Campo:** `hora_fim` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** `HH:MM`, posterior a `hora_inicio`
- **Campo:** `turno` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** `MANHA`, `TARDE`, `NOITE`
- **Campo:** `prioridade` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** `ALTA`, `MEDIA`, `BAIXA`


---

# Lembretes

Os lembretes representam compromissos ou avisos cadastrados pelo usuário e podem ser únicos ou recorrentes.

## Resumo das rotas de lembretes

- **Método:** `GET` — **Rota:** `/api/lembretes` — **Descrição:** Lista lembretes do usuário
- **Método:** `GET` — **Rota:** `/api/lembretes/proximos` — **Descrição:** Lista próximos lembretes ativos considerando recorrência
- **Método:** `GET` — **Rota:** `/api/lembretes/ativos` — **Descrição:** Lista lembretes ativos
- **Método:** `GET` — **Rota:** `/api/lembretes/recorrentes` — **Descrição:** Lista lembretes recorrentes
- **Método:** `GET` — **Rota:** `/api/lembretes/data/{data}` — **Descrição:** Filtra pela data armazenada
- **Método:** `GET` — **Rota:** `/api/lembretes/usuario/{id}` — **Descrição:** Lista lembretes pelo ID de usuário informado
- **Método:** `POST` — **Rota:** `/api/lembretes` — **Descrição:** Cria lembrete
- **Método:** `GET` — **Rota:** `/api/lembretes/{id}` — **Descrição:** Consulta lembrete
- **Método:** `PUT` / `PATCH` — **Rota:** `/api/lembretes/{id}` — **Descrição:** Atualiza lembrete
- **Método:** `DELETE` — **Rota:** `/api/lembretes/{id}` — **Descrição:** Exclui lembrete


## Estrutura de resposta

Os lembretes são formatados pelo `LembreteResource`.

Exemplo:

```json
{
  "id": 1,
  "descricao": "Revisar conteúdo da disciplina",
  "data_hora": "2026-08-10 20:00:00",
  "recorrente": true,
  "frequencia": "DIARIA",
  "proxima_ocorrencia": "2026-08-14 20:00:00",
  "ativo": true,
  "categoria": {
    "id": 1,
    "nome": "Faculdade",
    "cor": "#D45D8C"
  },
  "created_at": "2026-08-10T12:00:00.000000Z",
  "updated_at": "2026-08-10T12:00:00.000000Z"
}
```

`data_hora` representa a data e hora original armazenada no banco. `proxima_ocorrencia` representa a ocorrência calculada pelo back-end.

## Listar lembretes

```http
GET /api/lembretes
```

Resposta:

```json
{
  "data": []
}
```

A listagem é ordenada por `data_hora` e, em seguida, por `id`.

## Próximos lembretes

```http
GET /api/lembretes/proximos
```

Retorna lembretes ativos que ainda possuem uma ocorrência válida a partir do momento atual.

Para lembretes recorrentes cuja `data_hora` original já passou, a rota calcula a próxima ocorrência e mantém o lembrete na listagem.

Os resultados são ordenados pela próxima ocorrência calculada.

## Lembretes ativos

```http
GET /api/lembretes/ativos
```

Retorna os lembretes do usuário com `ativo = true`.

## Lembretes recorrentes

```http
GET /api/lembretes/recorrentes
```

Retorna os lembretes com `recorrente = true`.

## Buscar lembretes por data

```http
GET /api/lembretes/data/2026-08-14
```

A rota utiliza a data de `data_hora` armazenada no registro. Ela não pesquisa pela `proxima_ocorrencia` calculada.

## Buscar lembretes por usuário

```http
GET /api/lembretes/usuario/1
```

Retorna lembretes associados ao `usuario_id` informado.

## Criar lembrete

```http
POST /api/lembretes
```

Lembrete único:

```json
{
  "categoria_id": 1,
  "descricao": "Entregar atividade",
  "data_hora": "2026-08-15 18:00:00",
  "recorrente": false,
  "ativo": true
}
```

Lembrete recorrente:

```json
{
  "categoria_id": 1,
  "descricao": "Revisar planejamento",
  "data_hora": "2026-08-15 18:00:00",
  "recorrente": true,
  "frequencia": "SEMANAL",
  "ativo": true
}
```

Se `recorrente` for `false`, `frequencia` não deve ser informada e será mantida como `null`.

Se `recorrente` for `true`, `frequencia` é obrigatória.

Sucesso: `201 Created`.

## Consultar lembrete

```http
GET /api/lembretes/{id}
```

A consulta é feita dentro dos lembretes do usuário autenticado.

## Atualizar lembrete

```http
PUT /api/lembretes/{id}
```

ou

```http
PATCH /api/lembretes/{id}
```

Aceita atualização parcial.

Exemplo:

```json
{
  "ativo": false
}
```

Para transformar um lembrete em recorrente:

```json
{
  "recorrente": true,
  "frequencia": "MENSAL"
}
```

Para remover a recorrência:

```json
{
  "recorrente": false
}
```

Nesse caso, o Controller define `frequencia` como `null`.

Quando `frequencia` for enviada na atualização, `recorrente` deve estar presente e ser `true`.

## Excluir lembrete

```http
DELETE /api/lembretes/{id}
```

Sucesso:

```json
{
  "message": "Lembrete excluído com sucesso."
}
```

## Campos de lembrete

- **Campo:** `categoria_id` — **Criação:** Opcional — **Atualização:** Opcional — **Valores / formato:** ID existente ou `null`
- **Campo:** `descricao` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** texto, máximo 255
- **Campo:** `data_hora` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** `AAAA-MM-DD HH:MM:SS`
- **Campo:** `recorrente` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** `true` ou `false`
- **Campo:** `frequencia` — **Criação:** Condicional — **Atualização:** Condicional — **Valores / formato:** `DIARIA`, `SEMANAL`, `MENSAL`, `ANUAL`
- **Campo:** `ativo` — **Criação:** Obrigatório — **Atualização:** Opcional — **Valores / formato:** `true` ou `false`
- **Campo:** `proxima_ocorrencia` — **Criação:** — — **Atualização:** — — **Valores / formato:** campo calculado de resposta


## Regra de recorrência

A recorrência utiliza um único registro de lembrete. Novas linhas não são criadas no banco para cada repetição.

A partir da `data_hora` original, a próxima ocorrência é calculada conforme a frequência:

- **Frequência:** `DIARIA` — **Avanço:** 1 dia
- **Frequência:** `SEMANAL` — **Avanço:** 1 semana
- **Frequência:** `MENSAL` — **Avanço:** 1 mês sem ultrapassar o limite válido do mês
- **Frequência:** `ANUAL` — **Avanço:** 1 ano sem ultrapassar o limite válido do ano


O cálculo avança até encontrar a primeira ocorrência igual ou posterior ao momento de referência.

---

# Dashboard

O dashboard consolida informações do usuário autenticado.

```http
GET /api/dashboard
```

Status: `200 OK`.

Estrutura:

```json
{
  "data": {
    "tarefas_pendentes": 2,
    "tarefas_concluidas": 3,
    "metas_em_andamento": 1,
    "proximos_lembretes": [],
    "indicador_produtividade": 60
  }
}
```

## Campos do dashboard

- **Campo:** `tarefas_pendentes` — **Significado:** tarefas de hoje cujo status é diferente de `CUMPRIDA`
- **Campo:** `tarefas_concluidas` — **Significado:** tarefas de hoje com status `CUMPRIDA`
- **Campo:** `metas_em_andamento` — **Significado:** quantidade de metas com status `EM_ANDAMENTO`
- **Campo:** `proximos_lembretes` — **Significado:** até 5 lembretes ativos cuja `data_hora` armazenada ainda não passou
- **Campo:** `indicador_produtividade` — **Significado:** percentual de tarefas concluídas entre as tarefas do dia


O indicador é calculado por:

```text
tarefas_concluidas / total_de_tarefas_do_dia * 100
```

Quando não há tarefas no dia, o indicador retorna `0`.

> Observação: atualmente o dashboard seleciona `proximos_lembretes` diretamente pela `data_hora` armazenada. A rota específica `/api/lembretes/proximos` possui lógica adicional para considerar ocorrências recorrentes cuja data original já passou.

---

# Códigos HTTP

- **Código:** `200` — **Significado:** OK — **Situação comum:** consulta, atualização, exclusão ou login concluído
- **Código:** `201` — **Significado:** Created — **Situação comum:** usuário ou registro criado
- **Código:** `401` — **Significado:** Unauthorized — **Situação comum:** token ausente/inválido ou credenciais inválidas
- **Código:** `404` — **Significado:** Not Found — **Situação comum:** registro não encontrado
- **Código:** `422` — **Significado:** Unprocessable Entity — **Situação comum:** dados não passaram pela validação
- **Código:** `500` — **Significado:** Internal Server Error — **Situação comum:** erro interno inesperado


---

# Erros de validação

Quando os dados enviados não atendem às regras do Laravel, a API pode responder com `422 Unprocessable Entity`.

Exemplo:

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "descricao": [
      "A descrição é obrigatória."
    ]
  }
}
```

O texto exato de `message` pode variar conforme a configuração global do tratamento de exceções.

## Regras importantes

- Metas não aceitam `data_fim` anterior a `data_inicio`, inclusive em atualização parcial.
- Tarefas exigem `hora_fim` posterior a `hora_inicio`.
- Em atualização de tarefa, ao informar uma das horas, a outra também é exigida.
- Lembretes recorrentes exigem uma frequência válida.
- A frequência do lembrete somente pode ser informada quando `recorrente` for `true`.
- IDs de categoria recebidos por metas, tarefas e lembretes devem existir na tabela `categorias`.

---

# Observações para integração com o front-end

- Sempre enviar Bearer Token nas rotas protegidas.
- Utilizar os nomes dos campos exatamente como documentados.
- Datas de metas usam `AAAA-MM-DD`.
- Horários das tarefas usam `HH:MM`.
- A data e hora dos lembretes usam `AAAA-MM-DD HH:MM:SS`.
- Valores de enumeração devem respeitar as letras maiúsculas definidas pela API.
- Metas e lembretes normalmente encapsulam coleções e registros em `data`.
- Categorias e tarefas possuem respostas diretas em algumas operações.
- O front-end deve verificar o código HTTP e não depender somente da mensagem textual.
- `proxima_ocorrencia` é um campo calculado e não deve ser enviado em requisições de criação ou atualização.
