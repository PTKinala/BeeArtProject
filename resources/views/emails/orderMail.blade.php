<!DOCTYPE html>
<html>

<head>
    <title>beeartgallery.com</title>
</head>

<body>
    <h1>{{ $mailData['title'] }}</h1>
    <p>{{ $mailData['body'] }}</p>
    <p>{{ $mailData['content'][1] }}</p>
    <p>ขนาดของภาพ {{ '  ' }}{{ $mailData['content'][2] }}</p>
    <p>กระดาษ {{ '  ' }}{{ $mailData['content'][3] }}</p>
    <p>สี {{ '  ' }}{{ $mailData['content'][4] }}</p>
    <p>จำนวนคน(เฉพาะภาพเหมือน) {{ '  ' }}{{ $mailData['content'][5] }}</p>
    <p>รายละเอียดเพิ่มเติม {{ '  ' }}{{ $mailData['content'][6] }}</p>
    <p> ชื่อ{{ '  ' }}{{ $mailData['content'][7] }}{{ '  ' }} {{ $mailData['content'][8] }}</p>
    <p>เบอร์ติดต่อ {{ '  ' }} {{ $mailData['content'][9] }}</p>
    <a href="https://beeartgallery.com">เข้าสู้เว็บไชต์ beeartgallery.com</a>
    <p>Thank you</p>
</body>

</html>
