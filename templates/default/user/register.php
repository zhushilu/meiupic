<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php if(isset($site_title)): echo $site_title; else: ?><?php echo getSetting('site_title');?> - <?php echo getSetting('site_sub_title');?><?php endif; ?></title>
    <meta name="keywords" content="<?php if(isset($site_keywords)){ echo $site_keywords; } ?>" />
    <meta name="description" content="<?php if(isset($site_description)){ echo $site_description; } ?>" />
    <script type="text/javascript" src="<?=S('base','js/jquery.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo S('base','js/jquery.placeholder.js');?>"></script>
    <link rel="stylesheet" href="<?=ST('css/login.css')?>" type="text/css" />
</head>
<body>
<div class="register-box">
    <div class="mod-head">
        <a href="/"><img src="<?php echo ST('images/login_logo.png');?>" alt="<?php echo getSetting('site_title');?>"></a>
        <h1>注册新用户</h1>
    </div>
    <div class="mod-body">
            <form class="session-form" action="<?php echo U('user','register');?>" method="post" onsubmit="return doRegister(this);">
                <ul>
                <li class="alert alert-danger error_message" style="display: none;">
                    
                </li>
                <li>
                    <input type="text" required="" value="" placeholder="用户名" name="username" class="form-control" />
                </li>
                <li>
                    <input type="password" required="" placeholder="登录密码" name="userpass" class="form-control" />
                </li>
                <li>
                    <input type="text" required="" value="" placeholder="Email" name="email" class="form-control" />
                </li>
                <li>
                    <input type="text" required="" placeholder="常用昵称或真名" name="nickname" class="form-control" />
                </li>
                <?php foreach ($fields as $key => $value): 
                if($value['show'] != 1) continue;
                ?>
                <li>
                    <input type="text" placeholder="<?php echo $value['cname'];?>" name="<?php echo $key;?>" class="form-control" />
                </li>
                <?php endforeach ?>
                <?php 
                $user_setting = getSetting('user_setting',true);
                if($user_setting['enable_reg_captcha']):
                ?>
                <li class="captcha clearfix">
                    <input type="text" required="" placeholder="验证码" name="captcha" class="form-control" />
                    <i class="captcha_show">
                        <img orgisrc="<?php echo U('base','captcha');?>" src="<?php echo U('base','captcha');?>" alt="验证码" />
                    </i>
                </li>
                <?php endif; ?>
                <li class="last">
                    <label><input type="checkbox" checked="checked" value="agree" name="agree" /> 我同意</label> <a href="javascript:void(0);" class="agreement-btn">用户协议</a>
                    <a href="<?php echo U('user','login');?>" class="pull-right">已有账号?</a>
                    <div class="register-agreement collapse" style="display: none;">
                        <div class="register-agreement-txt" id="register_agreement">
                            <?php echo nl2br(getSetting('agreement_content')); ?>
                        </div>
                    </div>

                </li>
                <li class="form-action">
                    <input type="hidden" name="isajax" value="1" />
                    <input type="submit" class="btn btn-xl" value="注册" />
                </li>
                </ul>
            </form>
    </div>
</div>
<script type="text/javascript">
function doRegister(f){
    $('.error_message').hide();
    $.post($(f).attr('action'),$(f).serializeArray(),function(data){
        if(data.ret){
            window.location.href=data.redirect;
        }else{
            if(data.field){
                $('.error_message').html(data.msg).show();
                //$('input[name="'+data.field+'"]').addClass('input-error').after('<span class="text-error">'+data.msg+'</span>');
            }else{
                alert(data.msg);
            }
        }
    },'json');
    return false;
}
$(function(){
    $('input, textarea').placeholder();
    $('input[name=username]').focus();
    $('.agreement-btn').click(function(){
        if($('.register-agreement').is(":visible")){
            $('.register-agreement').hide();
        }else{
            $('.register-agreement').show();
        }
    });
    $('.captcha_show img').click(function(){
        var osrc=$('.captcha_show img').attr('orgisrc');
        $('.captcha_show img').attr('src',osrc+(osrc.indexOf('?')>=0?'&':'?')+'t='+Math.random() );
        return false;
    });
});
</script>
<?php $this->display('user/login_foot.php'); ?>