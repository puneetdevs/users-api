## APi url for getting the user 
     http://127.0.0.1:8000/api/get-users?page=10  - you can change the current page by changing the page params in the url
## The record will be save in storage/app/public -> users.csv

  Run the command : php artisan storage:link for showing the users.csv file inside public folder

## The record will be shown on the web => http://127.0.0.1:8000/users?