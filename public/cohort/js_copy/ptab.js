// python3 -m http.server 3000 &
var doc;
// A4 formaat is 21 x 29,7 cm | 72 ppi: 595 x 842
var margeHorizontaal = 50;
var margeVerticaal = 50;
var contentBreedte = 842 - 2*margeHorizontaal;
var contentHoogte = 595 - 2*margeVerticaal;
var grootteKop = 60;

var PTAType = 'niveau'; // 'vak' of 'niveau'
var PTAsoort = 'A'; // A=PTA, B=PTB Bovenbouw
var filterVak = 'NE';
var filterNiveau = '4A';
var voet = true;
var waterMerk = false;
var waterMerkTruc;
// var fileNaam = 'PTAB_DEF_controle.txt';
// var fileNaam = 'PTAB_def_deelraad.txt';
var fileNaam = 'basisCOHORTEN.txt';
var csvdata;
var Nrij;

function preload() {
  csvdata = loadTable(fileNaam, 'tsv');
}

var items,vakkenLijst,item;
var opmerkingenPTA = [];

function setup() {
    Nrij = csvdata.getRowCount();
    vakkenLijst = genereerVakkenlijst();
    // http://raw.githack.com/MrRio/jsPDF/master/docs/jsPDF.html#setDocumentProperties // l is landscape
    doc = new jsPDF('l','pt','a4');
    doc.setProperties({
        title: 'PTA & PTB',
        subject: 'Programma van Toetsing Bovenbouw',
        author: 'VNR',
        keywords: 'PTA & PTB,CSG,Augustinus'
    });
    if (PTAType == 'vak') {
        genereerPTBopVak();
    }
    else {
        genereerPTBopNiveau();
    }
}

function genereerVakkenlijst() {
    var lijst = [];
    for (var r = 0;r < Nrij;r++) {
        item = csvdata.getArray()[r];
        lijst[item[1]] = item[2];
    }
    var vaklijst = lijst.filter(function (el) {
        return el != null;
    });
    return vaklijst;
}

function genereerPTBopVak() {
    var niveauLijst = ['3M','4M','4H','5H','4A','5A','6A'];
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
    doc.save("PTB "+filterNiveau+" 2020-2021.pdf");    
}

function genereerPTBopNiveau() {
    var eerstePagina = true;
    var paginaNummer = 1;
    for (var v = 0;v < vakkenLijst.length;v++) {
        filterVak = vakkenLijst[v];
        if (PTAsoort == 'A') {
            vakItemsPTA(filterVak);
            console.log('vak '+filterVak+' heeft N='+items.length);
            if (v != 0 && items.length > 0 && !eerstePagina) {
                doc.addPage('a4','l');
            }
            if (items.length > 0) {
                kop(filterNiveau,filterVak);
                tabelPTA(items);
                opmerkingen([[opmerkingenPTA[filterVak]]]);
                if (voet) {footer(filterNiveau,paginaNummer);}
                paginaNummer++;
                eerstePagina = false;
                if (waterMerk) {
                    doc.addImage("js/controle15.png", "PNG",0,0,800,321,waterMerkTruc,'NONE',-19);                    
                }
            }
        }
        else {
            vakItemsPTB(filterVak);
            if (v != 0 && items.length > 0 && !eerstePagina) {
                doc.addPage('a4','l');
            }
            if (items.length > 0) {
                kop(filterNiveau,filterVak);
                tabelPTB(items);
                eerstePagina = false;     
            }
        }
    }  
    doc.save("PT"+PTAsoort+" "+filterNiveau+" 2020-2021.pdf");
}

function vakItemsPTB(vak) {
    items = [];
    var codeSom;
    for (var r = 1;r < Nrij;r++) {
        item = csvdata.getArray()[r];
        if ((item[0] == filterNiveau && item[2] == vak && item[6] !=0 && item[4] !=7) || r == 0) {
            codeSom = item[5]+''+item[8]+''+'XX';
            // UPDATE bij export op school niet!! Er ontstaat een lege kolom [6]
            // voor PTB 8 is VD
            // voor PTA 13 is SE, 14 is her, 15 is domein
            if (item[7] == 0) {
                item[7] = ''; // leeg laten
                //item[8] = item[13]; // gelijkstellen aan SE levert nu wel 0 bij HD maar dat kan opgelost
            }
            // items.push([item[5],item[8],item[7],item[6]]);
            if (item[7]==0) {item[7] = item[12]+'*';}
            if (item[14]==0) {item[14] = '';}
            items.push([item[5],item[8],item[7],item[6],item[14]]);
        }
    }
}

var hulp = 0;

