<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contacto;
use App\Models\Direccion;
use App\Models\Email;
use Illuminate\Support\Facades\Validator;
use App\Models\Telefono;

class contactoController extends Controller
{ 
    public function index(){
        $contactos = Contacto::all();               

        if($contactos->isEmpty()){
            $data = [
                'message'=>'No hay contactos registrados',
                'status'=> 200
            ];
            return response()->json($data,404);
        }

        $data = [
            'contacto'=>$contactos,
            'status'=> 200
        ];
        return response()->json($data,200);
    }

    public function get_contacto($id_contacto){
        $contacto = Contacto::find($id_contacto);
        $telefonos = Telefono::where('id_contacto', '=', $id_contacto)->get();
        $emails = Email::where('id_contacto', '=', $id_contacto)->get();
        $direcciones = Direccion::where('id_contacto', '=', $id_contacto)->get();
        
        if(!$contacto){

            $data = [
                'message'=>'Contacto no encontrado',
                'status'=> 404
            ];
            return response()->json($data,404);
        }

        $data = [
            'contacto'=>$contacto,
            'status'=> 200,
            'telefonos'=>$telefonos,
            'emails'=>$emails,
            'direcciones'=>$direcciones
        ];
        return response()->json($data,200);
    }

    public function addContacto(Request $request){
        $validator = Validator::make($request->all(),[
            'nombre'=>'required',
            'empresa'=>'required'
        ]);

        if($validator->fails()){
            $data = [
                'message'=>'Error en la validacion de datos',
                'errors'=>$validator->errors(),
                'status'=> 400
            ];
            return response()->json($data,400);
        }

        $contacto = Contacto::create([
            'nombre' => $request->nombre,
            'nota' => $request->nota,
            'fecha_cumpleanios' => $request->fecha_cumpleanios,
            'pagina_web' => $request->pagina_web,
            'empresa' => $request->empresa   
        ]);

        if(!$contacto){
            $data = [
                'message'=>'Error al crear contacto',
                'status'=> 500
            ];
            return response()->json($data,500);
        }

        $telefonos = $request->telefono;

        if($telefonos){

            for($i=0;$i<count($telefonos);$i++){

                Telefono::create([
                    'id_contacto' => $contacto->id,
                    'telefono' => $telefonos[$i]['numero'], 
                ]);
                
            } 
        }
        

        $emails = $request->emails;

        if($emails){

            for($i=0;$i<count($emails);$i++){

                Email::create([
                    'id_contacto' => $contacto->id,
                    'email' => $emails[$i]['email'], 
                ]);
                
            } 
        }

        $direcciones = $request->direcciones;

        if($direcciones){

            for($i=0;$i<count($direcciones);$i++){

                Direccion::create([
                    'id_contacto' => $contacto->id,
                    'direccion' => $direcciones[$i]['direccion'], 
                ]);
                
            } 
        }


        $data = [
            'message'=>'Contacto guardado',
            'contacto'=>$contacto,
            'status'=> 201
        ];
        return response()->json($data,201);
    }

    public function edit_contacto(Request $request, $id_contacto){
        $contacto = Contacto::find($id_contacto);

        if(!$contacto){

            $data = [
                'message'=>'Contacto no encontrado',
                'status'=> 404
            ];
            return response()->json($data,404);
        }

        $validator = Validator::make($request->all(),[
            'nombre'=>'required',
            'empresa'=>'required'
        ]);

        if($validator->fails()){
            $data = [
                'message'=>'Error en la validacion de datos',
                'errors'=>$validator->errors(),
                'status'=> 400
            ];
            return response()->json($data,400);
        }

        $contacto->nombre = $request->nombre;
        $contacto->nota = $request->nota;
        $contacto->fecha_cumpleanios = $request->fecha_cumpleanios;
        $contacto->pagina_web = $request->pagina_web;
        $contacto->empresa = $request->empresa;

        $contacto->save();

  
        
        $telefonos = $request->telefono;

        if($telefonos){
            //Telefono::where('id_contacto', $id_contacto)->delete();
            for($i=0;$i<count($telefonos);$i++){

                Telefono::create([
                    'id_contacto' => $contacto->id,
                    'telefono' => $telefonos[$i]['numero'], 
                ]);
                
            } 
        }
        

        

        $emails = $request->emails;

        if($emails ){
            //Email::where('id_contacto', $id_contacto)->delete();
            for($i=0;$i<count($emails);$i++){

                Email::create([
                    'id_contacto' => $contacto->id,
                    'email' => $emails[$i]['email'], 
                ]);
                
            } 
        }

        

        

        $direcciones = $request->direcciones;

        if($direcciones){
            //Direccion::where('id_contacto', $id_contacto)->delete();
            for($i=0;$i<count($direcciones);$i++){

                Direccion::create([
                    'id_contacto' => $contacto->id,
                    'direccion' => $direcciones[$i]['direccion'], 
                ]);
                
            } 
        }

        $data = [
            'message'=>'Contacto editado',
            'contacto'=>$contacto,
            'status'=> 200
        ];
        return response()->json($data,200);
    }

    public function delete_contacto($id_contacto){
        $contacto = Contacto::find($id_contacto);

        if(!$contacto){

            $data = [
                'message'=>'Contacto no encontrado',
                'status'=> 404
            ];
            return response()->json($data,404);
        }

        $contacto->delete();
        Telefono::where('id_contacto', $id_contacto)->delete();
        Email::where('id_contacto', $id_contacto)->delete();
        Direccion::where('id_contacto', $id_contacto)->delete();

        $data = [
            'message'=>'Contacto eliminado',
            'status'=> 200
        ];
        return response()->json($data,200);
    }

}
