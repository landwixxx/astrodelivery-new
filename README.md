## Astrodelivery

## Servidor
- PHP v7.4
- MySQL v5^

## Frameworks
- Laravel  v8.83
- Bootstrap v5.2.1

## Libs
- Font Awesome v6.2.0
- Google Fonts
- https://imask.js.org/
- https://select2.org/
- Tailwind em template dashboard

## Pacotes Laravel
- https://laravel.com/docs/7.x/authentication#authentication-quickstart
- https://github.com/squizlabs/PHP_CodeSniffer
- https://github.com/lucascudo/laravel-pt-BR-localization
- https://larapex-charts.netlify.app/
- https://github.com/LaravelLegends/pt-br-validator
- https://spatie.be/docs/laravel-permission/v5/installation-laravel

## API
- [Manual integração 1.5](./doc/api/1.%20Cópia%20de%20Manual%20integração%201.5.docx)
- [Complemento do manual integração 1.5 revisão 1,3](./doc/api/2.%20complemento%20do%20manual%20integração%201.5%20revisão%201,3.docx)

Exemplo de endpoint: http://127.0.0.1:8000/api/integracao?empresa=strikefoods

## Instalação
### Instalar as dependências
```
composer install
```

### Copiar ``.env.example`` para ``.env``
```
copy .env.example .env
```

### Gerar key do projeto
```
php artisan key:generate
```

### Configurar o banco de dados e executar o migrations
```
php artisan migrate
```

**Executar os seeders para criar permissões**
```
php artisan db:seed RolesAndPermissionsSeeder
```

**Executar os seeders para OrderStatus**
```
php artisan db:seed OrderStatusSeeder
```

**Executar os seeders para criar dados fakes para teste (opcional)**
```
php artisan db:seed
```

**Ou usar um desses 2 comandos em vez dos outros a cima**

 - Executar migrations com seeders para permissões e valores padrão para OrderStatus
```
php artisan run-migrations
```

- Executar migrations com seeders para permissões, valores padrão para OrderStatus e dados fakes
```
php artisan run-migrations-seed
```

**Login**
```
email: admin@teste.com
email: logista@teste.com
email: cliente@teste.com

senha: password
```

### Criar um link simbólico para 'storage'
```
php artisan storage:link
```

### Configurar para permitir subdominios
Cada loja terá um subdominio e é preciso configurar o dns para permitir que o sistema funcione

#### Configurando em localhost com o xampp
Ref: https://central.linkhostbrasil.com.br/index.php?rp=%2Fknowledgebase%2F37%2FComo-criar-um-subdominio-no-Xampp.html&language=portuguese-pt

Para testar em localhost com xampp vai ser possível apenas com um subdominio de loja. Configure 
o virtualhost para utilizar por exemplo o domínio ``astrodelivery.com.br`` e ``teste.astrodelivery.com.br``

``astrodelivery.com.br`` vai ser o endereço que o lojista e admin podem fazer login e ter acesso ao sistema e ``teste.astrodelivery.com.br`` vai ser o enderço da loja, é bom executar os seeders que já vai criar essa loja para teste.

#### Configurando em servidor online
Pesquisar por "configura registro coringa dominio wildcard"

## Configura o url do site no arquivo ``.env``
```
APP_URL=http://127.0.0.1:8000/
ASSET_URL=http://127.0.0.1:8000/
```

### Iniciar o servidor em localhost
```
php artisan serve
```
