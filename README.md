## About this project

It's a basic project to upload millions of records from csv via Queue job and also have batching functionality.

## How to use

1. Copy ".env.example" to ".env" file and setup database config.
2. Pull the repo and set "QUEUE_CONNECTION" to "database" in env.
3. Use "php artisan migrate" to migrate the tables.
4. Run development server using "php artisan serve" command.
5. visit "/upload" to upload the csv. after uploading csv it'll return batch details.
6. run "php artisan queue:work" command to start queue in the batch.
7. visit "/batch?id={your batch id}". It'll show you batch progress.

## Property API collection

This project also contains "API's for complete "CRUD" of "property" and "broker". you can check them out too.

## License

Licensed under the [MIT license](https://opensource.org/licenses/MIT).
