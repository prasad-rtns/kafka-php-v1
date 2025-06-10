<?php
$conf = new RdKafka\Conf();
$conf->set('metadata.broker.list', 'localhost:9092');

$producer = new RdKafka\Producer($conf);
$topic = $producer->newTopic("test_topic");

for ($i = 0; $i < 5; $i++) {
    $message = "Test Message " . $i . " - " . date('H:i:s');
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
    echo "Produced: $message\n";
    $producer->poll(0);
}

// Flush messages (ensure delivery)
$producer->flush(10000);
echo "All messages sent!\n";