import { UserIDType } from './User.type';
import { CriteriaIDType } from './Criteria.type';
import { ContingentIDType } from './Contingent.type';

export type RatingIDType = number;

export type RatingValueType = number;

export type RatingIsLockedType = number;

export type RatingType = {
    id: RatingIDType,
    value: RatingValueType,
    is_locked: RatingIsLockedType,
    judge_id: UserIDType,
    criteria_id: CriteriaIDType,
    contingent_id: ContingentIDType
}

export type RatingsType = null | {
    [key: string]: RatingType
}