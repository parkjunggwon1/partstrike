var target;
var pop_top;
var pop_left;
var cal_Day;
//var oPopup = window.createPopup();
document.write("<div id='oPopup' style=\"border:solid black 1px;background:buttonface; margin:5; padding:5;border:1 solid buttonshadow;width:160px;visibility:hidden;position: absolute; z-index:2\"></div>");

function Calendar_Click(e) {
	var oPopup = document.getElementById("oPopup");
	cal_Day = e.title;
	if (cal_Day.length > 6) {
		if (cal_Day=="deletedate"){
			cal_Day="";
		}
		target.value = cal_Day
	}
	oPopup.style.visibility = 'hidden';
}

function Calendar_D(obj,x,y) {
	var oPopup = document.getElementById("oPopup");
	if(oPopup.style.visibility=="visible"){
		oPopup.style.visibility="hidden";
	}else{
		var bodyElement = document.documentElement.scrollTop?document.documentElement:document.body;
		var now = obj.value.split("-");
		target = obj;
/*
	    x = (document.layers) ? loc.pageX : event.clientX;
	    y = (document.layers) ? loc.pageY : event.clientY;
	    
	    x = Event.pointer(event).x; 
	    y = Event.pointer(event).y;
*/
		oPopup.style.top    = (y+7+document.body.scrollTop+document.documentElement.scrollTop)+"px";
	    oPopup.style.left    = (x-50+document.body.scrollLeft+document.documentElement.scrollLeft)+"px";


		if (now.length == 3) {
			Show_cal(now[0],now[1],now[2]);					
		} else {
			now = new Date();
			Show_cal(now.getFullYear(), now.getMonth()+1, now.getDate());
		}
	}
}

function Calendar_M(obj,x,y) {
	var oPopup = document.getElementById("oPopup");
	if(oPopup.style.visibility=="visible"){
		oPopup.style.visibility="hidden";
	}else{
		var bodyElement = document.documentElement.scrollLeft?document.documentElement:document.body;
		var now = obj.value.split("-");
		target = obj;
		//pop_top = bodyElement.clientTop + GetObjectTop(obj) - bodyElement.scrollTop;
		//pop_left = bodyElement.clientLeft + GetObjectLeft(obj) -  bodyElement.scrollLeft;

		//pop_top = (y+7+document.body.scrollTop+document.documentElement.scrollTop)+"px";
		//pop_left = (x-50+document.body.scrollLeft+document.documentElement.scrollLeft)+"px";
		oPopup.style.top    = (y+7+document.body.scrollTop+document.documentElement.scrollTop)+"px";
	    oPopup.style.left    = (x-50+document.body.scrollLeft+document.documentElement.scrollLeft)+"px";

		if (now.length == 2) {
			Show_cal_M(now[0],now[1]);					
		} else {
			now = new Date();
			Show_cal_M(now.getFullYear(), now.getMonth()+1);
		}
	}
}

function doOver(el) {
	cal_Day = el.title;

	if (cal_Day.length > 7) {
		el.style.borderColor = "#FF0000";
	}
}

function doOut(el) {
	cal_Day = el.title;

	if (cal_Day.length > 7) {
		el.style.borderColor = "#FFFFFF";
	}
}

function day2(d) {
	var str = new String();
	
	if (parseInt(d) < 10) {
		str = "0" + parseInt(d);
	} else {
		str = "" + parseInt(d);
	}
	return str;
}

