# educational-service
## educational service for Cloud Computing Project
The educational service is implemented with **php** language.
This service is provided for viewing lessons and choosing units or removing selected units.
To launch this service, we first create a container from the PHP image and then place the code files inside it.
This service needs to be connected to the database service to perform its function, so there must be a link between the two services.
To create a container for this service and link it to database service, we used the composite file and linked the two services.
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
