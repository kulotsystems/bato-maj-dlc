import { ContingentArrayType } from './Contingent.type';
import { CriteriaArrayType } from './Criteria.type';

export type ScoreSheetType = {
    contingents: ContingentArrayType,
    criteria   : CriteriaArrayType,
    ready: boolean
}