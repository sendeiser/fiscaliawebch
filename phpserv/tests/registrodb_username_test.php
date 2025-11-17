<?php
ob_start();
function call($script, $method, $post = [], $get = []){
  $_SERVER['REQUEST_METHOD'] = $method;
  $_GET = $get; $_POST = $post;
  include __DIR__ . '/../' . $script;
  $out = ob_get_contents(); ob_clean(); return [http_response_code(), $out];
}
$u = 'dupuser_' . uniqid();
$email1 = 'dup1_' . uniqid() . '@example.com';
$email2 = 'dup2_' . uniqid() . '@example.com';
$ok = call('registrodb.php','POST',[
  'nombre'=>'A','apellido'=>'B','celular'=>'0','correo'=>$email1,'usuario'=>$u,'contrasena'=>'X'
]);
echo "FIRST STATUS: ".$ok[0]."\n";
echo "FIRST BODY: ".$ok[1]."\n";
$dup = call('registrodb.php','POST',[
  'nombre'=>'C','apellido'=>'D','celular'=>'0','correo'=>$email2,'usuario'=>$u,'contrasena'=>'Y'
]);
echo "DUP STATUS: ".$dup[0]."\n";
echo "DUP BODY: ".$dup[1]."\n";
$avail = call('check_user_availability.php','GET',[],['usuario'=>$u]);
echo "AVAIL STATUS: ".$avail[0]."\n";
echo "AVAIL BODY: ".$avail[1]."\n";
?>