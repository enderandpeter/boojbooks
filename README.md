# Booj Reading List
*Beware of the person of one book. -- Thomas Aquinas*
## Task
Compose a site using the [Laravel](https://laravel.com/) framework that allows the user to create a list of books they would like to read. Users should be able to perform the following actions:
* Add or remove books from the list
* Change the order of the books in the list
* Sort the list of books by their author
* Display a book detail page with a minimum of author, publication date, and title

Please use the [ORM](https://laravel.com/docs/5.2/eloquent) rather than crafting queries by hand. 

##### Bonus points!

* Deploy it for real so we can play with it! (and then tell us about how you deployed it)
* Handle image uploading while adding books to the list
* Do something fancy like integrating an external API or handling user authentication

<hr />

## Instructions

### Usage

Go to the __Register__ link to create an account, after which you will be able to create reading lists.

### Deploying

You can deploy this Laravel site in an environment with all the required programs and credentials, which you may
specify for the database in the local `.env`. 

## Requirements

* Laravel 5.2.*
* PHP >=5.5.9
* MySQL 5.*

### Recommended
* [doctrine/dbal](https://packagist.org/packages/doctrine/dbal) 2.*
* [Docker](https://www.docker.com/products/docker-toolbox)