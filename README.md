## Coding test for Teamleader.

I was assigned the discounts problem described in [docs/teamleader.md](docs/teamleader.md)

I choose to set up a very slim framework from scratch. This is a very basic setup, build quickly without much in-advance
planning and brainstorming about the framework structure.

There are certainly many improvements that could be made to the framework, corners where cut here and there, but it
allows me to get the job done.

## Requirements

* Composer installed globally
* PHP 8.1
* Apache server with mod_rewrite enabled and AllowOverride all or ngnix equivalent

## Installation

### Setup .env
    cp .env.example .env
### Composer
    composer install
### Testing
    composer test
* Unit testing.
* Code sniffing against our defined PSR-12 coding Standard.
* Attempt to automatically correct coding standard violations.
## Usage 


