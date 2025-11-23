export interface Debt {
  id: number;
  debtor_name: string;
  amount: number;
  days_overdue: number;
  status: string;
  last_action?: string;
  last_action_at?: string;
}