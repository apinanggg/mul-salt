
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

function b64DecodeUnicode(str) {
    // Going backwards: from bytestream, to percent-encoding, to original string.
    return decodeURIComponent(atob(str).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
}


