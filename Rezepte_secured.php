<?php
require_once('initialisierung.php');
if($_SESSION['logged_in'] == false){ header("Location: Rezepte.php");}
else{$Meldung = 'Sie können nun Rezepte verfassen, '.$_SESSION['Anrede'].' '.$_SESSION['Nachname'].'!.' ;}
$posten = $_SESSION['Posten'];
// FUNKTIONSDEFINITIONEN ----------- REGISTRIEREN -----------------------
// Funktion, die bei Seitenaufruf mit Aktion "registrieren" die als Parameter übergebenen
// Werte als neuen Datensatz in die "kunde"-Tabelle der DB einträgt
function registrieren( $Anrede, $Nachname, $Vorname, $Anschrift, $EMail, $Passwort ) {
	//Deklaration von $Verbindung als "global" eröglicht den Zugriff auf die
	// aus der Initialisierung stammende DB-Verbindung 
	global $Verbindung ;
	// Auswahlabfrage, um festzustellen, ob die als Parameter angegebene E-Mail-Adresse 
	// bereits in der Kunde-Tabelle vorkommt:
	// Aufbau eines Statement-Objektes auf der DB-Verbindung 
	$Abfrage = $Verbindung->stmt_init() ;
	// Festlegen der zugehörigen SQL-Anweisung mit Platzhaltern
	$Abfrage->prepare('
		SELECT * FROM kunde WHERE EMail = ? ;
	') ;
	// Verknüpfung der verwendeten Platzhalter mit entsprechend getypten Variablen
	$Abfrage->bind_param('s', $EMail ) ;
	// Eigentliche Durchfürung der Abfrage
	$Abfrage->execute() ;
	// Anlegen einer Verknüpfung zum Erzielten Abfrage-Ergebnis
	$Ergebnis = $Abfrage->get_result() ;
	//Abbruch der Ausführung, falls ein Datensatz mit der einzutragenden Email
	// bereits vorhanden ist => sollte später Anwender-freundlich durch Meldung ersetzt werden 
	if( $Ergebnis->num_rows > 0 ) die('Mailadresse schon vorhanden!');
	// Vorbereitung und durchfürung der eigentlichen Einfüge-Abfrage, durch die der
	// Datensatz mit den entsprechenden Einfügen erzeugt wird.
	$Abfrage = $Verbindung->stmt_init() ;
	$Abfrage->prepare('
		INSERT INTO kunde ( Anrede, Nachname, Vorname, Anschrift, EMail, Passwort  )
		VALUES ( ?, ?, ?, ?, ?, ? ) ;
	');
	$Abfrage->bind_param('ssssss', $Anrede, $Nachname, $Vorname, $Anschrift, $EMail, $Passwort );
	$Abfrage->execute() ;
	// Abruf der durch die letzte SQL-Anweisung auf der Verbindung erzeugten
	// auto-increment-Schlüsselwertes und Speicherung in der Session-Variable "KundenNR"
	$_SESSION['KundenNr'] = $Verbindung->insert_id ;
}

if( isset($_POST['Aktion']) && $_POST['Aktion'] == 'registrieren' ) {
		if( $_POST['Passwort'] == $_POST['Kontrolle'] ) {
			registrieren( 
				$_POST['Anrede'],
				$_POST['Nachname'],
				$_POST['Vorname'],
				$_POST['Anschrift'],
				$_POST['EMail'],
				$_POST['Passwort']
			) ;
			$Meldung = 'Sie sind nun registriert und können sich einloggen 
							mit der KundenNr. '.$_SESSION['KundenNr'] ;
		} else {
			$Meldung = 'WARNUNG: Kennwort-Kontrolle stimmt nicht. - Nochmal!' ;
		}
	}



// EINLOGGEN ------------------------------------
function einloggen( $KundenNr, $Passwort ) {
	// DB-Verbindung in der Funktion zugänglich machen 
	global $Verbindung ;
	//Aufbau und Durchführung der DB-Abfrage 
	$Abfrage = $Verbindung->stmt_init() ;
	$Abfrage->prepare('
		SELECT * FROM kunde WHERE KundenNr = ? AND Passwort = ? ;
	');
	$Abfrage->bind_param('is', $KundenNr, $Passwort ) ;
	$Abfrage->execute() ;
	$Ergebnis = $Abfrage->get_result() ;
	if( $Ergebnis->num_rows == 0 ) die('KundenNr und Passwort stimmen nicht überein!');
	else {
		$Datensatz = $Ergebnis->fetch_assoc() ;
		$_SESSION['Kunde'] = $Datensatz['KundenNr'] ;
		$_SESSION['Nachname'] = $Datensatz['Nachname'] ;
		$_SESSION['Vorname'] = $Datensatz['Vorname'] ;
		$_SESSION['Anrede'] = $Datensatz['Anrede'] ;
	}
	
}
	if( isset($_POST['Aktion1']) && $_POST['Aktion1'] == 'einloggen' ) {
		einloggen( $_POST['KundenNr'], $_POST['Passwort'] ) ;
		$Meldung = 'Sie sind nun eingeloggt und werden in den geschüzten Bereich weitergeleitet .'; 
		$_SESSION['Meldung'] = $Meldung;
		$_SESSION['logged_in'] = true;
		
		
	
	}
	/*if($_SESSION['logged_in'] == true){
		//header("Location:Rezepte.php");
	}*/
	
	
	function stop(){
		$Meldung = 'Bitte zuerst einloggen!';
		echo('Hallo');
	}





// UPLOAD --------------------------------------
if(isset($_POST['Aktion4'])){
	$Dateiname = 'Keine Datei verfügbar.' ;
		try {
			// Fehler bei fehlender oder fehlerhafter Dateiübertragung:
			if( !isset( $_FILES['Datei']['error'] ) || is_array( $_FILES['Datei']['error'] ) ) {
				throw new RuntimeException('Fehlender Dateiupload') ;
			}
			// Auswertung vorhandener Fehlerzustände
			switch( $_FILES['Datei']['error'] ) {
				case 0 : break ; // Alles OK
				case 1 : 
				case 2 : throw new RuntimeException('Datei zu groß!') ;
				case 3 : throw new RuntimeException('Übertragung unvollständig.') ;
				case 4 : throw new RuntimeException('Keine Datei empfangen.') ;
				case 6 : throw new RuntimeException('Kein temporäres Verzeichnis') ;
				case 7 : throw new RuntimeException('Lokale Speicherung unmöglich.') ;
				case 8 : throw new RuntimeException('Erweiterung unzulässig.') ;
				default: throw new RuntimeException('Unbekannte Störung des Uploads.') ;
			}
			// Maßnahmen zur Kontrolle / Reduktion der Datenmenge
			if( $_FILES['Datei']['size'] > 1000000 ) 
				throw new RuntimeException('Dateigröße grenzwertig');
			// Maßnahmen zur Kontrolle und Absicherung des Dateiformats bzw. MIME-Typs
			$Akzeptiert = array('jpg'=>'image/jpeg', 'gif'=>'image/gif', 'png'=>'image/png') ;
			$Dateiinfo = new finfo( FILEINFO_MIME_TYPE ) ;
			$Erweiterung = array_search( $Dateiinfo->file( $_FILES['Datei']['tmp_name'] ), $Akzeptiert, true ) ;
			if( $Erweiterung === false ) { // MIME-Typ nicht in Akzeptiert
				throw new RuntimeException('Ungültiges Dateiformat.') ;
			} else { // Neuen Dateinamen aus dem alten und der ermittelten Erweiterung generieren
				$Dateiname = explode('.', $_FILES['Datei']['name'] ) ;
				$Dateiname = './img/Rezeptimages/'.$Dateiname[0].'.'.$Erweiterung ;
			}
			if( ! move_uploaded_file( $_FILES['Datei']['tmp_name'], $Dateiname ) ) {
				throw new RuntimeException('Übertragene Datei konnte nicht in das Zielverzeichnis verschoben werden.') ;
			}
		} catch( RuntimeException $Fehler ) {
			echo('FEHLER: '.$Fehler->getMessage() ) ;
		}
}
// -----------------------------------------------



// Function für die Rezeptübersicht --------------



$Link = mysqli_connect('localhost','root','','db_pejo_shop');
mysqli_set_charset($Link, 'utf8');


	
	$RezErs ='SELECT * FROM rezepte, kunde WHERE kunde.KundenNr LIKE rezepte.KundNr';
	$query = mysqli_query($Link,$RezErs);
	//$count = mysqli_num_rows($query);
	//echo($count);
	$ausgabe="";
	while($test = mysqli_fetch_assoc($query)){
				$Name = $test['Anrede'].' '.$test['Nachname'];
				$RezeptName = $test['RezName'];
				$Zutatenliste = $test['Zutaten'];
				$RBeschreibung = $test['RezBeschreibung'];
				$Rezeptbild = $test['RezBild'];
				$PBewertung = $test['PositiveB'];
				$NBewertung = $test['NegativeB'];
	
				$ausgabe.=	'<h1>'.$RezeptName.'</h1>'
							.'<div id="Rezepte" style="background-image: url('.$Rezeptbild.'); display:block; background-size:cover;" >'
							.'<div id="Rezzusammenfassung">'
							.'<p>von '.$Name.'</p>'
							//.'<img src="'.$Rezeptbild.'"/>'
							.'<p> ZUTATEN: <br>'.$Zutatenliste.'</p>'
							.'<p> REZEPTBESCHREIBUNG: <br>'.$RBeschreibung.'</p>'
							.'<form name="Bewert" action="Rezepte.php?rid='.$test['Reznummer'].'" method="post" >'
							.'<p>'.$PBewertung.'</p><input type="submit" name="PB" value="Gefällt mir!" 
							class="blog-nav-item btn btn-default" />'
							.'<p>'.$NBewertung.'</p><input type="submit" name="NB" value="Gefällt mir nicht!" 
							class="blog-nav-item btn btn-default" />'
							.'</form>'
							.'</div>'
							.'</div>';
							
	}
	
	if(isset($_POST['PB'])){	
		$bewert = 'UPDATE rezepte SET PositiveB = PositiveB +1 WHERE Reznummer='.$_GET["rid"];
		$query = mysqli_query($Link,$bewert);
		$Meldung = 'Danke für Ihre Bewertung!';
		header("Location: Rezepte.php"); 
	} 
	else if(isset($_POST['NB'])){
		$bewert = 'UPDATE rezepte SET NegativeB = NegativeB +1 WHERE Reznummer='.$_GET["rid"];
		$query = mysqli_query($Link,$bewert);
		$Meldung = 'Danke für Ihre Bewertung!';
		header("Location: Rezepte.php"); 
	}
				



	






// -----------------------------------------------


//Datenbankeintragungen --------------------------


	


if(isset($_POST['Aktion4'])){
		$Meldung = 'Sie haben erfolgreich ein Rezept verfasst';
		
		$Abfrage = $Verbindung->prepare('
			INSERT INTO rezepte ( KundNr, RezName, Zutaten, RezBeschreibung, RezBild ) 
			VALUES ( ?, ?, ?, ?, ? ) ;
		') ;
		
		$Abfrage->bind_param('issss', $KNr, $Rname, $Rzut, $Rbesch, $Rbild ) ;
		if(!isset($_SESSION['Kunde'])){
			$KNr = '5';
			$Rname = $_POST['Rezeptnam'];
			$Rzut = $_POST['Rezeptzut'];
			$Rbesch = $_POST['Rezeptbesch'];
			$Rbild = $Dateiname;
		} else{
			$Rname = $_POST['Rezeptnam'];
			$Rzut = $_POST['Rezeptzut'];
			$Rbesch = $_POST['Rezeptbesch'];
			$Rbild = $Dateiname;
			$KNr = $_SESSION['Kunde'];
		}
		
		//FUNKTIONIERT NICHT!! --------------------------------
		// Bilnamen-Überprüfung und EXECUTE für den Datenbank-Eintrag
		$Bildnamen ='SELECT RezBild FROM rezepte';
		$query2 = mysqli_query($Link,$Bildnamen);
		while($test = mysqli_fetch_assoc($query2)){
			$Bildverlinkung = $test['RezBild'];
			if($Bildverlinkung == $Bildnamen){
				$Dateiname = $Dateiname.'2';
				$Abfrage->execute() ;
			} 
			else{
				$Abfrage->execute() ;
			}
		}
		
}

if( $Verbindung->error ) { // Falls eine Fehlermeldung existiert
	die('Verbindungsfehler: '.$Verbindung->error ) ;
}




// -----------------------------------------------



?>






<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Rezepte</title>
<link rel="stylesheet" type="text/css" href="css/pejo_style.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>

                        
<!-- Registrierung Pop-Up-Fenster -->
                        <div id="myModal2" class="modal fade register" role="dialog">
                            <div class="modal-dialog">

                        <!-- Registrierung content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h2 class="modal-title">Wir über uns</h2>
                                    </div>
                                    <div class="modal-body">
                                    <?php echo(ueberuns());?>
                                    </div>
                                   <div class="modal-footer">
                                      <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                   </div>
                                </div>
                            </div>
                        </div>
                        
                      
                                        
                        <!-- Rezept eintragen -->
                        <div id="myModal5" class="modal fade register" role="dialog">
                            <div class="modal-dialog">

                        <!-- Rezept Formularcontent-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h2 class="modal-title">Rezept eintragen</h2>
                                    </div>
                                    <div class="modal-body">
                                    <form name="RezeptForm" action="Rezepte.php" method="post" enctype="multipart/form-data">
                                        Der Name des Rezepts<input type="text" name="Rezeptnam" placeholder="Name" 
                                        max="15" class="btn btn-default btn-sm"/><br><br>
                                        Die Zutaten<textarea name="Rezeptzut" placeholder="Die Zutaten" 
                                        class="btn btn-default btn-sm" cols="75" rows="7"
                                        max="120"></textarea><br><br>
                                        Die Rezeptbeschreibung<textarea name="Rezeptbesch" 
                                        placeholder="Rezeptdurchlauf in kurzen Schritten erklärt" max="150" 
                                        class="btn btn-default btn-sm" cols="75" rows="7"></textarea>
                                        <br><br>                                                   
                                        Bitte wählen Sie ein Bild des fertigen Gerichts in einem der folgenden Dateiformate
                                        ".jpg", ".gif" oder ".png":
                                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                                        <input type="file" name="Datei" value="Datei" class="blog-nav-item 
                                        btn btn-default btn-sm" />
                                        <input type="submit" name="Aktion4" value="hochladen" class="blog-nav-item btn btn-default"/>
                                        <br><br><br>
                                    </form>
                                    <figure>
                                        <figcaption><?php if(isset($_POST['Aktion5'])){ echo( $Dateiname ) ; } ?>
                                        </figcaption>
                                    </figure>

                                    </div>
                                   <div class="modal-footer">
                                      <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                   </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Warenkorb - Pop-Up-Fenster -->
                                        <div id="myModal3" class="modal fade register" role="dialog">
                                            <div class="modal-dialog">
                
                                        <!-- Warenkorb content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      <h2 class="modal-title">Warenkorb</h2>
                                                    </div>
                                                    <div class="modal-body">
													<div class="table-responsive">
													<?php echo(wk_zeigen());?>
                                                    </div>
                                                    </div>
                                                   <div class="modal-footer">
                                                      <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                   </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                         <!-- Kontakt und Impressum - Pop-Up-Fenster -->
                                        <div id="myModal8" class="modal fade register" role="dialog">
                                            <div class="modal-dialog">
                
                                        <!-- Kontakt und Impressum content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      <h2 class="modal-title">Kontakt und Impressum</h2>
                                                    </div>
                                                    <div class="modal-body">
													<div class="table-responsive">
													<?php echo(kontakt());?>
                                                    </div>
                                                    </div>
                                                   <div class="modal-footer">
                                                      <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                   </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Kontakt und Impressum - Pop-Up-Fenster -->
                                        <div id="myModal9" class="modal fade register" role="dialog">
                                            <div class="modal-dialog">
                
                                        <!-- Kontakt und Impressum content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      <h2 class="modal-title">Datenschutz</h2>
                                                    </div>
                                                    <div class="modal-body">
													<div class="table-responsive">
													<?php echo(datenschutz());?>
                                                    </div>
                                                    </div>
                                                   <div class="modal-footer">
                                                      <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                   </div>
                                                </div>
                                            </div>
                                        </div>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Pejo Falaffel</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/pejo_style.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

</head>
<body>
<div class="wrapper container">
	<!-- Header -->
	<div class="blog-masthead container-fluid">
				<div class="siegel row">
                    <div class="col-md-4 col-xs-2 col-sm-6 col-lg-3 col-xl-6 col-md-offset-4 col-xs-offset-5 col-sm-offset-3 col-lg-offset-0 col-xl-offset-0">
                        <div><a href="index_secured.php"><img class="img-responsive img img-circle col-md-4 col-lg-4 col-xs-4 col-sm-4 col-xl-4" src="./img/logo.jpg"></a></div>
                        <div><img src="./img/siegel2.jpg" class="img img-circle img-responsive col-md-4 col-lg-4 col-xs-4 col-sm-4 col-xl-4" alt="Placeholder image"></div>
                        <div><img src="./img/siegel1.jpg" class="img img-circle img-responsive col-md-4 col-lg-4 col-xs-4 col-sm-4 col-xl-4" alt="Placeholder image"></div>
					</div>
                    <div class="col-md-8 col-xs-2 col-sm-10 col-lg-8 col-xl-6 col-md-offset-2 col-xs-offset-5 col-sm-offset-1 col-lg-offset-0 col-xl-offset-0 text-center">
                       <nav class="blog-nav topnav">
                           <nav class="blog-nav ">
                                    <a href="logout.php" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-log-out"></span> Log Out</a>
                                    <button id="WK" type="button" data-toggle="modal" data-target="#myModal3" class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> Warenkorb (<?php if(isset($posten))echo( $posten ) ; ?>)
                                    </button>         
                           </nav>
                      </nav>
                    </div>
                    
                </div>
                
                
              	<div class="row">
                    <nav class="col-md-12 col-xs-2 col-sm-4 col-lg-8 col-xl-10 col-md-offset-0 col-xs-offset-5 col-sm-offset-4 col-lg-offset-2 col-xl-offset-1 text-center">
                        <p><?php if( isset($Meldung) ) echo( $Meldung ) ; ?></p>
                    </nav>
                </div>
                <div class="row text-center">
                	<div class="col-md-8 col-xs-2 col-sm-10 col-lg-8 col-xl-10 col-md-offset-2 col-xs-offset-5 col-sm-offset-1 col-lg-offset-2 col-xl-offset-1 text-center">
                        <nav class="blog-nav">
                                        <fieldset>
                                            <a href="index_secured.php" class="blog-nav-item btn btn-default btn-sm">Home</a>
                                            <a href="produkte_secured.php" class="blog-nav-item btn btn-default btn-sm">Produkte 
                                            </a>
                                            <a href="#" data-toggle="modal" data-target="#myModal2" class="blog-nav-item  btn btn-default
                                            btn-sm">Wir über uns</a>
                                            <a href="Rezepte_secured.php" class="blog-nav-item btn btn-default btn-sm">Rezepte</a>
                                            <a href="#" data-toggle="modal" data-target="#myModal8" class="blog-nav-item  btn btn-default
                                            btn-sm">
                                                <span class="glyphicon"></span> Kontakt und Impressum 
                                            </a>
                                       </fieldset>
                        </nav>
              		</div>
                </div>
    </div>
<div class="container-fluid main"> 
       			<div class="row ">
					<div class="text-center col-md-12 col-xs-2 col-sm-12 col-lg-12 col-xl-10 col-md-offset-0 col-xs-offset-5 col-sm-offset-0 col-lg-offset-0 col-xl-offset-1 blog-main">
                        <section>
                        <p class="lead ">Sie suchen vegane Rezepte mit Falafel, Hummus und mehr? Hier finden Sie alles was Sie begehren!
                        Viele der Zutaten finden sie auch in unserem <a href="produkte_secured.php">Shop</a>. 
                        <br>
                        </p>
                        	<button type="button" data-toggle="modal" data-target="#myModal5" name="Aktion1" value=
                            "Rezepteintrag" class="btn btn-default btn-sm col-md-4 col-md-offset-4">
                            <span class="glyphicon"></span> Rezept verfassen 
                        	</button>
                        </section>
                    </div>                        
                </div>
                <div class="row">
                <div class="text-center col-md-12 col-xs-2 col-sm-12 col-lg-12 col-xl-10 col-md-offset-0 col-xs-offset-5 col-sm-offset-
                0 col-lg-offset-0 col-xl-offset-1 blog-main">
                <?php
                echo $ausgabe; 
				?>
              
                </div>
                </div>
 <!--Main-Content-->
                           <div class="row">
                                    <div class="blog-sidebar  text-center col-md-12 col-xs-2 col-sm-12 col-lg-12 col-xl-12 col-md-offset-0 col-xs-offset-5 col-sm-offset-0 col-lg-offset-0 col-xl-offset-1">
                                        <section >
                                          <strong>Hossam Ekkawi & Joachim Winkler</strong><br>
                                                  Nierlochstraße 2<br>
                                                  D-72379 Hechingen<br>
                                          <abbr title="Telefonnummer">Tel.:</abbr> +49 7471 - 871 931
                                          <abbr title="Fax">Fax.:</abbr> +49 7471 - 871 910 <br>
                                          <h3>Peijo GbR</h3>
                                          <a href="index.php"><img class="img-responsive img img-rounded center-block" src="./img/logo.jpg"></a>
                                         
                                        </section>
                                        
                                        <br>
                                        <a href="#" data-toggle="modal" data-target="#myModal9" class="blog-nav-item  btn btn-default
                                            btn-sm">
                                                <span class="glyphicon"></span> Datenschutz 
                                            </a>
                                	</div>		
		 </div>
                            
</div>

<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>
</body>
</html>






<!-- Datenschutzerklärung

Geltungsbereich

Diese Datenschutzerklärung klärt Nutzer über die Art, den Umfang und Zwecke der Erhebung und Verwendung personenbezogener Daten durch den verantwortlichen Anbieter [HIER BITTE IHREN NAMEN, ADRESSE, EMAIL UND TELEFONNUMMER EINTRAGEN] auf dieser Website (im folgenden “Angebot”) auf.

Die rechtlichen Grundlagen des Datenschutzes finden sich im Bundesdatenschutzgesetz (BDSG) und dem Telemediengesetz (TMG).

Zugriffsdaten/ Server-Logfiles

Der Anbieter (beziehungsweise sein Webspace-Provider) erhebt Daten über jeden Zugriff auf das Angebot (so genannte Serverlogfiles). Zu den Zugriffsdaten gehören:

Name der abgerufenen Webseite, Datei, Datum und Uhrzeit des Abrufs, übertragene Datenmenge, Meldung über erfolgreichen Abruf, Browsertyp nebst Version, das Betriebssystem des Nutzers, Referrer URL (die zuvor besuchte Seite), IP-Adresse und der anfragende Provider.

Der Anbieter verwendet die Protokolldaten nur für statistische Auswertungen zum Zweck des Betriebs, der Sicherheit und der Optimierung des Angebotes. Der Anbieterbehält sich jedoch vor, die Protokolldaten nachträglich zu überprüfen, wenn aufgrund konkreter Anhaltspunkte der berechtigte Verdacht einer rechtswidrigen Nutzung besteht.

Umgang mit personenbezogenen Daten

Personenbezogene Daten sind Informationen, mit deren Hilfe eine Person bestimmbar ist, also Angaben, die zurück zu einer Person verfolgt werden können. Dazu gehören der Name, die Emailadresse oder die Telefonnummer. Aber auch Daten über Vorlieben, Hobbies, Mitgliedschaften oder welche Webseiten von jemandem angesehen wurden zählen zu personenbezogenen Daten.

Personenbezogene Daten werden von dem Anbieter nur dann erhoben, genutzt und weiter gegeben, wenn dies gesetzlich erlaubt ist oder die Nutzer in die Datenerhebung einwilligen.

Kontaktaufnahme

Bei der Kontaktaufnahme mit dem Anbieter (zum Beispiel per Kontaktformular oder E-Mail) werden die Angaben des Nutzers zwecks Bearbeitung der Anfrage sowie für den Fall, dass Anschlussfragen entstehen, gespeichert.

Kommentare und Beiträge

Wenn Nutzer Kommentare im Blog oder sonstige Beiträge hinterlassen, werden ihre IP-Adressen gespeichert. Das erfolgt zur Sicherheit des Anbieters, falls jemand in Kommentaren und Beiträgen widerrechtliche Inhalte schreibt (Beleidigungen, verbotene politische Propaganda, etc.). In diesem Fall kann der Anbieter selbst für den Kommentar oder Beitrag belangt werden und ist daher an der Identität des Verfassers interessiert.

Registrierfunktion

Die im Rahmen der Registrierung eingegebenen Daten werden für die Zwecke der Nutzung des Angebotes verwendet. Die Nutzer können über angebots- oder registrierungsrelevante Informationen, wie Änderungen des Angebotsumfangs oder technische Umstände per E-Mail informiert werden. Die erhobenen Daten sind aus der Eingabemaske im Rahmen der Registrierung ersichtlich. Dazu gehören [HIER BITTE DIE ERHOBENEN DATEN EINGEBEN, Z.B. NAME, POSTALISCHE ADRESSE, E-MAIL-ADRESSE, IP-ADRESSE UND DEREN ZWECK, ZUM BEISPIEL COMMUNITY ODER PRODUKTESTS].

Widerruf, Änderungen, Berichtigungen und Aktualisierungen

Der Nutzer hat das Recht, auf Antrag unentgeltlich Auskunft zu erhalten über die personenbezogenen Daten, die über ihn gespeichert wurden. Zusätzlich hat der Nutzer das Recht auf Berichtigung unrichtiger Daten, Sperrung und Löschung seiner personenbezogenen Daten, soweit dem keine gesetzliche Aufbewahrungspflicht entgegensteht.
Datenschutz-Muster von Rechtsanwalt Thomas Schwenke - I LAW it -->