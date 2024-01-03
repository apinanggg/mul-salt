<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datatables AppzStory</title>
    <link rel="shortcut icon" type="image/x-icon" href="../icon.ico">
    <!-- bootstrap 5 -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" >
    <!-- dataTables.bootstrap5 -->
    <link rel="stylesheet" href="../node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <!-- responsive.dataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <!-- sweetalert2 -->
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
        .dataTables_scrollHeadInner, .table{
            width:100% !important
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 pt-4">
                        <h4> 
                            <i class="fas fa-shopping-cart"></i> 
                            ประเภทสินค้า
                        </h4>
                    </div>
                    <div class="card-body">
                        <a href="create.html" class="btn btn-info btn-sm my-2 mx-md-0 px-4" id="createItem">
                            เพิ่มข้อมูล <i class="fas fa-plus"></i>
                        </a>
                        <a href="../" class="btn btn-success btn-sm my-2 mx-md-0 px-4">
                            จัดการสินค้า <i class="fas fa-list-alt"></i>
                        </a>
                        <table id="table" class="table"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery3.6 -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <!-- bootstrap5 -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- jquery.dataTables -->
    <script src="../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <!-- dataTables.bootstrap5 -->
	<script src="../node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <!-- dataTables.responsive -->
    <script src="../node_modules/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <!-- sweetalert2 -->
    <script src="../node_modules/sweetalert2/dist/sweetalert2.all.js"></script>

    <script src="../api/category/index.js"></script>

   

 </body>
</html>