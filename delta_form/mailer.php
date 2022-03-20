<?php
header("Access-Control-Allow-Origin: *");
require_once __DIR__ . '/phpmailer/PHPMailerAutoload.php';

if(!isset($_POST["params"])) {
	exit();
}

$params = json_decode($_POST["params"], true);

$values = $params[0]["vals"];
$qty = $params[0]["qty"];
$firm = ($params[0]["firm"] !== "") ? $params[0]["firm"] : "Firma Bilgisi Yok";
$auth = $params[0]["auth"];
$email = $params[0]["email"];
$phone = $params[0]["phone"];
$note = $params[0]["note"];
$category = $params[0]["category"];
$image = $params[0]["image"];
$oil_channel = $params[0]["oil"];
$tolerance_type = $params[0]["tolerancetype"];

$body = '<img src="https://dev.digitalfikirler.com/delta_form/logo.jpg" width="220"/><br><br>Sayın yetkili,<br><br>' . $auth . '(' . $firm . ') ' . $category . ' bir teklif talebinde bulundu. <br><br>';
$body .= '<!--[if gte MSO 9]>
		<table width="640">
		<tr>
			<td>
		<![endif]-->
		<table width="100%" style="max-width:640px;">
		<tr>
			<td>
			<img src="https://shop.deltakalip.com' . $image . '" width="100%" />
			</td>
		</tr>
		</table>
		<!--[if gte MSO 9]>
			</td>
		</tr>
		</table>
    <![endif]--><table><tr>
		<th>
			Yağ Kanalı
		</th>
		<td>
			' . $oil_channel . '
		</td>
	</tr><tr>
		<th>
			Tolerans Değerleri
		</th>
		<td>
			' . $tolerance_type . '
		</td>
	</tr></table><br><table>
	<thead>
		<tr><th style="border: solid 1px; padding: 1rem;">Ölçü Adı</th>
		<th style="border: solid 1px; padding: 1rem;">Ölçü Değeri</th>
		<th style="border: solid 1px; padding: 1rem;">Tolerans Değeri</th>
	</tr></thead>
	<tbody>';
for ($index=0; $index < count($values); $index++) { 

    // $body .= 'Ölçü Adı: ' . $values[$index]["title"] . "\t | \t Ölçü Değeri: " . $values[$index]["value"] . "\t | \t Tolerans Değeri: " . $values[$index]["tolerance"] . '<br><br>';
	// $body .= '<tr><th style="border: solid 1px; padding: 10px;">Ölçü Adı</th><td style="border: solid 1px; padding: 10px;">' . $values[$index]["title"] . '</td><th style="border: solid 1px; padding: 10px;">Ölçü Değeri</th><td style="border: solid 1px; padding: 10px;">' . $values[$index]["value"] . '</td>
	// 	<th style="border: solid 1px; padding: 10px;">Tolerans Değeri</th><td style="border: solid 1px; padding: 10px;">' . $values[$index]["tolerance"] . '</td></tr>';

	$body .= '<tr>
		<td style="border: solid 1px; padding: 1rem; text-align: center">' . $values[$index]["title"] . '</td>
		<td style="border: solid 1px; padding: 1rem; text-align: center">' . $values[$index]["value"] . '</td>
		<td style="border: solid 1px; padding: 1rem; text-align: center">' . $values[$index]["tolerance"] . '</td>
	</tr>';
}
$body .= '</tbody></table><br><br>Adet: ' . $qty . '<br><br>Telefon: ' . $phone . '<br>Email: ' . $email . '<br>Not: ' . $note . '<br><br>İyi çalışmalar dileriz.';
$response = sendEmail("deltakalip@deltakalip.com", "deltakalip.com", $body, []);

if($response == 1) {
	echo 1;
}
else {
	echo 0;
}

function sendEmail($email, $name, $body, $attachment = null) {
			
	try {
		$mail = new PHPMailer();
		$mail->IsSMTP();

		$mail->SMTPAuth = true;
		$mail->Host = 'smtp.office365.com';
		$mail->Port = 587;
		$mail->Username = 'deltakalip@deltakalip.com';
		$mail->Password = 'Duq26990';

		$mail->SetFrom("deltakalip@deltakalip.com", 'deltakalip.com');
		$mail->AddAddress($email, $name);
		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'Teklif - deltakalip.com';
		$mail->IsHTML(true);
		$mail->MsgHTML($body);
		// $mail->SMTPDebug = 2;
		// $mail->SMTPOptions = array(
		// 	"ssl" => array(
		// 		"verify_peer" => false,
		// 		"verify_peer_name" => false,
		// 		"allow_self_signed" => true
		// 	)
		// );

		if(is_array($attachment)) {
			
			for($i = 0; $i < count($attachment); $i++) {
				
				$mail->AddAttachment($attachment[$i]["path"], $attachment[$i]["name"], 'base64', $attachment[$i]["type"]);

			}

		}

		if($mail->Send()) {
			
			return 1;
					
		} 
		else {
					
			return 0;
					
		}
	
	}
	catch (phpmailerException $e) {
		
	  return $e->errorMessage();
	  
	} 
	catch (Exception $e) {
		
	  return $e->getMessage(); 
	  
	}
	
}
?>