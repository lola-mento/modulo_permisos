import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'inicio',
  templateUrl: './inicio.component.html',
  styleUrls: ['./inicio.component.css']
})
export class InicioComponent implements OnInit {
  public page_title: string;
  constructor()
  {
    this.page_title = 'Pagina de inicio'
  }

  ngOnInit(): void {
  }

}
