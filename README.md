# Sistema de Gestão de Créditos Tributários

Sistema web para cadastro de empresas e cálculo de créditos tributários de ICMS.

https://github.com/user-attachments/assets/a6f48b6e-a6ca-4a5e-910d-0309db95d279

## 🎯 Sobre

Aplicação que permite o cadastro de empresas com seus valores de ICMS pago e créditos possíveis, gerando relatórios com cálculo automático de percentual de crédito. Inclui dashboard com visualização gráfica dos dados e exportação de relatórios em PDF.

## 🛠️ Tecnologias

| Camada | Tecnologia |
|--------|------------|
| Backend | PHP 8.3, Laravel 12 |
| Frontend | Blade, Tailwind CSS 4, Chart.js |
| Banco de Dados | SQLite |
| Infraestrutura | Docker, Docker Compose |
| Build | Vite |
| Testes | Pest PHP |
| PDF | DomPDF |

## 🚀 Como Rodar

### Pré-requisitos

- Docker e Docker Compose instalados

### Instalação

```bash
# Clone o repositório
git clone https://github.com/augusto-dmh/company-credit-management.git
cd company-credit-management

# Copie o arquivo de ambiente
cp .env.example .env

# Suba os containers
docker compose up -d --build

# Instale as dependências
docker compose exec app composer install
docker compose exec app npm install

# Gere a chave da aplicação
docker compose exec app php artisan key:generate

# Execute as migrations
docker compose exec app php artisan migrate
```

### Testes

```bash
docker compose exec app php artisan test
```

## ✨ Features

- **Cadastro de Empresas**: Formulário com validação de CNPJ (dígitos verificadores)
- **Dashboard**: Cards com totalizadores e gráficos interativos
- **Relatórios**: Visualização individual por empresa com percentual de crédito
- **Exportação PDF**: Download de relatório formatado
- **AJAX**: Submissão de formulário sem recarregar página (opcional)
- **Máscara de CNPJ**: Formatação automática no input

## 🏗️ Decisões Técnicas

### Arquitetura

- **Service Layer**: Lógica de negócio isolada em `EmpresaService` para facilitar testes e manutenção
- **Form Requests**: Validação separada em classes dedicadas (`StoreEmpresaRequest`)
- **Custom Rules**: Validação de CNPJ com verificação de dígitos em `App\Rules\CnpjValido`

### API

- **Rotas separadas**: Web para SSR, API para AJAX (`/api/empresa`)
- **Controller dedicado**: `Api\EmpresaController` retorna JSON

### Frontend

- **Tailwind CSS 4**: Nova sintaxe com `@import 'tailwindcss'`
- **Chart.js via Vite**: Importado como módulo, não CDN como geralmente vejo por aí (acho má prática, vi muita empresa sofrendo com a queda da AWS por isso)
- **Scripts modulares**: `resources/js/charts.js` separado do `app.js` e <script> "não abusado" (já sofri dando manutenção em blade view com tag script gigante).

### Infraestrutura

- **SQLite**: Banco simples para desenvolvimento, sem necessidade de container extra dedicado a um mysql da vida
- **Single container**: PHP CLI com Artisan serve, adequado para desenvolvimento
- **Vite no Docker**: Configurado com `host: 0.0.0.0` para acesso externo

### Testes

- **Pest PHP**: Sintaxe expressiva (para qualquer um ler e entender) com `describe`/`it`
- **Feature vs Unit**: Testes apenas unitários (decidi por ser mais quick-win que de integração e de mais fácil manutenibilidade caso fosse necessário)
