<?PHP
// $handmatigeLeerLaagLijst = ['H3','H4','A4','A5'];
// $handmatigeLeerLaagLijst = ['A4','A5'];

$vakCodeLijst = ['NE','EN','DU','FA','GDL','LO','MA','CKV','WA','WB','WC','WD','WI','IF','NA','NASK1','SK','NASK2','BIO','NLT','GS','AK','EC','BECO','KUA','KUBV','BTE','KCKV','BV','PWS','REK'];
$vakNamenLijst = ['Nederlands','Engels','Duits','Frans','godsdienst','LO','maatschappijleer','CKV','wiskunde A','wiskunde B','wiskunde C','wiskunde D','wiskunde','informatica','natuurkunde','NaSk1','scheikunde','NaSk2','biologie','NLT','geschiedenis','aardrijkskunde','economie','BECO','KUA','Kunst BV','BTE','KCKV','beeldende vorming','Profielwerkstuk','Rekenen'];
$huidigJaarVoorGenererenExcel = 2021; // doe je voor de zomervakantie
// LET OP LET OP eerste item [0] wordt ook gebruikt om dat tabblad weer te verwijderen voor iedereen behalve KCKV
$tabbladen = ['M2021','M2020','M2019','H2021','H2020','H2019','A2021','A2020','A2019','A2018'];
$status = 'schrijfrecht'; // schrijfrecht leesrecht definitief
$lagen = ['M4','H4','H5','A4','A5','A6','M3'];

$printJaar = 2021; // jaar waarin wordt geprint voor het komende examenjaar. 2021 print dus voor 2021-2022 = examenjaar 2022
$toonWatermerk = true;
$inlezen = false; // anders wegschrijven naar xlsx en PDF
$outputPTA = false; // bij false volgt een PTO
if ($outputPTA) {$outputType = 'PTA';} else {$outputType = 'PTO';}



?>