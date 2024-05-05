<template>
    <div>
        <Header></Header>
        <SideNav></SideNav>
        <div class="mobile-menu-left-overlay"></div>
        <Panel></Panel>
        <div class="page-content">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
import SideNav from "./partials/SideNav";
import Header from "./partials/Header";
import Panel from "./partials/Panel.vue"

export default {
    components: {Header, SideNav, Panel}
}
</script>
