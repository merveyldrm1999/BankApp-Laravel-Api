Postman Doc: https://documenter.getpostman.com/view/23907181/2s935hQmXX

User
Register

POST

http://127.0.0.1:8000/api/user

BODY
{
    "username":"merve@yildirim.com",
    "password":"1999"
}

Login
GET

http://127.0.0.1:8000/api/user/merve@yildirim.com/1999



Account
Account Withdraw

POST
http://127.0.0.1:8000/api/account/withdraw
BODY
{ "amount":67 }


Account Deposit
POST
http://127.0.0.1:8000/api/account/deposit
BODY
{ "amount":67 }

 
# BankApp-Laravel-Api
