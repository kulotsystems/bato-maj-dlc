export type UserIDType = number;

export type UserUserTypeType = 'admin' | 'judge' | 'technical';

export type UserUsernameType = string;

export type UserFullNameType = string;

export type UserAvatarType = string;

export type UserNumberType = number;

export type UserType = null | {
    id      : UserIDType,
    userType: UserUserTypeType,
    username: UserUsernameType,
    fullName: UserFullNameType,
    avatar  : UserAvatarType,
    number  : UserNumberType
};