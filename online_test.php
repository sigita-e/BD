<!DOCTYPE html>
<?php include "header.php";?>

    <title>UDHS apvienība | anketa</title>

<body>

<div class="page-wrapper">

<div class="container Site-content">
    <div class="row">
        <div class="col-sm-12">

            <h1 class="h1-body-text">Bērna UDHS novērtēšanas anketa</h1>
            <p class="text-justify">Aizpildi anketu tiešsaistē, lai novērtētu bērnu par iespējamu vai diagnosticētu uzmanības deficīta un hiperaktivitātes sindromu. 
            Pēc izpildes anketu iespējams iesniegt ārtsējošam ārstam UDHS simptomu dinamikas vērtēšanai. 
            Pilnīgu rezultātu ieguvei anketa neatkarīgi jāaizpilda gan bērna likumiskajam pārstāvim par uzvedību mājas apstākļos, gan pedagogam par uzvedību izglītības iestādē. 
            Pilna anketas versija atrodama <a href="guidelines.php">UDHS vadlīnijās</a>. Anketa sastāv no 18 jautājumiem.
            <p class="text-center" id="notification"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                </svg> Anketai ir informatīva nozīme
        
            <p class="text-justify">
                <p id="test_status"></p>
                <div id="onlineTest"></div>
        </div>
    </div>
</div>

<style>
.center-td {
    text-align: center;
}

input[type="radio"] {
    margin: 0 10px 0 0;
}

#errorChFill {
    display: flex; 
    justify-content: center;
    text-align: center; 
    color:red; 
    margin: 16px 0 16px 0;
}

#errorFill {
    color:red; 
    margin-right: 16px; 
}

.error-button {
    display: flex; 
    float: right; 
    height: 100%; 
    align-items: center; 
    justify-content: center; 
    vertical-align:middle;
}

.option-input {
  -webkit-appearance: none;
  -moz-appearance: none;
  -ms-appearance: none;
  -o-appearance: none;
  appearance: none;
  position: relative;
  top: 2px;
  right: 0;
  bottom: 0;
  left: 0;
  height: 16px;
  width: 16px;
  background: #cbd1d8;
  border: none;
  color: #fff;
  cursor: pointer;
  display: inline-block;
  outline: none;
  position: relative;
  z-index: 1000;
}
.option-input:hover {
  background: #9faab7;
}
.option-input:checked {
  background: #337ab7;
}
.option-input:checked::before {
  height: 16px;
  width: 16px;
  position: relative;
  content: '✔';
  display: inline-block;
  font-size: 12px;
  text-align: normal;
  line-height: 16px;
  bottom: 4px;
}
.option-input:checked::after {
  background: #337ab7;
  content: '';
  display: block;
  position: relative;
  z-index: 100;
}
.option-input.radio {
  border-radius: 50%;
}
.option-input.radio::after {
  border-radius: 50%;
}

</style>

               
<script type="text/javascript">
var pos = 0, test, test_status, question, choice, choicesHTML, testHTML, pages = 0, ch0 = "Nekad", ch1 = "Dažreiz", ch2 = "Bieži", ch3 = "Ļoti bieži", scoreTotal = 0;
var childGender, childAge, childHTML, choiceChildAge, choiceChildGender, choiceAgeList, choiceGenderList, childAge, childGender, posChild = 1;
var scaleResult = "", chADHD1 = "zema", chADHD2 = "vidēja", chADHD3 = "augsta", chADHD4 = "ļoti augsta";

var aboutChild = [
    [ "Bērna dzimums", "Siev.", "Vīr." ],
    [ "Bērna vecuma grupa", "5-7", "8-10", "11-13", "14-18" ]
];

choicesHTML = [];

var questions = [
    [ "Nespēj sakopot uzmanību detaļām vai pieļauj skolas darbos paviršas kļūdas" ],
	[ "Nemierīgi kustina rokas un kājas, grozās uz krēsla" ],
	[ "Ir grūtības ilgstoši sakopot/ koncentrēt uzmanību uz mācībām vai rotaļām"  ],
	[ "Atstāj savu vietu klasē vai citā situācijā, kurā tiek gaidīta mierīga palikšana savā vietā"],
    [ "Šķiet, ka viņš neklausās, kad ar viņu runā" ],
    [ "Pārmērīgi skraida vai kāpelē situācijās, kad tas ir nepiedienīgi" ],
    [ "Nespēj sekot instrukcijām un nespēj pabeigt darbu" ],
    [ "Ir grūtības rotaļāties vai mierīgi piedalīties brīvā laika aktivitātēs" ],
    [ "Grūti organizēt darbu un aktivitātes" ],
    [ "Ir nepārtrauktā kustībā vai kā ar motoru \"dzīts\"" ],
    [ "Izvairās no skolas darbiem (skolasdarbiem, mājasdarbiem), kuri prasa ilgstošu garīgu piepūli" ],
    [ "Runā skaļi un daudz (pārmērīgi)" ],
    [ "Zaudē lietas, kuras nepieciešamas skolā vai citās aktivitātēs" ],
    [ "Runā/ atbilst pirms jautājums ir pabeigts" ],
    [ "Ir ļoti izklaidīgs" ],
    [ "Grūti sagaidīt savu kārtu" ],
    [ "Izklaidīgs/ aizmāršīgs dienas darbos/ aktivitātēs" ],
    [ "Pārtrauc un uzmācās citiem" ]
];

