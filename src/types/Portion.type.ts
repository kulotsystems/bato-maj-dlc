export type PortionKeyType = 'maj' | 'dlc';

export const isPortionKeyType = (value: any): value is PortionKeyType => {
    return value === 'maj' || value === 'dlc';
}

export type PortionTitleType = 'Majorettes' | 'Drum & Lyre';

export type PortionsType = {
    [key in PortionKeyType]: {
        title: PortionTitleType,
        icon : string
    }
}