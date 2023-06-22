<?php
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php'; 
require 'phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true); 
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/'); 
$mail->IsHTML(true);

//От кого письмо
$mail->setFrom('test.otpravka@bk.ru', 'Фрилансер по жизни'); 
//Кому отправить 
$mail->addAddress('ddwwzzsa@mail.ru');
//Тема письма
$mail->Subject = 'Привет! ';

//Рука
$hand = "Правая";
if($_POST['hand'] == "left"){
    $hand = "Левая";
}

//Тело письма
$body = '<h1>Встречайте супер письмо!</h1>';

if(!empty(trim($_POST['name']))){ 
    $body .= '<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
} 
if(!empty(trim($_POST['email']))){ 
    $body .= '<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
}

if(!empty(trim($_POST['hand']))){
    $body .= '<p><strong>Рука:</strong> '.$hand.'</p>';
}

if(!empty(trim($_POST['age']))){
    $body .= '<p><strong>Сообщение:</strong> '.$_POST['message'].'</p>';
}

//Прикрепить файл 
if(!empty($_FILES['image']['tmp_name'])) {

    //путь загрузки файла
    $filePath = "/files/" . $_FILES['image']['name']; 
    //грузим файл
    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)){
        $fileAttach = $filePath;
        $body .= '<p><strong>Фото в приложении</strong></p>'; 
        $mail->addAttachment($fileAttach);
    }
}

$mail->Body = $body;

if(!$mail->send()){
    $message = 'Ошибка';
} else {
    $message = 'Данные отправлены!';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
?>