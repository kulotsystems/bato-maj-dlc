import { defineStore } from 'pinia';

export const useMainStore = defineStore('mainStore', {
    state: () => ({
        app: {
            dir: 'bato-maj-dlc',
            url: '',
            backendDir: 'app'
        }
    }),

    getters: {
        appDir():string {
            return this.app.dir;
        },

        appURL():string {
            const location = window.location;
            if(location.hostname == 'localhost' && location.port == '5175')
                return `http://localhost/${this.app.dir}/${this.app.backendDir}`;
            else
                return `${this.app.backendDir}`;
        }
    }
});