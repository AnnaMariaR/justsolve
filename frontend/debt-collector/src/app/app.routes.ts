import { Routes } from '@angular/router';
import {DebtViewComponent} from './components/debt-view/debt-view';
import {DebtListComponent} from './components/debt-list/debt-list';

export const routes: Routes = [
  { path: '', redirectTo: 'debts', pathMatch: 'full' },
  { path: 'debts', component: DebtListComponent },
  { path: 'debts/:id', component: DebtViewComponent },
  { path: '**', redirectTo: 'debts' }, //home page
];
