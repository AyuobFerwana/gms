<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->view('lgs.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = Department::all();
        return response()->view('lgs.employee.create' , compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [

            'emp_name' => 'required|string|min:3|max:50',
            'emp_birthdate' => 'required|date',
            'emp_salary' => 'required|string|min:3|max:50',
            'dept_id' => 'required|string',
            'status' => ['required', 'in:active,expired'],
        ]);

        if (!$validator->fails()) {
            $employee = new Employee();
            $employee->emp_name = $request->input('emp_name');
            $employee->emp_birthdate = $request->input('emp_birthdate');
            $employee->emp_salary = $request->input('emp_salary');
            $employee->dept_id = $request->input('dept_id');
            $employee->status = $request->input('status');


            $isSaved = $employee->save();
            return response()->json([
                'message' => $isSaved ? 'Create Employee Successfully' : 'Create Employee Failed'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $department = Department::all();
        return response()->view('lgs.employee.edit', ['employee'=>$employee , 'department'=>$department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validator = validator($request->all(), [

            'emp_name' => 'required|string|min:3|max:50',
            'emp_birthdate' => 'required|date',
            'emp_salary' => 'required|string|min:3|max:50',
            'dept_id' => 'required|string',
            'status' => ['required', 'in:active,expired'],
        ]);

        if (!$validator->fails()) {
            $employee->emp_name = $request->input('emp_name');
            $employee->emp_birthdate = $request->input('emp_birthdate');
            $employee->emp_salary = $request->input('emp_salary');
            $employee->dept_id = $request->input('dept_id');
            $employee->status = $request->input('status');
            $isSaved = $employee->save();
            return response()->json([
                'message' => $isSaved ? 'Update Employee Successfully' : 'Update Employee Failed'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $isDelete = $employee->delete();
        return response()->json(
            ['message' => $isDelete ? ' Delete Successfully ! ' : ' Delete Faild ! '],
            $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
