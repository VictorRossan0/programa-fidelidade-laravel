# Programa de Fidelidade (Backend Laravel)

API REST para gerenciamento de um programa de fidelidade: cadastro de clientes, acúmulo de pontos por compras, resgate de prêmios e envio de e-mails transacionais e de lembrete.

Este repositório foi preparado para avaliação técnica, com código testado, documentação e coleção do Postman.

## Visão geral

- Pontuação automática: 1 ponto a cada R$5,00 gastos (arredondado para baixo)
- Resgates de prêmios fixos por faixas de pontos
- Consulta de saldo e extrato básico de resgates
- E-mails automáticos: pontos recebidos, prêmio resgatado e lembrete diário
- Agendador diário para lembrar clientes elegíveis ao maior prêmio
- Autenticação por Bearer Token com permissões por endpoint

## Arquitetura rápida

- Framework: Laravel 12+, PHP 8.2
- Banco de dados: MySQL (migrations e seeders incluídos)
- ORM: Eloquent (modelos: `Client`, `Point`, `Reward`, `Redemption`, `Transaction`)
- Filas/Jobs: envio de e-mails (pontos/resgate/lembrete)
- Mail: SMTP (recomendado Mailtrap para desenvolvimento)
- Scheduler: agendamento diário via `app/Console/Kernel.php`

### Tabelas principais

- `clients` (clientes)
- `points` (saldo único por cliente)
- `rewards` (prêmios e pontos necessários)
- `redemptions` (resgates realizados)
- `transactions` (registro de compras e pontos gerados)

### Endpoints e permissões

Middleware: `token:<perm>` exige Bearer Token com a permissão indicada.

- 001 POST `/api/clients` — Criar cliente (perm: 001)
- 002 GET  `/api/clients/{id}` — Buscar cliente (perm: 002)
- 003 GET  `/api/clients` — Listar clientes (perm: 003)
- 004 GET  `/api/clients/{id}/balance` — Saldo e resgates (perm: 004)
- 005 POST `/api/redemptions` — Resgatar prêmio (perm: 005)
- 006 POST `/api/points/earn` — Registrar compra e pontuar (perm: 006)

Detalhes de payloads e respostas: ver `docs/Documentacao_Fidelidade.md` e `postman_collection.json`.

### Tokens de exemplo (para avaliação)

- 4b5f8f32c96a9aa152e0c6615d4e632f → permissões: 001,002,003,004,005,006
- 117ae721e424e7f819893edb2c0c5fd6 → permissões: 002,003,004
- 3b7d6e2cb06ba79a9c9744f8e256a39e → permissões: 005,006

Envie no header: `Authorization: Bearer <TOKEN>`

## Instalação e configuração

Pré-requisitos: PHP 8.2+, Composer, MySQL. Para e-mail: conta no Mailtrap.

1. Dependências

```bash
composer install
```

1. Ambiente

- Copie `.env.example` para `.env` e configure:
- DB_* (MySQL)
- MAIL_MAILER=smtp, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD (Mailtrap)
- QUEUE_CONNECTION=sync (desenvolvimento) ou `database` (produção/dev com worker)

1. Banco de dados (migrations e seeders)

```bash
php artisan migrate --seed
```

1. Subir aplicação

```bash
php artisan serve
```

Servidor padrão: <http://127.0.0.1:8000>

## E-mails, Filas e Agendador

- E-mails são disparados ao pontuar (006), ao resgatar (005) e no lembrete diário.
- Em dev, use `QUEUE_CONNECTION=sync` para simplificar; para filas reais, configure `QUEUE_CONNECTION=database` e rode o worker:

```bash
php artisan queue:work
```

- Agendador (lembrete diário):

```bash
php artisan schedule:work
```

O agendador envia lembretes apenas a clientes cujo saldo ≥ pontos do prêmio de maior valor.

## Testes automatizados

- Suite de Feature tests cobrindo endpoints, e-mails e agendamento.

```bash
php artisan test
```

Por padrão, a suite usa SQLite em memória (configurado no `phpunit.xml`).

## Postman

- Coleção pronta em `postman_collection.json` com todos os endpoints, headers e exemplos.
- Base URL: `http://127.0.0.1:8000`
- Adicione o header `Authorization: Bearer <TOKEN>` conforme a permissão exigida.

## Dicas e troubleshooting

- E-mails não chegam:
        - Verifique credenciais do Mailtrap no `.env` e se `MAIL_MAILER=smtp`.
        - Em filas reais, confirme `queue:work` em execução.
- Lembrete diário não dispara:
        - Rode `php artisan schedule:work` localmente.
        - Confirme que há clientes com saldo ≥ prêmio de maior custo.
- Resgate retorna 422/400:
        - Verifique se o cliente possui saldo suficiente para o `reward_id` enviado.

## Personalização

- Templates de e-mail em `resources/views/emails/`.
- Ajuste prêmios iniciais em `database/seeders/RewardSeeder.php` (seeder).

## Licença

Este projeto é disponibilizado apenas para fins de avaliação técnica.
