DISTRO=$(shell sed 's/ .*//' /etc/redhat-release && sed -n '/DISTRIB_ID=/{s/.*=//;p}' /etc/lsb-release 2>/dev/null)
SYSTEM=$(shell which yum >/dev/null 2>&1 && echo yum || echo apt)

mp3-libs: cms-libs mp3-libs-${SYSTEM} 
mp3-libs-yum:
	sudo rpm -i lame-3.96.1-2.2.el4.rf.i386.rpm
	sudo yum install sox lame id3v2
	make exiftool-from-source
	make mpg123-from-source
	make id3lib-from-source
cms-libs: basic-tools cms-libs-${SYSTEM}
basic-tools: basic-tools-${SYSTEM}

basic-tools-yum:
	sudo yum install vim-enhanced 
	make htop-from-source

tmp:
	mkdir tmp
cms-libs-yum: tmp
	sudo yum install ImageMagick libevent-devel
	make gearman-from-source

pear: pear-${SYSTEM}

pear-yum:
	sudo yum install php-pear
gearman-from-source: pear
	rm -rf tmp/gearmand-0.13
	cd tmp && tar --overwrite -xzf ../gearmand-0.13.tar.gz
	cd tmp/gearmand-0.13 && ./configure && make && sudo make install
	sudo cp init.d.gearmand /etc/init.d/gearmand
	sudo pear install channel://pear.php.net/Net_Gearman-0.2.3
exiftool-from-source:
	rm -rf tmp/Image-ExifTool-8.00
	cd tmp &&  tar xzf ../Image-ExifTool-8.00.tar.gz 
	cd tmp/Image-ExifTool-8.00/ &&  perl Makefile.PL && make && sudo make install
mpg123-from-source:
	rm -rf tmp/mpg123-1.10.0
	cd tmp/ && tar xjf ../mpg123-1.10.0.tar.bz2 
	cd tmp/htop-1.10.3/ && ./configure && make && sudo make install
htop-from-source:
	rm -rf tmp/htop-0.8.3
	cd tmp/ && tar xzf ../htop-0.8.3.tar.gz 
	cd tmp/htop-0.8.3/ && ./configure && make && sudo make install
id3lib-from-source:
	rm -rf tmp/id3lib-3.8.3
	cd tmp/ && tar xzf ../id3lib-3.8.3.tar.gz
	cd tmp/id3lib-3.8.3/ && ./configure && make && sudo make install
