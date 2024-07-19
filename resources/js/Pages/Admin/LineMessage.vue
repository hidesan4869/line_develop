<template>
    <div>
        <h1>Send Message</h1>
        <div v-if="successMessage" style="color: green;">{{ successMessage }}</div>
        <div v-if="errorMessage" style="color: red;">{{ errorMessage }}</div>
        <form @submit.prevent="sendMessage">
        <div>
            <label for="user_id">User ID:</label>
            <input type="text" id="user_id" v-model="form.user_id" required>
        </div>
        <div>
            <label for="message">Message:</label>
            <textarea id="message" v-model="form.message" required></textarea>
        </div>
        <button type="submit">Send</button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';

export default {
    setup() {
        const form = useForm({
        user_id: '',
        message: ''
        });

        const successMessage = ref('');
        const errorMessage = ref('');

        const sendMessage = async () => {
        successMessage.value = '';
        errorMessage.value = '';
        form.post('/admin/line-message', {
            onSuccess: () => {
                successMessage.value = 'Message sent successfully!';
                form.reset();
            },
                onError: (errors) => {
                errorMessage.value = 'Failed to send message: ' + errors.message;
            }
        });
        };

        return {
            form,
            sendMessage,
            successMessage,
            errorMessage
        };
    }
};
</script>
