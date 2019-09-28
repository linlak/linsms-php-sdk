<?php

namespace LinSms\Bootstrap;

use App\Services\Traits\Sms\ParseContacts;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use LinSms\Contracts\InitContract;
use LinSms\Response\BalanceResponse;
use LinSms\Response\DepositResponse;
use LinSms\Response\PayoutResponse;
use LinSms\Response\SmsResponse;
use LinSms\Response\WalletBalanceResponse;
use LinSms\Util\Constants;
use Psr\Http\Message\ResponseInterface;

class Init implements InitContract
{
    use ParseContacts;

    private $client_id = "";
    private $secret = "";
    /**
     * @var \GuzzleHttp\Client
     * 
     */
    private $_client;
    private $headers = [];

    public function __construct($client_id, $secret)
    {
        $this->client_id = $client_id;
        $this->secret = $secret;
        $this->_client = new Client([
            'base_uri' => Constants::API_URI,
            'verify' => false,
            'timout' => 40

        ]);
        $this->getHeaders();
    }

    private function getHeaders()
    {
        $authKey = $this->client_id . ':' . $this->secret;
        $this->setHeaders(Constants::H_AUTH, 'Basic ' . base64_encode($authKey));
    }

    public function setHeaders($key, $value)
    {

        $this->headers[$key] = $value;
    }

    public function removeHeader($key)
    {
        if (!array_key_exists($key, $this->headers)) {
            return;
        }
        unset($this->headers[$key]);
    }

    public function sendSMS($sender_id, $message, $recipients)
    {
        $vrecipients = $this->cleanContacts($recipients);
        if (count($vrecipients) > 0) {
            $data = [
                'message' => $message,
                'sender_id' => $sender_id,
                'recipients' => \join(',', $vrecipients)
            ];
            $req = $this->genRequest("POST", Constants::SEND_URI, $data);
            $res = $this->send($req);
            return new SmsResponse($res);
        }
        return false;
    }

    public function smsStatus($reference_id)
    {
        $req = $this->genRequest("GET", Constants::STATUS_URI . $reference_id);
        $res = $this->send($req);
        return new SmsResponse($res);
    }
    public function balance()
    {
        $req = $this->genRequest("GET", Constants::BALANCE_URI);
        $res = $this->send($req);
        return new BalanceResponse($res);
    }
    /**
     * @param string $mtd
     * @param string $url
     * @param mixed array|boolean
     * @return \GuzzleHttp\Psr7\Request
     */
    private function genRequest($mtd, $url, $body = false)
    {
        if (false === $body) {
            $this->removeHeader(Constants::H_C_TYPE);
            $request = new Request($mtd, $url, $this->headers);
        } else {
            $this->setHeaders(Constants::H_C_TYPE, 'application/json');
            if (is_array($body)) {
                $body = json_encode($body, JSON_UNESCAPED_SLASHES);
            }
            $this->setHeaders("Content-Length", strlen($body));

            $request = new Request($mtd, $url, $this->headers, $body);
        }
        return $request;
    }
    /**
     * @param \GuzzleHttp\Psr7\Request [$request]
     * 
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    private function send(Request $request)
    {
        $promise = $this->_client->sendAsync($request)
            ->then(function (ResponseInterface $res) {
                // echo(Psr7\str($res));	
                return $this->passResponse($res);
            }, function (RequestException $e) {
                // echo(Psr7\str($e->getRequest())."\n\r");	
                if ($e->hasResponse()) {
                    // echo(Psr7\str($e->getResponse())."\n\r");		
                    return $this->passResponse($e->getResponse());
                }
                return [
                    'status_code' => $e->getCode(),
                    'status_phrase' => "Connection Error"
                ];
            });
        return  $promise->wait();
    }
    /**
     * @param \Psr\Http\Message\ResponseInterface [$response]
     * 
     * @return mixed array|boolean
     */
    private function passResponse(ResponseInterface $response)
    {

        if ($response !== null) {

            $output = [
                "status_code" => $response->getStatusCode(),
                "status_phrase" => $response->getReasonPhrase(),
            ];
            $body = $response->getBody();
            $output['data'] = json_decode($body->getContents(), 1);
            return $output;
        }
        return false;
    }
    //payments
    public function walletBalance()
    {
        $req = $this->genRequest('GET', Constants::PAY_BAL);
        $response = $this->send($req);
        //pass response
        return new WalletBalanceResponse($response);
    }

    public function deposit(string $mobile_number, int $amount, $payload = [])
    {
        $data = [
            'phone_number' => $mobile_number,
            'amount' => $amount,
            'payload' => $payload
        ];

        $req = $this->genRequest('POST', Constants::DEPOSIT_URI, $data);

        $response = $this->send($req);
        //pass response
        return new DepositResponse($response);
    }

    public function depositStatus($reference_id)
    {
        $req = $this->genRequest('GET', Constants::DEPOSIT_STATUS . $reference_id);
        $response = $this->send($req);
        //pass response
        return new DepositResponse($response);
    }

    //payout

    public function payout(String $mobile_number, int $amount, $payload = [])
    {
        $data = [
            'phone_number' => $mobile_number,
            'amount' => $amount,
            'payload' => $payload
        ];

        $req = $this->genRequest('POST', Constants::PAYOUT_URI, $data);

        $response = $this->send($req);
        return new PayoutResponse($response);
    }

    public function payoutStatus($reference_id)
    {
        $req = $this->genRequest('GET', Constants::PAYOUT_STATUS . $reference_id);
        $response = $this->send($req);
        //pass response
        return new PayoutResponse($response);
    }
}
