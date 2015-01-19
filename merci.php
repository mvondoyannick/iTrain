<?php 	
    include "php/qrlib.php";    
    include "init.php";

    //fonction pour la gestion du numero de siege
    function num_siege(){
      //calcule le umero de siege
      $place = $_COOKIE["place"];  //par exemple 154
      $classeTMP = $_COOKIE["classeTMP"];  // par exemple economique

      //on par chercher le nombre maximum de place pour une classe
      $r = "SELECT * FROM tb_place WHERE classe = '".$classeTMP."' ";
      $q = mysql_query($r) or die("Impossible d avoir la classe : ".mysql_error());
      $data = mysql_fetch_array($q);

      //on calcule la place
      $place = ($data['placeTotal'] - $place);  //+1 pour equilibrer
      return $place;

    }
    /*-----------------------------------------fin fonction------------------------------------*/

    //petite requete pour demander le numero de siege
    $sql = "SELECT * FROM tb_client WHERE codeTicket = '".$_COOKIE["__code__"]."' ";
    $query = mysql_query($sql) or die("Une erreur est survenur, contacter le service technique : ".mysql_error());
    $result = mysql_fetch_array($query);

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


	//les sessions sont enregistrés et sont valables sur toutes les pages aussi bien php que js

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
  <link rel="stylesheet" type="text/css" href="css/sweet-alert.css">
  <link rel="stylesheet" type="text/css" href="css/all.css">

	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.mobile.min.js"></script>
	<script src="js/script.js"></script>
  <script src="js/jquery.cookie.js"></script>
  <script src="js/sweet-alert.min.js"></script>

  <script type="text/javascript">
	//fonction qui empeche le retour de la page en arriere
		function noBack(){
			window.history.forward()
		}
		noBack();
		window.onload=noBack;
		window.onpageshow=function(evt){
			if(evt.persisted)
				noBack()
		}
		window.onunload=function(){
			void(0)
		}
	</script> 

</head>
<body>

