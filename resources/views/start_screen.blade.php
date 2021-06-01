<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>Guess Words</title>

<style>
 @import url('https://fonts.googleapis.com/css?family=Poppins');

/* BASIC */


body {
  font-family: "Poppins", sans-serif;
  height: 100vh;
  background: url('https://projects.funtash.net/lms/source/public/uploads/images/bg15.png');


  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;


  top: 0;

  left: 0;

  bottom: 0;

  right: 0;

  

  z-index: -1;   
}

a {
  color: #92badd;
  display:inline-block;
  text-decoration: none;
  font-weight: 400;
}

h2 {
  text-align: center;
  font-size: 16px;
  font-weight: 600;
  text-transform: uppercase;
  display:inline-block;
  margin: 40px 8px 10px 8px; 
  color: #cccccc;
}



/* STRUCTURE */

.wrapper {
  display: flex;
  align-items: center;
  flex-direction: column; 
  justify-content: center;
  width: 100%;
  min-height: 100%;
  padding: 20px;

}

#formContent {
   -webkit-border-radius: 10px 10px 10px 10px;
  border-radius: 10px 10px 10px 10px;

  padding: 30px;
  width: 90%;
  max-width: 550px;
  position: relative;
  padding: 0px;

  text-align: center;
}

#formFooter {
  background-color: #f6f6f6;
  border-top: 1px solid #dce8f1;
  padding: 25px;
  text-align: center;
  -webkit-border-radius: 0 0 10px 10px;
  border-radius: 0 0 10px 10px;
}



/* TABS */

h2.inactive {
  color: #cccccc;
}

h2.active {
  color: #121d5c;
  border-bottom: 2px solid #121d5c;
}



/* FORM TYPOGRAPHY*/

input[type=button], input[type=submit], input[type=reset]  {
  background-color: #121d5c;
  border: none;
  cursor: pointer;
  color: white;
  padding: 15px 80px;
  text-align: center;
  text-decoration: none;
  text-transform: uppercase;
  font-size: 13px;
  -webkit-box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
  box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
  -webkit-border-radius: 5px 5px 5px 5px;
  border-radius: 5px 5px 5px 5px;
  margin: 5px 20px 40px 20px;
  -webkit-transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  -ms-transition: all 0.3s ease-in-out;
  -o-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;
}

input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover  {
  background-color: #39ace7;
}

input[type=button]:active, input[type=submit]:active, input[type=reset]:active  {
  -moz-transform: scale(0.95);
  -webkit-transform: scale(0.95);
  -o-transform: scale(0.95);
  -ms-transform: scale(0.95);
  transform: scale(0.95);
}



input[type=email] {
  background-color: #f6f6f6;
  border: none;
  color: #0d0d0d;
  padding: 15px 32px;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 5px;
  width: 85%;
  border: 2px solid #f6f6f6;
  -webkit-transition: all 0.5s ease-in-out;
  -moz-transition: all 0.5s ease-in-out;
  -ms-transition: all 0.5s ease-in-out;
  -o-transition: all 0.5s ease-in-out;
  transition: all 0.5s ease-in-out;
  -webkit-border-radius: 5px 5px 5px 5px;
  border-radius: 5px 5px 5px 5px;
}

input[type=email]:focus {
  background-color: #fff;
  border-bottom: 2px solid #5fbae9;
}

input[type=email]:placeholder {
  color: #cccccc;
}



input[type=password] {
  background-color: #f6f6f6;
  border: none;
  color: #0d0d0d;
  padding: 15px 32px;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 5px;
  width: 85%;
  border: 2px solid #f6f6f6;
  -webkit-transition: all 0.5s ease-in-out;
  -moz-transition: all 0.5s ease-in-out;
  -ms-transition: all 0.5s ease-in-out;
  -o-transition: all 0.5s ease-in-out;
  transition: all 0.5s ease-in-out;
  -webkit-border-radius: 5px 5px 5px 5px;
  border-radius: 5px 5px 5px 5px;
}

input[type=password]:focus {
  background-color: #fff;
  border-bottom: 2px solid #5fbae9;
}

input[type=password]:placeholder {
  color: #cccccc;
}



/* ANIMATIONS */

/* Simple CSS3 Fade-in-down Animation */
.fadeInDown {
  -webkit-animation-name: fadeInDown;
  animation-name: fadeInDown;
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}

@-webkit-keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}

@keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}

/* Simple CSS3 Fade-in Animation */
@-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

.fadeIn {
  opacity:0;
  -webkit-animation:fadeIn ease-in 1;
  -moz-animation:fadeIn ease-in 1;
  animation:fadeIn ease-in 1;

  -webkit-animation-fill-mode:forwards;
  -moz-animation-fill-mode:forwards;
  animation-fill-mode:forwards;

  -webkit-animation-duration:1s;
  -moz-animation-duration:1s;
  animation-duration:1s;
}

.fadeIn.first {
  -webkit-animation-delay: 0.4s;
  -moz-animation-delay: 0.4s;
  animation-delay: 0.4s;
}

.fadeIn.second {
  -webkit-animation-delay: 0.6s;
  -moz-animation-delay: 0.6s;
  animation-delay: 0.6s;
}

.fadeIn.third {
  -webkit-animation-delay: 0.8s;
  -moz-animation-delay: 0.8s;
  animation-delay: 0.8s;
}

.fadeIn.fourth {
  -webkit-animation-delay: 1s;
  -moz-animation-delay: 1s;
  animation-delay: 1s;
}

/* Simple CSS3 Fade-in Animation */
.underlineHover:after {
  display: block;
  left: 0;
  bottom: -10px;
  width: 0;
  height: 2px;
  background-color: #121d5c;
  content: "";
  transition: width 0.2s;
}

.underlineHover:hover {
  color: #121d5c;
}

