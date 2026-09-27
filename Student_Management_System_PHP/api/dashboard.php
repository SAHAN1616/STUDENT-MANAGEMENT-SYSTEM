<?php
require_once __DIR__.'/../config.php';header('Content-Type: application/json');
$students=(int)$conn->query('SELECT COUNT(*) c FROM students')->fetch_assoc()['c'];$teachers=(int)$conn->query('SELECT COUNT(*) c FROM teachers')->fetch_assoc()['c'];
$today=$conn->query("SELECT COUNT(*) total,SUM(status='Present') present FROM attendance WHERE date=CURDATE()")->fetch_assoc();$att=((int)$today['total'])?round(((int)$today['present']/(int)$today['total'])*100,1):0;
$fees=$conn->query('SELECT COALESCE(SUM(amount),0) total,COALESCE(SUM(paid),0) paid FROM fees')->fetch_assoc();
function out($ok,$msg='',$data=[]){echo json_encode(array_merge(['success'=>$ok,'message'=>$msg],$data));exit;} out(true,'',['students'=>$students,'teachers'=>$teachers,'attendance'=>$att,'fees_total'=>(float)$fees['total'],'fees_paid'=>(float)$fees['paid'],'fees_due'=>(float)$fees['total']-(float)$fees['paid']]);
