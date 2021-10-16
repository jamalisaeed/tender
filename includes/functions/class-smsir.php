<?php
/**
 * Utility Class File
 *
 * This class contains functions that help you in general tasks like rendering
 * template, convert to persian numbers and words and so on. These functions
 * have been used in many of my projects and I decide to add it in this boilerplate.
 * If you want to use some written functions which are used many times in your codes,
 * you can put it in this file (or files something like that)
 *
 * @package    Tender_Shop_Dir\Includes\Functions
 * @author     Your_Name <youremail@nomail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://yoursite.com
 * @since      1.0.0
 */

namespace Tender_Shop_Dir\Includes\Functions;

/**
 * Class Utility.
 * This class contains functions that help you in general tasks like rendering
 * template, convert to numbers and words and so on.
 *
 * @package    Tender_Shop_Dir\Includes\Functions
 * @author     Your_Name <youremail@nomail.com>
 */
class SmsIr {

    /**
     * gets API Ultra Fast Send Url.
     *
     * @return string Indicates the Url

     */
    protected function getAPIUltraFastSendUrl() {
        return "http://RestfulSms.com/api/UltraFastSend";
    }

    /**
     * gets Api Token Url.
     *
     * @return string Indicates the Url

     */
    protected function getApiTokenUrl(){
        return "http://RestfulSms.com/api/Token";
    }

    /**
     * gets config parameters for sending request.
     *
     * @param string $APIKey API Key
     * @param string $SecretKey Secret Key

     * @return void

     */
    public function __construct($APIKey,$SecretKey){
        $this->APIKey = $APIKey;
        $this->SecretKey = $SecretKey;
    }


    /**
     * Ultra Fast Send Message.
     *
     * @param data[] $data array structure of message data
     * @return string Indicates the sent sms result
     */
    public function UltraFastSend($data) {

        $token = $this->GetToken($this->APIKey, $this->SecretKey);
        if($token != false){
            $postData = $data;

            $url = $this->getAPIUltraFastSendUrl();
            $UltraFastSend = $this->execute($postData, $url, $token);
            $object = json_decode($UltraFastSend);

            if(is_object($object)){
                $array = get_object_vars($object);
                if(is_array($array)){
                    $result = $array['Message'];
                } else {
                    $result = false;
                }
            } else {
                $result = false;
            }

        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * gets token key for all web service requests.
     *

     * @return string Indicates the token key
     */
    private function GetToken(){
        $postData = array(

            'UserApiKey' => $this->APIKey,
            'SecretKey' => $this->SecretKey,
            'System' => 'php_rest_v_1_2'
        );
        $postString = json_encode($postData);

        $ch = curl_init($this->getApiTokenUrl());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'

        ));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, count($postString));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);


        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result);

        if(is_object($response)){
            $resultVars = get_object_vars($response);

            if(is_array($resultVars)){
                @$IsSuccessful = $resultVars['IsSuccessful'];
                if($IsSuccessful == true){
                    @$TokenKey = $resultVars['TokenKey'];
                    $resp = $TokenKey;
                } else {
                    $resp = false;
                }
            }
        }


        return $resp;
    }

    /**
     * executes the main method.
     *
     * @param postData[] $postData array of json data
     * @param string $url url
     * @param string $token token string
     * @return string Indicates the curl execute result
     */
    private function execute($postData, $url, $token){

        $postString = json_encode($postData);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'x-sms-ir-secure-token: '.$token
        ));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, count($postString));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}