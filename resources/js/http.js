function getCsrfCookie() {
    return fetch('/sanctum/csrf-cookie', {
      credentials: 'include',
    });
}
  
export function baseFetch(url, options = {}) {
    const defaultOptions = {
      credentials: 'include',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        ...(options.method && options.method !== 'GET' ? { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } : {}),
        ...options.headers,
      },
    };
  
    // if (options.method && options.method !== 'GET') {
    //   // For state-changing requests, ensure CSRF cookie is set first
    //   return getCsrfCookie().then(() => fetch(url, { ...defaultOptions, ...options }));
    // }
  
    // For GET requests, just proceed with the fetch
    return fetch(url, { ...defaultOptions, ...options });
}
  