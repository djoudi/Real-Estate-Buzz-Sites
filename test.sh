#!/bin/bash

CURRDIR=`pwd`

echo $CURRDIR

for i in wp-admin/*
do
echo $CURRDIR/$i $i
done