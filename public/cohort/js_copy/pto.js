// LET OP: alle items.length > 1 veranderd in > 0 werking niet gecheckt.




// python3 -m http.server 3000 &
var doc;
// A4 formaat is 21 x 29,7 cm | 72 ppi: 595 x 842
var margeHorizontaal = 50;
var margeVerticaal = 50;
var contentBreedte = 842 - 2*margeHorizontaal;
var contentHoogte = 595 - 2*margeVerticaal;
var grootteKop = 60;

var PTOType = 'vak'; // 'vak' of 'niveau'
var filterVak = 'EN';
var filterNiveau = '1HA';
var fileNaam = 'pto_tsv.txt';

var csvdata;
var Nrij;

function preload() {
  csvdata = loadTable(fileNaam, 'tsv'); // tsv.txt
}

var items,vakkenLijst;
var item;

function setup() {
    Nrij = csvdata.getRowCount();
    vakkenLijst = [];
    var huidigeVak = csvdata.getArray()[0][1];
    for (var r = 0;r < Nrij;r++) {
        item = csvdata.getArray()[r];
        if (item[1] != huidigeVak) {
            huidigeVak = item[1];
            vakkenLijst.push(item[1]);
        }
    }
    // http://raw.githack.com/MrRio/jsPDF/master/docs/jsPDF.html#setDocumentProperties // l is landscape
    doc = new jsPDF('l','pt','a4');
    doc.setProperties({
        title: 'PTO',
        subject: 'Programma van Toetsing Onderbouw',
        author: 'VNR',
        keywords: 'PTO,CSG,Augustinus'
    });
    if (PTOType == 'vak') {
        genereerPTOopVak();
    }
    else {
        genereerPTOopNiveau();
    }
}

function genereerPTOopVak() {
    var niveauLijst = ['1A','1HA','1MH','2A','2H','2M','3A','3H','3M'];
    var eerstePagina = true;
    for (var v = 0;v < niveauLijst.length;v++) {
        filterNiveau = niveauLijst[v];
        vakItems(filterVak);
        if (!eerstePagina && items.length > 0) {
            doc.addPage('a4','l');
        }
        if (items.length > 0) {
            kop(filterNiveau,filterVak);
            tabel(items);    
            eerstePagina = false;        
        }
    }  
    doc.save("PTO "+filterNiveau+" 2020-2021.pdf");    
}

function genereerPTOopNiveau() {
    for (var v = 0;v < vakkenLijst.length;v++) {
        filterVak = vakkenLijst[v];
        vakItems(filterVak);
        if (v != 0 && items.length > 0) {
            doc.addPage('a4','l');
        }
        if (items.length > 0) {
            kop(filterNiveau,filterVak);
            tabel(items);            
        }
    }  
    doc.save("PTO "+filterNiveau+" 2020-2021.pdf");
}

function vakItems(vak) {
    items = [];
    for (var r = 1;r < Nrij;r++) {
        // item = csvdata.getArray()[r][0].split(';'); // voor csv met ;
        item = csvdata.getArray()[r];
        if ((item[0] == filterNiveau && item[1] == vak && item[4] !=0) || r == 0) {
            items.push([item[3],item[7],item[6],item[4],item[5]]);            
        }
    }    
}

function kop(niveau,vak) {
    var offset = 15;
    doc.setTextColor(255);
    doc.setDrawColor(100);
    doc.setFillColor(100);
    doc.rect(margeHorizontaal,margeVerticaal,contentBreedte,grootteKop, 'FD');
    doc.setFontSize(120);
    // doc.setTextColor(240);
    doc.text(niveau,margeHorizontaal - offset,margeVerticaal + grootteKop + offset,'left');
    // doc.setTextColor(255);
    doc.setFontSize(60);
    doc.text(vak,margeHorizontaal + contentBreedte/2,margeVerticaal + grootteKop/2 + 1.5*offset,'center');
}

function tabel(items) {
    var head = [['per','afname','weging','stof','domein']];
    var body = items;
    doc.autoTable({
    startY: margeVerticaal+grootteKop+20,
    margin: {left:margeHorizontaal,right:margeHorizontaal},
    tableLineColor: [100],
    tableLineWidth: 0.01,
    styles: {
      lineColor: [100],
      lineWidth: 0.01,
    },    
    head: head,
    body: body,
    theme: 'grid',
    rowPageBreak: 'auto',    
    styles: {fontSize:16,fillColor:[100],textColor:255,minCellHeight:40,halign:'center',valign:'middle'},
    bodyStyles: {fontSize:12,fillColor:[255],textColor:50,minCellHeight:30},
    columnStyles: {
        2: {fontStyle:'bold'},
        3: {halign:'left'},
        4: {halign:'left'},
    },
    });
}