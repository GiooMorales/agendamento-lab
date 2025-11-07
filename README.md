# Agendamento Lab

Aplicacao web para gerenciar a reserva de laboratorios e salas em um ambiente academico. Permite cadastrar espacos, controlar disponibilidade por aula/turno e efetuar agendamentos com atualizacao em tempo real para todos os usuarios autenticados.

<img width="1856" height="881" alt="image" src="https://github.com/user-attachments/assets/b02d596a-8405-48ee-9c4b-197e6ed20be0" />

<img width="1472" height="623" alt="image" src="https://github.com/user-attachments/assets/5de3831a-bb01-48a7-b1f0-bbb1bd7f3605" />

<img width="1510" height="710" alt="image" src="https://github.com/user-attachments/assets/3039c172-4024-4c58-b7f0-410cf04b3ce9" />

<img width="1478" height="777" alt="image" src="https://github.com/user-attachments/assets/0cb4663c-fc8e-4df7-8e07-baebe2beeba1" />


## Indice

- [Visao Geral](#visao-geral)
- [Funcionalidades](#funcionalidades)
- [Arquitetura e Stack](#arquitetura-e-stack)
- [Pré-requisitos](#pré-requisitos)
- [Configuracao Rapida](#configuracao-rapida)
- [Executando em Desenvolvimento](#executando-em-desenvolvimento)
- [Jobs em Tempo Real](#jobs-em-tempo-real)
- [Estrutura de Pastas](#estrutura-de-pastas)
- [Testes](#testes)
- [Checklist para Deploy](#checklist-para-deploy)
- [Contribuicao](#contribuicao)

## Visao Geral

O sistema oferece um painel autenticado onde docentes e tecnicos podem:

- Registrar novos laboratorios/salas com capacidade e descricao.
- Visualizar uma tabela dinamica com todas as reservas do dia.
- Realizar agendamentos em um clique, bloqueando o espaco para a aula selecionada.
- Receber atualizacoes instantaneas quando outro usuario efetua uma reserva no mesmo dia.

Todo o fluxo e protegido por autenticacao. Apenas usuarios logados acessam os recursos de gestao de espacos e agendamentos.

## Funcionalidades

- Cadastro completo de espacos com edicao e exclusao via confirmacao modal.
- Agenda diaria organizada por numero de aula (1-7) e por laboratorio.
- Agendamento em tempo real utilizando Laravel Echo e Pusher para broadcast.
- Feedback visual para reservas concluidas e toasts de sucesso para operacoes de cadastro.
- Script de desenvolvimento que orquestra servidor HTTP, fila e Vite com uma so chamada.

## Arquitetura e Stack

- **Backend:** Laravel 12 (PHP 8.2), Eloquent ORM, eventos/broadcasting.
- **Frontend:** Blade, Bootstrap, Vite, Tailwind (pronto para uso) e componentes JS dedicados (`public/js`).
- **Banco de Dados:** Relacional (MySQL/PostgreSQL/SQLite) via migrations.
- **Tempo Real:** Laravel Echo + Pusher Channels (ou qualquer provedor compatível com protocolo Pusher).
- **Filas:** `database` driver padrao; jobs de broadcast processados via `queue:listen`.

## Pré-requisitos

- PHP 8.2+
- Composer 2.6+
- Node.js 20+ e npm 10+
- Banco de dados compatível (MySQL 8, MariaDB 10.6, PostgreSQL 14 ou SQLite)
- Redis opcional (para escalonar filas/broadcast)

## Configuracao Rapida

```bash
git clone https://github.com/<sua-conta>/agendamento-lab.git
cd agendamento-lab
cp .env.example .env
composer install
php artisan key:generate
```

Edite o arquivo `.env` e ajuste ao menos:

- `APP_URL`
- `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `BROADCAST_DRIVER=pusher`
- Credenciais Pusher (`PUSHER_APP_ID`, `PUSHER_APP_KEY`, `PUSHER_APP_SECRET`, `PUSHER_APP_CLUSTER`)

Depois aplique as migrations (e seeds, se houver):

```bash
php artisan migrate
php artisan db:seed   # opcional
```

Instale as dependencias do frontend:

```bash
npm install
```

## Executando em Desenvolvimento

### Opcao 1: Script unificado

```bash
composer run dev
```

Esse comando executa simultaneamente `php artisan serve`, `php artisan queue:listen` e `npm run dev` usando `concurrently`.

### Opcao 2: Processos separados

```bash
php artisan serve
php artisan queue:listen --tries=1
npm run dev
```

Em ambos os casos o frontend ficara disponivel em `http://localhost:8000` (ou porta configurada) com assets processados pelo Vite.

> **Dica:** ajuste `resources/js/bootstrap.js` com a sua chave Pusher para que o Echo conecte corretamente.

## Jobs em Tempo Real

- Cada reserva dispara o evento `SchedulingCreated`, transmitido no canal publico `schedules` com o nome `scheduling.created`.
- A tela de agendamentos escuta esse canal via `window.Echo` e atualiza automaticamente a celula correspondente.
- Para evitar delays, mantenha o worker de filas ativo (`php artisan queue:listen` ou `queue:work`).

## Estrutura de Pastas

- `app/Http/Controllers`: Fluxos de autenticacao (`UserController`), gestao de espacos (`PlaceController`) e agenda (`SchedulingController`).
- `app/Events/SchedulingCreated.php`: Evento broadcast com os dados da reserva.
- `resources/views`: Telas Blade para login, cadastro, listagens e agenda.
- `public/js`: Scripts auxiliares para modal de confirmacao e exibicao de toasts.
- `database/migrations`: Estrutura das tabelas `places` e `schedulings`, alem das tabelas padrao do Laravel.
- `resources/js/bootstrap.js`: Inicializacao do Laravel Echo com configuracao Pusher.

## Testes

```bash
php artisan test
```

Atualmente o projeto contem os testes de exemplo. Reforce a cobertura adicionando cenarios para autenticacao, cadastro de espacos e fluxo de agendamento.

## Checklist para Deploy

- [ ] Configurar variaveis sensiveis (`APP_KEY`, `APP_URL`, credenciais de banco, Pusher, fila)
- [ ] Executar migrations (`php artisan migrate --force`)
- [ ] Configurar queue worker em segundo plano (Supervisor, Horizon ou equivalente)
- [ ] Gerar build de assets (`npm run build`)
- [ ] Configurar cache de configuracao/rotas (`php artisan config:cache`, `php artisan route:cache`)
- [ ] Definir storage link se necessario (`php artisan storage:link`)

## Contribuicao

1. Faça um fork do repositorio.
2. Crie um branch com a sua feature: `git checkout -b feat/minha-feature`.
3. Escreva testes quando fizer sentido.
4. Envie um pull request descrevendo claramente o contexto e o impacto da mudanca.

Ficou com duvidas ou encontrou um bug? Abra uma issue descrevendo o passo a passo para reproduzir. Obrigado por contribuir!
