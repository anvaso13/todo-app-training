<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;

/**
 * En esta clase deben implementar los metodos vacios de acuerdo a lo
 * previamente estudiado acerca de RESTFul. Recuerda que DEBEN validar los datos
 * de entrada y de regresar lo que les pide el método correctamente.
 *
 * Class TodoController
 * @package App\Http\Controllers
 */
class TodoController extends Controller
{
    /**
     * Este método del controlador regresa el listado del todos de la app
     * en un response del tipo json ordenados desde el más antiguo al más nuevo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get todos
        $todos = Todo::orderBy('created_at','desc')->get();

        // Return todos as json
        return response()->json($todos);
    }

    /**
     * Este método del controlador debe crear un nuevo registro todo
     * y al final regresa el registro creado en un response del tipo
     * json.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $todo = new Todo();
        $todo->text = $request->text;
        $todo->done = $request->done;
        
        if($todo->save())
            return  response()->json($todo);
    }

    /**
     * Modifica el item todo con el $id correspondiente
     * y regresa el mismo item modificado.
     *
     * @param integer $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $todo = Todo::find($id);
        $todo->text = $request->text;
        $todo->done = $request->done == 0 ? $request->done = 1 : $request->done = 0;
        if($todo->save()) 
            return response()->json($todo);
    }

    /**
     * Elimina el registro y devuelve un response 200 en caso de exito o un 400
     * en caso de fallo pero igual en tipo json.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $todo = Todo::find($id);
        if($todo->delete())
            return response()->json(['status' => 'Success'], 200);
        else
            return response()->json(['status' => 'Error'], 400);
    }
}
