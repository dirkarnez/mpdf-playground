mpdf-playground
===============
### How to start
- Just run `run.cmd`

### Testing out
- **http://localhost:8000/mpdf**
- http://localhost:8000/tcpdf

### Notes
- mpdf is considered the best because it is built on top of [FPDF](http://www.fpdf.org/) with Unicode support
    - It support some .otf fonts (error message loading "Noto Serif TC": "Fonts with postscript outlines are not supported")
- tcpdf cannot find documentation on loading .otf, but it also supports Unicode