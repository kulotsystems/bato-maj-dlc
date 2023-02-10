import { defineStore } from 'pinia';

export const useMainStore = defineStore('mainStore', {
    state: () => ({
        app: {
            backendDir: 'app'
        }
    }),

    getters: {
        appURL():string {
            const location = window.location;
            if(location.hostname == 'localhost' && location.port == '5175')
                return `http://localhost${import.meta.env.BASE_URL}${this.app.backendDir}`;
            else
                return `${this.app.backendDir}`;
        }
    }
});