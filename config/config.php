<?php
/***************************************
 * Fichier de config de l'application
 ***************************************/

/*----------
 * Allocine
 -----------*/

/// Code allociné associé au cinéma
define("ALLOCINE_CINEMA_CODE", "W0419");

/// Code postal du cinéma
define("ALLOCINE_CINEMA_POSTCODE", "35130");



/// Nombre de jour après la selection de la date sur laquelle on va requêter le site allocine
define("ALLOCINE_NB_DAY_REQUEST",10);

/*----------
 * Session
 -----------*/

/// Clé de session sous laquelle seront enregistré tout les 
define("SESSION_KEY", "LE_BRETAGNE_NEWSLETTER");

/*
 * Envoi de la newsletter
 * 
 */
///Adresse d'envoie
define("NEWSLETTER_SEND_EMAIL_SENDER", "guerchecine@free.fr");

/*
 * Config des pages 
 */

///Nombre de newsletters affiché dans le menu
define("PAGE_ADMIN_NEWSLETTERS_NB_DISPLAY", 10);

?>