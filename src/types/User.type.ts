export type UserType = null | {
    userType: 'admin' | 'judge' | 'technical',
    username: string,
    fullName: string,
    avatar  : string
};