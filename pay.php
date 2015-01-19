<?php 
	//initialisation du code qr
	include "php/qrlib.php";    
    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'QRTemp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'QRTemp/';  
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'camrailQRCode.png';
            
    // user data
    $filename = $PNG_TEMP_DIR.'camrailQRCode'.md5($_COOKIE["__code__"].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    QRcode::png("http://localhost/camrail/a.php?qr=".base64_encode($_COOKIE["__code__"]), $filename, 'H', '6', 2); 
?>  
                                                                                                                                                                <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="shortcut icon" href="img/icon.ico">
	<title></title>
	<link rel="stylesheet" href="css/jquery.mobile.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.mobile.min.js"></script>
	<script src="js/script.js"></script>
	<script src="js/datepicker.js"></script>
  <script src="js/datepicker-fr.js"></script>
  <script src="js/jquery.cookie.js"></script>
</head>
<body>

<div data-role="page" data-theme="b" id="terminer">
	<div data-role="header" data-position="fixed" data-theme="a">
		<a href="merci.php" rel="external" data-transition="slide" data-direction="reverse" class="ui-btn-left ui-btn ui-btn-b ui-btn-inline ui-mini ui-corner-all ui-icon-carat-l ui-btn-icon-left" id="annuler">Annuler</a>
		<h1>Itrain</h1>
    	<a href="#info" data-rel="popup" data-position-to="window" data-transition="pop" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-info">Info</a>
	</div>

	<div data-role="popup" id="info" data-theme="a" data-overlay-theme="b" class="ui-content" style="max-width:340px; padding-bottom:2em;">
    <h4 style="text-align:center;">Infos | Paiement</h4>
    <h2 style="text-align:center;">
      <img src="img/pay.png" alt="" width="" height="">
    </h2>
    <p>En payant maintenant, vous pouvez directement retirer votre billet dans n'importe qu'elle agence camrail dans le Cameroun.</p>
    <div style="text-align:center;">
      <a href="#" data-rel="back" class="ui-shadow ui-btn-b ui-mini ui-btn ui-corner-all ui-btn-inline ui-mini">Fermer</a>
    </div>
  </div>

	<div data-role="content">
	<div style="text-align:center;">
	</div>
	<ul data-role="listview" data-split-icon="info" data-inset="true" data-filter="false" data-filter-placeholder="Trouver rapidement une ville">
     <li>
      <a href="#" data-transition="slide" class="choix_voyage" title="aller">
       <img src="img/mtn.jpg" alt="" width="150" height="100">
        <h1>MTN Mobile Money</h1>
        <p>MTN Cameroon</p>
      </a>
      <a href="#mtn" data-rel="popup" data-position-to="window" data-transition="pop">Informations</a>
     </li>
     <li data-role="list-divider"></li>
     <li>
      <a href="#" data-transition="slide" class="choix_voyage" title="aller_retour">
      <img src="img/orange.jpg" alt="" width="100" height="110">
       <h1>Orange Money</h1>
       <p>Orange Cameroun</p>
      </a>
      <a href="#orange" data-rel="popup" data-position-to="window" data-transition="pop">Informations</a>
     </li>
     <li data-role="list-divider"></li>
     <li>
      <a href="#" data-transition="slide" class="choix_voyage" title="aller_retour">
      <img src="img/pay_64.png" alt="" width="100" height="110">
       <h1>VISA CARD</h1>
       <p>Payer avec VISA CARD</p>
      </a>
      <a href="#orange" data-rel="popup" data-position-to="window" data-transition="pop">Informations</a>
     </li>
     <li data-role="list-divider"></li>
     <li>
      <a href="#" data-transition="slide" class="choix_voyage" title="aller_retour">
      <img src="img/pay_64.png" alt="" width="100" height="110">
       <h1>MASTER CARD</h1>
       <p>Payer avec MASTER CARD</p>
      </a>
      <a href="#orange" data-rel="popup" data-position-to="window" data-transition="pop">Informations</a>
     </li>
    </ul>
	<div style="text-align:center;">
	<p style="font-size:10px;">Identifier en tant que</p>
		<div><?php echo $_COOKIE["nom_client"]." ".$_COOKIE["prenom_client"]; ?></div>
		<div style="font-size:10px;">Code : <?php echo $_COOKIE["__code__"]; ?></div>
	</div>
	</div>
	<div data-role="footer" data-position="fixed" data-theme="b">
		<div style="text-align:center;">
			<a href="index.html" rel="external" data-transition="slide" data-prefetch class="ui-btn ui-btn-b ui-btn-inline ui-corner-all ui-mini ui-btn-active" id="hide_qr_code">Revenir à l'acceuil</a>
		</div>
	</div>

	<div data-role="popup" id="mtn" data-theme="a" data-overlay-theme="b" class="ui-content" style="max-width:340px; padding-bottom:2em;">
      <h4 style="text-align:center;">Infos | MTN Mobile Money</h4>
      <h2 style="text-align:center;">
        <img src="img/pay.png" alt="" width="" height="">
      </h2>
      <p>MTN Mobile money est une plateforme de paiement via telephone, le telephone est votre porte. ce service est disponible aux abonnes MTN Cameroon.</p>
      <div style="text-align:center;">
        <a href="#" data-rel="back" class="ui-shadow ui-btn-b ui-mini ui-btn ui-corner-all ui-btn-inline ui-mini">Fermer</a>
      </div>
    </div>

    <div data-role="popup" id="orange" data-theme="a" data-overlay-theme="b" class="ui-content" style="max-width:340px; padding-bottom:2em;">
      <h4 style="text-align:center;">Infos | Orange Money</h4>
      <h2 style="text-align:center;">
        <img src="img/pay.png" alt="" width="" height="">
      </h2>
      <p>Orange money est une plateforme de paiement via telephone, le telephone est votre porte. ce service est disponible aux abonnes Orange Cameroun.</p>
      <div style="text-align:center;">
        <a href="#" data-rel="back" class="ui-shadow ui-btn-b ui-mini ui-btn ui-corner-all ui-btn-inline ui-mini">Fermer</a>
      </div>
    </div>

</div>
</body>
</html>
                            
                            
                            
                            
                            
