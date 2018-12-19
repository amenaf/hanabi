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

  /* POSTリクエストからイベントを生成
     成功時true、失敗時falseを返す */
  public function createFromRequest ($request) {
    $this->id = uniqid();
    if (empty($request['name'])) return false;
    $this->name = $request['name'];
    $this->description = $request['description'] ?? null;
    if (empty($request['date'])) return false;
    $this->date = [
      'from' => $request['date']['from'] ?? null,
      'to' => $request['date']['to'] ?? null,
    ];
    if (empty($request['time'])) {
      $this->time = [
        'from' => null,
        'to' => null
      ];
    } else {
      $this->time = [
        'from' => $request['time']['from'] ?? null,
        'to' => $request['time']['to'] ?? null,
      ];
    }
    $this->zipcode = $request['zipcode'] ?? null;
    if (empty($request['prefecture'])) return false;
    $this->prefecture = $request['prefecture'];
    $this->address = $request['address'] ?? null;
    if (empty($request['location'])) {
      $this->location = [
        'longitude' => null,
        'latitude' => null
      ];
    } else {
      $this->location = [
        'longitude' => $request['location']['longitude'] ?? null,
        'latitude' => $request['location']['latitude'] ?? null,
      ];
    }
    $this->webpage = $request['webpage'] ?? null;
    $this->tel = $request['tel'] ?? null;
    $this->fireworks = $request['fireworks'] ?? null;

    return true;
  }

  public function insert ($db) {
    $prepare = $db->prepare("INSERT INTO `events` (`id`, `name`, `description`, `date_from`, `date_to`, `time_from`, `time_to`, `zipcode`, `prefecture`, `address`, `longitude`, `latitude`, `webpage`, `tel`, `fireworks`) VALUES (:id, :name, :description, :dateFrom, :dateTo, :timeFrom, :timeTo, :zipcode, :prefecture, :address, :longitude, :latitude, :webpage, :tel, :fireworks)");
    $prepare->bindParam(':id', $this->id, PDO::PARAM_STR);
    $prepare->bindParam(':name', $this->name, PDO::PARAM_STR);
    $prepare->bindParam(':description', $this->description, PDO::PARAM_STR);
    $prepare->bindParam(':dateFrom', $this->date['from'], PDO::PARAM_STR);
    $prepare->bindParam(':dateTo', $this->date['to'], PDO::PARAM_STR);
    $prepare->bindParam(':timeFrom', $this->time['from'], PDO::PARAM_STR);
    $prepare->bindParam(':timeTo', $this->time['to'], PDO::PARAM_STR);
    $prepare->bindParam(':zipcode', $this->zipcode, PDO::PARAM_STR);
    $prepare->bindParam(':prefecture', $this->prefecture, PDO::PARAM_STR);
    $prepare->bindParam(':address', $this->address, PDO::PARAM_STR);
    $prepare->bindParam(':longitude', $this->location['longitude'], PDO::PARAM_STR);
    $prepare->bindParam(':latitude', $this->location['latitude'], PDO::PARAM_STR);
    $prepare->bindParam(':webpage', $this->webpage, PDO::PARAM_STR);
    $prepare->bindParam(':tel', $this->tel, PDO::PARAM_STR);
    $prepare->bindParam(':fireworks', $this->fireworks, PDO::PARAM_INT);
    return $prepare->execute();
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
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

  $path =  parse_url($_SERVER['REQUEST_URI'])['path'];
  $uri = explode('/', $path); /* /api/event/EVENT_ID */

  /* イベントIDが未指定 */
  $id = '';
  if (empty($uri[3])) {
    http_response_code(400);
    exit;
  }
  else $id = urldecode($uri[3]);

  $prepare = $db->prepare('SELECT * FROM `events` WHERE `id` = :id');
  $prepare->bindParam(':id', $id, PDO::PARAM_STR);
  $prepare->execute();
  $event = $prepare->fetch();

  if (empty($event)) {
    http_response_code(404);
    exit;
  }

  http_response_code(200);
  echo json_encode($event, JSON_UNESCAPED_UNICODE);
  exit;
} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $json_string = file_get_contents('php://input');
  $req = json_decode($json_string, true);

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

  header('Access-Control-Allow-Origin: *');

  /* イベントを生成 */
  $event = new Event();
  if (!$event->createFromRequest($req)) {
    http_response_code(401);
    exit();
  }

  /* データベースに保存 */
  if (!$event->insert($db)) {
    http_response_code(502);
    exit();
  }

  http_response_code(200);
  exit;
}
?>
