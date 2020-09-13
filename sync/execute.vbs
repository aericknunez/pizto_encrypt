Dim WinScriptHost
Set WinScriptHost = CreateObject("WScript.Shell")
WinScriptHost.Run Chr(34) & "C:\AppServ\www\pizto\sync\sync.bat" & Chr(34), 0
Set WinScriptHost = Nothing