function _(x){
	return document.getElementById(x);
}


function startTest() {
    test = _("onlineTest");
    _("test_status").innerHTML = "Pamatinformācija par bērnu";

    childHTML = "<table class=\"table\" style=\"margin-left: auto; margin-right: auto; width:50%;\">";

    childHTML += "<tr><td>"+aboutChild[0][0]+":</td><td></td><td></td>";
    childHTML += "<td class=\"center-td\"><label><input class=\"option-input radio\" type='radio' name='choiceChildGender' value='S'>"+aboutChild[0][1]+"</label></td>";
    childHTML += "<td class=\"center-td\"><label><input class=\"option-input radio\" type='radio' name='choiceChildGender' value='V'>"+aboutChild[0][2]+"</label></td></tr>";

    childHTML += "<tr><td>"+aboutChild[1][0]+":</td>";

    for(var i=posChild; i<(aboutChild[1].length); i++) {
        childHTML += "<td class=\"center-td\"><label><input class=\"option-input radio\" type='radio' name='choiceChildAge' value='"+aboutChild[1][i]+"'>"+aboutChild[1][i]+"</label></td>";
    }
    childHTML += "</tr></table>";
    test.innerHTML = childHTML;

    test.innerHTML += "<span id=\"errorChFill\"></span>";
    test.innerHTML += "<p class=\"text-center\"><button type=\"button\" class=\"btn btn-primary\" button onclick='validateChildAnswers()'>Sākt</button></p>";
    
}

function validateChildAnswers() {

    var countUncheckedAge = 0;

    choiceChGenderList = document.getElementsByName("choiceChildGender");

    if (!choiceChGenderList[0].checked & !choiceChGenderList[1].checked) {
        document.getElementById("errorChFill").innerHTML = "Lūdzu atzīmē bērna dzimumu!";
    } else {
        choiceChAgeList = document.getElementsByName("choiceChildAge");

        for (var j=0; j<4; j++)  {
            if (choiceChAgeList[j].checked) {
                countUncheckedAge++; 
            }
         }

         if ( countUncheckedAge > 0 ) {
            document.getElementById("notification").style.opacity = "0"; 
            checkChildAnswers();
         } else {
            document.getElementById("errorChFill").innerHTML = "Lūdzu aizpildi bērna vecuma grupu!";
         }

    }

}

function checkChildAnswers() {
    choiceAgeList = document.getElementsByName("choiceChildAge");
    choiceGenderList = document.getElementsByName("choiceChildGender");

    for(var i=0; i<choiceGenderList.length; i++){
		if(choiceGenderList[i].checked){
			childGender = choiceGenderList[i].value;
		}
	}

    for(var i=0; i<choiceAgeList.length; i++){
		if(choiceAgeList[i].checked){
			childAge = choiceAgeList[i].value;
		}
	}

    renderQuestions();
}

