# Karting app
[![Tests](https://github.com/mtk3d/karting-laravel-ddd-cqrs/actions/workflows/tests.yml/badge.svg)](https://github.com/mtk3d/karting-laravel-ddd-cqrs/actions/workflows/tests.yml)

This is the project create for learn how to write EventDriven DDD application with CQRS in Laravel.
I had some problems how to do that properly. This project is my testing app. I'm trying to handle those problems:
- Working with repository pattern in ActiveRecord ORM for testing without using database
- How to handle Read Models in CQRS
- Search the contexts / modules in domain logic
- Communication between contexts / modules (Process Managers)

Thanks to Andrzej Krzywda for instagram private conversations about handling DDD problems in Active Record.
I also learn a lot from Domain Driven Rails book by Arkency.
I think Rails and Laravel are similar frameworks, but there is a bit more articles / etc. about good practices in Rails.

# Domain
I had tried to make Event Storming for this application. Everything is described [here](doc/event-storming.md).

# Run the application
TODO
