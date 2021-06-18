<?php
$conf = new RdKafka\Conf();
$conf->set('log_level', (string) LOG_DEBUG);
//$conf->set('debug', 'all');
$conf->set('bootstrap.servers', 'kafka');
$rk = new RdKafka\Producer($conf);
$rk->addBrokers('kafka:29092');

$topicName = 'TOPIC.EXAMPLE';
$topic = $rk->newTopic($topicName);
for($i=0; $i < 10; $i++) {
  $message =  sprintf('test_message,111,%s', $i+rand(0,50));
  $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
  var_dump($message);
}
$rk->flush(5000);