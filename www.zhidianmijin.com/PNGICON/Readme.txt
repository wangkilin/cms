步骤：

1.把需要转化的.PNG文件拷贝到PNG文件夹内
2.运行Start.bat文件
3.需要的.ICO文件在ICO文件夹里


注意：

默认定义转化以下几种图标大小（32位带Alpha通道）：
16*16
32*32
48*48
64*64
72*72
96*96
128*128

如果需要增添，可以自己编辑Start.bat文件

“png2ico -i "png" -o "png" -s 16 32bpp -s 24 32bpp -s 32 32bpp -s 48 32bpp -s 64 32bpp -s 72 32bpp -s 96 32bpp -s 128 32bpp -noconfirm”

可以按照这样的格式添加，不要哪种格式，把-s ** 32bpp删除就是了。
32bpp代表32位带Alpha通道色彩

Vivonl 2005.3.4