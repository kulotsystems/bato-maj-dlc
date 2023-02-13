import { UserIDType } from './User.type';
import { ContingentIDType } from './Contingent.type';
import { PortionKeyType } from './Portion.type';
import {
    RatingIDType,
    RatingIsLockedType,
    RatingValueType
} from './Rating.type';


export type DeductionType = {
    id: RatingIDType,
    value: RatingValueType,
    is_locked: RatingIsLockedType,
    technical_id: UserIDType,
    contingent_id: ContingentIDType,
    loading: boolean
};

export type DeductionsType = {
    [key: string]: DeductionType
};

export type DeductionPayloadType = {
    portion: PortionKeyType,
    contingentID: ContingentIDType,
    technicalID: UserIDType,
    value: RatingValueType
};

export type DeductionFinalsRowPayloadType = {
    contingentID: ContingentIDType,
    value: RatingValueType
};

export type DeductionFinalsPayloadType = {
    portion: PortionKeyType,
    technicalID: UserIDType,
    rows: Array<DeductionFinalsRowPayloadType>
};