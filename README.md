

## PHP 7.1 Kafka setup
Step 1: 
```
wget https://archive.apache.org/dist/kafka/2.4.0/kafka_2.12-2.4.0.tgz
tar -xzf kafka_2.12-2.4.0.tgz
cd kafka_2.12-2.4.0
```
2. Start the server
Kafka uses ZooKeeper, we will use the script packaged with Kafka to get a single-node ZooKeeper instance.
`$ bin/zookeeper-server-start.sh config/zookeeper.properties`

Start the Kafka server.
`$ bin/kafka-server-start.sh config/server.properties`
(If port already exist 
`lsof -i :9092
kill -9 <PID>`
)

Now we can create a topic named "test" with a single partition and one replica.
`$ bin/kafka-topics.sh --create --zookeeper localhost:2181 --replication-factor 1 --partitions 1 --topic test
##$ bin/kafka-topics.sh --create --bootstrap-server localhost:9092 --replication-factor 1 --partitions 1 --topic test`

Delete the test topic (if you don't need it anymore):
`kafka-topics.sh --delete --topic test --bootstrap-server localhost:9092`


Step 2: Install PHP Kafka Extension (rdkafka) for MAMP
1. Install librdkafka (C library for Kafka)

`brew install librdkafka`


2. Install php-rdkafka (PHP extension)
Since MAMP uses its own PHP, we need to compile the extension manually:

```
# Download rdkafka (compatible with PHP 7.1)
git clone --branch 3.0.5 https://github.com/arnaud-lb/php-rdkafka.git
cd php-rdkafka

# Tell pecl to use MAMP's PHP
export PATH=/Applications/MAMP/bin/php/php7.1.x/bin:$PATH
phpize
./configure --with-php-config=/Applications/MAMP/bin/php/php7.1.x/bin/php-config
make
sudo make install
```

3. Enable rdkafka in MAMP's php.ini
Open MAMP → PHP → php.ini

Add this line:
`extension=rdkafka.so`

4. Verify Installation
Create a phpinfo.php file in MAMP’s htdocs:
