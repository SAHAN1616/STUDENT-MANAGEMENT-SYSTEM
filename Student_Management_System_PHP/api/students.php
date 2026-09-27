<?php
require_once __DIR__.'/../config.php';header('Content-Type: application/json');
function out($ok,$msg='',$data=[]){echo json_encode(array_merge(['success'=>$ok,'message'=>$msg],$data));exit;}
if($_SERVER['REQUEST_METHOD']==='GET'){ $r=$conn->query('SELECT * FROM students ORDER BY id DESC');$rows=[];while($x=$r->fetch_assoc())$rows[]=$x;out(true,'',['students'=>$rows,'total'=>count($rows)]); }
$a=$_POST['action']??'add';$id=(int)($_POST['id']??0);$name=trim($_POST['name']??'');$roll=trim($_POST['roll_no']??'');$course=trim($_POST['course']??'BCA');$year=trim($_POST['year']??'1st Year');$phone=trim($_POST['phone']??'');$email=trim($_POST['email']??'');if($name===''||$roll==='')out(false,'Name and roll number are required.');
if($a==='delete'){ $s=$conn->prepare('DELETE FROM students WHERE id=?');$s->bind_param('i',$id);$s->execute();out(true,'Student deleted.'); }
if($a==='update'){ $s=$conn->prepare('UPDATE students SET name=?,roll_no=?,course=?,year=?,phone=?,email=? WHERE id=?');$s->bind_param('ssssssi',$name,$roll,$course,$year,$phone,$email,$id);$s->execute();out(true,'Student updated.'); }
$s=$conn->prepare('INSERT INTO students(name,roll_no,course,year,phone,email) VALUES(?,?,?,?,?,?)');$s->bind_param('ssssss',$name,$roll,$course,$year,$phone,$email);if(!$s->execute())out(false,'Could not save student. Roll number may already exist.');out(true,'Student added.');
