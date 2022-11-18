# Структура кода PHP-приложения

## Общие принципы организации кода репозитория

### Структура папок

- Код бизнес-логики должен храниться в папке `src`
- Конфиги и прочие настройки не хранятся в кодовой базе и лежат в папке `config`
- Тесты хранятся в папке `tests`
- Общедоступные файлы хранятся в папке `public`
- (необязательно) Документации содержится в папке `docs`
- (необязательно) CI содержится в папке `.ci`
    - Скрипты (bash, js, etc..) для сборки проекта - `.ci/scripts`
    - Docker - `.ci/docker`
    - Конфиги CI, Etc - `.ci/etc`

### Необходимые файлы репозитория

- `Readme.md` - Файл описания репозитория. В нем должны быть отражены следующие детали:
    - Что за репозиторий и описание его конечного продукта
    - Требования для запуска конечного продукта
    - Как развернуть продукт на той или иной инфраструктуре
    - Как запустить ту или иную функциональность продукта
    - Как запустить тесты
    - Куда обращаться за помощью и писать баги

### Необязательные (но очень приветствуются) файлы репозитория

- Файлы настроек различных линтеров, тестовых фреймворков. Такие файлы должны существовать в двух видах:
    - Файл, включенный в git. Неизменяемый файл для продуктовой CI инфраструктуры. Пример: `phpcs.xml`.
    - Файл, не включенный в git. Локальный файл настроек, которые переписывает файл основных настроек для локальной
      инфраструктуры. Выносятся в `.gitignore`. Пример: `phpunit.xml.dist`.

  Примеры таких пакетов:
    - Тестовые фреймворки:
        - [PHPUnit](https://phpunit.de)
        - [Codeception](https://codeception.com)
    - Линтеры:
        - [PHP Code Standard Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)
        - [PHP Code Sniffer](https://github.com/squizlabs/PHP_CodeSniffer)
        - [Php Inspections (EA Extended)](https://github.com/kalessil/phpinspectionsea)
    - Статические анализаторы:
        - [PHPStan](https://github.com/phpstan/phpstan)
        - [Psalm](https://psalm.dev)
        - [Phan](https://github.com/phan/phan)

## Структура кода приложения DDD

Определимся с хранением слоев проекта. Все слои проекта должны находится в папке `src`.
Но! Слой `UI (Presentation) Layer` может быть вынесен в отдельную папку `app` (или `apps`, если их несколько).
Что соответствует концепции DDD - бизнес-логика находится в `src`, а в `app` - ее вызовы.

В дальнейшем мы будем выносить данный слой в `app(s)`, что бы разделить слои. Не будем смешивать `UI` и `Application`
слои.

### Рассмотрим структуру кода бизнес-логики (`src`)

```
src
|-- Shared // Общее ядро: Общая `Инфрастуктура (Infrastructure)` и `Предметная область (Domain)` расшаненные между различными `Ограниченными контекстами (Bounded Contexts)`
|   |-- Domain
|   |   `-- Entity
|   |       `-- User.php
|   `-- Infrastructure
|
|-- Library // Bounded Context: Особенности, относящиеся к одному функциональному признаку
|   |-- Books // SubDomain `Books` inside Bounded Context 
|   |   |-- Application // Внутри данного слоя все структурировано по `Actions`
|   |   |   `-- Find // `Unit of Work` // Action, который ищет книгу
|   |   |       |-- FindAll.php
|   |   |       `-- FindOne.php 
|   |   |-- Domain
|   |   |   |-- Entity
|   |   |   |    `-- Book.php // Сущность `Book`
|   |   |   `-- Repository
|   |   |       `-- BookRepositoryInterface.php // Интерфейс репозитория `Book`
|   |   `-- Infrastructure
|   |   |   `-- Repository
|   |   |       |-- BookRepositoryMysql.php // Реализация репозитория `Book`, работающий с MySQL
|   |   |       `-- BookRepositoryPg.php // Реализация репозитория `Book`, работающий с Postgres
|   |
|   `-- Comments // SubDomain `Comments` inside Bounded Context 
|       |-- Application
|       |-- Domain
|       `-- Infrastructure
```
