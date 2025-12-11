<template>
    <div>
        <h2>{{ isEditing ? 'Edit Task' : 'New Task' }}</h2>
        <form @submit.prevent="submitForm">
            <input v-model="form.title" placeholder="Title" required />
            <textarea v-model="form.description" placeholder="Description"></textarea>

            <select v-model="form.status" required>
                <option value="new">New</option>
                <option value="in_progress">In Progress</option>
                <option value="done">Done</option>
                <option value="archived">Archived</option>
            </select>

            <select v-model.number="form.priority" required>
                <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
            </select>

            <input type="date" v-model="form.due_date" />

            <select v-model="form.karada_project" required>
                <option value="karada_u">karada_u</option>
                <option value="prohuntr">prohuntr</option>
                <option value="other">other</option>
            </select>

            <button type="submit">{{ isEditing ? 'Update' : 'Create' }}</button>
        </form>
        <p v-if="error">{{ error }}</p>
    </div>
</template>

<style scoped>
h2 {
    color: #2f3640;
    margin-bottom: 10px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

input, select, textarea, button {
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #dcdde1;
    font-size: 16px;
}

textarea {
    resize: vertical;
    min-height: 60px;
}

button {
    width: 120px;
    background-color: #44bd32;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}

button:hover {
    background-color: #4cd137;
}

p {
    color: red;
    font-weight: bold;
}
</style>


<script setup>
import { reactive, ref } from 'vue';
import api from '../services/api';
const emit = defineEmits(['saved']);

const form = reactive({ id:null, title:'', description:'', status:'new', priority:1, due_date:'', karada_project:'karada_u' });
const error = ref(null);
const isEditing = ref(false);

function setTask(task){
    Object.assign(form, task);
    isEditing.value = true;
}

async function submitForm(){
    try{
        if(isEditing.value){
            await api.put(`/tasks/${form.id}`, {
                title: form.title,
                description: form.description,
                status: form.status,
                priority: form.priority,
                due_date: form.due_date,
                karada_project: form.karada_project
            });
        } else {
            await api.post('/tasks', {
                title: form.title,
                description: form.description,
                status: form.status,
                priority: form.priority,
                due_date: form.due_date,
                karada_project: form.karada_project
            });
        }
        emit('saved');
        resetForm();
    }catch(e){
        error.value = e.response?.data?.message || 'Error saving task';
    }
}

function resetForm(){
    form.id = null; form.title=''; form.description=''; form.status='new'; form.priority=1; form.due_date=''; form.karada_project='karada_u';
    isEditing.value = false;
}

defineExpose({ setTask });
</script>
