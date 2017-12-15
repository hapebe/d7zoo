C:
cd \ia\temp
copy C:\xampp\apps\drupal\htdocs\sites\default\files\ia\rescaled.jpg . /y
copy C:\xampp\apps\drupal\htdocs\sites\default\files\ia\chart-*.png . /y >nul
del C:\xampp\apps\drupal\htdocs\sites\default\files\ia\chart-*.png

del *.png
del rescaled.jpg

copy C:\xampp\apps\drupal\htdocs\sites\default\files\ia\filelist.txt . /y
C:\ia\bmp2avi\EasyBMPtoAVI.exe -filelist filelist.txt -framerate 25 -output out.avi
del *.bmp
del filelist.txt
C:\ia\vd\VirtualDub.exe /s colorspace-convert.vcf /p out.avi SCWT0261.avi /r /x
del out.avi

REM animated GIF output:
REM "C:\Program Files\ImageMagick-6.8.9-Q16\convert" -delay 4 chart-???.png -fuzz 40% -map colormap_332.png anim.miff
REM "C:\Program Files\ImageMagick-6.8.9-Q16\convert" anim.miff -delay 4 -coalesce +dither -layers OptimizeTransparency anim-opt.gif
