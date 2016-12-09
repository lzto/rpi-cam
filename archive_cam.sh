#!/bin/bash


if [ ! -z "$1" ];then
	f=$1
	_f=`echo ${f}|sed -e s/_//g`
	files=${_f}
	pushd /exports/cam
	mkdir -p ${f}
	mv *${files}*.jpg ${f}
	popd
else

	yesterday=`date +%Y_%m_%d --date="yesterday"`
	y_files=`date +%Y%m%d --date="yesterday"`

	date=`date +%Y_%m_%d`

	files=`date +%Y%m%d`

	pushd /exports/cam

	mkdir -p ${date}

	mv *${files}*.jpg ${date}/

	if [ ! -z "${y_files}" ];then
		mv *${y_files}*.jpg ${yesterday}/
	fi

	popd
fi
