import { defineStore } from 'pinia';
import { useStore } from './index';
import { UserType } from '../types/User.type';

export const useAuthStore = defineStore('authStore', {
    state: () => ({
        user : null as UserType | null,
        error: '',
    }),

    getters: {
        // get hasError
        hasError(state) {
            return state.error != '';
        }
    },

    actions: {
        // clear error
        clearError() {
            this.error = '';
        },


        // request authenticated user
        async getUser() {
            await useStore().requestAsync('GET', null, 'getUser')
                .then(result => {
                    if(result.error)
                        this.error = result.error;
                    else
                        this.user = result.user;
                });
        },

        // handle sign in
        async signIn(username: string, password: string) {
            this.error = '';
            await useStore().requestAsync('POST', {
                username,
                password
            })
                .then(result => {
                    if(result.error)
                        this.error = result.error;
                    else
                        this.user = result.user;
                });
        },

        // handle sign out
        async signOut() {
            await useStore().requestAsync('POST', {
                signOut: true
            })
                .then(result => {
                    if(result.error)
                        this.error = result.error;
                    else
                        this.user = null;
                });
        }
    }
});
