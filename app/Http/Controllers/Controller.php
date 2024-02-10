<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    public function index(){
        $jsonData = Storage::get('public/employee.json');
        $data = json_decode($jsonData, true);

        return view('welcome', compact('data'));
    }

    public function create(Request $request){
        $existingData = [];
        if (Storage::exists('public/employee.json')) {
            $existingData = json_decode(Storage::get('public/employee.json'), true);
        }

        $newData = [
            "id" => $request->id,
            "name" => $request->name,
            "manager_id" => $request->manager_id,
        ];

        $existingData[] = $newData;

        Storage::put('public/employee.json', json_encode($existingData));

        return back();
    }

    public function search(Request $request){
        $jsonData = Storage::get('public/employee.json');
        $employees = json_decode($jsonData, true);
        $employeeId = $request->id;
        $employeeName = null;

        $employee = $this->findEmployeeById($employees, $employeeId);
        $employeeName = (string)$employee[0]['name'];

        if (!$employee) {
            return "Employee with ID $employeeId is not found.";
        } else if(count($employee) == 1){
            $managers = $this->getManagers($employees, $employeeId);
        } else {
            $managers = $this->getMoreManagers($employees, $employeeId);
            return view('view-2', compact('employeeName', 'managers'));
        }

        return view('view', compact('employeeName', 'managers'));
    }

    // finding employee method
    private function findEmployeeById($employees, $employeeId)
    {
        $countemployee = [];
        foreach ($employees as $employee) {
            if ($employee['id'] == $employeeId) {
                $countemployee[] = $employee;
            }
        }
        return $countemployee;
    }

    // getting manager method
    private function getManagers($employees, $employeeId)
    {
        $managers = null;


        foreach ($employees as $employee) {
            if ($employee['id'] == $employeeId) {
                $managerId = $employee['manager_id'];
                foreach ($employees as $manager) {
                    if ($manager['id'] == $managerId) {
                        $managers = $manager;
                        break;
                    }
                }
                break;
            }
        }

        if ($managers && $managers['manager_id'] !== null) {
            $nextManager = $this->getManagers($employees, $managers['id']);
            if ($nextManager) {
                return array_merge([$managers], $nextManager);
            }
        }

        return $managers ? [$managers] : "Unable to process employeee hierarchy";
    }

    // method used when someones data are multiple
    private function getMoreManagers($employees, $employeeId)
    {
        $managers = [];
        $employeeName = null;

        foreach ($employees as $employee) {
            if ($employee['id'] == $employeeId) {
                $employeeName = $employee['name'];
                $managerId = $employee['manager_id'];
                foreach ($employees as $manager) {
                    if ($manager['id'] == $managerId) {
                        $managers[] = $manager;
                    }
                }
            }
        }

        return $managers;
    }
}
