<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'meting.php';
use Metowolf\Meting;
if (empty($_GET['type']) || empty($_GET['id'])) {
    header('Content-Type: text/html; charset=utf-8');
    require_once __DIR__ . '/temp.html';
    exit;
}
$params = [
    'server' => $_GET['server'] ?? 'netease', 
    'type'   => $_GET['type'],
    'id'     => $_GET['id']
];

$api = new Meting($params["server"]);
$api->format(true);

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];

try {
    switch ($params['type']) {
        case 'song':
            $result = $api->song($params['id']);
            $data = json_decode($result, true);
            
            $songData = isset($data[0]) ? $data[0] : $data;
            $formattedData = [
                "name" => $songData['name'] ?? '',
                "artist" => isset($songData['artist']) ? implode('/', $songData['artist']) : '',
                "url" => $baseUrl . "?server={$params['server']}&type=url&id={$songData['url_id']}",
                "pic" => $baseUrl . "?server={$params['server']}&type=pic&id={$songData['pic_id']}",
                "lrc" => $baseUrl . "?server={$params['server']}&type=lrc&id={$songData['lyric_id']}"
            ];
            echo json_encode($formattedData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            break;
            
        case 'playlist':
            $result = $api->playlist($params['id']);
            $data = json_decode($result, true);
            
            $songs = isset($data['songs']) ? $data['songs'] : $data;
            $formattedData = [];
            foreach ($songs as $song) {
                $formattedData[] = [
                    "name" => $song['name'] ?? '',
                    "artist" => isset($song['artist']) ? implode('/', $song['artist']) : '',
                    "url" => $baseUrl . "?server={$params['server']}&type=url&id={$song['url_id']}",
                    "pic" => $baseUrl . "?server={$params['server']}&type=pic&id={$song['pic_id']}",
                    "lrc" => $baseUrl . "?server={$params['server']}&type=lrc&id={$song['lyric_id']}"
                ];
            }
            
            echo json_encode($formattedData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            break;
            
        case 'url':
            $result = $api->url($params['id']);
            echo $result;
            break;
            
        case 'pic':
            $result = $api->pic($params['id']);
            echo $result;
            break;
            
        case 'lrc':
            $result = $api->lyric($params['id']);
            echo $result;
            break;
            
        default:
            echo json_encode(['error' => '无效的类型参数: ' . $params['type']], JSON_UNESCAPED_UNICODE);
            exit;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => '服务器内部错误: ' . $e->getMessage()]);
}

?>


