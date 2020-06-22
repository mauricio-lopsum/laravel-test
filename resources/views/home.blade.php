<?php
    $emp = DB::select('select * from employees');
    $employees = [];
    foreach($emp as $_emp){
        $_emp = (array) $_emp;
        $_emp['name'] = $_emp['first_name'].' '.$_emp['last_name'];
        $_emp['company'] = DB::select('select * from company where id=?', [$_emp['company_id']])[0];
        $employees[] = $_emp;
    }
    $companies = DB::select('select * from company');

    $view = isset($view) ? $view : 'home';

?>  

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dashboard</title>

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
                    <?php if($view == "home" || $view == "companies"):?>
                        <div class="table-container">
                            <h2>Companies <small>(<?= count($companies);?>)</small> <a href="/new/company"><button type="button" class="btn btn-outline-primary">Add new</button></a></h2>
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th></th>
                                            <th>Name</th>
                                            <th>E-mail</th>
                                            <th>Phone number</th>
                                            <th>Website</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($companies as $emp):
                                            $c = Storage::disk('local')->url($emp->logo);
                                        ?>
                                            <tr>
                                                <td><?= $emp->id;?></td>
                                                <td><img src={{$c}}  style="max-width: 30px; display: block;"/></td>
                                                <td><?= $emp->name;?></td>
                                                <td><a href="mailto:<?= $emp->email;?>"> <?= $emp->email;?> </a></td>
                                                <td><a href="tel:<?= $emp->phone;?>"> <?= $emp->phone;?> </a></td>
                                                <td><a href="<?= $emp->website;?>"> <?= $emp->website;?> </a></td>
                                                <td>
                                                    <a href="/company/{{$emp->id}}">View/Edit</a>
                                                    <a href="delete/company/{{$emp->id}}" style="color: red; margin-left: 2rem">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif;?>
                        <?php if($view == "home" || $view == "employees"):?>
                        <div class="table-container">
                        <h2>Employees <small>(<?= count($employees);?>)</small> <a href="new/employee"><button type="button" class="btn btn-outline-primary">Add new</button></a></h2>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Company</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>E-mail</th>
                                        <th>Phone number</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($employees as $emp):?>
                                        <tr>
                                            <td><?= $emp['id'];?></td>
                                            <td><?= $emp['company']->name;?></td>
                                            <td><?= $emp['name'];?></td>
                                            <td><?= $emp['position'];?></td>
                                            <td><a href="<?= $emp['email'];?>"> <?= $emp['email'];?> </a></td>
                                            <td><a href="tel:<?= $emp['phone'];?>"> <?= $emp['phone'];?> </a></td>
                                            <td>
                                                <a href="/employee/{{$emp['id']}}">View/Edit</a>
                                                <a href="delete/employee/{{$emp['id']}}" style="color: red; margin-left: 2rem">Delete</a>

                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                                    <?php endif;?>
                    </main>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>
