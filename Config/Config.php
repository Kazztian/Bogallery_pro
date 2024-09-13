 <?php

  //define("BASE_URL", "http://localhost:8080/Bogallery_pro");
  //define("BASE_URL", "http://localhost/bogallery_pro");

  const BASE_URL = "http://localhost:8080/Bogallery_pro";
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
  const SPD = ","; // Delimitador de decimales
  const SPM = "."; // Delimitador de miles

  //Simbolo de la moneda
  const SMONEY = "$";      // Símbolo de pesos colombianos
  const CURRENCY = "COP";  // Moneda para Colombia

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

  //Redes Sociales
  const FACEBOOK = "https://www.facebook.com/share/K5dG67fxCTEWuVs1/?mibextid=qi2Omg";
  const INSTAGRAM = "https://www.instagram.com/bogalleryexplore?igsh=MTgxOTh5OXZxN2p3Mg==";

  //Datos empresa
  const DIRECCION = "Cra 8 N° 10-65,Bogota";
  const TELEMPRESA = "+(057)3112724639";
  const WHATASPP = "+0573112724639";
  const EMAIL_PLANES = "Bogallerygaes.com";
  const EMAIL_SUSCRIPCION = "Bogallerygaes.com";

  // Constante para encriptar 
  const KEY ='bogobogo';
  const METHODENCRIPT = "AES-128-ECB";

  //Envio o valor adiccional
  const COSTOENVIO = 0.19;
    
