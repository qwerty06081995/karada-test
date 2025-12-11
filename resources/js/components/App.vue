<template>
    <Header />
    <router-view></router-view>
</template>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f5f6fa;
    margin: 0;
    padding: 0;
}

#app {
    margin: 50px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}
</style>
<script setup>
import Header from './Header.vue';
</script>
