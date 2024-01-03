
/** ประกาศตัวแปร */
let selectedFile,
    products,
    categories,
    tableData
/** Function onFileSelected สำหรับพรีวิวรูปภาพและเก็บข้อมูลในตัวแปรไว้ใช้งาน */
function onFileSelected (input) {
    selectedFile = input.files[0]
    if(selectedFile){
        let reader = new FileReader()
        document.querySelector('#imgControl').classList.replace("d-none", "d-block")
        reader.onload = function (e) {
            let element = document.querySelector('#imgUpload')
            element.setAttribute("src", e.target.result)
        }
        reader.readAsDataURL(selectedFile)
    }
}


/** Function initialData เริ่มต้นดึงข้อมูลหน้าเว็บไซต์ */
function initialData() {
    /** สร้าง Ajax เพื่อยิง Request ด้วย Method GET สำหรับดึงค่าเริ่มต้น */
    $.ajax({
        type: "GET",
        url: "service/product/index.php"
    }).done(function(resp, textStatus, jqXHR){
        products = resp.response.products // เก็บค่า products ที่ได้จาก API สำหรับนำไปใช้งาน
        categories = resp.response.categories // เก็บค่า categories ที่ได้จาก API สำหรับนำไปใช้งาน
        tableData = []
        /** สร้างชุดข้อมูลของคอลัมน์ใหม่ ให้เป็น array เพื่อนำไปใช้กับ Datatables */
        products.forEach(function (item, index){
            tableData.push([    
                `${index + 1}`,
                `<img src="assets/uploads/${item.p_image}" class="img-fluid" width="100px">`,
                `<span>${item.p_name}</span>`,
                `<span>${item.p_title}</span>`,
                `${item.cat_name}`,
                `${Number(item.p_price).toLocaleString()}`,
                `<input class="toggle-event" type="checkbox" name="status" data-id="${item.p_id}"
                        ${item.p_status === 'true' ? 'checked': ''} data-toggle="toggle" data-on="เผยแพร่" data-off="ปิด" 
                        data-onstyle="success" data-style="ios" data-size="sm">`,
                `<div class="btn-group" role="group">
                    <button class="btn btn-info btn-sm" id="showItem" data-id="${item.p_id}"> <i class="fas fa-eye"></i> ดูข้อมูล </button>
                    <button class="btn btn-warning btn-sm" id="editItem" data-id="${item.p_id}"> <i class="fas fa-edit"></i> แก้ไข </button>
                    <button class="btn btn-danger btn-sm" id="deleteItem" data-id="${item.p_id}"> <i class="fas fa-trash-alt"></i> ลบ </button>
                </div>`
            ])
        })

        /** function renderDatatable() เริ่มต้นการสร้าง Datatables */
        renderDatatable(tableData);

        /** render select option */
        categories.forEach(function(item, index){
            $("<option>", {
                value: item.cat_id,
                text: item.cat_name
            }).appendTo($('#categories'));
        })

    }).fail(function(jqXHR, textStatus, errorThrown){
        Swal.fire({ 
            text: jqXHR.responseJSON.message, 
            icon: 'error', 
            confirmButtonText: 'ตกลง', 
        }).then(function() {
            location.assign('./')
        })
    })
}

