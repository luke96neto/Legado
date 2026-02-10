# Legado

O Legado é uma ferramenta que busca arquivar projetos feitos dentro da instituição para servir de referência aos futuros alunos em seus respectivos projetos.

## Começando

### Pré-requisitos
- PHP 8.2 ou superior
- Composer 2.2 ou superior
- MySQL 8.0+ ou MariaDB 10.6+
- Node.js 18+ e npm 9+

### Instalação
1. Clone o repositório:
   
   ```bash
   git clone https://github.com/luke96neto/Legado.git
3. Instale as dependências:
   ```bash
    composer install
   ```
   ```bash
    npm install
4. Gere o arquivo de configuração válido e a chave da aplicação:
   ```bash
   cp .env.example .env
   ```
   ```bash
   php artisan key:generate
## Banco de Dados (MySql)   
1. No .env configure os dados de acesso ao mysql

   ```env
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_USERNAME=root
   DB_PASSWORD=
   ```
1. Gere o banco:
   ```bash
   php artisan migrate
3. (Opcional) Popular o banco:
   ```bash
   php artisan db:seed
   
## Rodando o projeto
1. Compile o front end
    ```bash
    npm run dev
2. Crie o servidor local
    ```bash
    php artisan serve

3. Acesse http://localhost:8000 no seu navegador

## Configuração de Login via GitHub e Google (Opcional)

1. Criar OAuth Application via GitHub
   
   1. Acesse [GitHub Developer Settings](https://github.com/settings/developers)
   2. Clique em "New OAuth App"
   3. Configure:
       - Name: `Legado`
       - Homepage: `http://localhost:8000`
       - Callback: `http://localhost:8000/auth/github/callback`

    4. Adicione ao seu arquivo .env:

    ```env
    GITHUB_CLIENT_ID=seu_client_id_aqui
    GITHUB_CLIENT_SECRET=seu_client_secret_aqui
    GITHUB_REDIRECT_URI=http://localhost:8000/auth/github/callback
    ```
2. Configuração do Google OAuth
    1. Acesse o [Google Cloud Console](https://console.cloud.google.com)
    2. Crie um novo projeto ou selecione um existente
    3. Navegue para APIs & Services → OAuth consent screen
    4. Configure a tela de consentimento:
        - User Type: External
    6. Preencha as informações obrigatórias do aplicativo
    7. Navegue para Credentials → Create Credentials → OAuth 2.0 Client IDs
    8. Configure o cliente OAuth:
        - Application Type: Web application
        - Name: Legado
        - Authorized redirect URIs:`http://localhost:8000/auth/google/callback`
        
    9. Adicione ao seu arquivo .env:

    ```env
    GOOGLE_CLIENT_ID=seu_client_id_aqui
    GOOGLE_CLIENT_SECRET=seu_client_secret_aqui
    GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
    ```

    
