export type MethodType = 'GET' | 'POST';

export type CredentialsType = 'include' | 'omit' | 'same-origin';

export type InitType = {
    method: MethodType,
    credentials: CredentialsType,
    body?: string
}