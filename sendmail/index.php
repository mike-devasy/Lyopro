<?php
// Налаштування відправки
require 'config.php';

//Від кого лист
$mail->setFrom('some@gmail.com', 'Lyopro.tech'); // Вказати потрібний E-mail
//Кому відправити
$mail->addAddress('mike.devasy@gmail.com'); // Вказати потрібний E-mail
//Тема листа
$mail->Subject = 'Hello!This is the letter from the site Lyopro!';

//Тіло листа
// Начало письма
$body = '<h1>New application from the site</h1>';
$body .= '<table style="width: 100%; border-collapse: collapse;">';

// Словарь для "красивых" названий полей (необязательно)
$labels = [
    'name'      => 'Name',
    'surname'   => 'Last Name',
    'email'     => 'Email',
    'company'   => 'Company',
    'job'       => 'Job Title',
    'challenge' => 'Challenge',
];

if (isset($_POST['form']) && is_array($_POST['form'])) {
    foreach ($_POST['form'] as $key => $value) {
        $value = trim($value);
        
        if ($value !== "") {
            // Берем красивое имя из словаря, если его нет — просто делаем первую букву заглавной
            $label = isset($labels[$key]) ? $labels[$key] : ucfirst($key);
            
            // Безопасно обрабатываем текст
            $safeValue = nl2br(htmlspecialchars($value));
            
            // Добавляем строку в таблицу письма
            $body .= "
                <tr style='background-color: #f8f8f8;'>
                    <td style='padding: 10px; border: #e9e9e9 1px solid; width: 30%;'><b>$label</b></td>
                    <td style='padding: 10px; border: #e9e9e9 1px solid;'>$safeValue</td>
                </tr>";
        }
    }
}

$body .= '</table>';
 //Тіло листа
// $body = '<h1>Зустрічайте супер листа!</h1>';

// Проверяем существование массива 'form' в POST
// if (isset($_POST['form'])) {
//     $formData = $_POST['form'];

//     if (!empty(trim($formData['name']))) {
//         $body .= '<p><strong>Name:</strong> ' . htmlspecialchars($formData['name']) . '</p>';
//     }
//     if (!empty(trim($formData['surname']))) {
//         $body .= '<p><strong>Last Name:</strong> ' . htmlspecialchars($formData['surname']) . '</p>';
//     }
//     if (!empty(trim($formData['email']))) {
//         $body .= '<p><strong>Email:</strong> ' . htmlspecialchars($formData['email']) . '</p>';
//     }
//     if (!empty(trim($formData['company']))) {
//         $body .= '<p><strong>Company:</strong> ' . htmlspecialchars($formData['company']) . '</p>';
//     }
//     if (!empty(trim($formData['job']))) {
//         $body .= '<p><strong>Job Title:</strong> ' . htmlspecialchars($formData['job']) . '</p>';
//     }
//     if (!empty(trim($formData['challenge']))) {
//         $body .= '<p><strong>Challenge:</strong> ' . nl2br(htmlspecialchars($formData['challenge'])) . '</p>';
//     }
// }

/*
	//Прикріпити файл
	if (!empty($_FILES['image']['tmp_name'])) {
		//шлях завантаження файлу
		$filePath = __DIR__ . "/files/sendmail/attachments/" . $_FILES['image']['name']; 
		//грузимо файл
		if (copy($_FILES['image']['tmp_name'], $filePath)){
			$fileAttach = $filePath;
			$body.='<p><strong>Фото у додатку</strong>';
			$mail->addAttachment($fileAttach);
		}
	}
	*/

$mail->Body = $body;

//Відправляємо
if (!$mail->send()) {
	$message = 'Помилка';
} else {
	$message = 'Дані надіслані!';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
