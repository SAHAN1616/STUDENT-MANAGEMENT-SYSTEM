<?php
require_once __DIR__.'/../config.php'; header('Content-Type: application/json');
function out($ok,$msg='',$data=[]){echo json_encode(array_merge(['success'=>$ok,'message'=>$msg],$data));exit;}
if($_SERVER['REQUEST_METHOD']==='GET'){ $r=$conn->query('SELECT * FROM app_settings WHERE id=1');out(true,'',['settings'=>$r->fetch_assoc()]); }
$name=trim($_POST['institute_name']??'');$email=trim($_POST['admin_email']??'');$phone=trim($_POST['phone']??'');$address=trim($_POST['address']??'');
$s=$conn->prepare('UPDATE app_settings SET institute_name=?,admin_email=?,phone=?,address=? WHERE id=1');$s->bind_param('ssss',$name,$email,$phone,$address);$s->execute();out(true,'Settings saved.');