/** Function Render Datatables */
function renderDatatable($tableData) {
    /** เริ่มต้นสร้าง DataTable() */
    $('#table').DataTable({
        data: $tableData, // ใส่ค่าข้อมูล array ที่ได้จัดเตรียมไว้
        pageLength : 5, // กำหนดจำนวนแถวที่จะแสดงใน table
        lengthMenu: [5, 10, 20, 50], //เปลี่ยนแปลงค่าตัวเลือกที่จะให้แสดงจำนวนแถว
        "columnDefs": [{
                "targets": [1,2,3,6,7], // จำกัดการจัดเรียงข้อมูลในคอลัมน์ จะให้แสดงเฉพาะคอลัมน์ที่กำหนด
                "orderable": false 
            },{ 
                "targets": [1,6,7], //จำกัดการค้นหาข้อมูลในช่องค้นหา จะค้นหาได้เฉพาะคอลัมน์ที่กำหนด
                "searchable": false 
            }
        ],
        initComplete: function () {
            /** คลิกเพื่อลบข้อมูล */
            $(document).on('click', '#deleteItem', function(){ 
                /** ใช้งาน Sweet Alert ตรวจสอบว่าต้องการทำรายการนี้หรือไม่ */
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
                            url: "service/product/delete.php",  
                            data: { id: $(this).data('id') } // กำหนดค่าข้อมูลที่ส่ง
                        }).done(function(resp, textStatus, jqXHR){
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
            /** แก้ไขข้อมูลผ่าน Modal Form Update (Form เดิมที่ใช้ Create) */
            .on('click', '#editItem', function(){
                /** เรียกใช้งาน Modal */
                new bootstrap.Modal($('#formModal'), {
                    keyboard: false
                }).show()
                /** ตั้งค่าเริ่มต้นของข้อมูล hidden */
                $("#formData [name=p_id]").remove()
                $("#formData [name=p_image]").remove()
                /** ค้นหาข้อมูลจาก id ที่คลิกเข้ามา */
                let product = products.filter((data) => data.p_id == $(this).data('id'))[0]
                /** นำค่าที่ได้เข้าไปใส่ไว้ใน input แต่ละตัว */
                $('#p_name').val(product.p_name)
                $('#p_title').val(product.p_title)
                $('#p_price').val(product.p_price)
                $('#p_detail').val(product.p_detail)  
                /** เรียกใช้งงาน bootstrapToggle และตั้งค่า status ปัจจุบัน */
                $('.toggle-edit').bootstrapToggle()
                $('#formData [name=p_status]').bootstrapToggle(product.p_status == 'true'? 'on' : 'off' , true).data('id', product.p_id);
                /** selected ในส่วนของ select option จากค่าข้อมูล */
                $(`#formData option[value=${product.cat_id}]`).prop("selected", true)
                /** เปิดปิด การแสดงผลรูปภาพ */
                $('#imgControl').removeClass('d-none').addClass('d-block')
                /** แสดงผลรูปภาพออกทางหน้าจอ */
                $('#imgUpload').attr("src", `assets/uploads/${product.p_image}`)
                /** ตั้งค่า input hidden สำหรับซ่อนค่าที่เราต้องการเอาไว้ */
                $('<input>').attr({
                    type: 'hidden',
                    name: 'p_image',
                    value: product.p_image
                }).appendTo('#formData .modal-body .row')
                $('<input>').attr({
                    type: 'hidden',
                    name: 'p_id',
                    value: product.p_id
                }).appendTo('#formData .modal-body .row')
            })
            /** แสดงข้อมูลผ่าน Modal Show Data */
            .on('click', '#showItem', function(){
                /** เรียกใช้งาน Modal */
                new bootstrap.Modal($('#showModal'), {
                    keyboard: false
                }).show()
                /** ตั้งค่าเริ่มต้น body ให้เป็นค่าว่าง */
                $('#showModal .modal-body').html('')
                /** ค้นหาข้อมูลจาก id ที่คลิกเข้ามา */
                // console.log(products)
                let product = products.filter((data) => data.p_id == $(this).data('id'))[0]
                /** แสดงผล HTML ตามค่าที่กำหนด ไว้ใน Modal */
                $(`<section class="card card-hover">
                    <img src="assets/uploads/${product.p_image}" alt="AppzStory" class="card-img-top" >
                    <div class="card-body">
                        <h5 class="card-title fw-bold">
                            ${product.p_name}
                        </h5> 
                        <p>${product.p_title}</p>
                        <p><span class="fw-bold">ประเภท:</span> ${product.cat_name}</p>
                        <p><span class="fw-bold">ราคา:</span> ${product.p_price}</p> 
                        <p><span class="fw-bold">รายละเอียด:</span> ${product.p_detail}</p> 
                    </div>
                </section>`).appendTo('#showModal .modal-body')
            })
            /** Toggle Switch กดปุ่มเปิดปิด */
            .on('change', '.toggle-event', function(){
                /** สร้าง Ajax เพื่อยิง Request ด้วย Method POST สำหรับเปลี่ยนแปลงข้อมูล */
                $.ajax({  
                    type: "POST",  
                    url: "service/product/active.php",  
                    data: { 
                        id: $(this).data('id'), // ดึงค่า id จากการ data attribute
                        value: $(this).is(':checked') // ดึงค่า checked จาก toggle switch
                    }
                }).done(function(resp, textStatus, jqXHR){ // จะเข้าเมื่อ Response กลับมาด้วย status 2xx
                    /**  การใช้งาน Sweet Alert กรณีทำสำเร็จ */
                    Swal.fire({
                        text: resp.message,
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                    })
                }).fail(function(jqXHR, textStatus, errorThrown){ // จะเข้าเมื่อ Response กลับมาด้วย status 4xx, 5xx
                    /**  การใช้งาน Sweet Alert กรณีไม่สำเร็จ */
                    Swal.fire({ 
                        text: jqXHR.responseJSON.message, 
                        icon: 'error', 
                        confirmButtonText: 'ตกลง', 
                    })
                })
            })
        },
        fnDrawCallback: function() {
            /** เรียกใช้งาน bootstrapToggle เมื่อมีการเปลี่ยนหน้าใหม่ */
            $('.toggle-event').bootstrapToggle()
        },
        /** กำหนดชื่อคอลัมน์ทั้งหมด */
        columns: [
            { title: "ลำดับ" , className: "align-middle", width: "40px"},
            { title: "รูปภาพ" , className: "align-middle"},
            { title: "ชื่อสินค้า" , className: "align-middle"},
            { title: "คำอธิบาย" , className: "align-middle"},
            { title: "ประเภท" , className: "align-middle"},
            { title: "ราคา", className: "align-middle"},
            { title: "สถานะ", className: "align-middle"},
            { title: "จัดการ", className: "align-middle", width: "210px"}
        ],
        /** กำหนดให้ Datatables รองรับมือถือ (Responsive) ในรูปแบบของการคลิกปุ่มเปิดปิด */
        responsive: {
            details: {
                renderer: function ( api, rowIdx, columns ) {
                    var data = $.map( columns, function ( col, i ) {
                        /** ปิดการแสดงผลคอลัมน์สถานะในหน้าจอมือถือ */
                        return col.hidden && col.title != 'สถานะ' ?
                            `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                                <td>${col.title}: </td>
                                <td>${col.data} </td>
                            </tr>` :
                            ''
                    } ).join('')
                    return data ? $('<table/>').append( data ) : false
                }
            }
        },
        /** ตั้งค่าให้แสดงผลภาษาไทยใน Datatatables */
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
    /** เคลียร์ค่าเริ่มต้น และใช้งาน Modal From Create */
    $('#createItem').on('click', function (e) {
        e.preventDefault()
        /** ตรวจสอบว่าประเภทสินค้า มีค่าตัวเลือกหรือไม่ */
        if(!categories.length){
            Swal.fire({icon: 'error',text: 'จำเป็นต้องสร้างประเภทสินค้าก่อน',})
            return // return คือวิธีการออกจาก Function ไม่ต้องทำงานต่อ
        }
        /** สร้าง Modal สำหรับแสดง Form Create */
        new bootstrap.Modal($('#formModal'), {
            keyboard: false
        }).show()
        /** เคลียร์ข้อมูลให้เป็นค่าว่างใน Form Modal */
        $("#formData").trigger("reset")
        /** ลบ input id กับ image ที่ใช้สำหรับการ Update */
        $("#formData [name=p_id]").remove()
        $("#formData [name=p_image]").remove()
        /** เปลี่ยนการแสดงผล Preview Image Upload ให้เป็นค่าเริ่มต้น */
        $('#imgControl').removeClass('d-block').addClass('d-none')
        $('#imgUpload').attr("src", '')
    })

    
    /** Function on Submit Form */
    $('#formData').on('submit', function (e) {
        e.preventDefault()
        /** สร้าง Api Endpoint ปลายทางที่จะส่งไป */
        let endpoint = 'create.php',
        /** สร้าง object formData ไว้เก็บข้อมูล */
        formData = new FormData(),
        /** เก็บข้อมูลจาก form ทั้งหมดไว้ในตัวแปรในรูปแบบ Array */
        serialize = $('#formData').serializeArray()
        /** loop ข้อมูลใส่ไว้ใน formData */
        serialize.forEach( function (item, index) {
            formData.append(item.name, item.value)
        })
        /** นำข้อมูลการ Upload Image ใส่ในใน formData */
        formData.append('file',selectedFile)
        /** เช็คว่ามี id แนบมาใน form หรือไม่เพื่อตั้งค่า endpoint */
        if($('#formData [name=p_id]').val()){
            endpoint = 'update.php'
        }
        /** สร้าง Ajax เพื่อยิง Request ด้วย Method POST สำหรับบันทึกข้อมูล */
        $.ajax({
            type: 'POST',
            url: `service/product/${endpoint}`,
            data: formData, // กำหนดค่า formData ที่จะถูกส่งออกไป
            processData: false, // กำหนดเป็น false เพื่อให้สามารถส่งแบบไม่ต้องประมวลผลใดๆ
            contentType: false // กำหนดเป็น false เพื่อไม่ให้ตั้งค่า content header ใดๆ
        }).done(function(resp, textStatus, jqXHR){ // จะเข้าเมื่อ Response กลับมาด้วย status 2xx
            /** การใช้งาน Sweet Alert กรณีทำสำเร็จ */
            Swal.fire({
                text: resp.message,
                icon: 'success',
                confirmButtonText: 'ตกลง',
            }).then(() => {
                location.assign('./')
            })
        }).fail(function(jqXHR, textStatus, errorThrown){ // จะเข้าเมื่อ Response กลับมาด้วย status 4xx, 5xx
            /**  การใช้งาน Sweet Alert กรณีไม่สำเร็จ */
            Swal.fire({ 
                text: jqXHR.responseJSON.message, 
                icon: 'error', 
                confirmButtonText: 'ตกลง', 
            })
        })
    })

    /** เริ่มต้นดึงข้อมูลหน้าเว็บไซต์ */
    initialData()
})
