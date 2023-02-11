import { defineStore } from 'pinia';
import { PortionKeyType, PortionsType } from '../types/Portion.type';

export const usePortionStore = defineStore('portionStore', {
    state: () => ({
        portions: {
            maj: {
                title: 'Majorettes',
                icon : 'mdi-human-female-dance'
            },
            dlc: {
                title: 'Drum & Lyre',
                icon : 'mdi-music'
            }
        } as PortionsType,

        activePortion: 'maj' as PortionKeyType
    }),

    getters: {

    },

    actions: {
        setActivePortion(key: PortionKeyType) {
            this.activePortion = key;
        }
    }
});