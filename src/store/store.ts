import { defineStore } from 'pinia';
import { MethodType, InitType } from '../types/Request.type';

export const useStore = defineStore('store', {
    state: () => ({
        app: {
            backendDir: 'app'
        },
        sidebar: {
            opened: false
        },
        window: {
            height: 0
        },
        rating: {
            max: 100,
            min: 75
        }
    }),

    getters: {
        // get app name
        appName() {
            return import.meta.env.BASE_URL.replaceAll('/', '');
        },

        // get app backend url
        appURL():string {
            const location = window.location;
            if(location.hostname == 'localhost' && location.port == '5175')
                return `http://localhost${import.meta.env.BASE_URL}${this.app.backendDir}`;
            else
                return `${location.protocol}//${location.hostname}${import.meta.env.BASE_URL}${this.app.backendDir}`;
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
            return await fetch(input, init)
                .then(response => response.json())
                .catch(error => {
                    return { error: error.message }
                });
        },

        // open or hide sidebar
        toggleSidebar(bool: boolean) {
            this.sidebar.opened = bool;
        },

        // set window height
        setWindowHeight(height: number) {
            this.window.height = height;
        }
    }
});