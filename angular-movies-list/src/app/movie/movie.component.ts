import { Component, OnInit, Input } from '@angular/core';
import { Movie } from '../movie'
import { HttpClient } from '@angular/common/http';
import { MOVIES } from '../mock-movies';

@Component({
  selector: 'app-movie',
  templateUrl: './movie.component.html',
  styleUrls: ['./movie.component.css']
})
export class MovieComponent implements OnInit {

  movie : Movie = {
     id: 0,
     listId: 0,
     name: 'Toy Story'
  };

  @Input() listId: any;
  addingList = false;
  updatingList = false;
  movies = this.http.get('http://localhost:8888/SCMoviesProject/backend/movie/readAll.php?id='+this.listId);
  selectedMovie : Movie;

  testVal:any;

  movieAPIResults:any;
  inputSuggestionList:any;


  constructor(private http: HttpClient) { }

  ngOnInit() {
  }

  onSelect(movie: Movie): void {
     this.selectedMovie = movie;
  }

  toggleAddToList(): void {
     this.addingList = !this.addingList;
  }

  toggleUpdateList(): void {
     this.updatingList = !this.updatingList;
  }

  addMovie(text: string) {


     if (text != "") {
        const data: Movie = {
           id: null,
           listId: this.listId,
           name: text
        }

        this.testVal = this.http.post('http://localhost:8888/SCMoviesProject/backend/movie/create.php', { data });

        console.log(this.testVal);
        this.toggleAddToList();
        window.location.reload();
     }
  }

  deleteMovie(data: Movie) {
     this.testVal = this.http.post('http://localhost:8888/SCMoviesProject/backend/movieList/delete.php', { data });

     console.log(this.testVal);
     this.selectedMovie = null;
     window.location.reload();
  }

  updateList(text: string) {


     if (text != this.selectedMovie.name) {

        const data: Movie = {
           id: this.selectedMovie.id,
           listId: this.listId,
           name: text
        }

        this.testVal = this.http.post('http://localhost:8888/SCMoviesProject/backend/movieList/update.php', { data });

        console.log(this.testVal);
        this.toggleUpdateList();
        window.location.reload();
     }
  }

  getMovies() {
     this.movies = this.http.get('http://localhost:8888/SCMoviesProject/backend/movie/readAll.php?id='+this.listId);
     window.location.reload();
  }

  getTitleSuggestions(text: string) {
    this.movieAPIResults = JSON.parse(this.http.get('http://www.omdbapi.com/?s='+text+'&r=json&apikey=6602feb'));
    this.inputSuggestionList = [];


    for (i = 0; i < this.movieAPIResults.Search.length; i++) {
       this.inputSuggestionList[i] = this.movieAPIResults.Search[i].Title;
    }


    return this.inputSuggestionList;
  }

  getMovieTrailerLink() {
    this.movieAPIResults = JSON.parse(this.http.get('http://www.omdbapi.com/?s='+text+'&r=json&apikey=6602feb')).Search[1].imdbID;
    return "https://www.imdb.com/title/" +this.movieAPIResults+"/";
  }
}
