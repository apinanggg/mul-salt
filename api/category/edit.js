
$(function() {
    /** ดึงค่า params id มาใช้งานเพื่อหาข้อมูล */
    let params = new URL(location.href).searchParams.get("id")

    // console.log(params)

    // let result = params.slice(10, -10);

    // var cat_id = b64DecodeUnicode(result)

    /** สร้าง Ajax เพื่อยิง Request ด้วย Method GET สำหรับดึงข้อมูล */
    $.ajax({
        type: "GET",
        url: "../service/category/show.php",
        data: { id: params }, // กำหนดค่า id ที่จะถูกส่งออกไปค้นหา
        cache: true // ตั้งค่าแคชข้อมูลเมื่อมีการเรียกใช้งาน
    }).done(function(resp, textStatus, jqXHR){ // เมื่อสำเร็จกำหนดค่าแสดงผลใน input
        let category = resp.response
        $('#cat_name').val(category.cat_name)
        $('#cat_title').val(category.cat_title)
    }).fail(function(jqXHR, textStatus, errorThrown){ // เมื่อไม่สำเร็จแสดง กล่อง Sweet Alert ขึ้นมา
        Swal.fire({ 
            text: jqXHR.responseJSON.message, 
            icon: 'error', 
            confirmButtonText: 'ตกลง', 
        }).then(function() {
            location.assign('./')
        }) 
    })

    
    /** Function on Submit Form */
    $('#formData').on('submit', function (e) {
        e.preventDefault()
        /** ดึงค่าจาก form มาใช้งานด้วย serialize */
        let serialize = $(this).serialize()
        $.ajax({
            type: 'PUT',
            url: '../service/category/update.php',
            data:`${serialize}&cat_id=${params}` //กำหนดค่าข้อมูลพร้อมแนบ id ต่อท้าย params
        }).done(function(resp, textStatus, jqXHR){ // เมื่อสำเร็จแสดง Sweet Alert Success ขึ้นมา
            Swal.fire({
                text: resp.message,
                icon: 'success',
                confirmButtonText: 'ตกลง',
            }).then(() => {
                location.assign('./')
            })
        }).fail(function(jqXHR, textStatus, errorThrown){ // เมื่อไม่สำเร็จแสดง Sweet Alert Error ขึ้นมา
            Swal.fire({ 
                text: jqXHR.responseJSON.message, 
                icon: 'error', 
                confirmButtonText: 'ตกลง', 
            })
        })
    })
})
   

function b64DecodeUnicode(str) {
// Going backwards: from bytestream, to percent-encoding, to original string.
return decodeURIComponent(atob(str).split('').map(function(c) {
return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
}).join(''));
}


