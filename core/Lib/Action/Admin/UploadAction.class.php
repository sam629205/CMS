<?php
/**
 * @name    上传附件管理模块
 * @package GXCMS.Administrator
 * @link    www.gxcms.com
 */
class UploadAction extends AdminAction{
	// 列表		
    public function show(){
		$this->display('./views/admin/upload.html');
    }
    //选择文件
    public function select(){
    	$this->display('./views/admin/select.html');
    }
    //选择文件
    public function select1(){
    	include 'simple_html_dom.php';
		echo('<div style="font-size:12px; height:30px; line-height:30px">');
		$uppath   = './'.C('upload_path').'/';
		$uppath_s = './'.C('upload_path').'-s/';
		$mid      = trim($_POST['mid']);
		$fileback = !empty($_POST['mid']) ? trim($_POST['fileback']) : 'filepath';
		if ($mid) {
			$uppath.= $mid.'/';
			$uppath_s.= $mid.'/';
			$backpath = $mid.'/';
		}
		import("ORG.Net.UploadFile");
		$up = new UploadFile();
		//$up->maxSize = 3292200;
		$up->savePath      = $uppath;
		$up->saveRule      = uniqid;
		$up->uploadReplace = true;
		$up->allowExts     = explode(',',C('cms_exts'));
		$up->autoSub       = true;
		$up->subType       = date;
		$up->dateFormat    = C('upload_style');
		$uploadList = $up->getUploadFileInfo();
		//是否添加水印
		if (C('upload_water')) {
		   import("ORG.Util.Image");
		   Image::water($uppath.$uploadList[0]['savename'],C('upload_water_img'),'',C('upload_water_pct'),C('upload_water_pos'));
		}
		//是否生成缩略图
		if (C('upload_thumb')) {
		   $thumbdir = substr($uploadList[0]['savename'],0,strrpos($uploadList[0]['savename'], '/'));
		   mkdirss($uppath_s.$thumbdir);
		   import("ORG.Util.Image");
		   Image::thumb($uppath.$uploadList[0]['savename'],$uppath_s.$uploadList[0]['savename'],'',C('upload_thumb_w'),C('upload_thumb_h'),true);
		}
		//是否远程图片
		if (C('upload_ftp')) {
			$img = D('Down');
			$img->ftp_upload($backpath.$uploadList[0]['savename']);
		}
		$mCode = substr($mid,0,strripos($mid, '\\'));
		$Code = substr($mCode,strripos($mCode, '\\')+1);
		$html = new simple_html_dom();
		$urlStr = 'http://javzoo.com/tw/search/'.$Code;
		$html->file_get_html($urlStr);
		dump($html->file_get_html($urlStr));
		$detailLink=$html->find('a[target="_blank"]',0);
		echo($detailLink);
		$html->file_get_html($detailLink);
		$content=$html->find('div[class="container"]',1);
		$name = $content->find('h3')->innertext;
		$imgUrl = $content->find('a[class="bigImage"]')->href;
		$this->getImage($imgUrl, $mCode);
		
		$factory = $content->find('a',1)->innertext;
		
		echo "<script type='text/javascript'>parent.document.getElementById('".$fileback."').value='".$backpath.$uploadList[0]['savename']."';</script>";
		echo "<script type='text/javascript'>parent.document.getElementById('name').value='".$name."';</script>";
		echo "<script type='text/javascript'>parent.document.getElementById('Code').value='".$Code."';</script>";
		echo '文件<a href="'.$uppath.$uploadList[0]['savename'].'" target="_blank"><font color=red>'.$uploadList[0]['savename'].'</font></a>选择成功　[<a href="?s=Admin/Upload/Show/mid/'.$mid.'/fileback/'.$fileback.'">重选</a>]';
		echo '</div>';
	}
	// 上传
	public function upload(){
		echo('<div style="font-size:12px; height:30px; line-height:30px">');
		$uppath   = './'.C('upload_path').'/';
		$uppath_s = './'.C('upload_path').'-s/';
		$mid      = trim($_POST['mid']);
		$fileback = !empty($_POST['fileback']) ? trim($_POST['fileback']) : 'picurl';
		if ($mid) {
			$uppath.= $mid.'/';
			$uppath_s.= $mid.'/';
			$backpath = $mid.'/';
		}
		import("ORG.Net.UploadFile");
		$up = new UploadFile();
		//$up->maxSize = 3292200;
		$up->savePath      = $uppath;
		$up->saveRule      = uniqid;
		$up->uploadReplace = true;
		$up->allowExts     = explode(',',C('cms_exts'));
		$up->autoSub       = true;
		$up->subType       = date;
		$up->dateFormat    = C('upload_style');
        if (!$up->upload()) {
			$error = $up->getErrorMsg();
			if($error == '上传文件类型不允许'){
				$error .= ',可上传<font color=red>'.C('cms_exts').'</font>';
			}
			exit($error.' [<a href="?s=Admin/Upload/Show/mid/'.$mid.'/fileback/'.$fileback.'">重新上传</a>]');
			//dump($up->getErrorMsg());
		}
		$uploadList = $up->getUploadFileInfo();
		//是否添加水印
		if (C('upload_water')) {
		   import("ORG.Util.Image");
		   Image::water($uppath.$uploadList[0]['savename'],C('upload_water_img'),'',C('upload_water_pct'),C('upload_water_pos'));
		}
		//是否生成缩略图
		if (C('upload_thumb')) {
		   $thumbdir = substr($uploadList[0]['savename'],0,strrpos($uploadList[0]['savename'], '/'));
		   mkdirss($uppath_s.$thumbdir);
		   import("ORG.Util.Image");
		   Image::thumb($uppath.$uploadList[0]['savename'],$uppath_s.$uploadList[0]['savename'],'',C('upload_thumb_w'),C('upload_thumb_h'),true);
		}
		//是否远程图片
		if (C('upload_ftp')) {
			$img = D('Down');
			$img->ftp_upload($backpath.$uploadList[0]['savename']);
		}
		echo "<script type='text/javascript'>parent.document.getElementById('".$fileback."').value='".$backpath.$uploadList[0]['savename']."';</script>";
		echo '文件<a href="'.$uppath.$uploadList[0]['savename'].'" target="_blank"><font color=red>'.$uploadList[0]['savename'].'</font></a>上传成功　[<a href="?s=Admin/Upload/Show/mid/'.$mid.'/fileback/'.$fileback.'">重新上传</a>]';
		echo '</div>';
	}
	// 本地附件展示
    public function fileshow(){
		$id = $_GET['id'];
		if ($id) {
			$dirup   = substr($id,0,strrpos($id, '*'));
			$dirpath = str_replace('*','/',$id);
		}else{
			$dirpath = './'.C('upload_path');
		}
		if (!strpos($dirpath,trim(C('upload_path')))) {
			$this->error('不在附件文件夹的范围内!');
		}		
		import("ORG.Io.Dir");
		$dir = new Dir($dirpath);
		$dirlist = $dir->toArray();
		if (strpos($dirup,C('upload_path')) > 0){
			$this->assign('dirup',$dirup);
		}
		$this->assign('dir',$dirlist);
		$this->display('./views/admin/upload_fileshow.html');
    }
	// 删除本地附件
    public function filedel(){
		$id = $_GET['id'];
		if ($id) {
			$dirpath = str_replace('*','/',$id);
			@unlink($dirpath);
			@unlink(str_replace(C('upload_path').'/',C('upload_path').'-s/',$dirpath));
			$this->success('删除附件成功！');
		}
    }
	/*
	*功能：php多种方式完美实现下载远程图片保存到本地
	*参数：文件url,保存文件名称，使用的下载方式
	*当保存文件名称为空时则使用远程文件原来的名称
	*/
	function getImage($url,$path,$type=0,$avatar){
	  if($url==''){return false;}
	   //文件保存路径 
	  if($type){
	  $ch=curl_init();
	  $timeout=5;
	  curl_setopt($ch,CURLOPT_URL,$url);
	  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	  $img=curl_exec($ch);
	  curl_close($ch);
	    }else{
	     ob_start(); 
	     readfile($url);
	     $img=ob_get_contents(); 
	     ob_end_clean(); 
	    }
	    $size=strlen($img);
	    $im = imagecreatefromstring($img);
	    $width = imagesx($im);
	    $height = imagesx($im);
	    $newimg = imagecreatetruecolor($width/2, $height);
	    imagecopyresampled($newimg, $im, 0, 0, $width/2, 0, $width/2, $height, $width, $height);
	    $filename=$path.'\cover.jpg';
	    $filename1 = $path.'\scover.jpg';
	    //文件大小 
	    $fp2=@fopen($filename,'a');
	    fwrite($fp2,$img);
	    fclose($fp2);
	    if ($avatar) {
	   	$fp3=@fopen($filename1, 'a');
	    fwrite($fp3, $newimg);
	    fclose($fp3);
	    }

	    return $filename;
}
}
?>