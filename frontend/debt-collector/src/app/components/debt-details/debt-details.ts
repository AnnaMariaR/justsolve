import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { DebtService } from '../../services/debt.service';

@Component({
  selector: 'app-debt-details',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './debt-details.html',
  styleUrl: './debt-details.css',
})
export class DebtDetailsComponent implements OnInit {
  debt: any;
  suggestion: any;
  loadingSuggestion = false;
  applying = false;
  private id!: number;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private api: DebtService
  ) {}

  ngOnInit(): void {
    this.id = Number(this.route.snapshot.paramMap.get('id'));
    if (Number.isNaN(this.id)) {
      this.goBack();
      return;
    }

    this.api.getDebt(this.id).subscribe({
      next: (res) => (this.debt = res),
      error: (err) => {
        console.error('Failed to load debt', err);
        this.goBack();
      },
    });
  }

  loadSuggestion(): void {
    this.loadingSuggestion = true;
    this.api.getSuggestion(this.id).subscribe({
      next: (res) => {
        this.suggestion = res;
        this.loadingSuggestion = false;
      },
      error: (err) => {
        console.error('Failed to load suggestion', err);
        this.loadingSuggestion = false;
      },
    });
  }

  applyAction(action: string): void {
    this.applying = true;
    this.api.applyAction(this.id, action).subscribe({
      next: (res) => {
        this.debt = res.debt ?? this.debt;
        this.applying = false;
        alert('Action applied successfully.');
      },
      error: (err) => {
        console.error('Failed to apply action', err);
        this.applying = false;
      },
    });
  }

  goBack(): void {
    this.router.navigate(['/debts']);
  }
}
