import { Debt } from './debt.interface';

export interface ApplyActionResponse {
  message: string;
  debt: Debt;
}