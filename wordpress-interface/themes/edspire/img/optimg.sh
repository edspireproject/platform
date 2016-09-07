#!/bin/bash
# script to reduce the file size of jpegs and pngs in this folder
# required software:
#  - jpegoptim
#  - optipng

jpegoptim --strip-all *.jpg
optipng -o7 *.png

