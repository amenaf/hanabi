<?php
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Content-Type');
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
  $json_string = file_get_contents('php://input');
  $req = json_decode($json_string, true);

  if (!isset($req['review'])) {
    http_response_code(400);
    exit();
  }

  $path =  parse_url($_SERVER['REQUEST_URI'])['path'];
  $uri = explode('/', $path); /* /api/event/review/EVENT_ID */

  /* イベントIDが未指定 */
  $id = '';
  if (empty($uri[4])) {
    http_response_code(400);
    exit;
  }
  else $id = urldecode($uri[4]);

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

  if ($req['review'] === 'good') {
    $prepare = $db->prepare('UPDATE `events` SET `good` = `good` + 1 WHERE `id` = :id');
    $prepare->bindParam(':id', $id, PDO::PARAM_STR);
    $prepare->execute();
  } else if ($req['review'] === 'bad') {
    $prepare = $db->prepare('UPDATE `events` SET `bad` = `bad` + 1 WHERE `id` = :id');
    $prepare->bindParam(':id', $id, PDO::PARAM_STR);
    $prepare->execute();
  } else {
    http_response_code(400);
    exit();
  }

  http_response_code(200);
  exit;
}
?>
