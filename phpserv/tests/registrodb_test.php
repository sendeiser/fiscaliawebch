<?php
ob_start();

function run_registration($post) {
  $_POST = $post;
  $_SERVER['REQUEST_METHOD'] = 'POST';
  include __DIR__ . '/../registrodb.php';
  $output = ob_get_contents();
  ob_clean();
  return [http_response_code(), $output];
}

$email = 'test_' . uniqid() . '@example.com';
$success = run_registration([
  'nombre' => 'Test',
  'apellido' => 'User',
  'celular' => '0000000000',
  'correo' => $email,
  'usuario' => 'testuser_' . uniqid(),
  'contrasena' => 'Secret123!'
]);

echo "SUCCESS STATUS: " . $success[0] . "\n";
echo "SUCCESS BODY: " . $success[1] . "\n";

$duplicate = run_registration([
  'nombre' => 'Test',
  'apellido' => 'User',
  'celular' => '0000000000',
  'correo' => $email,
  'usuario' => 'anotheruser_' . uniqid(),
  'contrasena' => 'Secret123!'
]);

echo "DUPLICATE STATUS: " . $duplicate[0] . "\n";
echo "DUPLICATE BODY: " . $duplicate[1] . "\n";

?>