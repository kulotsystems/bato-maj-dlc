export type CriteriaIDType = number;

export type CriteriaTitleType = string;

export type CriteriaPercentage = number;

export type CriteriaType = {
    id: CriteriaIDType,
    title: CriteriaTitleType,
    percentage: CriteriaPercentage
}

export type CriteriaArrayType = Array<CriteriaType>;