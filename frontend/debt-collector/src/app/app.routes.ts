import { Routes } from '@angular/router';
import {DebtDetailsComponent} from './components/debt-view/debt-view';
import {DebtsListComponent} from './components/debt-list/debt-list';

export const routes: Routes = [
  { path: '', redirectTo: 'debts', pathMatch: 'full' },
  { path: 'debts', component: DebtsListComponent },
  { path: 'debts/:id', component: DebtDetailsComponent },
  { path: '**', redirectTo: 'debts' },
];
