<?php
// metrics.php - coleta local mínima de eventos sem dados sensíveis.

date_default_timezone_set('UTC');
$allowedEvents = ['page_view_local','chapter_index_view','chapter_1_view','chapter_2_view','chapter_3_view','chapter_4_view','chapter_5_view','read_vatican','download_pdf','adhesion_submit','contact_click','visual_placeholder_click'];
$dataDir = __DIR__ . '/data';
$filePath = $dataDir . '/metrics.json';

if (!is_dir($dataDir)) {
  mkdir($dataDir, 0755, true);
}
if (!file_exists($filePath)) {
  file_put_contents($filePath, json_encode(['events' => []], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['summary'])) {
  header('Content-Type: application/json; charset=utf-8');
  readfile($filePath);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(['success' => false, 'message' => 'Método não permitido']);
  exit;
}

$body = file_get_contents('php://input');
$input = json_decode($body, true);
$eventName = $input['event'] ?? '';
if (!in_array($eventName, $allowedEvents, true)) {
  http_response_code(400);
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(['success' => false, 'message' => 'Evento inválido']);
  exit;
}

$current = json_decode(file_get_contents($filePath), true);
if (!is_array($current) || !isset($current['events'])) {
  $current = ['events' => []];
}
if (!isset($current['events'][$eventName])) {
  $current['events'][$eventName] = ['count' => 0, 'last_seen' => null, 'daily_count' => []];
}

$today = gmdate('Y-m-d');
$current['events'][$eventName]['count'] += 1;
$current['events'][$eventName]['last_seen'] = gmdate('c');
$current['events'][$eventName]['daily_count'][$today] = ($current['events'][$eventName]['daily_count'][$today] ?? 0) + 1;

file_put_contents($filePath, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['success' => true]);
