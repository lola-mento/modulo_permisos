import { Component, OnInit } from '@angular/core';
import { UserServices } from 'src/app/services/user.services';
import { PersonaServices } from 'src/app/services/persona.services';
import { RolServices } from 'src/app/services/rol.services';
import { User } from 'src/app/models/user';
import { global } from 'src/app/services/global';


@Component({
  selector: 'usuario',
  templateUrl: './usuario.component.html',
  styleUrls: ['./usuario.component.css'],
  providers:[UserServices,PersonaServices,RolServices]
})
export class UsuarioComponent implements OnInit
{
  public page_title: string;
  public url:string;
  public usuario:User;
  public resultado:any;
  public resultadoPersona:any;
  public resultadoRol:any;
  public bq:any;
  public status: string;
  public mensaje: string;
  public token;
  public p:any;

  constructor
  (
    private _userService: UserServices,
    private _personaService: PersonaServices,
    private _rolService: RolServices
  )
  {
    this.page_title = 'Gestión de usuarios';
    this.usuario = new User(1,1,1,'','');
    this.url = global.url;
    this.status = '';
    this.mensaje = '';
    this.token = this._userService.getToken();
  }

  ngOnInit(): void
  {
    this.index();
    this.getPersona();
    this.getRol();
  }
  store(form:any)
  {
    this._userService.store(this.token,this.usuario).subscribe
    (
      response =>
      {
        if(response.status = "success")
        {
          this.status = response.status;
          this.mensaje = response.message;
          form.reset();
          this.index();
        }
        else
        {
          this.status = 'error';
          this.mensaje = response.message;
        }
      },
      error=>
      {
        this.status = 'error';
        this.mensaje = error.error.message;
      }
    );
  }
  index()
  {
    this._userService.index(this.token).subscribe
    (
      response=>
      {
        if(response.status = 'success')
        {
          this.resultado = response.usuario;
        }
      },
      error=>
      {
        console.log(error);
      }
    )
  }
  reload()
  {
    window.location.reload();
  }
  buscar()
  {
    if(this.bq != '')
    {
    this._userService.buscar(this.token,this.bq).subscribe
    (
      response=>
      {
        if(response.status = 'success')
        {
          this.resultado = response.busqueda;
        }
      },
      error=>
      {
        console.log(error);
      }
    )
  }
    else
    {
      this.index();
    }

  }
  destroy(id:any)
  {
    this._userService.destroy(this.token,id).subscribe
    (
      response=>
      {
        this.status = response.status;
        this.mensaje = response.message;
        setTimeout('document.location.reload()',500);
      },
      error=>
      {
        this.mensaje = error.message;
      }
    )
  }
  getPersona()
  {
    this._personaService.index(this.token).subscribe
    (
      response=>
      {
        this.resultadoPersona = response.persona;
        console.log(response.persona);
      },
      error=>
      {
        console.log(error);
      }
    )
  }
  getRol()
  {
    this._rolService.index(this.token).subscribe
    (
      response=>
      {
        this.resultadoRol = response.rol;
        console.log(response.rol);
      },
      error=>
      {
        console.log(error);
      }
    )
  }



}
