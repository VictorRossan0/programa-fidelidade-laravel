# 📑 Documentação da API - Programa de Fidelidade

## 🔐 Autenticação

Todos os endpoints exigem **Bearer Token** no header:

``` markdown
Authorization: Bearer {token}
```

### Tokens disponíveis

- `4b5f8f32c96a9aa152e0c6615d4e632f` → 001,002,003,004,005,006  
- `117ae721e424e7f819893edb2c0c5fd6` → 002,003,004  
- `3b7d6e2cb06ba79a9c9744f8e256a39e` → 005,006  

---

## 📌 Endpoints

### 001 - Cadastrar Cliente

`POST /clients`  
**Permissão:** 001  

**Body (JSON):**

```json
{
  "name": "João Silva",
  "email": "joao.silva@example.com"
}
```

**Resposta (201):**

```json
{
  "id": 1,
  "name": "João Silva",
  "email": "joao.silva@example.com",
  "created_at": "2025-09-07T16:00:00"
}
```

---

### 002 - Buscar Cliente

`GET /clients/{id}`  
**Permissão:** 002  

**Resposta (200):**

```json
{
  "id": 1,
  "name": "João Silva",
  "email": "joao.silva@example.com",
  "points": { "amount": 10 },
  "redemptions": []
}
```

---

### 003 - Listar Clientes

`GET /clients`  
**Permissão:** 003  

---

### 004 - Consultar Saldo

`GET /clients/{id}/balance`  
**Permissão:** 004  

**Resposta (200):**

```json
{
  "saldo": 10,
  "resgates": []
}
```

---

### 005 - Resgatar Prêmio

`POST /redemptions`  
**Permissão:** 005  

**Body (JSON):**

```json
{
  "client_id": 1,
  "reward_id": 2
}
```

**Resposta (201):**

```json
{
  "id": 1,
  "client_id": 1,
  "reward_id": 2,
  "created_at": "2025-09-07T16:05:00"
}
```

---

### 006 - Pontuar Cliente

`POST /points/earn`  
**Permissão:** 006  

**Body (JSON):**

```json
{
  "client_id": 1,
  "amount_spent": 50
}
```

**Resposta (200):**

```json
{
  "message": "Pontos adicionados com sucesso"
}
```

---

## 📧 Emails Automáticos

- Ao ganhar pontos → Email de confirmação com saldo atualizado.  
- Ao resgatar prêmio → Email de parabéns com detalhes do prêmio.  
- Cronjob diário → Email lembrando que o cliente pode resgatar o prêmio máximo.  

---

## 🛠️ Setup do Projeto

1. Clonar o repositório.  
2. Instalar dependências:

```bash
composer install
```

3.Configurar `.env` com banco MySQL e credenciais Mailtrap.  

4.Rodar migrations e seeders:

```bash
php artisan migrate --seed
```

5.Subir servidor:

```bash
php artisan serve
```

6.Testar endpoints via Postman/Insomnia.  
