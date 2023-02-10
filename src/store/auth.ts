import { defineStore } from 'pinia';
import { useStore } from './index';
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
            await useStore().requestAsync('GET', null, 'getUser')
                .then(result => {
                    this.user = result.user;
                })
                .catch(error => console.log('Error in getting user: ', error));
        },

        // handle sign in
        async signIn(username: string, password: string) {
            await useStore().requestAsync('POST', {
                username,
                password
            })
                .then(result => {
                    this.user = result.user;
                })
                .catch(error => console.log('Error in signing in: ', error));
        },

        // handle sign out
        async signOut() {
            await useStore().requestAsync('POST', {
                signOut: true
            })
                .then(result => {
                    this.user = null;
                })
                .catch(error => console.log('Error in signing out: ', error));

        }
    }
});
