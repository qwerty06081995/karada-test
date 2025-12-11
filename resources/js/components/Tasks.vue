<template>
    <div>
        <TaskForm ref="taskForm" @saved="loadTasks" />
        <TaskList :tasks="tasks" @deleted="loadTasks" @edit="editTask" />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import TaskForm from './TaskForm.vue';
import TaskList from './TaskList.vue';
import api from '../services/api';

const tasks = ref([]);
const taskForm = ref(null);

async function loadTasks() {
    try {
        const { data } = await api.get('/tasks');
        console.log('API response:', data);
        tasks.value = Array.isArray(data) ? data : [];
    } catch(e) {
        tasks.value = [];
        console.error(e);
    }
}

function editTask(task) {
    taskForm.value.setTask(task);
}

onMounted(loadTasks);
</script>
