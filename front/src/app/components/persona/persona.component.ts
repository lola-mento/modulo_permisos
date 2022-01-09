import { Component, OnInit } from '@angular/core';
import { PersonaServices } from 'src/app/services/persona.services';
import { UserServices } from 'src/app/services/user.services';
import { Persona } from 'src/app/models/persona';
import { global } from 'src/app/services/global';
import { NgbDateStruct } from '@ng-bootstrap/ng-bootstrap';


@Component({
  selector: 'persona',
  templateUrl: './persona.component.html',
  styleUrls: ['./persona.component.css'],
  providers:[PersonaServices,UserServices]
})
export class PersonaComponent implements OnInit {


  public page_title: string;
  public url = global.url;
  public persona:Persona;
  public resultado:any;
  public bq:any;
  public status: string;
  public mensaje: string;
  public token;
  public p:any;

  constructor
  (
    private _personaService: PersonaServices,
    private _userService: UserServices
  )
  {
    this.page_title = 'Gestión de personas';
    this.persona = new Persona(1,'','','','','','','','','','','');
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
    this._personaService.store(this.token,this.persona).subscribe
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
        console.log(response);
      },
      error=>
      {
        this.status = 'error';
        console.log(<any>error);
        this.mensaje = error.error.message;
      }
    );
  }

  index()
  {
    this._personaService.index(this.token).subscribe
    (
      response=>
      {
        if(response.status = 'success')
        {
          this.resultado = response.persona;
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
    this._personaService.buscar(this.token,this.bq).subscribe
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
    this._personaService.destroy(this.token,id).subscribe
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
