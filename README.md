# 📞 Contact Management System

Um sistema completo de gerenciamento de contatos desenvolvido com Laravel, Inertia.js, Vue 3 e TailwindCSS, seguindo princípios de Clean Architecture e SOLID.

## 🚀 Tecnologias Utilizadas

### Backend
- **Laravel 11** - Framework PHP
- **MySQL** - Banco de dados
- **PHP 8.2+** - Linguagem de programação
- **Composer** - Gerenciador de dependências

### Frontend
- **Inertia.js** - Bridge entre Laravel e Vue
- **Vue 3** - Framework JavaScript
- **TailwindCSS** - Framework CSS
- **Alpine.js** - JavaScript reativo
- **Inputmask** - Máscara de entrada para telefones

### Ferramentas de Desenvolvimento
- **Docker** - Containerização
- **PHPUnit** - Testes automatizados
- **Laravel Mail** - Sistema de emails
- **Laravel Queue** - Sistema de filas

## 📋 Funcionalidades

### ✅ CRUD Completo de Contatos
- **Criar** novos contatos com validação
- **Listar** contatos com paginação (10 por página)
- **Editar** contatos existentes
- **Deletar** contatos com confirmação

### ✅ Validação e Segurança
- Validação de dados em tempo real
- Email único por contato
- Formatação automática de telefone
- Mensagens de erro em inglês

### ✅ Interface Moderna
- Design responsivo com TailwindCSS
- Modais para confirmação de ações
- Ícones intuitivos (lápis para editar, lixeira para deletar)
- Máscara de telefone brasileiro

### ✅ Funcionalidades Extras
- **Notificações por Email**: Envio automático quando contato é deletado
- **Favicon Personalizado**: Ícone SVG relacionado a contatos
- **Mensagens de Sucesso**: Feedback visual para o usuário

## 🏗️ Arquitetura

### Clean Architecture & SOLID Principles
```
app/
├── Actions/          # Lógica de negócio
├── Http/
│   ├── Controllers/  # Coordenação de requisições
│   ├── Middleware/   # Middlewares
│   └── Requests/     # Validação de dados
├── Models/           # Modelos Eloquent
├── Repositories/     # Abstração de acesso a dados
└── Providers/        # Service Providers
```

### Padrões Implementados
- **Repository Pattern** - Abstração de dados
- **Action Pattern** - Lógica de negócio isolada
- **Request Validation** - Validação centralizada
- **Service Layer** - Separação de responsabilidades

## 🛠️ Instalação

### Pré-requisitos
- **Docker** e **Docker Compose** instalados
- Git

### 🐳 Método Recomendado: Docker

#### 1. Clone o repositório
```bash
git clone https://github.com/rafaelguimaraessantos/crud-contacts.git
cd crud-contacts
```

#### 2. Configure o ambiente
```bash
cp .env.example .env
```

#### 3. Inicie os containers
```bash
docker-compose up -d
```

#### 4. Instale as dependências do PHP
```bash
docker-compose exec app composer install
```

#### 5. Gere a chave da aplicação
```bash
docker-compose exec app php artisan key:generate
```

#### 6. Execute as migrations e seeders
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

#### 7. Instale as dependências do Node.js
```bash
docker-compose exec app npm install
```

#### 8. Compile os assets
```bash
docker-compose exec app npm run dev
```

#### 9. Acesse a aplicação
- **Frontend**: http://localhost:8000
- **MySQL**: localhost:3306
- **phpMyAdmin**: http://localhost:8080

### 🔧 Método Alternativo: Instalação Local

#### Pré-requisitos
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js 18+

#### 1. Clone o repositório
```bash
git clone https://github.com/rafaelguimaraessantos/crud-contacts.git
cd crud-contacts
```

#### 2. Instale as dependências
```bash
# Backend
composer install

# Frontend
npm install
```

#### 3. Configure o ambiente
```bash
cp .env.example .env
php artisan key:generate
```

#### 4. Configure o banco de dados
```bash
# Edite o arquivo .env com suas configurações
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=contact_management
DB_USERNAME=root
DB_PASSWORD=
```

