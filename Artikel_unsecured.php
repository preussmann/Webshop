<?php
	require_once('initialisierung.php');
	if( isset( $_GET['ArtNr']) && is_numeric( $_GET['ArtNr'] ) ) {
		$Abfrage = $Verbindung->stmt_init() ;
		$Abfrage->prepare('
			SELECT * FROM artikel WHERE ArtikelNr = ? ;
		') ;
		$Abfrage->bind_param('i', $ArtNr ) ;
		$ArtNr = (int) $_GET['ArtNr'] ;
		$Abfrage->execute() ;
		$Ergebnis = $Abfrage->get_result() ;
		if( $Ergebnis->num_rows > 0 ) {
			$Datensatz = $Ergebnis->fetch_assoc() ;
		} else {
//			header('location: produkte_secured.php');
			die('Artikelnummer nicht vorhanden!');
		}
	} else {
//		header('location: sortiment_1.php');
		die('Keine Artikelnummer angegeben!');
	}
	function zeigeArtikel( $Datensatz ) {
		$Pos = wk_finden( $Datensatz['ArtikelNr'] ) ;
		if( $Pos >= 0 ) $Menge = $_SESSION['Warenkorb'][$Pos]->Mng ;
		else $Menge = 1 ;
		$Ausgabe = '<article>' ;
		$Ausgabe .='<div class="col-md-6">';
		$Ausgabe .='<img src="'.$Datensatz['Image'].'" class="img-fluid produkt" alt="Responsive image">';
		$Ausgabe .='</div>';
		$Ausgabe .='<div class="col-md-6">';
		$Ausgabe .='<h1>'.$Datensatz['Bezeichnung'].'</h1>' ;
		$Ausgabe .='<section class="Beschreibung"><h2>Beschreibung</h2><p>'.$Datensatz['Beschreibung'].'</p></section>' ;
		$Ausgabe .='</div>';
		$Ausgabe .='<section class="Zutaten"><h1>Zutaten:</h1><p>'.$Datensatz['Zutaten'].'</p></section>' ;
		$Ausgabe .='<div class="col-md-6">';
		$Ausgabe .='<section class="Preis"><h1>Preis</h1><p>'.$Datensatz['Preis'].' €</p></section>' ;
		$Ausgabe .='
			<form name="Eintragung" action="bestellung.php" method="get">
				<input type="hidden" name="ArtNr" value="'.$Datensatz['ArtikelNr'].'"/>
				
				  <p> Bitte einloggen, um einkaufen zu können. </p>
			</form>
		' ;
		$Ausgabe .='</div>';
		$Ausgabe .='</article>' ;
		return $Ausgabe ;
		$_SESSION['ArtNr'] = $Datensatz['ArtikelNr'];
	}
	$_SESSION['logged_in'] = false;


// FUNKTIONSDEFINITIONEN --------------------------------------------------------------------
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
	// Funktion, die bei Seitenaufruf mit der Aktion "einloggen" ausgführt wird
	// und als Parameter die KundenNr und das Passwort aus dem Log.In-Formular erwartet.
	// Mit diesen Angeben wird dann in der Kunde Tabelle nach einem passendem Datensatz gesucht
	// der, falls existent, das Login erfolgreich macht und die benötigten Kunden-Daten liefern
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
	if( $Ergebnis->num_rows == 0 ) {
		
		header('Location:produkte.php');
	die();
	$Meldung = 'KundenNummer und Passwort stimmen nicht überein!';
		
		$_SESSION['Meldung'] = $Meldung;
	}
	else {
		$Datensatz = $Ergebnis->fetch_assoc() ;
		$_SESSION['Kunde'] = $Datensatz['KundenNr'] ;
		$_SESSION['Nachname'] = $Datensatz['Nachname'] ;
		$_SESSION['Vorname'] = $Datensatz['Vorname'] ;
		$_SESSION['Anrede'] = $Datensatz['Anrede'] ;
		
	}
	// DB-Abfrage mit o.g. ID und Passwort
	// Falls ein Datensatz dazu existiert, dann 
	// übertrage aus dem Datensatz die KundenNr, Anrede, Vor- und Nachname in Sessionvariable
	// Ansonsten zeige Fehlermeldung, Login und Neuregistrierung
}


	// REGISTRIEREN ---------------------------------------------------------------
	
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
	
	// EINLOGGEN ------------------------------------------------------------------
	
	if( isset($_POST['Aktion1']) && $_POST['Aktion1'] == 'einloggen' ) {
		einloggen( $_POST['KundenNr'], $_POST['Passwort'] ) ;
		$Meldung = 'Sie sind nun eingeloggt und werden in den geschüzten Bereich weitergeleitet .'; 
		$_SESSION['Meldung'] = $Meldung;
		$_SESSION['logged_in'] = true;
		
		
	
	}
	if($_SESSION['logged_in'] == true){
		header("Location: Artikel_unsecured.php");
	}
	
	
	function stop(){
		$Meldung = 'Bitte zuerst einloggen!';
		echo('Hallo');
	}
