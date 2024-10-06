# !Laravel-API

> ### Laravel-api that contain basic function for book management (CRUD, auth, advanced patterns and more).

This repo is functionality complete — Questions and criticism are very welcome!

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/11.x/installation)

Clone the repository

    git clone https://github.com/mademuliana/laravel-api.git

Switch to the repo folder

    cd laravel-api

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

**Make sure you set the correct database connection information before running the migrations**

Open the DummyDataSeeder and set the factory you want to run 
  
    database/seeds/DummyDataSeeder.php

Run the database seeder and you're done

    php artisan db:seed

**Populate the database with seed data. This can help you to quickly start testing the api or start using it with ready content. And avoid to use manual/db/eloquent insertion for table that doesn't have default value. Always use factory to populate that kind table**  

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**Use BookManagement.postman_collection.json for pre-made mappings to hit the endpoint, and don’t forget to configure the environment, especially the {{base_url}} variable, to ensure it functions properly.**

## Testing

this project already implement phpunit framework, run this command to run the test case

    php artisan test
    php artisan test --filter <class>
    php artisan test --filter <class>::<<function>>

### Testing function

testing function
| **function** 	                                     | **class**            | **expected value**  |
|----------------------------------------------------|----------------------|---------------------|
| can get all author                                 | AuthorTest           | yes/true            | 
| can get single author                              | AuthorTest           | yes/true            |
| can create author                                  | AuthorTest           | yes/true            |
| can update author                                  | AuthorTest           | yes/true            |
| can delete author                                  | AuthorTest           | yes/true            |
| create author fails when all fields are missing    | AuthorValidationTest | yes/true            |
| create author fails when name is missing           | AuthorValidationTest | yes/true            |
| create author fails when name is empty name        | AuthorValidationTest | yes/true            |
| author validation fails with invalid date          | AuthorValidationTest | yes/true            |
| author validation fails with future date           | AuthorValidationTest | yes/true            |
| author validation passes with valid data           | AuthorValidationTest | yes/true            |
| can get all books                                  | bookTest             | yes/true            |
| can get single book                                | bookTest             | yes/true            |
| can create book                                    | bookTest             | yes/true            |
| can update book                                    | bookTest             | yes/true            |
| can delete book                                    | bookTest             | yes/true            |
| create book fails when all fields are              | bookValidationTest   | yes/true            |
| create book fails when title is                    | bookValidationTest   | yes/true            |
| create book fails when author id is                | bookValidationTest   | yes/true            |
| create book fails when title is empty              | bookValidationTest   | yes/true            |
| book validation fails with invalid                 | bookValidationTest   | yes/true            |
| book validation fails with future                  | bookValidationTest   | yes/true            |
| book validation fails with invalid author id       | bookValidationTest   | yes/true            |
| book validation passes with valid data             | bookValidationTest   | yes/true            |

# Code overview
## Structure
- `app`- Core application logic and structure.
- `app/Http/Controllers/` - Handle incoming requests and responses.
- `app/Http/Classes/` - Custom classes for business logic.
- `app/Http/Requests/` - Validate incoming request data.
- `app/Http/Resources/` - Transform models for API responses.
- `app/Interfaces/` - Define contracts for services and repositories.
- `app/Models/` - Eloquent models representing database entities.
- `app/Providers/` - Register application services and configurations.
- `app/Repositories/` - Data access layer for models.
- `database/factories/` - Generate test data for models.
- `database/migrations/` - Manage database schema changes.
- `database/seeds` - Populate database with initial data.
- `routes` - Define application route handling.
- `tests` - Automated tests for application functionality.
- `tests/Feature` - Test the application's features and endpoints.

## Environment variables

- `.env` - Environment variables can be set in this file
- `.env.testing` - Environment variables for testing can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.


