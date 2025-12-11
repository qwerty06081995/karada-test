<template>
    <div>
        <h2>My Tasks</h2>
        <table v-if="tasks.length">
            <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Due Date</th>
                <th>Project</th>
                <th>Importance Score</th>
                <th>Test Label</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="task in tasks" :key="task.id">
                <td>{{ task.title }}</td>
                <td>{{ task.status }}</td>
                <td>{{ task.priority }}</td>
                <td>{{ task.due_date || '-' }}</td>
                <td>{{ task.karada_project }}</td>
                <td>{{ task.importance_score }}</td>
                <td>{{ task.karada_test_label }}</td>
                <td>
                    <button @click="$emit('edit', task)">Edit</button>
                    <button @click="deleteTask(task.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
        <p v-else>No tasks yet</p>
    </div>
</template>

<style scoped>
h2 {
    margin-bottom: 10px;
    color: #2f3640;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #dcdde1;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f1f2f6;
}

button {
    margin-right: 5px;
    padding: 5px 10px;
    border-radius: 4px;
    border: none;
    font-size: 14px;
    cursor: pointer;
}

button:hover {
    opacity: 0.8;
}

button:nth-child(1) { background-color: #e1b12c; color: #fff; } /* Edit */
button:nth-child(2) { background-color: #e84118; color: #fff; } /* Delete */
</style>


<script setup>
import api from '../services/api';
const props = defineProps({ tasks: Array });
const emit = defineEmits(['deleted','edit']);

async function deleteTask(id){
    try{
        await api.delete(`/tasks/${id}`);
        emit('deleted');
    }catch(e){
        console.error(e);
    }
}
</script>
