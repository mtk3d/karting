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
The [RES example repository](https://github.com/RailsEventStore/cqrs-es-sample-with-res) is also really helpful for me in this project development.  
I also learn a lot from Domain Driven Rails book by Arkency.
I think Rails and Laravel are similar frameworks, but there is a bit more articles / etc. about good practices in Rails.

## :blue_book: Domain
I had tried to make Event Storming for this application. Everything is described [here](doc/event-storming.md).

## :rocket: Run the application
1. Copy config file
```bash
cp .env.example .env
```
2. Run docker-compose command
```bash
docker-compose up -d
```
3. Run migrations
```bash
docker-compose run --rm app php artisan migrate
```
## :speech_balloon: API
API is documented as Postman collection file [here](doc/Karting.postman_collection.json).
