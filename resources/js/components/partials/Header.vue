<template>
<header class="site-header">
<div class="container-fluid">

    <a href="#" class="site-logo">
        <img class="hidden-md-down" v-bind:src="'startui/img/logo-2.png'" alt="">
        <img class="hidden-lg-up" v-bind:src="'startui/img/logo-2-mob.png'" alt="">
    </a>

    <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
        <span>toggle menu</span>
    </button>

    <button class="hamburger hamburger--htla">
        <span>toggle menu</span>
    </button>
    <div class="site-header-content">
        <div class="site-header-content-in">
            <div class="site-header-shown">
                <div class="dropdown dropdown-notification notif">
                    <a href="#"
                       class="header-alarm dropdown-toggle active"
                       id="dd-notification"
                       data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        <i class="font-icon-alarm"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-notif"
                         aria-labelledby="dd-notification">
                        <div class="dropdown-menu-notif-header">
                            Notifications
                            <span class="label label-pill label-danger">4</span>
                        </div>
                        <div class="dropdown-menu-notif-list">
                            <div class="dropdown-menu-notif-item">
                                <div class="photo">
                                    <img v-bind:src="'startui/img/photo-64-1.jpg'" alt="">
                                </div>
                                <div class="dot"></div>
                                <a href="#">Morgan</a> was bothering about something
                                <div class="color-blue-grey-lighter">7 hours ago</div>
                            </div>
                            <div class="dropdown-menu-notif-item">
                                <div class="photo">
                                    <img v-bind:src="'startui/img/photo-64-2.jpg'" alt="">
                                </div>
                                <div class="dot"></div>
                                <a href="#">Lioneli</a> had commented on this <a href="#">Super Important Thing</a>
                                <div class="color-blue-grey-lighter">7 hours ago</div>
                            </div>
                            <div class="dropdown-menu-notif-item">
                                <div class="photo">
                                    <img v-bind:src="'startui/img/photo-64-3.jpg'" alt="">
                                </div>
                                <div class="dot"></div>
                                <a href="#">Xavier</a> had commented on the <a href="#">Movie title</a>
                                <div class="color-blue-grey-lighter">7 hours ago</div>
                            </div>
                            <div class="dropdown-menu-notif-item">
                                <div class="photo">
                                    <img v-bind:src="'startui/img/photo-64-4.jpg'" alt="">
                                </div>
                                <a href="#">Lionely</a> wants to go to <a href="#">Cinema</a> with you to see <a
                                href="#">This Movie</a>
                                <div class="color-blue-grey-lighter">7 hours ago</div>
                            </div>
                        </div>
                        <div class="dropdown-menu-notif-more">
                            <a href="#">See more</a>
                        </div>
                    </div>
                </div>

                <div class="dropdown dropdown-notification messages">
                    <a href="#"
                       class="header-alarm dropdown-toggle active"
                       id="dd-messages"
                       data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        <i class="font-icon-mail"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-messages"
                         aria-labelledby="dd-messages">
                        <div class="dropdown-menu-messages-header">
                            <ul class="nav" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       data-toggle="tab"
                                       href="#tab-incoming"
                                       role="tab">
                                        Inbox
                                        <span class="label label-pill label-danger">8</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                       data-toggle="tab"
                                       href="#tab-outgoing"
                                       role="tab">Outbox</a>
                                </li>
                            </ul>
                            <!--<button type="button" class="create">
                                <i class="font-icon font-icon-pen-square"></i>
                            </button>-->
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-incoming" role="tabpanel">
                                <div class="dropdown-menu-messages-list">
                                    <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                src="startui/img/photo-64-2.jpg" alt=""></span>
                                        <span class="mess-item-name">Tim Collins</span>
                                        <span class="mess-item-txt">Morgan was bothering about something!</span>
                                    </a>
                                    <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                src="startui/img/avatar-2-64.png" alt=""></span>
                                        <span class="mess-item-name">Christian Burton</span>
                                        <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something.</span>
                                    </a>
                                    <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                src="startui/img/photo-64-2.jpg" alt=""></span>
                                        <span class="mess-item-name">Tim Collins</span>
                                        <span class="mess-item-txt">Morgan was bothering about something!</span>
                                    </a>
                                    <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                src="startui/img/avatar-2-64.png" alt=""></span>
                                        <span class="mess-item-name">Christian Burton</span>
                                        <span class="mess-item-txt">Morgan was bothering about something...</span>
                                    </a>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-outgoing" role="tabpanel">
                                <div class="dropdown-menu-messages-list">
                                    <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                src="startui/img/avatar-2-64.png" alt=""></span>
                                        <span class="mess-item-name">Christian Burton</span>
                                        <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something...</span>
                                    </a>
                                    <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                src="startui/img/photo-64-2.jpg" alt=""></span>
                                        <span class="mess-item-name">Tim Collins</span>
                                        <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something.</span>
                                    </a>
                                    <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                src="startui/img/avatar-2-64.png" alt=""></span>
                                        <span class="mess-item-name">Christian Burtons</span>
                                        <span class="mess-item-txt">Morgan was bothering about something!</span>
                                    </a>
                                    <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                src="startui/img/photo-64-2.jpg" alt=""></span>
                                        <span class="mess-item-name">Tim Collins</span>
                                        <span class="mess-item-txt">Morgan was bothering about something!</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-menu-notif-more">
                            <a href="#">See more</a>
                        </div>
                    </div>
                </div>

                <div class="dropdown user-menu">
                    <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <img src="startui/img/avatar-2-64.png" alt="">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                        <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-user"></span>Perfil</a>
                        <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-cog"></span>Configuración</a>
                        <a class="dropdown-item" href="#"><span
                            class="font-icon glyphicon glyphicon-question-sign"></span>Ayuda</a>
                        <div class="dropdown-divider"></div>
                        <!--                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                             document.getElementById('logout-form').submit();"><span
                                                    class="font-icon glyphicon glyphicon-log-out"></span>Salir</a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>-->
                    </div>
                </div>
            </div><!--.site-header-shown-->

        </div><!--site-header-content-in-->
    </div><!--.site-header-content-->
</div><!--.container-fluid-->
</header><!--.site-header-->
</template>
