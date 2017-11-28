<?php
	/* Осуществляем проверку вводимых данных и их защиту от враждебных 
		скриптов */
	$input_data = array(
		"Name" => array(
			"VALUE" => "",
			"ONERROR" => "Введите имя!",
			"ERROR" => 0
		),
		"Email" => array(
			"VALUE" => "",
			"ONERROR" => "Некорректный E-mail!",
			"ERROR" => 0
		),
		"Phone" => array(
			"VALUE" => "",
			"ONERROR" => "Введите телефон!",
			"ERROR" => 0
		)
	);
	
	$result = array("status" => "success");
	
	foreach($_POST as $item_key => $value) {
		$input_data[$item_key]["VALUE"] = htmlspecialchars($value);
		$input_data[$item_key]["VALUE"] = trim($input_data[$item_key]["VALUE"]);
		$input_data[$item_key]["VALUE"] = stripslashes($input_data[$item_key]["VALUE"]);
		$input_data[$item_key]["VALUE"] = htmlspecialchars($input_data[$item_key]["VALUE"]);
		if(strlen($input_data[$item_key]["VALUE"]) == 0 || ($item_key == "Email" && !preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $input_data[$item_key]["VALUE"]))) {
			$result["status"] = "error";
			$input_data[$item_key]["ERROR"] = 1;
			$result["errors"][] = array(
				"field_name" => $item_key,
				"error_text" => $input_data[$item_key]["ONERROR"]
			);
		}
	}
	
	if($result["status"] == "success") {
		$message = "С лендинга 'Арендный бизнес в ЦАО' отправлена заявка
		Имя отправителя: $your_name 
		E-mail: $email 
		Телефон: $phone";
		//$to = "info@deltaestate.ru, secretary@deltaestate.ru, lena@deltaestate.ru, devyatov@deltaestate.ru";
		$to = "terenchuk@deltaestate.ru";
		$subject = "С лендинга 'Арендный бизнес в ЦАО' отправлена заявка";
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <it-bot@deltaestate.ru>' . "\r\n";
		mail($to, $subject, $message, $headers);
	}
	
	echo json_encode($result);
?>