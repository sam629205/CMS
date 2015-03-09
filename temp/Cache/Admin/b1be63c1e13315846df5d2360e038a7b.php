<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>添加/编辑影片</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='./views/css/admin_style.css'>
<style>
.removePlayList{padding-left:6px; padding-right:6px; padding-top:2px; padding-bottom:2px; border:1px solid #F30; background-color:#F30; color:#FFF; margin-left:10px; cursor:pointer;}
.tipplayer{padding-left:6px; padding-right:6px; padding-top:2px; padding-bottom:2px; border:1px solid #06C; background-color:#06C; color:#FFF; margin-left:10px;}
.tipplayer a{color:#FFF;}
.tipplayer a:hover{color:#FF0;}
</style>
<script language="JavaScript" charset="utf-8" type="text/javascript" src="./views/js/jquery.js"></script>
<script language="JavaScript" charset="utf-8" type="text/javascript" src="./views/js/admin_all.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8" src="./views/editor/kindeditor.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8" src="./views/editor/lang/zh_CN.js"></script>


<script>
var ppslist = new Array();
var curplaycount = 1;


function showTip(id,type)
{
	var url = document.URL;
	//www.ekucms.com/tool/tudou.php
	switch(type)
	{
		case 'qvod':
			//document.write('正在使用快播播放器');
			$('#tipplayer_'+id).html('正在使用快播播放器');
			break;
		case 'tudou':
			//document.write('<a href="http://www.ekucms.com/tool/tudou.php?f='+url+'" target="_blank">土豆URL地址转ID，请点击这里！！！</a>');
			$('#tipplayer_'+id).html('<a href="http://www.ekucms.com/tool/tudou.php?f='+url+'" target="_blank">土豆URL地址转ID，请点击这里！！！</a>');
			break;
		case 'youku':
			//document.write('<a href="http://www.ekucms.com/tool/yukou.php?f='+url+'" target="_blank">优酷URL地址转ID，请点击这里！！！</a>');
			$('#tipplayer_'+id).html('<a href="http://www.ekucms.com/tool/yukou.php?f='+url+'" target="_blank">优酷URL地址转ID，请点击这里！！！</a>');
			break;
		case 'sohu':
			//document.write('<a href="http://www.ekucms.com/tool/sohu.php?f='+url+'" target="_blank">搜狐视频 URL地址转ID，请点击这里！！！</a>');
			$('#tipplayer_'+id).html('<a href="http://www.ekucms.com/tool/sohu.php?f='+url+'" target="_blank">搜狐视频 URL地址转ID，请点击这里！！！</a>');
			break;
		case 'letv':
			//document.write('<a href="http://www.ekucms.com/tool/letv.php?f='+url+'" target="_blank">乐视 URL地址转ID，请点击这里！！！</a>');
			$('#tipplayer_'+id).html('<a href="http://www.ekucms.com/tool/letv.php?f='+url+'" target="_blank">乐视 URL地址转ID，请点击这里！！！</a>');
			break;
		case 'qiyi':
			//document.write('<a href="http://www.ekucms.com/tool/qiyi.php?f='+url+'" target="_blank">奇艺 URL地址转ID，请点击这里！！！</a>');
			$('#tipplayer_'+id).html('<a href="http://www.ekucms.com/tool/qiyi.php?f='+url+'" target="_blank">奇艺 URL地址转ID，请点击这里！！！</a>');
			break;
		case 'baidu':
			//document.write('正在使用百度影音播放器');
			$('#tipplayer_'+id).html('正在使用百度影音播放器');
			break;
			
	}
}
</script>
</head>
<body> 
<?php if(($id)  >  "0"): ?><form name="update" action="?s=Admin/Video/Update" method="post" id="gxform">
<input type="hidden" name="id" value="<?php echo ($id); ?>">
<?php else: ?>
<form name="add" action="?s=Admin/Video/Insert" method="post" id="gxform"><?php endif; ?>
<table cellpadding="0" cellspacing="0" class="boxadd">
<tr class="tabs_title">
    <td><span id="tabs" class="fl"><a class="on" href="javascript:void(0)" name="1,2" hideFocus='true'><?php echo ($tpltitle); ?>影片</a><a class="tab2" href="javascript:void(0)" name="2,2" hideFocus='true'>其它设置</a></span><span class="fr"><a href="?s=Admin/Video/Show" class="no">返回数据管理</a></span>
    </td>
</tr>
<tr><td>
<div id="showtab_1" style="border-top:1px solid #C6DCF2;">
<ul><li class="l">路径：<input name="filepath" id="filepath" type="text" class="input" maxlength="255" value="<?php echo ($filepath); ?>"></li>
<li class="r" style="padding-top:5px"><iframe src="?s=Admin/Upload/Select/mid/video" scrolling="no" topmargin="0" width="300" height="28" marginwidth="0" marginheight="0" frameborder="0" align="left"></iframe></li>
</ul>
<ul><li class="l">名 称：<input name="title" id="name" type="text" class="input" maxlength="255" value="<?php echo ($title); ?>"></li>
<li class="r">分 类：<select name="cid" class="select" onchange="changeCat(this.value)"><?php if(is_array($list_channel_video)): $i = 0; $__LIST__ = $list_channel_video;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxcms): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($gxcms["id"]); ?>" <?php if(($gxcms["id"])  ==  $cid): ?>selected<?php endif; ?>><?php echo ($gxcms["cname"]); ?></option><?php if(is_array($gxcms['son'])): $i = 0; $__LIST__ = $gxcms['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxcms): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($gxcms["id"]); ?>" <?php if(($gxcms["id"])  ==  $cid): ?>selected<?php endif; ?>>├ <?php echo ($gxcms["cname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?><?php endforeach; endif; else: echo "" ;endif; ?></select></li>
<li class="r">连载信息：<input name="serial" type="text" size="10" value="<?php echo ($serial); ?>" class="ct"></li>
</ul>

<ul>
<li class="l" style="width:60px; ">多分类：</li>
<li style="float:left; line-height:36px;" id="stype_list"></li>
</ul>

<ul>
<li class="l">备 注：<input name="intro" type="text" class="input" maxlength="255" value="<?php echo ($intro); ?>"></li>
<li class="r">颜 色：<select name="color" class="select"><option value=''>标题颜色</option><option value='#FF0000' style='background-color:#FF0000' <?php if(($color)  ==  "#FF0000"): ?>selected<?php endif; ?>>红色</option><option value='#FF33CC' style='background-color:#FF33CC' <?php if(($color)  ==  "#FF33CC"): ?>selected<?php endif; ?>>粉红</option><option value='#00FF00' style='background-color:#00FF00' <?php if(($color)  ==  "#00FF00"): ?>selected<?php endif; ?>>绿色</option><option value='#660099' style='background-color:#660099' <?php if(($color)  ==  "#660099"): ?>selected<?php endif; ?>>紫色</option><option value='#FFFF00' style='background-color:#FFFF00' <?php if(($color)  ==  "#FFFF00"): ?>selected<?php endif; ?>>黄色</option><option value='#0000CC' style='background-color:#0000CC' <?php if(($color)  ==  "#0000CC"): ?>selected<?php endif; ?>>深蓝</option><option value=''>无色</option></select></li>
<li class="r">点播人气：<input name="hits" type="text" size="10" value="<?php echo ($hits); ?>" class="ct"></li>
</ul>
<ul>
<li class="l">主 演：<input name="actor" type="text" class="input" maxlength="255" value="<?php echo ($actor); ?>" title="半角逗号分隔"></li>
<li class="r">星 级：<select name="stars" class="select"><option value="1" <?php if(($stars)  ==  "1"): ?>selected<?php endif; ?>>☆</option><option value="2" <?php if(($stars)  ==  "2"): ?>selected<?php endif; ?>>☆☆</option><option value="3" <?php if(($stars)  ==  "3"): ?>selected<?php endif; ?>>☆☆☆</option><option value="4" <?php if(($stars)  ==  "4"): ?>selected<?php endif; ?>>☆☆☆☆</option><option value="5" <?php if(($stars)  ==  "5"): ?>selected<?php endif; ?>>☆☆☆☆☆</option>
</select></li>
<li class="r">影片评分：<input name="score" type="text" size="10" maxlength="4" value="<?php echo (($score)?($score):'10'); ?>" class="ct"></li>
</ul>
<ul>
<li class="l">导 演：<input name="director" type="text" class="input" maxlength="255" value="<?php echo ($director); ?>" title="半角逗号分隔"></li>
<li class="r">对 白：<select name="language" class="select" title="对白语言"><?php if(is_array($list_language)): $i = 0; $__LIST__ = $list_language;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxcms): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($gxcms); ?>" <?php if(($gxcms)  ==  $language): ?>selected<?php endif; ?>><?php echo ($gxcms); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select></li>
<li class="r">发行年份：<input name="year"  type="text" size="10" maxlength="5" value="<?php echo (($year)?($year):'2000'); ?>"  class="ct"/></li>
</ul>
<ul>
<li class="l">优 化：<input name="keywords" type="text" class="input" maxlength="255" value="<?php echo ($keywords); ?>" title="SEO关键词"></li>
<li class="r">地 区：<select name="area" class="select" title="生产地区"><?php if(is_array($list_area)): $i = 0; $__LIST__ = $list_area;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxcms): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($gxcms); ?>" <?php if(($gxcms)  ==  $area): ?>selected<?php endif; ?>><?php echo ($gxcms); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select></li>
<li class="r">影片录入：<input name="inputer" type="text" size="10" value="<?php echo ($inputer); ?>" class="ct" title="设为gxcms将强制该影片为手动更新"></li>
</ul>
<ul>
<li class="l">海 报：<input name="picurl" id="picurl" type="text" class="input" maxlength="255" value="<?php echo ($picurl); ?>"></li>
<li class="r" style="padding-top:5px"><iframe src="?s=Admin/Upload/Show/mid/video" scrolling="no" topmargin="0" width="300" height="28" marginwidth="0" marginheight="0" frameborder="0" align="left"></iframe></li>
</ul>
<ul style="padding:5px 0px; height:auto; background-color:#F5F5F5">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
<tr>
	<td width="10%" rowspan="2">
    播放地址：
    </td>
	<td width="90%" align="left" valign="top" id="play_add">
    
        <?php
        if($id)
        {
        	$playcount = count($vodplay);
            foreach($vodplay as $k=>$v)
            {
                //$playserverid = $vodplay[$k];
        ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="table__playlist_<?php echo $k+1;?>">
          <tr>
            <td>
            
            第 <?php echo $k+1;?> 组播放地址：
			<select name="vodplay[]" id="vodplay_<?php echo $k+1;?>" onchange="showTipFirst(this,<?php echo $k+1;?>);">
              <script>
			  var ppslist = new Array();
              </script>
              <?php
              foreach($playserver as $k2=>$v2)
              {
                $s = $v == $k2 ? 'selected="selected"' : '';
              ?>
              
              <script>
			  var str = '<?php echo ($k2); ?>'+'|'+'<?php echo ($v2); ?>';
              ppslist.push(str);
              </script>
                <option value="<?php echo ($k2); ?>" <?php echo $s;?> ><?php echo ($v2); ?></option>
        <?php
                }
        ?>
        <script>
        curplaycount = <?php echo ($playcount); ?>;
        </script>
              </select>
              <span class="removePlayList" onclick="removePlayList('<?php echo $k+1;?>');">删除该组播放器</span>      
              <span class="tipplayer" id="tipplayer_<?php echo $k+1;?>">
              <script>
			  showTip('<?php echo $k+1;?>','<?php echo ($v); ?>');
              </script>
              </span>      
            </td>
          </tr>
          <tr>
            <td>
              
              <textarea name='playurl[]' style="width:100%;height:150px" title="播放地址请按每集一行的格式输入"><?php echo ($playurl[$k]); ?></textarea>
            </td>
          </tr>
        </table>
        <?php
            }
        }else{
        ?>
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="table__playlist_1">
          <tr>
       
            <td>
            第1组播放地址：
              <select name="vodplay[]" onchange="showTipFirst(this,1)">
              <?php
              foreach($playserver as $k=>$v)
              {
              ?>
              <script>
			  var str = '<?php echo ($k); ?>'+'|'+'<?php echo ($v); ?>';
              ppslist.push(str);
              </script>
                <option value="<?php echo ($k); ?>"><?php echo ($v); ?></option>
        <?php
            }
        ?>
            </select>
            <span class="removePlayList" onclick="removePlayList('1');">删除该组播放器</span>
            
              <span class="tipplayer" id="tipplayer_<?php echo $k+1;?>">
              <script>
			  showTip('1','baidu');
            	</script>
            
            </td>
          </tr>
          
          <tr>
            <td>
            
              
              <textarea name='playurl[]' style="width:755px;height:150px" title="播放地址请按每集一行的格式输入"></textarea>
            
            </td>
          </tr>
        </table>
        
        <?php
        }
        ?>
    </td>
</tr>
<tr>
<td align="left">
<span id="addaddress" style="cursor:pointer; width:100px; height:30px; line-height:30px; border:1px solid #06C; background-color:#06C; color:#FFF; padding:6px; font-size:14px;" onclick="addPlayAddressJs();">
继续添加播放地址
</span>
</td>
</tr>
</table>


</ul>
<ul style="height:160px;line-height:160px;padding:5px 0px">
<li style="padding-left:22px;float:left;">下载地址：</li>
<li style="float:left"><textarea name='downurl' style="width:755px;height:150px" title="下载地址请按每集一行的格式输入,没有请留空"><?php echo ($downurl); ?></textarea></li>
</ul>
<ul style="height:260px;line-height:260px;padding:5px 0px">
<li style="padding-left:22px;float:left;">剧情简介：</li>
<li style="float:left"><textarea id="content" name="content" style="width:760px;height:250px;"><?php echo ($content); ?></textarea></li>
</ul>
</div>
<div id="showtab_2" style="display:none;border-top:1px solid #C6DCF2;text-align:left">
<ul><li class="l">状&nbsp;&nbsp;&nbsp;&nbsp;态：<select name="status"><option value="1" >显示</option><option value="0" <?php if(($status)  ==  "0"): ?>selected<?php endif; ?>>隐藏</option></select></li></ul>

<ul><li class="l">自定义标题：<input name="selftitle" type="text" size="100" value="<?php echo ($selftitle); ?>" class="input"></li></ul>
<ul style="height:110px;line-height:110px;padding:5px 0px"><li class="l">自定义关键字：<textarea name='selfkeywords' style="width:755px;height:100px"><?php echo ($selfkeywords); ?></textarea></li></ul>
<ul style="height:110px;line-height:110px;padding:5px 0px"><li class="l">自定义描述：<textarea name='selfdescription' style="width:755px;height:100px"><?php echo ($selfdescription); ?></textarea></li></ul>


<ul><li class="l">评分人：<input name="scoreer" type="text" size="10" value="<?php echo (($scoreer)?($scoreer):'1'); ?>" class="ct" title="共多少人评分" maxlength="8"></li></ul>
<ul><li class="l">首字母：<input name="letter" type="text" size="10" value="<?php echo ($letter); ?>" class="ct" maxlength="2"></li></ul>
<ul><li class="l">月人气：<input name="monthhits" type="text" size="10" value="<?php echo ($monthhits); ?>" class="ct" maxlength="8"></li></ul>
<ul><li class="l">周人气：<input name="weekhits" type="text" size="10" value="<?php echo ($weekhits); ?>" class="ct" maxlength="8"></li></ul>
<ul><li class="l">日人气：<input name="dayhits" type="text" size="10" value="<?php echo ($dayhits); ?>" class="ct" maxlength="8"></li></ul>
<ul><li class="l">支&nbsp;&nbsp;&nbsp;&nbsp;持：<input name="up" type="text" size="10" value="<?php echo (($up)?($up):'0'); ?>" class="ct" maxlength="8"></li></ul>
<ul><li class="l">反&nbsp;&nbsp;&nbsp;&nbsp;对：<input name="down" type="text" size="10" value="<?php echo (($down)?($down):'0'); ?>" class="ct" maxlength="8"></li></ul>
<ul><li class="l" title="勾选则使用系统当前时间">时&nbsp;&nbsp;&nbsp;&nbsp;间：<input name="addtime" type="text" size="20" maxlength="35" value="<?php echo (date('Y-m-d H:i:s',$addtime)); ?>"> <input name="checktime" type="checkbox" class="noborder" value="1" <?php echo ($checktime); ?>></li></ul>
<ul><li class="l">来&nbsp;&nbsp;&nbsp;&nbsp;源：<input name="reurl" type="text" class="input" maxlength="255" value="<?php echo ($reurl); ?>" class="ct" title="请勿随意修改,将作为采集更新的标识"></li></ul>
</div>
<ul>
<li style="margin-left:70px;text-align:left;padding-top:5px"><input class="bginput" type="submit" name="submit" value=" 提 交 " > <input class="bginput" type="reset" name="Input" value=" 重 置 " ></li>
</ul>
</td></tr>
</table>
</form>
<script type="text/javascript">
var cid = '<?php echo ($cid); ?>';
var stype_mcid = '<?php echo ($stype_mcid); ?>';
window.onload = function(){
	if (isNaN(parseInt(cid)) == true) cid = 1;
	changeCat(cid,stype_mcid);	
};
//
var editor;
KindEditor.ready(function(K){
    editor = K.create('#content', {
	resizeType : 1,
	allowPreviewEmoticons : false,
	allowImageUpload : false,
	items : [
	'source', '|', 'fontsize', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
	'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
	'insertunorderedlist', '|', 'emoticons', 'image', 'link', 'unlink', 'about']
})});
var $content = $('#content').val();
	document.getElementById("gxform").onreset = function(){
	KindEditor.html('content', $content);
}

function changeCat(id,mcid){
	$.ajax({
		type:'get',
		url:'?s=Admin/video/ajaxstype/id/'+id+'/mcid/'+mcid,
		success:function(html){
			$("#stype_list").html(html);
		}
	})
}
function addPlayAddressJs()
{
	curplaycount++;
	var obj = $('#play_add');
	var html = '<table width="100%" border="0" cellspacing="0" cellpadding="0" id="table__playlist_'+curplaycount+'">';
	html += "<tr><td>";
	html += "第"+curplaycount+"组播放地址：";
	
	html += "<select name='vodplay[]' onchange='showTipFirst(this,"+curplaycount+")'>";
	
	for(var i=0;i<ppslist.length;i++)
	{
		var str = ppslist[i].split('|');
		html += '<option value='+str[0]+'>'+str[1]+'</option>';
	}
	
	html += "</select>";
	
	html += '<span class="tipplayer" id="tipplayer_'+curplaycount+'">您正在使用百度影音播放器</span>';
	
	html += "</td></tr>";
	html += "<tr><td>";
	html += "<textarea name='playurl[]' style='width:755px;height:150px' title='播放地址请按每集一行的格式输入'></textarea>";
	html += "<tr><td>";
	html += '</table>';
	obj.append(html);
	
}

function removePlayList(i)
{
	var returns = window.confirm('兄弟，你真要删除？');
	if (returns == true)
	{
		$('#table__playlist_'+i).remove();
	}
}

function showTipFirst(obj,id)
{
	showTip(id,$(obj).val());
}
</script>
<style>
#footer, #footer a:link, #footer a:visited {
	clear:both;
	color:#0072e3;
	font:12px/1.5 Arial;
	margin-top:10px;
	text-align:center;
	white-space:nowrap;
}
</style>
<div id="footer">程序版本：<?php echo C("cms_var");?>&nbsp;&nbsp;&nbsp;&nbsp;Copyright © 2010-2011 All rights reserved</div>
</body>
</html>