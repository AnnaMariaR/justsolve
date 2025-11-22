import { Routes } from '@angular/router';
import {DebtDetailsComponent} from './components/debt-details/debt-details';
import {DebtsListComponent} from './components/debts-list/debts-list';

export const routes: Routes = [
  { path: '', redirectTo: 'debts', pathMatch: 'full' },
  { path: 'debts', component: DebtsListComponent },
  { path: 'debts/:id', component: DebtDetailsComponent },
  { path: '**', redirectTo: 'debts' },
];
