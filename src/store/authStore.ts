import { defineStore } from 'pinia';
import { useMainStore } from './mainStore';
import { UserType } from '../types/User.type';

export const useAuthStore = defineStore('authStore', {
    state: () => ({
        user: null as UserType | null
    }),

    getters: {

    },

    actions: {
        // get authenticated user
        async getUser() {
            const mainStore = useMainStore();

            await fetch(`${mainStore.appURL}/index.php?getUser`, {
                method: 'GET',
                credentials: 'include'
            })
                .then(response => response.json())
                .then(result => {
                    this.user = result.user;
                })
                .catch(error => console.log('Error in getting user: ', error));
        },

        // handle sign in
        async signIn(username: string, password: string) {
            const mainStore = useMainStore();

            await fetch(`${mainStore.appURL}/index.php`, {
                method: 'POST',
                credentials: 'include',
                body: JSON.stringify({
                    username,
                    password
                })
            })
                .then(response => response.json())
                .then(result => {
                    this.user = result.user;
                })
                .catch(error => console.log('Error in signing in: ', error));
        },

        // handle sign out
        async signOut() {
            const mainStore = useMainStore();

            await fetch(`${mainStore.appURL}/index.php`, {
                method: 'POST',
                credentials: 'include',
                body: JSON.stringify({
                    signOut: true
                })
            })
                .then(response => response.json())
                .then(result => {
                    this.user = null;
                })
                .catch(error => console.log('Error in signing out: ', error));
        }
    }
});
