<?php
require_once __DIR__.'/../config.php';header('Content-Type: application/json');
function out($ok,$msg='',$data=[]){echo json_encode(array_merge(['success'=>$ok,'message'=>$msg],$data));exit;}
if($_SERVER['REQUEST_METHOD']==='GET'){ $filter=(int)($_GET['student_id']??0);$sql='SELECT a.*,s.name,s.roll_no FROM attendance a JOIN students s ON s.id=a.student_id';if($filter)$sql.=' WHERE a.student_id='.$filter;$sql.=' ORDER BY a.date DESC,a.id DESC';$r=$conn->query($sql);$rows=[];while($x=$r->fetch_assoc())$rows[]=$x;out(true,'',['attendance'=>$rows]); }
$a=$_POST['action']??'save';$id=(int)($_POST['id']??0);$sid=(int)($_POST['student_id']??0);$date=$_POST['date']??'';$status=$_POST['status']??'Present';if(!$sid||!$date||!in_array($status,['Present','Absent'],true))out(false,'Invalid attendance data.');
if($a==='delete'){ $s=$conn->prepare('DELETE FROM attendance WHERE id=?');$s->bind_param('i',$id);$s->execute();out(true,'Attendance deleted.'); }
if($a==='update'){ $s=$conn->prepare('UPDATE attendance SET student_id=?,date=?,status=? WHERE id=?');$s->bind_param('issi',$sid,$date,$status,$id);$s->execute();out(true,'Attendance updated.'); }
$s=$conn->prepare('INSERT INTO attendance(student_id,date,status) VALUES(?,?,?) ON DUPLICATE KEY UPDATE status=VALUES(status)');$s->bind_param('iss',$sid,$date,$status);$s->execute();out(true,'Attendance saved.');
