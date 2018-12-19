<?php
class Event {
  public $id = null;
  public $name = '';
  public $description = null;
  public $date = [
    'from' => null,
    'to' => null
  ];
  public $time = null;
  public $zipcode = null;
  public $prefecture = '';
  public $address = null;
  public $location = [
    'longitude' => null,
    'latitude' => null
  ];
  public $webpage = null;
  public $tel = null;
  public $fireworks = null;
  public $review = [
    'good' => 0,
    'bad' => 0
  ];

  public function convertFromDb ($event) {
    $this->id = $event['id'];
    $this->name = $event['name'];
    $this->description = $event['descripiton'];
    $this->date = [
      'from' => $event['date_from'],
      'to' => $event['date_to']
    ];
    $this->time = [
      'from' => $event['time_from'],
      'to' => $event['time_to']
    ];
    $this->zipcode = $event['zipcode'];
    $this->prefecture = $event['prefecture'];
    $this->address = $event['address'];
    $this->location = [
      'longitude' => $event['longitude'],
      'latitude' => $event['latitude']
    ];
    $this->webpage = $event['webpage'];
    $this->tel = $event['tel'];
    $this->fireworks = $event['fireworks'];
    $this->review = [
      'good' => $event['good'],
      'bad' => $event['bad']
    ];
  }

  public function getCalenderFormat () {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'description' => $this->description,
      'date' => $this->date,
      'prefecture' => $this->prefecture,
      'fireworks' => $this->fireworks,
      'review' => $this->review,
    ];
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (empty($_GET['month']) || strlen($_GET['month']) != 7) {
    http_response_code(400);
    exit();
  }

  /* データベース接続 */
  $db = new PDO(
    'mysql:host=jp28.mixhost.jp;dbname=eistsquf_fireworks;charset=utf8;',
    'eistsquf_fireworks',
    '7cLQj6~h&y{4',
    array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => false,
    )
  );

  header('Content-Type: application/json; charset=utf-8');
  header('Access-Control-Allow-Origin: *');

  /* 指定された月のイベントを取得 */
  $min = $_GET['month'].'-01';
  $max = $_GET['month'].'-31';

  $prepare = $db->prepare('SELECT * FROM `events` WHERE (`date_from` BETWEEN :fmin AND :fmax) OR (`date_to` BETWEEN :tmin AND :tmax) ORDER BY `date_from` ASC');
  $prepare->bindParam(':fmin', $min, PDO::PARAM_STR);
  $prepare->bindParam(':fmax', $max, PDO::PARAM_STR);
  $prepare->bindParam(':tmin', $min, PDO::PARAM_STR);
  $prepare->bindParam(':tmax', $max, PDO::PARAM_STR);
  $prepare->execute();
  $dbEvents = $prepare->fetchAll();

  $events = [];
  foreach ($dbEvents as $e) {
    $event = new Event();
    $event->convertFromDb($e);
    $events[] = $event->getCalenderFormat();
  }

  http_response_code(200);
  echo json_encode($events, JSON_UNESCAPED_UNICODE);
  exit;
}
?>
