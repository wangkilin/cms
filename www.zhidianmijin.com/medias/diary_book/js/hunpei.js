times=1;

function promptEntry(s)
{
  window.status = s;
  return true;
}

function warnInvalid ( field, s )
{
  field.focus();
  alert( s );
  return false;
}

function isEmpty( s )
{
  return ( ( s == null ) || ( s.length == 0 ) )
}

function isDigit( c )
{
  if ( isEmpty( c ) ) return true;
  else return ( ( c >= "0" ) && ( c <= "9" ) )
}

function isNumber(s)
{
  if ( isEmpty(s) ) return true;
  for( var i = 0; i < s.length; i++ )
  {
    if ( !isDigit( s.charAt(i) ) ) return false;
  }
  return true;
}

function isWhitespace (s)
{   
    var whitespace = " \t\n\r";
    if ( isEmpty(s) ) return true;
    for ( var i = 0; i < s.length; i++ )
    {
        var c = s.charAt(i);
        if ( whitespace.indexOf ( c ) == -1 ) return false;
    }
    return true;
}

function checkEmpty ( field, alias )
{
  if ( isEmpty( field.value ) || isWhitespace( field.value ) )
  {
    return warnInvalid( field, alias );
  }
  return true;
}

function onClick_hunpei( form )
{
  if ( checkEmpty ( form.mname, "请输入男方姓名！" ) && checkEmpty ( form.fname, "请输入女方姓名！" )){
    if ( checkDate( form.myear, form.mmonth, form.mday, "date of male" ) &&
       checkDate( form.fyear, form.fmonth, form.fday, "date of female" ) )
    {
      var mchart = getChart( form.myear, form.mmonth, form.mday );
      if ( mchart == "00" )
      {
        alert( "出生日期不对！" );
        return false;
      }

      var fchart = getChart( form.fyear, form.fmonth, form.fday );
      if ( fchart == "00" )
      {
        alert( "出生日期不对！" );
        return false;
      }

      if((98-parseInt(form.myear.value))<6 || (98-parseInt(form.fyear.value))<6){
        alert("对不起，少儿不宜!");
        return false;
      }

        form.male.value = mchart;
        form.female.value = fchart;
        document.hunpei.getInfo(form.male.value,form.female.value);
        return true;
   
    } 
  }
  else
    return false;
}

function getChart( field1, field2, field3 )
{
  var date;

  if ( field1.value.length == 1 ) date = "0" + field1.value;
  else date = field1.value;

  if ( field2.value.length == 1 ) date = date + "0" + field2.value;
  else date = date + field2.value;

  if ( field3.value.length == 1 ) date = date + "0" + field3.value;
  else date = date + field3.value;

  if ( date >= 240205 && date < 250123 ||
       date >= 360124 && date < 370210 ||
       date >= 480210 && date < 490128 ||
       date >= 600128 && date < 610214 ||
       date >= 720215 && date < 730202 ||
       date >= 840202 && date < 850219 ||
       date >= 960219 && date < 970206 )
    return "01";
  else if ( date >= 250124 && date < 260212 ||
       date >= 370211 && date < 380130 ||
       date >= 490129 && date < 500216 ||
       date >= 610215 && date < 620204 ||
       date >= 730203 && date < 740122 ||
       date >= 850220 && date < 860208 )
    return "02";
  else if ( date >= 260213 && date < 270201 ||
       date >= 380131 && date < 390218 ||
       date >= 500217 && date < 510205 ||
       date >= 620205 && date < 630124 ||
       date >= 740128 && date < 750210 ||
       date >= 860209 && date < 870128 )
    return "03";
  else if ( date >= 270202 && date < 280122 ||
       date >= 390219 && date < 400207 ||
       date >= 510206 && date < 520126 ||
       date >= 630125 && date < 640212 ||
       date >= 750211 && date < 760130 ||
       date >= 870129 && date < 880216 )
    return "04";
  else if ( date >= 280123 && date < 290209 ||
       date >= 400208 && date < 410126 ||
       date >= 520127 && date < 530213 ||
       date >= 640213 && date < 650201 ||
       date >= 760131 && date < 770217 ||
       date >= 880217 && date < 890205 )
    return "05";
  else if ( date >= 290210 && date < 300129 ||
       date >= 410127 && date < 420214 ||
       date >= 530214 && date < 540202 ||
       date >= 650202 && date < 660120 ||
       date >= 770218 && date < 780206 ||
       date >= 890206 && date < 900126 )
    return "06";
  else if ( date >= 300130 && date < 310216 ||
       date >= 420215 && date < 430204 ||
       date >= 540203 && date < 550123 ||
       date >= 660121 && date < 670209 ||
       date >= 780207 && date < 790127 ||
       date >= 900227 && date < 910214 )
    return "07";
  else if ( date >= 310217 && date < 320205 ||
       date >= 430205 && date < 440124 ||
       date >= 550124 && date < 560211 ||
       date >= 670209 && date < 680129 ||
       date >= 790128 && date < 800215 ||
       date >= 910215 && date < 920203 )
    return "08";
  else if ( date >= 320206 && date < 330125 ||
       date >= 440125 && date < 450212 ||
       date >= 560212 && date < 570130 ||
       date >= 680130 && date < 690216 ||
       date >= 800216 && date < 810204 ||
       date >= 920204 && date < 930122 )
    return "09";
  else if ( date >= 210208 && date < 220127 ||
       date >= 330126 && date < 340213 ||
       date >= 450213 && date < 460201 ||
       date >= 570131 && date < 580217 ||
       date >= 690217 && date < 700205 ||
       date >= 810205 && date < 820124 )
    return "10";
  else if ( date >= 220128 && date < 230215 ||
       date >= 340214 && date < 350203 ||
       date >= 460202 && date < 470121 ||
       date >= 580218 && date < 590207 ||
       date >= 700206 && date < 710126 ||
       date >= 820125 && date < 830212 )
    return "11";
  else if ( date >= 230216 && date < 240204 ||
       date >= 350204 && date < 360123 ||
       date >= 470122 && date < 480209 ||
       date >= 590208 && date < 600127 ||
       date >= 710127 && date < 720214 ||
       date >= 830213 && date < 840201 )
    return "12";
  else return "00";
}

function checkDate( field1, field2, field3, alias )
{
  var year  = field1.value;
  var month = field2.value;
  var day   = field3.value;

  if ( isEmpty( year ) || isEmpty( month ) || isEmpty( day ) ||
      !isNumber( year ) || !isNumber( month ) || !isNumber( day ) )
  {
    alert( "出生日期不对！" );
    return false;
  }

  if ( month == 1 || month == 3 || month == 5 || month == 7
    || month == 8 || month == 10 || month == 12 )
  {
    if ( day >= 1 && day <= 31 ) return true;
  }
  else if ( month == 4 || month == 6 || month == 9 || month == 11 )
  {
    if ( day >= 1 && day <= 30 ) return true;
  }
  else if ( month == 2 )
  {
    var dayInFeb = ( (year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0) ) ) ? 29 : 28;
    if ( day >= 1 && day <= dayInFeb ) return true;
  }

  alert( "出生日期不对！" );
  return false;
}