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

    <script>
        /** Function Render Datatables */
        function renderDatatable($tableData) {
            /** เริ่มต้นสร้าง DataTable() */
            $('#table').DataTable({
                data: $tableData, // ใส่ค่าข้อมูล array ที่ได้จัดเตรียมไว้
                initComplete: function () {
                    /** คลิกเพื่อลบข้อมูล */
                    $(document).on('click', '#deleteItem', function(){ 
                        Swal.fire({
                            text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'ใช่! ลบเลย',
                            cancelButtonText: 'ยกเลิก'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                /** สร้าง Ajax เพื่อยิง Request ด้วย Method DELETE สำหรับเปลี่ยนแปลงข้อมูล */ 
                                $.ajax({  
                                    type: "DELETE",  
                                    url: "../service/category/delete.php",  
                                    data: { cat_id: $(this).data('id') }
                                }).done(function(response, textStatus, jqXHR){
                                    Swal.fire({
                                        text: 'รายการของคุณถูกลบเรียบร้อย',
                                        icon: 'success',
                                        confirmButtonText: 'ตกลง',
                                    }).then((result) => {
                                        location.reload()
                                    })
                                })
                            }
                        })
                    })
                },
                columns: [
                    { title: "ลำดับ" , className: "align-middle", width: "40px"},
                    { title: "ชื่อประเภท" , className: "align-middle"},
                    { title: "คำอธิบาย" , className: "align-middle"},
                    { title: "เปลี่ยนแปลงล่าสุด", className: "align-middle"},
                    { title: "จัดการ", className: "align-middle", width: "105px"}
                ],
                language: {
                    "lengthMenu": "แสดงข้อมูล _MENU_ แถว",
                    "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
                    "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                    "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
                    "infoFiltered": "",
                    "search": 'ค้นหา',
                    "paginate": {
                        "previous": "ก่อนหน้านี้",
                        "next": "หน้าต่อไป"
                    }
                }
            })
        }

        $(function() {
            /** เริ่มต้นดึงข้อมูลหน้าเว็บไซต์ */
            /** สร้าง Ajax เพื่อยิง Request ด้วย Method GET สำหรับบันทึกข้อมูล */
            $.ajax({
                type: "GET",
                url: "../service/category/index.php"
            }).done(function(resp, textStatus, jqXHR){
                let arr1 = resp.response,
                tableData = []

              //console.log(arr1)
                
                //console.log(cat_title)
                /** จัดข้อมูล Response ใหม่ ให้พร้อมใช้งาน */
                arr1.forEach(function (item, index){
                    
                    // let result = item.cat_id.slice(10, -10);

                    // var cat_id = b64DecodeUnicode(result)

                    var cat_name = item.cat_name
                    var cat_title = item.cat_title
                    var updated_at = item.updated_at
                   
                  
                    tableData.push([    
                        `${index + 1}`,
                        `<span>${cat_name}</span>`,
                        `<span>${cat_title}</span>`,
                        `<span>${updated_at}</span>`,
                        `<div class="btn-group" role="group">
                            <a href="edit.html?id=${item.cat_id}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> แก้ไข </a>
                            <button class="btn btn-danger btn-sm" id="deleteItem" data-id="${item.cat_id}"><i class="fas fa-trash-alt"></i> ลบ </button>
                        </div>`
                    ])
                })
                /** render Datatable */
                renderDatatable(tableData);
            }).fail(function(jqXHR, textStatus, errorThrown){
                Swal.fire({ 
                    text: jqXHR.responseJSON.message, 
                    icon: 'error', 
                    confirmButtonText: 'ตกลง', 
                }).then(function() {
                    location.assign('./')
                })
            })
        })


    </script>

   <script>
    function b64DecodeUnicode(str) {
    // Going backwards: from bytestream, to percent-encoding, to original string.
    return decodeURIComponent(atob(str).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
}
   </script>
</body>
</html>