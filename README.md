Zentlix Main Bundle
=================

This bundle is part of Zentlix CMS. Currently in development, please do not use in production!

## Установка
- Установить Symfony 4.4: 
```bash
   composer create-project symfony/skeleton:^4.4.* my_project_name
```
- Установить MainBundle:
```bash
    cd my_project_name   
    composer require zentlix/main-bundle
```
- Настроить подключение к базе данных.
- Настроить язык приложения в файле config\packages\translation.yaml. На данный момент поддерживаемые языки ru и ua.
- Создать миграцию:
```bash 
    php bin/console doctrine:migrations:diff
```
- Выполнить миграцию: 
```bash 
    php bin/console doctrine:migrations:migrate
```
- Запустить установку Zentlix CMS:
```bash 
    php bin/console zentlix_main:install
```