export const laravelErrorToZodError = (error: { [index: string]: any }) => {
    let result = {};
    for (let key in error) {
        const parts = key.split(".");
        let next = result;
        parts.forEach((p, i) => {
            if (!next[p]) {
                if (parts[i + 1] == undefined) {
                    next[p] = { _errors: error[key] };
                } else {
                    next[p] = isNaN(parts[i + 1]as unknown as number) ? {} : [];
                }
            }
            next = next[p];
        });
    }
    return {...result }
};
