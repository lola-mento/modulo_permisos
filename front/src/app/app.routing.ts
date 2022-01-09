import { ModuleWithProviders } from "@angular/core";
import { Routes, RouterModule } from "@angular/router";

import { PersonaComponent } from "./components/persona/persona.component";
import { LoginComponent } from "./components/login/login.component";
import { InicioComponent } from "./components/inicio/inicio.component";
import { UsuarioComponent } from "./components/usuario/usuario.component";
import { RolComponent } from "./components/rol/rol.component";
import { PermisoComponent } from "./components/permiso/permiso.component";
import { ActualizarPersonaComponent } from "./components/actualizar-persona/actualizar-persona.component";
import { IdentityGuard } from "./services/identity.guard";
import { ActualizarPermisoComponent } from "./components/actualizar-permiso/actualizar-permiso.component";
import { ErrorComponent } from "./components/error/error.component";


//TODOS DEFINIR LAS RUTAS
const appRoutes: Routes = [

  //! RUTA PRINCIPAL
  {path: 'inicio',component: InicioComponent,canActivate:[IdentityGuard]},
  //! RUTAS DEL MÓDULO DE USUARIOS
  {path: '',component: LoginComponent},
  {path: 'logout/:sure',component: LoginComponent},
  {path: 'usuario',component: UsuarioComponent},
  {path: 'rol',component: RolComponent,canActivate:[IdentityGuard]},
  //! RUTAS DEL MÓDULO DE PERSONAS
  {path: 'persona',component: PersonaComponent,canActivate:[IdentityGuard]},
  {path: 'actualizarPersona/:id',component: ActualizarPersonaComponent,canActivate:[IdentityGuard]},
  //! RUTAS DEL MODULO DE PERMISOS
  {path: 'permiso',component: PermisoComponent,canActivate:[IdentityGuard]},
  {path: 'actualizarPermiso/:id',component: ActualizarPermisoComponent,canActivate:[IdentityGuard]},
  {path: '**',component: ErrorComponent},
];

//TODOS EXPORTAR LAS RUTAS
export const appRoutingProviders: any[] = [];
export const routing: ModuleWithProviders<any> = RouterModule.forRoot(appRoutes);

