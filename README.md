1. Code for creating the database and tables

create database studentmanagementsystem;

use studentmanagementsystem;

create table student(
	sid int NOT NULL,
	sname varchar(30) NOT NULL,
	password varchar(50) NOT NULL,
	phone varchar(10) NOT NULL,
	PRIMARY KEY(sid)
);

create table faculty(
	fid int NOT NULL,
	fname varchar(30) NOT NULL,
	password varchar(50) NOT NULL,
	phone varchar(30) NOT NULL,
	PRIMARY KEY(fid)
);

create table course(
	cid int NOT NULL,
	cname varchar(30) NOT NULL,
	credits int NOT NULL,
	syllabus varchar(40) NOT NULL UNIQUE,
	fno int,
	PRIMARY KEY(cid),
	FOREIGN KEY(fno) REFERENCES faculty(fid) ON UPDATE CASCADE ON DELETE SET NULL
);

create table learning(
	sno int NOT NULL,
	cno int NOT NULL,
	value int DEFAULT 0,
	PRIMARY KEY(sno,cno),
	FOREIGN KEY(sno) REFERENCES student(sid) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(cno) REFERENCES course(cid) ON UPDATE CASCADE ON DELETE CASCADE
);

2. When you are creating a course, its syllabus is uploaded to C:/data folder. So, create a folder named "data" in your C drive.

3. All of the documents downloaded will be downloaded into the current directory

4. For mailing change the following settings in these two files

I am using xampp. So open sendmail configuration file present in C:\xampp\sendmail folder

uncomment the following things(remove the ; present at the beginning for these lines. set it to following

smtp_server=smtp.gmail.com
smtp_ssl=tls
smtp_port=587

To log the errors and for debugging uncomment the following(remove the ; in the beginning)
error_logfile=error.log
debug_logfile=debug.log

Set the following to given id and password. For this account, sending mail from less secure apps is turned on. Otherwise it doesn't work 
auth_username=omgggggggg0@gmail.com
auth_password=abcdefgh@12345678

hostname = localhost

Then save this file and close it.

Open php.ini file located in C:\xampp\php folder and search for "mail function" in this file

comment out the following lines(place a ; at the beginning of the following lines)
;SMTP=localhost
;smtp_port=25
;sendmail_from = me@example.com

set the following to this
sendmail_path = C:\xampp\sendmail\sendmail.exe

search for php_openssl make sure this extension is enabled
extension=php_openssl.dll

Save and close this file and restart your apache server

5. For security reasons, from address/header is not changed while sending the mail. Even if that header is specified, it is overwritten at the ISP to the authentication mail id set in the configuration file. So the taken mail id is kept in the reply to header

6. Credits to videezy website for the background video in the index.php page

7. Firstly open the index.php page and the login details for admin are username = "root" and password = "root"

8. Faculty and Students can be added from admin page itself.
