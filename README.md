# kafka-php-env-test
Simple Kafka docker env


## How to Run

```
docker-compose up -d
```

## Run Producer

```
docker exec -it php-producer php index.php
``` 

## Run Consumer

```
docker exec -it php-consumer php index.php
``` 

## KAFKA commands

```
docker exec -it server_kafka_1 /bin/kafka-topics --list --zookeeper zookeeper:2181
```