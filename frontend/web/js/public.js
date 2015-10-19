function url_to(target){
	var link;
	if(target == 'task'){
		link = '/?r=home/task/add';
	}else{
		link = 'http://www.sina.com.cn';
	}
	location.href= link;
}