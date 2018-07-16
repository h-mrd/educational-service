
# سرویس آموزشی
The educational service is implemented with php language. This service is provided for viewing lessons and choosing units or removing selected units. 
To launch this service, we first create a container from the PHP image and then place the code files inside ```./volume/project/unit/ ```folder in your directory to mount this file to ```/var/www/html ``` directory in container. 
This service needs to be connected to the database service to perform its function, so there must be a link between the two services. To create a container for this service and link it to database service, we used the composite file and linked the two services
### create a container with compose file
> In the Compose file, the specification of this service is as follows:
```docker compose
unit:
    image: php:5.6-apache
    container_name: unit
    #restart: always
    links:
      - db_service:db_service_host
    volumes:
      - ./volume/project/unit/:/var/www/html
    ports:
      - 80:80
      - 443:443
    networks:
      mor_net:
        ipv4_address: 172.100.100.120
```
after you careate compose file, you must ```cd ``` to folder that contain this file and run ```docker-compose up -d``` command to build unit container.
hopefully, you can see this container in result of ```docker-compose ps``` command :)

because we use ```mysqli_connect()``` function to put/get data in db_service container,we must install mysqli extension in our container with this commands:
```
Docker exec –it unit sh
docker-php-ext-install mysqli
docker-php-ext-enable mysqli
apachectl restart
```

if you can need to inspect this container, you must use ```docker inspect unit``` ;)
