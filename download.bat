@echo off
cd\
cd C:\AppServ\www\pizto
git reset --hard
git pull https://github.com/aericknunez/pizto.git

cd\
cd C:\AppServ\www\pizto\sync
call C:\AppServ\www\pizto\sync\sync_json.bat
exit