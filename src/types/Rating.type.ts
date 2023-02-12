import { UserIDType } from './User.type';
import { CriteriaIDType } from './Criteria.type';
import { ContingentIDType } from './Contingent.type';
import { PortionKeyType } from './Portion.type';

export type RatingIDType = number;

export type RatingValueType = number;

export type RatingIsLockedType = 0 | 1;

export type RatingType = {
    id: RatingIDType,
    value: RatingValueType,
    is_locked: RatingIsLockedType,
    judge_id: UserIDType,
    criteria_id: CriteriaIDType,
    contingent_id: ContingentIDType
};

export type RatingsType = {
    [key: string]: RatingType
};

export type RatingTotalType = {
    value: RatingValueType,
    is_locked: RatingIsLockedType,
    loading: boolean
};

export type RatingTotalsType = {
    [key: string]: RatingTotalType // key: `t_${contingent_id}`
};

export type RatingPayloadValueType = {
    criteriaID: CriteriaIDType,
    value: RatingValueType
};

export type RatingPayloadType = {
    portion: PortionKeyType,
    contingentID: ContingentIDType,
    judgeID: UserIDType,
    values: Array<RatingPayloadValueType>
};