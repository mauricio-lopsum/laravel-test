<?php
    $employee = DB::select('select * from employees where id=(?)', [$id])[0];
    $companiesDb = DB::select('select * from company');
    $companies = [];
    foreach($companiesDb as $c){
        $companies[$c->id] = $c->name;
    }
?>  

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>View/Edit {{$employee->first_name}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            #wrapper{
                width: 100%;
                height: 100%;
                position: absolute;
                top: 0;
                left: 0;
            }

            #sidebarMenu{
                height: 100vh;
                overflow-y: auto;
            }

            .table-container{
                margin: 2rem 0;
            }


        </style>
    </head>
    <body>
        <div id="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                        <div class="sidebar-sticky pt-3">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link active" href="/">
                                    <span data-feather="home"></span>
                                        Dashboard <span class="sr-only">(current)</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="/employees">
                                    <span data-feather="employees"></span>
                                        Employees
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="/companies">
                                    <span data-feather="companies"></span>
                                        Companies
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                        <div class="table-container">
                            <h2>{{$employee->first_name}}</h2>
                            <hr />
                            <h3>Edit employee</h3>

                            {{Form::open (array ('action' => 'DataController@editemployee', 'enctype' => 'multipart/form-data'))}}
                                <p> {{Form::text ('first_name', $employee->first_name, array ('placeholder'=>'First name','maxlength'=>300))}} </p>
                                <p> {{Form::text ('last_name', $employee->last_name, array ('placeholder'=>'Last name','maxlength'=>300))}} </p>
                                <p> {{Form::text ('position', $employee->position, array ('placeholder'=>'Position','maxlength'=>300))}} </p>
                                <p>
                                    <label>Company</label>
                                    {{Form::select('company_id', $companies, $employee->company_id)}}
                                </p>
                                <p> {{Form::text ('email', $employee->email, array ('placeholder'=>'Email','maxlength'=>300))}} </p>
                                <p> {{Form::text ('phone', $employee->phone, array ('placeholder'=>'Phone','maxlength'=>300))}} </p>
                                <input type="hidden" name="id" value="{{$id}}"/>
                                <p> {{Form::submit ('Submit')}} </p>
                            {{Form::close ()}}
                            
                        </div>
                    </main>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>
