# Legado

O Legado é uma ferramenta que busca arquivar projetos feitos dentro da instituição para servir de referência aos futuros alunos em seus respectivos projetos.

## 🚀 Começando

### Pré-requisitos
- PHP 8.1+
- Composer
- Laravel 10+
- SQLite3

### Instalação
1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/nome-do-projeto.git
2. Instale as dependências:
   ```bash
    composer install
3. Configure o ambiente:
   ```bash
   cp .env.example .env
   php artisan key:generate

## Banco de Dados (SQLite)

1. Crie o arquivo do banco:
   ```bash
   touch database/database.sqlite
2. Configure o arquivo .env:
   
   DB_CONNECTION=sqlite
   DB_DATABASE=/caminho/absoluto/para/database/database.sqlite
