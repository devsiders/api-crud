<?php

namespace App\Http\Controllers;

use App\Models\Student;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Student::all();
        if ($student->isEmpty()) {
            $data = [
                'message' => 'No hay datos de los estudiantes',
                'status' => 200
            ];
            return response()->json($data, 200);
            
        }
        return response()->json($student, 200);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:students',
            'phone' => 'required|digits:10'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student = Student::create($request->all());
        if (!$student) {
            $data = [
                'message' => 'Error al registrar estudiante',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'student' => $student,
            'status' => 201
        ];
        return response()->json($data, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        return response()->json($student, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits:10'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student->name = $request->name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->phone = $request->phone;

        $student->save();

        
        $data = [
            'student' => $student,
            'status' => 200
        ];
        return response()->json($data, 200);

    }

    public function updatePatch(Request $request, string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'last_name' => 'max:255',
            'email' => 'email|unique:students',
            'phone' => 'digits:10'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('name')) {
            $student->name = $request->name;
        }

        if ($request->has('last_name')) {
            $student->last_name = $request->last_name;
        }

        if ($request->has('email')) {
            $student->email = $request->email;
        }

        if ($request->has('phone')) {
            $student->phone = $request->phone;
        }

        $student->save();

        
        $data = [
            'student' => $student,
            'message' => 'Estudiante actualizado exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $student->delete();
        $data = [
            'message' => 'Estudiante eliminado exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);


    }
}