.underlineHover:hover:after{
  width: 100%;
}



/* OTHERS */

*:focus {
    outline: none;
} 

#icon {
  width:60%;
}

* {
  box-sizing: border-box;
}
.link_button {
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    border: solid 1px #D8AA4A;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.4);
    -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
    background: #D8AA4A;
    color: #FFF;
    padding: 8px 12px;
    text-decoration: none;
}
.alphabet {
list-style-type: none;
    margin:0px auto 0;
    padding:0;
    cursor: pointer;
    width:100%;
    text-align:center;
}

.alphabet li {
float:left;
    margin:0;
    padding:0;
    border-right:1px solid darkgrey;
    font-size: 13px;
    font-family:Verdana;
    -moz-box-sizing:border-box;
    color:black;
    display:inline-block;
    -webkit-box-sizing:border-box;
    -moz-box-sizing:border-box;
    box-sizing:border-box;
    width:3.6%;
}

.alphabet li:last-child {
  border-right: none;
}

.alphabet li:hover {
  color: #005bab;
  background-color: #e2ecf6;
}

.bottombar1{
       content: "";
       display:block;
       height:0.7em;
       width:100%;
       background-color:#00688B;
}

#panelA,#panelB,#panelC,#panelD,#panelE,#panelF,#panelG,#panelH,
#panelI,#panelJ,#panelK,#panelL,#panelM,#panelN,#panelO,#panelP,
#panelQ,#panelR,#panelS,#panelT,#panelU,#panelV,#panelW,#panelX,
#panelY,#panelZ,#panelnumber {
  display: none;
}

#panelA,#panelB,#panelC,#panelD,#panelE,#panelF,#panelG,#panelH,
#panelI,#panelJ,#panelK,#panelL,#panelM,#panelN,#panelO,#panelP,
#panelQ,#panelR,#panelS,#panelT,#panelU,#panelV,#panelW,#panelX,
#panelY,#panelZ, #panelnumber {
    display: none;
    font-size: 16px;
    text-align: center;
    background-color:#e2ecf6;
    border-style:solid;
    border-width:1px;
    padding-top:5px;
    padding-bottom:5px;
    border-color:transparent;
    color: #005bab;
    margin: auto;
}
.txt {
  line-height: 1.3;
  font-size: 16px;
  width: 500px;
  background-color: #eee;
  padding: 10px;
}

.break {
  word-break: break-all;
}
.div {
display:inline-block;
width:100px;
height:80px;
margin:0;
padding:0;
padding-top: 20px;
border:0;
font-size: 25px;
font-weight: bold;
text-decoration-color: #fff
}
#one {
background:#AA8559;
}
#two {
background:#dbdad9;
}
#three {
background:#dbdad9;
}

</style>

</head>
<body>

<div class="wrapper fadeInDown" id="refresh_all_requests" style="padding-top: 60px">

</div>
<script type="text/javascript">
  
    function Reload() {
       
        setTimeout(function () { 
            document.location.reload(true); }, 100);    
    }


</script>
<script type="text/javascript">

var buttons = document.querySelectorAll("#alpha button");
var characters = document.getElementById("characters").value;
var translation = document.getElementById("translation").value;


document.addEventListener('dragstart', function (event) {
event.dataTransfer.setData('Text', event.target.innerHTML);
});

document.addEventListener('dragend', function (event) {
event.dataTransfer.setData('Text', event.target.innerHTML);

document.getElementById("checks").value +=event.target.innerHTML;    


var test2 = document.getElementById("checks").value;
var characters2 =document.getElementById("characters").value;

if(test2.length > characters2){
document.getElementById("checks").value ='';

}else if(test2.length == characters2){

  setTimeout(function(){
  checking();
  }, 500); // seconds to wait, miliseconds
}
});

function checking() {
 var ae = document.getElementById("checks").value;
 var test = ae.toLowerCase();

if (ae.length > characters) {
var a = document.getElementById("checks").value = '';

}

if(test == translation){
playAudio();
}

}

// seconds to wait, miliseconds

var title = document.getElementById("title").innerHTML;

var next = document.getElementById("next");
/*for(var i =0; i < buttons.length; i++){

var btn = buttons[i];
btn.addEventListener("click", function() {

var a = document.getElementById("one").value += this.innerHTML;

var color = document.getElementById("one").style.color;
color = (color=="#775329") ? "#775329" : "#775329" ;
document.getElementById("one").style.color= color;

var test = a.toLowerCase();
   
if (a.length > characters) {
var a = document.getElementById("one").innerHTML = this.innerHTML;
}

if(test == translation){

playAudio();

}

});
}
*/

var x = document.getElementById("myAudio"); 

function playAudio() { 
  x.play(); 
} 

function pauseAudio() { 
  x.pause(); 
} 

function clear(){
      document.getElementById("one").innerHTML = '';
      document.getElementById("one").value = '';
}



function removeTextTag()
{
 
var strng=document.getElementById("checks").value;
document.getElementById("checks").value=strng.substring(0,strng.length-1)

var strng2=document.getElementById("one").value;
document.getElementById("one").value=strng.substring(0,strng2.length-1)

}

</script>
<script type="text/javascript">
  document.addEventListener('gesturestart', function(e) {
    e.preventDefault();
    // special hack to prevent zoom-to-tabs gesture in safari
    document.body.style.zoom = 0.99;
});

document.addEventListener('gesturechange', function(e) {
    e.preventDefault();
    // special hack to prevent zoom-to-tabs gesture in safari
    document.body.style.zoom = 0.99;
});

document.addEventListener('gestureend', function(e) {
    e.preventDefault();
    // special hack to prevent zoom-to-tabs gesture in safari
    document.body.style.zoom = 0.99;
});
</script>
</body>
</html>