import {
    ContingentIDType,
    ContingentIsActiveType,
    ContingentLogoType,
    ContingentNumberType,
    ContingentSchoolType
} from './Contingent.type';
import { CriteriaArrayType } from './Criteria.type';

import { RatingValueType } from './Rating.type';
import {
    UserAvatarType,
    UserFullNameType,
    UserIDType,
    UserNumberType
} from './User.type';


export type ResultContingentType = {
    id: ContingentIDType,
    number: ContingentNumberType,
    school: ContingentSchoolType,
    logo: ContingentLogoType,
    is_active: ContingentIsActiveType,
    deduction: {
        total: RatingValueType,
        average: RatingValueType
    },
    rating: {
        total: RatingValueType,
        average:RatingValueType
    },
    rank: {
        dense: {
            total: RatingValueType,
            average: RatingValueType
        },
        fraction: {
            total: RatingValueType,
            average: RatingValueType
        }
    },
    final: {
        rating_average: {
            less_deduction_total: RatingValueType,
            less_deduction_average: RatingValueType
        }
    }
};

export type ResultContingentArrayType = Array<ResultContingentType>;

export type ResultJudgeRatingsType = {
    [key: string]: {
        value: RatingValueType,
        locked: 0 | 1,
        rank: {
            dense: RatingValueType,
            fraction: RatingValueType
        }
    }
};

export type ResultJudgeType = {
    id      : UserIDType,
    number  : UserNumberType
    fullname: UserFullNameType,
    avatar  : UserAvatarType,
    is_chairman: 0 | 1,
    ratings: ResultJudgeRatingsType
};

export type ResultJudgeArrayType = Array<ResultJudgeType>;

export type ResultTechnicalType = {
    id      : UserIDType,
    number  : UserNumberType
    fullname: UserFullNameType,
    avatar  : UserAvatarType,
    deductions: ResultJudgeRatingsType
};

export type ResultTechnicalArrayType = Array<ResultTechnicalType>;

export type ResultSheetType = {
    contingents: ResultContingentArrayType,
    criteria: CriteriaArrayType,
    judges: ResultJudgeArrayType,
    technicals: ResultTechnicalArrayType,
    ready: boolean
};