
$(function() {
    /** Function on Submit Form */
    $('#formData').on('submit', function (e) {
        e.preventDefault()
        /** สร้าง Ajax เพื่อยิง Request ด้วย Method POST สำหรับบันทึกข้อมูล */
        $.ajax({
            type: 'POST',
            url: '../service/category/create.php',
            data: $(this).serialize() //ดึงข้อมูลจาก form มาใช้งานด้วย serialize
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
