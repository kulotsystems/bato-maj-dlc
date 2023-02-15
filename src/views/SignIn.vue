<template>
    <v-row class="ma-0 fill-height" justify="center" align="center">
        <v-col cols="12" sm="8" md="6" lg="5" class="px-5">
            <v-form @submit="handleSignIn">
                <v-img
                    :src="`/${store.appName}/logo.png`"
                    aspect-ratio="1"
                    height="400"
                    class="mb-4"
                >
                  <template v-slot:placeholder>
                    <v-row
                        class="fill-height ma-0"
                        align="center"
                        justify="center"
                    >
                      <v-progress-circular
                          indeterminate
                          color="grey-lighten-5"
                      ></v-progress-circular>
                    </v-row>
                  </template>
                </v-img>
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
    import { useStore } from '../store/store';
    import { useAuthStore } from '../store/store-auth';
    import { usePortionStore } from '../store/store-portion';

    // use hooks
    const router = useRouter();
    const store = useStore();
    const authStore = useAuthStore();
    const portionStore = usePortionStore();


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
            if (authStore.user) {
                await router.replace({
                    name: authStore.user.userType,
                    params: {
                        portion: portionStore.activePortion
                    }
                });
            }
            loading.value = false;
        }
    };
</script>


<style scoped>

</style>