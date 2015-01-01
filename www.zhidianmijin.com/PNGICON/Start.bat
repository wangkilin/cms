png2ico -i "png" -o "png" -s 16 32bpp -s 24 32bpp -s 32 32bpp -s 48 32bpp -s 64 32bpp -s 72 32bpp -s 96 32bpp -s 128 32bpp -noconfirm
XCOPY "png\*.ico" ".\ico\" /S /E /C /H /Q /Y
DEL  "png\*.ico"  /F /Q /S

