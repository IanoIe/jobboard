import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
import { Navbar } from './navbar/navbar';


@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterModule, Navbar],
  template: `<router-outlet></router-outlet>`
})
export class AppComponent {}
