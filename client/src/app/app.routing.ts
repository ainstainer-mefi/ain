import { Routes, RouterModule } from '@angular/router';
import { ModuleWithProviders } from '@angular/core';

import { LoginComponent } from './auth/index';
import { AuthGuard } from './_guards/index';
import { PagesComponent, HomeComponent, NotFoundComponent, DocsComponent } from './pages/index';


export const appRoutes: Routes = [
    { path: '', redirectTo: 'page/home', pathMatch: 'full', canActivate: [AuthGuard] },
    {
        path: 'page',
        component: PagesComponent,
        children: [
            { path: '', redirectTo: 'home', pathMatch: 'full'},
            { path: 'home', component: HomeComponent},
            { path: 'docs', component: DocsComponent},
            { path: 'not-found', component: NotFoundComponent},
        ],
        canActivate: [AuthGuard]
    },
    { path: 'login', component: LoginComponent },
    { path: '**', redirectTo: 'page/not-found', pathMatch: 'full', canActivate: [AuthGuard]  }
];

export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes, { useHash: true });
