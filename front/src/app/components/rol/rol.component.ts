import { Component, OnInit } from '@angular/core';
import { RolServices } from 'src/app/services/rol.services';
import { UserServices } from 'src/app/services/user.services';
import { global } from 'src/app/services/global';
import { Rol } from 'src/app/models/rol';
import { Persona } from 'src/app/models/persona';

@Component({
  selector: 'rol',
  templateUrl: './rol.component.html',
  styleUrls: ['./rol.component.css'],
  providers:[RolServices,UserServices]
})
export class RolComponent implements OnInit
{
  public page_title: string;
  public url: string;
  public roli:Rol;
  public resultado:any;
  public status: string;
  public mensaje: string;
  public token;

  constructor
  (
    private _rolServices: RolServices,
    private _userService: UserServices
  )
  {
    this.page_title = 'Creación de roles';
    this.roli = new Rol(1,'');
    this.url = global.url;
    this.status = '';
    this.mensaje = '';
    this.token = this._userService.getToken();
  }

  ngOnInit(): void
  {
    this.index();
  }
  store(form:any)
  {
    this._rolServices.store(this.token,this.roli).subscribe
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
    this._rolServices.index(this.token).subscribe
    (
      response=>
      {
        if(response.status = 'success')
        {
          this.resultado = response.rol;
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
  destroy(id:any)
  {
    this._rolServices.destroy(this.token,id).subscribe
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
}
