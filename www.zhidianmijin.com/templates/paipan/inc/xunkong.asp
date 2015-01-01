<%function xunkong(gz1,xunk,xunshou)
set fo=server.CreateObject("scripting.filesystemobject")
path=server.MapPath("temp")
path=path&"/xunkong.txt"
set fns=fo.opentextfile(path)
while not fns.atendofstream
str=fns.readline
if instr(str,gz1)>0 then
strarr=split(str,",")
xunk=strarr(10)
xunshou=strarr(0)
end if
wend
fns.close
set fo=nothing
end function

%>