function scaleADHD (score) {

    switch (childAge) {
        case "5-7":
            switch (childGender) {
                case "S":
                    //alert("S 5-7");
                    if ( score <= 7 ) { scaleResult = chADHD1; }
                    if ( score > 7 && score <= 23 ) { scaleResult = chADHD2; }
                    if ( score > 23 && score <= 36 ) { scaleResult = chADHD3; }
                    if ( score > 36 ) { scaleResult = chADHD4; }
                break;
                case "V":
                    //alert("V 5-7");
                    if ( score <= 13 ) { scaleResult = chADHD1; }
                    if ( score > 13 && score <= 30 ) { scaleResult = chADHD2; }
                    if ( score > 30 && score <= 39 ) { scaleResult = chADHD3; }
                    if ( score > 39 ) { scaleResult = chADHD4; }                    
                break;
            }
        break;

        case "8-10":
            switch (childGender) {
                case "S":
                    //alert("S 8-10");
                    if ( score <= 4 ) { scaleResult = chADHD1; }
                    if ( score > 4 && score <= 16 ) { scaleResult = chADHD2; }
                    if ( score > 16 && score <= 30 ) { scaleResult = chADHD3; }
                    if ( score > 30 ) { scaleResult = chADHD4; }
                break;
                case "V":
                    //alert("V 8-10");
                    if ( score <= 15 ) { scaleResult = chADHD1; }
                    if ( score > 15 && score <= 34 ) { scaleResult = chADHD2; }
                    if ( score > 34 && score <= 44 ) { scaleResult = chADHD3; }
                    if ( score > 44 ) { scaleResult = chADHD4; }                    
                break;
            }
        break;

        case "11-13":
            switch (childGender) {
                case "S":
                    //alert("S 11-13");
                    if ( score <= 5 ) { scaleResult = chADHD1; }
                    if ( score > 5 && score <= 17 ) { scaleResult = chADHD2; }
                    if ( score > 17 && score <= 27 ) { scaleResult = chADHD3; }
                    if ( score > 27 ) { scaleResult = chADHD4; }
                break;
                case "V":
                    //alert("V 11-13");
                    if ( score <= 12 ) { scaleResult = chADHD1; }
                    if ( score > 12 && score <= 28 ) { scaleResult = chADHD2; }
                    if ( score > 28 && score <= 36 ) { scaleResult = chADHD3; }
                    if ( score > 36 ) { scaleResult = chADHD4; }                    
                break;
            }
        break;

        case "14-18":
            switch (childGender) {
                case "S":
                    //alert("S 14-18");
                    if ( score <= 3 ) { scaleResult = chADHD1; }
                    if ( score > 3 && score <= 11 ) { scaleResult = chADHD2; }
                    if ( score > 11 && score <= 18 ) { scaleResult = chADHD3; }
                    if ( score > 18 ) { scaleResult = chADHD4; }
                break;
                case "V":
                    //alert("V 14-18");
                    if ( score <= 9 ) { scaleResult = chADHD1; }
                    if ( score > 9 && score <= 23 ) { scaleResult = chADHD2; }
                    if ( score > 23 && score <= 31 ) { scaleResult = chADHD3; }
                    if ( score > 31 ) { scaleResult = chADHD4; }                    
                break;
            }
        break;
    }
    
    return scaleResult;
}

function renderQuestions(){
	test = _("onlineTest");

	if (pos >= questions.length) {
        //document.getElementById("notification").style.opacity = "1"; 
        scaleADHD (scoreTotal);
		test.innerHTML = "<p class=\"text-center\";>Bērna dzimums: "+childGender+"., vecuma grupa: "+childAge+" gadi<p class=\"text-center\";>Kopējais punktu skaits: <b>"+scoreTotal+"</b><p><h1>UDHS ticamība: <b>"+scaleResult +"</b></h1>";
        scaleResult = "";
		_("test_status").innerHTML = "";
		pos = 0;
		scoreTotal = 0;
		return false;
	}

	_("test_status").innerHTML = (pages+1)+" no "+questions.length /6 + " lapām";

    testHTML = "<table class=\"table table-striped\"><thead><tr class=\"info\"><th>Simptomi</th><th class=\"center-td\">Nekad</th><th class=\"center-td\">Dažreiz</th><th class=\"center-td\">Bieži</th><th class=\"center-td\">Ļoti bieži</th></tr></thead><tbody>";

    for(var i=pos; i<(pos+6); i++) {
        question = questions[i][0];
	    testHTML += "<tr><th>"+question+"</th>";
        for (var j=0; j<4; j++) {
            testHTML += "<td class=\"col-md-1 center-td\"><input class=\"option-input radio\" type='radio' name='choices"+i+"' value='"+j+"'></td>";
        }
        
        testHTML += "</tr>";
    }

    testHTML += "</tbody></table>";
    test.innerHTML = testHTML;
	test.innerHTML += "<div class=\"error-button\"><span id=\"errorFill\"></span><button type=\"button\" class=\"btn btn-primary pull-right\" button onclick='validateAnswers()'>Apstiprināt un turpināt</button></div>";
}

function validateAnswers() {
    var choiceNumber, choicesEachRow, countUncheckedRow, countUnchecked = 0;

    for (var i=pos; i<(pos+6); i++)  {

        choiceNumber = "choices"+ i;
        choicesEachRow = document.getElementsByName(choiceNumber);
        countUncheckedRow = 0; 

        for (var j=0; j<4; j++)  {
            if (!choicesEachRow[j].checked) {
                countUncheckedRow++; 
            }
        }

        if (countUncheckedRow == 4) {
            for (var k=0; k<4; k++)  {
                countUnchecked++;
                document.getElementById("errorFill").innerHTML = "Lūdzu aizpildi visas rindas!";
                return false;
            }
        }   
    }

    if (countUnchecked == 0) {
        checkAnswers();
    }

}

function checkAnswers() {

	choicesHTML = document.querySelectorAll("input[type=radio]");

	for(var i=0; i<choicesHTML.length; i++){
		if(choicesHTML[i].checked){
			choice = choicesHTML[i].value;
            scoreTotal = scoreTotal + parseInt(choicesHTML[i].value);
		}
	}

	pos=pos+6;
    pages++;

	renderQuestions();
}

$("td").click(function () {
   $(this).find('input:radio').attr('checked', true);
});

window.addEventListener("load", startTest, false);
</script>

</div>

<?php require "footer.php";?>

</body>
</html>