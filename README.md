# Html & CSS & Javascript educator
>html css javascript 교육 목적으로 만들어진 간단한 페이지 입니다.

대학교 재학시절 후배들이 html, css, javascript를 배운다는 이야기를 듣고 교수님의 강의 편의성을 위해 제작한 웹 에플리케이션 입니다. 하루정도 걸려서 후딱 만든거라 소스가 깔끔하지는 않지만 필요하신 분이 있을것 같아 적당히 수정하여 배포합니다.

파일 및 폴더 생성, 삭제, 변경, 이름변경, 파일 업로드, 파일 다운로드 등의 기능들을 포함하고 있습니다.

![](./img/1.png)
![](./img/2.png)
![](./img/3.png)
![](./img/4.png)

## 설치 방법

서버설정 H3
-----------

이 프로그램은 linux 기반으로 만들어져 있으며 윈도우에서는 사용할 수 없습니다.

* 디렉토리 리스팅 및 에러 표시는 모두 OFF 해 주세요.

* apache 설정파일에 해당 내용을 추가합니다.
	* apache.conf
	* httpd.conf
설정파일은 위와 같은 파일들을 뜯하며 꼭 해당 config 파일에 추가 할 필요는 없습니다.

```sh
<Directory [SOURCE_FILE_PATH]/users>
        php_admin_flag engine Off
</Directory>

```
위 구문에서 [SOURCE_FILE_PATH] 는 소스파일이 위치하는 경로는 뜻합니다.

아파치 기본 웹 서버 경로에 해당 소스를 넣었다고 가정하면
```
<Directory /var/www/html/users>
        php_admin_flag engine Off
</Directory>
```
위와 같이 작성하시면 됩니다.

위 작업을 하지 않을경우 심각한 보안 사고가 발생할 수 있습니다. H3

* 최 상위 폴더의 users 폴더의 권한을 777로 바꿔줍니다.
```
chmod 777 users
```
위 작업을 하지 않을 시 사용자의 폴더가 생성되지 않을 수 있습니다.

데이터베이스 설정 H3
--------------------

본 프로젝트는 mysql을 이용합니다.
함께 업로드된 sql 파일을 이용하여 테이블을 테이블을 생성합니다.
config.php 파일을 수정합니다.

```
//Database
$host = "[DB server ip]";
$db_id = "[DB id]";
$db_pw = "[DB password]";
$db_name = "[DB name]";

//server
$apache_path = "[APACHE WEB SERVER PATH]";
```
정당한 값을 채워 넣습니다.
apache_path는 아파지 웹 서버 폴더위치를 넣습니다.
기본값은 /var/www/html 입니다.

# 사용 방법

사용방법은 직관적이므로 설명하지 않겠음.


