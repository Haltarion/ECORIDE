export function sanitizeString(str) {
    str = str.replace(/^.*[\\/]/, "");
    str = str.replace(/[<>:"'|?*]/g, "_");
    str = str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    return str;
}

export function isAllowedType(file, allowedTypes) {
    return allowedTypes.includes(file.type);
}

export function isAllowedSize(file, maxSize) {
    return file.size <= maxSize;
}
