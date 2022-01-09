import { Component,OnInit, DoCheck  } from '@angular/core';
import { UserServices } from './services/user.services';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
  providers: [UserServices]
})
export class AppComponent implements OnInit, DoCheck {
  public title = 'SITCO';
  public identity:any;
  public token:any;
  constructor
  (
    public _userService: UserServices
  )
  {
    this.identity = this._userService.getIdentity();
    this.token = this._userService.getToken();
  }
  ngDoCheck()
  {
    this.loadUser();
  }
  ngOnInit()
  {
    console.log('Web App cargada correctamente');
  }
  loadUser()
  {
    this.identity = this._userService.getIdentity();
    this.token = this._userService.getIdentity();
  }


}
