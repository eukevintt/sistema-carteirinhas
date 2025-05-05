## 📖 Sobre

Este projeto foi desenvolvido para atender às necessidades de um **clube de associados da Petrobras**, com o objetivo principal de **reduzir os custos com impressão de carteirinhas físicas**.

A plataforma permite que **associados e seus dependentes com matrícula válida realizem o cadastro e tenham acesso à versão digital da carteirinha diretamente pelo sistema**. Além disso, oferece ao clube uma visão centralizada de:

-   Quantos associados e dependentes estão cadastrados;
-   Quantos estão, de fato, utilizando o clube;
-   Estatísticas que ajudam na **gestão e tomada de decisões administrativas**.

Trata-se de uma solução moderna, sustentável e de fácil acesso, que substitui processos manuais por um controle digital inteligente.

## ⚙️ Funcionalidades

-   Cadastro de **associados** e **dependentes** com validação por matrícula.
-   Dashboard com:
    -   Botão para **gerar carteirinha digital**.
    -   Indicadores de uso: número de usuários, associados, dependentes e carteirinhas geradas.
    -   Lista com as **últimas carteirinhas geradas**.
-   Gestão completa de:
    -   Associados
    -   Dependentes
    -   Usuários do sistema
-   Possibilidade de **atualizar dados pessoais** diretamente pela interface.

## 🚀 Instalação

Siga os passos abaixo para rodar o projeto localmente:

### 🔧 Pré-requisitos

-   PHP >= 8.1
-   Composer
-   MySQL ou PostgreSQL
-   Node.js e NPM
-   Laravel CLI (opcional, mas recomendado)

### 📦 Passo a passo

```bash
# Clone o repositório
git clone https://github.com/eukevintt/sistema-carteirinhas.git
cd sistema-carteirinhas

# Instale as dependências do PHP
composer install

# Copie o arquivo de ambiente e configure as variáveis
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Configure as credenciais do banco de dados no arquivo .env
# DB_DATABASE, DB_USERNAME, DB_PASSWORD, etc.

# Rode as migrations (e seeders, se houver)
php artisan migrate

# Instale as dependências do frontend (se aplicável)
npm install && npm run dev

# Inicie o servidor local
php artisan serve
```

## 🛠 Tecnologias

Este projeto foi desenvolvido com as seguintes tecnologias:

-   **Laravel** – framework PHP para aplicações web robustas
-   **Blade** – engine de templates do Laravel
-   **Blade Components** – componentes reutilizáveis para views
-   **Tailwind CSS** – framework utilitário de CSS
-   **Flowbite** – biblioteca de componentes UI baseada em Tailwind
-   **Alpine.js** – interatividade leve no frontend
-   **MySQL** – banco de dados relacional
-   **Dompdf** – geração de PDFs diretamente do HTML (carteirinhas)
-   **Laravel Excel (Maatwebsite)** – exportação de dados para Excel
