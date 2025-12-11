import { reactive } from 'vue';

export const authState = reactive({
    token: localStorage.getItem('token') || null,
    get isAuthenticated() {
        return !!this.token;
    }
});

export function setToken(token) {
    authState.token = token;
    localStorage.setItem('token', token);
}

export function clearToken() {
    authState.token = null;
    localStorage.removeItem('token');
}
