<% 
   Function yzhy(riqi)
   Dim fqArr
   rq=riqi
  set fo=server.CreateObject("scripting.filesystemobject")
 ' SkipLs=DateDiff("d","1921-2-10",rq)
  'response.Write(skipls)
  path=server.MapPath(".")
  path=path&"\"&"yinyang1.0.txt"
  on error resume next
  Nlyear=left(rq,4)
  Skipls=(cint(Nlyear)-1921)*360
  
   set fn=fo.opentextfile(path)
    for i=1 to skipls
      fn.skipline
    next
	Flag=true
  while (not Fn.atendofStream) and Flag
  rqStr=fn.readline
  rqStr=replace(rqStr,"--","-")
  fqArr=split(rqStr,"*")
  if(fqArr(0)=rq) then
  Flag=false
  end if
  
  yzhy=FqArr(1)
  wend
  'response.Write(skipls)
 

  'if trim(fqArr(0))=riqi then
  yzhy=trim(fqarr(1))
  'end if
  
If Err Then
	err.Clear
	Response.Write "<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>"
	Response.Write "<title>欢迎使用来算网www.114xk.cn提供的在线算命系统</title>"
	Response.Write "<LINK href='new.css' rel=stylesheet type=text/css>"
	Response.Write "<p>&nbsp;<p>&nbsp;<p align=center>Sorry!您刚才输入的阴历日期 <b>"&riqi&" </b>是错误的。<p>&nbsp;<p>"
	Response.Write "<p align=center>"&now()
	Response.Write "<script> "&chr(10)
	Response.Write "alert(""对不起，您的日期输入出错了，请返回重新输入...."")"&chr(10)
	Response.Write "location.href = 'javascript:history.back()'"&chr(10)
	Response.Write ""
	Response.Write "</script>"&chr(10)
	Response.end
End If

'response.Write(err.description)
  fn.close
  End Function
  
 'response.Write(yzhy("1993-12-8"))
 'call yzhy("1993-12-8")
%>

