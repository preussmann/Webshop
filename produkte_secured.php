<?php
require_once('initialisierung.php');  
$posten = $_SESSION['Posten'];
if($_SESSION['logged_in'] == false){ header("Location: produkte.php");}
else{$Meldung = 'Sehen Sie sich ein wenig in unserem Sortiment um, '.$_SESSION['Anrede'].' '.$_SESSION['Nachname'].'!.' ;}
require_once('initialisierung.php');  

	if( isset( $_GET['Aktion']) && $_GET['Aktion'] == 'suchen' ) {
		if( isset( $_GET['Eingabe']) && !empty( $_GET['Eingabe'] ) ) {
			$Suche = '%'.$_GET['Eingabe'].'%' ;
		} else $Suche = '%' ;
		$Abfrage = $Verbindung->prepare('
			SELECT ArtikelNr, Bezeichnung, Preis, Image, Zutaten
			FROM artikel
			WHERE Bezeichnung LIKE ? OR Beschreibung LIKE ? OR Zutaten LIKE ?
		;') ;
		$Abfrage->bind_param('ss', $Suche, $Suche ) ;
		$Abfrage->execute() ;
		$Ergebnis = $Abfrage->get_result() ;
	} else {
		$Ergebnis = $Verbindung->query('
			SELECT ArtikelNr, Bezeichnung, Preis, Image, Zutaten
			FROM artikel
		') ;
	}
	// Funktinosdefinitionen
	function zeigeSortiment( $Daten ) {
		$Ausgabe ='<table class="table table-bordered table-condensed table-hover tabelle">' ;
		while( $Datensatz = $Daten->fetch_assoc() ){
			$Ausgabe .= '<tr>' ;
			$Ausgabe .= '<td class="text-center"><a href="Artikel.php?ArtNr='.$Datensatz['ArtikelNr'].'"  class="reihe">'.$Datensatz['Bezeichnung'].'</a></td>' ;
			$Ausgabe .= '<td><img src="'.$Datensatz['Image'].'" width="160px" height="140px" alt="nicht da"/></td>' ;
			$Ausgabe .= '<td><p class="reihe">'.$Datensatz['Preis'].'€</p></td>' ;
			$Ausgabe .= '</tr>' ;
		}
		$Ausgabe .='</table>' ;
		return $Ausgabe ;
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
                                    <span class="glyphicon glyphicon-shopping-cart"></span> Warenkorb (<?php echo( $posten ); ?>)
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
       			<div class="row ">
					<div class="text-center col-md-12 col-xs-2 col-sm-12 col-lg-12 col-xl-10 col-md-offset-0 col-xs-offset-5 col-sm-offset-0 col-lg-offset-0 col-xl-offset-1 blog-main">
                        <section>
                        <h1>Unser Sortiment</h1>
                        </section>
                    </div>                        
                </div> 
                    <div class="row">
                        <div class="text-center col-md-12 col-xs-2 col-sm-12 col-lg-12 col-xl-10 col-md-offset-0 col-xs-offset-5 col-sm-offset-0 col-lg-offset-0 col-xl-offset-1 blog-main-produkte ">
                        	<form name="Suche" action="produkte_secured.php" method="get" class="suche col-md-4 col-md-offset-4 col-sm-offset-5">
                                <input type="text" name="Eingabe" style="" class="form-control"/>
                                <input type="submit" name="Aktion" value="suchen" class="blog-nav-item btn btn-default btn-sm col-md-4 col-md-offset-4"/>
							</form>
							<div style="margin: 10px;"><?php echo( zeigeSortiment( $Ergebnis ) ) ; ?></div>
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