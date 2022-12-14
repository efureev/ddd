# Easy ToDo List

## Description

A simple app is built with DDD only.  
Without Auth.  
Only REST JSON API.

## Functionality

- Get items list
- Add an item
- Remove an item

## Stack

- PHP: >= 8.1
- Symfony: >= 6.1
- Database:
    - Dummy
    - Elasticsearch
    - [not implement] Redis

## Install

```shell
composer install
```

## Code Structure

Здесь мы не будем выносить `UI Layer` отдельно. Наша репа - это уже папка с приложением.
В `src` - будет храниться основная БЛ. Kernel и контроллеры нашего приложения будет храниться также в папке `src`.

Во всех следующих приложениях, мы будем его выносить в отдельную папку `app` (или `apps`, если их несколько).
В папку `app` войдут:

- `bin`
- `config`
- `public`
- `src`
    - `Controller`
    - `Commands`
    - `Kernel`
- `tests`

Соответственно, в папке `src` останется только БЛ.

### Routes

- `GET /health-check`: роут проверки работоспособности приложения. Никакие наши домены не задействованы, кроме самого
  Symfony.
- `GET /list`: роут получения списка ToDo.
- `POST /create`: роут добавления пункта в список.

В двух последних роутах задействован домен `ToDo`. Он один на все приложение, поэтому в путях роутов мы его опустим.
