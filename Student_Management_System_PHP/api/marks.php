<?php
require_once __DIR__.'/../config.php'; header('Content-Type: application/json');
function out($ok,$msg='',$data=[]){echo json_encode(array_merge(['success'=>$ok,'message'=>$msg],$data));exit;}
if($_SERVER['REQUEST_METHOD']==='GET'){
 $q='SELECT m.*,s.name,s.roll_no FROM marks m JOIN students s ON s.id=m.student_id ORDER BY m.id DESC';
 $r=$conn->query($q);$rows=[];while($x=$r->fetch_assoc())$rows[]=$x;out(true,'',['marks'=>$rows]);
}
$a=$_POST['action']??'add';$id=(int)($_POST['id']??0);$sid=(int)($_POST['student_id']??0);$subject=trim($_POST['subject']??'');$marks=(float)($_POST['marks']??0);$exam=trim($_POST['exam']??'Semester Exam');
if(!$sid||$subject===''||$marks<0||$marks>100)out(false,'Select student, subject and marks between 0 and 100.');
if($a==='delete'){ $s=$conn->prepare('DELETE FROM marks WHERE id=?');$s->bind_param('i',$id);$s->execute();out(true,'Marks deleted.'); }
if($a==='update'){ $s=$conn->prepare('UPDATE marks SET student_id=?,subject=?,marks=?,exam=? WHERE id=?');$s->bind_param('isdsi',$sid,$subject,$marks,$exam,$id);$s->execute();out(true,'Marks updated.'); }
$s=$conn->prepare('INSERT INTO marks(student_id,subject,marks,exam) VALUES(?,?,?,?) ON DUPLICATE KEY UPDATE marks=VALUES(marks)');$s->bind_param('isds',$sid,$subject,$marks,$exam);$s->execute();out(true,'Marks saved.');
