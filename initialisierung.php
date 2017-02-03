<?php // Allgemeine Voreinstellungen
session_start();
// Mit DB Verbinden...
$Verbindung = new mysqli('localhost','root','','db_pejo_shop') ;
if( $Verbindung->error ) { 
	die('Verbindungsfehler: '.$Verbindung->connect_error ) ;
	$Meldung = 'Verbindung tot!';
}
$Verbindung->set_charset('utf8') ;

// Initialisierung von Session und Warenkorb:

if( ! isset( $_SESSION['Warenkorb'] ) ) $_SESSION['Warenkorb'] = array() ;

// Definition der Posten-Klasse
class Posten {
	// Instanzeigenschaften:
	public $ArtNr ;
	public $Bez ;
	public $Mng ;
	public $Prs ;
	//public $Img ;
	// Konstruktor-Funktion
	// ...wird bei Erzeugung einer neuen Posten-Instanz aufgerufen
	// ... und liefert als Rückgabewert eine REFERENZ auf diese.
	public function __construct( $ArtikelNr, $Bezeichnung, $Menge, $Preis ) {
		$this->ArtNr = (int) $ArtikelNr ;
		$this->Bez = (string) $Bezeichnung ;
		$this->Mng = (int) $Menge ;
		$this->Prs = (float) $Preis ;
		
		
	}
	// Definition benötigter Instanz-Methoden:
	public function berechnen( $Steuer = 0 ) {
		$PostenPreis = $this->Mng * $this->Prs ;
		$PostenPreis += $PostenPreis * $Steuer /100  ;
		return $PostenPreis ; 
	}
	
	public function alleposten(){
		$gesamtposten = $this->Mng;
		return $gesamtposten;
		}

}
function ueberuns(){
$Anzeigen = '<h2>Alte Familienrezepte</h2><h3>Moderne Produktionsmethoden</h3><section>
<h3>Täglich frische Produktion in Deutschland nach deutschen Standards</h3>

 <div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="./img/persoenlichkeit.jpg"></iframe>
</div>
<p>Das ist unser Erfolgsrezept!
Wir schreiben das Jahr 1991. Gerade hat in Tübingen der ers­te Falafel-Imbiss seine Pforten geöffnet: „Die Kichererbse“. <br><br> Der Koch der ersten Stunde ist Hossam Ekkawi, erst weni­ge Monate zuvor hatte er seine Heimat Beirut verlassen. <br><br>
„Die Kichererbse“ ist von Anfang an ein Erfolg! Joachim Winkler, ein Tübinger Student, wird dort Stammkunde, und mit der Zeit freunden sich die beiden an: Der Koch und der Bio-Student.<br><br>
2006 ist es dann so weit: Die Peijo GbR wird in Hechingen am Fuße der Schwäbischen Alb gegründet. <br></p>
<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="./img/persoenlichkeit2.jpg"></iframe>
</div>
<p>
Unser Ziel ist es von Anfang an, Falafel und andere vegane Lecke­reien aus dem östlichen Mittelmeerraum in höchster Qualität und Authentizität in Bio-Qualität herzustellen.<br>
Mittlerweile steht die Peijo GbR hunderten von Partnern in Deutschland, Österreich, der Schweiz und Frankreich als Lieferant zur Ver­fügung. <br><br>
Bei Messeauftritten und Verkostungen am point of sale erleben wir immer wieder, dass die Kunden von der hohen Qua­lität und dem feinen Geschmack unserer Speisen begeistert sind.<br>
Das Schöne an unseren Produkten ist, dass wir sie nicht erst „designen“ mussten. Falafel & Co. gibt es schon seit Jahrhunderten und sie sind schon im­mer vegan, glutenfrei und laktosefrei! <br><br>
Der einzigartige Geschmack un­serer Produkte beruht auf Ihrer Ursprünglichkeit.
Keine langen Zu­tatenlisten, keine Zusätze, Hilfsstoffe oder Aromen - es kommt nichts hinein, was nicht hinein gehört.<br>
Bei uns mussten sich nicht die Produkte an die Maschinen anpassen, sondern die Maschinen wurden so entworfen,
dass wir mit ih­nen unsere Produkte unverfälscht herstellen können.</p>
</section>';
return $Anzeigen;
}

function kontakt(){
	$Darstellen = '						 <section >
                                          <strong>Hossam Ekkawi & Joachim Winkler</strong><br>
                                                  Nierlochstraße 2<br>
                                                  D-72379 Hechingen<br>
                                          <abbr title="Telefonnummer">Tel.:</abbr> +49 7471 - 871 931
                                          <abbr title="Fax">Fax.:</abbr> +49 7471 - 871 910 <br>
                                          <h3>Peijo GbR</h3>
                                          <a href="index.php"><img class="img-responsive img img-rounded center-block" src="./img/logo.jpg"></a>
                                         
                                        </section>
                                		';
									return $Darstellen;
	}
	
	
	function datenschutz(){
		$Datenschutzausgabe = 'Geltungsbereich

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
Datenschutz-Muster von Rechtsanwalt Thomas Schwenke - I LAW it';
return $Datenschutzausgabe;
		}

