# 📑 Documentação da API — Programa de Fidelidade

API REST para cadastro de clientes, pontuação por compras, resgate de prêmios e e-mails automáticos (transacionais e lembrete diário).

Base URL: <http://127.0.0.1:8000/api>

---

## 🔐 Autenticação

Autenticação via Bearer Token com permissões por endpoint (middleware `token:<perm>`).

Header:

```http
Authorization: Bearer <TOKEN>
```

Tokens de exemplo:

- `4b5f8f32c96a9aa152e0c6615d4e632f` → 001,002,003,004,005,006
- `117ae721e424e7f819893edb2c0c5fd6` → 002,003,004
- `3b7d6e2cb06ba79a9c9744f8e256a39e` → 005,006

---

## ⚙️ Regras de Pontos

- 1 ponto a cada R$5,00 gastos (arredondado para baixo): `points = floor(amount_spent / 5)`
- Valor mínimo para gerar pontos: `amount_spent >= 5`

---

## 🧩 Modelo de Dados (resumo)

- Tabelas
  - `clients` — clientes do programa
  - `points` — saldo único de pontos por cliente (`client_id`, `amount`)
  - `rewards` — prêmios com `points_required`
  - `redemptions` — resgates realizados (`client_id`, `reward_id`)
  - `transactions` — compras com `amount_spent` e `points_earned`

- Relacionamentos
  - Client hasOne Point
  - Client hasMany Redemptions; Redemption belongsTo Reward
  - Client hasMany Transactions

---

## 📌 Endpoints

### 001 — Cadastrar Cliente

POST /clients — perm: 001

Body (JSON):

```json
{
  "name": "João Silva",
  "email": "joao.silva@example.com"
}
```

Resposta (201 Created):

```json
{
  "id": 1,
  "name": "João Silva",
  "email": "joao.silva@example.com",
  "created_at": "2025-09-07T16:00:00.000000Z"
}
```

Erros comuns:

- 422 Unprocessable Entity (validação): campos obrigatórios/duplicados
- 401/403 (autenticação/permissão)

---

### 002 — Buscar Cliente

GET /clients/{id} — perm: 002

Resposta (200):

```json
{
  "id": 1,
  "name": "João Silva",
  "email": "joao.silva@example.com",
  "points": { "amount": 10 },
  "redemptions": []
}
```

Observação: `points` representa o saldo do cliente.

Erros comuns:

- 404 Not Found: cliente inexistente
- 401/403 (autenticação/permissão)

---

### 003 — Listar Clientes

GET /clients — perm: 003

Retorna a lista de clientes.

Erros comuns:

- 401/403 (autenticação/permissão)

---

### 004 — Consultar Saldo

GET /clients/{id}/balance — perm: 004

Resposta (200):

```json
{
  "saldo": 10,
  "resgates": []
}
```

Erros comuns:

- 404 Not Found: cliente inexistente
- 401/403 (autenticação/permissão)

---

### 005 — Resgatar Prêmio

POST /redemptions — perm: 005

Body (JSON):

```json
{
  "client_id": 1,
  "reward_id": 2
}
```

Resposta (201 Created):

Headers:

```http
Location: /api/redemptions/1
```

Body:

```json
{
  "id": 1,
  "client_id": 1,
  "reward_id": 2,
  "remaining_balance": 5,
  "created_at": "2025-09-07T16:05:00.000000Z"
}
```

Erros comuns:

- 400 Bad Request: {"error":"Saldo insuficiente"}
- 404 Not Found: `client_id` ou `reward_id` inexistente
- 401/403 (autenticação/permissão)

---

### 006 — Pontuar Cliente

POST /points/earn — perm: 006

Body (JSON):

```json
{
  "client_id": 1,
  "amount_spent": 50
}
```

Resposta (200):

```json
{
  "message": "Pontos adicionados com sucesso"
}
```

Validações:

- `client_id` deve existir; `amount_spent` numérico e mínimo 5.

Erros comuns:

- 422 Unprocessable Entity: `amount_spent < 5` ou inválido
- 404 Not Found: `client_id` inexistente
- 401/403 (autenticação/permissão)

---

## 📧 E-mails e Agendamento

- Ao pontuar (006): envia `PointsEarnedMail` com confirmação.
- Ao resgatar (005): envia `RewardRedeemedMail` com detalhes do prêmio.
- Lembrete diário: `DailyReminderMail` para clientes com saldo ≥ pontos do prêmio de maior valor.

Jobs: `SendPointsEmail`, `SendRedemptionEmail`, `SendDailyReminderEmail`.

Agendador: definido em `app/Console/Kernel.php`. Envia lembretes apenas a clientes elegíveis ao maior prêmio.

---

## 🛠️ Setup Rápido

1. Instalar dependências

```powershell
composer install
```

1. Configurar `.env` (MySQL, Mailtrap SMTP, QUEUE_CONNECTION)

1. Migrar e popular base

```powershell
php artisan migrate --seed
```

1. Subir servidor

```powershell
php artisan serve
```

1. (Opcional) Executar filas e agendador

```powershell
php artisan queue:work
php artisan schedule:work
```

---

## 📎 Postman

- Coleção pronta: `postman_collection.json`
- Base URL: `http://127.0.0.1:8000/api`
- Use o header `Authorization: Bearer <TOKEN>`

---

## ✅ Checklist (Implementado)

- Laravel, MySQL, Eloquent
- Endpoints 001–006 com validações
- Autenticação por Bearer Token com permissões
- Débito de pontos no resgate e e-mails transacionais
- Lembrete diário apenas para quem pode resgatar o prêmio máximo
