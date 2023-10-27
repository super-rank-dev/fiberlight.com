<?php

/**
 * WhatsApp webhook Request class
 * 
 * @since 1.0.0
 */
class Qcld_WA_Request {

    /**
     * Account Sid
     *
     * @var string
     * 
     * @since 1.0.0
     */
    private $AccountSid = '';

    /**
     * Api Version
     *
     * @var string
     * 
     * @since 1.0.0
     */
    private $ApiVersion = '';

    /**
     * Request body
     *
     * @var string
     * 
     * @since 1.0.0
     */
    private $Body = '';

    /**
     * From whatsApp Number
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    private $From = '';

    /**
     * Message Sid
     *
     * @var string
     * 
     * @since 1.0.0
     */
    private $MessageSid = '';

    /**
     * Number of Media
     *
     * @var int
     * 
     * @since 1.0.0
     */
    private $NumMedia = 0;

    /**
     * Number of Segments
     *
     * @var int
     * 
     * @since 1.0.0
     */
    private $NumSegments = 0;

    /**
     * Profile Name
     *
     * @var string
     * 
     * @since 1.0.0
     */
    private $ProfileName = '';

    /**
     * Sms Message Sid
     *
     * @var string
     * 
     * @since 1.0.0
     */
    private $SmsMessageSid = '';

    /**
     * Sms Sid
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    private $SmsSid = '';

    /**
     * Sms Status
     *
     * @var string
     * 
     * @since 1.0.0
     */
    private $SmsStatus = '';

    /**
     * To WhatsApp number
     *
     * @var string
     * 
     * @since 1.0.0
     */
    private $To = '';

    /**
     * WaId
     *
     * @var string
     * 
     * @since 1.0.0
     */
    private $WaId = '';

    /**
     * Construction
     * 
     * @since 0.0.9
     * @param null
     * @return null
     */
    public function __construct(){

        $data = $_POST;

        $this->AccountSid = isset( $data['AccountSid'] ) ? $data['AccountSid'] : '';
        $this->ApiVersion = isset( $data['ApiVersion'] ) ? $data['ApiVersion'] : '';
        $this->Body = isset( $data['Body'] ) ? $data['Body'] : '';
        $this->From = isset( $data['From'] ) ? $data['From'] : '';
        $this->MessageSid = isset( $data['MessageSid'] ) ? $data['MessageSid'] : '';
        $this->NumMedia = isset( $data['NumMedia'] ) ? $data['NumMedia'] : 0;
        $this->NumSegments = isset( $data['NumSegments'] ) ? $data['NumSegments'] : 1;
        $this->ProfileName = isset( $data['ProfileName'] ) ? $data['ProfileName'] : '';
        $this->SmsMessageSid = isset( $data['SmsMessageSid'] ) ? $data['SmsMessageSid'] : '';
        $this->SmsSid = isset( $data['SmsSid'] ) ? $data['SmsSid'] : '';
        $this->SmsStatus = isset( $data['SmsStatus'] ) ? $data['SmsStatus'] : '';
        $this->To = isset( $data['To'] ) ? $data['To'] : '';
        $this->WaId = isset( $data['WaId'] ) ? $data['WaId'] : '';
        
    }

    public function getAccountSid() {
        return $this->AccountSid;
    }

    public function getApiVersion() {
        return $this->ApiVersion;
    }

    public function getBody() {
        return $this->Body;
    }

    public function getFrom() {
        return $this->From;
    }

    public function getMessageSid() {
        return $this->MessageSid;
    }

    public function getProfileName() {
        return $this->ProfileName;
    }

    public function getSmsMessageSid() {
        return $this->SmsMessageSid;
    }

    public function getSmsSid() {
        return $this->SmsSid;
    }

    public function getSmsStatus() {
        return $this->SmsStatus;
    }

    public function getTo() {
        return $this->To;
    }

    public function getWaId() {
        return $this->WaId;
    }

}