function Show_cal(sYear, sMonth, sDay) {
	var Months_day = new Array(0,31,28,31,30,31,30,31,31,30,31,30,31)
	var Month_Val = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
	var intThisYear = new Number(), intThisMonth = new Number(), intThisDay = new Number();

	datToday = new Date();
	
	intThisYear = parseInt(sYear,10);
	intThisMonth = parseInt(sMonth,10);
	intThisDay = parseInt(sDay,10);
	
	if (intThisYear == 0) intThisYear = datToday.getFullYear();
	if (intThisMonth == 0) intThisMonth = parseInt(datToday.getMonth(),10)+1;
	if (intThisDay == 0) intThisDay = datToday.getDate();
	
	switch(intThisMonth) {
		case 1:
				intPrevYear = intThisYear -1;
				intPrevMonth = 12;
				intNextYear = intThisYear;
				intNextMonth = 2;
				break;
		case 12:
				intPrevYear = intThisYear;
				intPrevMonth = 11;
				intNextYear = intThisYear + 1;
				intNextMonth = 1;
				break;
		default:
				intPrevYear = intThisYear;
				intPrevMonth = parseInt(intThisMonth,10) - 1;
				intNextYear = intThisYear;
				intNextMonth = parseInt(intThisMonth,10) + 1;
				break;
	}
	intPPyear = intThisYear-1
	intNNyear = intThisYear+1

	NowThisYear = datToday.getFullYear();
	NowThisMonth = datToday.getMonth()+1;
	NowThisDay = datToday.getDate();
	
	datFirstDay = new Date(intThisYear, intThisMonth-1, 1);
	intFirstWeekday = datFirstDay.getDay();
	
	intThirdWeekday = intFirstWeekday;
	
	datThisDay = new Date(intThisYear, intThisMonth, intThisDay);
	
	
	intPrintDay = 1;
	secondPrintDay = 1;
	thirdPrintDay = 1;

	Stop_Flag = 0
	
	if ((intThisYear % 4)==0) {
		if ((intThisYear % 100) == 0) {
			if ((intThisYear % 400) == 0) {
				Months_day[2] = 29;
			}
		} else {
			Months_day[2] = 29;
		}
	}
	intLastDay = Months_day[intThisMonth];

	Cal_HTML = "<html><body>";
	Cal_HTML += "<form name='calendar'>";
	Cal_HTML += "<table id=Cal_Table border=0 bgcolor='#f4f4f4' cellpadding=1 cellspacing=1 width=100% style='font-size : 12;font-family:;'>";
	Cal_HTML += "<tr height='35' align=center bgcolor='#f4f4f4'>";
	Cal_HTML += "<td colspan=7 align=center>";
	Cal_HTML += "	<select name='selYear' STYLE='font-size:11;' OnChange='parent.fnChangeYearD(calendar.selYear.value, calendar.selMonth.value, "+intThisDay+")';>";
	for (var optYear=(intThisYear+5); optYear>(intThisYear-10); optYear--) {
		Cal_HTML += "		<option value='"+optYear+"' ";
		if (optYear == intThisYear) Cal_HTML += " selected>\n";
		else Cal_HTML += ">\n";
		Cal_HTML += optYear+"</option>\n";
	}
	Cal_HTML += "	</select>";
	Cal_HTML += "&nbsp;&nbsp;&nbsp;<a style='cursor:pointer;' OnClick='parent.Show_cal("+intPrevYear+","+intPrevMonth+","+intThisDay+");'>&lt;</a> ";
	Cal_HTML += "<select name='selMonth' STYLE='font-size:11;' OnChange='parent.fnChangeYearD(calendar.selYear.value, calendar.selMonth.value, "+intThisDay+")';>";
	for (var i=1; i<13; i++) {	
		Cal_HTML += "		<option value='"+Month_Val[i-1]+"' ";
		if (intThisMonth == parseInt(Month_Val[i-1],10)) Cal_HTML += " selected>\n";
		else Cal_HTML += ">\n";
		Cal_HTML += Month_Val[i-1]+"</option>\n";
	}
	Cal_HTML += "	</select>&nbsp;";
	Cal_HTML += "<a style='cursor:pointer;' OnClick='parent.Show_cal("+intNextYear+","+intNextMonth+","+intThisDay+");'>&gt;</a>";
	Cal_HTML += "</td></tr>";
	Cal_HTML += "<tr align=center bgcolor='#87B3D6' style='color:#2065DA;' height='25'>";
	Cal_HTML += "	<td style='padding-top:3px;' width='24'><font color=black>일</font></td>";
	Cal_HTML += "	<td style='padding-top:3px;' width='24'><font color=black>월</font></td>";
	Cal_HTML += "	<td style='padding-top:3px;' width='24'><font color=black>화</font></td>";
	Cal_HTML += "	<td style='padding-top:3px;' width='24'><font color=black>수</font></td>";
	Cal_HTML += "	<td style='padding-top:3px;' width='24'><font color=black>목</font></td>";
	Cal_HTML += "	<td style='padding-top:3px;' width='24'><font color=black>금</font></td>";
	Cal_HTML += "	<td style='padding-top:3px;' width='24'><font color=black>토</font></td>";
	Cal_HTML += "</tr>";
		
	for (intLoopWeek=1; intLoopWeek < 7; intLoopWeek++) {
		Cal_HTML += "<tr height='24' align=right bgcolor='white'>"
		for (intLoopDay=1; intLoopDay <= 7; intLoopDay++) {
			if (intThirdWeekday > 0) {
				Cal_HTML += "<td>";
				intThirdWeekday--;
			} else {
				if (thirdPrintDay > intLastDay) {
					Cal_HTML += "<td>";
				} else {
					Cal_HTML += "<td onClick=parent.Calendar_Click(this); title="+intThisYear+"-"+day2(intThisMonth).toString()+"-"+day2(thirdPrintDay).toString()+" style=\"cursor:pointer;border:1px solid white;";
					if (intThisYear == NowThisYear && intThisMonth==NowThisMonth && thirdPrintDay==intThisDay) {
						Cal_HTML += "background-color:#C6F2ED;";
					}
					
					switch(intLoopDay) {
						case 1:
							Cal_HTML += "color:red;"
							break;
						//case 7:
						//	Cal_HTML += "color:blue;"
						//	break;
						default:
							Cal_HTML += "color:black;"
							break;
					}
					Cal_HTML += "\">"+thirdPrintDay;
				}
				thirdPrintDay++;
				
				if (thirdPrintDay > intLastDay) {
					Stop_Flag = 1;
				}
			}
			Cal_HTML += "</td>";
		}
		Cal_HTML += "</tr>";
		if (Stop_Flag==1) break;
	}
	Cal_HTML += "<tr height='20' align=center bgcolor='#f4f4f4'>";
	Cal_HTML += "<td colspan=2></td><td colspan=3 align=center onClick=parent.Calendar_Click(this); title='deletedate' style='cursor:pointer;border:1px solid white;background-color:#C6F2ED;'>";
	Cal_HTML += "일자삭제";
	Cal_HTML += "</td><td colspan=2></td></tr>";
	Cal_HTML += "</table></form></body></html>";

	var oPopup = document.getElementById("oPopup");
	oPopup.innerHTML = Cal_HTML;
	oPopup.style.visibility = "visible";
}


