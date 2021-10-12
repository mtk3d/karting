# Couple CRUD modules with app

* Status: accepted <!-- optional -->
* Deciders: @mtk3d <!-- optional -->
* Date: 12-10-2021 <!-- optional -->

## Context and Problem Statement

Making read models for crud modules doesn't make sens.
Here in domain model I use Eloquent `Model` in domain entities, so
it doesn't make a difference for coupling. Every module is coupled
to Laravel Eloquent, so it's coupled to app.

## Decision Drivers <!-- optional -->

* Using Laravel with Eloquent
* Want to make small code base
* Easier objects and modules management

## Considered Options

* Remove read models for CRUDs modules, and couple module with app
* Rewrite CRUD's models data by events to the read models
* Create pure PHP CRUD modules, and manually map them to database

## Decision Outcome

Chosen option: "Remove read models for CRUDs modules, and couple module with app", because it's
the best option at this moment. It doesn't make necessary complexity, or big code base
with manual mapping.

### Positive Consequences <!-- optional -->

* Less code needed for making CRUD modules
* Less complexity right now
* Less code, fewer bugs

### Negative Consequences <!-- optional -->

* In the future, some relations to CRUD modules may be needed. That may do a lot of complexity

## Pros and Cons of the Options <!-- optional -->

### Remove read models for CRUDs modules, and couple module with app

* Good, because not require additional code
* Good, because doesn't make duplication
* Bad, because make coupling to the framework
* Bad, because makes technical debt

### Rewrite CRUD's models data by events to the read models

* Good, because doesn't make coupling by using entities in app directly
* Bad, because need duplication
* Bad, because make some complication in simple CRUDs

### Create pure PHP CRUD modules, and manually map them to database

* Good, because doesn't make any coupling to the code
* Good, because it may be reused in non laravel projects
* Bad, because need manually map entities to database objects
* Bad, because makes bigger code base
