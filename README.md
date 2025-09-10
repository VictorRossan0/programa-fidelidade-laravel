# Programa de Fidelidade - Backend Laravel

API desenvolvida para gerenciar o programa de fidelidade de uma empresa, permitindo cadastro de clientes, pontuação por compras, resgate de prêmios e disparo de e-mails automáticos.

## Funcionalidades

- Cadastro e consulta de clientes
- Pontuação automática: 1 ponto a cada R$5,00 gastos
- Resgate de prêmios fixos (Suco de Laranja, 10% de desconto, Almoço especial)
- Consulta de saldo e histórico de resgates
- Disparo de e-mails automáticos ao pontuar, resgatar prêmio e lembrete diário
- Autenticação via Bearer Token com permissões específicas
- Agendamento diário para envio de lembrete aos clientes elegíveis

## Tecnologias Utilizadas

- Laravel 12+
- MySQL
- Eloquent ORM
- Jobs & Queues
- Mail (Mailtrap)
- Middlewares personalizados

## Instalação e Setup

1. Clone o repositório

    ```sh
    git clone https://github.com/VictorRossan0/programa-fidelidade-laravel.git
    ```

2. Instale as dependências:

    ```bash
    composer install
    ```

3. Configure o arquivo `.env` com dados do MySQL e Mailtrap
4. Rode as migrations e seeders:

    ```bash
    php artisan migrate --seed
    ```

5. Inicie o servidor:

    ```bash
    php artisan serve
    ```

## Endpoints Principais

Consulte a documentação completa em [`docs/Documentacao_Fidelidade.md`](docs/Documentacao_Fidelidade.md).

## Autenticação

Todos os endpoints exigem Bearer Token. Veja os tokens e permissões na documentação.

## E-mails Automáticos

- Pontuação e resgate de prêmio disparam e-mails para o cliente
- Lembrete diário para clientes com saldo suficiente para o prêmio máximo
- Visualize os e-mails recebidos via Mailtrap

## Testes

Recomenda-se testar os endpoints via Postman ou Insomnia.

## Observações

- O projeto está pronto para ser apresentado e validado conforme requisitos do teste técnico.
- Templates dos e-mails podem ser personalizados em `resources/views/emails/`.

---

Desenvolvido para o Teste Técnico - Vaga Desenvolvedor Backend Pleno
