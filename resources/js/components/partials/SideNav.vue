<template>
    <nav class="side-menu">
        <div class="side-menu-avatar">
            <div class="avatar-preview avatar-preview-100">
                <img v-bind:src="'startui/img/avatar-1-256.png'" alt="">
            </div>
        </div>
        <ul class="side-menu-list">
            <li class="grey">
                <router-link exact-active-class="active" to="/home">
                    <i class="font-icon font-icon-dashboard"></i>
                    <span class="lbl">Dashboard</span>
                </router-link>
            </li>
            <li class="blue with-sub">
            <span><i class="font-icon font-icon-users"></i>
                <span class="lbl">Usuarios</span>
            </span>
                <ul>
                    <li><router-link exact-active-class="active" to="/mostrar"><span class="lbl">Gestionar</span></router-link></li>
<!--                    <li><a href="{{route('roles.index')}}"><span class="lbl">Roles</span></a></li>-->
                </ul>
            </li>
        </ul>
    </nav>
</template>
