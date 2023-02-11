export type ContingentIDType = number;

export type ContingentNumberType = number;

export type ContingentSchoolType = string;

export type ContingentLogoType = null | string;

export type ContingentIsActiveType = 0 | 1;

export type ContingentType = {
    id: ContingentIDType,
    number: ContingentNumberType,
    school: ContingentSchoolType,
    logo: ContingentLogoType,
    is_active: ContingentIsActiveType
};

export type ContingentArrayType = Array<ContingentType>;