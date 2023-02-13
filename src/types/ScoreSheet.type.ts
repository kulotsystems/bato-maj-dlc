import { ContingentArrayType } from './Contingent.type';
import { CriteriaArrayType } from './Criteria.type';
import { RatingsType } from './Rating.type';
import { DeductionsType } from './Deduction.type';

export type ScoreSheetType = {
    contingents: ContingentArrayType,
    criteria   : CriteriaArrayType,
    ratings    : RatingsType,
    ready: boolean
};

export type DeductionSheetType = {
    contingents: ContingentArrayType,
    deductions : DeductionsType,
    ready: boolean
};