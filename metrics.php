<?php
declare(strict_types=1);

$allowedEvents = ['page_view_local', 'read_vatican', 'download_pdf', 'adhesion_submit', 'contact_click', 'nav_click'];
$dataDir = __DIR__ . '/data';
$filePath = $dataDir . '/metrics.json';

if (!is_dir($dataDir)) mkdir($dataDir, 0755, true);
if (!file_exists($filePath)) file_put_contents($filePath, json_encode(['events' => []], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

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

$input = json_decode((string) file_get_contents('php://input'), true);
$eventName = is_array($input) ? (string)($input['event'] ?? '') : '';
if (!in_array($eventName, $allowedEvents, true)) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => 'Evento inválido']);
  exit;
}

$current = json_decode((string) file_get_contents($filePath), true);
if (!is_array($current) || !isset($current['events']) || !is_array($current['events'])) $current = ['events' => []];
if (!isset($current['events'][$eventName])) $current['events'][$eventName] = ['count' => 0, 'last_seen' => null, 'daily_count' => []];

$today = gmdate('Y-m-d');
$current['events'][$eventName]['count']++;
$current['events'][$eventName]['last_seen'] = gmdate('c');
$current['events'][$eventName]['daily_count'][$today] = ($current['events'][$eventName]['daily_count'][$today] ?? 0) + 1;

file_put_contents($filePath, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['success' => true]);
