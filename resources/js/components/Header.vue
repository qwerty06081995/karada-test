<template>
    <header class="header">
        <h1 class="logo">KARADA Tasks</h1>
        <nav>
            <button v-if="!authState.isAuthenticated" @click="$router.push('/login')">Login</button>
            <button v-if="!authState.isAuthenticated" @click="$router.push('/register')">Register</button>
            <button v-if="authState.isAuthenticated" @click="logout">Logout</button>
        </nav>
    </header>
</template>

<script setup>
import { authState, clearToken } from '../stores/auth';
import { useRouter } from 'vue-router';
import api from '../services/api';

const router = useRouter();

async function logout() {
    try {
        await api.post('/logout');
    } catch(e) {
        console.error(e);
    }
    clearToken();
    router.push('/login');
}
</script>

<style scoped>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #2f3640;
    color: white;
}

.logo {
    font-size: 20px;
    font-weight: bold;
}

nav button {
    margin-left: 10px;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
}

nav button:hover {
    opacity: 0.8;
}

nav button:nth-child(1),
nav button:nth-child(2) {
    background-color: #44bd32;
    color: white;
}

nav button:nth-child(3) {
    background-color: #e84118;
    color: white;
}
</style>
