import { defineStore } from 'pinia';
import { MethodType, InitType } from '../types/Request.type';

export const useStore = defineStore('store', {
    state: () => ({
        app: {
            backendDir: 'app'
        }
    }),

    getters: {
        // return app backend url
        appURL():string {
            const location = window.location;
            if(location.hostname == 'localhost' && location.port == '5175')
                return `http://localhost${import.meta.env.BASE_URL}${this.app.backendDir}`;
            else
                return `${this.app.backendDir}`;
        }
    },

    actions: {
        // reusable async request
        async requestAsync(method: MethodType, body: null|object = null, params: string = '', file: string = 'index.php') {
            // input url
            let input = `${this.appURL}/${file}`;
            if(params != '')
                input += `?${params}`;

            // init options
            let init:InitType = {
                method,
                credentials: 'include',
            };
            if(body && method != 'GET')
                init.body = JSON.stringify(body);

            // request
            return await fetch(input, init).then(response => response.json());
        }
    }
});