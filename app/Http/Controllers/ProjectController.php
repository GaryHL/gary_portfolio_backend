<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return response()->json(['success' => true, 'data' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = new Project();

        $project->title  = $request->title;

        $project->description  = $request->description;

        $project->deploy  = $request->deploy;
        $project->type  = $request->type;

        $project->repository  = $request->repository;


        // check the file field

        if ($request->hasFile('img_url')) {

            $file = $request->file('img_url');

            $destinationPath = 'images/featureds/';

            $fileName = time() . '-' . $file->getClientOriginalName();

            $uploadSucces = $request->file('img_url')->move($destinationPath, $fileName);

            $project->img_url  = $destinationPath . $fileName;
        } else {

            $project->img_url  = 'no picture';
        }

        $project->save();

        return response()->json(['success' => true, 'data' => $project]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response()->json(['success' => true, 'data' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'deploy' => 'required',
            'repository' => 'required'
        ]);

        $project->title = $request->title;
        $project->description = $request->description;
        $project->deploy = $request->deploy;
        $project->type = $request->type;
        $project->repository = $request->repository;

        // Check if the request includes an image file
        if ($request->hasFile('img_url')) {
            $file = $request->file('img_url');
            $destinationPath = 'images/featureds/';
            $fileName = time() . '-' . $file->getClientOriginalName();
            $uploadSuccess = $request->file('img_url')->move($destinationPath, $fileName);
            $project->img_url = $destinationPath . $fileName;
        }

        $project->save();

        return response()->json(['success' => true, 'data' => $project]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if(is_null($project)){
            
            return response()->json('No se pudo realizar la peticion, el archivo ya no existe o nunca existio', 404);
        }

        $project->delete();


        return response()->json(['success' => true, 'eliminado con exito']);
    }
}
