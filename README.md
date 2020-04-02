# Open4Business
A crowdsourced information system for business that are open during the COVID19 pandemic in Portugal 


## CONTEXT
With the declaration of the state of emergency in Portugal, some business will be shutdown until April 2nd - and may be closed for more than that - and other business will continue to be open to the general population. Supermarkets's chains have imposed diverse opening hours (to security and safety forces, elderly, general population). This information is vital to make sure citizens are not on the streets going to a place that is closed or they won't get any service because they are not part of a specific group. 

## The Project
Build a crowdsourced website (followed by an app) where users can check if a certain business is open
What are the opening hours and what are the diverse timetables for specific groups
What kind of service is provided 

## Priority 
This is a critical priority project. All resources should be focused on this, apart from the team that is developing the app for covid19estamoson.gov.pt 

## Runing locally

Be sure to have `docker` and `docker-compose`.

1. `cp .env.example-docker .env`
1. `docker-compose build`
1. `docker-compose up -d`
1. `docker-compose exec laravel-app composer install`
1. `docker-compose exec laravel-app php artisan config:cache`
1. `docker-compose exec laravel-app php artisan migrate`
