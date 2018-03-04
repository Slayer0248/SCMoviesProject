import { Component, OnInit } from '@angular/core';
import { MovieList } from '../movie-list'
import { MovieComponent } from '../movie/movie.component';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { HttpHeaders } from '@angular/common/http';
import { LISTS } from '../mock-movie-list';

@Component({
  selector: 'app-movie-list',
  templateUrl: './movie-list.component.html',
  styleUrls: ['./movie-list.component.css']
})
export class MovieListComponent implements OnInit {

  addingList = false;
  updatingList = false;
  //movieLists = this.http.get('http://localhost:8888/SCMoviesProject/backend/movieList/readAll.php');
  movieLists : Observable<any>;
  selectedList : MovieList;
  testVal:any;
  listname:any;

  mov : any;

  constructor(private http: HttpClient) {
    //this.getLists();
  }

  ngOnInit() {
     //this.h
  }

  onSelect(movieList: MovieList): void {
     this.selectedList = movieList;
  }

  toggleAddToList(): void {
     this.addingList = !this.addingList;
  }

  toggleUpdateList(): void {
     this.updatingList = !this.updatingList;
  }

  addList() {
     console.log(this.listname);

     if (this.listname.length > 0) {

        const data: MovieList = {
           id: 0,
           name: this.listname
        }

        this.testVal = this.http.post('http://localhost:8888/SCMoviesProject/backend/movieList/create.php?name=${this.listname}', data);

        console.log(this.testVal);
        this.toggleAddToList();
        //window.location.reload();
     }
  }

  deleteList(data: MovieList) {
     this.testVal = this.http.post('http://localhost:8888/SCMoviesProject/backend/movieList/delete.php', { data });

     console.log(this.testVal);
     this.selectedList = null;
     //window.location.reload();
  }

  updateList(text: string) {


     if (text != this.selectedList.name) {

        const data: MovieList = {
           id: this.selectedList.id,
           name: text
        }

        this.testVal = this.http.post('http://localhost:8888/SCMoviesProject/backend/movieList/update.php', data );

        console.log(this.testVal);
        this.toggleUpdateList();
        //window.location.reload();
     }
  }

  getLists() {
     this.movieLists = this.http.get('http://localhost:8888/SCMoviesProject/backend/movieList/readAll.php');
     //window.location.reload();
  }






}
