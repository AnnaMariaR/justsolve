import { HttpInterceptorFn } from '@angular/common/http';

export const authInterceptor: HttpInterceptorFn = (req, next) => {
  // Use admin credentials for all API requests, this is for testing purposes only
  const username = 'admin@example.com';
  const password = 'password';
  const basicAuth = 'Basic ' + btoa(`${username}:${password}`);

  const authReq = req.clone({
    setHeaders: {
      Authorization: basicAuth
    }
  });

  return next(authReq);
};
