How to Run the Project

- Clone the project.

- Update the .env file with your database parameters.

- Install passport with php artisan passport:install.

- Run migration using php artisan migrate.

- Run the project using php artisan serve.


API DOCUMENTATION 

(My Postman documentation is not publishing, so I had to create the documentation here)

base_url = http://localhost:8000/api


REGISTER 

Endpoint: {{base_url}}/register

Method: POST

Request body:

{
    "name" : "Test User",
    "email" : "testuser@example.com",
    "password" : "test123",
    "confirm_password" : "test123"
}


LOGIN 

Endpoint: {{base_url}}/login

Method: POST

Request body:

{
    "email" : "testuser@example.com",
    "password" : "test123"
}


CREATE TRANSACTION

Endpoint: {{base_url}}/user/create-transaction

Method: POST

Request body:

{
    "type" : "test",
    "description" : "test",
    "amount" : 3000
}

Header: Bearer Token


GET TRANSACTIONS 

Endpoint: {{base_url}}/user/get-transactions 

Method: GET

Header: Bearer Token


UPDATE TRANSACTIONS 

Endpoint: {{base_url}}/user/update-transaction/4

Method: PUT

Request body:

{
    "type" : "testing",
    "description" : "testing",
    "amount" : 5000
}

Header: Bearer Token


DELETE TRANSACTIONS 

Endpoint: {{base_url}}/user/delete_transaction/4

Method: DELETE

Header: Bearer Token









