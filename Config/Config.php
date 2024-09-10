 <?php

  //define("BASE_URL", "http://localhost:8080/Bogallery_pro");
  //define("BASE_URL", "http://localhost/bogallery_pro");

  const BASE_URL = "http://localhost/bogallery_pro";
  //Zona horaria
  date_default_timezone_set('America/Bogota');

  const DB_HOST = "localhost";
  const DB_NAME = "pro_bogallery";
  const DB_USER = "root";
  const DB_PASSWORD = "";
  const DB_CHARSET = "charset=utf8";
  // para envio del correo
  const ENVIRONMENT = 0; //Local:0, produccion: 1;

  //Deliminadores decimal y millar
  const SPD = "."; // Delimitador de decimales
  const SPM = ","; // Delimitador de miles

  //Simbolo de la moneda
  const SMONEY = "$";
  const CURRENCY = "USD";

 //API paypal
 //SAMBOX PAYPAL
  const IDCLIENTE ="AfPh5BBTzI2gEjDYDDxo4EM4dgRcA4mm1c8r_HQTfzBQEUHvcsEHjVtrBaLBaxQNKfTAqGEpt64tKMIV";
  //vERCION DE PRODUCCION CAMBIAR EL ID 
  //const IDCLIENTE ="AfPh5BBTzI2gEjDYDDxo4EM4dgRcA4mm1c8r_HQTfzBQEUHvcsEHjVtrBaLBaxQNKfTAqGEpt64tKMIV";

  //Datos envio correo
  const NOMBRE_REMITENTE = "BoGallery";
  const EMAIL_REMITENTE = "no-reply@estefa.com";
  const NOMBRE_EMPRESA = "BoGallery";
  const WEB_EMPRESA = "www.BoGallery.com";

  //Aca se configura para extraer las categorias que se van a visualizar slider
  const CAT_SLIDER = "1,2,3";
  //Aca se configura para extraer las categorias que se van a visualisar en el Banner
  const CAT_BANNER = "4,5,6,7,8,9";

  // Constante para encriptar 
  const KEY ='bogobogo';
  const METHODENCRIPT = "AES-128-ECB";

  //Envio o valor adiccional
  const COSTOENVIO = 0;
    
