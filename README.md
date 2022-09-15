# Webcheckout integration
***
Project developed to meet requirements in implementation of the payment gateway provided by PlaceToPay, code that shows how it would be implemented in a simple way in a project developed in PHP with the Laravel development framework in its ninth version. It still lacks certain features to take full advantage of all the tools provided by this payment gateway.
***
## install
To install the project it is necessary to run the following commands in the following order.
### Clone the project from github.
```
https://github.com/luisJaimeB/api-webcheckout.git
```
### Use the composer command for dependency management (You must have composer installed on your machine).
```
composer install
```
### Copy the contents of the .env.example file into the .env file..
```
cp .env.example .env
```
### The encryption key is generated.
```
php artisan key:generate
```
### We generate the user from the seeder
The user generated will be the following: test@example.com, password: "password". In case of not generating such a user, the system allows you to generate new users from the register.
```
php artisan db:seed
```
### You must run the following command for UI
```
npm run dev
```
***
## Use
In order to use the project firstly and with everything installed, we need to generate the session token to log in to the application. To do this, using postman we go to the following route: localhost **/api/sanctum/token** with the follow content: (The mail generated for the user)
```
{
    "email": "estel14@example.net",
    "password": "password",
    "token_name": "test"
}
```
with the generated token you can access the system and run the service route; its uri is the following: **/api/payments**, it must have the following data matrix:
```
{
    "total": "125000",
    "payer": {
        "document": "1254774",
        "documentType": "CC",
        "name": "John",
        "surname": "Doe",
        "company": "areandina",
        "email": "johndoe@app.com",
        "mobile": "+5731111111111",
        "address": {
            "street": "Calle falsa 123",
            "city": "Medellín",
            "state": "Poblado",
            "postalCode": "55555",
            "country": "Colombia",
            "phone": "+573111111111"
        }
    }
}
```
The values of such data are entered by the user, those mentioned here are merely examples.

When sending this data, the system returns the url in which the payment process will be made.
At the end of the payment process, you are redirected back to the system where you can view the invoice and its status.

### Application in first version, if you find failures do not hesitate to communicate them, we will be in favor of its better optimization. With love to you.