<template>
    <v-row class="ma-0 fill-height" justify="center" align="center">
        <v-col cols="12" sm="8" md="6" lg="5" class="px-5">
            <v-form @submit="handleSignIn">
                <v-text-field
                    v-model="username"
                    type="text"
                    label="Username"
                    variant="outlined"
                    class="mb-2"
                    :error="authStore.hasError"
                    @change="authStore.clearError()"
                />
                <v-text-field
                    v-model="password"
                    :type="passwordShown ? 'text' : 'password'"
                    label="Password"
                    variant="outlined"
                    class="mb-2"
                    :error="authStore.hasError"
                    :messages="authStore.error"
                    @change="authStore.clearError()"
                    :append-inner-icon="passwordShown ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:appendInner="togglePasswordShown"
                />
                <v-btn
                    type="submit"
                    color="primary"
                    size="large"
                    :loading="loading"
                >
                    Sign in
                </v-btn>
            </v-form>
        </v-col>
    </v-row>
</template>


<script lang="ts" setup>
    import { ref, computed } from 'vue';
    import { useRouter } from 'vue-router';
    import { useAuthStore } from '../store/auth';

    // use hooks
    const router = useRouter();
    const authStore = useAuthStore();


    // state
    const username = ref('');
    const password = ref('');
    const loading = ref(false);
    const passwordShown = ref(false);


    // computed
    const enteredUsername = computed(() => username.value.trim());
    const enteredPassword = computed(() => password.value);


    // methods
    const togglePasswordShown = () => {
        passwordShown.value = !passwordShown.value;
    };

    const handleSignIn = async (e: Event) => {
        e.preventDefault();
        if (enteredUsername.value != '' && enteredPassword.value != '') {
            loading.value = true;
            await authStore.signIn(enteredUsername.value, enteredPassword.value)
            if (authStore.user)
                await router.replace({name: authStore.user.userType});
            loading.value = false;
        }
    };
</script>


<style scoped>

</style>