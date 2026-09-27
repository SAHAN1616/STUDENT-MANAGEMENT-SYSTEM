<?php
require_once __DIR__.'/../config.php';
header('Content-Type: application/json');
function out($ok,$msg='',$data=[]){echo json_encode(array_merge(['success'=>$ok,'message'=>$msg],$data));exit;}
$method=$_SERVER['REQUEST_METHOD'];
if($method==='GET'){
 $r=$conn->query('SELECT * FROM teachers ORDER BY id DESC'); $rows=[]; while($x=$r->fetch_assoc())$rows[]=$x; out(true,'',['teachers'=>$rows]);
}
$a=$_POST['action']??'add'; $id=(int)($_POST['id']??0); $name=trim($_POST['name']??''); $department=trim($_POST['department']??''); $subject=trim($_POST['subject']??''); $phone=trim($_POST['phone']??''); $email=trim($_POST['email']??''); $status=$_POST['status']??'Active';
if($name===''||$department===''||$subject==='') out(false,'Name, department and subject are required.');
if($a==='delete'){ $s=$conn->prepare('DELETE FROM teachers WHERE id=?');$s->bind_param('i',$id);$s->execute();out(true,'Teacher deleted.'); }
if($a==='update'){ $s=$conn->prepare('UPDATE teachers SET name=?,department=?,subject=?,phone=?,email=?,status=? WHERE id=?');$s->bind_param('ssssssi',$name,$department,$subject,$phone,$email,$status,$id);$s->execute();out(true,'Teacher updated.'); }
$s=$conn->prepare('INSERT INTO teachers(name,department,subject,phone,email,status) VALUES(?,?,?,?,?,?)');$s->bind_param('ssssss',$name,$department,$subject,$phone,$email,$status);$s->execute();out(true,'Teacher added.');
