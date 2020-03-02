# App
## Setup
To start appliaction simple type `make`

Test and linters are available with:
* `make lint`
* `make test` 

## Thoughts
I'm aware of incompleteness task, but I've spent on it 4 hours as part of 
requirements. All layers I believe are separated with framework, application,
domain and infrastructure responsibility. In future I'll consider to use 
ES patterns to better handle events. I'm not familiar with laravel but I think
Implementation of application should not be a pain.

At this point I show me understanding of layers segregation, domain implementation
and unit testing. 

Additional comments I've put in code.

## Todo
* split docker layers with copy files for composer and then copy src
* implement event dispatcher with laravel dispatcher, move mock outside src
* implement all http layer on top of laravel controllers
* implement tons of endpoints with proper behaviors
* implement infrastructure and consider of use another type of storage
* implement command and handlers