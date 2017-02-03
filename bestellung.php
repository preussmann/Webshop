<?php
	require_once('initialisierung.php') ;
	if( !isset( $_SESSION['Kunde'] ) ) header('location: index.php');
	if( count( $_SESSION['Warenkorb'] ) == 0 ){ header('location: produkte_secured.php');}
	else{$Meldung = 'Ihre Bestellübersicht, '.$_SESSION['Anrede'].' '.$_SESSION['Nachname'].'.' ;}
	
	if( isset( $_GET['Aktion'] ) && isset( $_GET['ArtNr'] ) && is_numeric( $_GET['ArtNr'] ) ) {
		
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
		} else die('Artikelnummer nicht vorhanden!');
		
		switch( $_GET['Aktion'] ) {
			case 'eintragen': 
				if( isset($_GET['Menge']) && is_numeric( $_GET['Menge'] ) ) { 
					wk_eintragen( $Datensatz['ArtikelNr'], $Datensatz['Bezeichnung'], (int) $_GET['Menge'], $Datensatz['Preis'] ) ;
				}
				break;
			case 'ändern': 
				if( isset($_GET['Menge']) && is_numeric( $_GET['Menge'] ) ) { 
					wk_eintragen( $Datensatz['ArtikelNr'], $Datensatz['Bezeichnung'], (int) $_GET['Menge'], $Datensatz['Preis'] ) ;
				}
				break;
			case 'löschen': 
				wk_eintragen( $Datensatz['ArtikelNr'], $Datensatz['Bezeichnung'], 0, $Datensatz['Preis'] ) ;
				break;
			default: die('Aktion nicht vorgesehen!') ;
		}
	}
	$posten = $_SESSION['Posten'];
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
                        <div><a href="index_secured.php"><img class="img-responsive img img-circle col-md-4 col-lg-4 col-xs-4 col-sm-4 col-xl-4" src="./img/logo.jpg"></a></div>
                        <div><img src="./img/siegel2.jpg" class="img img-circle img-responsive col-md-4 col-lg-4 col-xs-4 col-sm-4 col-xl-4" alt="Placeholder image"></div>
                        <div><img src="./img/siegel1.jpg" class="img img-circle img-responsive col-md-4 col-lg-4 col-xs-4 col-sm-4 col-xl-4" alt="Placeholder image"></div>
					</div>
                    <div class="col-md-8 col-xs-2 col-sm-10 col-lg-8 col-xl-6 col-md-offset-2 col-xs-offset-5 col-sm-offset-1 col-lg-offset-0 col-xl-offset-0 text-center">
                       <nav class="blog-nav topnav">
                           <nav class="blog-nav ">
                                    <a href="logout.php" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-log-out"></span> Log Out</a>
                                    <button id="WK" type="button" data-toggle="modal" data-target="#myModal3" class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> Warenkorb (<?php echo( $posten ) ; ?>)
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
                                <a href="index_secured.php" class="blog-nav-item btn btn-default btn-sm">Home</a>
                                <a href="produkte_secured.php" class="blog-nav-item btn btn-default btn-sm">Produkte</a>
                                <a href="#" data-toggle="modal" data-target="#myModal2" class="blog-nav-item  btn btn-default btn-sm">Wir über uns</a>
                                <a href="#" class="blog-nav-item btn btn-default btn-sm">Messetermine</a>
                                <button id="LI" type="button" data-toggle="modal" data-target="#myModal8" name="Aktion" value="einloggen" class="blog-nav-item btn btn-default btn-sm">
                                    <span class="glyphicon"></span> Kontakt und Impressum 
                                </button>
                        </nav>
              		</div>
                </div>
    </div>
<div class="container-fluid main"> 
       			<div class="row ">
					<div class="text-center col-md-12 col-xs-2 col-sm-12 col-lg-12 col-xl-10 col-md-offset-0 col-xs-offset-5 col-sm-offset-0 col-lg-offset-0 col-xl-offset-1 blog-main">
                        <section>
                        	<h1>Sie wollen bestellen: </h1>
                            <p>Oder bestellen Sie noch mehr aus unserem <a href="produkte_secured.php">Sortiment</a></p>
                        </section>
                    </div>                        
                </div>
                <div class="row">
                <div class="text-center col-md-12 col-xs-2 col-sm-12 col-lg-12 col-xl-10 col-md-offset-0 col-xs-offset-5 col-sm-offset-0 col-lg-offset-0 col-xl-offset-1 blog-main">
                	<div class="table-responsive"><?php echo( wk_zeigen() ) ; ?></div>
	<form name="Bestellung" action="bestaetigung.php" method="post">
		<label for="Zahlungsart" class="">Zahlungsart</label>
		<select name="Zahlungsart" id="Zahlungsart" class="btn btn-default btn-sm">
			<option value="Kreditkarte" class="btn btn-default btn-sm">Kreditkarte</option>
			<option value="Bankeinzug" class="btn btn-default btn-sm">Bankeinzug</option>
			<option value="PayPal" class="btn btn-default btn-sm">PayPal</option>
		</select>
		<label for="Lieferadresse" class="">Lieferadresse</label>
		<textarea name="Lieferadresse" class="btn btn-default btn-sm"></textarea>
		<label for="Zahlungsart" class="">Ich kenne und akzeptiere die <a href="agb.html">AGBs</a></label>
		<input type="checkbox" name="AGB" class="btn btn-default btn-sm"/>
		<input type="submit" name="Aktion" value="verbindlich bestellen" class="btn btn-default btn-sm"/>
	</form>
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
