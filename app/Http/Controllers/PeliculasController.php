<?php

namespace App\Http\Controllers;

use App\Models\Peliculas;
use Illuminate\Http\Request;






class PeliculasController extends Controller
{

    //admin and customer can see all movies

    public function index()
    {
        try {
            $peliculas = Peliculas::all();
            return response()->json($peliculas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    //Admin and customer can see the details of the movie

    public function show($id)
    {
        try {
            $pelicula = Peliculas::find($id);
            return response()->json($pelicula);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //only admin can update

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'titulo' => 'required|string',
                'genero' => 'required|string',
                'director' => 'required|string',
                'año' => 'required|string',
                'sinopsis' => 'required|string',
            ]);
            $pelicula = Peliculas::find($id);
            $pelicula->update($request->all());
            return response()->json([
                'message' => 'Successfully updated user!',
                'pelicula' => $pelicula,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //only admin can delete

    public function destroy($id)
    {
        try {
            $pelicula = Peliculas::find($id);
            $pelicula->delete();
            return response()->json($pelicula);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(['Ok' => 'Pelicula eliminada'], 200);
    }

    //Admin and customer can see the details of the movie

    public function info($sinopsis)
    {
        try {
            $pelicula = Peliculas::where('sinopsis', $sinopsis)->first();
            return response()->json($pelicula);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Admin and customer can see the details of the movie

    public function search($titulo)
    {
        try {
            $pelicula = Peliculas::where('titulo', 'like', '%'.$titulo.'%')->get();
            return response()->json([$pelicula, "View Search"]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Admin and customer can see the details of the movie

    public function filter($genero)
    {
        try {
            $pelicula = Peliculas::where('genero', $genero)->get();
            return response()->json([$pelicula , "View Filter"]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    //only admin can create a new movie

    function create(Request $peliculas){
        try {
            $peliculas->validate([
                'titulo'=>'required|string',
                'genero'=>'required|string',
                'director'=>'required|string',
                'año'=>'required|string',
                'sinopsis'=>'required|string'
            ]);

            $peliculas=Peliculas::create([
                'titulo'=> $peliculas->titulo,
                'genero'=> $peliculas->genero,
                'director'=> $peliculas->director,
                'año'=> $peliculas->año,
                'sinopsis'=> $peliculas->sinopsis
            ]);
            return response()->json([
                'message'=>'Successfully created user!',
                'peliculas'=>$peliculas
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'message'=>'Error created user!',
                'error'=>$th->getMessage()
            ]);
    }
}

}
