<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>WeTrue</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
    />
    <meta name="description" content="Choose between regular React Bootstrap tables or advanced dynamic ones.">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
<link rel="icon" href="/assets/images/favicon.ico">
<link rel="stylesheet" href="/main.css?v=1.0.3">
<link rel="stylesheet" href="/assets/css/WET.css?v=<?php echo $WeTrue?>">
</head>
<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar fixed-footer">
    <div class="app-header header-shadow">
        <div class="app-header__logo">
            <div class="logo-src"></div>
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
        <div class="app-header__menu">
            <span>
                <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                    <span class="btn-icon-wrapper">
                        <i class="fa fa-ellipsis-v fa-w-6"></i>
                    </span>
                </button>
            </span>
        </div>
		<div class="app-header__content">
            <div class="app-header-left">
                <div class="search-wrapper">
                    <div class="input-holder">
						<input type="text" id="suid" class="search-input" placeholder="Content, Comment, UserName..." onkeydown="keyup_submittop(event);" target="_blank">
						<button type="submit" class="search-icon" target="_blank"><span></span></button>
                    </div>
                    <button class="close"></button>
                </div>
			</div>
            <div class="app-header-right">
                <div class="header-dots">
 
					<div class="dropdown">
                        <button type="button" aria-haspopup="true" data-toggle="dropdown" aria-expanded="false" class="p-0 mr-2 btn btn-link dd-chart-btn">
                            <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                <span class="icon-wrapper-bg bg-success"></span>
                                <i class="icon text-success fa fa-chart-line"></i>
                            </span>
                        </button>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-premium-dark">
                                    <div class="menu-header-image" style="background-image: url('/assets/images/dropdown-header/abstract4.jpg');"></div>
                                    <div class="menu-header-content text-white">
                                        <h5 class="menu-header-title">AE Price
                                        </h5>
                                        <h6 class="menu-header-subtitle">AEternity Token Price
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-chart">
                                <div class="widget-chart-content">

                                    <div class="widget-numbers">
                                        <span><?php echo $AeLast?> USDT</span>
                                    </div>
                                    <div class="widget-description text-danger">                                        
                                        <span><?php echo $AepercentChange?>%</span>
                                        <i class="fa fa-arrow-left"></i>
                                    </div>
                                    <div class="widget-subheading pt-2">
                                    24小时最高：<?php echo $Aehigh24hr?>
                                    <br>
                                    24小时最低：<?php echo $Aelow24hr?>
                                    </div>
                                </div>
                                <div class="widget-chart-wrapper">
                                    <div id="dashboard-sparkline-carousel-3-pop"></div>
                                </div>
                            </div>
                            <ul class="nav flex-column">
                                <li class="nav-item-divider mt-0 nav-item">
                                </li>
                                <li class="nav-item-btn text-center nav-item">
                                    <button class="btn-shine btn-wide btn-pill btn btn-warning btn-sm">
                                        <i class="fa fa-cog fa-spin mr-2">
                                        </i>
                                        查看
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
 <!-- 
                    <div class="dropdown">
                        <button type="button" data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                            <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                <span class="icon-wrapper-bg bg-focus"></span>
                                <i class="icon text-danger fa fa-bell"></i>
                            </span>
                        </button>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                            <div class="dropdown-menu-header mb-0">
                                <div class="dropdown-menu-header-inner bg-deep-blue">
                                    <div class="menu-header-image opacity-1"></div>
                                    <div class="menu-header-content text-dark">
                                        <h5 class="menu-header-title">Notifications</h5>
                                        <h6 class="menu-header-subtitle">You have <b>21</b> unread messages</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-messages-header" role="tabpanel">
                                    <div class="scroll-area-sm">
                                        <div class="scrollbar-container">
                                            <div class="p-3">
                                                <div class="notifications-box">
                                                    <div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">

                                                        <div class="vertical-timeline-item dot-success vertical-timeline-element">
                                                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">Build the production release </h4>
                                                                    <span class="vertical-timeline-element-date"></span></div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item dot-primary vertical-timeline-element">
                                                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">Something not important </h4>
                                                                   <span class="vertical-timeline-element-date"></span></div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
 -->
					<div class="dropdown">
                        <button type="button" data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                            <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                <span class="icon-wrapper-bg bg-focus"></span>
                                
                                <i class="icon fa fa-language"></i>
                            </span>
                        </button>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">

                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-premium-dark">
                                    <div class="menu-header-content text-white">
                                        <h6 class="menu-header-subtitle" i18n="chooselanguage">Choose Language</h6>
                                    </div>
                                </div>
                            </div>
							<button type="button" tabindex="0" class="trans-lang dropdown-item trans-cn" value="简体中文">简体中文</button>
                            <button type="button" tabindex="0" class="trans-lang dropdown-item trans-en" value="English">English</button>

                        </div>
                    </div>

					<div class="dropdown" style="display:none" id="addTch">
                        <a href="/Content/Post"><button  class="p-0 btn">
                            <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                <span class="icon-wrapper-bg bg-danger"></span>
								<i class="fa fa-plus icon-anim-pulse"></i>
								<span class="badge badge-dot badge-dot-sm badge-danger">闪烁发文</span>
                            </span>
                        </button></a>
                    </div>

				</div>
                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <img width="42" height="42" class="rounded-circle" src="/assets/images/avatars/null.jpg" id="portrait_1"> 
                                </a>
                                    <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-menu-header">
                                            <div class="dropdown-menu-header-inner bg-info">
                                                <div class="menu-header-image opacity-2" style="background-image: url('/assets/images/avatars/null.jpg');"></div>
                                                <div class="menu-header-content text-left">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <div class="hy-txa">
                                                                <img width="42" height="42" class="rounded-circle" src="/assets/images/avatars/null.jpg" id="portrait_2">
                                                                <a href="/Portrait"><span i18n="edit">编辑</span></a>
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading" id="ueserName_2"><n i18n="no">未</n><n i18n="login">登录</n></div>
                                                                <div class="widget-subheading opacity-8" id="WalletId2"></a></div>
                                                            </div>
                                                            <div class="widget-content-right mr-2">
                                                                <button class="btn-pill btn btn-light" style="display:none;" id="userCenter"><a href="#" id="userCenterurl" i18n="MyHomepage">个人主页</a></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="scroll-area-xs" style="height: 50px;">
                                            <div class="scrollbar-container ps">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a href="javascript:void(0);" class="nav-link"><n i18n="balance">当前余额</n>
                                                            <div class="ml-auto badge badge-pill badge-info" id="balance">0.00000 AE
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <ul class="nav flex-column">
                                            <li class="nav-item-divider mb-0 nav-item"></li>
                                        </ul>
                                        <div class="grid-menu grid-menu-2col">
                                            <div class="no-gutters row">
                                                <div class="col-sm-12" style="display:none" id="NewUserActivity">
                                                    <button class="AskForAE btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-danger">
                                                        <i class="fa fa-american-sign-language-interpreting icon-gradient bg-love-kiss btn-icon-wrapper mb-2"></i>
                                                        <b><n i18n="AskFor">索取</n> AE</b>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <ul class="nav flex-column">
                                            <li class="nav-item-divider nav-item">
                                            </li>
                                            <li class="nav-item-btn text-center nav-item">
                                                <button class="btn btn-focus" id="loginout"><a href="/login" class="btn btn-focus" i18n="login">登录</a></button>
                                                <button class="btn btn-focus" onclick="LogoutBtn_click()" style="display:none;" id="logout" i18n="logout">清除登录</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <div class="widget-content-left  ml-3 header-user-info">
                                <div class="widget-heading" id="ueserName_1"><a href="/Login"><n i18n="login">登录</n></div>
                                <div class="widget-subheading" id="WalletId1">
                                <n i18n="click">点击</n><n i18n="login">登录</n></a>
                                </div>
                            </div>
                                    
                        </div>
                    </div>
                </div>
                <div class="header-btn-lg">
                    <button type="button" class="hamburger hamburger--elastic open-right-drawer">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>        </div>
        </div>
    </div>
<?php $this->load->view('Admin/Left'); ?>