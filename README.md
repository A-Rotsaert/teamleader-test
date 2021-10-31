## Coding test for Teamleader.

I was assigned the discounts problem described in [docs/teamleader.md](docs/teamleader.md)

I choose to set up a very slim framework from scratch. This is a very basic setup, build quickly without much in-advance
planning and brainstorming about the framework structure.

There are certainly many improvements that could be made to the framework, corners where cut here and there, but it
allows me to get the job done.

## Requirements

* Composer installed globally
* PHP 8.0 or higher
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

* [Root](/) displays this README.md (links not working, styling not ok)
* [Test](/test) "showcases" some build in debugging functionality, if environment is set on anything other then
  production otherwise displays a generic error page.
* [Order](/order) is where the "magic" happens, just do a POST request to this uri with data like provided by the
  examples order.json files in the [data/orders](/data/orders) directory.

  #### Example request body

  ```json
  {
  "id": "3",
  "customer-id": "3",
  "items": [
  {
  "product-id": "A101",
  "quantity": "2",
  "unit-price": "9.75",
  "total": "19.50"
  }, {
  "product-id": "A102",
  "quantity": "1",
  "unit-price": "49.50",
  "total": "49.50"
  }
  ],
  "total": "69.00"
  }
  ```

  If everything goes well, you get a result with discounts back if the discount service is enabled in
  the [config/discount.yaml](config/discount.yaml) config.

  #### Response (with provided example data)
  ```json
  {
    "id": "3",
    "customer-id": "3",
    "items": [
        {
            "product-id": "A101",
            "quantity": "2",
            "unit-price": "9.75",
            "total": "19.50"
        },
        {
            "product-id": "A102",
            "quantity": "1",
            "unit-price": "49.50",
            "total": "49.50"
        }
    ],
    "total": 67.05,
    "discounts": {
        "items": {
            "A101": "-1.95"
        },
        "reasons": [
            "Bulk category buy deal, 20% percent discount on the cheapest item in category 1. "
        ]
    }
  }
  ```