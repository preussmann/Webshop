<?php
	require_once('initialisierung.php');
	$posten = $_SESSION['Posten'];
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
		$Ausgabe .='</div>';
		$Ausgabe .='<div class="col-md-6">';
		$Ausgabe .='
			<form name="Eintragung" action="bestellung.php" method="get">
				<input type="hidden" name="ArtNr" value="'.$Datensatz['ArtikelNr'].'"/>
				
				  <label for="Menge">Menge:</label>
				<select class="form-control" id="sel1" name="Menge" value="'.$Menge.'">
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
				  </select>
				<input type="submit" name="Aktion" value="eintragen" />
			</form>
		' ;
		$Ausgabe .='</div>';
		$Ausgabe .='</article>' ;
		return $Ausgabe ;
		$_SESSION['ArtNr'] = $Datensatz['ArtikelNr'];
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
                        <div><a href="index_secured.php"><img class="img-responsive img img-circle col-md-4 col-lg-4 col-xs-4 col-sm-4 col-xl-4" src="./img/logo.jpg"></a></div>
                        <div><img src="./img/siegel2.jpg" class="img img-circle img-responsive col-md-4 col-lg-4 col-xs-4 col-sm-4 col-xl-4" alt="Placeholder image"></div>
                        <div><img src="./img/siegel1.jpg" class="img img-circle img-responsive col-md-4 col-lg-4 col-xs-4 col-sm-4 col-xl-4" alt="Placeholder image"></div>
					</div>
                    <div class="col-md-8 col-xs-2 col-sm-10 col-lg-8 col-xl-6 col-md-offset-2 col-xs-offset-5 col-sm-offset-1 col-lg-offset-0 col-xl-offset-0 text-center">
                       <nav class="blog-nav topnav">
                           <nav class="blog-nav ">
                                    <a href="logout.php" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-log-out"></span> Log Out</a>
                                    <button id="WK" type="button" data-toggle="modal" data-target="#myModal3" class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> Warenkorb (<?php echo( $posten )  ?>)
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
                                <a data-toggle="modal" data-target="#myModal2" class="blog-nav-item  btn btn-default btn-sm">Wir über uns</a>
                                <a href="Rezepte_secured.php" class="blog-nav-item btn btn-default btn-sm">Rezepte</a>
                                <a href="#" data-toggle="modal" data-target="#myModal8" class="blog-nav-item  btn btn-default
                                            btn-sm">
                                    <span class="glyphicon"></span> Kontakt und Impressum 
                                </a>
                        </nav>
              		</div>
                </div>
    </div>
<div class="container-fluid main"> 
       			
                    <div class="row">
                        <div class="blog-main-produkte text-center col-md-12 col-xs-2 col-sm-12 col-lg-12 col-xl-10 col-md-offset-0 col-xs-offset-5 col-sm-offset-0 col-lg-offset-0 col-xl-offset-1 blog-main">
                        	<h1<?php echo( $Datensatz['Bezeichnung'] ) ; ?></h1>
                            	<div>
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