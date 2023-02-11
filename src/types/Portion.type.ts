export type PortionKeyType = 'maj' | 'dlc';

export type PortionTitleType = 'Majorettes' | 'Drum & Lyre';

export type PortionsType = {
    [key in PortionKeyType]: {
        title: PortionTitleType,
        icon : string
    }
}