import { Injectable } from "@angular/core";
import { Router, CanActivate } from "@angular/router";
import { UserServices } from "./user.services";

@Injectable()
export class IdentityGuard implements CanActivate
{
  constructor
  (
    private _router:Router,
    private _userService:UserServices
  )
  {

  }
  canActivate()
  {
    let identity = this._userService.getIdentity();
    if(identity.sub)
    {
      return true;
    }
    else
    {
      this._router.navigate(['']);
      return false;
    }
  }

}
