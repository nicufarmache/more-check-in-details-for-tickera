#!/bin/sh

rm -rf build
mkdir build
cd build
mkdir more-check-in-details-for-tickera
cp ../*.php more-check-in-details-for-tickera/
zip -r more-check-in-details-for-tickera.zip more-check-in-details-for-tickera
cd ..
