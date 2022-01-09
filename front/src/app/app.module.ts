import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';


import { routing } from './app.routing';
import { appRoutingProviders } from './app.routing';
import { FormsModule } from '@angular/forms';
import { HttpClientModule} from '@angular/common/http';
import { InicioComponent } from './components/inicio/inicio.component';
import { PersonaComponent } from './components/persona/persona.component';
import { NgxPaginationModule} from 'ngx-pagination';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { LoginComponent } from './components/login/login.component';
import { ActualizarPersonaComponent } from './components/actualizar-persona/actualizar-persona.component';
import { IdentityGuard } from "./services/identity.guard";
import { UserServices } from './services/user.services';
import { UsuarioComponent } from './components/usuario/usuario.component';
import { RolComponent } from './components/rol/rol.component';
import { PermisoComponent } from './components/permiso/permiso.component';
import { ActualizarPermisoComponent } from './components/actualizar-permiso/actualizar-permiso.component';
import { ErrorComponent } from './components/error/error.component';



@NgModule({
  declarations: [
    AppComponent,
    InicioComponent,
    PersonaComponent,
    LoginComponent,
    ActualizarPersonaComponent,
    UsuarioComponent,
    RolComponent,
    PermisoComponent,
    ActualizarPermisoComponent,
    ErrorComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    routing,
    FormsModule,
    HttpClientModule,
    NgxPaginationModule,
    BrowserAnimationsModule,
    NgbModule


  ],
  providers: [appRoutingProviders,IdentityGuard, UserServices],
  bootstrap: [AppComponent]
})
export class AppModule { }
