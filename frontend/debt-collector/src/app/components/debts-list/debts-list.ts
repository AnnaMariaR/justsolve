import { Component, OnInit, OnDestroy, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, NavigationEnd } from '@angular/router';
import { DebtService } from '../../services/debt.service';
import { Subscription, filter } from 'rxjs';

@Component({
  selector: 'app-debts-list',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './debts-list.html',
  styleUrl: './debts-list.css',
})
export class DebtsListComponent implements OnInit, OnDestroy {
  debts: any[] = [];
  private routerSubscription?: Subscription;

  constructor(
    private api: DebtService,
    private router: Router,
    private cdr: ChangeDetectorRef
  ) {}

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
      next: (res: any) => {
        this.debts = res;
        this.cdr.detectChanges();
      },
      error: (err) => {
        console.error('Failed to load debts', err);
      },
    });
  }

  openDebt(id: number): void {
    void this.router.navigate(['/debts', id]);
  }
}