function Show_cal_M(sYear, sMonth) {
	var intThisYear = new Number(), intThisMonth = new Number()
	datToday = new Date();
	
	intThisYear = parseInt(sYear,10);
	intThisMonth = parseInt(sMonth,10);
	
	if (intThisYear == 0) intThisYear = datToday.getFullYear();
	if (intThisMonth == 0) intThisMonth = parseInt(datToday.getMonth(),10)+1;
			
	switch(intThisMonth) {
		case 1:
				intPrevYear = intThisYear -1;
				intNextYear = intThisYear;
				break;
		case 12:
				intPrevYear = intThisYear;
				intNextYear = intThisYear + 1;
				break;
		default: 
				intPrevYear = intThisYear;
				intNextYear = intThisYear;
				break;
	}
	intPPyear = intThisYear-1
	intNNyear = intThisYear+1

	Cal_HTML = "<html><head>\n";
	Cal_HTML += "</head><body>\n";
	Cal_HTML += "<table id=Cal_Table border=0 bgcolor='#f4f4f4' cellpadding=1 cellspacing=1 width=100% onmouseover='parent.doOver(event.srcElement)' onmouseout='parent.doOut(event.srcElement)' style='font-size : 12;font-family:;'>\n";
	Cal_HTML += "<tr height='30' align=center bgcolor='#f4f4f4'>\n";
	Cal_HTML += "<td colspan='4' align='center'>\n";
	Cal_HTML += "<a style='cursor:pointer;' OnClick='parent.Show_cal_M("+intPPyear+","+intThisMonth+");'>&lt;&lt;</a>&nbsp;";
	Cal_HTML += "<select name='selYear' STYLE='font-size:11;' OnChange='parent.fnChangeYearM(this.value, "+intThisMonth+")';>";
	for (var optYear=(intThisYear-2); optYear<(intThisYear+2); optYear++) {
			Cal_HTML += "		<option value='"+optYear+"' ";
			if (optYear == intThisYear) Cal_HTML += " selected>\n";
			else Cal_HTML += ">\n";
			Cal_HTML += optYear+"</option>\n";
	}
	Cal_HTML += "	</select>\n";
	Cal_HTML += "<a style='cursor:pointer;' OnClick='parent.Show_cal_M("+intNNyear+","+intThisMonth+");'>&gt;</a>";
	Cal_HTML += "</td></tr>\n";
	Cal_HTML += "<tr><td colspan=4 height='1' bgcolor='#000000'></td></tr>";
	Cal_HTML += "<tr height='20' align=center bgcolor=white>";
	Cal_HTML += "<td onClick=parent.Calendar_Click(this); title="+intThisYear+"-01"+" style=\"cursor:pointer;\">1월</td>";
	Cal_HTML += "<td onClick=parent.Calendar_Click(this); title="+intThisYear+"-02"+" style=\"cursor:pointer;\">2월</td>";
	Cal_HTML += "<td onClick=parent.Calendar_Click(this); title="+intThisYear+"-03"+" style=\"cursor:pointer;\">3월</td>";
	Cal_HTML += "<td onClick=parent.Calendar_Click(this); title="+intThisYear+"-04"+" style=\"cursor:pointer;\">4월</td>";
	Cal_HTML += "</tr>\n";
	Cal_HTML += "<tr height='20' align=center bgcolor=white>";
	Cal_HTML += "<td onClick=parent.Calendar_Click(this); title="+intThisYear+"-05"+" style=\"cursor:pointer;\">5월</td>";
	Cal_HTML += "<td onClick=parent.Calendar_Click(this); title="+intThisYear+"-06"+" style=\"cursor:pointer;\">6월</td>";
	Cal_HTML += "<td onClick=parent.Calendar_Click(this); title="+intThisYear+"-07"+" style=\"cursor:pointer;\">7월</td>";
	Cal_HTML += "<td onClick=parent.Calendar_Click(this); title="+intThisYear+"-08"+" style=\"cursor:pointer;\">8월</td>";
	Cal_HTML += "</tr>\n";
	Cal_HTML += "<tr height='20' align=center bgcolor=white>";
	Cal_HTML += "<td onClick=parent.Calendar_Click(this); title="+intThisYear+"-09"+" style=\"cursor:pointer;\">9월</td>";
	Cal_HTML += "<td onClick=parent.Calendar_Click(this); title="+intThisYear+"-10"+" style=\"cursor:pointer;\">10월</td>";
	Cal_HTML += "<td onClick=parent.Calendar_Click(this); title="+intThisYear+"-11"+" style=\"cursor:pointer;\">11월</td>";
	Cal_HTML += "<td onClick=parent.Calendar_Click(this); title="+intThisYear+"-12"+" style=\"cursor:pointer;\">12월</td>";
	Cal_HTML += "</tr>\n";
	Cal_HTML += "</table>\n</body></html>";

	var oPopup = document.getElementById("oPopup");
	oPopup.innerHTML = Cal_HTML;
	oPopup.style.visibility = 'visible';
}


