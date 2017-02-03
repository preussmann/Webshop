<?php  
require_once('initialisierung.php'); 

if($_SESSION['logged_in'] == false){ header("Location: index.php");}
else{$Meldung = 'Guten Tag, '.$_SESSION['Anrede'].' '.$_SESSION['Nachname'].', Sie sind nun eingeloggt.' ;} 

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
                                <a href="index_secured.php" class="blog-nav-item btn btn-default btn-sm">Home</a>
                                <a href="produkte_secured.php" class="blog-nav-item btn btn-default btn-sm">Produkte</a>
                                <a href="#" data-toggle="modal" data-target="#myModal2" class="blog-nav-item  btn btn-default btn-sm">Wir über uns</a>
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
                        <p class="lead ">Sie suchen Falafel, Hummus oder andere glutenfreie & vegane Spezialitäten?<br>
                                         Dann sind Sie hier richtig!
                        <br>
                        </p>
                        </section>
                    </div>                        
                </div>   
				<div class="row">
               	  <div class="">
                      <div id="carousel1" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carousel1" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel1" data-slide-to="1"></li>
                            <li data-target="#carousel1" data-slide-to="2"></li>
                        </ol>
                          <div class="carousel-inner" role="listbox">
                            <div class="item active"><img src="./img/carousel3.png" alt="First slide image" class="center-block img-responsive">
                              <div class="carousel-caption">
                                <h3>Falafel im Fladenbrot</h3>
                                <p>Immer frisch belegt</p>
                            </div>
                          </div>
                            <div class="item"><img src="./img/carousel1.png" alt="Second slide image" class="center-block img-responsive">
                              <div class="carousel-caption">
                                <h3>Bio und Vegan</h3>
                                <p>Lecker!</p>
                            </div>
                          </div>
                            <div class="item"><img src="./img/carousel2.png" alt="Third slide image" class="center-block img-responsive">
                              <div class="carousel-caption">
                                <h3>Lecker lecker Falafel</h3>
                                <p>Das schmeckt sooo gut</p>
                            </div>
                          </div>
                        </div>
                        <a class="left carousel-control" href="#carousel1" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="right carousel-control" href="#carousel1" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a></div>
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
