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
   git clone https://github.com/luke96neto/Legado.git
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
3. Criar e executar migrations:
   ```bash
   php artisan migrate
   
## Configuração de Login via GitHub

# 1. Criar OAuth Application

1. Acesse [GitHub Developer Settings](https://github.com/settings/developers)
2. Clique em "New OAuth App"
3. Configure:
   - Name: `Legado`
   - Homepage: `http://localhost:8000`
   - Callback: `http://localhost:8000/auth/github/callback`

# 2. Configurar Ambiente

Adicione ao `.env`:
```env
GITHUB_CLIENT_ID=seu_id_aqui
GITHUB_CLIENT_SECRET=seu_secret_aqui
GITHUB_REDIRECT=http://localhost:8000/auth/github/callback

    
