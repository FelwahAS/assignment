## Backend Assignment

## Task
You were given a sample [Laravel][laravel] project which implements sort of a personal wishlist
where user can add their wanted products with some basic information (price, link etc.) and
view the list.

#### Refactoring
The `ItemController` is messy. Please use your best judgement to improve the code. Your task
is to identify the imperfect areas and improve them whilst keeping the backwards compatibility.

#### New feature
Please modify the project to add statistics for the wishlist items. Statistics should include:

- total items count
- average price of an item
- the website with the highest total price of its items
- total price of items added this month

The statistics should be exposed using an API endpoint. **Moreover**, user should be able to
display the statistics using a CLI command.

Please also include a way for the command to display a single information from the statistics,
for example just the average price. You can add a command parameter/option to specify which
statistic should be displayed.

## Open questions
Please write your answers to following questions.

> #### Please briefly explain your implementation of the new feature
>
 Interface Documentation:
>   1. API endpoint:
>      - `/statistics`
>   2. CLI command: 
>      - To display all types: `php artisan item:statistics`
>      - To display a specific type: `php artisan item:statistics --type={type}`
>
>       - parameter options: = {total_items, average_price, highest_website, total_price_current_month}`
>      
>      - Errors are handled if user enters an invalid type. e.g, `php artisan item:statistics --type=total`
  Implementation:
>   1. Statistics functions
>       - Name:
>           - `getTotalCount()`
>           - `getAveragePrice()`
>           - `getHighestPriceWebsite()`
>           - `getTotalPriceCurrentMonth()`
>       - Location: 
>           - `Models/Item`
>       - Usage: 
>           - `Http/Resources/ItemStatisticResource.php`
>      - Note: I have elected to place these functions in the model rather than adding a repository layer due to the current scope of the project     
>   2. Helper function
>       - Name: `getWebsiteHostAttribute()`
>       - Location: `Models/Item`
>       - Usage: `getHighestPriceWebsite()` 
>       - Note: function was added to get an item's TLD to group the items by their TLD to calculate the website with the highest total price
>
>   2. Resources 
>       - Name: `Http/Resources/ItemsStatisticResource.php`
>       - Usage: 
>           - `Controllers/ItemController/getStatistics`
>           - `Console/Commands/GetStatistics.php`
>

> #### For the refactoring, would you change something else if you had more time? 
> I have applied the following refactoring that I deemed would benefit a project of this size:
> 1. Creating Form Request Validation 
>       - name: `Http/Requests/ItemRequest.php`
>       - usage: `store` and `update`
> 2. Using Route Model Binding
>       - usage: `show` and `update` 
> 3. Creating a public variable:
>       - name: `$converter`
>       - usage: `store` and `update` 
> 4. Creating Resources:
>       - name: 
>           - `Http/Resources/ItemResource.php`
>           - `Http/Resources/ItemsCollection.php`
>       - usage: all CRUD operations
>       - notes: I have elected to create two resources rather than one resource (ItemResource) and use the following syntax to be able to wrap the result in an "items" key rather than the default "data" key to keep the backwards compatibility: 
>       -      return ItemResource::collection(Item:all)
> Further refactoring may be considered as and when certain cases arise as the project scales up. 
> For example: a Service Layer would benefit a larger project

## Running the project
This project requires a database to run. For the server part, you can use `php artisan serve`
or whatever you're most comfortable with.

You can use the attached DB seeder to get data to work with.

#### Running tests
The attached test suite can be run using `php artisan test` command.

[laravel]: https://laravel.com/docs/8.x
