<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Card</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        .main {
            width: 346px;
            height: 214px;
            margin: auto;
            margin-bottom: 30px;
            position: relative;
        }

        .background-image {
            width: 345px;
            height: 212px;
            border-radius: 6px;
            border: 1px solid gray;
            position: absolute;
        }

        .main-data {
            width: 345px;
            height: 212px;
            position: absolute;
        }

        .right-div,
        .left-div {
            position: absolute;
            width: 172px;
            height: 212px;
        }

        .left-div {
            left: 0;
        }

        .right-div {
            right: 0;
            padding-left: 50px;
        }

        .logo {
            position: absolute;
            margin: 25px 0 0 18px;
        }

        .info {
            position: absolute;
            padding: 0 12px;
            height: 120px;
            margin-top: 70px;
        }

        .capitalize {
            text-transform: capitalize;
        }

        .register-hr {
            border-bottom: 1px solid black;
            width: 80px;
            margin: 10px 0;
        }

        .back-div {
            padding: 10px;
            position: absolute;
            height: 194px;
            margin-left: 120px;
            width: 208px;
        }

        .contact-info {
            display: block;
            margin-bottom: 8px;
        }

        .contact-icon {
            display: inline-block;
            padding: 6px;
            vertical-align: top;
        }

        .contact-text {
            display: inline-block;
            background: #e2e8f0;
            width: 150px;
            font-size: 10px;
            padding: 9px 5px;
            vertical-align: top;
        }

        .contact-text-sm {
            padding: 3px 5px;
        }

        .flex {
            display: flex;
            align-items: center;
            margin-top: 15px;
        }

        .flex img {
            width: 15px;
            margin-right: 8px;
        }

        .mx-auto {
            margin: 10px auto;
        }

        .qr-code {
            width: 100px;
            height: 100px;
            display: block;
            margin: auto;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            .printable, .printable * {
                visibility: visible;
            }
            .printable {
                position: absolute;
                left: 0;
                top: 0;
                width: 346px;
                height: 214px;
            }
            @page {
                margin: 0;
            }
        }
    </style>
</head>

<body>

    <div class="printable" id="page1">
        <div class="main">
            <img class="background-image" src="{{ asset('images/back.jpg') }}" alt="">
            <div class="main-data">
                <div class="left-div">
                    <img class="logo" src="{{ asset('images/uotlogo.png') }}" width="110" alt="">
                    <div class="info">
                    </div>
                </div>
                <div class="right-div">
                    <img style="height: 80px; margin-left: 15px; margin-top: 25px;" src="{{ asset('images/' . $student->image) }}" alt="" width="75">
                    <img class="mx-auto" src="{{ asset('images/sign.png') }}" alt="" width="45">
                    <div class="register-hr"></div>
                    <span class="capitalize">{{ $student->name }}</span><br>
                    <span class="text-md">ID: {{ $student->student_number }}</span><br>
                </div>
            </div>
        </div>
    </div>

    <div class="printable" id="page2">
        <div class="main">
            <img class="background-image" src="{{ asset('images/Back.jpg') }}" alt="">
            <div class="main-data">
                <div class="back-div">
                    <p style="font-size: 11px; line-height: 50%;">If found please return to the Register's Office.</p>
                    <p style="color: blue; line-height: 40%;">جامعة طرابلس</p>
                    <div>
                        <img class="qr-code" src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $student->student_number }}" alt="QR Code">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button onclick="printDiv('page1')">Print Page 1</button>
    <button onclick="printDiv('page2')">Print Page 2</button>

    <script>
       function printDiv(divId) {
            // إخفاء كل العناصر الأخرى
            var allElements = document.body.children;
            for (var i = 0; i < allElements.length; i++) {
                if (allElements[i].id !== divId) {
                    allElements[i].style.display = 'none';
                }
            }

            // طباعة العنصر المطلوب
            window.print();

            // استعادة العرض الأصلي للعناصر
            for (var i = 0; i < allElements.length; i++) {
                allElements[i].style.display = '';
            }
        }
    </script>
</body>

</html>