#### 5. Execute as migrations e seeders
```bash
php artisan migrate:fresh --seed
```

#### 6. Configure o email (opcional)
```bash
# Para desenvolvimento (logs)
MAIL_MAILER=log

# Para produção (SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls
```

#### 7. Compile os assets
```bash
npm run dev
```

#### 8. Inicie o servidor
```bash
php artisan serve
```

## 🐳 Comandos Docker Úteis

### Gerenciar containers
```bash
# Iniciar containers
docker-compose up -d

# Parar containers
docker-compose down

# Ver logs
docker-compose logs -f

# Reiniciar containers
docker-compose restart
```

### Executar comandos no container
```bash
# Acessar o container
docker-compose exec app bash

# Executar artisan
docker-compose exec app php artisan migrate

# Executar testes
docker-compose exec app php artisan test

# Instalar dependências
docker-compose exec app composer install
docker-compose exec app npm install
```

### Rebuild do container
```bash
# Rebuild após mudanças no Dockerfile
docker-compose up -d --build
```

## 🧪 Testes

### Executar todos os testes
```bash
# Com Docker
docker-compose exec app php artisan test

# Local
php artisan test
```

### Executar apenas testes de feature
```bash
# Com Docker
docker-compose exec app php artisan test --testsuite=Feature

# Local
php artisan test --testsuite=Feature
```

### Executar testes específicos
```bash
# Com Docker
docker-compose exec app php artisan test --filter=CreateContactsTest

# Local
php artisan test --filter=CreateContactsTest
```

## 📊 Estrutura do Banco de Dados

### Tabela `contacts`
```sql
CREATE TABLE contacts (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(191) NOT NULL,
    email VARCHAR(191) UNIQUE NOT NULL,
    phone VARCHAR(191) NULL,
    user_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    INDEX idx_name (name),
    INDEX idx_email (email),
    INDEX idx_user_id (user_id),
    INDEX idx_name_created (name, created_at),
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

## 🔧 Configurações Importantes

### Email
O sistema envia emails quando contatos são deletados. Configure no `.env`:

```env
# Desenvolvimento (logs)
MAIL_MAILER=log

# Produção (SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls
```

### Paginação
Por padrão, 10 contatos são exibidos por página. Para alterar:

```php
// Em app/Repositories/ContactRepository.php
public function paginate(int $perPage = 10)
```

## 📁 Estrutura de Arquivos

```
├── app/
│   ├── Actions/Contact/           # Lógica de negócio
│   ├── Http/
│   │   ├── Controllers/          # Controllers
│   │   ├── Middleware/           # Middlewares
│   │   └── Requests/             # Validação
│   ├── Models/                   # Modelos Eloquent
│   └── Repositories/             # Repositories
├── database/
│   ├── factories/                # Factories para testes
│   ├── migrations/               # Migrations
│   └── seeders/                  # Seeders
├── resources/
│   ├── js/Pages/Contacts/        # Páginas Vue
│   └── views/                    # Views Blade
├── routes/
│   └── web.php                   # Rotas
├── tests/
│   └── Feature/                  # Testes de feature
├── Dockerfile                    # Configuração Docker
└── docker-compose.yml            # Orquestração Docker
```

## 🚀 Deploy

### Produção com Docker
1. Configure as variáveis de ambiente no `.env`
2. Execute `docker-compose -f docker-compose.prod.yml up -d`
3. Configure o servidor web (Apache/Nginx) como proxy reverso

### Variáveis de Ambiente de Produção
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=contact_management
DB_USERNAME=usuario
DB_PASSWORD=senha-segura

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls
```

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 👨‍💻 Autor

**Rafael Guimarães Santos**
- GitHub: [rafaelguimaraessantos](https://github.com/rafaelguimaraessantos)

## 🙏 Agradecimentos

- Laravel Team pelo framework incrível
- Inertia.js pela ponte entre Laravel e Vue
- TailwindCSS pelo framework CSS utilitário
- Vue.js pela reatividade e componentes

---

⭐ Se este projeto te ajudou, considere dar uma estrela!
