# LinSms PHP SDK #

Today sms is considered the best communication medium because of the increased use of hand held mobile phones.

 People spend most of the time with their phones and it is considered appropriate since someone can read sms during their free time or at lunch breaks.
 
## Installation ##

linlak/linsms-php-sdk can be installed via composer a PHP dependency manager.
To install open terminal or command prompt in your project root and run the command below. 

	composer require linlak/linsms-php-sdk
	
That all you need to have linlak/linsms-php-sdk installed in your project

## Integration ##

If you are at this point, then you either have an account with LinSMS or you need an Api that will help you to easily integrate our sms gateway into your bulksms system or you are planning to have an online payment system integrated into you App or Website.

To integrate with our system, you must have an account with LinSMS and must have created an App with both **client_id** and **secret** which are required to  **initialize** the Api.

**Caution:** Never use you secret in a non secure environment. If you suspect any lick in your **client_id** or **secret** you can always refresh them i.e request new client_id or secret for your App in the developer console.

##Initialization##
Before you proceed, we assume that you **installed** this sdk via **composer** and that you have created an App on the Develover console at LinSMS. If you have not yet, then read the **Integration**  section above.

To intialize the Api create a file and name it **bootstrap.php**

	<?php
		require_once "{location to your vendor directory}/vendor/autoload.php";
		
		use LinSms\LinSMSClient;
		
		$client_id="";
		$secret="";
		
		$linsmsClient=LinSMSClient::init($client_id, $secret);
		
		

## SMS Api ##
The SMS Api is enabled by default, after creating the App on developer console, just copy your client_id and secret into your **bootstrap.php** and you will be good to go. However if you do not need SMS sending functionality, you can simply disable it on the developer console.

**Examples on SMS api**

**1. check SMS balance**

Create a file named **sms_balance.php**

	<?php
		require_once "./bootstrap.php";
		
		use LinSms\Util\HttpCodes;
		
		$response=$linsmsClient->balance();
		if($response->status_code===HttpCodes::HTTP_OK){
			echo $response->getBalance();
		}else{
			echo $response->status_phrase;
		}

**2. Send SMS**

Here repeated and invalid or unsupported numbers will be filtered before you send the request.

Create a file named **send_sms.php**

	<?php
		
		require_once "./bootstrap.php";
		
		use LinSms\Util\HttpCodes;
		
		$sender_id="testing";
		$message="This is a test message";
		$recipients="{comma seperated ugandan phone numbers}";
		
		$response=$linsmsClient->sendSMS($sender_id, $message, $recipients);
		
		if($response->isSent())
		{
			echo "refrenceId ". $response->getReferenceId();
			echo"\r\n";
			echo "sender_id ". $response->getSenderId();
			echo"\r\n";
			echo "message ". $response->getMessage();
			echo"\r\n";
			echo "recipients ". $response->getRecipients();
		}
		
**3. Check SMS status**

This checks if the SMS was sent, failed or pending. Created a file named **sms_status.php**

	<?php
		
		require_once "./bootstrap.php";
		
		use LinSms\Util\HttpCodes;
		
		$refrenceId="testing";
		
		
		$response=$linsmsClient->smsStatus($refrenceId);
		
		if($response->isSent())
		{
			echo "refrenceId ". $response->getReferenceId();
			echo"\r\n";
			echo "sender_id ". $response->getSenderId();
			echo"\r\n";
			echo "message ". $response->getMessage();
			echo"\r\n";
			echo "recipients ". $response->getRecipients();
		}


## Payment Api ##
Coming soon

## Payout Api ##

Coming soon