<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kkoat_m extends CI_Model
{
	function __construct(){
		parent::__construct();
	}

	public function token_generation(){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://bizmsg-web.kakaoenterprise.com/v1/oauth/token',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
			CURLOPT_HTTPHEADER => array(
				'accept: */*',
				'Authorization: Basic C000000395 C000000395_Cirppl7ATV2L1biJ0IM7vA',
				'Content-Type: application/x-www-form-urlencoded'
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$result = json_decode($response,true);
		return $result['access_token'];
	}

	public function ent_prise_kakao_send($token,$phone,$msg,$tmpcode){

		$headers = array(
			'accept: */*',
			'Content-Type: application/json',
			'Authorization: Bearer '.$token
		);

		$params = array(
			'client_id'=>'C000000395',
			'message_type'=>'AT',
			'sender_key'=>'84d51c1d5bb34d7656facc25429797b6452a8ede',
			'phone_number'=>$phone,
			'message'=>$msg,
			'template_code'=>$tmpcode,
			'sender_no'=>'1522-3176',
		);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://bizmsg-web.kakaoenterprise.com/v1/message/send',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($params),
			CURLOPT_HTTPHEADER => $headers,
		));

		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	public function nhn_cloud_kakao_send($templateCode,$recipientNo,$templateParameter){
		$headers = array(
			'X-Secret-Key: ViMrtYZn',
			'Content-Type: application/json'
		);

		$parameters = array(
			'senderKey'=>'48d50d8972837f8c9da01db9d45ff1a467200fe0',
			'templateCode'=>$templateCode,
			'recipientList'=>array(
				array(
					'recipientNo'=>$recipientNo,
					'templateParameter'=>$templateParameter
				)
			)
		);

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, "https://api-alimtalk.cloud.toast.com/alimtalk/v2.2/appkeys/nXAi274ozLVUPa57/messages");
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($parameters));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOSIGNAL, true);
		curl_setopt($curl, CURLOPT_VERBOSE, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($curl);
		curl_close($curl);

		$result = json_decode($response,true);
		return $result['header']['resultCode'];
	}
}
