<?php
$conf = new RdKafka\Conf();
$conf->set('group.id', 'test_group');
$conf->set('metadata.broker.list', 'localhost:9092');
$conf->set('auto.offset.reset', 'earliest');

$consumer = new RdKafka\KafkaConsumer($conf);
$consumer->subscribe(['test_topic']);

echo "Waiting for messages...\n";

while (true) {
    $msg = $consumer->consume(5000);
    
    if ($msg->err) {
        echo "Error: " . $msg->errstr() . "\n";
        continue;
    }
    
    echo "Received: " . $msg->payload . "\n";
}