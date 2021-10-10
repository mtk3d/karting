# Karting app :racing_car:
[![Tests](https://github.com/mtk3d/karting-laravel-ddd-cqrs/actions/workflows/tests.yml/badge.svg)](https://github.com/mtk3d/karting-laravel-ddd-cqrs/actions/workflows/tests.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/8dd235e0927737ae434b/maintainability)](https://codeclimate.com/github/mtk3d/karting-laravel-ddd-cqrs/maintainability)

This is the project created to learn how to write EventDriven DDD application with CQRS in Laravel. I had some problems with how to do that properly. This project is my testing app.
I'm trying to handle those problems:
- Working with repository pattern and Aggregates in ActiveRecord ORM for testing without using database
- How to handle Read Models in CQRS
- Search the contexts / modules in domain logic
- Communication between contexts / modules (Process Managers)

Thanks to Andrzej Krzywda for Instagram's private conversations about handling DDD problems in Active Record.
The [RES ecommerce](https://github.com/RailsEventStore/ecommerce) is also really helpful for me in this project development.  
I also learn a lot from Domain Driven Rails book by Arkency.
Also thanks for Mariusz Gil and Kuba Pilimon for [Aggregates by example](https://github.com/mariuszgil/aggregates-by-example) repository.
I modeled my availability context on this example.

## :blue_book: Domain
I had tried to make Event Storming for this application. Everything is described [here](doc/event-storming.md).

## :rocket: Run the application
To run this application locally with docker, just run:
```bash
make up
```
This command will configure app, create containers and run db migrations.
Everything is executed by docker run/exec, so you need only docker installed localy.

If you work in non-native environment for docker like MasOS/Windows it could be slow.
If you want, you can install all dependencies, and speed up work with app.

Requirements:
- PHP >=8.0
- Node >=14
- Yarn >=1.22
- Composer >= 2.0

Then you can run make targets locally, omitting the docker run:
```bash
make up SKIP_DOCKER=true
```

## :speech_balloon: API
API is documented as Postman collection file [here](doc/Karting.postman_collection.json).
