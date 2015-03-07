<?php if (!defined('THINK_PATH')) exit();?><!--<link rel='stylesheet' type='text/css' href='./views/css/admin_style.css'> -->
<style>
body {margin:0px;padding:0px;font-size:12px;color:#313131;font-family: "sim-sun", "Geneva", "Arial", "Helvetica", "sans-serif";}
input {border:1px solid #bbb;height:22px;vertical-align:middle;font-size:12px;}
</style>
<form action="?s=Admin/Upload/Select1" method="post" enctype="multipart/form-data" id="gxform" name="gxform" style="margin-left:5px" onsubmit="return ch()">
<input name="mid" type="hidden" value="<?php echo (htmlspecialchars($_GET['mid'])); ?>"/>
<input name="fileback" type="hidden" id="mid" value="<?php echo (htmlspecialchars($_GET['fileback'])); ?>"/>
<input type="file" name="upthumb" id="upthumb" size="25" value=""> <input type="submit" value="确定" style="background:url(../images/admin/inputbut_bg.gif); cursor:pointer" />
{__NOTOKEN__}<!--onclick="if(!upthumb.value){alert('��ѡ��Ҫ�ϴ����ļ�');return false;}" -->
</form>
<script language='javascript'>
        function getFullPath(obj)
        {
            if(obj)
            {
                if (window.navigator.userAgent.indexOf("MSIE")>=1)    //ie
                {
                    obj.select();
                    return document.selection.createRange().text;
                }
                else if(window.navigator.userAgent.indexOf("Firefox")>=1)             //firefox
                {
                    if(obj.files)
                    {
                        return obj.files.item(0).getAsDataURL();
                    }
                    return obj.value;
                }
                return obj.value;
            }
        }
        function ch(){
        	var fileurl = document.getElementById("upthumb").value;
        	document.getElementById("mid").value = fileurl;
        }
</script>