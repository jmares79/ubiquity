# Ubiquity API challenge

To create a project (Written using Laravel framework) to parse, interpret and solve a single or a collection of formulas.
The formulas will come in an input in XML format, in a specific structure, in order for them to be pasrsed and interpreted.

**NOTE: The XML input is in a format that can create troubles of parsing. More specifically, PHP parses in a different way an XML with this format:
    <add>
        <number>X</number>
        <multiply>
            <number>Y</number>
            <number>Z</number>
        </multiply>
    </add>
    Than it does for:
    <add>
        <multiply>
            <number>Y</number>
            <number>Z</number>
        </multiply>        
        <multiply>
            <number>Y</number>
            <number>Z</number>
        </multiply>
    </add>
    As in the second case an array of `multiply` types is created, having to re check and re parse the created array.    
    As this is an assigment with a tight deadline, and having the requirements says an XML for a specific type, onyl those simple ones are valid**

**NOTE 2: In a production environment, a XSD schema validation has to be set, for timing purposes only valid XML are accepted for parsing.**

## Structure of the project

Ubiquity REST API is based on the [Laravel framework](https://laravel.com/), using several models to map back end tables.

The reason for using Laravel is that is an up-to-date modern MVC framework, that has all needed capabilites for building, maintaining documenting and testing any project in a painless way.

### Data models

The project is structured with the following resources, as follows:

* __Expression Resources__ Which provides a controller, a model and some helper classes for handling the XML expressions and its parsing.
* __Utils Classes__ Utility classes for creating an Expression Tree, Nodes and helper cleaning formula capabilities.
* __Migrations & Factory seeders__ Which helps creating all the DDBB Schema AND provides fake data to test the API

### Controllers & routing

The requests are handled by `App\Http\Controllers\*` that provides a set of actions to be called on every request.

As in every Laravel project, each action is mapped to a route in `routes\api.php`. The routes and mappings are self explanatory, but I'll explain them:

* HTTP GET `api/expressions` - Returns all expression for a certain customer
* HTTP GET `api/expression/{id}` - Returns an expression for a specific id
* HTTP POST `api/expression` - Creates a new expression
* HTTP PUT `/expression/{id}` - Updates an existing expression
* HTTP DELETE `/expression/{id}` - Deletes an existing expression

### Interfaces and Services

In order to comply with some of SOLID principles, Interfaces and Services were created, in order for the code to be easily updated without the need of changing too many classes.

For example, a ParsingInterface was created with a `parse` method to implement, so if in some moment there's a new or better way of parsing the input (Or different inputs has to be accepted), instead of changing the code, another strategy of parsing services could be created, and just decide which one to use according to a certain parameter. 

As the parsing calls a parse, the code will work with a minimum requirement of code changing.

## Installation and usage

Just clone this repo to any desired folder (either a XAMPP htdocs, Docker PHP container or anything that suits you) and execute `composer install` in the command line.

Start your web server & MySQL server (for developing purposes I use the built in that PHP has) typing `php artisan serve` in the project folder command line and using any MySQL server you prefer.

After that, create the schema in the desired DDBB and run `php artisan migrate` to run migrations and create schema tables.

http://127.0.0.1:80/ubiquity/public/<end-point>

```
If any of those DDBBs seems incorrect, just change the names in the .env file located at the root of the structure. Also, there are some dummy seeds created for testing purposes.
```

I developed and QA test it using [Postman](https://www.getpostman.com/postman)
End with an example of getting some data out of the system or using it for a little demo

## Tests

For didactic reasons a test file for `ExpressionController` has been added. The test consists in 2 methods for testing the correct fetching data from the controller.

For timing reasons only this tests has been done.

## Issues or bugs?

Just open a bug/ticket to the project and I'll fix it ASAP :)
