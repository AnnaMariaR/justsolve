import { Component, OnInit, OnDestroy, ChangeDetectorRef, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { DebtService } from '../../services/debt.service';
import { Subscription } from 'rxjs';
import { Debt } from '../../models/debt.interface';
import { Suggestion } from '../../models/suggestion.interface';
import { DebtActionOption } from '../../models/debt-action.interface';

@Component({
  selector: 'app-debt-view',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './debt-view.html',
  styleUrl: './debt-view.css',
})
export class DebtViewComponent implements OnInit, OnDestroy {
  private route = inject(ActivatedRoute);
  private router = inject(Router);
  private api = inject(DebtService);
  private cdr = inject(ChangeDetectorRef);

  debt: Debt | null = null;
  suggestion: Suggestion | null = null;
  availableActions: DebtActionOption[] = [];
  loadingSuggestion = false;
  applyingAction: string | null = null;
  private id!: number;
  private routeSubscription?: Subscription;

  constructor() {}

  ngOnInit(): void {
    this.loadActions();

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

  loadActions(): void {
    this.api.getActions().subscribe({
      next: (response) => {
        this.availableActions = response;
      },
      error: (error) => {
        console.error('Failed to load actions', error);
      },
    });
  }

  ngOnDestroy(): void {
    this.routeSubscription?.unsubscribe();
  }

  loadDebt(): void {
    this.debt = null;
    this.suggestion = null;

    this.api.getDebt(this.id).subscribe({
      next: (response) => {
        this.debt = response;
        this.cdr.markForCheck();
      },
      error: (error) => {
        console.error('Failed to load debt', error);
        this.goBack();
      },
    });
  }

  loadSuggestion(): void {
    this.loadingSuggestion = true;
    this.api.getSuggestion(this.id).subscribe({
      next: (response) => {
        this.suggestion = response;
        this.loadingSuggestion = false;
        this.cdr.markForCheck();
      },
      error: (error) => {
        console.error('Failed to load suggestion', error);
        this.loadingSuggestion = false;
        this.cdr.markForCheck();
      },
    });
  }

  applyAction(action: string): void {
    this.applyingAction = action;
    this.api.applyAction(this.id, action).subscribe({
      next: (response) => {
        this.debt = response.debt;
        this.suggestion = null;
        this.applyingAction = null;
        this.cdr.markForCheck();
      },
      error: (error) => {
        console.error('Failed to apply action', error);
        this.applyingAction = null;
        this.cdr.markForCheck();
      },
    });
  }

  goBack(): void {
    this.router.navigate(['/debts']);
  }
}
