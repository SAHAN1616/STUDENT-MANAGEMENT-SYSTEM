<?php
require_once __DIR__.'/../config.php'; header('Content-Type: application/json');
function out($ok,$msg='',$data=[]){echo json_encode(array_merge(['success'=>$ok,'message'=>$msg],$data));exit;}
if($_SERVER['REQUEST_METHOD']==='GET'){
 $r=$conn->query('SELECT f.*,s.name,s.roll_no FROM fees f JOIN students s ON s.id=f.student_id ORDER BY f.id DESC');$rows=[];while($x=$r->fetch_assoc())$rows[]=$x;out(true,'',['fees'=>$rows]);
}
$a=$_POST['action']??'add';$id=(int)($_POST['id']??0);$sid=(int)($_POST['student_id']??0);$amount=(float)($_POST['amount']??0);$paid=(float)($_POST['paid']??0);$due=$_POST['due_date']??null;$status=$_POST['status']??'Pending';$note=trim($_POST['note']??'');
if(!$sid||$amount<=0||$paid<0||$paid>$amount)out(false,'Enter valid student, amount and paid amount.');
if($a==='delete'){ $s=$conn->prepare('DELETE FROM fees WHERE id=?');$s->bind_param('i',$id);$s->execute();out(true,'Fee record deleted.'); }
if($a==='update'){ $s=$conn->prepare('UPDATE fees SET student_id=?,amount=?,paid=?,due_date=?,status=?,note=? WHERE id=?');$s->bind_param('iddsssi',$sid,$amount,$paid,$due,$status,$note,$id);$s->execute();out(true,'Fee record updated.'); }
$s=$conn->prepare('INSERT INTO fees(student_id,amount,paid,due_date,status,note) VALUES(?,?,?,?,?,?)');$s->bind_param('iddsss',$sid,$amount,$paid,$due,$status,$note);$s->execute();out(true,'Fee record saved.');
