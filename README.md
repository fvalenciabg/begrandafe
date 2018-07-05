# Begranda facturación electrónica
Habilita enviar facturas electrónicas a la DIAN por medio del API de Begranda

## Acerca de 

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
setInvoiceNumber("990000022")->
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
setInvoiceDate($datetime)->
setInvoiceBase(100000.00)->
setInvoiceTotal(119000.00)->
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
])
```
### Dudas

Si tienes dudas o inconveninentes no dudes en escribirnos a soporte@begranda.com.