<div data-role="page" data-theme="b" id="terminer">
	<div data-role="header" data-position="fixed" data-theme="a">
		<a href="#nav-panel" data-rel="popup" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-bars ui-btn-icon-left ui-btn-b" data-transition="pop">Options</a>
		<h1>Itrain</h1>
    	<a href="decouverte.html" rel="external" data-transition="slide" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-icon-shop ui-btn-icon-right ui-mini ui-corner-all">Découvrir</a>
	</div>

	<div data-role="panel" data-position-fixed="true" data-display="overlay" data-theme="b" id="nav-panel">
        <ul data-role="listview" data-divider-theme="b">
            <li data-icon="power"><a href="#" data-rel="close" data-theme="a">Fermer</a></li>
            <li data-role="list-divider" style="background: none transparent; border-color: transparent;">&nbsp;</li>
            <li data-role="list-divider" style="background: none transparent; border-color: transparent;">&nbsp;</li>
            <li><a href="#qr-panel" data-rel="popup" data-split-icon="info" data-position-to="window" data-transition="pop">Code QR</a></li>
            <li data-icon="info"><a href="#quoi-panel" data-rel="popup" data-position-to="window">Qu'est ce que c'est?</a></li>
            <li><a href="#">Comment l'utiliser</a></li>
            <li><a href="#">Infos pour ce voyage</a></li>
            <li data-icon="location"><a href="carte.html" rel="external">Ou est mon train?</a></li>
            <li data-role="list-divider" style="background: none transparent; border-color: transparent;">&nbsp;</li>
            <li data-icon="refresh"><a href="merci.php?action=refresh" rel="external">Actualiser</a></li>
        </ul>
    </div><!-- /panel -->

    <div data-role="panel" data-position-fixed="true" data-display="overlay" data-theme="b" id="qr-panel">
        <ul data-role="listview" data-divider-theme="b">
            <li data-icon="power"><a href="#" data-rel="close" data-theme="a">Fermer | Code QR</a></li>
            <li data-role="list-divider" style="background: none transparent; border-color: transparent;">&nbsp;</li>
            <li data-role="list-divider" style="background: none transparent; border-color: transparent;">&nbsp;</li>
            <li data-icon="info">
              <a href="#">
                Enregistrer
                <p>Dans mon terminal</p>
              </a>
              
            </li>
            <li data-icon="info">
              <a href="#">
                Imprimer
                <p>Via une imprimante sans fil</p>
              </a>
            </li>
            <div data-role="collapsible">
              <h2>Afficher en plein ecran</h2>
              <p style="text-align:center;">
                Faites scanner ce code par nos agents.
                <?php echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" alt="" width="200" height="200" />'; ?>
              </p>
            </div>
            <li data-role="list-divider" style="background: none transparent; border-color: transparent;">&nbsp;</li>
            <li data-icon="carat-l"><a href="#nav-panel" data-rel="popup" data-split-icon="info" data-position-to="window" data-transition="pop">Retour</a></li>
        </ul>
    </div><!-- /panel -->


    <div data-role="panel" data-position-fixed="true" data-display="overlay" data-theme="b" id="quoi-panel">
        <ul data-role="listview" data-divider-theme="b">
            <li data-icon="power"><a href="#" data-rel="close" data-theme="a">Fermer | C'est quoi</a></li>
            <li data-role="list-divider" style="background: none transparent; border-color: transparent;">&nbsp;</li>
            <p>
              <strong>Qu'est ce que c'est?</strong>
              <hr>
              <p style="text-align:center;">
                <?php echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" alt="" width="40" height="40" />'; ?><br>
              </p>
              Ceci est un <strong>code QR</strong>, il permet de stocker toutes vos information de voyage, c'est un ticket numerique
              il vous suffit juste de le presenter à l'agence ou devant un scanner pour imprimer votre ticket et avoir acces
              au train. 
              <br>
              <p style="text-align:center;">
                <strong><?php echo $_COOKIE["__code__"]; ?></strong>
              </p>
              Le code qui est en dessous peut aussi service pour la même operation que le code QR.
            </p>
            <li data-role="list-divider" style="background: none transparent; border-color: transparent;">&nbsp;</li>
            <li data-icon="carat-l"><a href="#nav-panel" data-rel="popup" data-split-icon="info" data-position-to="window" data-transition="pop">Retour</a></li>
        </ul>
    </div><!-- /panel -->

	<div data-role="content">
	<div style="text-align:center;">
		<h4> <?php echo strtoupper($_COOKIE["nom_client"])." ".$_COOKIE["prenom_client"]; ?> </h4>
		<div>
			<?php echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" alt="" width="250" height="250" />'; ?>
	  </div>
  </div>
	<div style="font-size:50px; text-align:center;" id="codeTicket">
		<?php echo $_COOKIE["__code__"]; ?>
    <br>
  </div>
  <hr>
  <div>
    <table width="100%">
        <tr>
          <td>Nom du train</td>
          <td style="text-align:right;">
            <strong>
              Inter-city
            </strong>
          </td>
        </tr>
        <tr>
          <td>Numero wagon</td>
          <td style="text-align:right;">
          <strong>
            <?php 
              $r = "SELECT * FROM tb_place, tb_voiture WHERE classe = '".$result['classe']."' AND tb_place.id = tb_voiture.id_place";
              //$r = "SELECT * FROM tb_place, tb_voiture WHERE classe = '".$result['classe']."' ";
              $q = mysql_query($r) or die("Impossible de terminer : ".mysql_error());
              $data = mysql_fetch_array($q);
              echo '<a href="#" id="wagon">'.$data['id_voiture'].'</a>';
            ?>
          </strong>
          </td>
        </tr>
        <tr>
          <td>Numero siège</td>
          <td style="text-align:right;"><strong>
            <?php 
              //on recupere la place par appel de fonction
              $end = num_siege();
              echo $end;
            ?>
          </strong></td>
        </tr>
        <tr>
          <td>Classe</td>
          <td style="text-align:right;"><strong><?php echo $result['classe']; ?></strong></td>
        </tr>
        <tr>
          <td>Date départ</td>
          <td style="text-align:right;"><strong>
          <?php
            if ($result['date_reservation'] == "Aucune reservation") {
               # code...
              echo $result['date'];
             }
             else{
              //cas contraire
              echo $result['date_reservation'];
             }
          ?>
          </strong></td>
        </tr>
        <tr>
          <td>Départ / Arrivée</td>
          <td style="text-align:right;"><strong><?php echo $result['villeDepart']."/".$result['villeArrivee']; ?></strong></td>
        </tr>
      </table>
    </div>
  </div>

  <div data-role="popup" id="popupArrow" data-theme="a" data-transition="flow">
    <p style="text-align:center;">
      <?php echo strtoupper($_COOKIE["nom_client"])." ".$_COOKIE["prenom_client"]; ?>
    </p>
    <p>Le <strong>code</strong> derriere cette fenetre est votre identifiant, il vous donne access à bord du train et represente votre pièce justificative</p>
    <p style="text-align:center;">
      <a href="#" data-rel="back" class="ui-btn ui-btn-inline ui-btn-b ui-shadow ui-corner-all ui-mini" id="jaiCompris">J'ai compris</a>
    </p>
  </div>

  <div data-role="popup" id="GTKInfoWagon" data-theme="a" data-transition="flow">
    <p style="text-align:center;">
      Info sur le 
      <strong>
      <?php 
        $r = "SELECT * FROM tb_place, tb_voiture WHERE classe = '".$result['classe']."' AND tb_place.id = tb_voiture.id_place";
        //$r = "SELECT * FROM tb_place, tb_voiture WHERE nom = '".$result['classe']."' ";
        $q = mysql_query($r) or die("Impossible de terminer : ".mysql_error());
        $data = mysql_fetch_array($q);
        echo $data['id_voiture'];
      ?>
      </strong>
    </p>
    <p>
      <?php
        //on recupere les informations sur ce wagon
        $r1 = "SELECT * FROM tb_place, tb_voiture WHERE classe = '".$result['classe']."' AND tb_place.id = tb_voiture.id_place";
        //$r = "SELECT * FROM tb_place, tb_voiture WHERE nom = '".$result['classe']."' ";
        $q1 = mysql_query($r) or die("Impossible de terminer : ".mysql_error());
        $data1 = mysql_fetch_array($q1);
      ?>
      <table width="100%" border="0">
        <tr>
          <td>Num châssis</td>
          <td style="text-align:right;">
            <strong>
              <?php echo $data1['num_chassis']; ?></td>
            </strong>
        </tr>
        <tr>
          <td>Identification</td>
          <td style="text-align:right;">
            <strong>
              <?php echo $data1['id_voiture']; ?></td>
            </strong>
        </tr>
        <tr>
          <td>Classe de type</td>
          <td style="text-align:right;">
            <strong>
              <?php echo strtoupper($data1['classe']); ?></td>
            </strong>
        </tr>
        <tr>
          <td>Nombre de place total</td>
          <td style="text-align:right;">
            <strong>
              <?php echo $data1['placeTotal']; ?></td>
            </strong>
        </tr> 
      </table>
    </p>
    <p style="text-align:center;">
      <a href="#" data-rel="back" class="ui-btn ui-btn-inline ui-btn-b ui-shadow ui-corner-all ui-mini" id="jaiCompris">OK</a>
    </p>
  </div>

  <div data-role="popup" id="GTKInfoDepartTrain" data-theme="a" data-transition="flow">
    <p style="text-align:center;">
      <?php echo strtoupper($_COOKIE["nom_client"])." ".$_COOKIE["prenom_client"]; ?>
    </p>
    <p>Souhaitez vous etre notifier <strong>01 heures</strong> puis <strong>30 minutes</strong> avant le déoart du train?</p>
    <p style="text-align:center;">
      <a href="#" data-rel="back" class="ui-btn ui-btn-inline ui-btn-b ui-shadow ui-corner-all ui-mini" id="jaiCompris">OUI</a>
      <a href="#" data-rel="back" class="ui-btn ui-btn-inline ui-btn-b ui-shadow ui-corner-all ui-mini" id="jaiCompris">NON, pas la peine</a>
    </p>
  </div>

	<div data-role="footer" data-position="fixed" data-theme="b">
		<div style="text-align:center;">
			<a href="pay.php" data-transition="slide" class="ui-btn ui-btn-b ui-btn-inline ui-corner-all ui-mini ui-btn-active">Je paye mon voyage maintenant</a>
		</div> 	
	</div>
</div>
			
<script>
    $(document).on("swiperight", function(event, ui){
      $("#nav-panel").panel("open", {display: 'overlay', position: 'left'});
    });

		//quand on affiche la page #form, on informe le visiteur
      $(document).one('pageshow', '#terminer', function(e){
        e.preventDefault();
        $("#popupArrow").popup("open");
      })

      //quand on click sur le numero de wagon dans le but d' avoir des information complementaires
      $(document).on('click', '#wagon', function(){
        //swal("Bien");
        $("#GTKInfoWagon").popup("open");
      })
  </script>
</body>
</html>
                            
                            
                            
                            
                            
