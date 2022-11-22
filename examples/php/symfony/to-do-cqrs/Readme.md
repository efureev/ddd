# ToDo List with CQRS implementation

## Description

- A simple app is built with DDD.
- Only REST JSON API.
- Implemented `CQRS`
- Implemented `EBS`
- Without Auth.
- `UI Layer` is placed in a separate folder - `app`.
- Has Request Middleware
- Add `Specifications` - `Criteria` to search `Entity`

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

### Routes

- `GET /health-check`: роут проверки работоспособности приложения. Никакие наши домены не задействованы, кроме самого
  Symfony.
- `GET /list`: роут получения списка ToDo.
- `POST /create`: роут добавления пункта в список.

В двух последних роутах задействован домен `ToDo`. Он один на все приложение, поэтому в путях роутов мы его опустим.
