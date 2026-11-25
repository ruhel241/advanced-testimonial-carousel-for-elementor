// Remember WordPress's global Underscore before any bundled library
// (e.g. Lodash via webpack's AMD shim) can overwrite window._.
window.__atcPrevUnderscore = window._;
