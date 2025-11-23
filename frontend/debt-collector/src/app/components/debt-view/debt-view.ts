import { Component, OnInit, OnDestroy, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { DebtService } from '../../services/debt.service';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-debt-view',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './debt-view.html',
  styleUrl: './debt-view.css',
})
export class DebtDetailsComponent implements OnInit, OnDestroy {
  debt: any;
  suggestion: any;
  loadingSuggestion = false;
  applying = false;
  private id!: number;
  private routeSubscription?: Subscription;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private api: DebtService,
    private cdr: ChangeDetectorRef
  ) {}

  ngOnInit(): void {
    // Subscribe to route parameter changes
    this.routeSubscription = this.route.paramMap.subscribe(params => {
      const id = Number(params.get('id'));
      if (Number.isNaN(id)) {
        this.goBack();
        return;
      }

      this.id = id;
      this.loadDebt();
    });
  }

  ngOnDestroy(): void {
    this.routeSubscription?.unsubscribe();
  }

  loadDebt(): void {
    // Reset state when loading new debt
    this.debt = null;
    this.suggestion = null;

    this.api.getDebt(this.id).subscribe({
      next: (res) => {
        this.debt = res;
        this.cdr.detectChanges();
      },
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
        this.cdr.detectChanges();
      },
      error: (err) => {
        this.loadingSuggestion = false;
        this.cdr.detectChanges();
      },
    });
  }

  applyAction(action: string): void {
    this.applying = true;
    this.cdr.detectChanges();
    this.api.applyAction(this.id, action).subscribe({
      next: (res) => {
        this.debt = res.debt ?? this.debt;
        this.suggestion = null; // Clear suggestion after applying
        this.applying = false;
        this.cdr.detectChanges();
        alert('Action applied successfully.');
      },
      error: (err) => {
        console.error('Failed to apply action', err);
        this.applying = false;
        this.cdr.detectChanges();
      },
    });
  }

  goBack(): void {
    void this.router.navigate(['/debts']);
  }
}
