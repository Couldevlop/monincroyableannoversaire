


<div class="banner">
<div class="bannermarqu">
<script type="text/javascript" language="javascript">
var sliderwidth="1400px"
var sliderheight="55px"
var slidespeed=2
slidebgcolor=null
var leftrightslide=new Array();
var finalslide=''
 
leftrightslide[0]='<img src="images/1.png" align="texttop">'

leftrightslide[1]='<img src="images/2.png" align="texttop">'
leftrightslide[2]='<img src="images/3.png" align="texttop">'
leftrightslide[3]='<img src="images/4.png" align="texttop">'
leftrightslide[4]='PLEINS DE SUPERS CADEAUX A GAGNER!'
leftrightslide[5]='<img src="images/1.png" align="texttop">'
leftrightslide[6]='<img src="images/2.png" align="texttop">'
leftrightslide[7]='<img src="images/3.png" align="texttop">'
leftrightslide[8]='<img src="images/4.png" align="texttop">'

var imagegap=" "
var slideshowgap=2
var copyspeed=slidespeed
leftrightslide='<nobr>'+leftrightslide.join(imagegap)+'</nobr>'
var iedom=document.all||document.getElementById
if (iedom)
document.write('<span id="temp" style="visibility:hidden;position:absolute;top:-100px;left:-9000px">'+leftrightslide+'</span>')
var actualwidth=''
var cross_slide, ns_slide

function fillup(){
if (iedom){
cross_slide=document.getElementById? document.getElementById("test2") : document.all.test2
cross_slide2=document.getElementById? document.getElementById("test3") : document.all.test3
cross_slide.innerHTML=cross_slide2.innerHTML=leftrightslide
actualwidth=document.all? cross_slide.offsetWidth : document.getElementById("temp").offsetWidth
cross_slide2.style.left=actualwidth+slideshowgap+"px"
}
else if (document.layers){
ns_slide=document.ns_slidemenu.document.ns_slidemenu2
ns_slide2=document.ns_slidemenu.document.ns_slidemenu3
ns_slide.document.write(leftrightslide)
ns_slide.document.close()
actualwidth=ns_slide.document.width
ns_slide2.left=actualwidth+slideshowgap
ns_slide2.document.write(leftrightslide)
ns_slide2.document.close()
}
lefttime=setInterval("slideleft()",30)


if (iedomuser){
cross_slideuser=document.getElementById? document.getElementById("test2user") : document.all.test2user
cross_slideuser2=document.getElementById? document.getElementById("test3user") : document.all.test3user
cross_slideuser.innerHTML=cross_slideuser2.innerHTML=leftrightslideuser
actualwidthuser=document.all? cross_slideuser.offsetWidth : document.getElementById("tempuser").offsetWidth
cross_slideuser2.style.left=actualwidthuser+slideshowgapuser+"px"
}
else if (document.layers){
ns_slideuser=document.ns_slideusermenu.document.ns_slideusermenu2user
ns_slideuser2=document.ns_slideusermenu.document.ns_slideusermenu3user
ns_slideuser.document.write(leftrightslideuser)
ns_slideuser.document.close()
actualwidthuser=ns_slideuser.document.width
ns_slideuser2.left=actualwidthuser+slideshowgapuser
ns_slideuser2.document.write(leftrightslideuser)
ns_slideuser2.document.close()
}
lefttime=setInterval("slideleftuser()",30)


if (iedomthum){
cross_slidethum=document.getElementById? document.getElementById("test2thum") : document.all.test2thum
cross_slidethum2=document.getElementById? document.getElementById("test3thum") : document.all.test3thum
cross_slidethum.innerHTML=cross_slidethum2.innerHTML=leftrightslidethum
actualwidththum=document.all? cross_slidethum.offsetWidth : document.getElementById("tempthum").offsetWidth
cross_slidethum2.style.left=actualwidththum+slideshowgapthum+"px"
}
else if (document.layers){
ns_slidethum=document.ns_slidethummenu.document.ns_slidethummenu2
ns_slidethum2=document.ns_slidethummenu.document.ns_slidethummenu3
ns_slidethum.document.write(leftrightslidethum)
ns_slidethum.document.close()
actualwidththum=ns_slidethum.document.width
ns_slidethum2.left=actualwidththum+slideshowgapthum
ns_slidethum2.document.write(leftrightslidethum)
ns_slidethum2.document.close()
}
lefttime=setInterval("slideleftthum()",30)
}
window.onload=fillup

function slideleft(){
if (iedom){
if (parseInt(cross_slide.style.left)>(actualwidth*(-1)+10))
cross_slide.style.left=parseInt(cross_slide.style.left)-copyspeed+"px"
else
cross_slide.style.left=parseInt(cross_slide2.style.left)+actualwidth+slideshowgap+"px"

if (parseInt(cross_slide2.style.left)>(actualwidth*(-1)+10))
cross_slide2.style.left=parseInt(cross_slide2.style.left)-copyspeed+"px"
else
cross_slide2.style.left=parseInt(cross_slide.style.left)+actualwidth+slideshowgap+"px"

}
else if (document.layers){
if (ns_slide.left>(actualwidth*(-1)+10))
ns_slide.left-=copyspeed
else
ns_slide.left=ns_slide2.left+actualwidth+slideshowgap

if (ns_slide2.left>(actualwidth*(-1)+10))
ns_slide2.left-=copyspeed
else
ns_slide2.left=ns_slide.left+actualwidth+slideshowgap
}
}


if (iedom||document.layers){
with (document){
document.write('<table border="0" cellspacing="0" cellpadding="0"><td>')
if (iedom){
write('<div style="position:relative;width:'+sliderwidth+';height:'+sliderheight+';overflow:hidden">')
write('<div style="position:absolute;width:'+sliderwidth+';height:'+sliderheight+';background-color:'+slidebgcolor+'" onMouseover="copyspeed=0" onMouseout="copyspeed=slidespeed">')
write('<div id="test2" style="position:absolute;left:0px;top:0px"></div>')
write('<div id="test3" style="position:absolute;left:-1000px;top:0px"></div>')
write('</div></div>')
}
else if (document.layers){
write('<ilayer width='+sliderwidth+' height='+sliderheight+' name="ns_slidemenu" bgColor='+slidebgcolor+'>')
write('<layer name="ns_slidemenu2" left=0 top=0 onMouseover="copyspeed=0" onMouseout="copyspeed=slidespeed"></layer>')
write('<layer name="ns_slidemenu3" left=0 top=0 onMouseover="copyspeed=0" onMouseout="copyspeed=slidespeed"></layer>')
write('</ilayer>')
}
document.write('</td></table>')
}
}
</script>
</div>
</div>