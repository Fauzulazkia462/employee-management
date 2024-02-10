<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Employee Management</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- datatable -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
        </style>
    </head>
    <body>
        <h1>Employee Management</h1>

        <!-- Form for creating a new employee -->
        <form action="/employees" method="post">
            @csrf
            <input type="text" name="id" placeholder="Employee ID" required>
            <input type="text" name="name" placeholder="Employee Name" required>
            <input type="text" name="manager_id" placeholder="Manager ID">
            <button type="submit">Create Employee</button>
        </form>

        <!-- Form for getting employee hierarchy -->
        <form action="/employee/search" method="post"> 
            @csrf
            <input type="text" name="id" placeholder="Employee ID for Hierarchy" required>
            <button type="submit">Get Employee Hierarchy</button>
        </form>
        <hr>
        
        <table id="table1">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Manager Id</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                    <tr>
                        
                        <td>{{ $d['id'] }}</td>
                        <td>{{ $d['name'] }}</td>
                        <td>{{ $d['manager_id'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        
        <!-- jquery -->
        <script src="{{ asset('vendors/jquery/jquery-3.4.1.js') }}"></script>

        <!-- datatable -->
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/date-1.1.2/r-2.3.0/datatables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#table1').DataTable({
                    order: [],
                    // scrollX:false,    
                });
            });
        </script>
    </body>
</html>
