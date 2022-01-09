import { Component, OnInit } from '@angular/core';
import { User } from 'src/app/models/user';
import { UserServices } from 'src/app/services/user.services';
import { routing } from 'src/app/app.routing';
import { ActivatedRoute, Router } from '@angular/router';
import { Params } from '@angular/router';
import { THIS_EXPR } from '@angular/compiler/src/output/output_ast';

@Component({
  selector: 'login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
  providers: [UserServices]
})
export class LoginComponent implements OnInit
{
  public page_title: string;
  public user: User;
  public status: string;
  public token: string;
  public identity: string;
  public mensaje: string;

  constructor
  (
    private _userService: UserServices,
    private _router: Router,
    private _route: ActivatedRoute
  )
  {
    this.status = '';
    this.token = '';
    this.identity = '';
    this.page_title = 'Identificate';
    this.user = new User(1,1,1,'','');
    this.mensaje = '';
  }

  ngOnInit(): void
  {
    this.logOut();
  }
  logOut()
  {
    this._route.params.subscribe(params =>

      {
        let logout = +params['sure'];
        if(logout == 1)
        {
          localStorage.removeItem('identity');
          localStorage.removeItem('token');

          this.identity = '';
          this.token = '';

          //TODOS REDIRECCION  A LA PAGINA PRINCIPAL
          this._router.navigate(['']);

        }
      }

      )
  }
  onSubmit(form:any)
  {
    this._userService.signup(this.user).subscribe
    (
      response =>
      {
        //todos TOKEN
        if(response.status!='error')
        {
          this.status = 'success';
          this.token = response;

          //! OBJETO USUARIO IDENTIFICADO
          this._userService.signup(this.user,true).subscribe
            (
              response =>
              {
                this.identity = response;
                //! USAR EL USUARIO IDENTIFICADO
                localStorage.setItem('token',this.token);
                localStorage.setItem('identity',JSON.stringify(this.identity));
                //! REDIRECCION  A LA PAGINA PRINCIPAL
              this._router.navigate(['persona']);
              },
              error =>
              {
                this.status = 'error';
                this.mensaje = error.message;
              }
            );
        }
        else
        {
          this.status = 'error';
          this.mensaje = response.message;
        }
      },
      error =>
      {
        this.status = 'error';
        console.log(<any>error);
      }
    );
  }

}