function fnChangeYearD(sYear,sMonth,sDay){
	Show_cal(sYear, sMonth, sDay);
}

function fnChangeYearM(sYear,sMonth){
	Show_cal_M(sYear, sMonth);
}

function GetObjectTop(obj)
{
    var ret = new Object(); 
	var bodyElement = document.documentElement.scrollLeft?document.documentElement:document.body;
	if(obj.getBoundingClientRect){
        var rect = obj.getBoundingClientRect(); 
        ret.top = rect.top;
	}else if(document.getBoxObjectFor){ //FF2 
        var box = document.getBoxObjectFor(obj); 
        ret.top = box.y; 
    }else if(document.all && obj.getBoundingClientRect) {  //IE
        var rect = obj.getBoundingClientRect(); 
    }else{ //OPERA,SAFARI
		var rect = new Object();
		ret.top = obj.offsetTop;
		var parent = obj.offsetParent;
		while(parent != bodyElement && parent){
			ret.top += parent.offsetTop;
			parent = parent.offsetParent;
		}
	}
    return ret.top; 
}

function GetObjectLeft(obj)
{
    var ret = new Object(); 
	var bodyElement = document.documentElement.scrollLeft?document.documentElement:document.body;
	if(obj.getBoundingClientRect){
        var rect = obj.getBoundingClientRect(); 
        ret.left = rect.left;
	}else if(document.getBoxObjectFor){ //FF2 
        var box = document.getBoxObjectFor(obj); 
        ret.left = box.x; 
    }else if(document.all && obj.getBoundingClientRect) {  //IE
        var rect = obj.getBoundingClientRect(); 
    }else{ //OPERA,SAFARI
		var rect = new Object();
		ret.left = obj.offsetLeft;
		var parent = obj.offsetParent;
		while(parent != bodyElement && parent){
			ret.left += parent.offsetLeft;
			parent = parent.offsetParent;
		}
	}
    return ret.left; 
}