// Funktionen des Warenkorbs


function wk_zeigen() {
	$gesamtposten = 0;
	$Gesamt = 0 ;
	$Anzeige = '<table class="table table-responsive table-bordered table-condensed table-striped tabelle table-sm">' ;
	$Anzeige .= '<tr class="info"><th>ArtNr</th><th>Bezeichnung</th><th>Menge</th><th>Preis</th><th>Posten</th><th>Aktion</th></tr>';
	foreach( $_SESSION['Warenkorb'] as $Eintrag ) {
		$Anzeige .= '<tr><form name="Eingabe" method="get" action="bestellung.php">' ;
		$Anzeige .= '<td><input type="text" readonly name="ArtNr" value="'.$Eintrag->ArtNr.'"/></td>' ;
		$Anzeige .= '<td><input type="hidden" name="Bezeichnung" value="'.$Eintrag->Bez.'"/>
						<a href="Artikel.php?ArtNr='.$Eintrag->ArtNr.'">'.$Eintrag->Bez.'</a></td>' ;
		$Anzeige .= '<td><input type="number" name="Menge" value="'.$Eintrag->Mng.'"/></td>' ;
		$Anzeige .= '<td><input type="text" readonly name="Preis" value="'.$Eintrag->Prs.'"/></td>' ;
		$Anzeige .= '<td>'.$Eintrag->berechnen().'</td>' ;
		$Anzeige .= '<td>	<input type="submit" name="Aktion" value="ändern"/>
								<input type="submit" name="Aktion" value="löschen"/></td>' ;
		$Anzeige .= '</form></tr>' ;
		$Gesamt += $Eintrag->berechnen() ;
		$gesamtposten += $Eintrag->alleposten() ;
		
	}
	$Anzeige .= '<tr><td colspan="4">Gesamtpreis</td><td>'.$Gesamt.'</td></tr>';
	$Anzeige .= '<tr><td colspan="4">Artikel im Warenkorb</td><td>'.$gesamtposten.'</td></tr>';
	$Anzeige .= '</table>' ;
	$_SESSION['Posten'] = $gesamtposten;
	return $Anzeige ;
	return $SESSION['Posten'];
}

function wk_finden( $Artikel ) {
	for( $i = 0 ; $i < count( $_SESSION['Warenkorb'] ) ; $i++ ) {
		if( $_SESSION['Warenkorb'][$i]->ArtNr == $Artikel ) return $i ;
	}
	return -1 ;
}

function wk_eintragen( $ArtikelNr, $Bezeichnung, $Menge, $Preis ) {
	// Position des Artikels im Warenkorb ermitteln
	$Pos = wk_finden( $ArtikelNr ) ;
	if( $Menge > 0 && $Pos < 0 ) {
		// Falls Artikel gewünscht und noch nicht im Warenkorb: Neueintrag
		$_SESSION['Warenkorb'][] = new Posten( $ArtikelNr, $Bezeichnung, $Menge, $Preis ) ;
	} else if( $Menge > 0 && $Pos >= 0 ) {
		// Falls Artikel gewünscht und bereits im Warenkorb: Mengenänderung
		$_SESSION['Warenkorb'][$Pos]->Mng = $Menge ;
	} else if( $Menge <= 0 && $Pos >= 0 ) {
		// Falls Artikel nicht gewünscht, aber im Warenkorb: Löschung
		array_splice( $_SESSION['Warenkorb'], $Pos, 1 );
	} else {
		// Artikel nicht gewünscht und auch nicht im Warenkorb ... also nichts tun.
	}
}

function zeigeSelect( $Daten ) {
	$Kopfzeile = true ;
	$Feldnamen = '' ;
	$Eintraege = '' ;
	while( $Datensatz = $Daten->fetch_assoc() ) {
		$Eintraege .= '<tr>' ;
		foreach( $Datensatz as $Feld => $Eintrag ) {
			if( $Kopfzeile ) $Feldnamen .= '<th>'.$Feld.'</th>' ;
			$Eintraege .= '<td>'.$Eintrag.'</td>' ;
		}
		$Kopfzeile = false ;
		$Eintraege .= '</tr>' ;
	}
	$Tabelle = '<table border="1" class="table table-responsive table-bordered table-condensed table-striped tabelle table-sm">'.'<tr>'.$Feldnamen.'</tr>'.$Eintraege.'</table>' ;
	return $Tabelle ;
}
?>