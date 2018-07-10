<?php

namespace Fvalencial\BegrandaFe;

class Invoice
{
    protected $seller;
    protected $apiKey;
    protected $endpoint;

    public $paymentMethods = [
        10=>"Efectivo",
        20=>"Cheque",
        41=>"Transferencia bancaria",
        42=>"Consignación bancaria",
    ];
 
    public $paymentChannels = [
        1=>"Ordinary post",
        2=>"Air mail",
        3=>"Telegraph",
        4=>"Telex",
        5=>"S.W.I.F.T.",
        6=>"Other transmission networks",
        7=>"Networks not defined",
        8=>"Fedwire",
        9=>"Personal (face-to-face)",
        10=>"Registered air mail",
        11=>"Registered mail",
        12=>"Courier",
        13=>"Messenger",
        14=>"National ACH",
        15=>"Other ACH"
    ];

    public $invoiceTypes = [
        1=>"Factura de Venta",
        2=>"Factura de Exportación",
        3=>"Factura de Contingencia",
        4=>"Factura de Importación Vigencia suspendida",
    ];

    public $nitTypes = [
        "R-00-PN"=>"No obligado a registrarse en el RUT PN",
        11=>"Registro civil",
        12=>"Tarjeta de identidad",
        13=>"Cédula de ciudadanía",
        21=>"Tarjeta de extranjería",
        22=>"Cédula de extranjería",
        31=>"NIT",
        41=>"Pasaporte",
        42=>"Documento de identificación extranjero",
        91=>"NUIP *",
    ];
    
    public function __construct($endpoint,$key){
        if(!$endpoint || !$key){
            throw new \Exception("Endpoint and key are required");
        }
        $this->endpoint = $endpoint;
        $this->key = $key;
    }
    
    public function setSeller(Array $seller){
        $this->seller = $seller;
        return $this;
    }
    public function setBuyer(Array $buyer){
        if(!in_array($buyer["type"],array_keys($this->nitTypes))){
            throw new \Exception("Invalid buyer type");
        }
        $this->buyer = $buyer;
        return $this;
    }
    public function setIva(Int $iva){
        $this->iva = $iva;
        return $this;
    }
    public function setBase(Int $base){
        $this->base = $base;
        return $this;
    }
    public function setTotal(Int $total){
        $this->total = $total;
        return $this;
    }
    public function setIca(Int $ica){
        $this->ica = $ica;
        return $this;
    }
    public function setInvoice(String $invoice){
        $this->invoice = $invoice;
        return $this;
    }
    public function setDate(String $date){
        $this->date = $date;
        return $this;
    }
    public function setIpo(Int $ipo){
        $this->ipo = $ipo;
        return $this;
    }

    public function setAuthorizationNumber($authorizationNumber){
        $this->invoiceAuthorization = $authorizationNumber;
        return $this;
    }

    public function setAuthorizationPeriod($from,$to){
        $this->authorizationPeriod = [$from,$to];
        return $this;
    }

    public function setAuthorizationInvoiceFrom($authorizationInvoiceFrom){
        $this->invoiceNumberFrom = $authorizationInvoiceFrom;
        return $this;
    }
    
    public function setAuthorizationInvoiceTo($authorizationInvoiceTo){
        $this->invoiceNumberTo = $authorizationInvoiceTo;
        return $this;
    }
    public function setPaymentMethod(Int $paymentMethod){
        if(!in_array($paymentMethod,array_keys($this->paymentMethods))){
            throw new \Exception("Invalid payment method");
        }
        $this->paymentMethod = $paymentMethod;
        return $this;
    }
    public function setPaymentChannel(Int $paymentChannel){
        if(!in_array($paymentChannel,array_keys($this->paymentChannels))){
            throw new \Exception("Invalid payment method");
        }
        $this->paymentChannel = $paymentChannel;
        return $this;
    }
    private function validateFields(){
        if(!isset($this->seller)){
            throw new \Exception("The field seller is required");
        }
        if(!isset($this->buyer)){
            throw new \Exception("The field buyer is required");
        }
        if(!isset($this->iva)){
            throw new \Exception("The field iva is required");
        }
        if(!isset($this->base)){
            throw new \Exception("The field base is required");
        }
        if(!isset($this->total)){
            throw new \Exception("The field total is required");
        }
        if(!isset($this->ica)){
            throw new \Exception("The field ica is required");
        }
        if(!isset($this->ipo)){
            throw new \Exception("The field ipo is required");
        }
        if(!isset($this->invoice)){
            throw new \Exception("The field invoice is required");
        }
        if(!isset($this->date)){
            throw new \Exception("The field date is required");
        }
        if(!isset($this->paymentMethod)){
            throw new \Exception("The field paymentMethod is required");
        }
        if(!isset($this->paymentChannel)){
            throw new \Exception("The field paymentChannel is required");
        }
        if(!isset($this->invoiceAuthorization)){
            throw new \Exception("The field invoiceAuthorization is required");
        }
        if(!isset($this->authorizationPeriod)){
            throw new \Exception("The field authorizationPeriod is required");
        }
        if(!isset($this->invoiceNumberFrom)){
            throw new \Exception("The field invoiceNumberFrom is required");
        }
        if(!isset($this->invoiceNumberTo)){
            throw new \Exception("The field invoiceNumberTo is required");
        }
    }
    public function send(){
        $this->validateFields();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$this->endpoint."/invoice");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Authorization: '.$this->key,
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            http_build_query(array('payload' => json_encode([
                "seller"=>$this->seller,
                "buyer"=>$this->buyer,
                "iva"=>$this->iva,
                "base"=>$this->base,
                "total"=>$this->total,
                "ica"=>$this->ica,
                "ipo"=>$this->ipo,
                "invoice"=>$this->invoice,
                "date"=>$this->date,
                "paymentMethod"=>$this->paymentMethod,
                "paymentChannel"=>$this->paymentChannel,
                "authorization"=>[
                    "number"=>$this->invoiceAuthorization,
                    "dateFrom"=>$this->authorizationPeriod[0],
                    "dateTo"=>$this->authorizationPeriod[1],
                    "invoiceFrom"=>$this->invoiceNumberFrom,
                    "invoiceTo"=>$this->invoiceNumberTo,
                ]
            ])))
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($httpcode == 500){
            echo $server_output;
            die;
        }
        $jsonResponse = json_decode($server_output);
        if(!$jsonResponse){
            throw new \Exception("Malformed response");
        }
        curl_close ($ch);
        $jsonResponse->code = $httpcode;
        return $jsonResponse;
    }
}