?>
										<!-- Wir über Uns - Pop-Up-Fenster -->
                                        <div id="myModal2" class="modal fade register" role="dialog">
                                            <div class="modal-dialog">
                
                                        <!-- Wir über uns content-->
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
                        <div><a href="index.php"><img class="img-responsive img img-circle col-md-4 col-lg-4 col-xs-4 col-sm-4 col-xl-4" src="./img/logo.jpg"></a></div>
                        <div><img src="./img/siegel2.jpg" class="img img-circle img-responsive col-md-4 col-lg-4 col-xs-4 col-sm-4 col-xl-4" alt="Placeholder image"></div>
                        <div><img src="./img/siegel1.jpg" class="img img-circle img-responsive col-md-4 col-lg-4 col-xs-4 col-sm-4 col-xl-4" alt="Placeholder image"></div>
					</div>
                    <div class="col-md-8 col-xs-2 col-sm-10 col-lg-8 col-xl-6 col-md-offset-2 col-xs-offset-5 col-sm-offset-1 col-lg-offset-0 col-xl-offset-0 text-center">
                       <nav class="blog-nav topnav">
                           <nav class="blog-nav ">
                                    <form name="Login" action="produkte.php?login=1" method="post">
                                        <fieldset>
                                            <label for="KN" class="label">KundenNr:</label> 
                                            <input id="KN" type="number" name="KundenNr" placeholder="KundenNummer" required class="btn btn-default btn-sm" />
                                            <label for="PW" class="label">Passwort:</label> 
                                            <input id="PW" type="password" name="Passwort" placeholder="Passwort" required class="btn btn-default btn-sm"/>
                                      		<div>
                                               <button id="LI" type="submit" name="Aktion1" value="einloggen" class="btn btn-default btn-sm">
                                               <span class="glyphicon glyphicon-log-in"></span> Log in 
                                               </button>
                                               <a href="index.php" name="Aktion" value="einloggen" class="btn btn-default btn-sm">
                                               <span class="glyphicon glyphicon-registration-mark"></span> Registrierung
                                               </a>
                   							</div>
                                      </fieldset>
                                    </form>
                                    
                                              
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
                                            <a href="index.php" class="blog-nav-item btn btn-default btn-sm">Home</a>
                                            <button id="LI" type="submit" name="Aktion1" value="stop" class="blog-nav-item btn btn-default btn-sm">Produkte 
                                            </button>
                                            <a href="#" data-toggle="modal" data-target="#myModal2" class="blog-nav-item  btn btn-default btn-sm">Wir über uns</a>
                                            <a href="#" class="blog-nav-item btn btn-default btn-sm">Rezepte</a>
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
                    <div class="row">
                        <div class="blog-main-produkte text-center col-md-12 col-xs-2 col-sm-12 col-lg-12 col-xl-10 col-md-offset-0 col-xs-offset-5 col-sm-offset-0 col-lg-offset-0 col-xl-offset-1 blog-main">
                        	<h1<?php echo( $Datensatz['Bezeichnung'] ) ; ?></h1>
                            	<div class="">
								<?php echo( zeigeArtikel( $Datensatz ) ) ; ?>
                                </div>
							<p>Zurück zum <a href="produkte_secured.php">Sortiment</a></p>
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