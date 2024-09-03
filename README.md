# the name of project
Book Library
# step to run the project 
1- add data base name in phpmyadmin
2- add the database name in .env
3- run the project in termial using this step:
   1 . php artisan config:cache
   2. php artisan config:clear
   //we put this step above (1+2) because in my project i put database name but you want to add new data so this is to clear .env and allow you to put your database
   3. php artisan migrate
   4. php artisan db:seed --class=PermissionSeeder
   5. php artisan db:seed --class=CreateAdminSeeder
# Features
i use JWT package for Api   
# what about this project
this project containe two role admin and member
admin can add book and delete and update 
the user can see all books and rating any book but just the user how logged in 
the member can borrow book and retrived after 14 days and when he can not fined it at 14 days he asked to borrow it again 
and if he finished reading befor this 14 days also contact to admin to retrived the book
# doc of postman is 
https://documenter.getpostman.com/view/34555205/2sAXjNYAoW

