<?php

define('SERVIDOR', 'localhost');
define('USUARIO', 'root');
define('PASS', '');
define('BASE_DATOS', 'agenda_recuperacion');



// constante con el dominio de mi proyecto
define("BASE_URL", "https://localhost/php/mvc/agenda_mvc/");

// defino el controlador por defecto y el método por defecto que tengo
const CONTROLLER_DEFAULT = "Controllers\ContactoController";
const ACTION_DEFAULT = "index_prepare";

// estas constantes se usarán cuando hagamos llamadas a imágenes en las vistas
// o a URLs del proyecto en las vistas


// define: permite hacer cambios dinámicos, en el de config usar define aunque es indistinto
//const: así es como hay que definir las constantes en las clases