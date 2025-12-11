<template>
    <div class="auth-container">
        <h2>Login</h2>
        <form @submit.prevent="login" class="auth-form">
            <input v-model="email" type="email" placeholder="Email" required />
            <input v-model="password" type="password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>
        <p class="error" v-if="error">{{ error }}</p>
        <p class="switch">
            Don't have an account? <router-link to="/register">Register here</router-link>
        </p>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { setToken } from '../stores/auth';
import api from '../services/api';

const router = useRouter();
const email = ref('');
const password = ref('');
const error = ref('');

async function login() {
    try {
        const { data } = await api.post('/login', { email: email.value, password: password.value });
        localStorage.setItem('token', data.token);
        setToken(data.token);
        router.push('/');
    } catch(e) {
        error.value = e.response?.data?.message || 'Login failed';
    }
}
</script>

<style scoped>
.auth-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 30px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    text-align: center;
}

.auth-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-top: 20px;
}

input {
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #dcdde1;
    font-size: 16px;
    transition: border 0.2s;
}

input:focus {
    border-color: #00a8ff;
    outline: none;
}

button {
    padding: 12px;
    border-radius: 6px;
    border: none;
    background-color: #00a8ff;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}

button:hover {
    background-color: #0097e6;
}

.error {
    color: #e84118;
    font-weight: bold;
    margin-top: 10px;
}

.switch {
    margin-top: 15px;
    font-size: 14px;
}

.switch a {
    color: #00a8ff;
    text-decoration: none;
    font-weight: bold;
}

.switch a:hover {
    text-decoration: underline;
}
</style>
