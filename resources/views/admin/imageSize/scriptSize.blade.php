<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // คัดเลือกเลือกบรรทัด
        var select = $('select[name="id_image_type"]');

        // กำหนดการแสดงหรือซ่อนเมื่อเลือกอย่างใดอย่างหนึ่ง
        select.change(function() {
            if (select.val() == '2') {
                $('#numberDiv').show(); // แสดง div ถ้าค่าเลือกคือ 'ภาพเหมือน'
            } else {
                $('#numberDiv').hide(); // ซ่อน div ในกรณีอื่น ๆ
            }
        });

        // ตรวจสอบค่าเริ่มต้นเพื่อแสดงหรือซ่อน
        if (select.val() == '2') {
            $('#numberDiv').show(); // แสดง div หากค่าเริ่มต้นเป็น 'ภาพเหมือน'
        } else {
            $('#numberDiv').hide(); // ซ่อน div หากค่าเริ่มต้นไม่ใช่ 'ภาพเหมือน'
        }
    });
</script>
