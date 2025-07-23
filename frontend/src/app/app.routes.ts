import { Routes } from '@angular/router';
import { UserListComponent } from './user-component/user-list.component';
import { JobOfferListComponent } from './job-offer/job-offer-list.component';
import { ApplicationJobListComponent } from './application-job/application-job-list.component';
import { Home } from './home/home.component';
import { LoginComponent } from './login/login.component';
import { RecruiterComponent } from './recruiter/recruiter.component';



export const routes: Routes = [
  { path: '', component: Home},
  { path: 'users', component: UserListComponent },
  { path: 'job-offers', component: JobOfferListComponent },
  { path: 'applications', component: ApplicationJobListComponent },
  { path: 'login', component: LoginComponent },
  { path: 'recruiter', component: RecruiterComponent },
];
