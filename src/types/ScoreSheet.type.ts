import { ContingentArrayType } from './Contingent.type';
import { CriteriaArrayType } from './Criteria.type';
import { RatingsType } from './Rating.type';

export type ScoreSheetType = {
    contingents: ContingentArrayType,
    criteria   : CriteriaArrayType,
    ratings    : RatingsType,
    ready: boolean
}