function vakItemsPTA(vak) {
    items = [];
    var codeSom,duur;
    var codeHelper = [];
    codeHelper['tt'] = 0;
    codeHelper['mt'] = 0;
    codeHelper['lt'] = 0;
    codeHelper['hd'] = 0;
    codeHelper['po'] = 0;
    for (var r = 1;r < Nrij;r++) {
        // item = csvdata.getArray()[r][0].split(';'); // voor csv met ;
        item = csvdata.getArray()[r];
        // console.log(item);
        if (item[4] == 7 && item[2]==vak && item[6]!=0 && item[0]==filterNiveau) {
            opmerkingenPTA[item[2]] = item[6];
        }
        if ((item[0] == filterNiveau && item[2] == vak && item[6] !=0 && item[11] =='Ja') || r == 0) {
            codeHelper[item[8]]++;
            codeSom = item[0][0]+''+item[8]+''+codeHelper[item[8]];
            // UPDATE bij export op school niet, dus waarden vanaf 7 met 1 verlaagd!! Er ontstaat een lege kolom [6]
            //items.push([item[0],item[1],item[2],item[3],item[4],item[5],item[6],item[7],item[8],item[9],item[10],item[11],item[12],item[13],item[14],item[15]]);
            // voor PTB 8 is VD
            // voor PTA 13 is SE, 14 is her, 15 is domein
            if (item[10] == 0) {
                duur = '';
            }
            else {
                duur = item[10];
            }
            // toegevoegd afwijkende hulpmiddelen item[9]
            if (item[9] == 0) {item[9] = '';}
            if (item[14] == 0) {item[14] = '';}
            items.push([item[5],codeSom,item[12],item[13],duur,item[6],item[14],item[9]]);
        }
    }
}

function kop(niveau,vak) {
    var offset = 8;
    doc.setTextColor(255);
    doc.setDrawColor(100);
    doc.setFillColor(100);
    doc.rect(margeHorizontaal,margeVerticaal,contentBreedte,grootteKop, 'FD');
    doc.setFontSize(60);
    // doc.setTextColor(240);
    doc.text(niveau,margeHorizontaal,margeVerticaal + grootteKop - offset,'left');
    // doc.setTextColor(255);
    doc.setFontSize(36);
    doc.text(vak,margeHorizontaal + contentBreedte/2,margeVerticaal + grootteKop/2 + 1.5*offset,'center');
}

function getDatum() {
    var vandaag = new Date();
    var dd = String(vandaag.getDate()).padStart(2, '0');
    var mm = String(vandaag.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = vandaag.getFullYear();
    vandaag = dd + '-' + mm + '-' + yyyy;
    return vandaag;
}

function footer(niveau,pag) {
    var offset = 8;
    doc.setTextColor(200);
    doc.setFontSize(10);
    var d = new Date();
    //doc.text('|  '+pag+'  |                     PTA CSG Augustinus '+niveau+' 2020-2021 (datum afdruk:'+getDatum()+') ',contentBreedte+margeHorizontaal,contentHoogte+1.5*margeVerticaal,'right');
    //doc.text('|  '+pag+'  |                                        PTA CSG Augustinus '+niveau+' 2020-2021',contentBreedte+margeHorizontaal,contentHoogte+1.5*margeVerticaal,'right');
    doc.text('PTA CSG Augustinus '+niveau+' 2020-2021',contentBreedte+margeHorizontaal,contentHoogte+1.5*margeVerticaal,'right');
    doc.setTextColor(100);
    doc.text('|  '+pag+'  |',842/2,contentHoogte+1.5*margeVerticaal,'right');
}

function opmerkingen(content) {
    var head = [['opmerkingen']];
    var body = content;
    if (body[0] == "0") {
        // body = null; voor volledig weglaten
        body[0] = " ";
    }
    doc.autoTable({
    startY: contentHoogte - grootteKop,
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
    styles: {fontSize:14,fillColor:[100],textColor:255,minCellHeight:40,halign:'left',valign:'middle'},
    bodyStyles: {fontSize:11,fillColor:[255],textColor:50,minCellHeight:30},
    });
}

function tabelPTB(items) {
    var head = [['per','afname','weging VD','stofomschrijving','domeinen']];
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
    styles: {fontSize:14,fillColor:[100],textColor:255,minCellHeight:40,halign:'center',valign:'middle'},
    bodyStyles: {fontSize:11,fillColor:[255],textColor:50,minCellHeight:30},
    columnStyles: {
        2: {fontStyle:'bold'},
        3: {halign:'left'},
        4: {halign:'left'},
    },
    });
}

function tabelPTA(items) {
    var kopDomein = 'domeinen examen';
    if (filterNiveau == '4M') {
        kopDomein = 'eenheden examen';
    }
    var head = [['per','code SOM','weging','her','duur','stofomschrijving',kopDomein,'hulpmiddelen']];
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
    styles: {fontSize:14,fillColor:[100],textColor:255,minCellHeight:40,halign:'center',valign:'middle'},
    bodyStyles: {fontSize:11,fillColor:[255],textColor:50,minCellHeight:30},
    columnStyles: {
        5: {halign:'left'},
        6: {halign:'left'},
        7: {halign:'left'},
    },
    });
}