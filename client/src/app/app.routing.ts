import { Routes, RouterModule } from '@angular/router';
import { ModuleWithProviders } from '@angular/core';

import { LoginComponent } from './auth/index';
import { AuthGuard } from './_guards/index';
import {
    PagesComponent,
    NotFoundPageComponent,
    HomePageComponent,
    DocsPageComponent,
    ProfilePageComponent,
    CalendarPageComponent,
    MembersPageComponent
} from './pages/index';


export const appRoutes: Routes = [
    { path: '', redirectTo: 'page/home', pathMatch: 'full', canActivate: [AuthGuard] },
    {
        path: 'page',
        component: PagesComponent,
        children: [
            { path: '', redirectTo: 'home', pathMatch: 'full' },
            { path: 'home', component: HomePageComponent },
            { path: 'docs', component: DocsPageComponent },
            { path: 'profile', component: ProfilePageComponent },
            { path: 'calendar', component: CalendarPageComponent },
            { path: 'members', component: MembersPageComponent },
            { path: 'not-found', component: NotFoundPageComponent },
        ],
        canActivate: [AuthGuard]
    },
    { path: 'login', component: LoginComponent },
    { path: '**', redirectTo: 'page/not-found', pathMatch: 'full', canActivate: [AuthGuard]  }
];

export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes, { useHash: true });

