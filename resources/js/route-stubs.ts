// Minimal stubbed routes to avoid runtime errors while real routes are unavailable

type RouteStub = {
    (): string;
    url: () => string;
    form: () => Record<string, unknown>;
};

const createRoute = (): RouteStub => {
    const fn = (() => '#') as RouteStub;
    fn.url = () => '#';
    fn.form = () => ({});
    return fn;
};

export const dashboard = createRoute();
export const login = createRoute();
export const register = createRoute();
export const home = createRoute();
export const logout = createRoute();

// profile
export const edit = createRoute();

// verification
export const send = createRoute();

// user-password
export const update = createRoute();
export const request = createRoute();
export const email = createRoute();

// password/confirm, login, register – commonly export `store`
export const store = createRoute();

// two-factor
export const enable = createRoute();
export const disable = createRoute();
export const show = createRoute();
export const confirm = createRoute();
export const regenerateRecoveryCodes = createRoute();
export const qrCode = createRoute();
export const recoveryCodes = createRoute();
export const secretKey = createRoute();

