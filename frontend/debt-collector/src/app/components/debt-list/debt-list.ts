import { Component, OnInit, OnDestroy, ChangeDetectorRef, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, NavigationEnd } from '@angular/router';
import { DebtService } from '../../services/debt.service';
import { Subscription, filter } from 'rxjs';
import { Debt } from '../../models/debt.interface';

@Component({
  selector: 'app-debt-list',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './debt-list.html',
  styleUrl: './debt-list.css',
})
export class DebtListComponent implements OnInit, OnDestroy {
  private api = inject(DebtService);
  private router = inject(Router);
  private cdr = inject(ChangeDetectorRef);

  debts: Debt[] = [];
  private routerSubscription?: Subscription;

  constructor() {}

  ngOnInit(): void {
    this.loadDebts();

    // Reload debts whenever we navigate to this component
    this.routerSubscription = this.router.events
      .pipe(filter((event) => event instanceof NavigationEnd))
      .subscribe((event) => {
        const navEvent = event as NavigationEnd;
        if (navEvent.urlAfterRedirects === '/debts') {
          this.loadDebts();
        }
      });
  }

  ngOnDestroy(): void {
    this.routerSubscription?.unsubscribe();
  }

  loadDebts(): void {
    this.api.getDebts().subscribe({
      next: (response) => {
        this.debts = response;
        this.cdr.markForCheck();
      },
      error: (error) => {
        console.error('Failed to load debts', error);
      },
    });
  }

  openDebt(id: number): void {
    this.router.navigate(['/debts', id]);
  }
}
