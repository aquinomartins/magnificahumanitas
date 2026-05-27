<?php
declare(strict_types=1);
// subscribe.php - cadastro simples de adesão. Preparado para futura integração com serviço de e-mail.

date_default_timezone_set('UTC');

function is_fetch_request(): bool {
  $requestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
  return strtolower($requestedWith) === 'fetch' || (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);
}

function output_response(bool $success, string $message): void {
  if (is_fetch_request()) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => $success, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
  }

  header('Content-Type: text/html; charset=utf-8');
  echo '<!doctype html><html lang="pt-BR"><meta charset="utf-8"><title>Magnifica Humanitas</title>';
  echo '<body style="font-family:system-ui;padding:2rem"><p>' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</p>';
  echo '<p><a href="index.html">Voltar</a></p></body></html>';
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  output_response(false, 'Método não permitido.');
}

$name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
$emailRaw = trim($_POST['email'] ?? '');
$interest = trim(filter_input(INPUT_POST, 'interest', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
$consent = $_POST['consent'] ?? '';

$email = filter_var($emailRaw, FILTER_VALIDATE_EMAIL);
if (!$email) {
  output_response(false, 'Informe um e-mail válido.');
}
if ($consent !== '1') {
  output_response(false, 'É necessário concordar com o recebimento de comunicações.');
}

$dataDir = __DIR__ . '/data';
$filePath = $dataDir . '/subscribers.csv';
if (!is_dir($dataDir)) {
  mkdir($dataDir, 0755, true);
}
if (!file_exists($filePath)) {
  file_put_contents($filePath, "created_at,name,email,interest\n");
}

$existing = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
foreach ($existing as $index => $line) {
  if ($index === 0) { continue; }
  $cols = str_getcsv($line);
  if (isset($cols[2]) && strtolower(trim($cols[2])) === strtolower($email)) {
    output_response(true, 'Este e-mail já está cadastrado para acompanhamento.');
  }
}

$createdAt = gmdate('c');
$record = [$createdAt, $name, strtolower($email), $interest];
$fp = fopen($filePath, 'a');
if ($fp === false) {
  output_response(false, 'Não foi possível registrar seu cadastro neste momento.');
}
fputcsv($fp, $record);
fclose($fp);

output_response(true, 'Cadastro realizado com sucesso. Obrigado por acompanhar o projeto.');
