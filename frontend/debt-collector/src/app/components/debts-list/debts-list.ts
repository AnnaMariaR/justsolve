import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';
import { DebtService } from '../../services/debt.service';

@Component({
  selector: 'app-debts-list',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './debts-list.html',
  styleUrl: './debts-list.css',
})
export class DebtsListComponent implements OnInit {
  debts: any[] = [];

  constructor(private api: DebtService, private router: Router) {}

  ngOnInit(): void {
    this.api.getDebts().subscribe({
      next: (res: any) => {
        this.debts = res;
      },
      error: (err) => {
        console.error('Failed to load debts', err);
      },
    });
  }

  openDebt(id: number): void {
    this.router.navigate(['/debts', id]);
  }
}
