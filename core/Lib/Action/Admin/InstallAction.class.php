<?php
/**
 * @name 安装模块
 */
class InstallAction extends CmsAction{
    // 构造函数	
    public function _initialize(){
		parent::_initialize();
		$lock = RUNTIME_PATH.'Install/install.lock';
		if (is_file($lock)) {
			$this->error('已经安装过'.C('cms_name').',重新安装请先删除'.$lock.'文件!');
		}
		C('TMPL_FILE_NAME','./views/install/..');//模板目录
    }
	public function checksetup(){
		if(empty($_POST['setup'])){
			$this->assign("jumpUrl",C('cms_admin').'?s=Admin/Install');
			$this->error('对不起,您没有接受许可协议,不允许使用本软件!');
		}	
	}
		
	// 许可协议
    public function index(){
       $this->display('setup-1');
    }
	// 第二步检查环境
    public function second(){
		$this->checksetup();
        $this->display('setup-2');
    }
	
	
    private function makecode($num=4) {
        $re = '';
        $s = 'abc1def5gh7ij9kl2mn8op4qr6st3uvwxyz';
        while(strlen($re)<$num) {
            $re .= $s[rand(0, strlen($s)-1)]; //从$s中随机产生一个字符
        }
        return $re;
    }	
	
	// 第三步填写信息
    public function third(){
		$this->checksetup();
		$randStr = $this->makecode(4);
		$this->assign("rand",$randStr);
        $this->display('setup-3');
    }
	public function checkdb(){
		$condb = $_POST['con'];
		$conn  = @mysql_connect($condb['db_host'].":".$condb['db_port'],$condb['db_user'],$condb['db_pwd']);
		if(!$conn){
			exit('1');	
		}else{
			exit('0');
		}
	}
	// 数据库安装
    public function setup(){
		//$this->checksetup();
		$condb = $_POST['con'];
		$conn  = @mysql_connect(trim($condb['db_host']).":".intval($condb['db_port']),trim($condb['db_user']),trim($condb['db_pwd']));
		if (!$conn) {
			exit('数据库连接失败,请检查所填参数是否正确!');
		}
		// 数据库不存在,尝试建立
		if (!@mysql_select_db($condb['db_name'])) {
			$sql = "CREATE DATABASE `".$condb["db_name"]."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
			mysql_query($sql);
		}
		// 建立不成功
		if(!@mysql_select_db($condb['db_name'])){
			exit('无创建数据库的权限,请手动创建或者填写更高权限的用户名与密码!');
		}
		// 保存配置文件
		$config = array(
		    'web_path' =>$condb['web_path'],
			'db_host'  =>$condb['db_host'],
			'db_name'  =>$condb['db_name'],
			'db_user'  =>$condb['db_user'], 
			'db_pwd'   =>$condb['db_pwd'],
			'db_port'  =>$condb['db_port'],
			'db_prefix'=>$condb['db_prefix'],
		);
		$config_old=require './config.php';
		$config_old['web_url']			=	'http://'.$_SERVER['HTTP_HOST'].'/';
		$config_old['player_web_url']	=	'http://'.$_SERVER['HTTP_HOST'].'/';
		$config_new=array_merge($config_old,$config);
		arr2file('./config.php', $config_new);
		
		
		//更新播放器
		$player  ='var player_width='.$config_old['player_width'].';';
		$player .='var player_height='.$config_old['player_height'].';';
		$player .='var player_down="'.$config_old['player_down'].'";';
		$player .='var qvod_player_down="'.$config_old['qvod_player_down'].'";';
		$player .='var player_buffer="'.$config_old['player_buffer'].'";';
		$player .='var player_time="'.$config_old['player_time'].'";';
		$player .='var player_pause="'.$config_old['player_pause'].'";';
		$player .='var ckplayer_f_p="'.$config_old['ckplayer_f_p'].'";';
		$player .='var ckplayer_f_p_l="'.$config_old['ckplayer_f_p_l'].'";';
		$player .='var ckplayer_f_u="'.$config_old['player_web_url'].'";';
		$player .='var ckplayer_f_ad_l="'.$config_old['ckplayer_f_ad_l'].'";';
		$player .='var ckplayer_f_ad_s="'.$config_old['ckplayer_f_ad_s'].'";';
		
		$player .='var ckplayer_first_pic="'.$config_old['ckplayer_first_pic'].'";';
		$player .='var ckplayer_buffer_ad="'.$config_old['ckplayer_buffer_ad'].'";';
		
		$player .='var url_html_play=0;';
		$player .='var html_file_suffix="'.$config_old['html_file_suffix'].'";';
		
		$player .='var ckplayer_f_ad="'.$config_old['ckplayer_f_ad'].'";';
		$player .="var playlistArr = new Array('baidu','qvod','sohu','tudou','youku','qiyi','letv','ck','sina');";
		$player .="\n";
		
		//$player .='if(!window.ActiveXObject){alert(\'请使用IE内核浏览器观看本站影片!\');}'."\n";
		write_file('./temp/Js/player.js',$player);	
		
		
		
		
		
		
		
		
		// 导入SQL安装脚本
		$db_config = array('dbms'=>'mysql','username'=>$condb['db_user'],'password'=>$condb['db_pwd'],'hostname'=>$condb['db_host'],'hostport'=>$condb['db_port'],'database'=>$condb['db_name']);	
		$sql = read_file('./views/install/setup.sql');
		$sql = str_replace('eku_',$condb['db_prefix'],$sql);
		$this->installsql($sql,$db_config);
		
		
		
		
		echo('ok');//数据导入完毕
    }
    
    // 生成安装锁定文件并删除缓存
    public function setupend(){
		touch(RUNTIME_PATH.'Install/install.lock');
		@unlink('./temp/~app.php');
		@unlink('./temp/~runtime.php');	
		$this->display('setup-4');		
	}	
	
	//  执行sql语句
	public function installsql($sql,$db_config){
		require THINK_PATH.'/Lib/Think/Db/Driver/DbMysql.class.php';
		$db = new Dbmysql($db_config);
		$sql = str_replace("\r\n", "\n", $sql); 
		$ret = array(); 
		$num = 0; 
		foreach(explode(";\n", trim($sql)) as $query){
			$queries = explode("\n", trim($query)); 
			foreach($queries as $query) {
				$ret[$num] .= $query[0] == '#' || $query[0].$query[1] == '--' ? '' : $query; 
			} $num++; 
		} 
		unset($sql); 
		foreach($ret as $query) {  
			if(trim($query)) { 
			    $db->query($query); 
			} 
		}
		return true; 
	}								
}
?>