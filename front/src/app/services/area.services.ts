import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from "@angular/common/http";
import { Observable } from "rxjs";
import { global } from "./global";

@Injectable()
export class AreaServices
{
  public url:string;
  constructor
  (
    public _http: HttpClient
  )
  {
    this.url = global.url;
  }
  index(token:any):Observable<any>
  {
      let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                    .set('Authorization',token);
      return this._http.get(this.url+'area',{headers:headers});
  }
  buscar(token:any,bq:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.get(this.url+'area/buscar/'+bq,{headers:headers});
  }
  destroy(token:any,id:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.delete(this.url+'area/'+id,{headers:headers});
  }
  store(token:any,area:any): Observable<any>
  {
    let json = JSON.stringify(area);
    let params = 'json='+json;
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.post(this.url+'area', params, {headers:headers});
  }
  update(token:any,area:any,id:any): Observable<any>
  {
    let json = JSON.stringify(area);
    let params = 'json='+json;
    let headers = new HttpHeaders()
                                  .set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.put(this.url+'area/'+id, params, {headers:headers});
  }
  show(token:any,id:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                    .set('Authorization',token);
    return this._http.get(this.url+'area/'+id,{headers:headers});
  }


}

