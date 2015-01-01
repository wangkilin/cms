<%
on error resume next
'得到文件二进制数据
Function GetWebData(byval strUrl)
dim curlpath
dim Retrieval
  Set Retrieval = Server.CreateObject("Microsoft.XMLHTTP")
  With Retrieval
    .Open "Get", strUrl, False,"",""
    .Send
    GetWebData =.ResponseBody
  End With
  Set Retrieval = Nothing
End Function

'将数据保存成文件
Sub SaveFile(FileName,Data,Path)
Dim Ads
 Set ads=server.CreateObject("ado"&"db."&"stre"&"am")
  With ads
    .Type=1
    .Open
    .Write Data
    .SaveToFile server.MapPath(Path&"/"&FileName),2
    .Cancel()
    .Close()
  End With
  Set Ads=nothing
End Sub






'取得文件地址
Function GetFile(FileUrl,FilePath)
Dim AryFileName,Ary
  AryFileName=split(FileUrl,"/")
  Call  SaveFile(AryFileName(Ubound(AryFileName)),GetWebData(FileUrl),FilePath)
End Function


'取网页数据
Function GetHttp(url) 
Dim Retrieval,GetBody
  Set Retrieval = CreateObject("Microsoft.XMLHTTP") 
  Retrieval.Open "Get", url, False
  Retrieval.Send
  if Retrieval.status <> 404 then
    GetBody=Retrieval.ResponseBody 
  GetHttp=BytesToBstr(GetBody)
else
  If Starid=31 Then
   Response.write "ID编号 &nbsp;"&id&"&nbsp;目标地址不存在"
    Response.write "<A HREF=""?act=cj&id1="&id1&"&id2="&nextid&"&Starid=1&Co=1'""""><FONT  COLOR=#FF0000>继续采集下一月</FONT></A>"
 Else
  Response.write "ID编号 &nbsp;"&id&"&nbsp;目标地址不存在，跳转到下一个"
Response.write "<meta http-equiv=""refresh"" content=""0;url='?act=cj&id1="&id1+1&"&id2="&id2&"&Starid="&Starid+1&"&Co="&Co+1&"'"">"
End IF
   response.end
end if
  Set Retrieval = Nothing 
End function

'二进制转文本
Function BytesToBstr(body)
  Dim objstream
  Set objstream = Server.CreateObject("ado"&"db."&"stre"&"am")
  objstream.Type = 1
  objstream.Mode =3
  objstream.Open
  objstream.Write body
  objstream.Position = 0
  objstream.Type = 2
  objstream.Charset = "GB2312"
  BytesToBstr = objstream.ReadText 
  objstream.Close
set objstream = Nothing
End function





function DeHttpdata(sStr,Ptrn)
Dim regEx,aData,RetStr,Match   ' 建立变量。
  Set regEx = New RegExp   ' 建立规范表达式。
  regEx.IgnoreCase = False   ' 设置是否区分字母的大小写。
  regEx.Global = True   ' 设置全程性质。
  regEx.Pattern = Ptrn  ' 设置模式。
  Set Matches = regEx.Execute(sStr)
  For Each Match in Matches   ' 遍历 Matches 集合 
     RetStr = RetStr & Replace(Match.Value,"""","") &"|"
  Next
  DeHttpData =RetStr
  'sStr=regEx.Replace(sStr,"^")
  'DeHttpData=sStr'(DeTextDatea(sStr,"^"))
  set regEx=nothing
End function



Function GetStr(TmpBody,Str1,Str2)
Dim TmpStr
BStr=Instr(TmpBody,Str1)
EStr=Instr(BStr+1,TmpBody,Str2)
TmpStr=Mid(TmpBody,Bstr+Len(Str1),EStr-BStr-Len(Str1))
GetStr=TmpStr
End Function

Function GetRStr(RTmpBody,RStr1,RStr2)
Dim RTmpStr,RBstr,REStr
RBstr=InstrRev(RTmpBody,RStr1)
REStr=Instr(RBStr+1,RTmpBody,RStr2)
'Response.write RBStr &"---------"&ReStr
'Response.End
RTmpStr=Mid(RTmpBody,RBstr+Len(RStr1),REStr-RBStr-Len(RStr1))
GetRstr=RTmpStr
End Function

Function DSConvert(vString,vFlag)
 Rem vFlag为0时表示从全角转为半角,为其他时表示从半角转为全角
 Dim i,tmpSingleCharaASC,TempResult,SAscString,DAscString
 SAscString = "1,2,3,4,5,6,7,8,14,15,16,17,18,19,20,21,22,23,24,25,26,27,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126"

 DAscString = "-23679,-23678,-23677,-23676,-23675,-23674,-23673,-23672,-23666,-23665,-23664,-23663,-23662,-23661,-23660,-23659,-23658,-23657,-23656,-23655,-23654,-23653,-23647,-23646,-23645,-23644,-23643,-23642,-23641,-23640,-23639,-23638,-23637,-23636,-23635,-23634,-23633,-23632,-23631,-23630,-23629,-23628,-23627,-23626,-23625,-23624,-23623,-23622,-23621,-23620,-23619,-23618,-23617,-23616,-23615,-23614,-23613,-23612,-23611,-23610,-23609,-23608,-23607,-23606,-23605,-23604,-23603,-23602,-23601,-23600,-23599,-23598,-23597,-23596,-23595,-23594,-23593,-23592,-23591,-23590,-23589,-23588,-23587,-23586,-23585,-23584,-23583,-23582,-23581,-23580,-23579,-23578,-23577,-23576,-23575,-23574,-23573,-23572,-23571,-23570,-23569,-23568,-23567,-23566,-23565,-23564,-23563,-23562,-23561,-23560,-23559,-23558,-23557,-23556,-23555,-23554"

 TempResult = ""
 If Len(vString) <= 0 Then Response.Write "Parameters Error! Please Check Your Parameters!" : Response.End : Exit Function
 For i=1 to Len(vString)
  tmpSingleCharaASC = Asc(Mid(vString,i,1))
  If vFlag = 0 Then
   If InStr(DAscString,tmpSingleCharaASC) <> 0 and len(Cstr(tmpSingleCharaASC)) = 6 Then
    TempResult = TempResult & Chr(tmpSingleCharaASC+23680)
   Else
    TempResult = TempResult & Chr(tmpSingleCharaASC)
   End If
  Else
   If InStr(SAscString,tmpSingleCharaASC) <> 0 and Len(Cstr(tmpSingleCharaASC))<=4 Then
    TempResult = TempResult & Chr(tmpSingleCharaASC-23680)
   Else
    TempResult = TempResult & Chr(tmpSingleCharaASC)
   End If
  End If
 Next
 DSConvert = TempResult
End Function


%>
