# Begranda facturación electrónica
Habilita enviar facturas electrónicas a la DIAN por medio del API de Begranda

## Acerca de 

[![Packagist](https://img.shields.io/packagist/v/fvalencial/begrandafe.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/fvalencial/begrandafe)
[![StyleCI](https://styleci.io/repos/93313402/shield)](https://styleci.io/repos/93313402)
[![License](https://img.shields.io/packagist/l/fvalencial/begrandafe.svg?label=License&style=flat-square)](https://github.com/fvalencial/begrandafe/blob/develop/LICENSE)

Usando la libería en PHP de begranda, podrás enviar facturas electronicas a la DIAN de una forma sencilla y limpia

### Requerimientos

* php >= 5.6
* [Llave de Begranda](https://begranda.com) -Llave de acceso para enviar tus facturas


### Instalación con Composer

Ejecuta `composer require fvalenciabg/begrandafe`.


### Enviar una factura

El proceso para enviar una factura electronica simple

```
$endpoint = getenv("BEGRANDA_ENDPOINT");
$key = getenv("BEGRANDA_KEY");

$invoice = new Invoice($endpoint,$key);
$datetime = date("Y-m-d h:i:s");
$invoice->
setInvoice("990000022")->
setSeller([
    "nit"=>"44373983",
    "name"=>"Vendedor",
    "location"=>[
        "address"=>"Cl 46 AA 43",
        "countryCode"=>"CO",
        "city"=>"Medellín",
        "subdivission"=>"Poblado",
        "department"=>"Antioquia"
    ]
])->
setDate($datetime)->
setBase(100000.00)->
setTotal(119000.00)->
setIva(19000.00)->
setIca(0)->
setIpo(0)->
setBuyer([
    "nit"=>"45747373",
    "name"=>"Comprador",
    "type"=>31,
    "location"=>[
        "address"=>"CR 33 56 34",
        "countryCode"=>"CO",
        "city"=>"Medellin",
        "subdivission"=>"Belen",
        "department"=>"Antioquia"
    ]
]);
$invoice->send();
```
### Dudas

Si tienes dudas o inconveninentes no dudes en escribirnos a soporte@begranda.com.