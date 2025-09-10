# 📑 Documentação da API - Programa de Fidelidade

---

## ⚙️ Banco de Dados

- Utiliza MySQL (configuração no arquivo `.env`).
- Estrutura criada via migrations do Laravel.

---

## 📧 E-mails Automáticos

- O sistema dispara e-mails automáticos via Mailtrap:
  - Ao ganhar pontos (`PointsEarnedMail`).
  - Ao resgatar prêmio (`RewardRedeemedMail`).
  - Lembrete diário para clientes com saldo suficiente para o prêmio máximo (`DailyReminderMail`).
- Os templates dos e-mails podem ser personalizados em `resources/views/emails/`.
- O agendamento diário é feito via cronjob no `Console/Kernel.php`.

---

## 🛠️ Jobs e Agendamento

- Jobs implementados para envio de e-mails.
- O agendamento diário percorre todos os clientes e dispara o lembrete para quem tem saldo suficiente.

---

## ✅ Checklist de Requisitos Atendidos

- [x] Framework Laravel
- [x] Banco de dados MySQL
- [x] Eloquent ORM
- [x] Jobs
- [x] Validations
- [x] Artisan Console (Cronjobs)
- [x] Mail
- [x] Middlewares
- [x] Endpoints obrigatórios (001 a 006)
- [x] Decremento de pontos ao resgatar prêmio
- [x] Validação para não pontuar valores abaixo do mínimo
- [x] Envio de e-mail ao ganhar pontos e ao resgatar prêmio
- [x] Envio de e-mail diário para clientes com saldo suficiente
- [x] Autenticação via Bearer Token com permissões

## 🔐 Autenticação

---

## 📝 Observações Finais

- Para visualizar os e-mails enviados, acesse sua caixa Mailtrap.
- Os templates dos e-mails podem ser personalizados conforme desejado.
- Para agendar o envio diário, certifique-se que o cron do Laravel está rodando (`php artisan schedule:run`).
- O projeto está pronto para ser testado via Postman, Insomnia ou outra ferramenta de API.

Authorization: Bearer {token}

``` markdown

### Tokens disponíveis

- `4b5f8f32c96a9aa152e0c6615d4e632f` → 001,002,003,004,005,006  
- `117ae721e424e7f819893edb2c0c5fd6` → 002,003,004  
- `3b7d6e2cb06ba79a9c9744f8e256a39e` → 005,006  

```

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

    ```sh
    git clone https://github.com/VictorRossan0/programa-fidelidade-laravel.git
    ```

2. Instalar dependências:

    ```bash
    composer install
    ```

3. Configurar `.env` com banco MySQL e credenciais Mailtrap(ou outro que for utilizar).  

4. Rodar migrations e seeders:

    ```bash
    php artisan migrate --seed
    ```

5. Subir servidor:

    ```bash
    php artisan serve
    ```

6. Testar endpoints via Postman/Insomnia.
