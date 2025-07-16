import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';
import { AuthService, User } from '../../auth.service';

@Component({
  selector: 'app-layout',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './layout.html',
  styleUrls: ['./layout.css']
})
export class LayoutComponent {
  @Input() user: User | null = null;
  @Input() loading = false;
  @Input() error = '';

  showUserDropdown = false;
  mobileMenuOpen = false;

  // Modal state and mock fuzzy logic result
  showAlertModal = false;
  fuzzyResult = {
    suhu: 'Dingin',
    kelembaban: 'Kering',
    cahaya: 'Sedang',
    pompa: 'Pompa akan mati...'
  };

  constructor(
    private authService: AuthService,
    private router: Router
  ) {}

  toggleUserMenu(): void {
    this.showUserDropdown = !this.showUserDropdown;
  }

  closeUserMenu(): void {
    this.showUserDropdown = false;
  }

  toggleMobileMenu(): void {
    this.mobileMenuOpen = !this.mobileMenuOpen;
  }

  navigateToManageAccount(): void {
    this.router.navigate(['/manage-account']);
    this.closeUserMenu();
  }

  logout(): void {
    this.authService.logout().subscribe({
      next: () => {
        this.closeUserMenu();
      },
      error: () => {
        this.closeUserMenu();
      }
    });
  }

  loginWithGoogle(): void {
    this.authService.loginWithGoogle();
  }

  showAlerts(): void {
    // TODO: Replace with real data fetching if available
    this.showAlertModal = true;
  }

  closeAlertModal(): void {
    this.showAlertModal = false;
  }

  exportToExcel(): void {
    this.router.navigate(['/export']);
  }

  navigateToDashboard(): void {
    this.router.navigate(['/dashboard']);
  }

  navigateToLanding(): void {
    this.router.navigate(['/']);
  }

  navigateToContact(): void {
    this.router.navigate(['/contact']);
    this.closeUserMenu();
  }

  goToContact(): void {
    this.router.navigate(['/contact']);
  }
} 