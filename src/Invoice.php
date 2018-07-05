<?php

namespace Fvalencial\BegrandaFe;

class Invoice
{
    protected $seller;
    protected $apiKey;
    protected $endpoint;

    public function __construct($endpoint,$key){
        $this->endpoint = $endpoint;
        $this->key = $key;
    }
    
    public function setSeller(Array $seller){
        $this->seller = $seller;
        return $this;
    }
    public function setBuyer(Array $buyer){
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
    public function invoice(String $invoice){
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
    public function send(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$this->endpoint);
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
            ])))
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        curl_close ($ch);
        return json_decode($server_output);
    }
}
