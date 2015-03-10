<?php

	 echo('1234');
	$cookie_jar = '/tmp/cookie.tmp';
	$ch = curl_init();//www.javzoo.com/ja/movie/4pmt
	$options = array(CURLOPT_URL => 'http://www.javzoo.com/ja/movie/4pmt',
			CURLOPT_HEADER => 0,
			CURLOPT_NOBODY => 0,
			CURLOPT_PORT => 80,
			CURLOPT_POST => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_USERAGENT => 'Baiduspider+(+http://www.baidu.com/search/spider.htm)',
			CURLOPT_ENCODING=>'gzip,deflate',//GZIP解压
//			CURLOPT_COOKIEJAR => $cookie_jar,
//			CURLOPT_COOKIEFILE => $cookie_jar,
			CURLOPT_REFERER => 'http://www.baidu.com/search/spider.html',
			CURLOPT_CONNECTTIMEOUT=> 40
	);
	curl_setopt_array($ch, $options);
	$code = curl_exec($ch);
	curl_close($ch);
	echo $code;
	
	
	
?>