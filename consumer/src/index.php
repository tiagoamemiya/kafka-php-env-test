<?php
$conf = new RdKafka\Conf();

// Set a rebalance callback to log partition assignments (optional)
$conf->setRebalanceCb(function (RdKafka\KafkaConsumer $kafka, $err, array $partitions = null) {
    switch ($err) {
        case RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS:
            echo "Assign: ";
            var_dump($partitions);
            $kafka->assign($partitions);
            break;

         case RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS:
             echo "Revoke: ";
             var_dump($partitions);
             $kafka->assign(NULL);
             break;

         default:
            throw new \Exception($err);
    }
});

// Configure the group.id. All consumer with the same group.id will consume
// different partitions.
$conf->set('group.id', 'myConsumerGroup');

// Initial list of Kafka brokers
$conf->set('metadata.broker.list', 'kafka');
//$conf->set('debug', 'all');

// Set where to start consuming messages when there is no initial offset in
// offset store or the desired offset is out of range.
// 'earliest': start from the beginning
$conf->set('auto.offset.reset', 'earliest');


$topicName = 'TOPIC.EXAMPLE';

$consumer = new RdKafka\KafkaConsumer($conf);

$consumer->subscribe([$topicName]);
while (true) {
  $message = $consumer->consume(120*1000);
  switch ($message->err) {
      case RD_KAFKA_RESP_ERR_NO_ERROR:
          var_dump($message);
          break;
      case RD_KAFKA_RESP_ERR__PARTITION_EOF:
          echo "No more messages; will wait for more\n";
          break;
      case RD_KAFKA_RESP_ERR__TIMED_OUT:
          echo "Timed out\n";
          break;
      default:
          throw new \Exception($message->errstr(), $message->err);
          break;
  }
}