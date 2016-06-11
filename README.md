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

To get started, click the __Register__ link to create an account, or use the one provided in the Seeder file. You can create many accounts if you wish.

With an account, click the __Add reading list__ links to create reading lists and set their name. The main page will show
your reading lists. Click a reading list's title to edit the book list. Click the __Edit__ link below the reading list name to edit the reading list's settings, such as the name. Click __Delete__ to remove the reading list.

In the Reading List view, you can add books with the __Add a book__ link at the bottom left. Title, Author, and Publication Date are the only required fields. Optional fields are Description, Rating, and Image. Click the __Browse...__ button to upload an image.

After adding the book to your list, you will see it appear in the Reading List view. Click the list headings (Title, Author, Publication Date, and Description) to sort the list by that column.

Use the Edit and Delete buttons in the Controls section to edit or delete book entries.

Check out [a working example](http://brl.aninternetpresence.net)!

### Deploying

You can deploy this Laravel site in an environment with all the required programs and credentials, which you may
specify for the database in the local `.env`. See the [booj-read-list-docker](https://gitlab.com/aninternetpresence/booj-reading-list-docker) repo for a Dockerfile an instructions
for deployment with such a container.

If deploying in another environment, be sure to do the following:

* The storage and bootstrap/cache directories must be writeable by the web server process owner
* If using mod\_proxy to proxy requests to multiple contanairs on separate ports, you must enable the `httpd_can_network_connect` sebool if using SELinux.
* Use the host OS's public IP for the IP used with the `Proxy` and `ProxyPassReverse` directives.
* Node.js is required to publish the frontend assets. Run `npm install && npm -g install gulp && gulp` to make this happen. When developing, use the `gulp watch` or `npm test` command to automatically publish the assets (normalized CSS and JavaScript), everytime the main file is saved. Run `gulp --production` or `npm start` to also minify the CSS and JavaScript. See the tutorial on [Laravel Elixer](https://laravel.com/docs/5.2/elixir) for more information.
* Be sure to publish an application key to the `APP_KEY` value of the local `.env`. Run the command `php artisan key:generate` to create and assign such a key.

### Testing

There are several tests using Laravel's TestCase methods for confirming the user registration operations. You can run them with `phpunit` in the project root.

__Note:__ Be mindful that running the tests will rollback all migrations.

## Requirements

* Laravel 5.2.*
* PHP >=5.5.9
* MySQL 5.*
* NodeJS (LTS or Stable)

### Recommended
* [doctrine/dbal](https://packagist.org/packages/doctrine/dbal) 2.*
* [Docker](https://www.docker.com/products/docker-toolbox)